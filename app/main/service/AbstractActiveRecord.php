<?php

namespace service;

use Application;
use PDO;

abstract class AbstractActiveRecord
{
    public static function getConnection()
    {
        $driver = Application::$config['db']['driver'];
        $host = Application::$config['db']['host'];
        $dbname = Application::$config['db']['dbname'];
        $username = Application::$config['db']['username'];
        $password = Application::$config['db']['password'];

        return new PDO("$driver:host=$host;dbname=$dbname", $username, $password);
    }

    public static function getTableName()
    {
        return strtolower(substr(strrchr(static::class, "\\"), 1));
    }

    public static function getEntityClassName()
    {
        return static::class;
    }

    public function create()
    {
        $entity = $this;
        $columns = "";
        $values = "";
        $fields = array_keys((array) $entity);
        unset($fields['id']);
        foreach ($fields as $field) {
            if (!empty($columns)) {
                $columns .= ",";
                $values .= ",";
            }
            $columns .= " `$field`";
            $values .= " :$field";
        }

        $dbh = static::getConnection();
        $table = static::getTableName();
        $stmt = $dbh->prepare("INSERT INTO `$table` ($columns) VALUES ($values)");

        foreach ($fields as $field) {
            $stmt->bindParam(":$field", $entity->$field);
        }

        $stmt->execute();
        $entity->id = $dbh->lastInsertId();
        $stmt = null;
        $dbh = null;
    }

    public function update($fields = [])
    {
        $entity = $this;
        $update = "";
        if (empty($fields)) {
            $fields = array_keys((array) $entity);
            unset($fields['id']);
        }
        foreach ($fields as $field) {
            if (!empty($update)) {
                $update .= ",";
            }
            $update .= " `$field` = :$field";
        }

        $dbh = static::getConnection();
        $table = static::getTableName();
        $stmt = $dbh->prepare("UPDATE `$table` SET $update WHERE `id` = :id");

        foreach ($fields as $field) {
            $stmt->bindParam(":$field", $entity->$field);
        }
        $stmt->bindParam(':id', $entity->id);

        $stmt->execute();
        $stmt = null;
        $dbh = null;
    }

    public static function count($param = [])
    {
        $where = static::makeWhere($param);

        $dbh = static::getConnection();
        $table = static::getTableName();
        $stmt = $dbh->prepare("SELECT COUNT(*) FROM `$table`" . $where);

        $count = 0;
        if ($stmt->execute()) {
            $count = $stmt->fetchColumn();
        }
        $stmt = null;
        $pdo = null;

        return $count;
    }

    public static function findAll($offset = null, $limit = null)
    {
        return static::find([], $offset, $limit);
    }

    public static function find($param = [], $offset = null, $limit = null)
    {
        $tail = is_null($limit) ? "" : " LIMIT :limit";
        $tail .= is_null($offset) ? "" : " OFFSET :offset";

        $where = static::makeWhere($param);

        $dbh = static::getConnection();
        $table = static::getTableName();
        $stmt = $dbh->prepare("SELECT * FROM `$table`" . $where . $tail);

        if (!is_null($limit)) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        if (!is_null($offset)) {
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }

        $entities = [];
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $class = static::getEntityClassName();
                $entities[] = new $class($row);
            }
        }
        $stmt = null;
        $pdo = null;

        return $entities;
    }

    public static function findOne($param = [])
    {
        $where = static::makeWhere($param);

        $dbh = static::getConnection();
        $table = static::getTableName();
        $stmt = $dbh->prepare("SELECT * FROM `$table`" . $where . " LIMIT 1");

        foreach ($param as $key => $value) {
            $stmt->bindParam(":$key", $value);
        }

        $entity = null;
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($row)) {
                $class = static::getEntityClassName();
                $entity = new $class($row);
            }
        }
        $stmt = null;
        $pdo = null;

        return $entity;
    }

    protected static function makeWhere($param = [])
    {
        $where = "";
        if (!empty($param)) {
            $where = " WHERE";
            foreach ($param as $key => $value) {
                $where .= " `$key` = :$key";
            }
        }
        return $where;
    }
}