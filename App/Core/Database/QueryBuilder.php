<?php

namespace App\Core\Database;

use App\Core\View\Collection;
use PDO;
use stdClass;

class QueryBuilder
{
    /**
     * @var PDO|null
     */
    public ?PDO $db;


    protected string $query;

    protected array $bindParams = [];

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    /**
     * @param string $columns
     * @return $this|void
     */
    public function select(string $columns = '*')
    {
        if (!isset($this->query)) {
            $this->query = "SELECT $columns FROM ";
            return $this;
        }
    }

    public function update(string $table, array $data)
    {
        $this->query = "UPDATE $table SET ";

        $this->setBindParams($data);
        $this->setUpdateValues();
        return $this;
    }

    /**
     * @param string $table
     * @return self
     */
    public function from(string $table): self
    {
        $this->query .= "$table ";
        return $this;
    }

    /**
     * @param string $column
     * @param string $operator
     * @param $value
     * @return self
     */
    public function where(string $column, string $operator, $value): self
    {
        $this->query .= " WHERE `$column` $operator :$column ";
        $this->bindParams[":$column"] = $value;
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $this->query .= " OR (`$column` $operator :$column) ";
        $this->bindParams[":$column"] = $value;
        return $this;
    }

    public function andWhere($column, $operator, $value)
    {
        $this->query .= " AND (`$column` $operator :$column) ";
        $this->bindParams[":$column"] = $value;
        return $this;
    }

    public function insert(string $table, array $data)
    {
        $columns = count($data) == count($data, COUNT_RECURSIVE) ? array_keys($data) : array_keys($data[0]);

        $queryColumns = implode(', ', $columns);
        $this->query = "INSERT INTO $table ($queryColumns) VALUES ";

        $this->setBindParams($data);
        $this->setInsertValues();
        return $this;
    }

    protected function setBindParams(array $data)
    {
        $is_multi_arr = count($data) !== count($data, COUNT_RECURSIVE);
        if ($is_multi_arr) {
            foreach ($data as $key => $value) {
                foreach ($value as $bindKey => $bindValue) {
                    $this->bindParams[$key][':' . $bindKey . $key] = trim($bindValue);
                }
            }
            return;
        }
        foreach ($data as $bindKey => $bindValue) {
            $this->bindParams[0][':' . $bindKey . 0] = trim($bindValue);
        }
    }

    private function setUpdateValues()
    {
        foreach ($this->bindParams[0] as $key => $value) {
            $column = trim($key, ':\0');
            $separator = next($this->bindParams[0]) ? ' ,' : '';
            $this->query .= $column . '=' . $key . $separator;
        }
    }

    protected function setInsertValues()
    {
        foreach ($this->bindParams as $key => $value) {
            $separator = next($this->bindParams) ? ',' : ';';
            $this->query .= '(' . implode(',', array_keys($value)) . ')' . $separator;
        }
    }

    /**
     * @return Collection|string|array
     * @throws \PDOException
     */
    public function get(): Collection|string|array
    {
        $statement = $this->db->prepare($this->query);
        $statement->execute($this->bindParams ?? []);
        $data = $statement->fetchAll(PDO::FETCH_CLASS);
        if (count($data) >= 1) {
            return new Collection($data);
        }
        return $data;
    }

    /**
     * @return bool
     */
    public function execute()
    {
        var_dump($this->query);
        $statement = $this->db->prepare($this->query);
        array_walk_recursive($this->bindParams, function ($value, $bindParamKey) use (&$statement) {
            $param = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $statement->bindValue($bindParamKey, $value, $param);
        });
        return $statement->execute();
    }


}
