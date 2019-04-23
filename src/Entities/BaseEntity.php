<?php

namespace TimeControlManager\Entities;

use function count;
use function get_object_vars;
use function implode;
use PDOException;
use RuntimeException;
use function sprintf;
use TimeControlManager\TimeControl;

/**
 * Class BaseEntity
 * @package TimeControlManager\Entities
 */
class BaseEntity
{
    const TABLE_NAME = '';
    const SQL_UPDATE_WHERE = 'update %s set %s where %s = :_pk';
    const SQL_INSERT_VALUES = 'insert into %s (%s) values (%s)';
    const SQL_DELETE_WHERE = 'delete from %s where %s = ?';
    const SQL_SELECT = 'select * from %s';
    const SQL_SELECT_WHERE = 'select * from %s where %s = ?';

    /**
     * Идентификатор
     *
     * @var int
     */
    protected $id;

    /**
     * Название профиля
     *
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $_generators = [];

    /**
     * @var array
     */
    protected $map = [];

    /**
     * @var string
     */
    protected $primary = 'id';

    /**
     * @var bool
     */
    protected $_isNew = true;

    /**
     * BaseEntity constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (count($data)) {
            $this->load($data);
        }
    }

    /**
     * @param int $id
     *
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     * @return array
     */
    public function __debugInfo(): array
    {
        $result = get_object_vars($this);

        return $this->sanitizeResult($result);
    }

    /**
     * @return array
     */
    public function getMap(): array
    {
        return $this->map;
    }

    /**
     * @param $fakeColumn
     *
     * @return string
     */
    public static function getRealColumn($fakeColumn): string
    {
        $class = new static();
        $map = $class->getMap();
        $col = array_search($fakeColumn, $map);

        if (!$col) {
            throw new RuntimeException('Column not found');
        }

        return $col;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $db = TimeControl::getInstance()->getDb();

        try {
            if (!$this->_isNew) {
                // update
                $cols = [];
                $vals = [];
                foreach ($this->map as $realCol => $col) {
                    if ($col != $this->primary) {
                        $cols[] = $realCol . ' = :' . $col;
                        $vals[$col] = $this->{$col};
                    }
                }

                $vals['_pk'] = $this->{$this->primary};

                $query = sprintf(self::SQL_UPDATE_WHERE, static::TABLE_NAME, implode(', ', $cols), self::getRealColumn($this->primary));

                $st = $db->prepare($query);
                $st->execute($vals);
                $this->id = $db->lastInsertId();

                return $st->rowCount() === 1;
            }
            // insert
            $cols = [];
            $colsToVals = [];
            $vals = [];
            foreach ($this->map as $realCol => $col) {
                if (in_array($col, array_keys($this->_generators))) {
                    $cols[] = $realCol;
                    $colsToVals[] = sprintf('GEN_ID(%s,1)', $this->_generators[$col]);
                } else {
                    if ($this->{$col} !== null) {
                        $cols[] = $realCol;
                        $colsToVals[] = ':' . $col;
                        $vals[$col] = $this->$col;
                    }
                }
            }

            $query = sprintf(self::SQL_INSERT_VALUES, static::TABLE_NAME, implode(', ', $cols), implode(', ', $colsToVals));


            $st = $db->prepare($query);
            $st->execute($vals);

            return $db->commit() === true;
        } catch (PDOException $e) {
            if ($db && $db->inTransaction()) {
                $db->rollback();
            }

            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $db = TimeControl::getInstance()->getDb();
        $pk = $this->primary;

        try {
            $query = sprintf(self::SQL_DELETE_WHERE, static::TABLE_NAME, self::getRealColumn($pk));

            $st = $db->prepare($query);
            $st->execute([$this->$pk]);

            return $st->rowCount() === 1;
        } catch (PDOException $e) {
            if ($db && $db->inTransaction()) {
                $db->rollback();
            }

            throw new PDOException($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getPk(): string
    {
        $pk = $this->primary;
        return $this->$pk;
    }

    /**
     * @param null   $findParam
     * @param string $column
     *
     * @return array
     */
    public static function find($findParam = null, $column = 'id'): array
    {
        if (!$findParam) {
            $st = TimeControl::getInstance()->getDB()->query(sprintf(self::SQL_SELECT, static::TABLE_NAME));
        } else {
            $st = TimeControl::getInstance()->getDB()->prepare(sprintf(self::SQL_SELECT_WHERE, static::TABLE_NAME, self::getRealColumn($column)));
            $st->execute([$findParam]);
        }

        $entities = [];
        while ($row = $st->fetch()) {
            $entity = new static($row);
            $entities[$entity->getPk()] = $entity;
        }

        return $entities;
    }

    /**
     * @param        $findParam
     * @param string $column
     *
     * @return static|null
     */
    public static function findOne($findParam, $column = 'id')
    {
        $st = TimeControl::getInstance()->getDB()->prepare(sprintf(self::SQL_SELECT_WHERE, static::TABLE_NAME, static::getRealColumn($column)));

        $st->execute([$findParam]);
        $row = $st->fetch();
        if (empty($row)) {
            return null;
        }
        return new static($row);
    }

    /**
     * @param array $data
     */
    protected function load(array $data): void
    {
        $this->_isNew = false;
        foreach ($data as $col => $val) {
            if (isset($this->map[$col])) {
                $key = &$this->map[$col];
                $this->{$key} = $val;
            }
        }
    }

    /**
     * @param array $result
     *
     * @return array
     */
    private function sanitizeResult(array $result): array
    {
        unset($result['map']);
        unset($result['_generators']);
        unset($result['_primary']);
        unset($result['_isNew']);

        return $result;
    }
}
