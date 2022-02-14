<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class);
    }
}
