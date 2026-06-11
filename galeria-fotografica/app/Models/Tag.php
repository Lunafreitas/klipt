<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'nome',
    ];

    public function fotos()
    {
        return $this->belongsToMany(Foto::class);
    }
}