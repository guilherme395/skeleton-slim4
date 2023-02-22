<?php

namespace App\Config\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

# Admin
use App\Middlewares\Admin\AdminAuth;
use App\Controllers\Admin\AdminController;

# User
use App\Middlewares\App\UserAuth;
use App\Controllers\App\HomeController;

class FrontRoutes
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function router()
    {
        $this->app->group("/app", function (RouteCollectorProxy $app) {
            $app->get("/", HomeController::class);
        })->add(UserAuth::class);

        $this->app->group("/admin", function (RouteCollectorProxy $app) {
            $app->get("/", AdminController::class);
        })->add(AdminAuth::class);
    }
}
