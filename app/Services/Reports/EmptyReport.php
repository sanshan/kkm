<?php


namespace App\Services\Reports;

use Exception;
use Illuminate\Support\Collection;
use Validator;

class EmptyReport implements ReportInterface
{
    /**
     * Массив для хранения ошибок
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Массив с данными для отчёта
     *
     * @var array
     */
    protected $results = [];

    /**
     * Массив с параметрами и правилами валидации для Validator
     *
     * @var array
     */
    protected $params = [];

    /**
     * Возвращает коллекцию ошибок
     *
     * @return Collection
     */
    public function errors(): Collection
    {
        return collect($this->errors);
    }

    /**
     * Добавляет ошибки в $this->errors и возвращает коллекцию с ошибками
     *
     * @param array $m
     * @param bool $clear
     * @return Collection
     */
    public function setErrors(array $m, bool $clear = false): Collection
    {
        $this->errors = $clear ? $m : $this->errors + $m;
        return collect($this->errors);
    }

    /**
     * Возвращает массив с данными и статусом ответа во внешний мир
     *
     * @return array
     */
    public function data(): array
    {
        return [$this->getResult(), $this->getStatus()];
    }

    /**
     * Возвращает статус ответа
     *
     * @return int
     */
    protected function getStatus(): int
    {
        return 200;
    }

    /**
     * Возвращает коллекцию с данными для отчёта или коллекцию ошибок
     *
     * @return Collection
     */
    protected function getResult()
    {
        return $this->errors()->count() > 0 ? $this->errors() : $this->results();
    }

    /**
     * Возвращает коллекцию с данными для отчёта
     *
     * @return Collection
     */
    protected function results()
    {
        return collect($this->results);
    }

    /**
     * Проверяет входящие параметры. Возвращает коллекцию проверенных параметров
     *
     * @param Collection $params
     * @return Collection
     * @throws Exception
     */
    protected function chkParams(Collection $params): Collection
    {
        $validator = Validator::make($params->toArray(), $this->params);
        if ($validator->fails()) {
            $this->setErrors($validator->messages()->toArray());
            throw new Exception($validator->messages());
        }

        return collect($validator->validated());
    }

}
