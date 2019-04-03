<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class Department extends BaseEntity
{
    /**
     * Справочник подразделений
     */
    const TABLE_NAME = 'departments';

    /**
     * @var string
     */
    protected $_primary = 'id';

    /**
     * Идентификатор подразделения
     *
     * @var int
     */
    protected $id;

    /**
     * Название подразделения
     *
     * @var string
     */
    protected $name;

    /**
     * Идентификатор родительского подраздиления
     *
     * @var int
     */
    protected $parentId;

    /**
     * Идентификатор руководителя
     *
     * @var int
     */
    protected $headId;

    /**
     * Время начала работы
     *
     * @var string
     */
    protected $workStartTime;

    /**
     * Время конца работы
     *
     * @var string
     */
    protected $workEndTime;

    /**
     * Комментарий
     *
     * @var string
     */
    protected $comment;

    /**
     * Текстовый код
     *
     * @var string
     */
    protected $code;

    
    protected $map = [
        'DEPID' => 'id',
        'DEPNAME' => 'name',
        'PARENTID' => 'parentId',
        'PERSONID' => 'headId',
        'STARTTIME' => 'workStartTime',
        'ENDTIME' => 'workEndTime',
        'DEPCOMMENT' => 'comment',
        'CODE' => 'code',
    ];

    protected $_generators = [
        'id' => 'DEPARTMENTS_GEN',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Department
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): Department
    {
        if (mb_strlen($name) > 255) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @return Department|null
     */
    public function getParent(): ?Department
    {
        return static::findOne($this->parentId);
    }

    /**
     * @param int $parentId
     * @return Department
     */
    public function setParentId(int $parentId): Department
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeadId(): int
    {
        return $this->headId;
    }

    /**
     * @return User|null
     */
    public function getHead(): ?User
    {
        return User::findOne($this->headId);
    }

    /**
     * @param int $headId
     * @return Department
     */
    public function setHeadId(int $headId): Department
    {
        $this->headId = $headId;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkStartTime(): string
    {
        return $this->workStartTime;
    }

    /**
     * @TODO: time column, add validate check
     *
     * @param string $workStartTime
     * @return Department
     */
    public function setWorkStartTime(string $workStartTime): Department
    {
        $this->workStartTime = $workStartTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getWorkEndTime(): string
    {
        return $this->workEndTime;
    }

    /**
     * @TODO: time column, add validate check
     *
     * @param string $workEndTime
     * @return Department
     */
    public function setWorkEndTime(string $workEndTime): Department
    {
        $this->workEndTime = $workEndTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Department
     * @throws UnprocessableEntityException
     */
    public function setComment(string $comment): Department
    {
        if (mb_strlen($comment) > 255) {
            throw new UnprocessableEntityException('Comment too long');
        }

        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Department
     * @throws UnprocessableEntityException
     */
    public function setCode(string $code): Department
    {
        if (mb_strlen($code) > 20) {
            throw new UnprocessableEntityException('Code too long');
        }

        $this->code = $code;

        return $this;
    }
}