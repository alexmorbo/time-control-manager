<?php

namespace TimeControlManager;

use Exception;
use PDO as PDOAlias;

class BaseConnect
{
    const CONNECTION_FORMAT = 'firebird:dbname=%s/%s:%s';

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

    /**
     * BaseConnect constructor.
     *
     * @param $username
     * @param $password
     * @param $host
     * @param $port
     * @param $database
     *
     * @throws Exception
     */
    public function __construct(string $username, string $password, string $host, int $port, string $database)
    {
        if (!isset($username) || !isset($password) || !isset($host) || !isset($database)) {
            throw new Exception('something is not specified');
        }

        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    /**
     * @return PDOAlias
     */
    public function getDB(): PDOAlias
    {
        return $this->connect;
    }

    /**
     * lets connect
     */
    protected function connect(): void
    {
        $dsn = sprintf(self::CONNECTION_FORMAT, $this->host, $this->port, $this->database);
        $this->connect = new PDOAlias($dsn, $this->username, $this->password, [
            PDOAlias::ATTR_ERRMODE => PDOAlias::ERRMODE_EXCEPTION,
            PDOAlias::ATTR_DEFAULT_FETCH_MODE => PDOAlias::FETCH_ASSOC,
        ]);
        $this->connect->beginTransaction();
    }
}
