<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Voter extends Authenticatable
{
    use HasFactory;

    public $dates = ['voted_time', 'created_at', 'updated_at'];

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }
}
