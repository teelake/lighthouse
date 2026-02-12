<?php
namespace App\Models;

use App\Core\Model;

class Media extends Model
{
    protected $table = 'media';

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = ? AND is_published = 1");
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }
}
