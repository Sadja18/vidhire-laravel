<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'text',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
