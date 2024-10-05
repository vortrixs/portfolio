<?php

namespace Vortrixs\Portfolio\SharedKernel;

use Generator;
use PDO;
use PDOStatement;

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

    public function query(string $sql)
    {
        $statement = $this->pdo->prepare($sql);

        if (!$statement) {
            throw new \Error();
        }

        $this->pdo->beginTransaction();

        try {
            $statement->execute();
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
            return false;
        }

        $this->pdo->commit();

        return $statement->fetchAll();
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
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * @param string[] $columns
     */
    public function select(array $columns = ['*'], string $classname = 'stdClass'): Generator|false
    {
        $cols = implode(',', $columns);
        $query = "select {$cols} from {$this->table}";

        $statement = $this->pdo->prepare($query);

        if (!$statement) {
            throw new \Error();
        }

        $this->pdo->beginTransaction();

        try {
            $statement->execute();
            $this->pdo->commit();
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
            return false;
        }

        return $this->createGenerator($statement, $classname);
    }

    /**
     * @param array<string,mixed> $data
     */
    public function update(array $data, ?string $constraint = null, array $additionalPlaceholders = [], string $classname = 'stdClass'): Generator|false
    {
        /** @var string[] $keys */
        $keys = array_keys($data);
        $assignments = implode(',', array_map(fn(string $column) => "{$column} = :{$column}", $keys));

        $query = "update {$this->table} set {$assignments}";

        if ($constraint) {
            $query .= " where {$constraint}";
        }

        $statement = $this->pdo->prepare($query);

        if (!$statement) {
            throw new \Error();
        }

        foreach (array_merge($data,$additionalPlaceholders) as $key => $value) {
            $parameter = ":{$key}";
            $type = match (true) {
                is_string($value) => PDO::PARAM_STR,
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => null,
            };

            if (null !== $type) {
                $statement->bindValue($parameter, $value, $type);
            } else {
                $statement->bindValue($parameter, (string) $value, PDO::PARAM_STR);
            }
        }

        $this->pdo->beginTransaction();

        try {
            $statement->execute();
            $this->pdo->commit();
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
            return false;
        }

        return $this->createGenerator($statement, $classname);
    }

    public function delete(string|int $id, mixed $value)
    {
        $query = "delete from {$this->table} where {$id} = :{$id}";

        $statement = $this->pdo->prepare($query);

        if (!$statement) {
            throw new \Error();
        }

        $type = match (true) {
            is_string($value) => PDO::PARAM_STR,
            is_int($value) => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            is_null($value) => PDO::PARAM_NULL,
            default => null,
        };

        if (null !== $type) {
            $statement->bindValue(":{$id}", $value, $type);
        } else {
            $statement->bindValue(":{$id}", (string) $value, PDO::PARAM_STR);
        }

        $this->pdo->beginTransaction();

        try {
            $statement->execute();
            $this->pdo->commit();
            return true;
        } catch (\Error | \Exception) {
            $this->pdo->rollBack();
            return false;
        }
    }

    private function createGenerator(PDOStatement $statement, string $classname): Generator
    {
        while ($object = $statement->fetchObject($classname)) {
            yield $object;
        }
    }
}
