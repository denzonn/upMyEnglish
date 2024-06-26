<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExampleImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'example_id',
        'photo',
    ];

    public function example(){
        return $this->belongsTo(Example::class);
    }
}
