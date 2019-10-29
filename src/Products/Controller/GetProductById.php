<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 14:25
 */

namespace App\Products\Controller;
use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class GetProductById
{
    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return JsonResponse::ok(['message' => "GET request to /products/{$id}"]);

    }
}