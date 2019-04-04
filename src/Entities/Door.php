<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class Door extends BaseEntity
{
    /**
     * Справочник проходных
     */
    const TABLE_NAME = 'doors';

    /**
     * @var string
     */
    protected $_primary = 'id';

    /**
     * Идентификатор проходной
     *
     * @var int
     */
    protected $id;

    /**
     * Использовать проходную для учета рабочего времени
     *
     * @var int
     */
    protected $useForWorkHours;

    /**
     * По умолчанию доступ закрыт
     *
     * @var int
     */
    protected $defaultAccessDenied;

    /**
     * Название проходной
     *
     * @var string
     */
    protected $name;

    /**
     * Использовать временной интервал доступа
     *
     * @var int
     */
    protected $useTimeIntervalAccess;

    /**
     * Начало разрешенного доступа
     *
     * @var string
     */
    protected $allowedAccessStart;

    /**
     * Конец интервала доступа
     *
     * @var string
     */
    protected $allowedAccessEnd;

    /**
     * Подразделение связанное с проходной
     *
     * @var int
     */
    protected $department;

    /**
     * Текстовый код
     *
     * @var string
     */
    protected $code;

    /**
     * 1 - Загружать на устройства сотрудников только выбранного подразделения
     *
     * @var int
     */
    protected $loadOnlyDepartmentUsers;

    /**
     * 1 - по умолчанию при регистрации прихода\ухода вручную
     *
     * @var int
     */
    protected $isDefault;

    /**
     * @var array
     */
    protected $map = [
        'DID' => 'id',
        'DUSEFORFACT' => 'useForWorkHours',
        'DEFAULTCLOSE' => 'defaultAccessDenied',
        'DOORNAME' => 'name',
        'DUSEINTERVAL' => 'useTimeIntervalAccess',
        'DSTART' => 'allowedAccessStart',
        'DEND' => 'allowedAccessEnd',
        'DEPART' => 'department',
        'CODE' => 'code',
        'LOAD_BY_DEPART' => 'loadOnlyDepartmentUsers',
        'ISDEFAULT' => 'isDefault',
    ];

    protected $_generators = [
        'id' => 'DOORS_GEN',
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUseForWorkHours(): int
    {
        return $this->useForWorkHours;
    }

    /**
     * @param int $useForWorkHours
     * @return Door
     * @throws UnprocessableEntityException
     */
    public function setUseForWorkHours(int $useForWorkHours): Door
    {
        if ($useForWorkHours < -32768 || $useForWorkHours > 32767) {
            throw new UnprocessableEntityException('UseForWorkHours invalid');
        }

        $this->useForWorkHours = $useForWorkHours;

        return $this;
    }

    /**
     * @return int
     */
    public function getDefaultAccessDenied(): int
    {
        return $this->defaultAccessDenied;
    }

    /**
     * @param int $defaultAccessDenied
     * @return Door
     * @throws UnprocessableEntityException
     */
    public function setDefaultAccessDenied(int $defaultAccessDenied): Door
    {
        if ($defaultAccessDenied < -32768 || $defaultAccessDenied > 32767) {
            throw new UnprocessableEntityException('DefaultAccessDenied invalid');
        }

        $this->defaultAccessDenied = $defaultAccessDenied;

        return $this;
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
     * @return Door
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): Door
    {
        if (mb_strlen($name) > 128) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseTimeIntervalAccess(): int
    {
        return $this->useTimeIntervalAccess;
    }

    /**
     * @param int $useTimeIntervalAccess
     * @return Door
     * @throws UnprocessableEntityException
     */
    public function setUseTimeIntervalAccess(int $useTimeIntervalAccess): Door
    {
        if ($useTimeIntervalAccess < -32768 || $useTimeIntervalAccess > 32767) {
            throw new UnprocessableEntityException('UseTimeIntervalAccess invalid');
        }

        $this->useTimeIntervalAccess = $useTimeIntervalAccess;

        return $this;
    }

    /**
     * @return string
     */
    public function getAllowedAccessStart(): string
    {
        return $this->allowedAccessStart;
    }

    /**
     * @TODO: date column, add validate check
     *
     * @param string $allowedAccessStart
     * @return Door
     */
    public function setAllowedAccessStart(string $allowedAccessStart): Door
    {
        $this->allowedAccessStart = $allowedAccessStart;

        return $this;
    }

    /**
     * @return string
     */
    public function getAllowedAccessEnd(): string
    {
        return $this->allowedAccessEnd;
    }

    /**
     * @TODO: date column, add validate check
     *
     * @param string $allowedAccessEnd
     * @return Door
     */
    public function setAllowedAccessEnd(string $allowedAccessEnd): Door
    {
        $this->allowedAccessEnd = $allowedAccessEnd;

        return $this;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->department;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return Department::findOne($this->department);
    }

    /**
     * @param int $checkpoint
     * @return Door
     */
    public function setDepartmentId(int $checkpoint): Door
    {
        $this->department = $checkpoint;

        return $this;
    }

    /**
     * @param Department $department
     * @return Door
     */
    public function setDepartment(Department $department): Door
    {
        $this->department = $department->getId();

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
     * @return Door
     * @throws UnprocessableEntityException
     */
    public function setCode(string $code): Door
    {
        if (mb_strlen($code) > 8) {
            throw new UnprocessableEntityException('Code too long');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * @return bool
     */
    public function getLoadOnlyDepartmentUsers(): bool
    {
        return $this->loadOnlyDepartmentUsers ? true : false;
    }

    /**
     * @param bool $loadOnlyDepartmentUsers
     * @return Door
     */
    public function setLoadOnlyDepartmentUsers(bool $loadOnlyDepartmentUsers): Door
    {
        $this->loadOnlyDepartmentUsers = $loadOnlyDepartmentUsers ? true : false;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDefault(): bool
    {
        return $this->isDefault ? true : false;
    }

    /**
     * @param bool $isDefault
     * @return Door
     */
    public function setIsDefault(bool $isDefault): Door
    {
        $this->isDefault = $isDefault ? true : false;

        return $this;
    }
}