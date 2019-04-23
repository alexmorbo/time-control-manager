<?php

namespace TimeControlManager;

use PDO;
use RuntimeException;

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

    /**
     * TimeControl constructor.
     *
     * @param BaseConnect $baseConnect
     */
    public function __construct(BaseConnect $baseConnect)
    {
        $this->db = $baseConnect;
        self::$tcInstance = $this;
    }

    /**
     * @return TimeControl
     */
    public static function getInstance(): self
    {
        if (self::$tcInstance === null) {
            throw new RuntimeException('You need to initiate library before use static calls');
        }

        return self::$tcInstance;
    }

    /**
     * @return PDO
     */
    public function getDb(): PDO
    {
        return $this->db->getDB();
    }
}
