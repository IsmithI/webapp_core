<?php

namespace app\collection;

use JsonSerializable;

class Collection implements \IteratorAggregate, JsonSerializable {

	protected $items = [];

	public function __construct(array $items = []) {
		$this->items = $items;
	}

	public function get($key = null) {
		
		if (!is_null($key))
			if (array_key_exists($key, $this->items))
				return $this->items[$key];
			else
				return null;

		return $this->items;
	}

	public function count() {
		return count($this->get());
	}

	public function getIterator() {
		return new \ArrayIterator($this->items);
	}

	public function merge(Collection $collection) {
		return $this->add($collection->get());
	}

	public function add(array $items) {
		$this->items = array_merge($this->items, $items);
	}

	public function push($item) {
		$this->items[] = $item;
	}

	public function toJson() {
		return json_encode($this->items);
	}

	public function sort(\Closure $comparator) {
		usort($this->items, $comparator);
		return $this;
	}

	public function filter(\Closure $comparator) {
		$filtered = [];
		foreach ($this->items as $key => $item) {
			if ($comparator($item, $key)) $filtered[] = $item;
		}

		return new Collection($filtered);
	}

	public function pop() {
	    if ($this->isEmpty()) return null;

	    return $this->items[$this->count()-1];
    }

    public function isEmpty() {
	    return $this->count() == 0;
    }

    public function find(\Closure $comparator) {
        $records = $this->filter($comparator);
        return $records->pop();
    }

    public function map(\Closure $closure) {
	    $result = new Collection();
	    foreach ($this->items as $key => $item) $result->push($closure($item, $key));
	    return $result;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return $this->items;
    }
}