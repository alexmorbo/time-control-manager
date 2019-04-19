<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class UserGroup extends BaseEntity
{
    /**
     * Группы пользователей (типы конфигураций)
     */
    const TABLE_NAME = 'users_groups';

    /**
     * @var string
     */
    protected $primary = 'id';

    /**
     * Комментарий к группе
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

    /**
     * 1 - по умолчанию при добавлении
     *
     * @var int
     */
    protected $isDefault;

    /**
     * @var array
     */
    protected $map = [
        'UGID' => 'id',
        'UGNAME' => 'name',
        'GRCOMMENT' => 'comment',
        'CODE' => 'code',
        'ISDEF' => 'isDefault'
    ];

    protected $_generators = [
        'id' => 'USERS_GROUPS_GEN'
    ];

    /**
     * @param string $name
     * @return UserGroup
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): UserGroup
    {
        if (mb_strlen($name) > 100) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = $name;

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
     * @return UserGroup
     * @throws UnprocessableEntityException
     */
    public function setComment(string $comment): UserGroup
    {
        if (mb_strlen($comment) > 1024) {
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
     * @return UserGroup
     * @throws UnprocessableEntityException
     */
    public function setCode(string $code): UserGroup
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
    public function getIsDefault(): bool
    {
        return $this->isDefault ? true : false;
    }

    /**
     * @param bool $isDefault
     * @return UserGroup
     */
    public function setIsDefault(bool $isDefault): UserGroup
    {
        $this->isDefault = $isDefault ? 1 : 0;

        return $this;
    }
}
