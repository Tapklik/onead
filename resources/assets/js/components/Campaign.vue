<template>
    <v-container fluid grid-list-md>
        <v-stepper class="elevation-2" v-model="step">
            <v-divider></v-divider>

            <!-- TABS START -->
            <v-stepper-header class="elevation-0">
                <v-stepper-step  step="1" :complete="step > 1" editable>
                    DETAILS
                    <small class="red--text" v-show="!validDetailsPage() && step > 1">
                        Errors Found
                    </small>
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" :complete="step > 2" editable>
                    CATEGORIES
                    <small class="red--text" v-show="!validCategoriesPage() && step > 2">
                        Select categories
                    </small>
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3" :complete="step > 3" editable>
                    CREATIVES
                    <small class="red--text" v-show="!validCreativesPage() && step > 3">
                        Select creatives
                    </small>
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="4" :complete="step > 4" editable>
                    TARGETING
                    <small class="red--text" v-show="!validTargettingPage() && step > 4">
                        Errors Found
                    </small>
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="5" editable>
                    REVIEW
                </v-stepper-step>
            </v-stepper-header>
            <!-- TABS END -->

            <v-divider></v-divider>

            <!-- COMPONENTS START -->
            <v-stepper-content step="1">
                <campaign-details 
                :campaign="campaign"
                :valid="valid_new_campaign"
                ></campaign-details>
            </v-stepper-content>
            <v-stepper-content step="2">
                <campaign-categories 
                :campaign="campaign"
                :valid="valid_new_campaign"
                ></campaign-categories>
            </v-stepper-content>
            <v-stepper-content step="3">
                <campaign-creatives
                :token="token" 
                :campaign="campaign"
                :valid="valid_new_campaign"
                ></campaign-creatives>
            </v-stepper-content>
            <v-stepper-content step="4">
                <campaign-targeting 
                :campaign="campaign"
                :valid="valid_new_campaign"
                ></campaign-targeting>
            </v-stepper-content>
            <v-stepper-content step="5">
                <campaign-review
                :token="token" 
                :campaign="campaign"
                :valid="valid_new_campaign"
                ></campaign-review>
            </v-stepper-content>
            <!-- COMPONENTS END -->

        </v-stepper>
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

        props: ['token', 'user'],

        data() {
            return {
                //TABS 
                step: 1,

                //VALIDATION
                valid_new_campaign: {
                    name: false,
                    bid: false,
                    budget: false,
                    start: false,
                    end: false,
                    domain: false,
                    url: false,
                    pacing: false,
                    creatives: false,
                    categories: false,
                    geo: false,
                    devices: false,
                },

                //CONTENT
                campaign: {
                    name: '',
                    adomain: '',
                    ctrurl: '',
                    bid: 0,
                    exchange: 1,
                    test: 1,
                    weight: 1,
                    status: 'draft',
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
                }
            }
        },

        methods: {
            //VALIDATION
            validDetailsPage() {
                return (this.valid_new_campaign.name && this.valid_new_campaign.bid && this.valid_new_campaign.budget && this.valid_new_campaign.start && this.valid_new_campaign.end && this.valid_new_campaign.domain && this.valid_new_campaign.url && this.valid_new_campaign.pacing) ? true : false;
            },

            validCreativesPage() {
                return this.valid_new_campaign.creatives ? true : false;
            },

            validCategoriesPage() {
                return this.valid_new_campaign.categories ? true : false;
            },
            
            validTargettingPage() {
                return (this.valid_new_campaign.geo && this.valid_new_campaign.devices) ? true : false;
            },
            
            //CONTENT CREATE NEW
            createNewDraft() {
                axios.post(
                    this.$root.uri + '/campaigns', 
                    this.collectDraft(), 
                    this.$root.config
                ).then(response => {
                        this.campaign.id = response.data.data.id;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            collectDraft() {
                return {
                    name: 'Draft',
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: 'draft',
                    weight: this.campaign.weight,
                    node: this.campaign.node,
                    account_id: 1
                }
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

            //CONTENT EDIT
            fetchCampaign(id) {
                axios.get(
                    this.$root.uri + '/campaigns/' + id, 
                    this.$root.config
                ).then(response => {
                        this.campaign = response.data.data;
                        this.fetchCampaignCategories(id);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            fetchCampaignCategories(id) {
                axios.get(
                    this.$root.uri + '/campaigns/' + id + '/cat', 
                    this.$root.config
                ).then(response => {
                        this.campaign.cat = response.data;
                        this.fetchCampaignUser(id);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },
            
            fetchCampaignUser(id) {
                axios.get(
                    this.$root.uri + '/campaigns/' + id + '/users', 
                    this.$root.config
                ).then(response => {
                        this.campaign.user = response.data;
                        this.fetchCampaignBudget(id);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            fetchCampaignBudget(id) {
                axios.get(
                    this.$root.uri + '/campaigns/' + id + '/budget', 
                    this.$root.config
                ).then(response => {
                        this.campaign.budget = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            }
        },

        watch: {
            token (value) {
                if (this.$root.editMode) {
                    var campaignId = window.location.pathname.replace('/admin/campaigns/edit/', '');
                    this.fetchCampaign(campaignId);
                }
                else this.createNewDraft();
            }
        }

    }
</script>