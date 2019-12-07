<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'pko';
    protected $connection = 'remote-mysql';

    public const YEARS = [
        '2015' => 'pko_2015',
        '2016' => 'pko_2016',
        '2017' => 'pko_2017',
        '2018' => 'pko_2018',
        '2019' => 'pko',
    ];


//    public
}

