<?php

use Slim\App;

class Router
{
    public function __construct()
    {
        $this->path = str_replace("core\\system", "public\\controllers\\", __DIR__);
    }


    public function route(App $app, $files = null, $i = 0)
    {

        if ($files == null) {

            $controllers = scandir($this->path);
            array_splice($controllers, 0, 2);

            if (sizeof($controllers) == 0) return $app;

            return $this->route($app, $controllers);
        }

        $_SESSION['path'] = $this->path . $files[$i];

        $exploder = explode(".", $files[$i]);
        $controller = strtolower($exploder[0]);

        $app->group('/' . str_replace("controller", "", $controller), function () {

            // Get path
            $path = $_SESSION['path'];

            // Requiring Controller
            if (file_exists($path))
                /** @noinspection PhpIncludeInspection */
                require_once($path);
        });

        if ($i < sizeof($files) - 1) return $this->route($app, $files, $i  + 1);

        return $app;
    }
}
