<?php

namespace Vortrixs\Portfolio\SharedKernel;

use PDO;

class Database
{
    private readonly PDO $pdo;
    private ?string $table = null;

    public function __construct(private readonly string $databaseFilePath)
    {
        $this->pdo = new PDO("sqlite:{$databaseFilePath}", options: [PDO::ERRMODE_EXCEPTION => true]);
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @var array<string, mixed> $data
     */
    public function insert(array $data): bool
    {
        /** @var string[] $keys */
        $keys = array_keys($data);
        $columns = implode(',', $keys);
        $values = implode(',', array_map(fn(string $column) => ":{$column}", $keys));

        $query = "insert into {$this->table} ({$columns}) values ({$values})";

        $statement = $this->pdo->prepare($query);

        if (!$statement) {
            throw new \Error();
        }

        foreach ($data as $key => $value) {
            $parameter = ":{$key}";
            $type = match (true) {
                is_string($value) => PDO::PARAM_STR,
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => 0,
            };

            if (0 !== $type) {
                $statement->bindValue($parameter, $value, $type);
            } else {
                $statement->bindValue($parameter, (string) $value, PDO::PARAM_STR);
            }
        }

        $this->pdo->beginTransaction();

        try {
            return $statement->execute();
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
        }

        return false;
    }
}
