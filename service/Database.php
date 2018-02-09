<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 07.02.18
 */

namespace service;


class Database
{
    private static $instance;
    private $connection;
    private $host;
    private $username;
    private $password;
    private $database;

    private function __construct(string $host, string $username, string $password, string $db)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $db;
        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);

        // Error handling
        if (mysqli_connect_error()) {
            trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),
                E_USER_ERROR);
        }
    }

    public static function getDb()
    {
        if (!isset(self::$instance)) {
            $config = include '../config/db.php';
            self::$instance = new self($config['host'], $config['username'], $config['password'], $config['database']);
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function __clone()
    {
    }
}