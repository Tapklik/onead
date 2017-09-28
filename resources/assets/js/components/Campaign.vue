<template>
    <div>
        <v-stepper class="elevation-0" v-model="e1" alt-labels>
            <v-stepper-header class="elevation-0">
                <v-stepper-step step="1" :complete="e1 > 1" editable>DETAILS</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="e1 > 2" editable>CATEGORIES</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3" :complete="e1 > 3" editable>CREATIVES</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="4" :complete="e1 > 4" editable>TARGETING</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="5" editable>REVIEW</v-stepper-step>
            </v-stepper-header>
            <v-stepper-content step="1">
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                <campaign-details :campaign="campaign" :state="stateReady"
                :startTime="campaign.start_time"
                :endTime="campaign.end_time"></campaign-details>
            </v-stepper-content>
            <v-stepper-content step="2">
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                <campaign-categories :campaign="campaign" :state="stateReady"></campaign-categories>
            </v-stepper-content>
            <v-stepper-content step="3">
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
               <campaign-creatives :user="user" :token="token" :campaign="campaign"></campaign-creatives>
            </v-stepper-content>
            <v-stepper-content step="4">
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                <campaign-targeting :campaign="campaign" :state="stateReady"></campaign-targeting>
            </v-stepper-content>
            <v-stepper-content step="5">
                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                <campaign-review :selectedUa="selectedUa" :selectedOs="selectedOs" :selectedDevices="selectedDevices" :selectedCategories="selectedCategories" :user="user" :token="token" :campaign="campaign" :state="stateReady" :folder="currentFolder" :gender="selectedGender()"></campaign-review>
            </v-stepper-content>
        </v-stepper>
    </div>         
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.$root.isLoading = false;
            this.loadCategories();
            this.loadTechnologies();
        },

        props: ['token', 'user'],

        data() {
            return {
                technologiesList: [],
                alert: false,
                error: false,
                success: false,
                alertMessage: '',
                e1: 1,
                campaignId: null,
                campaign: {
                    daysDetails: [0, 1, 2, 3, 4, 5, 6],
                    timesDetails: [1, 2, 3, 4, 5, 6],
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    exchange: 1,
                    test: 1,
                    weight: 1,
                    status: 1,
                    total: 1,
                    start_time: this.getDate(0),
                    end_time: this.getDate(7),
                    geo: {
                        data: []
                    },
                    cat: {
                        data: []
                    },
                    creatives: {
                        data: []
                    },

                    budget: {
                        data: {
                            amount: 0,
                            pacing: "0111111 0111111 0111111 0111111 0111111 0111111 0111111",
                            type: 'daily',
                        }
                    },
                    device: {
                        data: {
                            type: [],
                            make: [],
                            model: [],
                            os: [],
                            ua: [],
                        }
                    },
                    user: {
                        data: {
                            gender: [],
                            age: {
                                min: 18,
                                max: 55
                            }
                        }
                    }
                },
                categoriesList: false,
                creatives: [],
                currentFolder: {},
                ageChange: false,
                stateReady: false
            }
        },

        methods: {

            loadCategories() {

                axios.get('/data/categories.json').then(response => {
                    this.categoriesList = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            fetchCampaign(id) {

                // Details
                axios.get(this.$root.uri + '/campaigns/' + id, this.$root.config).then(response => {
                    this.campaign = response.data.data;

                    this.fetchCampaignCategories(id);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            fetchCampaignCategories(id) {
                // Categories
                axios.get(this.$root.uri + '/campaigns/' + id + '/cat', this.$root.config).then(response => {
                    this.campaign.cat = response.data;
                    this.categories = this.campaign.cat.data;

                    this.fetchCampaignUser(id);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },
            
            fetchCampaignUser(id) {

                axios.get(this.$root.uri + '/campaigns/' + id + '/users', this.$root.config).then(response => {
                    this.campaign.user = response.data;

                    this.fetchCampaignBudget(id);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            fetchCampaignBudget(id) {

                axios.get(this.$root.uri + '/campaigns/' + id + '/budget', this.$root.config).then(response => {
                    this.campaign.budget = response.data;

                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            selectedGender() {

                if (this.campaign.user.data.gender.length == 2 || !this.campaign.user.data.gender.length) {
                    return "M&F";
                } else {
                    return this.campaign.user.data.gender.join('').toUpperCase();
                }

            },

            updateCurrentFolder(folder) {

                this.currentFolder = folder;
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

            __toObject(arr) {
                var bucket = {};

                for(var i in arr) {
                    bucket[i] = arr[i];
                }

                return bucket;
            },
            loadTechnologies() {

                axios.get('/data/technologies.json').then(response => {
                    this.technologiesList = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },
        },
        computed: {
            selectedOs() {
                var os = [];
                var technologiesList = this.technologiesList.operatingsystems;
                var selections = this.campaign.device.data.os;
                for (var s in selections) {
                    var id = selections[s];
                    for(var tech in technologiesList) {
                        if(id == technologiesList[tech].device_id) {

                        os.push(technologiesList[tech]);
                        break;
                        }       
                    }
                }
                return os;  
            },
            selectedDevices() {
                var devices = [];
                var technologiesList = this.technologiesList.devices;
                var selections = this.campaign.device.data.type;
                for (var s in selections) {
                    var id = selections[s];
                    for(var tech in technologiesList) {
                        if(id == technologiesList[tech].device_id) {

                        devices.push(technologiesList[tech]);
                        break;
                        }       
                    }
                } 
                return devices;  
            },
            selectedUa() {
                var ua = [];
                var technologiesList = this.technologiesList.browsers;
                var selections = this.campaign.device.data.ua;
                for (var s in selections) {
                    var id = selections[s];
                    for(var tech in technologiesList) {
                        if(id == technologiesList[tech].device_id) {

                        ua.push(technologiesList[tech]);
                        break;
                        }       
                    }
                }
                return ua;  
            },
            selectedCategories() {
                var categories = [];
                var categoriesList = this.categoriesList;
                var selections = this.campaign.cat.data;
                for (var s in selections) {
                    var id = selections[s];
                    for(var category in categoriesList) {
                        if(id == categoriesList[category].code) {

                        categories.push(categoriesList[category]);
                        break;
                        }       
                    }
                }
                return categories;
            }
        },
        watch: {
            token (value) {

                this.stateReady = true;

                if (this.$root.editMode) {
                    var campaignId = this.$root.getCampaignId();

                    this.fetchCampaign(campaignId);
                }
            },

            editMode(value) {

                this.campaignId = window.location.pathname.replace('/admin/campaigns/edit/', '');
            },

            campaign(value) {
                // Update folder
                this.folder = (typeof this.campaign.creatives.data[0] != 'undefined') ? this.campaign.creatives.data[0].folder : [];
            },

            gender(value) {

            },
        }

    }
</script>
