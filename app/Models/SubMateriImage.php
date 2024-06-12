<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMateriImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_materi_id',
        'photo'
    ];

    public function subMateri(){
        return $this->belongsTo(SubMateri::class);
    }
}
