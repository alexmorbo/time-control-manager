<?php

namespace TimeControlManager\Entities;

use TimeControlManager\TimeControl;

class BaseEntity
{
    const TABLE_NAME = '';

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
    protected $_primary = null;

    /**
     * @var bool
     */
    protected $_isNew = true;

    public function __construct(array $data = [])
    {
        if (count($data)) {
            $this->load($data);
        }
    }

    public function __debugInfo() {
        $result = get_object_vars($this);

        unset($result['map']);
        unset($result['_generators']);
        unset($result['_primary']);
        unset($result['_isNew']);

        return $result;
    }

    public function load(array $data)
    {
        $this->_isNew = false;

        foreach ($data as $col => $val) {
            if (isset($this->map[$col])) {
                $key = &$this->map[$col];
                $this->$key = $val;
            }
        }
    }

    public function getMap(): array
    {
        return $this->map;
    }

    public static function getRealColumn($fakeColumn): string
    {
        $class = new static();
        $map = $class->getMap();
        $col = array_search($fakeColumn, $map);

        if (! $col) {
            throw new \RuntimeException('Column not found');
        }

        return $col;
    }

    public function save(): bool
    {
        $db = TimeControl::getInstance()->getDb();
        $pk = $this->_primary;

        try {
            if (! $this->_isNew) {
                // update
                $cols = [];
                $vals = [];
                foreach ($this->map as $realCol => $col) {
                    if ($col != $this->_primary) {
                        $cols[] = $realCol .' = :'.$col;
                        $vals[$col] = $this->$col;
                    }
                }

                $vals['_pk'] = $this->$pk;

                $query = sprintf(
                    'update %s set %s where %s = :_pk',
                    static::TABLE_NAME,
                    implode(', ', $cols),
                    self::getRealColumn($pk)
                );

                $st = $db->prepare($query);
                $st->execute($vals);

                return $st->rowCount() === 1;

            } else {
                // insert
                $cols = [];
                $colsToVals = [];
                $vals = [];
                foreach ($this->map as $realCol => $col) {
                    if (in_array($col, array_keys($this->_generators))) {
                        $cols[] = $realCol;
                        $colsToVals[] = sprintf('GEN_ID(%s,1)', $this->_generators[$col]);
                    } else {
                        if ($this->$col !== null) {
                            $cols[] = $realCol;
                            $colsToVals[] = ':' . $col;
                            $vals[$col] = $this->$col;
                        }
                    }
                }

                $query = sprintf(
                    'insert into %s (%s) values (%s)',
                    static::TABLE_NAME,
                    implode(', ', $cols),
                    implode(', ', $colsToVals)
                );


                $st = $db->prepare($query);
                $st->execute($vals);

                return $db->commit() === true;
            }
        } catch (\PDOException $e) {
            if ($db && $db->inTransaction()) {
                $db->rollback();
            }

            throw new \PDOException($e->getMessage());
        }
    }

    public function delete()
    {
        $db = TimeControl::getInstance()->getDb();
        $pk = $this->_primary;

        try {
            $query = sprintf(
                'delete from %s where %s = ?',
                static::TABLE_NAME,
                self::getRealColumn($pk)
            );

            $st = $db->prepare($query);
            $st->execute([$this->$pk]);

            return $st->rowCount() === 1;
        } catch (\PDOException $e) {
            if ($db && $db->inTransaction()) {
                $db->rollback();
            }

            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getPk(): string
    {
        $pk = $this->_primary;
        return $this->$pk;
    }

    public static function find($findParam = null, $column = 'id'): array
    {
        if (! $findParam) {
            $st = TimeControl::getInstance()->getDB()->query(
                sprintf('select * from %s', static::TABLE_NAME)
            );
        } else {
            $st = TimeControl::getInstance()->getDB()->prepare(
                sprintf('select * from %s where %s = ?', static::TABLE_NAME, self::getRealColumn($column))
            );
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
     * @param $findParam
     * @param string $column
     * @return BaseEntity|null
     */
    public static function findOne($findParam, $column = 'id'): ?BaseEntity
    {
        $st = TimeControl::getInstance()->getDB()->prepare(
            sprintf(
                'select * from %s where %s = ?',
                static::TABLE_NAME,
                static::getRealColumn($column)
            )
        );

        $st->execute([$findParam]);
        $row = $st->fetch();

        return $row ? new static($row) : null;
    }
}