<?php

$this->get('', AuthController::class . ":login");

class AuthController extends BaseController
{
    function login($request, $response)
    {
        $this->parse($request, $response);

        $token = Tokenizer::generate(1);

        return $this->response->success($token);
    }
}