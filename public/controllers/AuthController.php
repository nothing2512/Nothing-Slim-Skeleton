<?php

$this->post('', AuthController::class . ":login");

class AuthController extends BaseController
{
    function login($request, $response)
    {
        $this->parse($request, $response);

        $valid = $this->request->validate([
            "name"  => "required|min:3|max:10|text|not_special"
        ]);

        if ($valid->status == false) return $this->response->error($valid->message);

        $this->request->uploads([ "photo" => "photo" ]);

        return $this->response->success($this->request);
    }
}