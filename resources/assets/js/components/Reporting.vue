<template>
    <v-container fluid grid-list-md>
        <v-tabs icons v-model="tab_name" light fixed :scrollable="false" class="elevation-2 white">

            <!-- CARD START-->
            <v-card light extended class="elevation-0" style="overflow:visible">

                <!-- TABS START -->
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
                <!-- TABS END -->
                
                <v-divider></v-divider>

                <!-- BASIC FILTERS START -->
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 md5 lg4>
                            <v-layout>
                                <v-flex xs12 md8>
                                    <tk-datepicker 
                                    i18n="EN" 
                                    @selected="selectDates"
                                    ></tk-datepicker>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-spacer></v-spacer>
                        <v-flex xs12 md4 lg3>
                            <v-layout>
                                <v-flex xs12 md6>
                                    <v-select 
                                    :items="stats" 
                                    prepend-icon="insert_chart" 
                                    v-model="column" 
                                    label="Column"
                                    ></v-select>
                                </v-flex>
                                <v-spacer></v-spacer>
                                <v-flex xs12 md6>
                                    <v-select 
                                    :items="stats" 
                                    prepend-icon="show_chart" 
                                    v-model="line" 
                                    label="Line"
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <!-- BASIC FILTERS END -->

                <v-divider></v-divider>

                <!-- CAMPAIGNS AND CREATIVES FILTER START -->
                <v-card-text>
                    <v-layout row wrap>
                        <tk-filter
                        leftIcon="important_devices"
                        buttonText="Campaigns"
                        :items="campaigns"
                        keyValue="id"
                        subTitle="id"
                        title="name"
                        value="id"
                        :selection="selectedCampaigns1"
                        @changeSelection="selectedCampaigns1 = $event"
                        ></tk-filter>
                        <tk-filter
                        leftIcon="crop_original"
                        buttonText="Creatives"
                        :items="creatives"
                        keyValue="id"
                        subTitle="id"
                        title="name"
                        value="id"
                        :selection="selectedCreatives1"
                        @changeSelection="selectedCreatives1 = $event"
                        ></tk-filter>
                        <v-chip 
                        @input="removeChip('selectedCampaigns1'), 
                        removeChip('selectedCreatives1')" 
                        close 
                        v-show="selectedCampaigns1 != ''"
                        >
                            <b>Campaigns: &nbsp;</b>
                            {{chipContent(campaignNames, 60)}}
                        </v-chip>
                        <v-chip 
                        @input="removeChip('selectedCreatives1')" 
                        close 
                        v-show="selectedCreatives1 != ''"
                        >
                            <b>Creatives: &nbsp;</b>
                            {{chipContent(creativesNames, 60)}}
                        </v-chip>
                    </v-layout>
                </v-card-text>
                <!-- CAMPAIGNS AND CREATIVES FILTER END -->

                <v-divider></v-divider>
            </v-card>
            <v-tabs-items>

                <!-- OVERALL FILTERS START-->
                <v-tabs-content id="overall-tab">
                </v-tabs-content>
                <!-- OVERALL FILTERS END -->

                <!-- PUBLISHER FILTERS START -->
                <v-tabs-content id="publisher-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-select 
                                    :items="publishers" 
                                    item-text="site" 
                                    item-value="site" 
                                    chips 
                                    v-model="selectedPublishers1" 
                                    label="Publisher Sites" 
                                    multiple 
                                    autocomplete
                                    ></v-select>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <!-- PUBLISHER FILTERS END -->

                <!-- DEVICES FILTERS START -->
                <v-tabs-content id="devices-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device"
                                    :items="models"
                                    keyValue="type"
                                    title="type"
                                    value="device_id"
                                    :selection="selectedDevicesTypes1"
                                    @changeSelection="selectedDevicesTypes1 = $event"
                                    ></tk-filter>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device UA"
                                    :items="browsers"
                                    keyValue="type"
                                    title="type"
                                    value="type"
                                    :selection="selectedDevicesUa1"
                                    @changeSelection="selectedDevicesUa1 = $event"
                                    ></tk-filter>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device OS"
                                    :items="operating_systems"
                                    keyValue="type"
                                    title="type"
                                    value="type"
                                    :selection="selectedDevicesOs1"
                                    @changeSelection="selectedDevicesOs1 = $event"
                                    ></tk-filter>
                                    <v-chip 
                                    @input="removeChip('selectedDevicesTypes1')" 
                                    close 
                                    v-show="selectedDevicesTypes1 != ''"
                                    >
                                        <b>Types: &nbsp;</b>
                                        {{ chipContent(selectedDevicesTypes1, 10) }}
                                    </v-chip>
                                    <v-chip 
                                    @input="removeChip('selectedDevicesUa1')" 
                                    close 
                                    v-show="selectedDevicesUa1 != ''"
                                    >
                                        <b>Browsers: &nbsp;</b>
                                        {{ chipContent(selectedDevicesUa1, 10) }}
                                    </v-chip>
                                    <v-chip 
                                    @input="removeChip('selectedDevicesOs1')" 
                                    close 
                                    v-show="selectedDevicesOs1 != ''"
                                    >
                                        <b>Operating Systems: &nbsp;</b>
                                        {{ chipContent(selectedDevicesOs1, 10) }}
                                    </v-chip>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <!-- DEVICES FILTERS END -->

                <!-- GEO FILTERS START -->
                <v-tabs-content id="geo-tab">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex xs12 lg3>
                                        <v-select
                                        prepend-icon="language"
                                        @change="showNothing()"
                                        :items="countries" 
                                        item-text="key" 
                                        item-value="country" 
                                        v-model="selectedGeoCountries1" 
                                        label="Countries" 
                                        multiple 
                                        autocomplete
                                        >
                                            <template 
                                            slot="selection" 
                                            slot-scope="data"
                                            ></template>
                                        </v-select>
                                    </v-flex>
                                    <v-chip 
                                    @input="removeChip('selectedGeoCountries1')" 
                                    close 
                                    v-show="selectedGeoCountries1 != ''"
                                    >
                                        <b>Countries: &nbsp;</b>
                                        {{ chipContent(selectedGeoCountries1, 10) }}
                                    </v-chip>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <!-- GEO FILTERS END -->

            </v-tabs-items>

            <!-- GRAPH START -->
            <reporting-tab 
            :tabIndex="tab_name"
            currentTab="geo-tab"
            @changeData="loadData($event, 'report')"
            graph="chart" 
            :summary="response_summary"
            :tableData="response"
            :tableLoading="table_loading"
            ></reporting-tab>
            <!-- GRAPH END -->
            
        </v-tabs>
    </v-container>
</template>

<script>
import VueRangedatePicker from 'vue-rangedate-picker'

    export default {

        created() {
            this.$root.isLoading = true;
        },
        
        mounted() {
            this.loadData('technologies', 'browsers', 'browsers');
            this.loadData('technologies', 'operating_systems', 'operatingsystems');
            this.loadData('technologies', 'models', 'devices');
            this.loadData('countries', 'countries');
            this.loadData('publishers', 'publishers');
            this.loadData('reportOverall','report');
            this.loadData('reportOverall','report_overall');
            this.$root.isLoading = false;
            this.styleInputDiv();
        },

        components: {
            VueRangedatePicker
        },

        props: ['user', 'token'],

        data() {
            return {
                table_loading: true,
                campaigns: [],
                creatives: [],
                publishers: [],
                models: [],
                operating_systems: [],
                browsers: [],
                countries: [],

                date_from: this.$utils.getDate(-10),
                date_to: this.$utils.getDate(0),
                stats: ['imps', 'clicks', 'ecpc', 'ecpm', 'spend', 'ctr'],
                line: 'imps',
                column: 'clicks',

                selectedCampaigns1: [],
                selectedCreatives1: [],
                selectedDevicesTypes1: [2,4,5],
                selectedDevicesOs1: [],
                selectedDevicesUa1: [],
                selectedPublishers1: [],
                selectedGeoCountries1: [],

                report_overall: this.loadData('reportOverall','report'),
                report: [],
                response: [],
                response_summary: {
                    clicks: 0, 
                    imps: 0, 
                    spend: 0, 
                    ctr: 0, 
                    ecpm: 0, 
                    ecpc:0
                },
                
                campaignsPresent: false,
                campaignNames: [],
                creativesNames: [],
                tab_name: 'overall-tab',
                startingDataSummary: {
                    clicks: 0,
                    ctr: 0,
                    ecpc: 0,
                    ecpm: 0,
                    imps: 0,
                    spend: 0
                }
            }
        },
        
        computed: {
            full_date() {
                return 'From: ' + this.date_from + '     To: ' + this.date_to;
            },
            selectedPublishers() {
                return this.selectedPackager('selectedPublishers1', 'publisher_site');
            },

            selectedGeoCountries() {
                return this.selectedPackager('selectedGeoCountries1', 'geo_country');
            },

            selectedDevicesUa() {
                return this.selectedPackager('selectedDevicesUa1', 'device_ua');
            },

            selectedDevicesOs() {
                return this.selectedPackager('selectedDevicesOs1', 'device_os');
            },

            selectedDevicesTypes() {
                return this.selectedPackager('selectedDevicesTypes1', 'device_type');
            },

            selectedCampaigns() {
                var campaigns = [];
                var selections = this.selectedCampaigns1;
                var allCampaigns = this.campaigns;
                var names = [];
                for (var s in selections) {
                    for(var a in allCampaigns) {
                        if(selections[s] == allCampaigns[a].id) names.push(allCampaigns[a].name)
                    }
                    var object = {name: 'cmp', value: selections[s]}
                    campaigns.push(object)
                }
                this.campaignNames = names;
                return campaigns
            },

            selectedCreatives() {
                var creatives = [];
                var selections = this.selectedCreatives1;
                var allCreatives = this.creatives;
                var names = [];

                for (var s in selections) {
                    for(var a in allCreatives) {
                        if(selections[s] == allCreatives[a].id) names.push(allCreatives[a].name)
                    }
                    var object = {name: 'crid', value: selections[s]}
                    creatives.push(object)
                }
                this.creativesNames = names;
                return creatives
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
                        date: this.date_to + ' 23:59:59',
                        ecpc: 0,
                        ecpm: 0,
                        imps: 0,
                        spend: 0 
                    }
                ]
            }
        },

        methods: {
            showNothing() {
                var empty = { key: '' };
                return empty;
            },

            styleInputDiv(reload) {
                if(!reload){
                    var input = document.getElementsByClassName('input-date');
                    var element = input[0];
                    element.classList.remove('input-date');
                    element.setAttribute("id", "custom-calender-input");
                }
                else var element = document.getElementById('custom-calender-input');

                element.innerHTML = '<div style="cursor:pointer" class="input-group input-group--dirty input-group--append-icon input-group--prepend-icon input-group--text-field"><label>Range</label><div class="input-group__input"><i aria-hidden="true" class="material-icons icon input-group__prepend-icon">flight_land</i><input style="cursor:pointer" readonly="readonly" tabindex="0" aria-label="To" type="text" value="' + this.full_date + '"><i aria-hidden="true" class="material-icons icon input-group__append-icon">date_range</i></div><div class="input-group__details"><div class="input-group__messages"></div></div></div>';
            },

            selectDates(new_dates) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let dates = Object.assign({}, new_dates);

                dates.start.setDate(dates.start.getDate() - 1);
                let start_year = dates.start.getFullYear();
                let start_month = toTwoDigits(dates.start.getMonth() + 1);
                let start_day = toTwoDigits(dates.start.getDate()); 
                this.date_from = `${start_year}-${start_month}-${start_day}`;

                dates.end.setDate(dates.end.getDate() - 1);
                let end_year = dates.end.getFullYear();
                let end_month = toTwoDigits(dates.end.getMonth() + 1);
                let end_day = toTwoDigits(dates.end.getDate()); 
                this.date_to = `${end_year}-${end_month}-${end_day}`;

                dates.start.setDate(dates.start.getDate() + 1);
                dates.end.setDate(dates.end.getDate() + 1);
                this.styleInputDiv(true);
                
            },
            selectedPackager(list, objectName) {
                var result = [];
                var selections = this[list];

                for (var s in selections) {
                    var object = {name: objectName, value: selections[s]}
                    result.push(object)
                }
                return result
            },

            removeDuplicates(creatives) {
                return creatives.filter((current_value, current_index, array) =>  
                    array.indexOf(current_value) == current_index
                );
            },

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

                this.creatives = listOfCreatives;
                this.removeDuplicates(this.creatives);
            },

            findCampaignById(id) {
                var campaigns = this.campaigns
                for (var c in campaigns) {
                    if (campaigns[c].id == id) return campaigns[c] 
                }
            },

            fetchCampaigns() {
                axios.get(this.$root.uri + '/campaigns', this.$root.config).then(response => {
                    this.campaigns = response.data.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Can not access campaigns.');
                })
            },

            loadData(jsonName, list, technology) {
                axios.get('/data/' + jsonName + '.json').then(response => {
                    technology ? this[list] = response.data[technology] : this[list] = response.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Can not access data.');
                });
            },

            createChart(target, dataset, column, line) {
                var obj = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 40,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "title": column.charAt(0).toUpperCase() + column.slice(1)
                    },
                    {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "title": line.charAt(0).toUpperCase() + line.slice(1)
                    }
                    ],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "column",
                        "fixedColumnWidth": 40,
                        "fillAlphas": 1,
                        "fillColors":"#78909c",
                        "lineThickness": 0,
                        "balloonText": "[[date]] <br> <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "title": column.charAt(0).toUpperCase() + column.slice(1),
                        "valueField": column
                    },
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#f76c06",
                        "fillColors":"#f76c06",
                        "fillAlphas": 0,
                        "balloonText": "[[date]] <br> <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "lineThickness": 2,
                        "title": line.charAt(0).toUpperCase() + line.slice(1),
                        "valueField": line
                        
                    }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 0,
                        "axisAlpha": 0.1,
                        "gridAlpha": 0,
                        "minPeriod": "hh",
                        "minorGridEnabled": false
                    },
                    "balloon": {
                        "borderColor": "#222",
                        "borderAlpha": 0,
                        "borderThickness": 0,
                        "shadowAlpha": 0,
                        "color": "#ffffff",
                        "drop": false,
                        "cornerRadius": 5,
                        "fillColor": "#222",
                        "fillAlpha": 1,
                    },
                    "chartCursor": {
                        "categoryBalloonDateFormat": "DD MM",
                        "cursorAlpha": 0.1,
                        "cursorColor":"#000000",
                        "fullWidth":true,
                        "valueBalloonsEnabled": false,
                        "zoomable": false
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

            generateQuery(queryList, chartOrSum) {
                var queries = queryList.queries;
                var table = queryList.table;
                var account = this.user.accountUuId;
                var dims = this.getQueryDims(queryList);
                var filters = this.getQueryFilters(queryList);

                //console.log(dims)

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
                        }
                        //remove previous objects with same name before re-adding with new values
                        for (var i = 0; i < dims.length; i++) {
                                if (dims[i].name == dim.name) {
                                    dims.splice(i, 1);
                                }
                            }
                        if (dimObj && dimObj.value != '') dims.push(dimObj);
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

            range() {
                var range = '&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 23:59:59';
                return range;
            },

            getChartData() {
                this.table_loading = true;
                axios.get(
                    this.$root.reportUri + this.generateQuery(this.report, 'sum')
                ).then(response => {
                        var results = response.data.data;
                        for(var r in results) {
                            results[r].imps = results[r].imps;
                            results[r].clicks = results[r].clicks;
                            results[r].ecpc = this.$currency.formatNumber(results[r].ecpc);
                            results[r].ecpm = this.$currency.formatNumber(results[r].ecpm);
                            results[r].ctr = this.$currency.formatNumber(results[r].ctr * 100);
                            results[r].spend = this.$currency.fromMicroDollars(results[r].spend);
                        }
                        this.response = results == undefined ? this.startingData : results;
                        this.table_loading = false;
                        this.createChart('chart', this.response, this.column, this.line);
                    }, error => {
                        this.response = this.startingData;
                        this.table_loading = false;
                        this.createChart('chart', this.response, this.column, this.line);
                        this.$root.showAlertPopUp('error', 'Can not access graph data.');
                    }
                );
            },

            getSummary() {
                axios.get(
                    this.$root.reportUri + this.generateQuery(this.report, 'summary')
                ).then(response => {
                        var summary = response.data.data;
                        this.response_summary = summary == undefined ? this.startingDataSummary : response.data.data;
                    }, error => {
                        this.response_summary = this.startingDataSummary;
                        this.$root.showAlertPopUp('error', 'Can not access summary data.');
                    }
                );
            },

            getOverallChartData() {
                axios.get(
                    this.$root.reportUri + this.generateQuery(this.report_overall, 'sum')
                ).then(response => {
                        var results = response.data.data;
                        for(var r in results) {
                            results[r].imps = results[r].imps;
                            results[r].clicks = results[r].clicks;
                            results[r].ecpc = this.$currency.formatNumber(results[r].ecpc);
                            results[r].ecpm = this.$currency.formatNumber(results[r].ecpm);
                            results[r].ctr = this.$currency.formatNumber(results[r].ctr * 100);
                            results[r].spend = this.$currency.fromMicroDollars(results[r].spend);
                        }
                        this.response = results == undefined ? this.startingData : results;
                        this.table_loading = false;
                        this.createChart('chart', this.response, this.column, this.line);
                    }, error => {
                        this.response = this.startingData;
                        this.table_loading = false;
                        this.createChart('chart', this.response, this.column, this.line);
                        this.$root.showAlertPopUp('error', 'Can not access graph data.');
                    }
                );
            },

            getOverallSummary() {
                axios.get(
                    this.$root.reportUri + this.generateQuery(this.report_overall, 'summary')
                ).then(response => {
                        var summary = response.data.data;
                        this.response_summary = summary == undefined ? this.startingDataSummary : response.data.data;
                    }, error => {
                        this.response_summary = this.startingDataSummary;
                        this.$root.showAlertPopUp('error', 'Can not access summary data.');
                    }
                );
            },

            generateChart() {
                this.getChartData();
                this.getSummary();
            }
        },

        watch: {
            report(value) {
                if(this.tab_name == 'geo-tab' && this.selectedGeoCountries1 == '') {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else if(this.tab_name == 'devices-tab' && !(this.selectedDevicesTypes1 != '' || this.selectedDevicesOs1 != '' || this.selectedDevicesUa1 != '')) {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else this.generateChart();
            },
            column(value) {
                this.generateChart();
            },
            line(value) {
                this.generateChart();
            },
            date_from(value) {
                this.generateChart();
            },
            date_to(value) {
                this.generateChart();
            },
            token(value) {
                this.fetchCampaigns();
            },
            selectedCampaigns1(value) {
                this.campaignsPresent = value != '' ? true : false;
                this.generateChart();
            },
            selectedCreatives1(value) {
                this.generateChart();
            },
            selectedPublishers1(value) {
                this.generateChart();
            },
            selectedDevicesTypes1(value) {
                if(this.tab_name == 'geo-tab' && this.selectedGeoCountries1 == '') {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else if(this.tab_name == 'devices-tab' && !(value != '' || this.selectedDevicesOs1 != '' || this.selectedDevicesUa1 != '')) {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else this.generateChart();
            },
            selectedDevicesOs1(value) {
                if(this.tab_name == 'geo-tab' && this.selectedGeoCountries1 == '') {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else if(this.tab_name == 'devices-tab' && !(this.selectedDevicesTypes1 != '' || value != '' || this.selectedDevicesUa1 != '')) {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else this.generateChart();
            },
            selectedDevicesUa1(value) {
                if(this.tab_name == 'geo-tab' && this.selectedGeoCountries1 == '') {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else if(this.tab_name == 'devices-tab' && !(this.selectedDevicesTypes1 != '' || this.selectedDevicesOs1 != '' || value != '')) {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else this.generateChart();
            },
            selectedGeoCountries1(value) {
                if(this.tab_name == 'geo-tab' && value == '') {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else if(this.tab_name == 'devices-tab' && !(this.selectedDevicesTypes1 != '' || this.selectedDevicesOs1 != '' || this.selectedDevicesUa1 != '')) {
                    this.getOverallSummary();
                    this.getOverallChartData();
                }
                else this.generateChart();
            },
            user(value) {
                this.generateChart();
            },
            selectedCampaigns(value) {
                this.getCreatives();
            }
        }
    }
</script>