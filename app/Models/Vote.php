<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Vote extends Model
{
    use HasFactory;

    public $dates = ['start', 'end', 'created_at', 'updated_at'];

    public function candidates()
    {
        return $this->hasMany(Candidate::class)->orderBy('id', 'asc');
    }

    public function voters()
    {
        return $this->hasMany(Voter::class)->orderBy('id', 'asc');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {
            $m->uuid = Str::uuid();
        });
    }
}
