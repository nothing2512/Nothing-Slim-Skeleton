<?php

use App\Models\Test;

$this->get('/', TestController::class . ":test");

class TestController extends BaseController
{
    public function __construct()
    {
        $this->test = new Test();
    }

    public function test($request, $response) 
    {
        $this->parse($request, $response);

        $data = $this->test->test();

        return $this->response->success($this->request);
    }
}