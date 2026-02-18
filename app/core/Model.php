<?php
namespace App\Core;

abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findAll($conditions = [], $orderBy = '', $limit = null, $offset = null)
    {
        $sql = "SELECT * FROM `{$this->table}`";
        $params = [];
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $k => $v) {
                $where[] = "`{$k}` = ?";
                $params[] = $v;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        if ($orderBy) $sql .= " ORDER BY {$orderBy}";
        if ($limit) $sql .= " LIMIT " . (int)$limit . ($offset ? " OFFSET " . (int)$offset : "");
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $cols = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($cols), '?'));
        $colsStr = '`' . implode('`, `', $cols) . '`';
        $sql = "INSERT INTO `{$this->table}` ({$colsStr}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $set = [];
        foreach (array_keys($data) as $k) {
            $set[] = "`{$k}` = ?";
        }
        $sql = "UPDATE `{$this->table}` SET " . implode(', ', $set) . " WHERE `{$this->primaryKey}` = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), [$id]));
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM `{$this->table}` WHERE `{$this->primaryKey}` = ?");
        return $stmt->execute([$id]);
    }

    public function count($conditions = [])
    {
        $sql = "SELECT COUNT(*) as c FROM `{$this->table}`";
        $params = [];
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $k => $v) {
                $where[] = "`{$k}` = ?";
                $params[] = $v;
            }
            $sql .= " WHERE " . implode(' AND ', $where);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetch()['c'];
    }

    /** Run raw SQL query and return all rows */
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}
