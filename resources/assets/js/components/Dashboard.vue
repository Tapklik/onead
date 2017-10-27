<template>
    <v-container fluid grid-list-lg>
        <v-alert class="mb-2" dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex d-flex md12 lg6>
                <v-card height="300px" class="elevation-1">
                   <v-card-title>
                        <span class="subheading orange--text text--darken-4">OVERALL CHART FOR 10 DAYS</span>
                    </v-card-title>
                    <v-card-media id="chart_main" class="tapklik-chart" height="250px"> 
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-media>
                </v-card>
            </v-flex>
            <v-flex d-flex xs6 md4 lg2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <tk-widget
                            icon="photo"
                            title="IMPRESSIONS"
                            subtitle="TOTAL LAST 10 DAYS"
                            :value="overallSummaryList.imps"
                            defaultValue="0"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <tk-widget
                            icon="monetization_on"
                            title="SPEND"
                            subtitle="TOTAL LAST 10 DAYS"
                            :value="$root.fromMicroDollars(overallSummaryList.spend)"
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
                            :value="overallSummaryList.clicks"
                            defaultValue="0"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <tk-widget
                            icon="monetization_on"
                            title="eCPM"
                            subtitle="TOTAL LAST 10 DAYS"
                            :value="$root.twoDecimalPlaces(overallSummaryList.ecpm)"
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
                            :value="$root.twoDecimalPlaces(overallSummaryList.ctr * 100)"
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
                            :value="$root.twoDecimalPlaces(overallSummaryList.ecpc)"
                            unit="$"
                            defaultValue="0.00"
                            size="lg"
                        ></tk-widget>
                    </v-flex>
                </v-layout>
            </v-flex> 
        </v-layout>
        <v-layout row wrap>
            <v-flex d-flex xs12 md4>
                <v-card height="350px" class="elevation-1">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">RECENT ACTIVE CAMPAIGNS</span>
                        <v-spacer></v-spacer>
                        <v-btn icon class="orange--text text--darken-3 ma-0" href="/admin/campaigns">
                            <v-icon>search</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-data-table v-bind:items="campaignList" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <span class="title">{{ props.item.name }}</span>
                            </td>
                            <td>
                                <v-chip v-if="props.item.status == 'active'" small class="green lighten-1 white--text">
                                    <small>ACTIVE</small>
                                </v-chip>
                            </td>
                            <td class="text-xs-right">
                                <span class="caption">{{ props.item.start_time }}</span> 
                                <span class="caption">-</span>&nbsp;<span class="caption">{{ props.item.end_time }}</span>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
            <v-flex d-flex xs12 md4>
                <v-card height="350px" class="elevation-1">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">RECENT CREATIVES</span>
                        <v-spacer></v-spacer>
                        <v-btn icon class="orange--text text--darken-3 ma-0" href="/admin/creatives">
                            <v-icon>search</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-data-table v-bind:items="creativeList"  hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <span class="title">{{ props.item.name }}</span>
                            </td>
                            <td>
                                <v-chip v-if="props.item.approved == 'approved'" small class="green lighten-1 white--text">
                                    <small>APPROVED</small>
                                </v-chip>
                                <v-chip v-else-if="props.item.approved == 'pending'" small class="yellow darken-1 white--text">
                                    <small>PENDING</small>
                                </v-chip>
                                <v-chip v-else small class="red lighten-1 white--text">
                                    <small>DECLINED</small>
                                </v-chip>
                            </td>
                            <td class="text-xs-right">
                                <span>{{ props.item.class }}</span> 
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
            <v-flex d-flex xs12 md4>
                <v-card height="350px" class="elevation-1">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">LOG</span>
                        <v-spacer></v-spacer>
                        <!-- <v-btn icon class="orange--text text--darken-3 ma-0" href="/admin/campaigns">
                            <v-icon>search</v-icon>
                        </v-btn> -->
                    </v-card-title>
                    <v-data-table v-bind:items="logList" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                            <v-icon>person</v-icon>
                            </td>
                            <td class="caption text-xs-right">
                                <span>{{ formatLogTime(props.item.timestamp) }}<br>{{ formatLogDate(props.item.timestamp) }}</span> 
                            </td>
                            <td>
                                <span class="small">{{ props.item.log }}</span>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
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
            this.$root.isLoading = false;
        },
        
        data() {
            return {
                alert: false,
                success: false,
                error: false,
                alertMessage: '',
                chartLoaded: false,
                totalItems: 5,
                password: '',
                campaignList: [],
                creativeList: [],
                logList: [],
                date_from: '',
                date_to: '',
                column: 'clicks',
                line: 'imps',
                overallList: false,
                search: '',
                pagination: {},
                overallSummaryList: {},
                folders: [],
                something: []
            }
        },
        
        props: ['user', 'token'],

        methods: {
            Slice(value) {
                return value.slice(0,9)
            },

            getFolders() {
                var self = this;
                var folders = [];
                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {
                    this.folders = response.data.data;
                    folders = response.data.data;
                }, error => {
                    alert(error);
                });
                var creatives = [];
                for (var f in folders) {
                    axios.get(this.$root.uri + '/creatives/' +  this.user.accountUuId + '/folders/' + folders[f].id, this.$root.config).then(response => {
                    var a = response.data;
                    creatives.push(a);
                }, error => {
                    alert(error);
                });
                }
                this.something = creatives;
            },

            getCreatives() {
                var folders = this.folders;
                var creatives = [];
                for (var f in folders) {
                    axios.get(this.$root.uri + '/creatives/' +  this.user.accountUuId + '/folders/' + folders[f].id, this.$root.config).then(response => {
                        var a = response.data.data;
                        var c = a.length -1;
                        for (var i = c; i > 0; i--) {
                            creatives.push(a[i]);
                            if(creatives.length == 5) break;
                        }
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                });
                }
                this.creativeList = creatives;
            },

            loadCampaignsAndCreatives() {
                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/campaigns', this.$root.config).then(response => {
                    var a = response.data.data;
                    var c = a.length - 1;
                    var b = [];
                    for (var item = c; item >= 0; item--) {
                        if(a[item].status == 'active') {
                            b.push(a[item]);
                            if(b.length == 5) break;
                        }
                    }
                    this.campaignList = b;
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                })
            },

            loadLog() {
                axios.get(this.$root.uri + '/accounts/log', this.$root.config).then(response => {
                    var a = response.data.data;
                    var b = [];
                    for (var item in a) {
                        b.push(a[item]);
                        if(b.length == 5) break;
                    }
                    this.logList = b;
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                })
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
            },

            getDate(days) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let today =  new Date();
                let date = new Date();
                date.setDate(today.getDate() + days);
                let year = date.getFullYear();
                let month = toTwoDigits(date.getMonth() + 1);
                let day = toTwoDigits(date.getDate()); 
                return `${year}-${month}-${day}`;
            },

            loadMainGraph() {

                axios.get(this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=sum&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00' + '&scale=1d', this.$root.config).then(response => {
                    this.overallList = response.data.data;
                    this.chartLoaded = true;
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                })
            },

            loadMainGraphData() {

                axios.get(this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=summary&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00', this.$root.config).then(response => {
                    this.overallSummaryList = response.data.data;
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                })
            },

            findCampaignById(id) {
                var campaignList = this.campaignList
                for (var c in campaignList) {
                    if (campaignList[c].id == id) return campaignList[c] 
                }
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

        },

        filters: {
            uppercase: function(v) {
                return v.toUpperCase();
            },
        },

        watch: {
            user(value) {
                this.date_from = this.getDate(-10);
                this.date_to = this.getDate(0);
                this.loadCampaignsAndCreatives();
                setTimeout(this.loadMainGraph(), 2000);
                setTimeout(this.loadMainGraphData(), 2000);
                this.getFolders();
            },

            chartLoaded(value) {
                setTimeout(this.createChart('chart_main', this.overallList, this.column, this.line), 2000);
            },

            token(value) {
                this.loadLog();
            },

            folders(value) {
                this.getCreatives();
            }
        }
    }
</script>
