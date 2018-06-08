<?php

namespace Coded\Memory;

class Ram extends AbstractMemory
{
    const VARIABLE = '_coded_cache_ram';

    private $cache = [];
    private $expire = [];

    public function setMemory(string $key, $data, int $expire = 0)
    {
        if (is_object($data)) $data = clone $data;

        $this->cache[$key] = $data;
        $this->expire[$key] = $expire;
        return true;
    }

    public function getMemory(string $key)
    {
        if (!$this->exists($key)) return false;

        if (is_object($this->cache[$key]))
            return clone $this->cache[$key];
        else
            return $this->cache[$key];
    }

    public function deleteMemory(string $key)
    {
        if (!$this->exists($key)) return false;
        unset($this->cache[$key]);
        unset($this->expire[$key]);
        return true;
    }

    public function flashMemory()
    {
        $this->cache = [];
        $this->expire = [];
        return true;
    }

    protected function exists(string $key)
    {
        if(!isset($this->cache[$key]) or !isset($this->cache[$key])) return false;
        if($this->cache[$key]==0 or $this->cache[$key]>time()) return true;
        $this->deleteMemory($key);
        return false;
    }
}