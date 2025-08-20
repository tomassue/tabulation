<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'category',
        'description',
        'winners',
        'display_participant',
        'is_active',
        'icon'
    ];

    public function getPercent()
    {
        $participant = RefParticipant::category($this->category)->count();
        $criterias = RefCriteria::where('category', $this->category)->count();
        $rawSql = $this->hasMany(Higalaay::class, 'category', 'category');

        if (Auth::user()->role == 'admin') {
            $judges = RefJudge::category($this->category)->count();
        } else {
            $judges = 1;
            $judge_id = RefJudge::where('user_id', Auth::user()->id)->category($this->category)->first();
            $rawSql->where('judge_id', $judge_id->id);
        }

        $total = ($participant * $criterias) * $judges;
        if ($total == 0) {
            return 0;
        }

        return ($rawSql->whereNotNull('score')->count() / $total) * 100;
    }
}
