<template>
    <v-flex class="text-xs-right">
        <v-btn icon class="grey--text text--lighten2">
            <v-icon>settings</v-icon>
        </v-btn>
        <v-btn icon class="grey--text text--lighten2">
            <v-icon>power_settings_new</v-icon>
        </v-btn>
    </v-flex> 
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
