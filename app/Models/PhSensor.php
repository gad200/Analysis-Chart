<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhSensor extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    public function systemDecision()
    {
        return $this->hasOne(SystemDecision::class);
    }
}
