<?php

namespace App\Products;

use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;

final class Storage
{
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(string $name, float $price): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO products (name, price) VALUES  (?, ?)',
                    [$name, $price]
            )
            ->then(function (QueryResult $result) use ($name, $price){
                return new Product($result->insertId, $name, $price);
            });
    }

    public function getById(int $id): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, name, price FROM products WHERE id = ?',[$id])
            ->then(function (QueryResult $queryResult){
                if(empty($queryResult->resultRows)) {
                    throw new ProductNotFound();
                }
                return $this->mapProduct($queryResult->resultRows[0]);
            });
    }

    public function getAll(): PromiseInterface {
        return $this->connection
            ->query('SELECT id, name, price FROM products')
            ->then(function (QueryResult $result) {
                return array_map(function (array $row) {
                    return $this->mapProduct($row);
                }, $result->resultRows);
            });
    }

    public function delete(int $id): PromiseInterface
    {
        return $this->connection
            ->query('DELETE FROM products WHERE id = ?',[$id])
            ->then(function (QueryResult $result){
                if($result->affectedRows === 0) {
                    throw new ProductNotFound();
                }
            });
    }

    public function update(int $id, string $newName, float $newPrice): PromiseInterface
    {
        return $this->getById($id)
            ->then(function (Product $product) use ($newName, $newPrice) {
                return $this->connection
                    ->query(
                        'UPDATE products SET name = ?, price = ? 
                             WHERE id = ?',
                        [$newName, $newPrice, $product->id]
                    );
            });
    }

    private function mapProduct(array $row): Product
    {
        return new Product((int)$row['id'], $row['name'], (float)$row['price']);
    }
}