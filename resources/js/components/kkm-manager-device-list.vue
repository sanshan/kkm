<template>
    <div id="deviceList">

        <div id="deviceListButton" class="columns mb-is">
            <div class="column is-3">
                <b-field label="Поиск">
                    <b-input v-model="search" @input="loadAsyncData" value=""/>
                </b-field>
            </div>
            <div class="column is-3">
                <b-field label="Столбец">
                    <b-select v-model="searchFieldDefault">
                        <option
                            v-for="(option,index) in fields"
                            :value="option.name"
                            :key="index">
                            {{ option.label }}
                        </option>
                    </b-select>
                </b-field>
            </div>
            <div class="column is-4">
                <b-field label="Выберите дату">
                    <b-datepicker
                        placeholder="Кликните..."
                        :month-names="monthNames"
                        :day-names="dayNames"
                        :first-day-of-week="firstDayOfWeek"
                        v-model="period"
                        @input="onDateInput"
                        range>
                    </b-datepicker>
                </b-field>
            </div>
            <div class="column is-2">
                <b-field class="has-text-right" label="Количество строк">
                    <b-select class="is-pulled-right" v-model="perPage" @input="loadAsyncData">
                        <option
                            v-for="(option,index) in rowsOnPage"
                            :value="option.name"
                            :key="index">
                            {{ option.label }}
                        </option>
                    </b-select>
                </b-field>
            </div>
        </div>

        <div class="is-clearfix"></div>

        <div id="deviceListTable" class="columns">
            <div class="column is-full">
                <b-table
                    :data="collectionData"
                    hoverable

                    paginated
                    backend-pagination
                    :total="total"
                    :per-page="perPage"
                    @page-change="onPageChange"

                    backend-sorting
                    :default-sort-direction="defaultSortDirection"
                    :default-sort="[sortField, sortDirection]"
                    @sort="onSort"

                    checkable
                    :checked-rows.sync="checkedRows"
                    @check="onCheck"
                >

                    <template slot-scope="props">
                        <b-table-column field="id" label="ID" width="40" numeric>
                            {{ props.row.id }}
                        </b-table-column>

                        <!--                        <b-table-column field="factory_number" label="Заводской номер" sortable>-->
                        <!--                            {{ props.row.factory_number }}-->
                        <!--                        </b-table-column>-->

                        <b-table-column field="serial" label="Серийный номер" sortable>
                            {{ props.row.serial }}
                        </b-table-column>

                        <b-table-column field="azs" label="АЗС" sortable>
                            {{ props.row.azs }}
                        </b-table-column>

                        <b-table-column field="region" label="Регион" sortable>
                            {{ props.row.region }}
                        </b-table-column>
                    </template>
                </b-table>
            </div>
        </div>
    </div>
</template>

<script>
    const collectionData = [];

    const fields = [
        {label: 'Серийный номер', name: 'serial'},
        {label: 'АЗС', name: 'azs'},
        {label: 'Регион', name: 'region'}
    ];

    const rowsOnPage = [
        {label: '10', name: '10'},
        {label: '20', name: '20'},
        {label: '50', name: '50'},
        {label: '100', name: '100'},
        {label: '500', name: '500'},
        {label: '999', name: '999'}
    ];

    const monthNames = [
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь'
    ];

    const dayNames = [
        'Вс',
        'Пн',
        'Вт',
        'Ср',
        'Чт',
        'Пт',
        'Сб'
    ];

    export default {
        data() {
            return {
                collectionData,
                fields,
                rowsOnPage,
                period: [],
                monthNames: monthNames,
                dayNames: dayNames,
                firstDayOfWeek: 1,
                checkedRows: [],
                total: 0,
                loading: false,
                sortDirection: 'desc',
                defaultSortDirection: 'desc',
                page: 1,
                perPage: 10,
                perPageDefault: 10,
                search: '',
                searchFieldDefault: 'serial',
                sortField: 'azs',
                lang: 'ru'
            }
        },
        created() {
            this.loadAsyncData();
        },
        methods: {
            /*
             * Load async collection data from server
             */
            loadAsyncData() {
                const params = {
                    page: this.page,
                    per_page: this.perPage,
                    dir: this.sortDirection,
                    sort_field: this.sortField,
                    search: this.search,
                    search_field: this.searchFieldDefault,
                    period: this.dates
                };

                this.loading = true;
                axios.get('/api/v1/kkm', {params: params})
                    .then(({data}) => {
                        this.total = data.meta.total;
                        this.collectionData = data.data;
                    })
                    .catch((error) => {
                        this.total = 0;
                        this.collectionData = [];
                        throw error;
                    })
                    .finally(() => {
                        this.checkedRows = [];
                        this.loading = false;
                        this.onCheck([]);
                    })
            },
            /*
             * Handle page-change event
             */
            onPageChange(page) {
                this.page = page;
                this.loadAsyncData()
            },
            /*
             * Handle sort event
             */
            onSort(field, order) {
                this.sortField = field;
                this.sortDirection = order;
                this.loadAsyncData()
            },
            /*
             * Handle check event
             */
            onCheck(checkedList) {
                this.$emit('select-device', checkedList)
            },
            /*
             * Handle date change event
             */
            onDateInput(value) {
                this.$emit('period-set', value)
            }
        }
    }
</script>
<style>
    #deviceListButton {
        margin-bottom: 1rem;
    }
</style>
