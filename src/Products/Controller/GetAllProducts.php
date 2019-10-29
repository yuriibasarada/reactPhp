<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 14:02
 */

namespace App\Products\Controller;


use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class GetAllProducts
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok(['message' => 'GET request to /products']);
    }
}