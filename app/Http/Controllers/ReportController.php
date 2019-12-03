<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $response = array_map(array($this, 'getCountWorkedDays'), $request->params['devices']);

        return response()->json($response);
    }

    private function getCountWorkedDays($device)
    {
        $device['worked_days'] = Report::selectRaw('osnov')
            ->where('osnov', $device['serial'])
            ->groupBy('date', 'osnov')
            ->get()
            ->count();

        return $device;
    }
}
