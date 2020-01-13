<?php


namespace App\Services\Reports;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
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
     * @param Exception $e
     * @param bool $clear
     * @return Collection
     */
    public function setErrors(Exception $e, bool $clear = false): Collection
    {
        if ($clear) $this->errors = [$this->convertErrorData($e)];
        else $this->errors[] = $this->convertErrorData($e);

        return collect($this->errors);
    }

    /**
     * Конвертируем ошибку в нужный формат
     *
     * @param Exception $e
     * @return array
     */
    private function convertErrorData(Exception $e): array
    {
        return [
            'message' => __($e->getMessage()),
            'data'    => optional($e)->errors() ?? '',
            'status'  => optional($e)->status ?? 500,
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ];
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
        return $this->errors()->last()['status'] ?? 200;
    }

    /**
     * Возвращает коллекцию с данными для отчёта или коллекцию ошибок
     *
     * @return Collection
     */
    protected function getResult()
    {
        return $this->errors()->count() > 0 ? $this->errors()->last() : $this->results();
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

        return collect($validator->validate());
    }

}
