<?php

namespace TimeControlManager\Entities;

use function mb_strlen;
use TimeControlManager\Exceptions\UnprocessableEntityException;

/**
 * Class AccessProfile
 * @package TimeControlManager\Entities
 */
class AccessProfile extends BaseEntity
{
    const TABLE_NAME = 'profiles_access';

    const IDENT_TYPE_PASSWORD = 1;
    const IDENT_TYPE_CARD = 2;
    const IDENT_TYPE_FINGERPRINT = 3;

    const IDENT_TYPE_CARD_OR_FINGERPRINT = 4;
    const IDENT_TYPE_CARD_OR_FINGERPRINT_OR_PASSWORD = 5;

    const IDENT_TYPE_CARD_AND_FINGERPRINT = 6;
    const IDENT_TYPE_CARD_AND_PASSWORD = 7;
    const IDENT_TYPE_FINGERPRINT_AND_PASSWORD = 8;

    /**
     * По умолчанию доступ закрыт
     *
     * @var int
     */
    protected $defaultClose;

    /**
     * Тип идентификации
     *
     * @var int
     */
    protected $identType;

    /**
     * Текстовый код
     *
     * @var string
     */
    protected $code;

    /**
     * По умолчанию
     *
     * @var int
     */
    protected $isDefault;

    /**
     * @var array
     */
    protected $map = [
        'DPID' => 'id',
        'DPNAME' => 'name',
        'ENTERCLOSE' => 'defaultClose',
        'IDENT_TYPE' => 'identType',
        'CODE' => 'code',
        'ISDEFAULT' => 'isDefault',
    ];

    /**
     * @var array
     */
    protected $_generators = [
        'id' => 'PROFILES_ACCESS_GEN'
    ];

    /**
     * @param string $name
     * @return AccessProfile
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): self
    {
        if (mb_strlen($name) > 128) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDefaultClose(): bool
    {
        return isset($this->defaultClose);
    }

    /**
     * @param bool $defaultClose
     * @return AccessProfile
     */
    public function setDefaultClose(bool $defaultClose): AccessProfile
    {
        $this->defaultClose = $defaultClose;

        return $this;
    }

    /**
     * @return int
     */
    public function getIdentType(): int
    {
        return $this->identType;
    }

    /**
     * @param int $identType
     * @return AccessProfile
     * @throws UnprocessableEntityException
     */
    public function setIdentType(int $identType): AccessProfile
    {
        switch ($identType) {
            case static::IDENT_TYPE_PASSWORD:
            case static::IDENT_TYPE_CARD:
            case static::IDENT_TYPE_FINGERPRINT:

            case static::IDENT_TYPE_CARD_OR_FINGERPRINT:
            case static::IDENT_TYPE_CARD_OR_FINGERPRINT_OR_PASSWORD:

            case static::IDENT_TYPE_CARD_AND_FINGERPRINT:
            case static::IDENT_TYPE_CARD_AND_PASSWORD:
            case static::IDENT_TYPE_FINGERPRINT_AND_PASSWORD:
                $this->identType = (int) $identType;
            break;
            default:
                throw new UnprocessableEntityException('Gender invalid');
        }

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
     * @return AccessProfile
     * @throws UnprocessableEntityException
     */
    public function setCode(string $code): AccessProfile
    {
        if (mb_strlen($code) > 20) {
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
        return isset($this->isDefault);
    }

    /**
     * @param bool $isDefault
     * @return AccessProfile
     */
    public function setIsDefault(bool $isDefault): AccessProfile
    {
        $this->isDefault = $isDefault;

        return $this;
    }
}
