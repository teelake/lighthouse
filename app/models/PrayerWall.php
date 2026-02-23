<?php
namespace App\Models;

use App\Core\Model;

class PrayerWall extends Model
{
    protected $table = 'prayer_wall';

    public function findPaginated(string $orderBy = 'created_at DESC', int $limit = 15, int $offset = 0): array
    {
        $sql = "SELECT * FROM `{$this->table}` ORDER BY " . preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy) . " LIMIT " . (int) $limit . " OFFSET " . (int) $offset;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        $total = (int) $this->db->query("SELECT COUNT(*) FROM `{$this->table}`")->fetchColumn();
        return ['rows' => $rows, 'total' => $total];
    }
}
