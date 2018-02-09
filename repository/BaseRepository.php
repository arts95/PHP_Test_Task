<?php
/**
 * @author: Arsenii Andrieiev
 * Date: 08.02.18
 */

namespace repository;

use entity\BaseEntity;
use service\DatabaseTrait;

class BaseRepository
{
    use DatabaseTrait;

    public static function findAll(string $tableName): array
    {
        $result = self::getDb()->getConnection()->query("SELECT * FROM {$tableName} WHERE 1");
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $result->free();
        }
        return $data;
    }

    public static function findOne(string $tableName, string $primaryKey, int $id): ?array
    {
        $statement = self::getDb()->getConnection()->prepare('SELECT * FROM ' . $tableName . ' WHERE  ' . $primaryKey . ' = ? LIMIT 1');
        if (!$statement) {
            die("SQL Error: {" . self::getDb()->getConnection()->errno . " } - {" . self::getDb()->getConnection()->error . "}");
        }
        $statement->bind_param('s', $id);
        $statement->execute();
        $data = $statement->get_result()->fetch_assoc();
        $statement->close();
        return $data;
    }

    public static function save(BaseEntity $entity, array $data)
    {
        $length = count($data);
        $fieldsToInsert = ' (' . implode(', ', array_keys($data)) . ') ';
        $statement = self::getDb()->getConnection()->prepare("INSERT INTO " . $entity::getTableName() . $fieldsToInsert . " VALUES(" . substr(str_repeat('?,', $length), 0, -1) . ")");
        if (!$statement) {
            die("SQL Error: {" . self::getDb()->getConnection()->errno . " } - {" . self::getDb()->getConnection()->error . "}");
        }
        $statement->bind_param(str_repeat('s', $length), ...array_values($data));
        $statement->execute();
        return $statement->insert_id;
    }

    public static function delete(string $tableName, string $primaryKey, int $id)
    {
        $statement = self::getDb()->getConnection()->prepare("DELETE FROM {$tableName} WHERE {$primaryKey} = ?");
        if (!$statement) {
            die("SQL Error: {" . self::getDb()->getConnection()->errno . " } - {" . self::getDb()->getConnection()->error . "}");
        }
        $statement->bind_param('s', $id);
        $statement->execute();
        return $statement->affected_rows;
    }

    public static function update(BaseEntity $entity, int $id, array $data)
    {
        $length = count($data);
        $updates = [];
        $sql = "UPDATE " . $entity::getTableName() . " SET ";
        foreach ($data as $field => $value) {
            $updates[] = "`{$field}` = ?";
        }
        $sql .= implode(', ', $updates);
        $sql .= ' WHERE ' . $entity::getPrimaryKey() . " = {$id}";
        $statement = self::getDb()->getConnection()->prepare($sql);
        if (!$statement) {
            die("SQL Error: {" . self::getDb()->getConnection()->errno . " } - {" . self::getDb()->getConnection()->error . "}");
        }
        $statement->bind_param(str_repeat('s', $length), ...array_values($data));
        return $statement->execute();
    }

    protected static function getFields(string $tableName): array
    {
        $fields = [];
        $statement = self::getDb()->getConnection()->query('DESCRIBE ' . $tableName);
        while ($result = $statement->fetch_assoc()) {
            $fields[] = $result['Field'];
        }
        return $fields;
    }
}