# Memory
This library helps you to store temporary data in your memory, database, cookie or session. Use it to cache data to improve the speed of your script.

## Install
Using Composer
```
"require": {
    "codedgr/memory": "~1.0"
}
```

## Store data to memory, session, database or cookie

Initialize the memory. Note that cookie does not need to initialized.
```
Ram::init();
Session::init();
Database::init($pdo);
```
Add data to the cache if the cache `$key` doesn't already exist. If it does exist, the data is not added and the function returns `false`.
```
Ram::add($key, $data, $expire);
Session::add($key, $data, $expire);
Database::add($key, $data, $expire);
Cookie::add($key, $data, $expire);
```
Add data to the cache.  If the cache `$key` already exists, then it will be overwritten; if not then it will be created.
```
Ram::set($key, $data, $expire);
Session::set($key, $data, $expire);
Database::set($key, $data, $expire);
Cookie::set($key, $data, $expire);
```
Replaces the given cache if it exists, returns `false` otherwise.
```
Ram::replace($key, $expire, $group);
Session::replace($key, $expire, $group);
Database::replace($key, $expire, $group);
Cookie::replace($key, $expire, $group);
```
Get the value of the cached object, or `false` if the cache `$key` doesn't exist.

To disambiguate a cached `false` from a non-existing `$key`, you should do absolute testing of `$found`, which is passed by reference, against `false`: if `$found === false`, the key does not exist.
```
Ram::get($key, $expire, &$found = null);
Session::get($key, $expire, &$found = null);
Database::get($key, $expire, &$found = null);
Cookie::get($key, $expire, &$found = null);
```
Clears data from the cache for the given `$key`.
```
Ram::delete($key, $expire);
Session::delete($key, $expire);
Database::delete($key, $expire);
Cookie::delete($key, $expire);
```
Clears all cached data. Note that you can't flash the cookie memory.
```
Ram::flush();
Session::flush();
Database::flush();
```