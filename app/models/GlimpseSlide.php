<?php
namespace App\Models;

use App\Core\Model;

class GlimpseSlide extends Model
{
    protected $table = 'glimpse_slides';

    public function getByRow($row)
    {
        return $this->findAll(['row' => (int) $row], 'sort_order ASC');
    }

    public function getAllGroupedByRow()
    {
        $rows = $this->findAll([], '`row` ASC, sort_order ASC');
        $grouped = [1 => [], 2 => []];
        foreach ($rows as $r) {
            $grouped[(int) $r['row']][] = $r;
        }
        return $grouped;
    }
}
