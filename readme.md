# SmithYard

## Overview
A simple web MVC framework for small but very impressive solutions. You'll find common things like controllers, models and views.
* [Klein](https://github.com/klein/klein.php) - routing
* [Medoo](https://github.com/catfan/Medoo) - database client

## Routing
Routing is made via configuration file located at `/app/config.json`. Here's and example:

```json
{
  "router": {
    "web": {
      "Main": [
        { 
          "path": "/?" 
        }
      ],
      "Login": [
        { 
          "path": "/login",
          "method": "POST",
          "name": "login"
        }
      ],
      "Users": [
        {
          "path": "/users",
          "method": ["GET", "POST"],
          "middleware": ["Auth"]
        },
        {
          "path": "/user/[i:id]",
          "method": ["GET", "POST"],
          "name": "get",
          "middleware": ["Auth"]
        }
      ]
    }
  }
}
```
At first you define a controller which will apply your request. 
* Create an object where key is your controller *class name*. 
Controllers are stored in `/app/controller`. Framework will search for a class in this directory. 
* Then, you need specify *path* that will trigger your controller action.
* A *method* key is a filter for incoming requests, you may use array of values like `["POST", "GET"]` or do not add this parameter
to respond to ALL requests.
* *name* is the name of static method in *controller* that will handle your request. By default is `index`.
* *middleware* is an array of classes that implement `app\middleware\Middleware` interface and they handle request before it 
reaches *controller*. Useful when you want to set up authentication and privileges rules.

## Controllers
Controllers are just classes that handle request with static methods. For example:
```PHP
class Users {

	static function index($req, $res) {
		$users = \app\model\Users::all();

		return $res->body($users->toJson());
	}

	static function get($req, $res) {
		$user = \app\model\Users::one(['id' => $req->id]);
		return $res->body($user->toJson());
	}
}
```
In this case we defined 2 methods: `index` and `get`.   
**Index** method returns `app\collection\Collection` of all users nad then we return json data.
**Get** method fetches single user model by id from request and returns json encoded data.


### New docs comming soon ;)