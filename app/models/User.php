<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';

    /** Staff (admin + editor) only */
    public function findStaff(string $orderBy = 'name ASC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `role` IN ('admin', 'editor')";
        if ($orderBy) $sql .= " ORDER BY {$orderBy}";
        if ($limit) $sql .= " LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** Members only */
    public function findMembers(string $orderBy = 'name ASC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM `{$this->table}` WHERE `role` = 'member'";
        if ($orderBy) $sql .= " ORDER BY {$orderBy}";
        if ($limit) $sql .= " LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
