<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 29.10.2019
 * Time: 17:13
 */

namespace App\Core;


use React\Http\Response;

final class JsonResponse extends Response
{

    public function __construct(int $statusCoude, $data = null)
    {
        $data = $data ? json_encode($data) : null;

        parent::__construct(
            $statusCoude,
            ['Content-type' => 'application/json'],
            $data
        );
    }

    public static function ok($data) : self
    {
        return new self(200, $data);
    }

    public static function internalServerError(string $reason): self
    {
        return new self(500, ['message' => $reason]);
    }
    
}