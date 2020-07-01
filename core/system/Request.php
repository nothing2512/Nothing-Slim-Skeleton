<?php

use Slim\Http\Request as HttpRequest;

class Request
{

    public $auth;
    public $files;

    public function __construct(Object $params, Object $auth)
    {
        $this->auth = $auth;
        $this->files = (object) [];

        foreach ($params as $key => $value) {
            $this->$key = $value;
        }

        foreach ($_FILES as $key => $value) {
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
                "token"     => ""
            ];
        } else {
            $_auth = explode(":", $_auth[0]);

            $auth = sizeof($_auth) == 1 ? (object) [
                "userId"    => 0,
                "token"     => "Invalid",
                "status"    => false
            ] :  (object) [
                "userId"    => $_auth[0],
                "token"    => $_auth[1],
                "status"    => true
            ];
        }



        return new Request($params, $auth);
    }

    public function uploads($params)
    {
        foreach ($params as $key => $path) {
            $this->files->$key->upload($path);
            $this->$key = $this->files->$key->uri;
        }
    }

    public function validate($params)
    {
        return Validator::validate($this, $params);
    }

    public function remove($key)
    {
        unset($this->$key);
    }
}
