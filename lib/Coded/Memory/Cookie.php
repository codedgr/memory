<?php

namespace Coded\Memory;

class Cookie
{
    static function add(string $key, $data, int $expire = 0){
        if(isset($_COOKIE[$key])) return false;
        return static::set($key, $data, $expire);
    }

    static function set(string $key, $data, int $expire = 0){
        return setcookie($key, serialize($data), $expire, '/');
    }

    static function replace(string $key, $data, int $expire = 0){
        if(!isset($_COOKIE[$key])) return false;
        return static::set($key, $data, $expire);
    }

    static function get(string $key, &$found = false){
        if(!isset($_COOKIE[$key])) return null;
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