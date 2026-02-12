<?php
namespace App\Models;

use App\Core\Model;

class Job extends Model
{
    protected $table = 'jobs';

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND is_published = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }
}
