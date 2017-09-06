<template>
 <v-container fluid grid-list-md>
    <v-layout row wrap>
        <v-flex xs12 md6>
            <v-layout row wrap>
                <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                    <h5><i class="material-icons">flight_takeoff</i> Basic Campaign Details</h5>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Campaign Name</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Set a name for your campaign to be identified with</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-text-field
                    label="Campaign Name"
                    hint="At least 8 characters"
                    prepend-icon="mode_edit"
                    v-model="campaign.name"
                    single-line
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Campaign Flight</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Define campaign start and end dates</span>
                </v-flex>
                <v-flex xs12 md5>
                    <v-dialog
                      persistent
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
                        slot="activator"
                        v-model="campaign.start_time"
                        ></v-text-field>
                        <v-date-picker v-model="campaign.start_time" no-title scrollable autosave></v-date-picker>
                    </v-dialog>
                </v-flex>
                 <v-flex xs12 md5>
                    <v-dialog
                      persistent
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
                        slot="activator"
                        v-model="campaign.end_time"
                        ></v-text-field>
                        <v-date-picker v-model="campaign.end_time" no-title scrollable autosave></v-date-picker>
                    </v-dialog>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Advertiser Domain</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Insert advertiser’s TLD (company.com)</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-text-field
                    label="advertiser.com"
                    prepend-icon="language"
                    single-line
                    v-model="campaign.adomain"
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Click-through URL</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Set the default click through URL for your creatives</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-text-field
                    label="http://advertiser.com/landing"
                    prepend-icon="language"
                    single-line
                    v-model="campaign.ctrurl"
                    ></v-text-field>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex xs12 md6>
            <v-layout row wrap>
                <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                    <h5><i class="material-icons">attach_money</i> Budget Details</h5>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Budget Type</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Set budget to "daily" or "campaign"</span>
                </v-flex>
            </v-layout>
            <v-layout>
                <v-flex xs12 md9 class="valign-wrapper">
                    <v-radio-group v-model="campaign.budget.data.type" row class="pa-3">
                        <v-radio label="Daily" value="daily" ></v-radio>
                        <v-radio label="Campaign" value="campaign"></v-radio>
                    </v-radio-group>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Budget</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Set budget for your campaign</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-text-field
                    label="0.00"
                    prepend-icon="attach_money"
                    v-model="campaign.budget.data.amount"
                    single-line
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Target Bid (CPM)</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Allocate the target bid price per 1000 impressions</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-text-field
                    label="0.00"
                    prepend-icon="attach_money"
                    v-model="campaign.bid"
                    single-line
                    ></v-text-field>
                </v-flex>
            </v-layout>
            <v-layout row wrap>
                <v-flex xs12 md9 class="valign-wrapper mt-3">
                    <span class="title">Daily Budget Pacing</span>
                    <span class="title orange-text text-darken-4"> . </span>
                    <span class="caption grey-text text-ldarken-1">Default pacing is between 7:00AM and 1:00AM every day</span>
                </v-flex>
                <v-flex xs12 md9>
                    <v-dialog v-model="showModal" width="1000px" lazy absolute>
                        <v-btn slot="activator" small class="grey lighten-2 mt-3">Set Budget Pacing</v-btn>
                        <v-card>
                            <v-card-title>
                                <div class="headline">Current Pacing Plan</div>
                            </v-card-title>
                        <div class="row form-group form-group-height">
                <div class="col-sm-12">
                    <table class="table table-sm table-responsive table-striped">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Time</th>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr v-for="time in timesOfDay">
                                <th>{{ time }}</th>
                                <td v-for="day in days"><i :class="getTimeActiveClass(days.indexOf(day), timesOfDay.indexOf(time))"></i></td>
                            </tr>
                         </tbody>
                    </table>
                </div>  
            </div>
            <div class="row form-group form-group-height">
                <div class="col-sm-12">
                        <legend><i class="fa fa-fw fa-pencil"></i> Edit Plan</legend>
                </div>
                <div class="form-group">    
                    <div class="col-sm-4">
                        <label class=" control-label" for="campaign-daily-budget">Active Days of Week</label>
                    </div>
                    <div class="col-sm-12">
                        <ul class="checkbox-list">
                            <li v-for="day in days" class="checkbox">
                                <label>
                                    <input type="checkbox" :value="days.indexOf(day)" v-model="selectedDays" @change="applyPlan()" class="checkbox style-orange" >
                                    <span>{{ day }}</span> 
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-4">
                        <label class=" control-label" for="campaign-daily-budget">Active Hours of Day</label>
                        <p class="help-block">Hours will be only edited for active days</p>
                    </div>
                    <div class="col-sm-12">
                        <ul class="checkbox-list">
                            <li v-for="time in timesOfDay" class="checkbox">
                                <label>
                                    <input type="checkbox" :value="timesOfDay.indexOf(time)" v-model="selectedTimes" @change="applyPlan()" class="checkbox style-orange" >
                                    <span>{{ time }}</span> 
                                </label>
                            </li>
                        </ul>
                     </div>
                 </div>
            </div>
            <div class="row">

            </div>
                        </v-card>
                    </v-dialog>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</v-container>
</template>
<script>
    export default {
        
        mounted() {
            console.log('Details component mounted.')
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
                selectedTimes: [1, 2, 3, 4, 5, 6]
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
            openModal() {
                this.$root.modalIsOpen = true;
                return false;
            },
            getTimeActiveClass(d, t) {
                var timeActiveClass = ""
                var hPlan = this.campaign.budget.data.pacing
                var timeOfWeek = d * 7 + t + d
                var activeT = hPlan.charAt(timeOfWeek)
                if(activeT == "1") {
                    timeActiveClass = "fa fa-fw fa-check-circle fa-active"
                } else {
                    timeActiveClass = "fa fa-fw fa-circle fa-inactive"
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
            }
        }
    }
</script>