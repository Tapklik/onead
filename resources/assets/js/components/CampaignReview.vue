<template>
    <v-container>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <h4>CAMPAIGN DETAILS</h4>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Name:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{campaign.name}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Campaign Flight:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> From: {{campaign.start_time}} to: {{campaign.end_time}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Advertiser Domain:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{campaign.adomain}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Click-through URL:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{campaign.ctrurl}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Budget Type:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{campaign.budget.data.type}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Budget:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{$root.fromMicroDollars(campaign.budget.data.amount)}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Target Bid:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> {{$root.fromMicroDollars(campaign.bid)}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Daily Budget Pacing:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p></p>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <h4>CAMPAIGN CATEGORIES</h4>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Chosen Categories: </span>
                    </v-flex>                    
                    <v-flex xs12 md8>
                        <span v-for="category in selectedCategories">{{category}}<br> </span><br>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <h4>CAMPAIGN CREATIVES</h4>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Chosen Creatives: </span>
                    </v-flex>                    
                    <v-flex xs12 md8>
                        <span v-for="creative in campaign.creatives.data" :key="creative.id">{{creative.name}}<br> </span>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <h4>CAMPAIGN TARGETING</h4>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Chosen Devices:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p v-for="device in selectedDevices"> {{device}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Chosen Operating Systems:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p v-for="os in selectedOs">{{os}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Chosen Browsers:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p v-for="ua in selectedUa"> {{ua}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Target Audience: </span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p> From {{campaign.user.data.age.min}} to {{campaign.user.data.age.max}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Selected Geo:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p v-for="geo in campaign.geo.data" :key="geo.id"> {{geo.key}}</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md4>
                        <span>Gender:</span>
                    </v-flex>
                    <v-flex xs12 md8>
                        <p v-for="gender in campaign.user.data.gender"> {{gender}}</p>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-btn v-show="!$root.editMode" large primary @click="createCampaign()">Start Campaign</v-btn>
        <v-btn v-show="$root.editMode" large primary @click="updateCampaign()">update {{campaign.name}}</v-btn>
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

        props: ['campaign', 'folder', 'gender','token','user','selectedUa','selectedOs','selectedDevices','selectedCategories'],

        data() {

            return {
                alert: false,
                success: false,
                error: false,
                alertMessage: '',
                ajax: false,
                batch: []
            }
        },

        filters: {
            lowercase(input) {

                return input.toLowerCase();
            }
        },

        methods: {
            createCampaign () {
                this.batch.push(0);
                this.ajax = true;

                axios.post(this.$root.uri + '/campaigns', this.collectCampaign(), this.$root.config).then(response => {
                    this.campaign.id = response.data.data.id;


                    this.updateCampaignCategories();
                    this.updateCampaignUser();
                    this.updateCampaignGeography();
                    this.updateCampaignDevice();
                    this.updateCampaignBudget();
                    this.updateCampaignCreatives();
                    
                    this.alert = true;
                    this.success = true;
                    this.error = false;
                    this.alertMessage = 'Successfully created a new campaign';
                    
                    setTimeout(function() {
                      window.location = "/admin/campaigns";
                    }, 3000);
                
                }, error => {
                    this.alert = true;
                    this.success = false;
                    this.error = true;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaign () {
                this.ajax = true;

                this.updateCampaignDetails();
                this.updateCampaignCategories();
                this.updateCampaignUser();
                this.updateCampaignGeography();
                this.updateCampaignDevice();
                this.updateCampaignBudget();
                this.updateCampaignCreatives();

                setTimeout(function() {
                  window.location = "/admin/campaigns";
                }, 3000);
                
            },

            updateCampaignDetails(){
                this.batch.push(0);

                var payload = this.collectCampaign();

                axios.put(this.$root.uri + '/campaigns/' + this.campaign.id, payload, this.$root.config).then(response => {
                    this.batch.push(0);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignCategories(){

                var payload = this.collectCategories();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/cat', payload, this.$root.config).then(response => {
                    this.batch.push(1);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignUser(){
                var payload = this.collectUser();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/users', payload, this.$root.config).then(response => {
                    this.batch.push(2);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignGeography(){

                var payload = this.collectGeography();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/geo', {geo: payload}, this.$root.config).then(response => {
                    this.batch.push(3);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignDevice(){

                var payload = this.collectDevices();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/type', {types: payload.types}, this.$root.config).then(response => {
                    this.batch.push(4);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/model', {models: payload.models}, this.$root.config).then(response => {
                    this.batch.push(5);

                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/os', {os: payload.os}, this.$root.config).then(response => {
                    this.batch.push(6);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignBudget()
            {
                var payload = this.collectBudget();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/budget', payload, this.$root.config).then(response => {
                    this.batch.push(7);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateCampaignCreatives() {

                var payload = this.collectCreatives();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/creatives', {creatives: payload}, this.$root.config).then(response => {
                    this.batch.push(8);
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            collectCampaign() {
                return {
                    name: this.campaign.name,
                    description: '',
                    start: this.campaign.start_time,
                    end: this.campaign.end_time,
                    bid: this.campaign.bid,
                    ctrurl: this.campaign.ctrurl,
                    adomain: this.campaign.adomain,
                    test: this.campaign.test,
                    status: this.campaign.status,
                    weight: this.campaign.weight,
                    node: this.campaign.node,
                    account_id: 1
                };
            },

            collectCategories() {
                return this.campaign.cat.data;
            },

            collectUser() {
                return this.campaign.user.data;
            },

            collectGeography() {
                return this.campaign.geo.data.map(function (geo) {
                    return geo.id;
                });
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

                var ids = [];

                for(var i in this.campaign.creatives.data)
                {
                    ids.push(this.campaign.creatives.data[i].id);
                }

                return ids;
            },
        },

        watch: {
            batch(value) {

                if (value.length == 7) {
                    this.error = false;
                    this.alert = true;
                    this.success = true;
                    this.alertMessage = 'Successfully updated campaign';
                    
                    this.ajax = false;
                    this.batch = [];
                }
            }
        },

        computed: {

            progress() {
                var items = 8;
                var percentage = 100 / items;

                var progress = Math.round(this.batch.length * percentage);

                return progress + ' %';
            }
        }
    }
</script>
