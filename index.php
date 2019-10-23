<?php
require "vendor/autoload.php";

$loop = \React\EventLoop\Factory::create();

$server = new \React\Http\Server(
    function (\Psr\Http\Message\ServerRequestInterface $request)use($loop) {
        $path = $request->getUri()->getPath();
        echo $path.PHP_EOL;
        switch ($path) {
            case '/':
                // Начало работы с файлами
                return new \React\Http\Response(
                    200,
                    ['Content-Type' => 'text/html;charset=Utf-8'],
                );
                break;
            case '/upload':
                return new \React\Http\Response(
                    200,
                    ['Content-Type' => 'text/plain;charset=Utf-8'],
                    "Upload"
                );
                break;
        }
    }
);

$socket = new \React\Socket\Server('127.0.0.1:8181', $loop);

$server->listen($socket);

echo 'Start server: ' . str_replace('tcp:', 'http:', $socket->getAddress());

$loop->run();