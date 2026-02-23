<?php
namespace App\Models;

use App\Core\Model;

class Event extends Model
{
    protected $table = 'events';

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND is_published = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    /** Upcoming events only (event_date >= today) */
    public function findUpcoming(int $limit = 10): array
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE is_published = 1 AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT " . (int) $limit);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}
