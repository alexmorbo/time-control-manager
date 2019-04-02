<?php

namespace TimeControlManager\Entities;

class User extends BaseEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $userPassword;

    /**
     * @var string
     */
    protected $userGroup;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $isUser;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $patronymic;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $externalId;

    /**
     * @var int
     */
    protected $departmentId;

    /**
     * @var int
     */
    protected $positionId;

    /**
     * @var string
     */
    protected $accessCardNumber;

    /**
     * @var int
     */
    protected $deviceId;

    protected $map = [
        'UID' => 'id',
        'USERPASSW' => 'userPassword',
        'USERGROUP' => 'userGroup',
        'USERNAME' => 'username',
        'ISUSER' => 'isUser',
        'FIRSTNAME' => 'surname',
        'SNAME' => 'name',
        'MIDNAME' => 'patronymic',
        'POL' => 'gender',
        'TABNUM' => 'externalId',
        'DEPART' => 'departmentId',
        'DOLJ' => 'positionId',
        'SHEDCARDKEY' => 'accessCardNumber',
        'DEVICE_UID' => 'deviceId',
    ];
}