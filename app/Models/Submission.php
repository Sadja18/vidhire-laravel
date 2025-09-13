<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'interview_id',
        'question_id',
        'video_url',
        'score',
        'comment',
        'status',
        'submitted_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
