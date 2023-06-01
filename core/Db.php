<?php

namespace core;

use PDO;

class Db
{
    protected static PDO $db;

    protected static function connect(string $dsn, string $username, string $password)
    {
        static::$db = new PDO($dsn, $username, $password);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        $dsn = CONFIG['database']['type'] . ':dbname=' . CONFIG['database']['dbname'];
        $username = CONFIG['database']['username'];
        $password = CONFIG['database']['password'];
        static::connect($dsn, $username, $password);
        $query = new Query(static::$db);
        return call_user_func_array([$query, $name], $arguments);
    }
}