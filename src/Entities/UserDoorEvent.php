<?php

namespace TimeControlManager\Entities;

use TimeControlManager\TimeControl;

class UserDoorEvent extends BaseEntity
{
    /**
     * События регистрация прихода и ухода
     */
    const TABLE_NAME = 'graph_fact_events';

    protected $primary = 'id';

    /**
     * Код пользователя
     *
     * @var int
     */
    protected $userId;

    /**
     * Дата и время события
     *
     * @var string
     */
    protected $eventDateTime;

    /**
     * Код проходной
     *
     * @var int
     */
    protected $doorId;

    /**
     * Метод регистрации события (1 - вручную 2 - картой 3 - автоматически 4 - биометрия)
     *
     * @var int
     */
    protected $method;

    /**
     * 0 - не задан (авто ) 1 - на вход 2 - ны выход 3 - проверка присутствия
     *
     * @var
     */
    protected $enterType;


    /**
     * @var array
     */
    protected $map = [
        'REGID' => 'id',
        'UID' => 'userId',
        'REGDATE' => 'eventDateTime',
        'DOORID' => 'doorId',
        'REGMETOD' => 'method',
        'INOUTTYPE' => 'enterType',
    ];

    /**
     * @var array
     */
    protected $_generators = [
        'id' => 'GRAPH_FACT_EVENTS_GEN'
    ];

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return User::findOne($this->userId);
    }

    /**
     * @param int $userId
     * @return UserDoorEvent
     */
    public function setUserId(int $userId): UserDoorEvent
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventDateTime(): string
    {
        return $this->eventDateTime;
    }

    /**
     * @param string $eventDateTime
     * @return UserDoorEvent
     */
    public function setEventDateTime(string $eventDateTime): UserDoorEvent
    {
        $this->eventDateTime = $eventDateTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getDoorId(): int
    {
        return $this->doorId;
    }

    /**
     * @return Door|null
     */
    public function getDoor(): ?Door
    {
        return Door::findOne($this->doorId);
    }

    /**
     * @param int $doorId
     * @return UserDoorEvent
     */
    public function setDoorId(int $doorId): UserDoorEvent
    {
        $this->doorId = $doorId;

        return $this;
    }

    /**
     * @return int
     */
    public function getMethod(): int
    {
        return $this->method;
    }

    /**
     * @param int $method
     * @return UserDoorEvent
     */
    public function setMethod(int $method): UserDoorEvent
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEnterType()
    {
        return $this->enterType;
    }

    /**
     * @param mixed $enterType
     * @return UserDoorEvent
     */
    public function setEnterType($enterType)
    {
        $this->enterType = $enterType;

        return $this;
    }

    public static function getEventsByPeriod(\DateTime $start, \DateTime $end)
    {
        $st = TimeControl::getInstance()->getDB()->prepare(
            sprintf(
                'select * from %s where %s > ? and %s < ?',
                static::TABLE_NAME,
                static::getRealColumn('eventDateTime'),
                static::getRealColumn('eventDateTime')
            )
        );
        $st->execute([
            $start->format('d.m.Y H:i'),
            $end->format('d.m.Y H:i'),
        ]);

        $entities = [];
        while ($row = $st->fetch()) {
            $entity = new static($row);
            $entities[$entity->getPk()] = $entity;
        }

        return $entities;
    }
}
