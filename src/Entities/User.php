<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class User extends BaseEntity
{
    /**
     * Справочник сотрудников
     */
    const TABLE_NAME = 'users';

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * @var string
     */
    protected $primary = 'id';

    /**
     * Код группы пользователей
     *
     * @var int
     */
    protected $userGroup;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $patronymic;

    /**
     * @var string
     */
    protected $fullName;

    /**
     * @var int
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

    /**
     * @var array
     */
    protected $map = [
        'UID' => 'id',
        'USERGROUP' => 'userGroup',
        'FIRSTNAME' => 'surname',
        'SNAME' => 'name',
        'MIDNAME' => 'patronymic',
        'FULLNAME' => 'fullName',
        'POL' => 'gender',
        'TABNUM' => 'externalId',
        'DEPART' => 'departmentId',
        'DOLJ' => 'positionId',
        'SHEDCARDKEY' => 'accessCardNumber',
        'DEVICE_UID' => 'deviceId',
    ];

    protected $_generators = [
        'id' => 'USERS_GEN',
        'deviceId' => 'USERS_DEVICE_UID_GEN',
    ];

    /**
     * @return int
     */
    public function getUserGroupId(): int
    {
        return $this->userGroup;
    }

    /**
     * @return UserGroup|null
     */
    public function getUserGroup(): ?UserGroup
    {
        return UserGroup::findOne($this->userGroup);
    }

    /**
     * @param int $userGroupId
     * @return User
     */
    public function setUserGroupId(int $userGroupId): User
    {
        $this->userGroup = $userGroupId;

        return $this;
    }

    /**
     * @param UserGroup $userGroup
     * @return User
     */
    public function setUserGroup(UserGroup $userGroup): User
    {
        $this->userGroup = $userGroup->getId();

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setSurname(string $surname): User
    {
        if (mb_strlen($surname) > 64) {
            throw new UnprocessableEntityException('Surname too long');
        }

        $this->surname = trim($surname);
        $this->updateFullName();

        return $this;
    }

    /**
     * @param string $name
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): User
    {
        if (mb_strlen($name) > 64) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = trim($name);
        $this->updateFullName();

        return $this;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @param string $patronymic
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setPatronymic(string $patronymic): User
    {
        if (mb_strlen($patronymic) > 64) {
            throw new UnprocessableEntityException('Patronymic too long');
        }

        $this->patronymic = trim($patronymic);
        $this->updateFullName();

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    protected function updateFullName()
    {
        $this->fullName = trim(implode(' ', [
            $this->surname,
            $this->name,
            $this->patronymic
        ]));
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return (int) $this->gender;
    }

    /**
     * @param string $gender
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setGender(string $gender): User
    {
        switch ($gender) {
            case static::GENDER_MALE:
            case static::GENDER_FEMALE:
                $this->gender = (int) $gender;
                break;
            default:
                throw new UnprocessableEntityException('Gender invalid');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setExternalId(string $externalId): User
    {
        if (mb_strlen($externalId) > 20) {
            throw new UnprocessableEntityException('ExternalId too long');
        }

        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return int
     */
    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return Department::findOne($this->departmentId);
    }

    /**
     * @param int $departmentId
     * @return User
     */
    public function setDepartmentId(int $departmentId): User
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    /**
     * @param Department $department
     * @return User
     */
    public function setDepartment(Department $department): User
    {
        $this->departmentId = $department->getId();

        return $this;
    }

    /**
     * @return int
     */
    public function getPositionId(): int
    {
        return $this->positionId;
    }

    /**
     * @return DirectoryData|null
     */
    public function getPosition(): ?DirectoryData
    {
        return DirectoryData::findOne($this->positionId);
    }

    /**
     * @param DirectoryData $directoryData
     * @return User
     */
    public function setPosition(DirectoryData $directoryData): User
    {
        $this->positionId = $directoryData->getId();

        return $this;
    }

    /**
     * @param int $positionId
     * @return User
     */
    public function setPositionId(int $positionId): User
    {
        $this->positionId = $positionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessCardNumber(): string
    {
        return $this->accessCardNumber;
    }

    /**
     * @param string $accessCardNumber
     * @return User
     * @throws UnprocessableEntityException
     */
    public function setAccessCardNumber(string $accessCardNumber): User
    {
        if (mb_strlen($accessCardNumber) > 100) {
            throw new UnprocessableEntityException('AccessCardNumber too long');
        }

        $this->accessCardNumber = $accessCardNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getDeviceId(): int
    {
        return $this->deviceId;
    }
}
