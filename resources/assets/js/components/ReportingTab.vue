<template>
    <div>
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
                                :value="$currency.formatNumber(summary.ctr * 100)"
                                unit="%"
                                defaultValue="0.00"
                                size="sm"
                            ></tk-widget>
                        </v-flex>
                        <v-flex xs6 md4 lg2>
                            <tk-widget
                                icon="monetization_on"
                                title="eCPM"
                                :value="$currency.formatNumber(summary.ecpm)"
                                unit="$"
                                defaultValue="0.00"
                                size="sm"
                            ></tk-widget>
                        </v-flex>
                        <v-flex xs6 md4 lg2>
                            <tk-widget
                                icon="star_half"
                                title="eCPC"
                                :value="$currency.formatNumber(summary.ecpc)"
                                unit="$"
                                defaultValue="0.00"
                                size="sm"
                            ></tk-widget>
                        </v-flex>
                        <v-flex xs6 md4 lg2>
                            <tk-widget
                                icon="monetization_on"
                                title="SPEND"
                                :value="$currency.formatNumber($currency.fromMicroDollars(summary.spend))"
                                unit="$"
                                defaultValue="0.00"
                                size="sm"
                            ></tk-widget>
                        </v-flex>
                        <v-flex xs12>
                            <v-card class="elevation-1">
                                <v-card-media :id="graph" class="tapklik-chart" height="350px"> 
                                    <scale-loader 
                                    :loading="true" 
                                    color="#9e9e9e" 
                                    height="15px" 
                                    width="3px" 
                                    class="mt-5"
                                    ></scale-loader>
                                </v-card-media>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
                <v-container fluid grid-list-md>
                    <v-data-table
                    :headers="headers"
                    :items="tableData"
                    :loading="tableLoading"
                    class="elevation-1"
                    :disable-initial-sort="true"
                    >
                        <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                        <template slot="items" scope="props">
                            <td>{{ props.item.date }}</td>
                            <td class="text-xs-right">{{ props.item.imps }}</td>
                            <td class="text-xs-right">{{ props.item.clicks }}</td>
                            <td class="text-xs-right">{{ $currency.formatNumber(props.item.spend) }}</td>
                            <td class="text-xs-right">{{ props.item.ecpc }}</td>
                            <td class="text-xs-right">{{ props.item.ecpm }}</td>
                            <td class="text-xs-right">{{ props.item.ctr }}</td>
                        </template>
                    </v-data-table>
                </v-container>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    props: ['summary', 'graph','tabIndex', 'currentTab', 'tableData', 'tableLoading'],

    data() {
        return {
            headers: [
          {
            text: 'Time',
            align: 'left',
            value: 'date'
          },
          { text: 'Imps', value: 'imps' },
          { text: 'Clicks', value: 'clicks' },
          { text: 'Spend', value: 'spend' },
          { text: 'eCPC', value: 'ecpc' },
          { text: 'eCPM', value: 'ecpm' },
          { text: 'CTR', value: 'ctr' }
        ],
            tabs: {
                overall: 'reportOverall',
                publishers: 'reportPublishers',
                devices: 'reportDevices',
                geo: 'reportGeo'
            },
            report: ''
        }
    },

    methods: {
        getData() {
            var length = this.tabIndex.length;
            var tabIndex = this.tabIndex.slice(0, length - 4);
            this.report = this.tabs[tabIndex];
        }
    },

    watch: {
        tabIndex(value) {
            this.getData();
            value = this.currentTab ? this.$emit('changeData', this.report) : '';
        }
    }
}
</script>