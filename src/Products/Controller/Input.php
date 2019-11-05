<?php

namespace App\Products\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

final class Input
{

    private $request;

    public function __construct(ServerRequestInterface $request)
    {

        $this->request = $request;
    }

    /**
     * @throws NestedValidationException
     */
    public function validate(): void
    {
        $nameValidator = Validator::key(
            'name',
            Validator::allOf(
                Validator::notBlank(),
                Validator::stringType()
            )
        )->setName('name');

        $priceValidator = Validator::key(
            'price',
            Validator::allOf(
                Validator::notBlank(),
                Validator::numeric(),
                Validator::positive()
            )
        )->setName('price');

        Validator::allOf($nameValidator, $priceValidator)->assert($this->request->getParsedBody());
    }

    public function name(): string
    {
        return $this->request->getParsedBody()['name'];
    }

    public function price(): float
    {
        return (float)$this->request->getParsedBody()['price'];
    }

    public function image(): ?UploadedFileInterface
    {
        $files = $this->request->getUploadedFiles();
        return $files['image'] ?? null;
    }
}
