<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_answer_id',
        'question_id',
        'answer_id',
        'point',
    ];

    public function userAnswer(){
        return $this->belongsTo(UserAnswer::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function answer(){
        return $this->belongsTo(Answer::class);
    }
}
