<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class AccessProfileData extends BaseEntity
{
    /**
     * Детализация профилей доступа
     */
    const TABLE_NAME = 'PROFILES_ACCESS_DET';

    /**
     * @var string
     */
    protected $primary = 'id';


    /**
     * Код профиля доступа
     *
     * @var int
     */
    protected $accessProfileId;

    /**
     * Код проходной
     *
     * @var int
     */
    protected $doorId;

    /**
     * Режим прохода 0 - доступ открыт 1 - доступ закрыт
     *
     * @var int
     */
    protected $accessEnabled;

    /**
     * Тип идентификации
     *
     * @var int
     */
    protected $identType;

    /**
     * @var array
     */
    protected $map = [
        'PDETID' => 'id',
        'DPID' => 'accessProfileId',
        'DOORID' => 'doorId',
        'ENTERMODE' => 'accessEnabled',
        'IDENT_TYPE' => 'identType',
    ];

    /**
     * @var array
     */
    protected $_generators = [
        'id' => 'PROFILES_ACCESS_DET_GEN'
    ];

    /**
     * @return int
     */
    public function getAccessProfileId(): int
    {
        return $this->accessProfileId;
    }

    /**
     * @return AccessProfile
     */
    public function getAccessProfile(): ?AccessProfile
    {
        return AccessProfile::findOne($this->accessProfileId);
    }

    /**
     * @param int $accessProfileId
     * @return AccessProfileData
     */
    public function setAccessProfileId(int $accessProfileId): AccessProfileData
    {
        $this->accessProfileId = $accessProfileId;

        return $this;
    }

    /**
     * @param AccessProfile $accessProfile
     * @return AccessProfileData
     */
    public function setAccessProfile(AccessProfile $accessProfile): AccessProfileData
    {
        $this->accessProfileId = $accessProfile->getId();

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
     * @return Door
     */
    public function getDoor(): ?Door
    {
        return Door::findOne($this->doorId);
    }

    /**
     * @param int $doorId
     * @return AccessProfileData
     */
    public function setDoorId(int $doorId): AccessProfileData
    {
        $this->doorId = $doorId;

        return $this;
    }

    /**
     * @param Door $door
     * @return AccessProfileData
     */
    public function setDoor(Door $door): AccessProfileData
    {
        $this->doorId = $door->getId();

        return $this;
    }

    /**
     * @return bool
     */
    public function getAccessEnabled(): bool
    {
        return $this->accessEnabled ? false : true;
    }

    /**
     * @param bool $accessEnabled
     * @return AccessProfileData
     */
    public function setAccessEnabled(bool $accessEnabled): AccessProfileData
    {
        $this->accessEnabled = $accessEnabled ? false : true;

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
     * @return AccessProfileData
     * @throws UnprocessableEntityException
     */
    public function setIdentType(int $identType): AccessProfileData
    {
        switch ($identType) {
            case AccessProfile::IDENT_TYPE_PASSWORD:
            case AccessProfile::IDENT_TYPE_CARD:
            case AccessProfile::IDENT_TYPE_FINGERPRINT:

            case AccessProfile::IDENT_TYPE_CARD_OR_FINGERPRINT:
            case AccessProfile::IDENT_TYPE_CARD_OR_FINGERPRINT_OR_PASSWORD:

            case AccessProfile::IDENT_TYPE_CARD_AND_FINGERPRINT:
            case AccessProfile::IDENT_TYPE_CARD_AND_PASSWORD:
            case AccessProfile::IDENT_TYPE_FINGERPRINT_AND_PASSWORD:
                $this->identType = (int) $identType;
                break;
            default:
                throw new UnprocessableEntityException('Gender invalid');
        }

        return $this;
    }
}
