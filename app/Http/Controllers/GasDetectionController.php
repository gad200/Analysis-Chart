<?php

namespace App\Http\Controllers;

use App\Models\GasDetection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GasDetectionController extends Controller
{
    public function check_gas()
    {
        return GasDetection::where('is_read', 0)
            ->select('id', 'gase')
            ->orderBy('created_at', 'desc')
            ->first();

    }

    public function mark_as_read($gasDetection): void
    {
        $gas = GasDetection::find($gasDetection);
        $gas->is_read = true;
        $gas->save();
    }

    public function add_gas()
    {
        $gas = new GasDetection();
        $gas->gase = 1;
        $gas->is_read = 0;
        $gas->save();
    }
}
