<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidateLink extends Model
{
    use HasFactory;

    protected $fillable = ['interview_id', 'candidate_id', 'token'];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function candidate()
    {
        return $this->belongsTo(\App\Models\User::class, 'candidate_id');
    }
}
