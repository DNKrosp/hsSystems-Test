<?php

namespace database;

use Exception;
use PDO;

class PgConnection
{
    private PDO $connection;
    private array $sets;

    private function __construct($conString, $username, $password)
    {
        $this->sets = [
            "constring" => "pgsql:" . $conString,
            "username" => $username,
            "password" => $password
        ];
        $this->connection = new PDO("pgsql:" . $conString, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function createFromJson($json): PgConnection
    {
        $params = json_decode($json, true);
        foreach (['host', 'port', 'user', 'password', 'dbname'] as $needed) {
            if (!isset($params[$needed])) throw new Exception("Needed json param " . $needed . " didn't passed");
        }
        return new self("host=" . $params['host'] . " dbname=" . $params['dbname'], $params['user'], $params['password']);
    }

    public function query($str, $placeholders = [])
    {
        $res = $this->connection->prepare($str);
        foreach ($placeholders as $key => $value) {
            $res->bindValue($key, $value);
        }
        if ($res) {
            try {
                $res->execute();
            } catch (\PDOException $e) {
                if ($e->getCode() == "HY000") {
                    unset($this->connection);
                    $this->connection = new PDO(
                        $this->sets["constring"],
                        $this->sets["username"],
                        $this->sets["password"],
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                    return $this->query($str, $placeholders);
                }
                throw $e;
            }
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //@todo экранировать table
    public function insert($table, $values, $returning = null): array
    {
        $keys = array_keys($values);
        foreach ($keys as &$key) {
            $key = '"' . $key . '"';
        }
        foreach ($values as &$value) {
            if (!is_numeric($value))
                $value = "'" . pg_escape_string($value) . "'";
        }
        $query = "insert into $table(" . implode(",", $keys) . ") values(" . implode(",", $values) . ")";
        if ($returning != null) $query .= " returning \"" . $returning . "\"";
        return $this->query($query);

    }

    public function update($table, $values, $where, $placeholders = [])
    {
        $keys = array_keys($values);
        $sets = [];
        foreach ($values as $key => $value) {
            $sets[] = '"' . $key . '"' . "=" . "'" . $value . "'";
        }

        $query = "update $table SET " . implode(",", $sets) . " " . $where ." RETURNING id";
        return $this->query($query, $placeholders);
    }

}