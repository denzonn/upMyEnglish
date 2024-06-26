<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_materi_id',
        'name',
        'audio',
        'description',
    ];

    public function subMateri(){
        return $this->belongsTo(SubMateri::class);
    }
}
