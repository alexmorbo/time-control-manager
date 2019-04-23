<?php

namespace TimeControlManager\Entities;

use TimeControlManager\Exceptions\UnprocessableEntityException;

class Directory extends BaseEntity
{
    /**
     * Мастер таблица спрачников
     */
    const TABLE_NAME = 'dictlist';

    /**
     * Заголовок справочника
     *
     * @var string
     */
    protected $title;

    /**
     * Описание справочника
     *
     * @var string
     */
    protected $description;

    /**
     * Использовать дополнительный код
     *
     * @var int
     */
    protected $useSecondaryCode;

    /**
     * Использовать дополнительное наименование
     *
     * @var int
     */
    protected $useSecondaryName;

    /**
     * Использовать цвет
     *
     * @var int
     */
    protected $useColor;

    /**
     * Использовать код
     *
     * @var int
     */
    protected $useCode;

    /**
     * Использовать значение по умолчанию
     *
     * @var int
     */
    protected $useDefault;

    /**
     * Использовать иконку
     *
     * @var int
     */
    protected $useIcon;

    /**
     * 1 - Используется коефициент
     *
     * @var int
     */
    protected $useRatio;

    /**
     * @var array
     */
    protected $map = [
        'DICTID' => 'id',
        'DICTNAME' => 'name',
        'DICTCAPTION' => 'title',
        'DICTDISCRIPTION' => 'description',
        'USEKOD2' => 'useSecondaryCode',
        'USENAME2' => 'useSecondaryName',
        'USECOLOR' => 'useColor',
        'USEKOD' => 'useCode',
        'USEDEFAULT' => 'useDefault',
        'USEIMAGEINDEX' => 'useIcon',
        'USEKOEF' => 'useRatio'
    ];

    /**
     * @var array
     */
    protected $_generators = [
        'id' => 'DICTLIST_GEN',
    ];

    /**
     * @param string $name
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setName(string $name): Directory
    {
        if (mb_strlen($name) > 20) {
            throw new UnprocessableEntityException('Name too long');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setTitle(string $title): Directory
    {
        if (mb_strlen($title) > 255) {
            throw new UnprocessableEntityException('Title too long');
        }

        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setDescription(string $description): Directory
    {
        if (mb_strlen($description) > 512) {
            throw new UnprocessableEntityException('Description too long');
        }

        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseSecondaryCode(): int
    {
        return $this->useSecondaryCode;
    }

    /**
     * @param int $useSecondaryCode
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseSecondaryCode(int $useSecondaryCode): Directory
    {
        if ($useSecondaryCode < -32768 || $useSecondaryCode > 32767) {
            throw new UnprocessableEntityException('UseSecondaryCode invalid');
        }

        $this->useSecondaryCode = $useSecondaryCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseSecondaryName(): int
    {
        return $this->useSecondaryName;
    }

    /**
     * @param int $useSecondaryName
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseSecondaryName(int $useSecondaryName): Directory
    {
        if ($useSecondaryName < -32768 || $useSecondaryName > 32767) {
            throw new UnprocessableEntityException('UseSecondaryName invalid');
        }

        $this->useSecondaryName = $useSecondaryName;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseColor(): int
    {
        return $this->useColor;
    }

    /**
     * @param int $useColor
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseColor(int $useColor): Directory
    {
        if ($useColor < -32768 || $useColor > 32767) {
            throw new UnprocessableEntityException('UseColor invalid');
        }

        $this->useColor = $useColor;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseCode(): int
    {
        return $this->useCode;
    }

    /**
     * @param int $useCode
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseCode(int $useCode): Directory
    {
        if ($useCode < -32768 || $useCode > 32767) {
            throw new UnprocessableEntityException('UseCode invalid');
        }

        $this->useCode = $useCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseDefault(): int
    {
        return $this->useDefault;
    }

    /**
     * @param int $useDefault
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseDefault(int $useDefault): Directory
    {
        if ($useDefault < -32768 || $useDefault > 32767) {
            throw new UnprocessableEntityException('UseDefault invalid');
        }

        $this->useDefault = $useDefault;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseIcon(): int
    {
        return $this->useIcon;
    }

    /**
     * @param int $useIcon
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseIcon(int $useIcon): Directory
    {
        if ($useIcon < -32768 || $useIcon > 32767) {
            throw new UnprocessableEntityException('UseIcon invalid');
        }

        $this->useIcon = $useIcon;

        return $this;
    }

    /**
     * @return int
     */
    public function getUseRatio(): int
    {
        return $this->useRatio;
    }

    /**
     * @param int $useRatio
     * @return Directory
     * @throws UnprocessableEntityException
     */
    public function setUseRatio(int $useRatio): Directory
    {
        if ($useRatio < -32768 || $useRatio > 32767) {
            throw new UnprocessableEntityException('UseRatio invalid');
        }

        $this->useRatio = $useRatio;

        return $this;
    }

    /**
     * @return DirectoryData[]|null
     */
    public function getData(): array
    {
        return DirectoryData::find($this->id, 'directoryId');
    }
}
