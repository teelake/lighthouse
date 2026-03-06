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

    /**
     * Upcoming events — includes all three types:
     *   - Coming Soon (no date)
     *   - Single date >= today
     *   - Date range where end date >= today (catches ongoing multi-day events)
     * Coming-soon events are sorted to the end; dated events sorted by start date ASC.
     */
    public function findUpcoming(int $limit = 10): array
    {
        $sql = "SELECT * FROM `{$this->table}`
                WHERE is_published = 1
                  AND (
                    event_date IS NULL
                    OR event_date >= CURDATE()
                    OR (event_end_date IS NOT NULL AND event_end_date >= CURDATE())
                  )
                ORDER BY
                    CASE WHEN event_date IS NULL THEN 1 ELSE 0 END ASC,
                    event_date ASC
                LIMIT " . (int)$limit;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}
