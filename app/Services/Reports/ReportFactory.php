<?php

namespace App\Services\Reports;

use Exception;
use Illuminate\Support\Collection;
use Str;

class ReportFactory
{
    /**
     * Объект Request
     */
    protected $request;

    /**
     * Конструктор ReportFactory.
     * В конструкторе пврвметру this->title присваивается значение запрошенного отчёта
     *
     * @param ReportFactoryRequest $request
     */
    public function __construct(ReportFactoryRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Создаёт и возвращает отчёт
     *
     * @return ReportInterface
     */
    public function make(): ReportInterface
    {
        $reportClass = $this->makeClassName('Class');
        try {
            \Log::info(print_r($this->getParams(), true));
            return new $reportClass($this->getParams());
        } catch (Exception $e) {
            $report = new EmptyReport();
            $report->setErrors($e);
            return $report;
        }
    }

    /**
     * Создаёт и возвращает имя класса
     *
     * @param String $type
     * @return String
     */
    private function makeClassName(String $type): String
    {
        $cc = $this->formatter($this->getTitle());
        return __NAMESPACE__ . "\\" . $cc . "\\" . $cc . $type;
    }

    /**
     * Конвертирует $val в PascalCase
     *
     * @param String $val
     * @return String
     */
    private function formatter(String $val): String
    {
        return Str::studly($val);
    }

    /**
     * Получить название отчёта из Request
     *
     * @return String
     */
    public function getTitle(): String
    {
        return $this->request->validated()['title'];
    }

    /**
     * Получить из Request коллекцию параметров без title
     *
     * @return Collection
     */
    public function getParams(): Collection
    {
        return collect($this->request)->filter(function ($value) {
            return $value !== $this->getTitle();
        });
    }
}
