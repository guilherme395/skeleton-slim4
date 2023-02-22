<?php

namespace App\Config\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

use \App\Controllers\Security\AuthAdminController;
use \App\Controllers\Security\AuthUserController;

class BackRoutes
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function router()
    {
        $this->app->group("/app", function (RouteCollectorProxy $app) {
            //Autentica usuario comum
            $app->post("/authUser", AuthUserController::class);
        });

        $this->app->group("/admin", function (RouteCollectorProxy $app) {
            //Autentica usuario admin
            $app->post("/authAdmin", AuthAdminController::class);
        });
    }
}
