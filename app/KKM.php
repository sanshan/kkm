<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    protected $table = 'kkm';

    protected $connection = 'remote-mysql';

    public const SORTABLE_COLUMNS = [
        'serial' => true,
        'azs' => true,
        'region' => true,
    ];

    public const SELECTABLE_COLUMNS = [
        'kkm.id',
        'kkm.serial',
        'kkm.azs',
        'azs.region',
    ];

}
