<?php

namespace App\Http\Controllers;

use App\Services\Reports\ReportFactory;

class ReportController extends Controller
{
    public function index(ReportFactory $reportGenerator)
    {
        return response()->json(...$reportGenerator->make()->data());
    }
}
