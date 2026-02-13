<?php
namespace App\Models;

use App\Core\Model;

class ContentSection extends Model
{
    protected $table = 'content_sections';

    public function getByKey($key)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE section_key = ?");
        $stmt->execute([$key]);
        return $stmt->fetch() ?: null;
    }

    public function getAllKeyed()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY sort_order");
        $rows = $stmt->fetchAll();
        $keyed = [];
        foreach ($rows as $r) {
            if (!empty($r['extra_data'])) {
                $r['extra_data'] = is_string($r['extra_data']) ? json_decode($r['extra_data'], true) : $r['extra_data'];
            }
            $keyed[$r['section_key']] = $r;
        }
        return $keyed;
    }

    public function updateByKey($key, $data)
    {
        $section = $this->getByKey($key);
        if (!$section) return false;
        return $this->update($section['id'], $data);
    }
}
