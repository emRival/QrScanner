<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class input extends Model
{
    use HasFactory;

    //guarded
    protected $guarded = [];

    public function data()
    {
        return $this->belongsTo(data::class);
    }
}