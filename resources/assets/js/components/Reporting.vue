<template>
    <v-container fluid grid-list-md>
        <v-tabs icons v-model="selection.tab" light fixed :scrollable="false" class="elevation-2 white">

                <!-- CARD START-->
                <v-card light extended class="elevation-0" style="overflow:visible">

                    <!-- TABS START -->
                    <v-tabs-bar class="white" slot="extension">
                        <v-tabs-slider class="orange darken-3"></v-tabs-slider>
                        <v-tabs-item href="#overall">
                            <v-icon class="orange--text text--darken-3">present_to_all</v-icon>
                            <span class="orange--text text--darken-3"> Overall</span>
                        </v-tabs-item>
                        <v-tabs-item href="#publisher" style="display:none">
                            <v-icon class="orange--text text--darken-3">mdi-newspaper</v-icon>
                            <span class="orange--text text--darken-3">Publishers</span>
                        </v-tabs-item>
                        <v-tabs-item href="#device_type">
                            <v-icon class="orange--text text--darken-3">devices</v-icon>
                            <span class="orange--text text--darken-3">Technologies</span>
                        </v-tabs-item>
                        <v-tabs-item href="#geo">
                            <v-icon class="orange--text text--darken-3">public</v-icon>
                            <span class="orange--text text--darken-3">Geo</span>
                        </v-tabs-item>
                    </v-tabs-bar>
                    <!-- TABS END-->

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
                                        :items="list.stats" 
                                        prepend-icon="insert_chart" 
                                        v-model="selection.column" 
                                        label="Column"
                                        ></v-select>
                                    </v-flex>
                                    <v-spacer></v-spacer>
                                    <v-flex xs12 md6>
                                        <v-select 
                                        :items="list.stats" 
                                        prepend-icon="show_chart" 
                                        v-model="selection.line" 
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
                            :items="list.campaigns"
                            keyValue="id"
                            subTitle="id"
                            title="name"
                            value="object"
                            :selection="selection.campaigns"
                            @changeSelection="selection.campaigns = $event"
                            ></tk-filter>
                            <tk-filter
                            leftIcon="crop_original"
                            buttonText="Creatives"
                            :items="list.creatives"
                            keyValue="id"
                            subTitle="id"
                            title="name"
                            value="object"
                            :selection="selection.creatives"
                            @changeSelection="selection.creatives = $event"
                            ></tk-filter>
                        </v-layout>
                    </v-card-text>
                    <!-- CAMPAIGNS AND CREATIVES FILTER END -->

                <v-divider></v-divider>
            </v-card>
            <v-tabs-items>

                <!-- OVERALL FILTERS START-->
                <v-tabs-content id="overall">
                </v-tabs-content>
                <!-- OVERALL FILTERS END -->

                <!-- PUBLISHER FILTERS START -->
                <v-tabs-content id="publisher">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-select 
                                    :items="list.publishers" 
                                    item-text="site" 
                                    item-value="site" 
                                    chips 
                                    v-model="selection.publishers" 
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
                <v-tabs-content id="device_type">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device"
                                    :items="list.models"
                                    keyValue="type"
                                    title="type"
                                    value="object"
                                    :selection="selection.models"
                                    @changeSelection="selection.models = $event"
                                    ></tk-filter>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device UA"
                                    :items="list.browsers"
                                    keyValue="type"
                                    title="type"
                                    value="object"
                                    :selection="selection.browsers"
                                    @changeSelection="selection.browsers = $event"
                                    ></tk-filter>
                                    <tk-filter
                                    leftIcon="filter_list"
                                    buttonText="Device OS"
                                    :items="list.os"
                                    keyValue="type"
                                    title="type"
                                    value="object"
                                    :selection="selection.os"
                                    @changeSelection="selection.os = $event"
                                    ></tk-filter>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <!-- DEVICES FILTERS END -->

                <!-- GEO FILTERS START -->
                <v-tabs-content id="geo">
                    <v-card>
                        <v-card-text>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex xs12 lg3>
                                        <v-select
                                        prepend-icon="language"
                                        :items="list.countries" 
                                        item-text="key" 
                                        return-object
                                        v-model="selection.countries" 
                                        label="Countries" 
                                        multiple 
                                        autocomplete
                                        >
                                        </v-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-tabs-content>
                <!-- GEO FILTERS END -->
            
            </v-tabs-items>
            <v-card>
                <v-card-text>
                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="photo"
                                    title="IMPRESSIONS"
                                    :value="0"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="monetization_on"
                                    title="CLICKS"
                                    :value="0"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="mouse"
                                    title="CTR"
                                    :value="0"
                                    unit="%"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="monetization_on"
                                    title="eCPM"
                                    :value="0"
                                    unit="$"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="star_half"
                                    title="eCPC"
                                    :value="0"
                                    unit="$"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs6 md4 lg2>
                                <tk-widget
                                    icon="monetization_on"
                                    title="SPEND"
                                    :value="0"
                                    unit="$"
                                    defaultValue="0.00"
                                    size="sm"
                                ></tk-widget>
                            </v-flex>
                            <v-flex xs12>
                                <v-card class="elevation-1">
                                    <v-card-media id="graph" class="tapklik-chart" height="350px"> 
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
                </v-card-text>
            </v-card>
        </v-tabs>
    </v-container>
</template>
<script type="text/javascript">
    import VueRangedatePicker from 'vue-rangedate-picker'

    export default {
        created() {
            this.$root.isLoading = true;
        },
        
        mounted() {
            this.$root.isLoading = false;
            this.styleInputDiv();
        },

        components: {
            VueRangedatePicker
        },

        props: ['user', 'token'],

        data() {
            return {
                list: {
                    campaigns: [],
                    creatives: [],
                    browsers: [],
                    os: [],
                    models: [],
                    countries: [],
                    publishers: [],
                    stats: ['imps', 'clicks', 'ecpc', 'ecpm', 'spend', 'ctr']
                },

                selection: {
                    tab: 'overall',
                    column: 'clicks',
                    line: 'imps',
                    date_from: this.$utils.getDate(-10),
                    date_to: this.$utils.getDate(0),
                    campaigns: [],
                    creatives: [],
                    browsers: [],
                    os: [],
                    models: [],
                    countries: [],
                    publishers: []
                },
                table_loading: false,
                chart_data: [],
                summary_data: {},
            }
        },
        
        computed: {
            dataQuery() {
                var table = '/' + this.selection.tab;
                var acc = 'acc=' + this.user.accountUuId + '&';
                if(this.selection.campaigns.length > 0) {
                    acc += 'cmp=' + this.selection.campaigns.map(cmp=>cmp.id).join() + '&';
                    if(this.selection.creatives.length > 0) {
                        acc += 'crid=' + this.selection.creatives.map(cr=>cr.id).join() + '&';      
                    }
                } 
                var from = 'from=' + this.selection.date_from + '&';
                var to = 'to=' + this.selection.date_to + '&';
                var fields = 'fields=' + this.selection.column + ',' + this.selection.line + '&';
                return table + '?' + acc + from + to + fields;
            },

            fullDate() {
                return 'From: ' + this.selection.date_from + '     To: ' + this.selection.date_to;
            }
        },

        methods: {
            getLists() {
                this.getCampaigns();
                this.getPublishers();
                this.getTechnologies();
                this.getCountries();
            },

            getCampaigns() {
                axios.get(
                    this.$root.uri + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        this.list.campaigns = response.data.data;
                        this.getCreatives();
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access campaigns.');
                    }
                );
            },

            getCountries() {
                axios.get(
                    '/data/countries.json'
                ).then(response => {
                        this.list.countries = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            getPublishers() {
                axios.get(
                    '/data/publishers.json'
                ).then(response => {
                        this.list.publishers = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            getTechnologies() {
                axios.get(
                    '/data/technologies.json'
                ).then(response => {
                        this.list.browsers = response.data.browsers;
                        this.list.os = response.data.operatingsystems;
                        this.list.models = response.data.devices;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            getCreatives() {
                var nested_arrays = this.list.campaigns.map(campaign => campaign.creatives.data);
                for(let i = 0; i < nested_arrays.length; i++) {
                    var current_array = nested_arrays[i];
                    for(let j = 0; j < current_array.length; j++) {
                        var current_value = current_array[j];
                        if(this.list.creatives.indexOf(current_value) === -1) {
                            this.list.creatives.push(current_value);
                        }
                    }
                }
            },

            getChartData() {
                axios.get(
                    this.$root.reportUri + this.dataQuery + 'op=sum',
                    this.$root.config
                ).then(response => {
                        this.chart_data = response.data;
                        this.createChart('graph', this.chart_data, this.selection.column, this.selection.line);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access graph data.');
                    }
                );
            },

            getSummaryData() {
                axios.get(
                    this.$root.reportUri + this.dataQuery + 'op=summary',
                    this.$root.config
                ).then(response => {
                        this.summary_data = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access graph data.');
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
                    "marginTop": 20,
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
                        "fillColors":"#78909c",
                        "lineThickness": 0,
                        "balloonText": "[[date]] <br> <br>"+column+" :[["+column+"]]<br>"+line+": [["+line+"]]",
                        "title": column,
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
                        "title": line,
                        "valueField": line
                        
                    }],
                    "categoryField": "timestamp",
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

            selectDates(new_dates) {
                const toTwoDigits = num => num < 10 ? '0' + num : num;
                let dates = Object.assign({}, new_dates);

                dates.start.setDate(dates.start.getDate() - 1);
                let start_year = dates.start.getFullYear();
                let start_month = toTwoDigits(dates.start.getMonth() + 1);
                let start_day = toTwoDigits(dates.start.getDate()); 
                this.selection.date_from = `${start_year}-${start_month}-${start_day}`;

                if(dates.end == null) this.selection.date_to = this.selection.date_from;
                else {
                    dates.end.setDate(dates.end.getDate() - 1);
                    let end_year = dates.end.getFullYear();
                    let end_month = toTwoDigits(dates.end.getMonth() + 1);
                    let end_day = toTwoDigits(dates.end.getDate()); 
                    this.selection.date_to = `${end_year}-${end_month}-${end_day}`;
                }
                dates.start.setDate(dates.start.getDate() + 1);
                if(dates.end != null) dates.end.setDate(dates.end.getDate() + 1);
                this.styleInputDiv(true);
            },

            styleInputDiv(reload) {
                if(!reload){
                    var input = document.getElementsByClassName('input-date');
                    var element = input[0];
                    element.classList.remove('input-date');
                    element.setAttribute("id", "custom-calender-input");
                }
                else var element = document.getElementById('custom-calender-input');

                element.innerHTML = '<div style="cursor:pointer" class="input-group input-group--dirty input-group--append-icon input-group--prepend-icon input-group--text-field"><label>Range</label><div class="input-group__input"><i aria-hidden="true" class="material-icons icon input-group__prepend-icon">flight_land</i><input style="cursor:pointer" readonly="readonly" tabindex="0" aria-label="To" type="text" value="' + this.fullDate + '"><i aria-hidden="true" class="material-icons icon input-group__append-icon">date_range</i></div><div class="input-group__details"><div class="input-group__messages"></div></div></div>';
            },
        },

        watch: {
            token(value) {
                this.getLists();
            },
            dataQuery(value) {
                this.getChartData();
                this.getSummaryData();
            }
        }
    }
</script>