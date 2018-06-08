<?php

namespace Coded\Memory;

class Session extends AbstractMemory
{
    const VARIABLE = '_coded_cache_session';
    const EXPIRE = '_coded_cache_session_expire';

    public function setMemory(string $key, $data, int $expire = 0)
    {
        if (is_object($data)) $data = clone $data;

        $_SESSION[static::VARIABLE][$key] = $data;
        $_SESSION[static::EXPIRE][$key] = $expire;
        return true;
    }

    public function getMemory(string $key)
    {
        if (!$this->exists($key)) return false;

        if (is_object($_SESSION[static::VARIABLE][$key]))
            return clone $_SESSION[static::VARIABLE][$key];
        else
            return $_SESSION[static::VARIABLE][$key];
    }

    public function deleteMemory(string $key)
    {
        if (!$this->exists($key)) return false;
        unset($_SESSION[static::VARIABLE][$key]);
        unset($_SESSION[static::EXPIRE][$key]);
        return true;
    }

    public function flashMemory()
    {
        $_SESSION[static::VARIABLE] = [];
        $_SESSION[static::EXPIRE] = [];
        return true;
    }

    protected function exists(string $key)
    {
        if(!isset($_SESSION[static::VARIABLE][$key]) or !isset($_SESSION[static::EXPIRE][$key])) return false;
        if($_SESSION[static::EXPIRE][$key]==0 or $_SESSION[static::EXPIRE][$key]>time()) return true;
        $this->deleteMemory($key);
        return false;
    }
}