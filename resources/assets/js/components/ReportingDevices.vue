<template>
    <v-card>
        <v-card-text>
            <v-container fluid grid-list-md>
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="internalAlert" transition="scale-transition">{{alertMessage}}</v-alert>
                <v-layout row wrap>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="photo"
                            title="Impressions"
                            :value="responseDevicesSummary.imps"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="Clicks"
                            :value="responseDevicesSummary.clicks"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="mouse"
                            title="CTR"
                            :value="$root.twoDecimalPlaces(responseDevicesSummary.ctr * 100)"
                            unit="%"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="eCPM"
                            :value="responseDevicesSummary.ecpm "
                            unit="$"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="star_half"
                            title="eCPC"
                            :value="responseDevicesSummary.ecpc "
                            unit="$"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="Spend"
                            :value="$root.fromMicroDollars(responseDevicesSummary.spend)"
                            unit="$"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md4>
            <v-select :items="technologiesList.devices" item-text="type" item-value="device_id" chips v-model="selectedDevicesTypes1" label="Devices" multiple autocomplete></v-select>
            </v-flex>
                <v-flex xs12 md4>
            <v-select :items="technologiesList.operatingsystems" item-text="type" chips item-value="type" v-model="selectedDevicesOs1" label="Operating Systems" multiple autocomplete></v-select>
            </v-flex>
                <v-flex xs12 md4>
            <v-select :items="technologiesList.browsers" item-text="type" chips item-value="type" v-model="selectedDevicesUa1" label="Browsers" multiple autocomplete></v-select>
            </v-flex>
            </v-layout>
            
                <v-container id="chart_devices" style="height: 500px;"></v-container>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>

    export default {

        data() {
            return {
                internalSelectedDevicesUa: [],
                internalSelectedDevicesOs:[],
                internalSelectedDevicesTypes:[],
                internalAlert: false,
                internalError: false,
                internalSuccess: false,
                internalAlertMessage: false,
            }
        },

        created() {
            this.internalSelectedDevicesUa = this.selectedDevicesUa1;
            this.internalSelectedDevicesOs = this.selectedDevicesOs1;
            this.internalSelectedDevicesTypes = this.selectedDevicesTypes1;
            this.internalSuccess = this.success;
            this.internalError = this.error;
            this.internalAlert = this.alert;
            this.internalAlertMessage = this.alertMessage;
        },
        
        mounted() {

        },

        props:['alert', 'error', 'success', 'alertMessage', 'responseDevicesSummary', 'technologiesList','selectedDevicesUa1','selectedDevicesOs1','selectedDevicesTypes1'],

        data() {
            return {
            }
        },
        
        computed: {
    
        },

        methods: {


},

watch: {
    alert(value) {
        this.$emit('input', this.internalAlert);
    }
 }
}
</script>
