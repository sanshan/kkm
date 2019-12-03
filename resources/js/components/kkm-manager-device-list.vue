<template>
    <div id="deviceList">

        <div id="deviceListButton" class="columns">
            <div class="column is-3">
                <b-field label="Поиск">
                    <b-input v-model="search" @input="loadAsyncData" value=""></b-input>
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
            <div class="column is-offset-4 is-2">
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
                    @check = "onCheck"
                >

                    <template slot-scope="props">
                        <b-table-column field="id" label="ID" width="40" numeric>
                            {{ props.row.id }}
                        </b-table-column>

                        <b-table-column field="factory_number" label="Заводской номер" sortable>
                            {{ props.row.factory_number }}
                        </b-table-column>

                        <b-table-column field="serial_number" label="Серийный номер" sortable>
                            {{ props.row.serial_number }}
                        </b-table-column>

                        <b-table-column field="gas_station_id" label="АЗС" sortable>
                            {{ props.row.gas_station_id }}
                        </b-table-column>

                        <b-table-column field="region_id" label="Регион" sortable>
                            {{ props.row.region_id }}
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
        {label: 'id', name: 'id'},
        {label: 'Заводской номер', name: 'factory_number'},
        {label: 'Серийный номер', name: 'serial_number'},
        {label: 'АЗС', name: 'gas_station_id'},
        {label: 'Регион', name: 'region_id'}
    ];

    const rowsOnPage = [
        {label: '10', name: '10'},
        {label: '20', name: '20'},
        {label: '50', name: '50'},
        {label: '100', name: '100'},
        {label: '500', name: '500'}
    ];

    export default {
        data() {
            return {
                collectionData,
                fields,
                rowsOnPage,
                checkedRows: [],
                total: 0,
                loading: false,
                sortDirection: 'desc',
                defaultSortDirection: 'desc',
                page: 1,
                perPage: 10,
                perPageDefault: 10,
                search: '',
                searchFieldDefault: 'factory_number',
                sortField: 'gas_station',
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
                    field: this.sortField,
                    search: this.search,
                    search_field: this.searchFieldDefault
                };

                this.loading = true;
                axios.get('/kkm', {params: params})
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
            }
        }
    }
</script>
