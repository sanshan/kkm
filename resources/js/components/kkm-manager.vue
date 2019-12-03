<template>
    <div id="kkmManager">
        <div class="columns">
            <div class="column is-full">
                <div id="kkmManagerReportsButton">
                    <b-button
                        type="is-primary"
                        icon-left="download"
                        :disabled="!checkedDevices.length"
                        @click="getReport1"
                    >
                        Сформировать отчёт
<!--                        <download-excel-->
<!--                            :fetch="getReport1"-->
<!--                            :fields = "report1Fields"-->
<!--                            :before-generate="startDownload"-->
<!--                            :before-finish="finishDownload"-->
<!--                        >-->
<!--                            Сформировать отчёт-->
<!--                        </download-excel>-->
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
                >
                </kkm-manager-device-list>
            </div>
        </div>
    </div>
</template>

<script>
    import kkmManagerDeviceList from './kkm-manager-device-list'
    import XLSX from 'xlsx';
    // import JsonExcel from 'vue-json-excel'

    export default {
        components: {
            'kkm-manager-device-list': kkmManagerDeviceList,
            'XLSX': XLSX,
            // 'download-excel': JsonExcel,
        },
        data() {
            return {
                checkedDevices: [],
                report1: [],
                loadingComponent: null,
                // report1Fields: {
                //     'ID': 'id',
                //     'Factory number': 'factory_number',
                //     'Serial number': 'serial_number',
                //     'Gas station number': 'gas_station_id',
                //     'Region number': 'region_id',
                //     'Worked days': 'worked_days'
                // }
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
            async getReport1() {
                const params = {
                    devices: this.checkedDevices
                };
                const response = {};
                try {
                    const response = await axios.post('/reports', {params: params});
                    this.report1 = response.data;
                } catch (error) {
                    console.error(error);
                } finally {
                    // this.loadingComponent.close()
                }

                const devices =  XLSX.utils.json_to_sheet(this.report1);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, devices, 'KKM');
                XLSX.writeFile(wb, 'KKM.xlsx')
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
