<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemDecision extends Model
{
    use HasFactory;

    public function phSensor()
    {
        return $this->belongsTo(PhSensor::class, 'ph_sensor_id');
    }

    public function tempSensor()
    {
        return $this->belongsTo(TempSensor::class, 'temp_sensor_id');
    }
}
