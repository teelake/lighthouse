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

    /**
     * Members with filters and pagination.
     * @param array $filters ['search' => string, 'status' => 'all'|'active'|'inactive']
     * @return array{rows: array, total: int}
     */
    public function findMembersFiltered(array $filters, string $orderBy = 'name ASC', int $limit = 20, int $offset = 0): array
    {
        $where = ["`role` = 'member'"];
        $params = [];

        $search = trim($filters['search'] ?? '');
        if ($search !== '') {
            $term = '%' . $search . '%';
            $where[] = '(`name` LIKE ? OR `email` LIKE ?)';
            $params[] = $term;
            $params[] = $term;
        }

        $status = $filters['status'] ?? 'all';
        if ($status === 'active') {
            $where[] = '`is_active` = 1';
        } elseif ($status === 'inactive') {
            $where[] = '(`is_active` = 0 OR `is_active` IS NULL)';
        }

        $whereClause = ' WHERE ' . implode(' AND ', $where);
        $orderSafe = preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy) ?: 'name ASC';
        $sql = "SELECT * FROM `{$this->table}`{$whereClause} ORDER BY {$orderSafe} LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        $countSql = "SELECT COUNT(*) FROM `{$this->table}`" . $whereClause;
        $stmtCount = $this->db->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int)$stmtCount->fetchColumn();

        return ['rows' => $rows, 'total' => $total];
    }
}
