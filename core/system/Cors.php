<?php

use Slim\Http\Request;
use Slim\Http\Response;

class Cors
{

    public function __invoke(Request $request, Response $response, $next)
    {
        $result = $next($request, $response);

        /** @noinspection PhpUndefinedMethodInspection */
        return $result->withHeader('Access-Controll-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Authorization')
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
