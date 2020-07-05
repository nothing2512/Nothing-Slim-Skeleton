<?php

use Slim\Http\Response as HttpResponse;

class Response {

    /**
     * @var HttpResponse
     */
    private $response;

    private function __construct($response)
    {
        $this->response = $response;
    }

    public function successMessage($message)
    {
        return $this->response
            ->withStatus(200)
            ->write(json_encode([
                'status'    => true,
                'message'   => $message,
                'data'      => null
            ]));
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

    public function forbidden()
    {
        return $this->error("Forbidden access");
    }

    public function illegal()
    {
        return $this->error("Illegal access");
    }

    public static function create(HttpResponse $response) 
    {
        return new Response($response->withHeader('Content-Type', 'application/json'));
    }
}