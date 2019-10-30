<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 14:25
 */

namespace App\Products\Controller;
use App\Core\JsonResponse;
use App\Products\ProductNotFound;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use App\Products\Product;

final class GetProductById
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return $this->storage
            ->getById((int)$id)
            ->then(
                function (Product $product) {
                    return JsonResponse::ok($product->toArray());
                }
            )
            ->otherwise(function(ProductNotFound $error){
                return JsonResponse::notFound();
            })
            ->otherwise(function (Exception $error){
                return JsonResponse::internalServerError($error->getMessage());
            });
    }
}