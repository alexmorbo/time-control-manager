<?php

namespace TimeControlManager\Entities;

class BaseEntity
{
    /**
     * @var array
     */
    protected $map = [];

    public function __construct(array $data = [])
    {
        $this->load($data);
    }

    public function load(array $data)
    {
        d($data);
        foreach ($data as $col => $val) {
            if (isset($this->map[$col])) {
                $key = &$this->map[$col];
                $this->$key = $val;
            }
        }
    }
}