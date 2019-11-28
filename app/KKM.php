<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    protected $table = 'kkms';

    public const SORTABLE_COLUMNS = [
        'factory_number' => true,
        'serial_number' => true,
        'gas_station_id' => true,
        'region_id' => true,
    ];

    public const SELECTABLE_COLUMNS = [
        'id',
        'factory_number',
        'serial_number',
        'gas_station_id',
        'region_id',
    ];

}
