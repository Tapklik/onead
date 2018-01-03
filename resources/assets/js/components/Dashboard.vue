<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex d-flex md12 lg6>

                <!-- CHART START -->
                <v-card height="300px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            OVERALL CHART FOR 10 DAYS
                        </span>
                    </v-card-title>
                    <v-card-media id="chart_main" class="tapklik-chart" height="250px"> 
                        <scale-loader 
                        :loading="true" 
                        color="#9e9e9e" 
                        height="15px" 
                        width="3px" 
                        class="mt-5"
                        ></scale-loader>
                    </v-card-media>
                </v-card>
                <!-- CHART END -->

            </v-flex>

            <!-- SUMMARY START -->
            <v-flex d-flex xs6 md4 lg2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="photo"
                        title="IMPRESSIONS"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="overall_summary.imps"
                        defaultValue="0"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="monetization_on"
                        title="SPEND"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="$root.fromMicroDollars(overall_summary.spend)"
                        unit="$"
                        defaultValue="0.00"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex d-flex xs6 md4 lg2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="mouse"
                        title="CLICKS"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="overall_summary.clicks"
                        defaultValue="0"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="monetization_on"
                        title="eCPM"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="$root.twoDecimalPlaces(overall_summary.ecpm)"
                        unit="$"
                        defaultValue="0.00"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex d-flex xs6 md4 lg2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="star_half"
                        title="CTR"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="$root.twoDecimalPlaces(overall_summary.ctr * 100)"
                        unit="%"
                        defaultValue="0.00"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <tk-widget
                        icon="monetization_on"
                        title="eCPC"
                        subtitle="TOTAL LAST 10 DAYS"
                        :value="$root.twoDecimalPlaces(overall_summary.ecpc)"
                        unit="$"
                        defaultValue="0.00"
                        size="lg"
                        ></tk-widget>
                    </v-flex>
                </v-layout>
            </v-flex> 
            <!-- SUMMARY END -->

        </v-layout>
        <v-layout row wrap class="mt-2">
            <v-flex d-flex xs12 md4>
                
                <!-- CAMPAIGNS START -->
                <v-card height="350px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            RECENT ACTIVE CAMPAIGNS
                        </span>
                        <v-spacer></v-spacer>
                        <v-btn 
                        icon 
                        class="orange--text text--darken-3 ma-0" 
                        href="/admin/campaigns"
                        >
                            <v-icon>search</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-data-table v-bind:items="campaigns" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <span class="title">{{ props.item.name }}</span>
                            </td>
                            <td>
                                <v-chip small class="green lighten-1 white--text">
                                    <small>ACTIVE</small>
                                </v-chip>
                            </td>
                            <td class="text-xs-right">
                                <span class="caption">{{ props.item.start_time }}</span> 
                                <span class="caption">-</span>
                                &nbsp;
                                <span class="caption">{{ props.item.end_time }}</span>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
                <!-- CAMPAIGNS END -->

            </v-flex>
            <v-flex d-flex xs12 md4>

                <!-- CREATIVES START -->
                <v-card height="350px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            RECENT CREATIVES
                        </span>
                        <v-spacer></v-spacer>
                        <v-btn 
                        icon 
                        class="orange--text text--darken-3 ma-0" 
                        href="/admin/creatives"
                        >
                            <v-icon>search</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-data-table v-bind:items="creatives"  hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <span class="title">{{ props.item.name }}</span>
                            </td>
                            <td>
                                <v-chip 
                                v-if="props.item.approved == 'approved'" 
                                small class="green lighten-1 white--text"
                                >
                                    <small>APPROVED</small>
                                </v-chip>
                                <v-chip 
                                v-else-if="props.item.approved == 'pending'" 
                                small 
                                class="yellow darken-1 white--text"
                                >
                                    <small>PENDING</small>
                                </v-chip>
                                <v-chip 
                                v-else 
                                small 
                                class="red lighten-1 white--text"
                                >
                                    <small>DECLINED</small>
                                </v-chip>
                            </td>
                            <td class="text-xs-right">
                                <span>{{ props.item.class }}</span> 
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
                <!-- CREATIVES END -->

            </v-flex>
            <v-flex d-flex xs12 md4>

                <!-- LOG START -->
                <v-card height="350px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            LOG
                        </span>
                        <v-spacer></v-spacer>
                    </v-card-title>
                    <v-data-table v-bind:items="logs" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                            <v-icon>person</v-icon>
                            </td>
                            <td class="caption text-xs-right">
                                <span>
                                    {{ formatLogTime(props.item.taken_at.date) }} <br />
                                    {{ formatLogDate(props.item.taken_at.date) }}
                                </span> 
                            </td>
                            <td>
                                <span class="small">{{ props.item.action }}</span>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
                <!-- LOG END -->

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.date_from = this.getDate(-10);
            this.date_to = this.getDate(0);
            this.$root.isLoading = false;
        },
        
        data() {
            return {
                //CHART
                chartLoaded: false,
                overall_data: [],
                date_from: '',
                date_to: '',
                column: 'clicks',
                line: 'imps',
                
                //SUMMARY
                overall_summary: {
                    clicks: 0,
                    imps: 0,
                    ecpm: 0,
                    ctr: 0,
                    ecpc: 0,
                    spend: 0
                },

                //CAMPAIGNS
                campaigns: [],

                //CREATIVES
                folders: [],
                creatives: [],
                
                //LOG
                logs: []
            }
        },
        
        props: ['user', 'token'],

        methods: {

            //OVERALL
            filterDataSize(number_of_items, dataset, reverse) {
                if(reverse) dataset.reverse(); //put in chronological order
                var excess = dataset.length - number_of_items; //look for number of items that are more than required
                if(excess > 0) dataset.splice(number_of_items, excess); //delete those items
                return dataset;
            },

            getDate(days) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let today = new Date();
                let date = new Date();
                date.setDate(today.getDate() + days);
                let year = date.getFullYear();
                let month = toTwoDigits(date.getMonth() + 1);
                let day = toTwoDigits(date.getDate()); 
                return `${year}-${month}-${day}`;
            },

            //CHART
            getOverallData() {
                axios.get(
                    this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=sum&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00&scale=1d', 
                    this.$root.config
                ).then(response => {
                            this.overall_data = response.data.data;
                            this.createChart('chart_main', this.overall_data, this.column, this.line);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            createChart(target, dataset, column, line) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 40,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "labelsEnabled": false,
                        "ignoreAxisWidth":true
                    },
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "labelsEnabled": false,
                        "ignoreAxisWidth":true
                    }
                    ],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "column",
                        "fillAlphas": 1,
                        "fillColors":"#ccc",
                        "lineColor":"#ccc",
                        "lineThickness": 2,
                        "balloonText": "[[date]] <br> ---------------- <br> Clicks: [[clicks]]<br>Imps: [[imps]]",
                        "title": "Imps",
                        "valueField": column,
                    },
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "smoothedLine",
                        "lineColor":"#f76c06",
                        "showBalloon": false,
                        "lineThickness": 2,
                        "title": "Clicks",
                        "valueField": line,
                        
                    }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 0,
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "minPeriod": "DD",
                        "minorGridEnabled": false
                    },
                    "balloon": {
                        "borderColor": "#f76c06",
                        "borderAlpha": 0,
                        "borderThickness": 0,
                        "shadowAlpha": 0,
                        "color": "#ffffff",
                        "drop": false,
                        "cornerRadius": 5,
                        "fillColor": "#f76c06",
                        "fillAlpha": 1,
                    },
                    "legend": {
                        "useGraphSettings": true
                    },
                    "export": {
                        "enabled": true
                    },
                    "dataProvider": dataset, // Here you need to add the dataset
                });
            },

            //SUMMARY
            getOverallSummary() {
                axios.get(
                    this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=summary&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00', 
                    this.$root.config
                ).then(response => {
                        if(response.data.data != undefined) {
                            this.overall_summary = response.data.data;
                        }
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            //CREATIVES
            getFolders() {        
                axios.get(
                    this.$root.uri + '/creatives/folders', 
                    this.$root.config
                ).then(response => {
                        this.folders = response.data.data;
                    }, error => {     
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            getCreatives() {
                var folders = this.folders;
                var creatives = [];
                for (var folder in folders) {
                    axios.get(
                        this.$root.uri + '/creatives/' +  this.user.accountUuId + '/folders/' + folders[folder].id, 
                        this.$root.config
                    ).then(response => {
                            this.creatives.push(response.data.data);
                            this.creatives = [].concat.apply([], this.creatives);
                        }, error => {
                            this.$root.showAlertPopUp('error', 'Something went wrong.');
                        }
                    );
                }
                this.creatives = this.filterDataSize(5, this.creatives, true);
            },

            //CAMPAIGNS
            getCampaigns() {
                axios.get(
                    this.$root.uri + '/accounts/' + this.user.accountUuId + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        var campaigns = response.data.data;
                        campaigns = campaigns.filter(campaign => campaign.status == 'active');
                        this.campaigns = this.filterDataSize(5, campaigns, true);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            //LOGS
            getLogs() {
                axios.get(
                    this.$root.uri + '/accounts/log', 
                    this.$root.config
                ).then(response => {
                        this.logs = this.filterDataSize(5, response.data.data);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            formatLogTime(t) {
                var timestamp = new Date(t)
                var hours = timestamp.getHours();
                var minutes = "0" + timestamp.getMinutes();
                var seconds = "0" + timestamp.getSeconds();
                var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
                return formattedTime
            },

            formatLogDate(t) {
                var timestamp = new Date(t)
                var year = timestamp.getFullYear();
                var month = "0" + timestamp.getMonth();
                var day = "0" + timestamp.getDate();
                var formattedDate = year + '.' + month.substr(-2) + '.' + day.substr(-2);
                return formattedDate
            }
        },

        watch: {
            user(value) {
                this.getCampaigns();
                setTimeout(this.getOverallData(), 2000);
                setTimeout(this.getOverallSummary(), 2000);
            },

            token(value) {
                this.getFolders();
                this.getLogs();
            },

            folders(value) {
                this.getCreatives();
            }
        }
    }
</script>
