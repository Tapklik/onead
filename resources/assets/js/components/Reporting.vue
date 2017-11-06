<template>
    <v-container fluid grid-list-md>
        <popup></popup>
        <v-tabs icons v-model="tabIndex" light fixed :scrollable="false" class="elevation-2 white">
            <v-card light extended class="elevation-0">
                <v-tabs-bar class="white" slot="extension">
                    <v-tabs-slider class="orange darken-3"></v-tabs-slider>
                    <v-tabs-item href="#overall-tab">
                        <v-icon class="orange--text text--darken-3">present_to_all</v-icon>
                        <span class="orange--text text--darken-3"> Overall</span>
                    </v-tabs-item>
                    <v-tabs-item href="#publisher-tab" style="display:none">
                        <v-icon class="orange--text text--darken-3">mdi-newspaper</v-icon>
                        <span class="orange--text text--darken-3">Publishers</span>
                    </v-tabs-item>
                    <v-tabs-item href="#devices-tab">
                        <v-icon class="orange--text text--darken-3">devices</v-icon>
                        <span class="orange--text text--darken-3">Technologies</span>
                    </v-tabs-item>
                    <v-tabs-item href="#geo-tab">
                        <v-icon class="orange--text text--darken-3">public</v-icon>
                        <span class="orange--text text--darken-3">Geo</span>
                    </v-tabs-item>
                </v-tabs-bar>
                <v-divider></v-divider>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 md10 lg8 offset-md1 offset-lg2>
                            <v-layout row wrap>
                                <v-flex xs-12 md6 lg4>
                                    <v-select :items="campaignList" item-text="name" prepend-icon="important_devices" item-value="id" chips v-model="selectedCampaigns1" label="Campaigns" multiple>
                                        <template slot="item" scope="data">
                                            <v-list-tile-content>
                                                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                                                <v-list-tile-sub-title v-html="data.item.id"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                    </v-select>
                                    <v-select :items="creativesList" item-text="name" prepend-icon="photo_library" item-value="id" chips v-model="selectedCreatives1" :disabled="!campaignsPresent" label="Creatives" multiple>
                                        <template slot="item" scope="data">
                                            <v-list-tile-content>
                                                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                                                <v-list-tile-sub-title v-html="data.item.id"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                        </template>
                                    </v-select>
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex xs-12 md6>
                                    <v-layout row wrap>
                                        <v-flex xs6>
                                            <v-dialog
                                            :v-model="false"
                                            lazy
                                            full-width
                                            >
                                                <v-text-field
                                                label="From"
                                                prepend-icon="flight_takeoff"
                                                append-icon="date_range"
                                                readonly
                                                v-model="date_from"
                                                slot="activator"
                                                ></v-text-field>
                                                <v-date-picker v-model="date_from" no-title scrollable autosave></v-date-picker>
                                            </v-dialog>
                                        </v-flex>
                                        <v-flex xs6>
                                            <v-dialog :v-model="false" lazy full-width>
                                                <v-text-field
                                                label="From"
                                                prepend-icon="flight_takeoff"
                                                append-icon="date_range"
                                                readonly
                                                v-model="date_to"
                                                slot="activator"
                                                ></v-text-field>
                                                <v-date-picker v-model="date_to" no-title scrollable autosave></v-date-picker>
                                            </v-dialog>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row wrap>
                                        <v-flex xs6>
                                            <v-select :items="stats" prepend-icon="insert_chart" v-model="column" label="Column"></v-select>
                                                   
                                        </v-flex>
                                        <v-flex xs6>
                                            <v-select :items="stats" prepend-icon="show_chart" v-model="line" label="Line"></v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
            <v-divider class="elevation-1"></v-divider>
            <v-tabs-items>
                <v-tabs-content id="overall-tab">
                    <reporting-overall graph="chart_overall" :summary="responseOverallSummary"></reporting-overall>
                </v-tabs-content>
                <v-tabs-content id="publisher-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex xs12 md4 lg2>
                                        <v-select :items="publisherList" item-text="site" item-value="site" chips v-model="selectedPublishers1" label="Publisher Sites" multiple autocomplete></v-select>
                                    </v-flex>
                                </v-layout>
                                <v-layout row wrap>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="photo"
                                            title="IMPRESSIONS"
                                            :value="responsePublishersSummary.imps"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="monetization_on"
                                            title="CLICKS"
                                            :value="responsePublishersSummary.clicks"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="mouse"
                                            title="CTR"
                                            :value="$root.twoDecimalPlaces(responsePublishersSummary.ctr * 100)"
                                            unit="%"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="monetization_on"
                                            title="eCPM"
                                            :value="$root.twoDecimalPlaces(responsePublishersSummary.ecpm)"
                                            unit="$"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="star_half"
                                            title="eCPC"
                                            :value="$root.twoDecimalPlaces(responsePublishersSummary.ecpc)"
                                            unit="$"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs6 md4 lg2>
                                        <tk-widget
                                            icon="monetization_on"
                                            title="SPEND"
                                            :value="$root.fromMicroDollars(responsePublishersSummary.spend)"
                                            unit="$"
                                            defaultValue="0.00"
                                            size="sm"
                                        ></tk-widget>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-card class="elevation-0">
                                            <v-card-media id="chart_publisher" class="tapklik-chart" height="350px"> 
                                                <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                                            </v-card-media>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <v-tabs-content id="devices-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex sm12>
                                        <v-menu offset-y :close-on-content-click='false'>
                                            <v-btn white flat slot="activator">
                                                <v-icon>filter_list</v-icon> DEVICE
                                                <v-icon>arrow_drop_down</v-icon>
                                            </v-btn>
                                            <v-list style="max-height: 200px">
                                                <v-list-tile v-for="device in technologiesList.devices" :key="device.type">
                                                    <v-list-tile-action>
                                                        <v-checkbox :value="device.type" v-model="selectedDevicesTypes1"></v-checkbox>
                                                    </v-list-tile-action>
                                                    <v-list-tile-title>{{ device.type }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                        <v-menu offset-y :close-on-content-click='false'>
                                            <v-btn white flat slot="activator">
                                                <v-icon>filter_list</v-icon> DEVICE UA
                                                <v-icon>arrow_drop_down</v-icon>
                                            </v-btn>
                                            <v-list style="max-height: 200px">
                                                <v-list-tile v-for="device in technologiesList.browsers" :key="device.type">
                                                    <v-list-tile-action>
                                                        <v-checkbox :value="device.type" v-model="selectedDevicesUa1"></v-checkbox>
                                                    </v-list-tile-action>
                                                    <v-list-tile-title>{{ device.type }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                        <v-menu offset-y :close-on-content-click='false'>
                                            <v-btn white flat slot="activator">
                                                <v-icon>filter_list</v-icon> DEVICE OS
                                                <v-icon>arrow_drop_down</v-icon>
                                            </v-btn>
                                            <v-list style="max-height: 200px">
                                                <v-list-tile v-for="device in technologiesList.operatingsystems" :key="device.type">
                                                    <v-list-tile-action>
                                                        <v-checkbox :value="device.type" v-model="selectedDevicesOs1"></v-checkbox>
                                                    </v-list-tile-action>
                                                    <v-list-tile-title>{{ device.type }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                        <v-chip @input="removeChip('selectedDevicesTypes1')" close v-show="selectedDevicesTypes1 != ''">
                                            <b>Types: &nbsp;</b>
                                            {{chipContent(selectedDevicesTypes1, 10)}}
                                        </v-chip>
                                        <v-chip @input="removeChip('selectedDevicesUa1')" close v-show="selectedDevicesUa1 != ''">
                                            <b>Browsers: &nbsp;</b>
                                            {{chipContent(selectedDevicesUa1, 10)}}
                                        </v-chip>
                                        <v-chip @input="removeChip('selectedDevicesOs1')" close v-show="selectedDevicesOs1 != ''">
                                            <b>Operating Systems: &nbsp;</b>
                                            {{chipContent(selectedDevicesOs1, 10)}}
                                        </v-chip>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    <reporting-overall graph="chart_devices" :summary="responseDevicesSummary"></reporting-overall>
                </v-tabs-content>
                <v-tabs-content id="geo-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex xs12 md4 lg2>
                                        <v-menu offset-y :close-on-content-click='false'>
                                            <v-btn white flat slot="activator">
                                                <v-icon>filter_list</v-icon> Country 
                                                <v-icon>arrow_drop_down</v-icon>
                                            </v-btn>
                                            <v-list style="max-height: 200px">
                                                <v-list-tile v-for="country in countriesList" :key="country.key">
                                                    <v-list-tile-action>
                                                        <v-checkbox :value="country.country" v-model="selectedGeoCountries1"></v-checkbox>
                                                    </v-list-tile-action>
                                                    <v-list-tile-title>{{ country.country_name }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                    </v-flex>
                                    <v-flex xs12 md4 lg2>
                                        <v-chip @input="removeChip('selectedGeoCountries1')" close v-show="selectedGeoCountries1 != ''">
                                            <b>Countries: &nbsp;</b>
                                            {{chipContent(selectedGeoCountries1, 10)}}
                                        </v-chip>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                    <reporting-overall graph="chart_geo" :summary="responseGeoSummary"></reporting-overall>
                </v-tabs-content>
            </v-tabs-items>
        </v-tabs>
    </v-container>
</template>

<script>

    export default {

        created() {
            this.$root.isLoading = true;
        },
        
        mounted() {
            this.loadCategories();
            this.loadTechnologies();
            this.loadReportDevices();
            this.loadReportGeo();
            this.loadReportPublishers();
            this.loadReportOverall();
            this.loadCountries();
            this.loadPublishers();
            this.$root.isLoading = false;

        },

        props: ['user', 'token'],

        data() {
            return {
                tabIndex: 'overall-tab',
                stats: ['imps', 'clicks', 'ecpc', 'ecpm', 'spend', 'ctr'],
                line: 'imps',
                column: 'clicks',
                dateFormat: 'yyyy-MM-dd',
                date_from: this.getDate(-10),
                date_to: this.getDate(0),
                selectedCampaigns1: [],
                selectedCreatives1: [],
                selectedDevicesTypes1: [],
                selectedDevicesOs1: [],
                selectedDevicesUa1: [],
                selectedPublishers1: [],
                selectedGeoCountries1: [],
                categoriesList: [],
                creativesList: [],
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
                request: '',
                overallLsit: [],
                publishersList: [],
                geoList: [],
                devicesList: [],
                campaignsPresent: false,
            }
        },
        
        computed: {

            selectedPublishers() {
                var publishers = [];
                var selections = this.selectedPublishers1;

                for (var s in selections) {
                    var object = {name: 'publisher_site', value: selections[s]}
                    publishers.push(object)
                }

                return publishers
            },

            selectedGeoCountries() {
                var countries = [];
                var selections = this.selectedGeoCountries1;

                for (var s in selections) {
                    var object = {name: 'geo_country', value: selections[s]}
                    countries.push(object)
                }

                return countries
            },

            selectedDevicesUa() {
                var devices = [];
                var selections = this.selectedDevicesUa1;

                for (var s in selections) {
                    var object = {name: 'device_ua', value: selections[s]}
                    devices.push(object)
                }

                return devices

            },

            selectedDevicesOs() {
                var devices = [];
                var selections = this.selectedDevicesOs1;

                for (var s in selections) {
                    var object = {name: 'device_os', value: selections[s]}
                    devices.push(object)
                }

                return devices

            },

            selectedDevicesTypes() {
                var devices = [];
                var selections = this.selectedDevicesTypes1;

                for (var s in selections) {
                    var object = {name: 'device_type', value: selections[s]}
                    devices.push(object)
                }

                return devices

            },

            selectedCampaigns() {
                var campaigns = [];
                var selections = this.selectedCampaigns1;

                for (var s in selections) {
                    var object = {name: 'cmp', value: selections[s]}
                    campaigns.push(object)
                }

                return campaigns

            },

            selectedCreatives() {
                var creatives = [];
                var selections = this.selectedCreatives1;

                for (var s in selections) {
                    var object = {name: 'crid', value: selections[s]}
                    creatives.push(object)
                }

                return creatives

            },

            dateChosen() {
                return this.date_from + ' to ' + this.date_to
            },

            startingData() {
                return [
                    {
                        clicks: 0,
                        ctr: 0,
                        date: this.date_from,
                        ecpc: 0,
                        ecpm: 0,
                        imps: 0,
                        spend: 0
                    },
                    {
                        clicks: 0,
                        ctr: 0,
                        date: this.date_to,
                        ecpc: 0,
                        ecpm: 0,
                        imps: 0,
                        spend: 0 
                    }
                ]
            },

            startingDataSummary() {
                return {
                    clicks: 0,
                    ctr: 0,
                    ecpc: 0,
                    ecpm: 0,
                    imps: 0,
                    spend: 0
                }
            }
        },

        methods: {

            removeChip(data) {
                this[data] = [];
            },
            
            chipContent(selection, characters) {
                var selection = selection;
                var show = '';
                var characterCount = 0;
                var plusMany = 0;
                for(var s in selection) {
                    if(characterCount + selection[s].length > characters) {
                        plusMany = plusMany + 1;
                    }
                    else {
                        show = show + selection[s] + ', '
                        characterCount = characterCount + selection[s].length;
                    }
                }
                show = show.slice(0,-2);
                if(plusMany != 0) {
                    show = show + ' and ' + plusMany + ' more';
                }
                console.log(show);
                return show;
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
                this.creativesList = listOfCreatives;
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
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            })
        },

        loadCategories() {

            axios.get('/data/categories.json').then(response => {
                this.categoriesList = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadTechnologies() {

            axios.get('/data/technologies.json').then(response => {
                this.technologiesList = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadCountries() {

            axios.get('/data/countries.json').then(response => {
                this.countriesList = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadPublishers() {

            axios.get('/data/publishers.json').then(response => {
                this.publisherList = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadReportGeo() {

            axios.get('/data/reportGeo.json').then(response => {
                this.reportGeo = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadReportOverall() {

            axios.get('/data/reportOverall.json').then(response => {
                this.reportOverall = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadReportDevices() {

            axios.get('/data/reportDevices.json').then(response => {
                this.reportDevices = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
        },

        loadReportPublishers() {

            axios.get('/data/reportPublishers.json').then(response => {
                this.reportPublishers = response.data;
            }, error => {
                this.$root.showAlertPopUp('error', 'Something went wrong.');
            });
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
                        "title": column
                    },
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "title": line
                    }
                    ],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "column",
                        "fixedColumnWidth": 40,
                        "fillAlphas": 1,
                        "fillColors":"#ccc",
                        "lineColor":"#ccc",
                        "lineThickness": 2,
                        "balloonText": "[[date]] <br> ---------------- <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "title": column,
                        "valueField": column
                    },
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "smoothedLine",
                        "lineColor":"#f76c06",
                        "balloonText": "[[date]] <br> ---------------- <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "bullet": "round",
                        "bulletSize": 4,
                        "lineThickness": 2,
                        "title": line,
                        "valueField": line
                        
                    }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 0,
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "minPeriod": "hh",
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

chart.addListener("rendered", removeLogo);

function removeLogo() {
    $('.amcharts-chart-div').find('a').each(function(index, item) {
        $(item).hide();
    });
}

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

generateQuery(queryList, chartOrSum) {

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


    request = '?table=' + table + '&acc=' + account + request + queriesString + this.range();
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
    axios.get(this.$root.reportUri + this.generateQuery(report, 'sum'))
    .then(response => {
        var results = response.data.data;
        for(var v in results) {
            results[v].imps = results[v].imps;
            results[v].clicks = results[v].clicks;
            results[v].ecpc = this.$root.twoDecimalPlaces(results[v].ecpc);
            results[v].ecpm = this.$root.twoDecimalPlaces(results[v].ecpm);
            results[v].ctr = this.$root.twoDecimalPlaces(results[v].ctr * 100);
            results[v].spend = this.$root.fromMicroDollars(results[v].spend);
        }

        if(results == undefined) {
            this[responseList] = this.startingData;
            this.createChart(chart, this[responseList], this.column, this.line);
        }
        else {
            this[responseList] = results;
            this.createChart(chart, this[responseList], this.column, this.line);
        }
    }, error => {
        this[responseList] = this.startingData;
        this.createChart(chart, this[responseList], this.column, this.line);
        this.$root.showAlertPopUp('error', 'Something went wrong.');
    });

    axios.get(this.$root.reportUri + this.generateQuery(report, 'summary'))
    .then(response => {
        var summary = response.data.data;
        if(summary == undefined) {
            this[responseListSummary] = this.startingDataSummary;
        } else {
            this[responseListSummary] = response.data.data;
        }
    }, error => {
        this[responseListSummary] = this.startingDataSummary;
        this.$root.showAlertPopUp('error', 'Something went wrong.');
    });
}
},

watch: {
    column(value) {
        this.generateCharts();
    },
    line(value) {
        this.generateCharts();
    },
    date_from(value) {
        this.generateCharts();
    },
    date_to(value) {
        this.generateCharts();
    },
    token(value) {
        this.fetchCampaigns();
    },
    selectedCampaigns1(value) {
        if(value != '') this.campaignsPresent = true;
        else this.campaignsPresent = false;
        this.generateCharts(); 
    },
    selectedCreatives1(value) {
        this.generateCharts();
    },
    selectedPublishers1(value) {
        this.generateCharts();
    },
    selectedDevicesTypes1(value) {
        this.generateCharts();
    },
    selectedDevicesOs1(value) {
        this.generateCharts();
    },
    selectedDevicesUa1(value) {
        this.generateCharts();
    },
    selectedGeoCountries1(value) {
        this.generateCharts();
    },
    
    user(value) {
        this.generateCharts();
    },

    trialdate(value) {
        this.date_from=this.getDate(-10);
        this.date_to=this.getDate(0);
    },

    selectedCampaigns(value) {
        this.getCreatives();
    },

    reportLoaded(value) {
        // HERE YOU CREATE FIRST VERSION OF THE CHART ONCE THE DATA IS LOADED
        this.generateCharts()
    },
    tabIndex(value) {
        this.generateCharts();
    }
}
}
</script>
