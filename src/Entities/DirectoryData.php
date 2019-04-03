<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class DirectoryData extends BaseEntity
{
    /**
     * Детальная таблица справочников
     */
    const TABLE_NAME = 'dictlist_det';

    protected $_primary = 'id';

    /**
     * Код записи справочника
     *
     * @var int
     */
    protected $id;

    /**
     * Код справочника
     *
     * @var int
     */
    protected $directoryId;

    /**
     * Значение наименования
     *
     * @var string
     */
    protected $value;

    /**
     * Значение код
     *
     * @var string
     */
    protected $code;

    /**
     * Значение дополнительного кода
     *
     * @var string
     */
    protected $secondaryCode;

    /**
     * Значение дополнительного наименования
     *
     * @var string
     */
    protected $secondaryValue;

    /**
     * Значение цвет
     *
     * @var int
     */
    protected $color;

    /**
     * Индекс иконки
     *
     * @var int
     */
    protected $imageIndex;

    /**
     * 1 - Значение по умолчанию
     *
     * @var int
     */
    protected $defaultValue;

    /**
     * Значение коефициента
     *
     * @var float
     */
    protected $ratio;

    /**
     * Профиль учета рабочего времени по умолчанию для справочника должностей
     *
     * @var int
     */
    protected $pid;

    protected $map = [
        'ID' => 'id',
        'DICTID' => 'directoryId',
        'DICTVALUE' => 'value',
        'CODE' => 'code',
        'CODE2' => 'secondaryCode',
        'DICTVALUE2' => 'secondaryValue',
        'VCOLOR' => 'color',
        'VIMAGEINDEX' => 'imageIndex',
        'VDEFAULT' => 'defaultValue',
        'KOEFVALUE' => 'ratio',
        'PID' => 'pid'
    ];

    /**
     * @var array
     */
    protected $_generators = [
        'id' => 'DICTLIST_DET_GEN',
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
    public function getDirectoryId(): int
    {
        return $this->directoryId;
    }

    /**
     * @return Directory|null
     */
    public function getDirectory(): ?Directory
    {
        return Directory::findOne($this->directoryId);
    }

    /**
     * @param int $directoryId
     * @return DirectoryData
     */
    public function setDirectoryId(int $directoryId): DirectoryData
    {
        $this->directoryId = $directoryId;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return DirectoryData
     * @throws UnprocessableEntityException
     */
    public function setValue(string $value): DirectoryData
    {
        if (mb_strlen($value) > 512) {
            throw new UnprocessableEntityException('Value too long');
        }

        $this->value = $value;

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
     * @return DirectoryData
     * @throws UnprocessableEntityException
     */
    public function setCode(string $code): DirectoryData
    {
        if (mb_strlen($code) > 20) {
            throw new UnprocessableEntityException('Code too long');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryCode(): string
    {
        return $this->secondaryCode;
    }

    /**
     * @param string $secondaryCode
     * @return DirectoryData
     * @throws UnprocessableEntityException
     */
    public function setSecondaryCode(string $secondaryCode): DirectoryData
    {
        if (mb_strlen($secondaryCode) > 20) {
            throw new UnprocessableEntityException('SecondaryCode too long');
        }

        $this->secondaryCode = $secondaryCode;


        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryValue(): string
    {
        return $this->secondaryValue;
    }

    /**
     * @param string $secondaryValue
     * @return DirectoryData
     * @throws UnprocessableEntityException
     */
    public function setSecondaryValue(string $secondaryValue): DirectoryData
    {
        if (mb_strlen($secondaryValue) > 512) {
            throw new UnprocessableEntityException('SecondaryValue too long');
        }

        $this->secondaryValue = $secondaryValue;

        return $this;
    }

    /**
     * @return int
     */
    public function getColor(): int
    {
        return $this->color;
    }

    /**
     * @param int $color
     * @return DirectoryData
     */
    public function setColor(int $color): DirectoryData
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return int
     */
    public function getImageIndex(): int
    {
        return $this->imageIndex;
    }

    /**
     * @param int $imageIndex
     * @return DirectoryData
     */
    public function setImageIndex(int $imageIndex): DirectoryData
    {
        $this->imageIndex = $imageIndex;

        return $this;
    }

    /**
     * @return int
     */
    public function getDefaultValue(): int
    {
        return $this->defaultValue;
    }

    /**
     * @param int $defaultValue
     * @return DirectoryData
     * @throws UnprocessableEntityException
     */
    public function setDefaultValue(int $defaultValue): DirectoryData
    {
        if ($defaultValue < -32768 || $defaultValue > 32767) {
            throw new UnprocessableEntityException('DefaultValue invalid');
        }

        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * @param float $ratio
     * @return DirectoryData
     */
    public function setRatio(float $ratio): DirectoryData
    {
        $this->ratio = $ratio;

        return $this;
    }

    /**
     * @return int
     */
    public function getPid(): int
    {
        return $this->pid;
    }

    /**
     * @param int $pid
     * @return DirectoryData
     */
    public function setPid(int $pid): DirectoryData
    {
        $this->pid = $pid;

        return $this;
    }
}