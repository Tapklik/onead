<template>
    <v-card>
        <v-card-text>
            <v-container fluid grid-list-md>
                <v-layout row wrap>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="photo"
                            title="IMPRESSIONS"
                            :value="summary.imps"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="CLICKS"
                            :value="summary.clicks"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="mouse"
                            title="CTR"
                            :value="$root.twoDecimalPlaces(summary.ctr * 100)"
                            unit="%"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="eCPM"
                            :value="$root.twoDecimalPlaces(summary.ecpm)"
                            unit="$"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="star_half"
                            title="eCPC"
                            :value="$root.twoDecimalPlaces(summary.ecpc)"
                            unit="$"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs6 md4 lg2>
                        <tk-widget
                            icon="monetization_on"
                            title="SPEND"
                            :value="$root.fromMicroDollars(summary.spend)"
                            unit="$"
                            defaultValue="0.00"
                            size="sm"
                        ></tk-widget>
                    </v-flex>
                    <v-flex xs12>
                        <v-card class="elevation-1">
                            <v-card-media :id="graph" class="tapklik-chart" height="350px"> 
                                <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                            </v-card-media>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    props: ['summary', 'graph','tabIndex', 'currentTab'],

    data() {
        return {
            tabs: {
                overall: 'reportOverall',
                publishers: 'reportPublishers',
                devices: 'reportDevices',
                geo: 'reportGeo'
            },

            hello: {
                response: [],
                responseSummary: {},
                report: ''
            }
        }
    },

    methods: {
        getData() {
            var length = this.tabIndex.length;
            var tabIndex = this.tabIndex.slice(0, length - 4);
            this.hello.report = this.tabs[tabIndex];
        }
    },

    watch: {
        tabIndex(value) {
            this.getData();
            value = this.currentTab ? this.$emit('changeData', this.hello.report) : '';
        }
    }
}
</script>