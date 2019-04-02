<?php

namespace TimeControlManager\Entities;

class Department extends BaseEntity
{
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
     * Идентификатор ответственного лица (сотрудника)
     *
     * @var int
     */
    protected $respId;

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
        'PERSONID' => 'respId',
        'STARTTIME' => 'workStartTime',
        'ENDTIME' => 'workEndTime',
        'DEPCOMMENT' => 'comment',
        'CODE' => 'code',
    ];
}