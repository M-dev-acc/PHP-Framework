<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;

class Database
{
    public PDO $connection;

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
}
