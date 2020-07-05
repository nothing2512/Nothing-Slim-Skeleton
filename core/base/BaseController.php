<?php

use App\Models\Log;
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

    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var Log
     */
    protected $log;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->log = new Log();
        $this->timestamp = date("Y-m-d H:i:s");
    }

    /**
     * @param $message
     * @param null $user
     */
    protected function log($message, $user=null)
    {
        if ($user == null) $user = $this->request->user;

        $this->log->create([
            ":userId"   => $user->userId,
            ":message"  => $message,
            ":created"  => $this->timestamp
        ]);
    }

    /**
     * @param $request
     * @param $response
     */
    protected function parse($request, $response) 
    {
        $this->request = Request::parse($request);
        $this->response = Response::create($response);
    }
}