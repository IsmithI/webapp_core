<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 16.12.18
 * Time: 11:36
 */

namespace Core\sockets;


use Core\collection\Collection;
use Core\loader\SocketsLoader;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class SocketServer implements MessageComponentInterface
{
    private static $instance = null;

    /**
     * @var \SplObjectStorage $clients
     */
    private $clients;


    /**
     * @var Collection $components
     */
    private $components;

    public static function init() {
        if (self::$instance == null) self::$instance = new SocketServer();

        echo "Initialized SocketsServer\n";
        self::$instance->start();
    }

    private function __construct() {
        $this->clients = new \SplObjectStorage();
        $this->components = new Collection();
    }

    public function start() {
        $loader = new SocketsLoader();
        $loader->load( function (MessageComponentInterface $component) {
            print_r("Registered new component: " . get_class($component) . "\n");
            $this->components->push($component);
        });

        $server = IoServer::factory(
            new HttpServer(
                new WsServer($this)
            ),
            4444
        );
        $server->run();
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        $this->components->each( function (MessageComponentInterface $component) use ($conn) {
            $component->onOpen($conn);
        });
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        $this->components->each( function (MessageComponentInterface $component) use ($conn) {
            $component->onClose($conn);
        });
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->components->each( function (MessageComponentInterface $component) use ($conn, $e) {
            $component->onError($conn, $e);
        });

        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $this->components->each( function (MessageComponentInterface $component) use ($from, $msg) {
            $response = $component->onMessage($from, $msg);

            foreach ($this->clients as $client) $client->send($response);
        });
    }
}