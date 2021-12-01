<?php

namespace App\Core\Database;

use App\Core\View\Collection;
use PDO;

class QueryBuilder
{
    /**
     * @var PDO|null
     */
    public ?PDO $db;

    public string $query;

    public array $bindParams = [];

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
        $values = count($data) == count($data, COUNT_RECURSIVE) ? array_values($data) : $data;

        $queryColumns = implode(', ', $columns);
        $this->query = "INSERT INTO $table ($queryColumns) ";

        return $this->values($columns, $values);
    }

    protected function values($columns, array $values): static
    {


        if (!is_array($values[0])) {
            array_map(function ($value, $column) {
                return $this->bindParams[":" . $column . "1"] = $value;
            }, $values, $columns);
            $values = implode("1,:", $columns);
            $this->query .= " VALUES ( :{$values}1);";
        } else {
            $this->query .= " VALUES ";
            $counter = 0;
            foreach ($values as $key => $value) {
                $prepareValues = implode($key . " ,", $columns) . $key;
                array_map(function ($single) use ($key, $columns, &$counter) {
                    return $this->bindParams[$key][":{$columns[$counter++]}$key"] = $single;
                }, $value);
                $counter = 0;
                $a = !next($values) ? " (:$prepareValues);" : "(:$prepareValues) , ";
                $this->query .= $a;
            }
        }
        return $this;
    }


    /**
     * @return string|Collection
     */
    public function get(): Collection|string
    {
        try {
            $statement = $this->db->prepare($this->query);
            $statement->execute($this->bindParams ?? []);
            return new Collection($statement->fetchAll(PDO::FETCH_CLASS));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function execute()
    {

        // var_dump($this->query);
        try {
            $statement = $this->db->prepare($this->query);
            foreach ($this->bindParams as $key => $value) {
                $str = "first_name";
                $statement->execute($value);
            }


        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
        //var_dump($this->query);
    }

}