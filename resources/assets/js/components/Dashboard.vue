<template>
    <v-container fluid grid-list-lg>
        <v-layout row wrap>

            <!-- REAL-TIME CHART START -->
            <v-flex d-flex md12 lg4 style="display: none">
                <v-card height="300px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            REAL-TIME CHART FOR 5 MINUTES ({{real_time_line | capitalize}} and {{real_time_line_two | capitalize}})
                        </span>
                    </v-card-title>
                    <v-card-media id="chart_real_time" class="tapklik-chart" height="250px"> 
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
            <!-- REAL-TIME CHART END -->

            <!-- REAL-TIME CHART START -->
            <v-flex d-flex md12 lg4  style="display: none">
                <v-card height="300px" class="elevation-2">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">
                            REAL-TIME CHART FOR 5 MINUTES ({{real_time_line_three | capitalize}})
                        </span>
                    </v-card-title>
                    <v-card-media id="chart_real_time_spend" class="tapklik-chart" height="250px"> 
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
            <!-- REAL-TIME CHART END -->

        </v-layout>
        <v-layout row wrap class="mt-2">

            <!-- WEEK CHART START -->
            <v-flex d-flex md12 lg6>
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
            </v-flex>
            <!-- WEEK CHART END -->

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
                        :value="$currency.formatNumber($currency.fromMicroDollars(overall_summary.spend))"
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
                        :value="$currency.formatNumber(overall_summary.ecpm)"
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
                        :value="$currency.formatNumber(overall_summary.ctr * 100)"
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
                        :value="$currency.formatNumber(overall_summary.ecpc)"
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
            <v-flex d-flex xs12 md6>
                
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
                    <v-data-table :items="campaigns" hide-actions>
                        <template slot="headers" slot-scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" slot-scope="props">
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
            <v-flex d-flex xs12 md6>

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
                        <template slot="headers" slot-scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" slot-scope="props">
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
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.date_from = this.$utils.getDate(-10);
            this.date_to = this.$utils.getDate(0);
            this.$root.isLoading = false;
        },
        
        data() {
            return {
                //REAL-TIME CHART
                real_time_start: '',
                real_time_end: '',
                real_time_data: '',
                real_time_length: 1,
                time_to_redraw: 300000,
                loaded: false,
                real_time_line: 'imps',
                real_time_line_two: 'clicks',
                real_time_line_three: 'spend',

                //WEEKLY CHART
                chartLoaded: false,
                overall_data: [],
                date_from: '',
                date_to: '',
                column: 'imps',
                line: 'ctr',
                
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

            //REAL TIME CHART
            getRealTimeDates() {
                var today = new Date();
                var year, month, day, hour, minute, seconds;
                var real_month;
                year = today.getFullYear();
                real_month = today.getMonth() + 1;
                month = real_month.toString().length == 1 ? "0" + real_month : real_month;
                day = today.getDate().toString().length == 1 ? "0" + today.getDate() : today.getDate();
                hour = today.getHours().toString().length == 1 ? "0" + today.getHours() : today.getHours();
                minute = today.getMinutes().toString().length == 1 ? "0" + today.getMinutes() : today.getMinutes();
                seconds = today.getSeconds().toString().length == 1 ? "0" + today.getSeconds() : today.getSeconds();
                this.real_time_end = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + seconds;

                today.setHours(today.getHours() - this.real_time_length);
                year = today.getFullYear();
                real_month = today.getMonth() + 1;
                month = real_month.toString().length == 1 ? "0" + real_month : real_month;
                day = today.getDate().toString().length == 1 ? "0" + today.getDate() : today.getDate();
                hour = today.getHours().toString().length == 1 ? "0" + today.getHours() : today.getHours();
                minute = today.getMinutes().toString().length == 1 ? "0" + today.getMinutes() : today.getMinutes();
                seconds = today.getSeconds().toString().length == 1 ? "0" + today.getSeconds() : today.getSeconds();
                this.real_time_start = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + seconds;
                this.getRealTimeData();

                setTimeout(this.getRealTimeDates, this.time_to_redraw);
            },

            getRealTimeData() {
                axios.get(
                    this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=ctr,imps,spend&op=sum&from=' + this.real_time_start + '&to=' + this.real_time_end + '&scale=5m', 
                    this.$root.config
                ).then(response => {
                        this.real_time_data = response.data.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            createRealTimeChart(target, dataset, line, second_line) {
                var self = this;
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 40,
                    "marginLeft": 70,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH:NN",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "labelsEnabled": true,
                        "ignoreAxisWidth":true,
                    }, {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "labelsEnabled": true,
                        "ignoreAxisWidth":true,
                        "maximum": 1,
                        labelFunction: function(number, label, axis) {
                            return number * 100 + '%'
                        }
                    }],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "line",
                        "fillAlphas": 1,
                        "lineColor": line == 'imps' ? "#78909c" : "",
                        "fillColors":"#78909c",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "showBalloon": false,
                        "lineThickness": 2,
                        "title": line.charAt(0).toUpperCase() + line.slice(1),
                        "valueField": line,
                    },
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#f76c06",
                        "fillAlphas": 0.0,
                        "fillColors":"#f76c06",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "showBalloon": false,
                        "lineThickness": 2,
                        "title": second_line ? second_line.charAt(0).toUpperCase() + second_line.slice(1) : '',
                        "valueField": second_line,
                        
                    }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "minPeriod": "5mm",
                        "axisAlpha": 0.1,
                        "axisThickness": 2,
                        "minorGridEnabled": false,
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
                        "categoryBalloonDateFormat": "YYYY-MM-DD JJ:NN",
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
                
                if(!second_line) {
                    chart.graphs.splice(1, 1);
                    chart.valueAxes.splice(1, 1);
                    if(self.loaded == false) chart.validateData();
                }

                setInterval(function addNewPoint() {
                    if(self.loaded == true) {
                        var first_element = chart.dataProvider.shift();
                        var new_element = self.real_time_data[self.real_time_data.length - 1];
                        chart.dataProvider.push(new_element);
                        chart.validateData();
                    }
                }, 300000);
            },

            //WEEK CHART
            getOverallData() {
                axios.get(
                    this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=ctr,imps,spend&op=sum&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 23:59:59&scale=1d', 
                    this.$root.config
                ).then(response => {
                        this.overall_data = response.data.data;
                        this.createChart('chart_main', this.overall_data, this.column, this.line);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access overall static graph data.');
                    }
                );
            },

            createChart(target, dataset, column, line) {
                var chart = AmCharts.makeChart(target, {
                    "type": "serial",
                    "theme": "light",
                    "marginRight": 50,
                    "marginLeft": 70,
                    "marginTop": 20,
                    "autoMarginOffset": 20,
                    "mouseWheelZoomEnabled":false,
                    "dataDateFormat": "YYYY-MM-DD HH",
                    "valueAxes": [{
                        "id": "v1",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "left",
                        "labelsEnabled": true,
                        "ignoreAxisWidth":true,
                    }, {
                        "id": "v2",
                        "axisAlpha": 0,
                        "gridAlpha": 0,
                        "position": "right",
                        "labelsEnabled": true,
                        "ignoreAxisWidth":true,
                        labelFunction: function(number, label, axis) {
                            return number > 1 ? number * 10 + '%' : number * 100 + '%'
                        }
                    }],
                    "graphs": [{
                        "valueAxis": "v1",
                        "id": "g1",
                        "type" : "column",
                        "fillAlphas": 1,
                        "fillColors":"#78909c",
                        "lineThickness": 0,
                        "balloonText": "[[date]] <br><br>CTR: [[ctr]]<br>Imps: [[imps]]",
                        "title": "Imps",
                        "valueField": column,
                    },
                    {   
                        "valueAxis": "v2",
                        "id": "g2",
                        "type" : "line",
                        "lineColor":"#f76c06",
                        "fillAlphas": 0.0,
                        "fillColors":"#f76c06",
                        "bullet": "round",
                        "bulletBorderAlpha": 1,
                        "useLineColorForBulletBorder": true,
                        "bulletColor": "#FFFFFF",
                        "showBalloon": false,
                        "lineThickness": 2,
                        "title": "CTR",
                        "valueField": line,
                        
                    }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": true,
                        "dashLength": 0,
                        "axisAlpha": 0.1,
                        "axisThickness": 2,
                        "gridAlpha": 0,
                        "minPeriod": "DD",
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
            },

            //SUMMARY
            getOverallSummary() {
                axios.get(
                    this.$root.reportUri + '?table=wins&acc=' + this.user.accountUuId + '&field=clicks,imps,spend&op=summary&from=' + this.date_from + ' 00:00:00&to=' + this.date_to + ' 23:59:59', 
                    this.$root.config
                ).then(response => {
                        if(response.data.data != undefined) {
                            this.overall_summary = response.data.data;
                        }
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access overall data.');
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
                        this.$root.showAlertPopUp('error', 'Can not access ad groups');
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
                            this.$root.showAlertPopUp('error', 'Can not access creatives.');
                        }
                    );
                }
            },

            //CAMPAIGNS
            getCampaigns() {
                axios.get(
                    this.$root.uri + '/campaigns', 
                    this.$root.config
                ).then(response => {
                        var campaigns = response.data.data;
                        campaigns = campaigns.filter(campaign => campaign.status == 'active');
                        this.campaigns = this.filterDataSize(5, campaigns, true);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not access campaigns');
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
                        this.$root.showAlertPopUp('error', 'Can not access logs.');
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

        filters: {
            capitalize(value) {
                return value.charAt(0).toUpperCase() + value.slice(1);
            }
        },
        
        watch: {
            user(value) {
                this.getCampaigns();
                this.getOverallData();
                this.getOverallSummary();
                this.getRealTimeDates();
            },

            token(value) {
                this.getFolders();
                this.getLogs();
            },

            folders(value) {
                this.getCreatives();
            },
            
            creatives(value) {
                if(value.length > 5) value = this.filterDataSize(5, value, true);
            },

            real_time_data(value) {
                if(!this.loaded) {
                    this.createRealTimeChart('chart_real_time', this.real_time_data, this.real_time_line, this.real_time_line_two);
                    this.createRealTimeChart('chart_real_time_spend', this.real_time_data, this.real_time_line_three);
                    this.loaded = true
                }
            }
        }
    }
</script>