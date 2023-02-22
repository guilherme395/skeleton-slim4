<?php

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager as Capsule;

use App\Config\Routes\FrontRoutes;
use App\Config\Routes\BackRoutes;
use App\Config\Middleware;

require_once __DIR__ . "/../../vendor/autoload.php";

class Bootstrap
{
    private $app;

    public function __construct(ContainerInterface $container)
    {
        AppFactory::setContainer($container);
        $this->app = AppFactory::create();

        $this->loadArchives();
        $this->configure();
    }

    public function get()
    {
        return $this->app;
    }

    private function loadArchives()
    {
        $routerFront = new FrontRoutes($this->app);
        $routerFront->router();

        $routerBack = new BackRoutes($this->app);
        $routerBack->router();

        $middleware = new Middleware($this->app);
        $this->app->add($middleware);
    }

    private function configure()
    {
        date_default_timezone_set("America/Sao_Paulo");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $this->configureDatabase();
    }

    private function configureDatabase()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            "driver" => "mysql",
            "host" => "localhost",
            "database" => "i3sis517_site",
            "username" => "root",
            "password" => "66586169",
            "charset" => "utf8mb4",
            "collation" => "utf8mb4_unicode_ci",
            "prefix" => "",
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}

class Container
{
    private $container;

    public function __construct()
    {
        $this->container = new \DI\Container();
        $this->register();
    }

    private function register()
    {
        $this->container->set(Bootstrap::class, function (ContainerInterface $container) {
            return new Bootstrap($container);
        });
    }

    public function get($class)
    {
        return $this->container->get($class);
    }
}

$container = new Container();
$app = $container->get(Bootstrap::class)->get();

return $app;
