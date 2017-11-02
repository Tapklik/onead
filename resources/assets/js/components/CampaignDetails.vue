<template>
    <v-container grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAMPAIGN DETAILS</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md5 lg4 class="valign-wrapper">
                        <span class="title">Campaign Name</span>
                        <p class="caption ma-0">Set a name for your campaign to be identified with</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-text-field
                        :rules="campaignNameRules()"
                        label="Campaign Name"
                        prepend-icon="mode_edit"
                        v-model="campaign.name"
                        single-line
                        v-on:blur="updateDetailsDraft()"
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
                            v-on:change="updateDetailsDraft()"
                            ></v-text-field>
                            <v-date-picker v-model="campaign.start_time" no-title scrollable autosave></v-date-picker>
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
                            v-on:change="updateDetailsDraft()"
                            v-model="campaign.end_time"
                            ></v-text-field>
                            <v-date-picker v-model="campaign.end_time" no-title scrollable autosave></v-date-picker>
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
                            v-on:blur="updateDetailsDraft()"
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
                            v-on:blur="updateDetailsDraft()"
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
                        <v-radio-group v-model="campaign.budget.data.type" v-on:change="updateDraftBudget()"row class="pa-1">
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
                        v-on:blur="updateDraftBudget()"
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
                        v-on:change="updateDetailsDraft()"
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
                        <p class="caption ma-0">Default pacing is enabled every day between 7:00AM and 1:00AM next day</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-dialog v-model="showModal" lazy absolute width="70%">
                            <v-btn slot="activator"><v-icon left class="small">monetization_on</v-icon>Set Budget Pacing</v-btn>
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
                                                    v-model="selectedDays" 
                                                    :value="days.indexOf(day)"
                                                    ></v-checkbox>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap>
                                                <v-flex xs12 class="valign-wrapper mt-5">
                                                    <span class="title">Active Hour of Day</span>
                                                    <p class="caption ma-0">Hours will be only edited for active days</p>
                                                </v-flex>
                                                <v-flex xs12 md6 lg4 v-for="time in timesOfDay" :key="time.index">
                                                    <v-checkbox  
                                                    color="orange darken-4"
                                                    :label="time" 
                                                    v-model="selectedTimes"
                                                    :value="timesOfDay.indexOf(time)"
                                                    ></v-checkbox>
                                                </v-flex>
                                            </v-layout>
                                        </v-flex>  
                                        <v-flex xs12 md5 >
                                            <v-card class="elevation-0 border">
                                                <v-card-text>
                                                    <span class="title">Plan Preview</span>
                                                    <p class="caption ma-0">Here you can see your weekly budget pacing plan</p>
                                                    <v-data-table class="mt-4 @blurpacing-preview" :items="timesOfDay" hide-actions>
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
                                                                <td class="small pa-0" v-for="day in days" v-html="getTimeActiveClass(days.indexOf(day), timesOfDay.indexOf(props.item))"></td>
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
                                    <v-btn @click="showModal = false" class="elevation-0">
                                        <v-icon>close</v-icon>                                    
                                        Cancel
                                    </v-btn>
                                    <v-btn primary dark @click="applyPlan(),showModal=false, updateDraftBudget()" class="elevation-0">
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>   
                        </v-dialog>
                        <br> <span class="red--text" v-show="daysAndTimesRules()">You must select days and times</span>
                    </v-flex>
                </v-layout>
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

        props: ['campaign'],
        
        data() {
            return {
                showModal: false,
                dateFormat: 'yyyy-MM-dd',
                isActive: true,
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                timesOfDay: ['12:00AM - 7:00AM', '7:00AM - 10:00AM', '10:00AM - 1:00PM', '1:00PM - 4:00PM', '4:00PM - 7:00PM', 
                '7:00PM - 10:00PM', '10:00PM - 12:00AM'],
                selectedDays: [0, 1, 2, 3, 4, 5, 6],
                selectedTimes: [1, 2, 3, 4, 5, 6],
                pacing: this.campaign.budget.data.pacing,
                ctrurlCheck: false 
            }
        },
        
        computed: {
            bidUsd: {
                // getter
                get: function () {
                    return this.campaign.bid / 1000000 
                },
                // setter
                set: function (usd) {
                    this.campaign.bid = usd * 1000000
                }
            },
            budgetUsd: {
                // getter
                get: function () {
                    return this.campaign.budget.data.amount / 1000000
                },
                // setter
                set: function (usd) {
                    this.campaign.budget.data.amount = usd * 1000000
                }
            }
        },
        methods: {
            campaignNameRules() {
                var name = ['too short'];
                if(this.campaign.name.length < 4) {
                    this.$parent.$parent.$parent.validName = false;
                    return name;
                }
                else {
                    this.$parent.$parent.$parent.validName = true;   
                }
            },

            budgetRules() {
                var budget = ['budget must be higher than bid'];
                var zero = ['Budget can not be 0'];
                if(this.campaign.bid > this.campaign.budget.data.amount || this.campaign.budget.data.amount == 0) {
                    this.$parent.$parent.$parent.validBudget = false;
                    if(this.campaign.budget.data.amount == 0) {
                        return zero;
                    }
                    else {
                        return budget;
                    }
                }
                else {
                    this.$parent.$parent.$parent.validBudget = true;
                }
            },

            bidRules() {
                var bid = ['budget must be higher than bid'];
                var zero = ['Bid can not be 0'];
                if(this.campaign.bid > this.campaign.budget.data.amount || this.campaign.bid == 0) {
                    this.$parent.$parent.$parent.validBid = false;
                    if(this.campaign.bid == 0) {
                        return zero;
                    }
                    else {
                        return bid;
                    }
                }
                else {
                    this.$parent.$parent.$parent.validBid = true;
                }
            },

            startDateRules() {
                var date = ['start before end'];
                var todayDate = ['this date is before today']
                var today = this.$parent.$parent.$parent.getDate(0);
                if (this.campaign.start_time >= this.campaign.end_time) {
                    return date;
                    this.$parent.$parent.$parent.validStart = false;
                }
                else if(this.campaign.start_time < today && this.$root.editMode == false) {
                    return todayDate;
                    this.$parent.$parent.$parent.validStart = false;
                }

                else {
                    this.$parent.$parent.$parent.validStart = true;
                }
            },

            domainRules() {
                var url = ['not a valid domain'];
                if(!this.campaign.adomain) return;
                else if(this.campaign.adomain.includes(".")) {
                    this.$parent.$parent.$parent.validDomain = true;
                }
                else { 
                    this.$parent.$parent.$parent.validDomain = false;
                    return url;
                }
            },

            urlRules() {
                var url = ['not a valid url'];
                if(!this.campaign.ctrurl) return;
                else if((this.campaign.ctrurl.startsWith("http://") && this.campaign.ctrurl.includes("."))|| (this.campaign.ctrurl.startsWith("https://") && this.campaign.ctrurl.includes("."))) { 
                    this.$parent.$parent.$parent.validUrl = true;
                }

                else { 
                    this.$parent.$parent.$parent.validUrl = false;
                    return url;
                }
            },

            endDateRules() {
                var date = ['start before end'];
                var todayDate = ['this date is before today'];
                var today = this.$parent.$parent.$parent.getDate(0);
                if (this.campaign.start_time >= this.campaign.end_time) {
                    this.$parent.$parent.$parent.validEnd = false;
                    return date;
                }
                else if(this.campaign.end_time < today && this.$root.editMode == false) {
                    this.$parent.$parent.$parent.validEnd = false;
                    return todayDate;
                }
                else {
                    this.$parent.$parent.$parent.validEnd = true;
                }
            },

            daysAndTimesRules() {
                if(this.selectedTimes == '' || this.selectedDays=='') {
                    this.$parent.$parent.$parent.validPacing = false;
                    return true;
                }
       
                else {
                    this.$parent.$parent.$parent.validPacing = true;
                    return false
                }
            
            },

            openModal() {
                this.$root.modalIsOpen = true;
                return false;
            },

            draftData() {
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

            updateDetailsDraft() {
                if(this.campaign.status != 'draft') return;
                else {
                    var payload = this.draftData();

                    axios.put(this.$root.uri + '/campaigns/' + this.campaign.id, payload, this.$root.config).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    });  
                }
            },

            updateDraftBudget() {
                if(this.campaign.status != 'draft') return;
                else {
                    var payload = this.campaign.budget.data;
    
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/budget', payload, this.$root.config).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    });
                }
            },
            
            getTimeActiveClass(d, t) {
                var timeActiveClass = false
                var hPlan = this.pacing
                var timeOfWeek = d * 7 + t + d
                var activeT = hPlan.charAt(timeOfWeek)
                if(activeT == "1") {
                    timeActiveClass = '<i class="material-icons icon orange--text text--darken-4">check</i>'
                } else {
                    timeActiveClass = '<i class="material-icons icon grey--text ">remove</i>'
                }
                return timeActiveClass  
            },
            applyPlan() {
                var plan = ""
                for (var d = 0; d < 7; d++) {
                    if (d > 0) {plan += " "}
                        if (this.selectedDays.indexOf(d) >= 0 ) {
                            for( var t = 0; t < 7; t++) {
                                if(this.selectedTimes.indexOf(t) >= 0) {
                                    plan += "1"
                                } else {
                                    plan += "0"
                                }
                            }
                        } else {
                            plan += "0000000"
                        }
                    }
                    this.campaign.budget.data.pacing = plan
                },
            applyCurrentlyPlan() {
                var plan = ""
                for (var d = 0; d < 7; d++) {
                    if (d > 0) {plan += " "}
                        if (this.selectedDays.indexOf(d) >= 0 ) {
                            for( var t = 0; t < 7; t++) {
                                if(this.selectedTimes.indexOf(t) >= 0) {
                                    plan += "1"
                                } else {
                                    plan += "0"
                                }
                            }
                        } else {
                            plan += "0000000"
                        }
                    }
                    this.pacing = plan
                }
            },
            watch: {
                selectedTimes(value) {
                    this.campaign.timesDetails = value;
                    this.applyCurrentlyPlan();
                
                },
                selectedDays(value) {
                    this.campaign.daysDetails = value;
                    this.applyCurrentlyPlan();
                }
            }
        }
    </script>