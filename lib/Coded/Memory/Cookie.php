<?php

namespace Coded\Memory;

class Cookie
{
    static function add(string $key, $data, int $expire = 0){
        if(isset($_COOKIE[$key])) return false;
        return static::set($key, $data, $expire);
    }

    static function set(string $key, $data, int $expire = 0){
        setcookie($key, serialize($data), $expire, '/');
        return true;
    }

    static function replace(string $key, $data, int $expire = 0){
        if(!isset($_COOKIE[$key])) return false;
        return static::set($key, $data, $expire);
    }

    static function get(string $key, &$found = null){
        if(!isset($_COOKIE[$key])) return $found = false;
        $found = true;
        return unserialize($_COOKIE[$key]);
    }

    static function delete(string $key){
        if(!isset($_COOKIE[$key])) return false;
        unset($_COOKIE[$key]);
        setcookie($key, '', time() - 3600, '/');
        return true;
    }
}