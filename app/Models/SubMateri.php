<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMateri extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'materi_id',
        'photo',
        'description',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
