<?php
namespace App\Models;

use App\Core\Model;

class Testimony extends Model
{
    protected $table = 'testimonies';

    /**
     * @param bool|string $archivedFilter true = exclude archived, 'only' = only archived, false = all
     */
    public function findPaginated(string $orderBy = 'created_at DESC', int $limit = 12, int $offset = 0, $archivedFilter = false): array
    {
        return $this->findPaginatedFiltered([], $orderBy, $limit, $offset, $archivedFilter);
    }

    /**
     * @param array $filters ['search' => string]
     * @param bool|string $archivedFilter true = exclude archived, 'only' = only archived, false = all
     * @return array{rows: array, total: int}
     */
    public function findPaginatedFiltered(array $filters, string $orderBy = 'created_at DESC', int $limit = 15, int $offset = 0, $archivedFilter = false): array
    {
        $where = [];
        $params = [];

        if ($archivedFilter === true) {
            $where[] = '(is_archived = 0 OR is_archived IS NULL)';
        } elseif ($archivedFilter === 'only') {
            $where[] = 'is_archived = 1';
        }

        if (!empty($filters['search'])) {
            $term = '%' . trim($filters['search']) . '%';
            $where[] = '(content LIKE ? OR author_name LIKE ?)';
            $params[] = $term;
            $params[] = $term;
        }

        $whereClause = empty($where) ? '' : ' WHERE ' . implode(' AND ', $where);
        $sql = "SELECT * FROM `{$this->table}`{$whereClause} ORDER BY " . preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy) . " LIMIT " . (int) $limit . " OFFSET " . (int) $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        $countSql = "SELECT COUNT(*) FROM `{$this->table}`" . $whereClause;
        $stmtCount = $this->db->prepare($countSql);
        $stmtCount->execute($params);
        $total = (int) $stmtCount->fetchColumn();

        return ['rows' => $rows, 'total' => $total];
    }
}
