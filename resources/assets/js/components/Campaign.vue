<template>
    <div>
        <v-stepper class="elevation-0" v-model="e1" alt-labels>
            <v-stepper-header class="elevation-0">
                <v-stepper-step step="1" :complete="e1 > 1" editable>Details</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="e1 > 2" editable>Categories</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3" :complete="e1 > 3" editable>Creatives</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="4" :complete="e1 > 4" editable>Targeting</v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="5" editable>Review</v-stepper-step>
            </v-stepper-header>
            <v-stepper-content step="1">
                <campaign-details :campaign="campaign" :state="stateReady"
                :startTime="campaign.start_time"
                :endTime="campaign.end_time"></campaign-details>
            </v-stepper-content>
            <v-stepper-content step="2">
                <campaign-categories :campaign="campaign" :state="stateReady"></campaign-categories>
            </v-stepper-content>
            <v-stepper-content step="3">
               <campaign-creatives :user="user" :token="token" :campaign="campaign"></campaign-creatives>
            </v-stepper-content>
            <v-stepper-content step="4">
                <campaign-targeting :campaign="campaign" :state="stateReady"></campaign-targeting>
            </v-stepper-content>
            <v-stepper-content step="5">
                
            </v-stepper-content>
        </v-stepper>
    </div>         
</template>

<script>
    export default {
        mounted() {
            console.log('Create Campaign Mounted.');

            // Check if campaign is in edit mode
            this.loadCategories();
        },

        props: ['token', 'user'],

        data() {
            return {
                e1: 1,
                campaignId: null,
                campaign: {
                    name: '',
                    start: '',
                    end: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    exchange: 1,
                    node: "",
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
                            type: 'daily'
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
                stateReady: false,
            }
        },

        methods: {

            loadCategories() {

                axios.get('/data/categories.json').then(response => {
                    this.categoriesList = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaign(id) {

                // Details
                axios.get(this.$root.uri + '/campaigns/' + id, this.$root.config).then(response => {
                    this.campaign = response.data.data;

                    this.fetchCampaignCategories(id);
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaignCategories(id) {
                // Categories
                axios.get(this.$root.uri + '/campaigns/' + id + '/cat', this.$root.config).then(response => {
                    this.campaign.cat = response.data;
                    this.categories = this.campaign.cat.data;

                    this.fetchCampaignUser(id);
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaignUser(id) {

                axios.get(this.$root.uri + '/campaigns/' + id + '/user', this.$root.config).then(response => {
                    this.campaign.user = response.data;

                    this.fetchCampaignBudget(id);
                }, error => {
                    console.log(error);
                });
            },

            fetchCampaignBudget(id) {

                axios.get(this.$root.uri + '/campaigns/' + id + '/budget', this.$root.config).then(response => {
                    this.campaign.budget = response.data;

                }, error => {
                    console.log(error);
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
