<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;

    //guarded
    protected $guarded = [];
    
    public function input()
    {
        return $this->hasMany(input::class);
    }
}
