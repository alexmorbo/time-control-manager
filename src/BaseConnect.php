<?php

namespace TimeControlManager;

use PDO as PDOAlias;

class BaseConnect
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $port;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var PDOAlias
     */
    private $connect;

    public function __construct($username, $password, $host, $port, $database)
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    protected function connect()
    {
        $dsn = sprintf(
            'firebird:dbname=%s/%s:%s',
            $this->host, $this->port, $this->database
        );

        $this->connect = new PDOAlias($dsn, $this->username, $this->password, [
            PDOAlias::ATTR_ERRMODE => PDOAlias::ERRMODE_EXCEPTION,
            PDOAlias::ATTR_DEFAULT_FETCH_MODE => PDOAlias::FETCH_ASSOC,
        ]);
    }

    public function getDB(): PDOAlias
    {
        return $this->connect;
    }
}