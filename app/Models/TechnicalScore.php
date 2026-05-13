<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalScore extends Model
{
    protected $fillable = ['participant_id', 'judge_id', 'sub_criteria_id', 'competition_category', 'score'];

    public function participant()
    {
        return $this->belongsTo(RefParticipant::class, 'participant_id');
    }

    public function judge()
    {
        return $this->belongsTo(RefJudge::class, 'judge_id');
    }

    public function subCriteria()
    {
        return $this->belongsTo(TechnicalSubCriteria::class, 'sub_criteria_id');
    }
}
