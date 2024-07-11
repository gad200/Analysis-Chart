<?php

namespace App\Http\Controllers;

use App\Models\PhSensor;
use App\Models\SystemDecision;
use App\Models\TempSensor;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SendDataController extends Controller
{
    public function index( $ph, $temperature, $state)
    {
        DB::beginTransaction();

            // Assign ph to PhSensor
            $phSensor = new PhSensor();
            $phSensor->data = $ph;
            $phSensor->save();

            // Assign temp data to TempSensor
            $tempSensor = new TempSensor();
            $tempSensor->data = $temperature;
            $tempSensor->save();

            // Assign state to SystemDecision
            $systemDecisions = new SystemDecision();
            $systemDecisions->decision = ($state == 1) ? 'Add' : 'No';
            $systemDecisions->ph_sensor_id = $phSensor->id;
            $systemDecisions->temp_sensor_id = $tempSensor->id;
            $systemDecisions->save();

        DB::commit();
    }
}
