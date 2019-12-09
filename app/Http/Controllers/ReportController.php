<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('params')['period'] ?? [];
        $years = [
            '2019' => 'pko',
        ];

        if (!empty($period)) {
            $period[0] = Carbon::parse($period[0])->timezone('Europe/Moscow');
            $period[1] = Carbon::parse($period[1])->timezone('Europe/Moscow');

            $years = array_filter(
                Report::YEARS,
                function ($year) use (&$period) {
                    return ($year >= $period[0]->year && $year <= $period[1]->year) ? $year : false;
                },
                ARRAY_FILTER_USE_KEY
            );

            $years = array_map(
                function ($table) {
                    return $table;
                },
                $years
            );

        }

        $response = array_map(
            function ($device) use ($years, $period) {
                $count = 0;

                foreach ($years as $year) {
                    $builder = DB::connection('remote-mysql')->table($year)->selectRaw('osnov');
                    $builder->where('osnov', $device['serial'])
                        ->groupBy('date', 'osnov');

                    if (!empty($period)) {
                        $start = Carbon::parse($period[0])->timezone('Europe/Moscow')->toDateString();
                        $end = Carbon::parse($period[1])->timezone('Europe/Moscow')->toDateString();

                        $builder->Where('date', '>=', $start)
                            ->where('date', '<=', $end);

                    }
                    $count += $builder->get()->count();
                }

                $device['worked_days'] = $count;
                return $device;

            },
            $request->params['devices']
        );


        \Log::info(print_r($response,true));

        return response()->json($response);
    }
}
