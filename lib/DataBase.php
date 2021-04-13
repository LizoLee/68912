<?php

class DataBase
{

    private const CONNECT_CONFIG = "../config/parametres.ini";

    private $dbconf;
    private $dsn;
    private $connection;
    private $err = 0;

    public function __construct()
    {
        $this->dbconf = parse_ini_file($this::CONNECT_CONFIG);
        $this->dsn = "pgsql:"
                . "host={$this->dbconf["host"]};"
                . "port={$this->dbconf["port"]};"
                . "user={$this->dbconf["user"]};"
                . "password={$this->dbconf["password"]};"
                . "dbname={$this->dbconf["dbname"]}";
        try {
            $this->connection = new PDO($this->dsn);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            $this->err = $e->getMessage();
        }
    }

    /**
     * $table must take values from following: "review", "user"
     */
    public function select_all_from_table(string $table, string $orderby = "id")
    {
        if (!$this->err) {
            try {
                $query = $this->create_select_query($table, "*", [], "date_insert");
                return $this->execute($query);
            } catch (Exception $e) {
                $this->err = $e->getMessage();
            }
        } else {
            return $this->err;
        }
    }

    /**
     * $table must take values from following: "review", "user"
     * 
     * $fields might be a string or an array 
     * and must be from following:
     * "id", "email", "name", "date_insert", "rate", "text", "image_path"
     * e.g. "email", ["id", "name"], ["0" => "date_insert", "mark" => "rate"]
     * 
     * $conditions array's keys must be from following: 
     * "id", "email", "name", "date_insert", "rate", "text", "image_path"
     * e.g. ["name" => "Nick", "rate" => "3"]
     */
    public function select_from_table(string $table, $fields, array $conditions = [], string $orderby = "id")
    {
        if (!$this->err) {
            $query = $this->create_select_query($table, $fields, $conditions, $orderby);
            try {
                return $this->execute($query);
            } catch (Exception $e) {
                $this->err = $e->getMessage();
            }
        } else {
            return $this->err;
        }
    }

    /**
     * $values array's keys must be from following: 
     * "email", "name", "rate", "text", "image_path"
     * keys "email", "name" and "rate" are required
     * e.g. ["email" => "example@example.com", "name" => "Nick", "rate" => "3"]
     */
    public function insert_to_reviews(array $values)
    {
        if (!$this->err) {
            $values["date_insert"] = date("Y-m-d H:i:sO");
            $query = $this->create_insert_query("reviews", $values);
            try {
                $this->execute($query);
            } catch (Exception $e) {
                $this->err = $e->getMessage();
                return $this->err;
            }
        } else {
            return $this->err;
        }
    }

    private function create_select_query(string $table, $fields, array $conditions, string $orderby)
    {
        $query = "SELECT ";
        if (is_string($fields)) {
            $query .= $fields;
        } elseif (is_array($fields)) {
            $query .= implode(", ", $fields);
        }
        $query .= " FROM " . $table;
        if (!empty($conditions)) {
            $query .= $this->conditions_from_arr($conditions);
        }
        if (!empty($orderby)) {
            $query .= " ORDER BY ". $orderby;
        }
        return $query;
    }

    private function create_insert_query(string $table, array $values)
    {
        $query = "INSERT INTO " . $table
                . " (" . implode(", ", array_keys($values))
                . ") VALUES ('" . implode("', '", $values) . "')";
        return $query;
    }

    private function conditions_from_arr(array $conditions)
    {
        return " WHERE " . implode("' AND ", array_map(function ($key, $val) {
                            return $key . "='" . $val;
                        }, array_keys($conditions), $conditions)) . "'";
    }

    private function execute($query)
    {
        $prepared = $this->connection->prepare($query);
        if ($prepared->execute()) {
            $data = $prepared->fetchAll();
        }
        return $data;
    }

}
