<?php
namespace App\Models;

use App\Core\Model;

class Donation extends Model
{
    protected $table = 'donations';

    /**
     * Find donations with filters and pagination.
     * @param array $filters ['date_from' => Y-m-d, 'date_to' => Y-m-d, 'designation' => string, 'search' => string]
     * @return array{rows: array, total: int}
     */
    public function findAllFiltered(array $filters, string $orderBy = 'created_at DESC', int $limit = 20, int $offset = 0): array
    {
        $where = [];
        $params = [];

        if (!empty($filters['date_from'])) {
            $where[] = 'DATE(`created_at`) >= ?';
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where[] = 'DATE(`created_at`) <= ?';
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['designation'])) {
            $where[] = '`designation` = ?';
            $params[] = $filters['designation'];
        }
        if (!empty($filters['search'])) {
            $term = '%' . trim($filters['search']) . '%';
            $where[] = '(COALESCE(donor_name,\'\') LIKE ? OR COALESCE(donor_email,\'\') LIKE ? OR COALESCE(purpose,\'\') LIKE ?)';
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

    /**
     * Get total amount (in cents) for filtered donations.
     */
    public function getTotalAmountCents(array $filters): int
    {
        $where = [];
        $params = [];

        if (!empty($filters['date_from'])) {
            $where[] = 'DATE(`created_at`) >= ?';
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where[] = 'DATE(`created_at`) <= ?';
            $params[] = $filters['date_to'];
        }
        if (!empty($filters['designation'])) {
            $where[] = '`designation` = ?';
            $params[] = $filters['designation'];
        }
        if (!empty($filters['search'])) {
            $term = '%' . trim($filters['search']) . '%';
            $where[] = '(COALESCE(donor_name,\'\') LIKE ? OR COALESCE(donor_email,\'\') LIKE ? OR COALESCE(purpose,\'\') LIKE ?)';
            $params[] = $term;
            $params[] = $term;
            $params[] = $term;
        }

        $sql = 'SELECT COALESCE(SUM(amount_cents), 0) as total FROM `' . $this->table . '`';
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}
