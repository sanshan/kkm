<?php

namespace App;

use App\Services\Reports\ReportFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Report extends Model
{
    protected $table = 'pko';
    protected $connection = 'remote-mysql';

    public const YEARS = [
        '2015' => 'pko_2015',
        '2016' => 'pko_2016',
        '2017' => 'pko_2017',
        '2018' => 'pko_2018',
        '2019' => 'pko_2019',
        '2020' => 'pko',
    ];

    public static function build(Request $request, ReportFactory $reportFactory)
    {

        return $reportFactory::make($request->validated);
    }

}

