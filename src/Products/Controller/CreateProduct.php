<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 14:06
 */

namespace App\Products\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class CreateProduct
{
    public function __invoke(ServerRequestInterface $request)
    {
        return  JsonResponse::ok(['message' => 'POST request to /products']);
    }
}