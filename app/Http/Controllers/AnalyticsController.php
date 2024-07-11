<?php

namespace App\Http\Controllers;

use App\Models\PhSensor;
use App\Models\TempSensor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function getDays($today = null)
    {
        if ($today === null) {
            $today = Carbon::now()->format('Y-m-d');
        }

        $parsToday = Carbon::createFromFormat('Y-m-d', $today);

        $dates = [];

        for ($i = 0; $i <= 30; $i++) {
            $dates[] = $parsToday->copy()->subDays($i)->format('Y-m-d');
        }

        return response(json_encode([
            'dates' => $dates
        ]));
    }

    public function ph_over_time($date = null)
    {
        if($date == null){
            $date = Carbon::now()->format('Y-m-d');
        }
        $parseDate = Carbon::createFromFormat('Y-m-d', $date);
        $ph = PhSensor::whereDate('created_at', $parseDate)->orderBy('created_at', 'desc')->take(15);

        $labels = $ph->pluck('created_at')->map(function ($createdAt) {
            return Carbon::parse($createdAt)->format('Y-m-d H:i:s');
        });

        return [
            'data' => $ph->pluck('data'),
            'labels'   => $labels
        ];
    }

    public function temp_over_time($date = null)
    {
        if($date == null){
            $date = Carbon::now()->format('Y-m-d');
        }
        $parseDate = Carbon::createFromFormat('Y-m-d', $date);
        $temp = TempSensor::whereDate('created_at', $parseDate)->orderBy('created_at', 'desc')->take(15);

        $labels = $temp->pluck('created_at')->map(function ($createdAt) {
            return Carbon::parse($createdAt)->format('Y-m-d H:i:s');
        });

        return [
            'data' => $temp->pluck('data'),
            'labels'   => $labels
        ];
    }

    public function avg_ph($date = null)
    {
        if($date == null){
            $date = Carbon::now()->format('Y-m-d');
        }
        $parseDate = Carbon::createFromFormat('Y-m-d', $date);
        $ph = PhSensor::whereDate('created_at', $parseDate)->avg('data');
        return [$ph, 14-$ph];
    }

    public function avg_temp($date = null)
    {
        if($date == null){
            $date = Carbon::now()->format('Y-m-d');
        }
        $parseDate = Carbon::createFromFormat('Y-m-d', $date);
        $temp = TempSensor::whereDate('created_at', $parseDate);
        return [$temp->max('data'), $temp->min('data')];
    }
}
