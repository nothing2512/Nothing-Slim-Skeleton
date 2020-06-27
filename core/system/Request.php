<?php

use Slim\Http\Request as HttpRequest;

class Request
{

    public $auth;
    public $files;

    public function __construct($params, $auth)
    {
        $this->auth = $auth;
        $this->files = (object) [];

        foreach ($params as $key => $value) {
            $this->$key = $value;
        }

        foreach($_FILES as $key => $value) {
            $this->files->$key = new RequestFile($value);
        }
    }

    public static function parse(HttpRequest $request)
    {

        $params = $request->isPost() ?
            (object) $request->getParsedBody() :
            (object) $request->getQueryParams();

        // Get authorization
        $_auth = $request->getHeader('HTTP_AUTHORIZATION');

        // Check and return auth
        if (sizeof($_auth) == 0) {
            $auth = (object) [
                "userId"    => 0,
                "apiKey"     => ""
            ];
        } else {
            $_auth = explode(":", $_auth[0]);

            $auth = sizeof($_auth) == 1 ? (object) [
                "userId"    => 0,
                "apiKey"     => "Invalid",
                "status"    => false
            ] :  (object) [
                "userId"    => $_auth[0],
                "apiKey"    => $_auth[1],
                "status"    => true
            ];
        }



        return new Request($params, $auth);
    }

    public function remove($key)
    {
        unset($this->$key);
    }
}
