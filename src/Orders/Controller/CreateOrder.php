<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 14:06
 */

namespace App\Orders\Controller;

use App\Core\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

final class CreateOrder
{
    public function __invoke(ServerRequestInterface $request)
    {
        $order = [
            'productId' => $request->getParsedBody()['productId'],
            'quantity' => $request->getParsedBody()['quantity']
        ];
        return JsonResponse::ok([
            'message' => 'POST request to /orders/',
            'order' => $order
        ]);
    }
}
