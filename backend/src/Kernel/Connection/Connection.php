<?php

namespace App\Kernel\Connection;

use PDO;
use PDOException;
use PDOStatement;

class Connection
{
    public readonly PDO $pdo;

    public readonly int $lastInsertId;

    public function __construct(
        private readonly string $db_host,
        private readonly string $db_name,
        private readonly string $db_user,
        private readonly string $db_password
    ) {
        $this->connect();
    }
    private function connect(): void
    {
        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_password, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function prepare($sql): PDOStatement
    {
        $this->pdo->beginTransaction();
        return $this->pdo->prepare($sql);
    }

    public function execute($sql, $params = [])
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        $this->lastInsertId = $this->pdo->lastInsertId();
        $this->pdo->commit();
        return $result;
    }
}