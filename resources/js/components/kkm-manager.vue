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
                            :fetch="getReport1"
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
            async getReport1() {
                const params = {
                    devices: this.checkedDevices,
                    period: this.period
                };
                const response = {};
                try {
                    const response = await axios.post('/reports', {params: params});
                    return response.data;
                } catch (error) {
                    console.error(error);
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
