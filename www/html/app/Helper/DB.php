<?php

namespace App\Helper;

use App\Helper\Config;
use PDO;
use stdClass;

class DB
{
    public static ?DB $instance = null;

    public PDO $pdo;

    private function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=' . Config::get('database.mysql.host') . ';dbname=' . Config::get('database.mysql.database') . ';',
            'root',
            'root',
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]
        );
    }

    public static function getInstance(): DB
    {
        if (is_null(self::$instance)) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public static function getPdo(): PDO
    {
        $db = self::getInstance();
        return $db->pdo;
    }

    public static function get(string $query, array $values = []): array|null
    {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);

            if ($stmt->rowCount() == 0) {
                return null;
            }

            return $stmt->fetchAll();
        } catch (\Throwable) {
            return null;
        }
    }

    public static function first(string $query, array $values = []): stdClass|null
    {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute($values);

            if ($stmt->rowCount() == 0) {
                return null;
            }

            return $stmt->fetch();
        } catch (\Throwable) {
            return null;
        }
    }

    public static function create(string $query, array $values = []): int|false
    {
        try {
            $pdo = self::getPdo();
            $stmt = $pdo->prepare($query);
            $response = $stmt->execute($values);

            return $response === true ? (int) $pdo->lastInsertId() : false;
        } catch (\Throwable) {
            return false;
        }
    }

    public static function beginTransaction(): void
    {
        $pdo = self::getPdo();
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }
    }

    public static function commitTransaction(): void
    {
        $pdo = self::getPdo();
        if ($pdo->inTransaction()) {
            $pdo->commit();
        }
    }

    public static function rollbackTransaction(): void
    {
        $pdo = self::getPdo();
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
    }
}
