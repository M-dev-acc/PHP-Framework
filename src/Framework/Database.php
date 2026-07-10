<?php

declare(strict_types=1);

namespace Framework;

use PDO, PDOException;
use PDOStatement;

class Database
{
    private PDO $connection;
    private PDOStatement $statement;

    public function __construct(
        string $driver, 
        array $configs,
        string $username,
        string $password
    )
    {
        $config = http_build_query(
            data: $configs, 
            arg_separator: ";"
        );

        $dsn = "$driver:$config";

        try {
            $this->connection = new PDO($dsn, $username, $password);
        } catch (PDOException $th) {
            die("Unable to connect to database.");
        }

    }

    public function query(string $query, array $params = []) : Database {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function count() : mixed {
        return $this->statement->fetchColumn();
    }
}
