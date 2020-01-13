<?php

namespace App\Services\Reports\NumberOfDaysWorkedByKkm;

use App\Services\Reports\EmptyReport;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Collection;

class NumberOfDaysWorkedByKkmClass extends EmptyReport
{
    /**
     * Массив с параметрами и правилами валидации для Validator
     *
     * @var array|Collection
     */
    protected $params = [
        'period'           => 'nullable|array',
        'period.*'         => 'iso_date',
        'devices'          => 'required|array',
        'devices.*.id'     => 'required|exists:remote-mysql.kkm,id',
        'devices.*.serial' => 'required|string',
        'devices.*.region' => 'required|integer',
        'devices.*.azs'    => 'required|integer',
    ];

    /**
     * Массив в формате "год" => "наименование_таблицы_в_БД"
     */
    private const YEARS = [
        '2015' => 'pko_2015',
        '2016' => 'pko_2016',
        '2017' => 'pko_2017',
        '2018' => 'pko_2018',
        '2019' => 'pko_2019',
        '2020' => 'pko',
    ];


    /**
     * Значение для периода поумолчанию
     *
     * @var array
     */
    private $defaultYears = [
        '2019' => 'pko',
    ];

    /**
     * NumberOfDaysWorkedByKkmClass constructor.
     * @param $params
     * @throws Exception
     */
    public function __construct($params)
    {
        $this->results = $this->getData($this->chkParams($params));
    }

    /**
     * Получает данные для отчёта
     *
     * @param Collection $params
     * @return Collection
     */
    private function getData(Collection $params): Collection
    {
        $devices = collect($params['devices']);
        $years = $this->setYears($params['period']);

        return $devices->map(function ($item, $key) use ($years, $params) {

            $item['worked_days'] = 0;
            foreach ($years as $year) {
                $builder = DB::connection('remote-mysql')->table($year)->selectRaw('osnov');
                $builder->where('osnov', $item['serial'])
                    ->groupBy('date', 'osnov');

                if (!empty($params['period'])) {
                    $start = Carbon::parse($params['period'][0])->timezone('Europe/Moscow')->toDateString();
                    $end = Carbon::parse($params['period'][1])->timezone('Europe/Moscow')->toDateString();

                    $builder->Where('date', '>=', $start)
                        ->where('date', '<=', $end);
                }

                $item['worked_days'] += $builder->get()->count();
            }

            return $item;
        });
    }

    /**
     * Вспомогательный метод для определения таблиц из которых надо брыть данные для отчёта
     *
     * @param array $period
     * @return Collection
     */
    private function setYears(array $period = [])
    {
        $years = collect($this->defaultYears ?? []);
        if (!empty($period)) {
            $period[0] = Carbon::parse($period[0])->timezone('Europe/Moscow');
            $period[1] = Carbon::parse($period[1])->timezone('Europe/Moscow');

            $years = collect(self::YEARS)
                ->filter(function ($value, $key) use (&$period) {
                    return ($key >= $period[0]->year && $key <= $period[1]->year) ? $key : false;
                });
        }

        return $years;
    }

}
