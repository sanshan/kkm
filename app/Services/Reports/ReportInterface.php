<?php


namespace App\Services\Reports;


use Illuminate\Support\Collection;

interface ReportInterface
{

    /**
     * Метод должен вернуть коллекцию с ошибками или пустую коллекцию
     *
     * @return Collection
     */
    public function errors() : Collection;


    /**
     * Добавляет ошибки в $this->errors и возвращает коллекцию с ошибками
     *
     * @param array $m
     * @param bool $clear
     * @return Collection
     */
    public function setErrors(array $m, bool $clear = false) : Collection;

    /**
     * Метод должен вернуть массив, первым элементом которого будут данные отчёта,
     * вторым элементом - код ответа
     *
     * @return array
     */
    public function data() : array;

}
