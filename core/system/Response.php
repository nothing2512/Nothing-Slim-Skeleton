<?php

use Slim\Http\Response as HttpResponse;

class Response {

    private $response;

    private function __construct($response)
    {
        $this->response = $response;
    }

    public function success($data)
    {
        return $this->response
            ->withStatus(200)
            ->write(json_encode([
                'status'    => true,
                'message'   => '',
                'data'      => $data
            ]));
    }

    public function error($message) {
        return $this->response
            ->withStatus(404)
            ->write(json_encode([
                'status'    => false,
                'message'   => $message,
                'data'      => null
            ]));
    }

    public static function create(HttpResponse $response) 
    {
        return new Response($response->withHeader('Content-Type', 'application/json'));
    }
}