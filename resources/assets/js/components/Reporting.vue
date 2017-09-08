<template>
    <v-container fluid grid-list-md>
        <v-tabs dark fixed icons v-model="tabIndex">
            <v-tabs-bar class="grey">
                <v-tabs-slider class="yellow"></v-tabs-slider>
                <v-tabs-item href="#overall-tab">
                    <v-icon>present_to_all</v-icon>
                    Overall
                </v-tabs-item>
                <v-tabs-item href="#publisher-tab">
                    <v-icon>mdi-newspaper</v-icon>
                    Publishers
                </v-tabs-item>
                <v-tabs-item href="#devices-tab">
                    <v-icon>devices</v-icon>
                    Technologies
                </v-tabs-item>
                <v-tabs-item href="#geo-tab">
                    <v-icon>public</v-icon>
                    Geo
                </v-tabs-item>
                <v-btn @click="generateCharts()">
                    Generate
                </v-btn>
            </v-tabs-bar>
            <v-tabs-items>
                <v-tabs-content id="overall-tab">
                    <v-card>
                        <v-card-text>
                            <v-container>
                                <v-layout>
                                    <v-flex>
                                        <span> Impressions </span>
                                        <h5>{{ responseOverallSummary.imps }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Clicks </span>
                                        <h5>{{ responseOverallSummary.clicks }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> CTR </span>
                                        <h5>{{ responseOverallSummary.ctr }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPM </span>
                                        <h5>{{ responseOverallSummary.ecpm }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPC </span>
                                        <h5>{{ responseOverallSummary.ecpc }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Spend </span>
                                        <h5>{{ responseOverallSummary.spend }}</h5>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-container id="chart_overall" style="height: 500px;"></v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <v-tabs-content id="publisher-tab">
                    <v-card flat>
                        <v-card-text>
                            <v-container>
                                <v-layout>
                                    <v-flex>
                                        <span> Impressions </span>
                                        <h5>{{ responsePublishersSummary.imps }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Clicks </span>
                                        <h5>{{ responsePublishersSummary.clicks }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> CTR </span>
                                        <h5>{{ responsePublishersSummary.ctr }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPM </span>
                                        <h5>{{ responsePublishersSummary.ecpm }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPC </span>
                                        <h5>{{ responsePublishersSummary.ecpc }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Spend </span>
                                        <h5>{{ responsePublishersSummary.spend }}</h5>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-select :items="publisherList" item-text="site" item-value="site" chips v-model="selectedPublishers" label="Select" multiple autocomplete></v-select>
                            <v-container id="chart_publisher" style="height: 500px;"></v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <v-tabs-content id="devices-tab">
                    <v-card flat>
                        <v-card-text>
                            <v-container>
                                <v-layout>
                                    <v-flex>
                                        <span> Impressions </span>
                                        <h5>{{ responseDevicesSummary.imps }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Clicks </span>
                                        <h5>{{ responseDevicesSummary.clicks }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> CTR </span>
                                        <h5>{{ responseDevicesSummary.ctr }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPM </span>
                                        <h5>{{ responseDevicesSummary.ecpm }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPC </span>
                                        <h5>{{ responseDevicesSummary.ecpc }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Spend </span>
                                        <h5>{{ responseDevicesSummary.spend }}</h5>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-container id="chart_devices" style="height: 500px;"></v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <v-tabs-content id="geo-tab">
                    <v-card flat>
                        <v-card-text>
                            <v-container>
                                <v-layout>
                                    <v-flex>
                                        <span> Impressions </span>
                                        <h5>{{ responseGeoSummary.imps }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Clicks </span>
                                        <h5>{{ responseGeoSummary.clicks }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> CTR </span>
                                        <h5>{{ responseGeoSummary.ctr }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPM </span>
                                        <h5>{{ responseGeoSummary.ecpm }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> eCPC </span>
                                        <h5>{{ responseGeoSummary.ecpc }}</h5>
                                    </v-flex>
                                    <v-flex>
                                        <span> Spend </span>
                                        <h5>{{ responseGeoSummary.spend }}</h5>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                            <v-container id="chart_geo" style="height: 500px;"></v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
            </v-tabs-items>
        </v-tabs>
    </v-container>
</template>

<script>

    export default {

        mounted() {

            this.loadCategories();
            this.loadTechnologies();
            this.loadReportDevices();
            this.loadReportGeo();
            this.loadReportPublishers();
            this.loadReportOverall();
            this.loadCountries();
            this.loadPublishers();
            this.drawDummy();

        },

        props: ['user', 'token'],

        data() {
            return {
                tabIndex: 'overall-tab',
                line: 'imps',
                column: 'clicks',
                dateFormat: 'yyyy-MM-dd',
                showModal1: false,
                showModal2: false,
                date_from: this.getDate(-100),
                date_to: this.getDate(0),
                selectedCampaigns: [],
                selectedCreatives: [],
                selectedDevicesTypes: [],
                selectedDevicesOs: [],
                selectedDevicesUa: [],
                selectedPublishers: [],
                selectedGeoCountries: [],
                categoriesList: [],
                technologiesList: [],
                campaignList: [],
                responseOverallList: [],
                responsePublishersList: [],
                responseDevicesList: [],
                responseGeoList: [],
                responseDevicesSummary: {clicks: 0, imps: 0, spend: 0, ctr: 0, ecpm: 0, ecpc:0},
                responsePublishersSummary: {clicks: 0, imps: 0, spend: 0, ctr: 0, ecpm: 0, ecpc:0},
                responseOverallSummary: {clicks: 0, imps: 0, spend: 0, ctr: 0, ecpm: 0, ecpc:0},
                responseGeoSummary: {clicks: 0, imps: 0, spend: 0, ctr: 0, ecpm: 0, ecpc:0},
                reportLoaded: false,
                countriesList: [],
                publisherList: [],
                reportDevices: [],
                reportGeo: [],
                reportOverall: [],
                reportPublishers: [],
                request: ''
            }
        },
        
        computed: {
            dateChosen() {
                return this.date_from + ' to ' + this.date_to
            },

            startingData() {
                return {
                    data: [
                    {
                        clicks: [
                        {
                            date: this.date_from, 
                            value: 0
                        }, 
                        {
                            date: this.date_to,
                            value:0
                        }
                        ]
                    },
                    {
                        imps: [
                        {
                            date: this.date_from, 
                            value: 0
                        }, 
                        {
                            date: this.date_to,
                            value:0
                        }
                        ] 
                    },
                    {
                        spend: [
                        {
                            date: this.date_from, 
                            value: 0
                        }, 
                        {
                            date: this.date_to,
                            value:0
                        }
                        ]
                    }
                    ]
                }

            }            
        },

        methods: {

            drawDummy() {
                this.createChart('chart_devices', this.startingData.data[0].clicks)
                this.createChart('chart_overall', this.startingData.data[0].clicks)
                this.createChart('chart_geo', this.startingData.data[0].clicks)
                this.createChart('chart_publisher', this.startingData.data[0].clicks)

            },
            getCreatives() {
                var listOfCreatives = []
                var campaigns = this.selectedCampaigns
                for (var c in campaigns) {
                    var campaignId = campaigns[c].value
                    var campaignObj = this.findCampaignById(campaignId)
                    var creatives = campaignObj.creatives.data
                    for (var cr in creatives) {
                        listOfCreatives.push(creatives[cr])
                    }
                }
                return listOfCreatives
            },

            findCampaignById(id) {
                var campaignList = this.campaignList
                for (var c in campaignList) {
                    if (campaignList[c].id == id) return campaignList[c] 
                }
        },

        fetchCampaigns() {

            axios.get(this.$root.uri + '/campaigns', this.$root.config).then(response => {
                this.campaignList = response.data.data;
            }, error => {
                swal('Error', 'Could not load campaigns', 'error');
            })
        },

        loadCategories() {

            axios.get('/data/categories.json').then(response => {
                this.categoriesList = response.data;
            }, error => {
                swal('Error', 'Could not load categories', 'error');
            });
        },

        loadTechnologies() {

            axios.get('/data/technologies.json').then(response => {
                this.technologiesList = response.data;
            }, error => {
                swal('Error', 'Could not load technologies', 'error');
            });
        },

        loadCountries() {

            axios.get('/data/countries.json').then(response => {
                this.countriesList = response.data;
            }, error => {
                swal('Error', 'Could not load countries', 'error');
            });
        },

        loadPublishers() {

            axios.get('/data/publishers.json').then(response => {
                this.publisherList = response.data;
            }, error => {
                swal('Error', 'Could not load publishers', 'error');
            });
        },

        loadReportGeo() {

            axios.get('/data/reportGeo.json').then(response => {
                this.reportGeo = response.data;
            }, error => {
                swal('Error', 'Could not load reportGeo', 'error');
            });
        },

        loadReportOverall() {

            axios.get('/data/reportOverall.json').then(response => {
                this.reportOverall = response.data;
            }, error => {
                swal('Error', 'Could not load reportOverall', 'error');
            });
        },

        loadReportDevices() {

            axios.get('/data/reportDevices.json').then(response => {
                this.reportDevices = response.data;
            }, error => {
                swal('Error', 'Could not load reportDevices', 'error');
            });
        },

        loadReportPublishers() {

            axios.get('/data/reportPublishers.json').then(response => {
                this.reportPublishers = response.data;
            }, error => {
                swal('Error', 'Could not load reportPublishers', 'error');
            });
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
                "chartScrollbar": {
                    "graph": "g1",
                    "oppositeAxis":false,
                    "offset":30,
                    "scrollbarHeight": 80,
                    "backgroundAlpha": 0,
                    "selectedBackgroundAlpha": 0.1,
                    "selectedBackgroundColor": "#888888",
                    "graphFillAlpha": 0,
                    "graphLineAlpha": 0.5,
                    "selectedGraphFillAlpha": 0,
                    "selectedGraphLineAlpha": 1,
                    "autoGridCount":true,
                    "color":"#AAAAAA"
                },
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

chart.addListener("rendered", removeLogo);

function removeLogo() {
    $('.amcharts-chart-div').find('a').each(function(index, item) {
        $(item).hide();
    });
}

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

generateQuery(queryList, scale, chartOrSum) {

    var queries = queryList.queries;
    var table = queryList.table;
    var account = this.user.accountUuId;
    var dims = this.getQueryDims(queryList);
    var filters = this.getQueryFilters(queryList);

    var request = ''
    for (var dim in dims) {
        request += '&' + dims[dim].name + '=' + dims[dim].value
        table += '_' + dims[dim].name
    }
    for (var filter in filters) {
        table  += '_' + filters[filter].name
        for(var sub_filter in filters[filter].sub_filters) {
            request += '&' + filters[filter].name + '_' + filters[filter].sub_filters[sub_filter].name + '=' 
            request += filters[filter].sub_filters[sub_filter].value
            table +=  '_' + filters[filter].sub_filters[sub_filter].name
        }
    }

    var queriesString = '&field=' + queries.queries_list.join(',') + '&op=' + chartOrSum

    scale = scale != '' ? '&scale=' + scale : ''

    request = '?table=' + table + '&acc=' + account + request + queriesString + this.range() + scale
    console.log(request);
    return request;
},

getQueryDims(queryList) {
    var dims = []
    queryList.dim.forEach((dim, index) => {
        var valueString = ''
        var dimObj = {
            name: '',
            value: ''
        }
        this[dim.list].forEach((dimVal) => {
           if (dimVal && dimVal.value != '') {
            valueString += dimVal.value + ','
            dimObj = {
                name: dim.name,
                value: valueString.slice(0,-1)
            }
            if (dimObj && dimObj.value != '') dims.push(dimObj);
        }
    })
    })
    return dims
},

getQueryFilters(queryList) {
    var filters = []
    queryList.filters.forEach((filter, index) => {
        var sub_filters = []
        var s = filter.sub_filters
        s.forEach((sub, index) => {
            var valueString = ''
            var subObj = {
                name: '',
                value: ''
            }
            this[sub.list].forEach((subVal) => {
                if (subVal && subVal.value != '') {
                    valueString += subVal.value + ','
                    subObj = {
                        name: sub.name,
                        value: valueString.slice(0,-1)
                    }
                }
            })
            if (subObj && subObj.value != '') sub_filters.push(subObj)
        })
        if (filter) {
            var filterObj = {
                name: '',
                sub_filters: []
            }
            filterObj.name = filter.name
            filterObj.sub_filters = sub_filters
            filters.push(filterObj)
        }
    })
    return filters
},

generateCharts() {
    if (this.tabIndex == 'overall-tab') {
        this.dataCall(this.reportOverall, 'responseOverallList', 'responseOverallSummary','chart_overall')
    }
    else if(this.tabIndex == 'publisher-tab') {
        this.dataCall(this.reportPublishers, 'responsePublishersList', 'responsePublishersSummary', 'chart_publisher')
    }
    else if(this.tabIndex == 'devices-tab') {
        this.dataCall(this.reportDevices, 'responseDevicesList', 'responseDevicesSummary', 'chart_devices')
    }
    else if(this.tabIndex == 'geo-tab') {
        this.dataCall(this.reportGeo, 'responseGeoList', 'responseGeoSummary', 'chart_geo')
    }
},

range() {
    var range = '&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 00:00:00';

    return range;
},

dataCall(report, responseList, responseListSummary, chart) {
    axios.get(this.$root.reportUri + this.generateQuery(report, '1h', 'sum'))
    .then(response => {
        this[responseList] = response.data.data;

        if(this[responseList] == undefined) {
            this.createChart(chart, this.startingData.data[0].clicks, this.column, this.line);
        }
        else {
            this.createChart(chart, this[responseList], this.column, this.line);
        }
    }, error => {
        this.createChart(chart, this.startingData.data[0].clicks);
        swal('Error', 'Your search was unsuccesfull','error');
    });
    axios.get(this.$root.reportUri + this.generateQuery(report, '1h', 'summary'))
    .then(response => {
        this[responseListSummary] = response.data.data;
    }, error => {
        swal('Error', 'Your search was unsuccesfull','error');
    });
}
},

watch: {
    token(value) {
        this.fetchCampaigns()
    },
    user(value) {
    },

    selectedCampaigns(value) {
        this.getCreatives()
    },

    reportLoaded(value) {
                // HERE YOU CREATE FIRST VERSION OF THE CHART ONCE THE DATA IS LOADED
                this.generateCharts()
            },
        }
    }
</script>
