<?php

namespace TimeControlManager;

use TimeControlManager\Entities\User;

class TimeControl
{
    /**
     * @var BaseConnect
     */
    private $db;

    public function __construct(array $config)
    {
        $this->db = new BaseConnect(
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['base']
        );
    }

    public function listUsers()
    {
        $st = $this->db->getDB()->query('select * from users where UID = 9');

        while ($row = $st->fetch()) {
            $user = new User($row);

            d($user);
            dd(__METHOD__);
            die;
        }
    }
}