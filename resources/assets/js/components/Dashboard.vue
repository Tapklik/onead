<template>
    <v-container fluid grid-list-lg>
        <v-alert class="mb-2" dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex d-flex md12 lg6>
                <v-card height="300px" class="elevation-1">
                   <v-card-title>
                        <span class="subheading orange--text text--darken-4">OVERALL CHART FOR 10 DAYS</span>
                    </v-card-title>
                    <v-card-media  id="chart_main" class="tapklik-chart" height="250px"> 
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
                            defaultValue="$0.00"
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
                            defaultValue="$0.00"
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
                            defaultValue="0.00%"
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
                            defaultValue="$0.00"
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
                        <span class="subheading orange--text text--darken-4">RECENT CAMPAIGNS</span>
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
                                <v-chip v-if="props.item.status == 'active'" small class="green white--text">
                                    <small>ACTIVE</small>
                                </v-chip>
                                <v-chip v-else-if="props.item.status == 'archived'" small class="yellow darken-2 white--text">
                                    <small>ARCHIVED</small>
                                </v-chip>   
                                <v-chip v-else small class="red white--text">
                                    <small>STOPPED</small>
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
                                <v-chip v-if="props.item.approved == 'approved'" small class="green white--text">
                                    <small>APPROVED</small>
                                </v-chip>
                                <v-chip v-else small class="yellow darken-2 white--text">
                                    <small>NOT APPROVED</small>
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
                        <v-btn icon class="orange--text text--darken-3 ma-0" href="/admin/campaigns">
                            <v-icon>search</v-icon>
                        </v-btn>
                    </v-card-title>
                    <v-data-table v-bind:items="logList" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <span class="title">{{ props.item.log }}</span>
                            </td>
                            
                            <td class="text-xs-right">
                                <span>{{ new Date(props.item.timestamp) }}</span> 
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
        mounted() {
            this.$root.isLoading = false;
        },
        created() {
            this.$root.isLoading = true;
        },
        data() {
            return {
                alert: true,
                success: false,
                error: true,
                alertMessage: 'Something went wrong',
                chartLoaded: false,
                chartDataLoaded: false,
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
                overallSummaryList: {}
            }
        },
        
        props: ['user', 'token','trialdate'],

        methods: {
            Slice(value) {
                return value.slice(0,9)
            },
            loadCampaignsAndCreatives() {
                axios.get(this.$root.uri + '/campaigns', this.$root.config).then(response => {
                    var a = response.data.data;
                    var b = [];
                    for (var item in a) {

                        b.push(a[item]);
                        if(b.length == 5) break;
                    }
                    this.campaignList = b;

                    var listOfCreatives = []
                    var campaigns = this.campaignList
                    for (var c in campaigns) {
                        if(listOfCreatives.length == 5) break;
                        var campaignId = campaigns[c].value
                        var campaignObj = this.findCampaignById(campaignId)
                        
                        var creatives = campaigns[c].creatives.data
                        for (var cr in creatives) {
                            if(listOfCreatives.length == 5) break;
                            listOfCreatives.push(creatives[cr])
                        }
                    }
                    this.creativeList = listOfCreatives;
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
                        if(b.length == 4) break;
                    }
                    this.logList = b;
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong';
                })
            },
            getDate(days) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                var a = this.$root.trialdate;
                let today =  new Date(a);
                let date = new Date(a);
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
                    this.chartDataLoaded = true;
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
                    "balloonText": "g1:[[clicks]]<br>g2:[[imps]]",
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
                "export": {
                    "enabled": true
                },
                "dataProvider": dataset, // Here you need to add the dataset
            });

            chart.addListener("rendered", zoomChart);

            zoomChart(dataset);
            function zoomChart(dataset) {
                    //chart.zoomToIndexes(dataset.length, dataset.length);
                }
            },
        },

        filters: {
            uppercase: function(v) {
              return v.toUpperCase();
          }
      },
        watch: {
            user(value) {
                this.date_from = this.getDate(-10);
                this.date_to = this.getDate(0);
                this.loadMainGraph();
                this.loadMainGraphData();
            },
            chartLoaded(value) {
                this.createChart('chart_main', this.overallList, this.column, this.line);
            },
            token(value) {
                this.loadCampaignsAndCreatives();
                this.loadLog();
            }
        }
    }
</script>
