<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'category',
        'description',
        'winners',
        'is_active',
        'icon'
    ];

    public function getPercent()
    {
        $judges = RefJudge::category($this->category)->count();
        $participant = RefParticipant::category($this->category)->count();
        $criterias = RefCriteria::where('category', $this->category)->count();
        $total = ($participant * $criterias) * $judges;
        if ($total == 0) {
            return 0;
        }
        return ($this->hasMany(Higalaay::class, 'category', 'category')->whereNotNull('score')->count() / $total) * 100;
    }
}
