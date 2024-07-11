<?php

namespace App\Http\Controllers;

use App\Models\SystemDecision;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActionLogController extends Controller
{
    public function index()
    {
        return SystemDecision::with('phSensor', 'tempSensor')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function search(Request $request){
        $request->validate([
            'date' => 'nullable|string|date|date_format:Y-m-d',
            'ph' => 'nullable|numeric|min:1|max:14',
            'temp   ' => 'nullable|numeric',
            'action' => 'nullable|string|in:Add,No'
        ]);

        $query = SystemDecision::with('phSensor', 'tempSensor');

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('ph')) {
            $query->whereHas('phSensor', function ($query) use($request) {
                $query->where('data', $request->ph);
            });
        }
        if ($request->filled('temp')) {
            $query->whereHas('tempSensor', function ($query) use($request) {
                $query->where('data', $request->temp);
            });
        }
        if ($request->filled('action')) {
            $query->where('decision', $request->action);
        }

        $results = $query->paginate(10);

        return $results;
    }
}
