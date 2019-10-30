<?php

namespace App\Products\Controller;

use App\Core\JsonResponse;
use App\Products\Storage;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use App\Products\Product;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

final class CreateProduct
{
    public $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $input = new Input($request);
        $input->validate();
        return $this->storage->create($input->name(), $input->price())
            ->then(function (Product $product) {
                return JsonResponse::ok($product->toArray());
            },
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}

