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

    protected string $query;

    protected array $bindParams = [];

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    /**
     * @param string $columns
     * @return $this
     */
    public function select(string $columns = '*')
    {
        $this->query = '';
        $this->query = "SELECT $columns ";
        return $this;
    }

    public function update(string $table, array $data)
    {

        $this->query = '';
        $this->query = "UPDATE $table SET ";

        $this->setBindParams($data);
        $this->setUpdateValues();

        return $this;
    }

    public function insert(string $table, array $data)
    {
        $this->query = '';
        $columns = count($data) == count($data, COUNT_RECURSIVE) ? array_keys($data) : array_keys($data[0]);

        $queryColumns = implode(', ', $columns);
        $this->query = "INSERT INTO $table ($queryColumns) VALUES ";

        $this->setBindParams($data);
        $this->setInsertValues();
        return $this;
    }

    public function delete(string $table)
    {
        $this->query = '';
        $this->query = "DELETE FROM $table ";

        return $this;
    }

    /**
     * @param string $table
     * @return self
     */
    public function from(string $table): self
    {
        $this->query .= "FROM $table ";
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
        $this->bindParams[][":$column"] = $value;
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $this->query .= " OR (`$column` $operator :$column) ";
        $this->bindParams[][":$column"] = $value;
        return $this;
    }

    public function andWhere($column, $operator, $value)
    {
        $this->query .= " AND (`$column` $operator :$column) ";
        $this->bindParams[][":$column"] = $value;
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
            $separator = next($this->bindParams) ? ',' : ";";
            $this->query .= '(' . implode(',', array_keys($value)) . ')' . $separator;
        }
    }

    /**
     * @return Collection|null
     * @throws \PDOException
     */
    public function get(): Collection|null
    {
        $statement = $this->db->prepare($this->query);
        array_walk_recursive($this->bindParams, function ($value, $bindParamKey) use (&$statement) {
            $param = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;

            $statement->bindValue($bindParamKey, $value, $param);
        });

        $statement->execute();
        $data = $statement->fetchAll(PDO::FETCH_CLASS);
        if (count($data) >= 1) {
            $this->bindParams = [];
            return new Collection($data);
        }
        $this->bindParams = [];
        return null;
    }

    protected function returnData(int $last_table_id)
    {
        $data = [];
        foreach ($this->bindParams as $key => $value) {
            $last_table_id++;
            array_walk_recursive($value, function ($val, $k) use ($key, &$data, $last_table_id) {
                $data[$key]['id'] = ($last_table_id);
                $data[$key][preg_replace("/[0-9.:]/", '', $k)] = $val;
            });
        }
        $this->bindParams = [];
        return $data;
    }

    public function execute()
    {
        $statement = $this->db->prepare($this->query);
        array_walk_recursive($this->bindParams, function ($value, $bindParamKey) use (&$statement) {
            $param = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
            $statement->bindValue($bindParamKey, $value, $param);
        });

        if ($res = $statement->execute()) {
            $last_id = $this->db->lastInsertId() - 1;
            return $this->returnData($last_id);
        }

        return null;
    }
}
