<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>Basic Campaign Details</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Campaign Name</span>
                        <p class="ma-0">Set a name for your campaign to be identified with</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Campaign Name"
                        prepend-icon="mode_edit"
                        v-model="campaign.name"
                        single-line
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Campaign Flight</span>
                        <p class="ma-0">Define campaign start and end dates</p>
                    </v-flex>
                    <v-flex xs6 md5 lg4>
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
                    <v-flex xs6 md5 lg4>
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
                            slot="activator"
                            v-model="campaign.end_time"
                            ></v-text-field>
                            <v-date-picker v-model="campaign.end_time" no-title scrollable autosave></v-date-picker>
                        </v-dialog>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Advertiser Domain</span>
                        <p class="ma-0">Insert advertiser’s TLD (company.com)</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="advertiser.com"
                        prepend-icon="language"
                        single-line
                        v-model="campaign.adomain"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Click-through URL</span>
                        <p class="ma-0">Set the default click through URL for your creatives</p>
                    </v-flex>
                    <v-flex xs12 md8>
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
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>Budget Details</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Budget Type</span>
                        <p class="ma-0">Set budget to "daily" or "campaign"; "campaign" budget spans the budget across the lifetime of the campaign</p>
                    </v-flex>
                </v-layout>
                <v-layout>
                    <v-flex xs12 md9 class="valign-wrapper">
                        <v-radio-group v-model="campaign.budget.data.type" row class="pa-1">
                            <v-radio label="Daily" value="daily" ></v-radio>
                            <v-radio label="Campaign" value="campaign"></v-radio>
                        </v-radio-group>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Budget</span>
                        <p class="ma-0">Set budget for your campaign</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="0.00"
                        prepend-icon="attach_money"
                        v-model="budgetUsd"
                        single-line
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Target Bid (CPM)</span>
                        <p class="ma-0">Allocate the target bid price per 1000 impressions</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="0.00"
                        prepend-icon="attach_money"
                        v-model="bidUsd"
                        single-line
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Daily Budget Pacing</span>
                        <p class="ma-0">Default pacing is enabled every day between 7:00AM and 1:00AM next day</p>
                    </v-flex>
                    <v-flex xs12 md9>
                        <v-dialog v-model="showModal" width="1500px" lazy absolute>
                            <v-btn slot="activator" small class="grey lighten-2 mt-3">Set Budget Pacing</v-btn>
                                <v-card>
                                <v-container fluid grid-list-md>
                                    <v-layout row wrap>
                                        <v-flex xs12 class="mb-3 mt-4">
                                            <h4>Basic Campaign Details</h4>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <table class="table table-sm table-responsive table-striped">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Time</th>
                                                    <td>Sun</td>
                                                    <td>Mon</td>
                                                    <td>Tue</td>
                                                    <td>wed</td>
                                                    <td>Thu</td>
                                                    <td>Fri</td>
                                                    <td>Sat</td>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr v-for="time in timesOfDay">
                                                    <th>{{ time }}</th>
                                                    <td v-for="day in days">
                                                        <v-icon v-if="getTimeActiveClass(days.indexOf(day), timesOfDay.indexOf(time))==true">check</v-icon>
                                                        <v-icon v-else>close</v-icon>
                                                    </td>
                                                </tr>
                                             </tbody>
                                        </table>
                                    </v-layout>
                                    <v-layout row wrap>
                                        <v-flex xs12 class="mb-3 mt-4">
                                            <h4>Choose Your Days</h4>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row wrap>
                                      <v-flex xs12 md2 v-for="day in days" :key="day.index">
                                        <v-card class="elevation-0">
                                            <v-card-text>
                                                <v-checkbox :label="day" v-model="selectedDays" :value="days.indexOf(day)"></v-checkbox>
                                            </v-card-text>
                                        </v-card>
                                    </v-flex>
                                    </v-layout>
                                    <v-layout row wrap>
                                        <v-flex xs12 class="mb-3 mt-4">
                                            <h4>Choose Your Times</h4>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout>
                                        <v-flex xs12 md2 v-for="time in timesOfDay" :key="time.index">
                                            <v-card class="elevation-0">
                                              <v-card-text>
                                                    <v-checkbox :label="time" v-model="selectedTimes" :value="timesOfDay.indexOf(time)"></v-checkbox>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
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
                var timeActiveClass = false
                var hPlan = this.campaign.budget.data.pacing
                var timeOfWeek = d * 7 + t + d
                var activeT = hPlan.charAt(timeOfWeek)
                if(activeT == "1") {
                    timeActiveClass = true
                } else {
                    timeActiveClass = false
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