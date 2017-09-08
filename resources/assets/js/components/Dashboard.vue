<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex d-flex xs12 md6>
                <v-card height="400px">

                </v-card>
            </v-flex>
            <v-flex d-flex xs6 md2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <v-card height="192px">
                            <v-card-title class="orange--text text--darken-4">
                                <v-flex xs12>
                                    <v-layout row>
                                        <v-flex xs12 class="pa-0">
                                            <span class="subheading right">CLICKS</span>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row>
                                        <v-flex xs12 class="pa-0">
                                            <span class="display-4 right">430</span>
                                        </v-flex>
                                    </v-layout>    
                                </v-flex>
                            </v-card-title>
                        </v-card>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <v-card height="192px" class="orange--text text--darken-4">

                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex d-flex xs6 md2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <v-card height="192px" class="orange--text text--darken-4">

                        </v-card>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <v-card height="192px" class="orange--text text--darken-4">

                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex d-flex xs6 md2>
                <v-layout row wrap>
                    <v-flex d-flex xs12>
                        <v-card height="192px" class="orange--text text--darken-4">

                        </v-card>
                    </v-flex>
                    <v-flex d-flex xs12>
                        <v-card height="192px" class="orange--text text--darken-4">

                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex> 
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        mounted() {
        },
        data() {
            return {
                password: '',
                campaignList: [],
                creativeList: [],
                token: this.token,
                date_from: this.getDate(-7),
                date_to: this.getDate(0),
                column: 'clicks',
                line: 'imps',
                overallList: false
            }
        },
        
        props: ['user'],

        methods: {
            loadCampaignsAndCreatives() {
                axios.get(this.$root.uri + '/campaigns', this.$root.config).then(response => {
                    this.campaignList = response.data.data;

                    var listOfCreatives = []
                    var campaigns = this.campaignList
                    for (var c in campaigns) {
                        var campaignId = campaigns[c].value
                        var campaignObj = this.findCampaignById(campaignId)
                        
                        var creatives = campaigns[c].creatives.data
                        for (var cr in creatives) {
                            listOfCreatives.push(creatives[cr])
                        }
                    }
                    this.creativeList = listOfCreatives;
                }, error => {
                    swal('Error', 'error', 'error');
                })
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

            loadMainGraph() {

                axios.get(this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=sum&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00&scale=1h', this.$root.config).then(response => {
                    this.overallList = response.data.data;
                    this.createChart('chart_main', this.overallList, this.column, this.line);
                    this.createChart('chart_clicks', this.overallList, 'clicks');
                    this.createChart('chart_imps', this.overallList, 'imps');
                    this.createChart('chart_spend', this.overallList, 'spend');
                    this.createChart('chart_ctr', this.overallList, 'ctr');
                    this.createChart('chart_ecpc', this.overallList, 'ecpc');
                    this.createChart('chart_ecpm', this.overallList, 'ecpm');
                }, error => {
                    swal('Error', 'Could not load main graph', 'error');
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
                    "position": "left",
                    "ignoreAxisWidth":true
                },
                {
                    "id": "v2",
                    "axisAlpha": 0,
                    "position": "right",
                    "ignoreAxisWidth":true
                }
                ],
                "balloon": {
                    "borderThickness": 1,
                    "shadowAlpha": 0
                },
                "graphs": [{
                    "valueAxis": "v1",
                    "id": "g1",
                    "type" : "column",
                    "fillAlphas": 0.8,
                    "fillColors":"#f76c06",
                    "lineColor":"#f76c06",
                    "balloonColor":"#444",
                    "balloon":{
                        "drop":true,
                        "adjustBorderColor":false,
                        "color":"#ffffff"
                    },
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "title": "red line",
                    "useLineColorForBulletBorder": true,
                    "valueField": column,
                    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                },
                {   
                    "valueAxis": "v2",
                    "id": "g2",
                    "type" : "line",
                    "fillColors":"#f76c06",
                    "lineColor":"magenta",
                    "balloonColor":"#444",
                    "balloon":{
                        "drop":true,
                        "adjustBorderColor":false,
                        "color":"#ffffff"
                    },
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "title": "red line",
                    "useLineColorForBulletBorder": true,
                    "valueField": line,
                    "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
                    
                }],
                "chartCursor": {
                    "pan": true,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "cursorAlpha":1,
                    "cursorColor":"#444",
                    "limitToGraph":"g1",
                    "valueLineAlpha":0.2,
                    "valueZoomable":true
                },
                "categoryField": "date",
                "categoryAxis": {
                    "parseDates": true,
                    "dashLength": 1,
                    "minPeriod" : "hh",
                    "minorGridEnabled": true
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


        watch: {

        }
    }
</script>