<?php
namespace App\Models;

use App\Core\Model;

class AcademyRegistration extends Model
{
    protected $table = 'academy_registrations';

    public static array $academyLabels = [
        'membership'   => 'Pharos Membership Academy',
        'leadership'   => 'Pharos Leadership Academy',
        'discipleship' => 'Pharos Discipleship Academy',
    ];

    public function findPaginated(string $orderBy = 'created_at DESC', int $limit = 20, int $offset = 0, ?string $academy = null): array
    {
        $where  = $academy ? ' WHERE academy = :academy' : '';
        $params = $academy ? [':academy' => $academy] : [];
        $sql    = "SELECT * FROM `{$this->table}`{$where} ORDER BY "
                . preg_replace('/[^a-z0-9_,\s\-\.]/i', '', $orderBy)
                . " LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $stmt   = $this->db->prepare($sql);
        $stmt->execute($params);
        $rows   = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];

        $countSql = "SELECT COUNT(*) FROM `{$this->table}`{$where}";
        $cStmt    = $this->db->prepare($countSql);
        $cStmt->execute($params);
        $total = (int)$cStmt->fetchColumn();

        return ['rows' => $rows, 'total' => $total];
    }
}
