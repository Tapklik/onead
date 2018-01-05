<template>
    <v-container grid-list-md>

        <!-- HEADER START -->
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAMPAIGN DETAILS</h5>
            </v-flex>
        </v-layout>
        <!-- HEADER END -->

        <!-- FORM START -->
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Campaign Name</span>
                        <p class="caption ma-0">Set a name for your campaign to be identified with</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-text-field
                        :rules="nameRules()"
                        label="Campaign Name"
                        prepend-icon="mode_edit"
                        v-model="campaign.name"
                        single-line
                        @blur="updateDetails()"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mt-4">
                        <span class="title">Campaign Flight</span>
                        <p class="caption ma-0">Define campaign start and end dates</p>
                    </v-flex>
                    <v-flex xs12 md5>
                        <v-dialog
                        :v-model="false"
                        lazy
                        full-width
                        >
                            <v-text-field
                            label="From"
                            prepend-icon="flight_takeoff"
                            append-icon="date_range"
                            single-line
                            readonly
                            :rules="startDateRules()"
                            slot="activator"
                            v-model="campaign.start_time"
                            @change="updateDetails()"
                            ></v-text-field>
                            <v-date-picker 
                            v-model="campaign.start_time" 
                            no-title scrollable autosave
                            ></v-date-picker>
                        </v-dialog>
                    </v-flex>
                    <v-flex xs12 md5>
                        <v-dialog
                        :v-model="false"
                        lazy
                        full-width
                        >
                            <v-text-field
                            label="From"
                            prepend-icon="flight_takeoff"
                            append-icon="date_range"
                            single-line
                            readonly
                            :rules="endDateRules()"
                            slot="activator"
                            @change="updateDetails()"
                            v-model="campaign.end_time"
                            ></v-text-field>
                            <v-date-picker 
                            v-model="campaign.end_time" 
                            no-title 
                            scrollable 
                            autosave
                            ></v-date-picker>
                        </v-dialog>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Advertiser Domain</span>
                        <p class="caption ma-0">Insert advertiser’s TLD (company.com)</p>
                    </v-flex>
                    <v-flex xs12 md6>
                        <form>
                            <v-text-field
                            label="advertiser.com"
                            prepend-icon="language"
                            single-line
                            type="url"
                            @blur="updateDetails()"
                            :rules="domainRules()"
                            v-model="campaign.adomain"
                            ></v-text-field>
                        </form>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Click-through URL</span>
                        <p class="caption ma-0">Set the default click through URL for your creatives</p>
                    </v-flex>
                    <v-flex xs12 md10>
                        <form>
                            <v-text-field
                            label="http://advertiser.com/landing"
                            prepend-icon="language"
                            single-line
                            type="url"
                            @blur="updateDetails()"
                            :rules="urlRules()"
                            v-model="campaign.ctrurl"
                            ></v-text-field>
                        </form>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md8 class="valign-wrapper">
                        <span class="title">Budget Type</span>
                        <p class="caption ma-0">Set budget to "daily" or "campaign"; "campaign" budget spans the budget across the lifetime of the campaign</p>
                    </v-flex>
                </v-layout>
                <v-layout>
                    <v-flex xs12 md9 class="valign-wrapper">
                        <v-radio-group 
                        v-model="campaign.budget.data.type" 
                        @change="updateBudget()"
                        row 
                        class="pa-1"
                        >
                            <v-radio label="Daily" value="daily" ></v-radio>
                            <v-radio label="Campaign" value="campaign"></v-radio>
                        </v-radio-group>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Budget</span>
                        <p class="caption ma-0">Set budget for your campaign</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-text-field
                        label="0.00"
                        @blur="updateBudget()"
                        prepend-icon="attach_money"
                        v-model="budgetUsd"
                        :rules="budgetRules()"
                        single-line
                        type="number"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Target Bid (CPM)</span>
                        <p class="caption ma-0">Allocate the target bid price per 1000 impressions</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-text-field
                        :rules="bidRules()"
                        label="0.00"
                        @blur="updateDetails()"
                        prepend-icon="attach_money"
                        v-model="bidUsd"
                        single-line
                        type="number"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-5">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Daily Budget Pacing</span>
                        <p class="caption ma-0">
                            Default pacing is enabled every day between 7:00AM and 1:00AM next day
                        </p>
                    </v-flex>

                    <!-- PACING MODAL START -->
                    <v-flex xs8 md5>
                        <v-dialog v-model="show_pacing_modal" lazy absolute width="70%">
                            <v-btn slot="activator">
                                <v-icon left class="small">monetization_on</v-icon>
                                Set Budget Pacing
                            </v-btn>
                            <v-card>
                                <v-card-title>
                                    <h4>Budget Pacing</h4>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex xs12 md7>
                                            <v-layout row wrap>
                                                <v-flex xs12 mdclass="valign-wrapper mt-4">
                                                    <span class="title">Active Days of Week</span>
                                                </v-flex>
                                                <v-flex xs6 md3 lg2 v-for="day in days" :key="day.index">
                                                    <v-checkbox 
                                                    color="orange darken-4"
                                                    :label="day" 
                                                    v-model="selected_days" 
                                                    :value="days.indexOf(day)"
                                                    ></v-checkbox>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap>
                                                <v-flex xs12 class="valign-wrapper mt-5">
                                                    <span class="title">Active Hour of Day</span>
                                                    <p class="caption ma-0">Hours will be only edited for active days</p>
                                                </v-flex>
                                                <v-flex xs12 md6 lg4 v-for="time in times" :key="time.index">
                                                    <v-checkbox  
                                                    color="orange darken-4"
                                                    :label="time" 
                                                    v-model="selected_times"
                                                    :value="times.indexOf(time)"
                                                    ></v-checkbox>
                                                </v-flex>
                                            </v-layout>
                                        </v-flex>  
                                        <v-flex xs12 md5 >
                                            <v-card class="elevation-0 border">
                                                <v-card-text>
                                                    <span class="title">Plan Preview</span>
                                                    <p class="caption ma-0">Here you can see your weekly budget pacing plan</p>
                                                    <v-data-table class="mt-4 @blurpacing-preview" :items="times" hide-actions>
                                                        <template slot="headers" scope="props">
                                                            <th>Time</th>
                                                            <th class="pa-0">S</th>
                                                            <th class="pa-0">M</th>
                                                            <th class="pa-0">T</th>
                                                            <th class="pa-0">W</th>
                                                            <th class="pa-0">T</th>
                                                            <th class="pa-0">F</th>
                                                            <th class="pa-0">S</th>
                                                        </template>
                                                        <template slot="items" scope="props">
                                                            <tr>
                                                                <th class="caption pa-0">{{ props.item }}</th>
                                                                <td 
                                                                class="small pa-0" 
                                                                v-for="day in days" 
                                                                v-html="toggleActiveTimes(days.indexOf(day), 
                                                                times.indexOf(props.item))"
                                                                ></td>
                                                            </tr>
                                                        </template>
                                                    </v-data-table>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>  
                                    </v-layout>        
                                </v-card-text>
                                 <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="show_pacing_modal = false" class="elevation-0">
                                        <v-icon>close</v-icon>                                    
                                        Cancel
                                    </v-btn>
                                    <v-btn 
                                    primary 
                                    dark 
                                    @click="applyPlan(),
                                    show_pacing_modal=false" 
                                    class="elevation-0"
                                    >
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>   
                        </v-dialog>
                        <!-- PACING MODAL END -->

                        <br />
                        <span class="red--text" v-show="!pacingRules()">
                            You must select days and times
                        </span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <!-- FORM END -->

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

        props: ['campaign', 'valid'],
        
        data() {
            return {
                //PACING MODAL
                show_pacing_modal: false,
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                times: [
                    '12:00AM - 7:00AM', 
                    '7:00AM - 10:00AM', 
                    '10:00AM - 1:00PM', 
                    '1:00PM - 4:00PM', 
                    '4:00PM - 7:00PM',
                    '7:00PM - 10:00PM', 
                    '10:00PM - 12:00AM'
                ],
                selected_days: [0, 1, 2, 3, 4, 5, 6],
                selected_times: [1, 2, 3, 4, 5, 6],
                pacing: this.campaign.budget.data.pacing
            }
        },
        
        computed: {
            bidUsd: {
                get() {
                    return this.campaign.bid / 1000000 
                },
                set(usd) {
                    this.campaign.bid = usd * 1000000
                }
            },
            budgetUsd: {
                get() {
                    return this.campaign.budget.data.amount / 1000000
                },
                set(usd) {
                    this.campaign.budget.data.amount = usd * 1000000
                }
            }
        },

        methods: {

            //VALIDATION
            nameRules() {
                var name = ['too short'];
                this.valid.name = this.campaign.name.length < 4 ? false : true;
                if(!this.valid.name) return name;
            },

            budgetRules() {
                var budget = ['budget must be higher than bid'];
                var zero = ['Budget can not be 0'];
                if(this.campaign.bid > this.campaign.budget.data.amount || this.campaign.budget.data.amount == 0) {
                    this.valid.budget = false;
                    return this.campaign.budget.data.amount == 0 ? zero : budget;
                }
                else {
                    this.valid.budget = true;
                }
            },

            bidRules() {
                var bid = ['budget must be higher than bid'];
                var zero = ['Bid can not be 0'];
                if(this.campaign.bid > this.campaign.budget.data.amount || this.campaign.bid == 0) {
                    this.valid.bid = false;
                    return this.campaign.bid == 0 ? zero : bid;
                }
                else {
                    this.valid.bid = true;
                }
            },

            startDateRules() {
                var date = ['start before end'];
                var todayDate = ['this date is before today']
                var today = this.$parent.$parent.$parent.getDate(0);
                if (this.campaign.start_time >= this.campaign.end_time) {
                    return date;
                    this.valid.start = false;
                }
                else if(this.campaign.start_time < today && this.$root.editMode == false) {
                    return todayDate;
                    this.valid.start = false;
                }

                else {
                    this.valid.start = true;
                }
            },

            domainRules() {
                var url = ['not a valid domain'];
                var regexp = new RegExp('((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ 
                    '((\\d{1,3}\\.){3}\\d{1,3}))' + 
                    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+
                    '(\\?[;&a-z\\d%_.~+=-]*)?'+
                    '(\\#[-a-z\\d_]*)?$','i');

                this.valid.domain = regexp.test(this.campaign.adomain) ? true : false;
                if(!this.valid.domain) return url;
            },

            urlRules() {
                var url = ['not a valid url'];
                var regexp = new RegExp('^(https?:\\/\\/)?'+ 
                    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ 
                    '((\\d{1,3}\\.){3}\\d{1,3}))' + 
                    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+
                    '(\\?[;&a-z\\d%_.~+=-]*)?'+
                    '(\\#[-a-z\\d_]*)?$','i'); 

                this.valid.url = regexp.test(this.campaign.ctrurl) ? true : false;
                if(!this.valid.url) return url;
            },

            endDateRules() {
                var date = ['start before end'];
                var todayDate = ['this date is before today'];
                var today = this.$parent.$parent.$parent.getDate(0);
                if (this.campaign.start_time >= this.campaign.end_time) {
                    this.valid.end = false;
                    return date;
                }
                else if(this.campaign.end_time < today && this.$root.editMode == false) {
                    this.valid.end = false;
                    return todayDate;
                }
                else {
                    this.valid.end = true;
                }
            },

            pacingRules() {
                this.valid.pacing = (this.selected_times == '' || this.selected_days=='') ? false : true;
                return this.valid.pacing ? true : false;
            },

            //UPDATE DRAFT
            collectDraft() {
                return {
                    name: this.campaign.name,
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: 'draft',
                    weight: this.campaign.weight,
                    node: this.campaign.node
                }
            },

            updateDetails() {
                if(this.campaign.status != 'draft') return;

                axios.put(
                    this.$root.uri + '/campaigns/' + this.campaign.id, 
                    this.collectDraft(), 
                    this.$root.config
                ).then(response => {
                
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );  
            },

            updateBudget() {
                if(this.campaign.status != 'draft') return;

                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/budget', 
                    this.campaign.budget.data, 
                    this.$root.config
                ).then(response => {
                
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },
            
            //PACING MODAL
            toggleActiveTimes(day, time) {
                var result = '';
                var time_of_week = day * 7 + time + day;
                var active_time = this.pacing.charAt(time_of_week);
                var active = '<i class="material-icons icon orange--text text--darken-4">check</i>';
                var inactive = '<i class="material-icons icon grey--text ">remove</i>';
                result = active_time == "1" ? active : inactive;
                return result;
            },

            applyPlan() {
                this.campaign.budget.data.pacing = this.pacing;
                this.updateBudget();
            },
            
            calculatePacing() {
                var plan = ""
                for (var d = 0; d < 7; d++) {
                    if (d > 0) plan += " ";
                    var selected_day = this.selected_days.indexOf(d) != -1 ? true : false;
                    if (!selected_day) plan += "0000000";
                    else {
                        for(var t = 0; t < 7; t++) {
                            plan += this.selected_times.indexOf(t) >= 0 ? "1" : "0";
                        }
                    }    
                }
                this.pacing = plan
            }
        },
            
        watch: {
            selected_times(value) {
                this.calculatePacing();
            },
        
            selected_days(value) {
                this.calculatePacing();
            }
        }
    }
</script>