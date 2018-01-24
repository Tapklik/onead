<template>
    <v-container grid-list-xs>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>REVIEW</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap class="mt-4">
            <v-flex xs12 class="valign-wrapper">
                <span class="subheading">CAMPAIGN BASIC DETAILS</span>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Campaign Name</span>
                    </v-flex>
                    <v-flex xs8 md5 v-if="valid.name">
                        <v-icon>mode_edit</v-icon>
                        <span>{{campaign.name}}</span>
                    </v-flex>
                    <v-flex xs8 md5 v-else>
                        <v-icon class="red--text">mode_edit</v-icon>
                        <span class="red--text">Type a valid campaign name</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Campaign Flight</span>
                    </v-flex>
                    <v-flex 
                    xs8 
                    md5 
                    v-if="valid.start && valid.end"
                    >
                        <v-icon>flight_takeoff</v-icon>
                        <span>From {{campaign.start_time}} to {{campaign.end_time}}</span>
                    </v-flex>
                    <v-flex xs8 md5 v-else>
                        <v-icon class="red--text">flight_takeoff</v-icon>
                        <span class="red--text">Please enter valid dates</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Advertiser Domain</span>
                    </v-flex>
                    <v-flex xs12 md8 v-if="valid.domain">
                        <v-icon>language</v-icon>
                        <span>{{campaign.adomain}}</span>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <v-icon class="red--text">language</v-icon>
                        <span class="red--text">Type a valid advertiser domain</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Click-through URL</span>
                    </v-flex>
                    <v-flex xs12 md8 v-if="valid.url">
                        <v-icon>language</v-icon>
                        <span>{{campaign.ctrurl}}</span>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <v-icon class="red--text">language</v-icon>
                        <span class="red--text">Type a valid click-through url</span>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Budget Type</span>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>monetization_on</v-icon>
                        <span>{{campaign.budget.data.type}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Budget</span>
                    </v-flex>
                    <v-flex xs8 md5 v-if="valid.budget">
                        <v-icon>attach_money</v-icon>
                        <span>{{$currency.fromMicroDollars(campaign.budget.data.amount)}}</span>
                    </v-flex>
                    <v-flex xs8 md5 v-else>
                        <v-icon class="red--text">attach_money</v-icon>
                        <span class="red--text">Type a valid budget</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Target Bid</span>
                    </v-flex>
                    <v-flex xs12 md8 v-if="valid.bid == true">
                        <v-icon>attach_money</v-icon>
                        <span>{{$currency.fromMicroDollars(campaign.bid)}}</span>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <v-icon class="red--text">attach_money</v-icon>
                        <span class="red--text">Type a valid bid</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="caption">Budget Pacing</span>
                    </v-flex>
                    <v-flex xs12 md8 v-if="valid.pacing">
                        <i>* view in campaign details</i>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <span class="red--text">Select a valid budget pace</span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-2">
            <v-flex xs4 class="valign-wrapper mt-4">
                <span class="subheading">CAMPAIGN CATEGORIES</span>
            </v-flex>
        </v-layout>
        <v-layout row wrap>                    
            <v-flex xs12 v-if="valid.categories">
                <v-btn icon v-for="category in selectedCategories" :key="category.code">
                    <v-icon>{{category.img}}</v-icon>
                </v-btn>
            </v-flex>
            <v-flex xs12 v-else>
                <v-btn icon>
                    <v-icon class="red--text">help</v-icon>
                </v-btn>
                <span class="red--text">Choose categories</span>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-2">
            <v-flex xs12 class="valign-wrapper mt-4">
                <span class="subheading">CAMPAIGN CREATIVES</span>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 v-if="valid.creatives">
                <v-layout row wrap class="mt-4">
                    <v-flex xs12>
                        <v-list two-line>
                            <span class="caption">Selected Creatives</span>
                            <v-list-tile avatar v-for="c in campaign.creatives.data" :key="c.id">
                                <v-list-tile-avatar>
                                    <img v-bind:src="c.thumb"/>
                                </v-list-tile-avatar>
                                <v-list-tile-content>                                    
                                    <v-list-tile-title>{{c.name}}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{c.id}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 v-else>
                <v-btn icon>
                    <v-icon class="red--text">help</v-icon>
                </v-btn>
                <span  class="red--text">Choose creatives</span>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-2">
            <v-flex xs12 class="valign-wrapper mt-4">
                <span class="subheading">CAMPAIGN TARGETING</span>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md4>
                <v-layout row wrap class="mt-4">
                    <v-flex xs4 class="valign-wrapper">
                        <span class="caption">Devices</span>
                    </v-flex>
                    <v-flex xs8 v-if="valid.devices">
                        <v-btn icon :key="device.device_id" v-for="device in selectedDevices">
                            <v-icon>{{device.icon}}</v-icon>
                        </v-btn>
                    </v-flex>
                    <v-flex xs8 v-else>
                        <span class="red--text">Select a device type</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs4 class="valign-wrapper">
                        <span class="caption">Operating Systems</span>
                    </v-flex>
                    <v-flex xs8>
                        <v-btn icon :key="os.type" v-for="os in selectedOs">
                            <v-icon>{{os.icon}}</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs4 class="valign-wrapper">
                        <span class="caption">Browsers</span>
                    </v-flex>
                    <v-flex xs8>
                        <v-btn icon :key="ua.type" v-for="ua in selectedUa">
                            <v-icon>{{ua.icon}}</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md4>
                <v-layout row wrap class="mt-4">
                    <v-flex xs4 class="valign-wrapper">
                        <span class="caption">Audience Gender</span>
                    </v-flex>
                    <v-flex xs8>
                        <v-btn icon :key="gender" v-for="gender in campaign.user.data.gender">
                            <v-icon>{{genderIcon(gender)}}</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs4 class="valign-wrapper">
                        <span class="caption">Audience Age Group</span>
                    </v-flex>
                    <v-flex xs8>
                        <v-icon>person</v-icon>
                        <span>From {{campaign.user.data.age.min}} to {{campaign.user.data.age.max}}</span>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md4>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 v-if="valid.geo">
                        <v-list two-line>
                            <span class="caption">Geo Location</span>
                            <v-list-tile avatar v-for="g in campaign.geo.data" :key="g.id">
                                <v-list-tile-content>
                                    <v-list-tile-title>{{g.key}}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{g.comment}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-flex>
                    <v-flex xs12 v-else>
                        <span class="caption">Geo Location</span><br>
                        <span class="red--text">Select a Location</span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-4 mb-b"> 
            <v-flex xs12 class="text-xs-center">
                <v-btn v-show="!$root.editMode" 
                primary large
                :disabled="!validCampaign()"
                @click="loading = true, createCampaign()"
                :loading="loading"
                ><v-icon left class="white--text">cloud_upload</v-icon>Start Campaign
                </v-btn>
                <v-btn v-show="$root.editMode" 
                primary large 
                :disabled="!validCampaign()"
                @click="loading = true, updateCampaign()"
                :loading="loading"
                ><v-icon left class="white--text">cloud_upload</v-icon>Update {{campaign.name}}
                </v-btn>
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
            this.loadTechnologies();
            this.loadCategories();
            this.$root.isLoading = false;
        },

        props: [
            'campaign',
            'token',
            'valid'
        ],

        data() {
            return {
                batch: [],
                checkCounter: 0,
                loading: false,
                errorCounter: 0,
                folders: [],
                categoriesList: [],
                technologiesList: []
            }
        },

        methods: {
            loadCategories() {
                axios.get('/data/categories.json').then(response => {
                    this.categoriesList = response.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                });
            },

            loadTechnologies() {

                axios.get('/data/technologies.json').then(response => {
                    this.technologiesList = response.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                });
            },

            getFolders() {
                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {
                    this.folders = response.data.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                });
            },

            campaignError() {
                window.location = '/admin/campaigns?m=' + this.$root.alertpopup.alertMessage;
            },

            validCampaign() {
                var keys = Object.keys(this.valid);
                return keys.every(key => this.valid[key] == true);
            },

            createCampaign () {
                this.batch.push(0);
                axios.put(
                    this.$root.uri + '/campaigns/' + this.campaign.id, 
                    { status: 'not started' }, 
                    this.$root.config
                ).then(response => {
                        this.$root.alertpopup.alertMessage = 'Successfully created a new campaign.';
                        window.location = '/admin/campaigns?m=' + this.$root.alertpopup.alertMessage;
                    }, error => {
                        this.loading = false;
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            updateMessage() {
                this.$root.alertpopup.alertMessage = 'Successfully created a new campaign.';
                window.location = '/admin/campaigns?m=' + this.$root.alertpopup.alertMessage;
            },

            updateCampaign () {
                this.updateCampaignDetails();
                this.updateCampaignCategories();
                this.updateCampaignUser();
                this.updateCampaignGeography();
                this.updateCampaignDevice();
                this.updateCampaignBudget();
                this.updateCampaignCreatives();
            },

            updateCampaignDetails(){
                this.batch.push(0);

                var payload = this.collectCampaign();

                axios.put(this.$root.uri + '/campaigns/' + this.campaign.id, payload, this.$root.config).then(response => {
                    this.batch.push(0);
                    this.checkCounter = this.checkCounter + 1;

                }, error => {

                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignCategories(){

                var payload = this.collectCategories();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/cat', payload, this.$root.config).then(response => {
                    this.batch.push(1);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.loading = false;
                    this.errorCounter = this.errorCounter + 1;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignUser(){
                var payload = this.collectUser();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/users', payload, this.$root.config).then(response => {
                    this.batch.push(2);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignGeography(){

                var payload = this.collectGeography();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/geo', {geo: payload}, this.$root.config).then(response => {
                    this.batch.push(3);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignDevice(){
                var payload = this.collectDevices();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/type', {types: payload.types}, this.$root.config).then(response => {
                    this.batch.push(4);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/model', {models: payload.models}, this.$root.config).then(response => {
                    this.batch.push(5);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/os', {os: payload.os}, this.$root.config).then(response => {
                    this.batch.push(6);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignBudget() {
                var payload = this.collectBudget();
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/budget', payload, this.$root.config).then(response => {
                    this.batch.push(7);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            updateCampaignCreatives() {
                var payload = this.collectCreatives();
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/creatives', {creatives: payload}, this.$root.config).then(response => {
                    this.batch.push(8);
                    this.checkCounter = this.checkCounter + 1;
                }, error => {
                    this.errorCounter = this.errorCounter + 1;
                    this.loading = false;
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },

            collectCampaign() {
                var status = this.campaign.status == 'draft' ? 'not started' : this.campaign.status;    
                return {
                    name: this.campaign.name,
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: status,
                    weight: this.campaign.weight,
                    node: this.campaign.node
                };
            },

            collectCategories() {
                return this.campaign.cat.data;
            },

            collectUser() {
                return this.campaign.user.data;
            },

            collectGeography() {
                return this.campaign.geo.data.map(geo => geo.id);
            },

            collectDevices() {
                return {
                    types: this.campaign.device.data.type,
                    models: this.campaign.device.data.ua,
                    os: this.campaign.device.data.os,
                };
            },

            collectBudget() {
                return this.campaign.budget.data;
            },

            collectCreatives() {
                return this.campaign.creatives.data.map(creative => creative.id);
            },

            genderIcon(g) {
                return g == 'F' ? 'mdi-human-female' : 'mdi-human-male'
            }
        },

        computed: {
            selectedOs() {
                if(!this.technologiesList.operatingsystems) return;
                var self = this;
                return this.technologiesList.operatingsystems.filter(operatingsystem => 
                    self.campaign.device.data.os.indexOf(operatingsystem.device_id) != -1
                );  
            },

            selectedDevices() {
                if(!this.technologiesList.devices) return;
                var self = this;
                return this.technologiesList.devices.filter(device => 
                    self.campaign.device.data.type.indexOf(device.device_id) != -1
                );
            },

            selectedUa() {
                if(!this.technologiesList.browsers) return;
                var self = this;
                return this.technologiesList.browsers.filter(ua => 
                    self.campaign.device.data.ua.indexOf(ua.device_id) != -1
                );  
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
            token(value) {
                this.getFolders();
            },
            batch(value) {
                if (value.length == 7) {
                    this.batch = [];
                }
            },
            checkCounter(value) {
                if (value == 9) this.updateMessage();
            },

            errorCounter(value) {
                if(value > 0) this.campaignError();
            }
        }
    }
</script>
