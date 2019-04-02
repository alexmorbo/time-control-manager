<?php

namespace TimeControlManager;

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
     * @var \PDO
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

        $this->connect = new \PDO($dsn, $this->username, $this->password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
    }

    public function getDB(): \PDO
    {
        return $this->connect;
    }
}