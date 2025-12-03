<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description'
    ];
    protected function casts(): array
    {
        return [
            'value' => 'string', // default
        ];
    }
    public function getValueAttribute($value)
    {
        return match ($this->type) {
            'number'  => (int) $value,
            'boolean' => (bool) $value,
            'json'    => json_decode($value, true),
            'text',
            'string'  => $value,
            default   => $value,
        };
    }
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = match ($this->type) {
            'json'    => json_encode($value),
            'boolean' => $value ? 1 : 0,
            default   => $value,
        };
    }
    public function scopeKey($query, $key)
    {
        return $query->where('key', $key);
    }
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }
    public static function set(string $key, $value, $type = 'string', $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value'       => $value,
                'type'        => $type,
                'description' => $description
            ]
        );
    }
}
