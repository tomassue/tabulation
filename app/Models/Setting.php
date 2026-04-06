<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'description'];

    public static function get(string $key, $default = null): mixed
    {
        return static::where('name', $key)->value('value') ?? $default;
    }

    public static function set(string $key, $value, string $description = null): void
    {
        $data = ['value' => $value];
        if ($description !== null) {
            $data['description'] = $description;
        }
        static::updateOrCreate(['name' => $key], $data);
    }
}
