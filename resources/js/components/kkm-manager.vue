<template>
    <div id="kkmManager">
        <div class="columns">
            <div class="column is-full">
                <div id="kkmManagerReportsButton">
                    <b-button
                        type="is-primary"
                        icon-left="download"
                        :disabled="!checkedDevices.length">
                        <download-excel
                            :fetch="getReport"
                            :fields="report1Fields"
                            :before-generate="startDownload"
                            :before-finish="finishDownload">

                            Сформировать отчёт
                        </download-excel>
                    </b-button>

                    <b-taglist attached>
                        <b-tag type="is-light">ККМ выбрано</b-tag>
                        <b-tag type="is-info">{{ deviceCount }}</b-tag>
                    </b-taglist>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-full">
                <kkm-manager-device-list
                    @select-device="updateDeviceCollection"
                    @period-set="periodSet">
                </kkm-manager-device-list>
            </div>
        </div>
    </div>
</template>

<script>
    import kkmManagerDeviceList from './kkm-manager-device-list'
    import JsonExcel from 'vue-json-excel'

    export default {
        components: {
            'kkm-manager-device-list': kkmManagerDeviceList,
            'download-excel': JsonExcel,
        },
        data() {
            return {
                checkedDevices: [],
                report1: [],
                loadingComponent: null,
                period: [],
                report1Fields: {
                    'ID': 'id',
                    'Серийный номер': 'serial',
                    'АЗС': 'azs',
                    'Регион': 'region',
                    'Отработано дней': 'worked_days'
                }
            }
        },
        computed: {
            deviceCount() {
                return this.checkedDevices.length
            },
        },
        methods: {
            updateDeviceCollection(checkedDevices) {
                this.checkedDevices = checkedDevices
            },
            periodSet(period) {
                this.period = period
            },
            async getReport() {
                console.log(this.period);
                try {
                    const response = await axios.post('/reports', {
                        devices: this.checkedDevices,
                        period: this.period.map(date => {
                            let tzoffset = (new Date()).getTimezoneOffset() * 60000;
                            return (new Date(date - tzoffset)).toISOString();
                        }),
                        title: 'number_of_days_worked_by_kkm',
                    });
                    return response.data;
                } catch (error) {
                    this.$buefy.toast.open({
                        duration: 2000,
                        message: error.response.data.message,
                        position: 'is-bottom',
                        type: 'is-danger'
                    })
                } finally {
                    this.loadingComponent.close()
                }

            },
            startDownload() {
                this.loadingComponent = this.$buefy.loading.open()
            },
            finishDownload() {
                this.loadingComponent.close()
            }

        }
    }
</script>
