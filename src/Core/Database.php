<?php

namespace Vortrixs\Portfolio\Core;

use Generator;
use PDO;
use PDOStatement;
use stdClass;

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

    public function query(string $sql): array|false
    {
        $statement = $this->pdo->prepare($sql);

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

        $statement = $this->bindValues($data, $statement);

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
     * @param array<string> $columns
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
    public function update(array $data, ?string $constraint = null): bool
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

        $statement = $this->bindValues($data, $statement);

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

    public function delete(string $column, mixed $value): bool
    {
        $query = "delete from {$this->table} where {$column} = :{$column}";

        $statement = $this->pdo->prepare($query);

        if (!$statement) {
            throw new \Error();
        }

        $statement = $this->bindValues([$column => $value], $statement);

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
        if (stdClass::class === $classname) {
            while ($data = $statement->fetchObject($classname)) {
                yield $data;
            }
        } else {
            while ($data = $statement->fetch(PDO::FETCH_ASSOC)) {
                if (method_exists($classname, 'fromDatabase')) {
                    yield $classname::fromDatabase($data);
                } else {
                    yield new $classname(...$data);
                }
            }
        }        
    }

    private function bindValues(array $data, PDOStatement $statement): PDOStatement
    {
        foreach ($data as $key => $value) {
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
                $statement->bindValue($parameter, serialize($value), PDO::PARAM_STR);
            }
        }

        return $statement;
    }
}
