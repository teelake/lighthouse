<?php
namespace App\Models;

use App\Core\Model;

class PrayerWall extends Model
{
    protected $table = 'prayer_wall';

    /**
     * @param bool|string $archivedFilter true = exclude archived, 'only' = only archived, false = all
     */
    public function findPaginated(string $orderBy = 'created_at DESC', int $limit = 15, int $offset = 0, $archivedFilter = false): array
    {
        $where = '';
        if ($archivedFilter === true) {
            $where = ' WHERE (is_archived = 0 OR is_archived IS NULL)';
        } elseif ($archivedFilter === 'only') {
            $where = ' WHERE is_archived = 1';
        }
        $sql = "SELECT * FROM `{$this->table}`{$where} ORDER BY " . preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy) . " LIMIT " . (int) $limit . " OFFSET " . (int) $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        $countSql = "SELECT COUNT(*) FROM `{$this->table}`" . $where;
        $total = (int) $this->db->query($countSql)->fetchColumn();
        return ['rows' => $rows, 'total' => $total];
    }
}
