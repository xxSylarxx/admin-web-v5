<?php

namespace Admin\Core;

use \Envms\FluentPDO\Query;


class DataBase
{
    private $host = BD_HOST;
    private $name = BD_NAME;
    private $user = BD_USER;
    private $pass = BD_PASS;
    private $port = BD_PORT;

    public function connect()
    {
        try {
            $con = "mysql:host=$this->host;dbname=$this->name;charset=utf8mb4;port=$this->port";
            $pdo = new \PDO($con, $this->user, $this->pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $fluent = new Query($pdo);
            return $fluent;
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}
