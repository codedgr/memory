<?php

namespace Coded\Memory;

class Database extends AbstractMemory
{
    const VARIABLE = '_coded_cache_session';

    private $pdo;
    private $lastStmt;
    private $table;

    function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->table = defined('DATABASE_CACHE_TABLE') ? DATABASE_CACHE_TABLE : 'cache';
    }

    function createTable()
    {
        $this->pdo->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (`key` varchar(255) NOT NULL, `value` longtext NULL, `expire` int(11) NULL, PRIMARY KEY (`key`));");
    }

    function dropTable()
    {
        $this->pdo->query("DROP TABLE IF EXISTS `{$this->table}`;");
    }

    function truncateTable()
    {
        $this->pdo->query("TRUNCATE TABLE `{$this->table}`");
    }

    public function setMemory(string $key, $data, int $expire = 0)
    {
        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`key`, `value`, `expire`) VALUES ( ?, ?, ?) ON DUPLICATE KEY UPDATE `key`=VALUES(`key`), `value`=VALUES(`value`), `expire`=VALUES(`expire`);");
        return $stmt->execute([$key, serialize($data), $expire]);
    }

    public function getMemory(string $key)
    {
        if (!$this->exists($key)) return false;
        return unserialize($this->lastStmt->fetchColumn());
    }

    public function deleteMemory(string $key)
    {
        if (!$this->exists($key)) return false;
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `key` = ?;");
        $stmt->execute([$key]);
        return true;
    }

    public function flashMemory()
    {
        $this->truncateTable();
        return true;
    }

    protected function exists(string $key)
    {
        $stmt = $this->pdo->prepare("SELECT `value` FROM `{$this->table}` WHERE `key` = ? and (`expire` = 0 or `expire` > ?);");
        $stmt->execute([$key, time()]);

        if(!$stmt->rowCount()) return false;

        $this->lastStmt = $stmt;
        return true;
    }
}