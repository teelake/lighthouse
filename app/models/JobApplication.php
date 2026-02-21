<?php
namespace App\Models;

use App\Core\Model;

class JobApplication extends Model
{
    protected $table = 'job_applications';

    /** Filter keys allowed for building WHERE conditions */
    private const FILTER_KEYS = ['job_id', 'engagement_type', 'date_from', 'date_to', 'search'];

    /**
     * Find applications with filters and pagination.
     * @param array $filters ['job_id' => int, 'engagement_type' => string, 'date_from' => Y-m-d, 'date_to' => Y-m-d, 'search' => string]
     * @return array{rows: array, total: int}
     */
    public function findAllFiltered(array $filters, string $orderBy = 'created_at DESC', int $limit = 15, int $offset = 0): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['job_id'])) {
            $where[] = '`job_id` = ?';
            $params[] = (int) $filters['job_id'];
        }
        if (!empty($filters['engagement_type'])) {
            $where[] = '`engagement_type` = ?';
            $params[] = $filters['engagement_type'];
        }
        if (!empty($filters['date_from'])) {
            $where[] = 'DATE(`created_at`) >= ?';
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where[] = 'DATE(`created_at`) <= ?';
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['search'])) {
            $term = '%' . trim($filters['search']) . '%';
            $where[] = '(CONCAT(COALESCE(first_name,\'\'), \' \', COALESCE(last_name,\'\')) LIKE ? OR name LIKE ? OR email LIKE ?)';
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        $sql = 'SELECT * FROM `' . $this->table . '`';
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY ' . preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy);
        $sql .= ' LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        $countSql = 'SELECT COUNT(*) as c FROM `' . $this->table . '`';
        if (!empty($where)) {
            $countSql .= ' WHERE ' . implode(' AND ', $where);
        }
        $stmtCount = $this->db->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) ($stmtCount->fetch()['c'] ?? 0);

        return ['rows' => $rows, 'total' => $total];
    }
}
