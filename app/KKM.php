<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KKM extends Model
{
    protected $table = 'kkm';

    protected $connection = 'remote-mysql';

    public const SORTABLE_COLUMNS = [
        'serial' => true,
        'azs'    => true,
        'region' => true,
    ];

    public const SELECTABLE_COLUMNS = [
        'kkm.id',
        'kkm.serial',
        'kkm.azs',
        'azs.region',
    ];


    /**
     * Получить коллекцию ККМ
     * $params['sort_field'] - поле по которому сортируются данные
     * $params['dir'] - направление сортировки
     * $params['search'] - строка поиска
     * $params['search_field'] - поле для поиска
     * $params['per_page'] - количество строк на странице
     *
     * @param array $params
     * @return mixed
     */
    public static function index(array $params)
    {
        return KKM::select(self::SELECTABLE_COLUMNS)
            ->join('azs', 'azs.skladID', '=', 'kkm.azs')
            ->orderBy($params['sort_field'], $params['dir'])
            ->when(!empty($params['search']), function ($q) use ($params) {
                return $q->where($params['search_field'], 'like', '%' . $params['search'] . '%');
            })
            ->paginate($params['per_page']);
    }

}
