<?php

use Slim\App as Slim;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class App {

    public function __construct() 
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function run()
    {
        $settings = [
            'settings'  => ['displayErrorDetails' => Config::DISPLAY_ERROR ]
        ];

        $container = new Container($settings);
        $container['notFoundHandler'] = function($c) {
            return function(Request $request, Response $response) use($c) {
                $appResponse = \Response::create($response);
                return $appResponse->error("page not found");
            };
        };

        $slim = new Slim($container);

        $router = new \Router();
        $router->route($slim);

        // Cors Setup
        $slim->add(new Cors());

        $slim->run();
    }
}