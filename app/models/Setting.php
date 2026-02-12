<?php
namespace App\Models;

use App\Core\Model;

class Setting extends Model
{
    protected $table = 'settings';
    private static $cache = [];

    public function get($key, $default = null)
    {
        if (isset(self::$cache[$key])) return self::$cache[$key];
        $stmt = $this->db->prepare("SELECT `value` FROM {$this->table} WHERE `key` = ?");
        $stmt->execute([$key]);
        $row = $stmt->fetch();
        $val = $row ? $row['value'] : $default;
        self::$cache[$key] = $val;
        return $val;
    }

    public function set($key, $value)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        $stmt->execute([$key, $value]);
        self::$cache[$key] = $value;
        return true;
    }
}
