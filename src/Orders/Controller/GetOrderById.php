<?php

namespace App\Orders\Controller;

use Psr\Http\Message\ServerRequestInterface;
use App\Core\JsonResponse;

final class GetOrderById
{
    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return JsonResponse::ok(['message' => "GET request to /orders/{$id}"]);
    }
}