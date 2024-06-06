<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sub_materi_id',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subMateri(){
        return $this->belongsTo(SubMateri::class);
    }

    public function detailAnswer(){
        return $this->hasMany(UserAnswerDetail::class);
    }
}
