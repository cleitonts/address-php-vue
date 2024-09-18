<?php

namespace App\Repository;

use App\Kernel\Connection\Connection;

abstract class AbstractRepository implements RepositoryInterface
{
    protected string $table;

    public function __construct(
        protected Connection $connection
    )
    {
    }

    public function find(int $id): array
    {
        $query = "SELECT * FROM {$this->getTable()} WHERE id = :id";
        return $this->connection->execute($query, ['id' => $id])[0] ?? [];
    }

    public function findAll($order): array
    {
        $query = "SELECT * FROM {$this->getTable()} order by {$order}";
        return $this->connection->execute($query) ?? [];
    }
}