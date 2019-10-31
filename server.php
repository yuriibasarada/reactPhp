<?php

use App\Core\ErrorHandler;
use App\Core\JsonRequestDecoder;
use App\Orders\Controller\CreateOrder\Controller;
use App\Orders\Controller\DeleteOrder;
use App\Orders\Controller\GetAllOrders;
use App\Orders\Controller\GetOrderById;
use App\Products\Controller\CreateProduct;
use App\Products\Controller\DeleteProduct;
use App\Products\Controller\GetAllProducts;
use App\Products\Controller\GetProductById;
use App\Products\Controller\UpdateProduct;
use App\Core\Router;
use Dotenv\Dotenv;
use FastRoute\DataGenerator\GroupCountBased;
use FastRoute\RouteCollector;
use FastRoute\RouteParser\Std;
use React\EventLoop\Factory;
use React\Http\Server;
use App\Products\Storage as Products;
use App\Orders\Storage as Orders;

require 'vendor/autoload.php';

$env = Dotenv::create(__DIR__);
$env->load();

$loop = Factory::create();
$mysql = new \React\MySQL\Factory($loop);
$uri = getenv('DB_LOGIN') . ':' . getenv('DB_PASS') . '@' . getenv('DB_HOST') . '/' . getenv('DB_NAME');
$connection = $mysql->createLazyConnection($uri);

$products = new Products($connection);
$orders = new Orders($connection);


$routes = new RouteCollector(new Std(), new GroupCountBased());

$routes->get('/products', new GetAllProducts($products));
$routes->post('/products', new CreateProduct($products));
$routes->get('/products/{id:\d+}', new GetProductById($products));
$routes->put('/products/{id:\d+}', new UpdateProduct($products));
$routes->delete('/products/{id:\d+}', new DeleteProduct($products));

$routes->get('/orders', new GetAllOrders($orders));
$routes->post('/orders', new Controller($orders, $products));
$routes->get('/orders/{id:\d+}', new GetOrderById($orders));
$routes->delete('/orders/{id:\d+}', new DeleteOrder($orders));

$middleware = [new ErrorHandler(), new JsonRequestDecoder(), new Router($routes)];
$server = new Server($middleware);
$socket = new \React\Socket\Server('127.0.0.1:8000', $loop);

$server->listen($socket);

$server->on('error', function (Throwable $error) {
    echo 'Error: ' . $error->getMessage() . PHP_EOL;
});

echo 'Listening on ' . str_replace('tcp', 'http', $socket->getAddress()) . PHP_EOL;

$loop->run();
