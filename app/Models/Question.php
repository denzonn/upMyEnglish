<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_materi_id',
        'question',
        'bobot',
        'photo',
        'audio',
    ];

    public function subMateri()
    {
        return $this->belongsTo(SubMateri::class);
    }
}
