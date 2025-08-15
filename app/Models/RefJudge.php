<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefJudge extends Model
{
    protected $fillable = [
        'category',
        'judge',
        'nickname',
        'user_id',
    ];
    protected $casts = [
        'category' => 'array', // Casts the 'details' column to a PHP array
    ];
    public function scopeCategory($query, $category)
    {
        return $query->whereJsonContains('ref_judges.category', $category);
    }
    public function getPercent()
    {
        $criterias = RefCriteria::where('category', 'poster')->count();
        $participant = RefParticipant::where('category', 'poster')->count();
        $total = $participant * $criterias;
        if ($total == 0) {
            return 0;
        }
        return bong_format($this->hasMany(Poster::class, 'judge_id')->whereNotNull('score')->count() / $total * 100);
    }
    public function getOralPercent()
    {
        $criterias = RefCriteria::where('category', 'oral')->count();
        $participant = RefParticipant::where('category', 'oral')->count();
        $total = $participant * $criterias;
        if ($total == 0) {
            return 0;
        }
        return bong_format($this->hasMany(Oral::class, 'judge_id')->whereNotNull('score')->count() / $total * 100);
    }
    public function getHigalaayPercent($category)
    {
        $criterias = RefCriteria::where('category', $category)->count();
        $participant = RefParticipant::category($category)->count();
        $total = $participant * $criterias;
        if ($total == 0) {
            return 0;
        }
        return bong_format($this->hasMany(Higalaay::class, 'judge_id')->where('category', $category)->whereNotNull('score')->count() / $total * 100);
    }
}
