<?php

use App\System\Constants;

abstract class BaseController implements Constants 
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    protected function parse($request, $response) 
    {
        $this->request = Request::parse($request);
        $this->response = Response::create($response);
    }
}