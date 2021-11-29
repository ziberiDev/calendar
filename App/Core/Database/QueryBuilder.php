<?php

namespace App\Core\Database;

use PDO;


class QueryBuilder
{

    /**
     * @var PDO|null
     */
    public ?PDO $db;


    /**
     * @var
     */
    public $query;

    /**
     * @var array
     */
    public $bindParams = [];


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
     * @return $this
     */
    public function from(string $table): self
    {
        $this->query .= "$table ";

        return $this;
    }

    /**
     * @param $column
     * @param string $operator
     * @param $value
     * @return $this
     */
    public function where($column, $operator, $value): static
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


    public function insert(string $table, array $columns)
    {
        $columns = implode(",", $columns);

        $this->query = "INSERT INTO $table  ($columns) ";

        return $this;
    }

    public function values(array $values): static
    {
        //TODO: implement better way of insert in to db
        if (!is_array($values[0])) {
            array_map(function ($value) {
                return $this->bindParams[':' . $value] = $value;
            }, $values);
            $values = implode(",:", $values);
            $this->query .= "VALUES (:$values)";
        } else {
            $this->query .= " VALUES ";
            foreach ($values as $value) {
                $prepareValues = implode(",:", $value);
                array_map(function ($single) {
                    return $this->bindParams[':' . $single] = $single;
                }, $value);
                $a = !next($values) ? " (:$prepareValues);" : "(:$prepareValues),";
                $this->query .= $a;
            }
        }
        return $this;
    }


    /**
     * @return array|false|string
     */
    public function get(): bool|array|string
    {
        if (!isset($this->query)) {
            echo "No QUERY";
        }
        try {
            $statement = $this->db->prepare($this->query);
            $statement->execute($this->bindParams ?? []);
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function execute()
    {
        $statement = $this->db->prepare($this->query);
        $statement->execute($this->bindParams ?? []);
    }


}