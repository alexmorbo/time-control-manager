<?php

namespace TimeControlManager;

/**
 * Class TimeControl
 * @package TimeControlManager
 */
class TimeControl
{
    /**
     * @var BaseConnect
     */
    private $db;

    /**
     * @var self
     */
    private static $tcInstance = null;

    public function __construct(array $config)
    {
        $this->db = new BaseConnect(
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['base']
        );

        self::$tcInstance = $this;
    }

    /**
     * @return TimeControl
     */
    public static function getInstance(): self
    {
        if (self::$tcInstance === null) {
            throw new \RuntimeException('You need to initiate library before use static calls');
        }

        return self::$tcInstance;
    }

    /**
     * @return \PDO
     */
    public function getDb(): \PDO
    {
        return $this->db->getDB();
    }
}