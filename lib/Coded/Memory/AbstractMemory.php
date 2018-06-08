<?php

namespace Coded\Memory;

abstract class AbstractMemory
{
    const VARIABLE = null;

    public $hits = 0;
    public $misses = 0;

    abstract function setMemory(string $key, $data, int $expire = 0);

    abstract function getMemory(string $key);

    abstract function deleteMemory(string $key);

    abstract function flashMemory();

    abstract protected function exists(string $key);

    static function status()
    {
        return (isset($GLOBALS[static::VARIABLE]) and get_class($GLOBALS[static::VARIABLE]) == static::class);
    }

    static function add(string $key, $data, int $expire = 0)
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        $var = &$GLOBALS[static::VARIABLE];

        if ($var->exists($key)) return false;
        return $var->setMemory($key, $data, $expire);
    }

    static function set(string $key, $data, int $expire = 0)
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        return $GLOBALS[static::VARIABLE]->setMemory($key, $data, $expire);
    }

    static function replace(string $key, $data, int $expire = 0)
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        $var = &$GLOBALS[static::VARIABLE];
        if (!$var->exists($key)) return false;

        return $var->setMemory($key, $data, $expire);
    }

    static function get(string $key, &$found = null)
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        $var = &$GLOBALS[static::VARIABLE];

        if ($var->exists($key)) {
            $found = true;
            $var->hits += 1;
            return $var->getMemory($key);
        }

        $found = false;
        $var->misses += 1;
        return false;
    }

    static function delete(string $key)
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');

        return $GLOBALS[static::VARIABLE]->deleteMemory($key);
    }

    static function flush()
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        return $GLOBALS[static::VARIABLE]->flashMemory();
    }

    static function getObject()
    {
        if (!static::status()) throw new \Exception(static::class . ' object is not defined.');
        return $GLOBALS[static::VARIABLE];
    }

    static function init($data = null)
    {
        if (static::status()) throw new \Exception(static::class . ' object is already defined.');
        $class = static::class;
        $GLOBALS[static::VARIABLE] = new $class($data);
        return true;
    }
}