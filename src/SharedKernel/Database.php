<?php

namespace Vortrixs\Portfolio\SharedKernel;

use PDO;

class Database {
    private readonly PDO $pdo;

    public function __construct(private readonly string $databaseFilePath)
    {
        $this->pdo = new PDO("sqlite:{$databaseFilePath}");
    }
}