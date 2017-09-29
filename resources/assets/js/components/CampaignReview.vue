<template>
    <v-container fluid grid-list-xs>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs2 md12>
                <v-layout row wrap>
                    <v-flex xs2 class="valign-wrapper mb-1">
                        <h5>CAMPAIGN DETAILS</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs2 md4>
                        <p>Name: <b>{{campaign.name}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Campaign Flight: <b> From: {{campaign.start_time}} to: {{campaign.end_time}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Advertiser Domain: <b> {{campaign.adomain}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Click-through URL: <b> {{campaign.ctrurl}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Budget Type: <b> {{campaign.budget.data.type}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Budget: <b>${{$root.fromMicroDollars(campaign.budget.data.amount)}}</b></p>
                    </v-flex>
                    <v-flex xs2 md4>
                        <p>Target Bid: $<b> {{$root.fromMicroDollars(campaign.bid)}}</b></p>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider></v-divider>
        <v-layout row wrap>
            <v-flex xs12 md12>
                <v-layout row wrap>
                    <v-flex xs2 class="valign-wrapper mt-4 mb-1">
                        <h5>CAMPAIGN CATEGORIES</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>                    
                    <v-flex xs12 md12>
                        <v-icon v-for="category in selectedCategories" :key="category.code" large>{{category.img}}</v-icon>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider></v-divider>
        <v-layout row wrap>
            <v-flex xs2 md12>
                <v-layout row wrap>
                    <v-flex xs2 class="valign-wrapper mt-4 mb-1">
                        <h5>CAMPAIGN CREATIVES</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap v-for="c in campaign.creatives.data" :key="c.id">  
                    <v-flex xs2 md4>
                        <span class="title">{{ c.name }}</span><br>
                        <span class="caption">{{ c.id }}</span>
                    </v-flex>
                    <v-flex xs2 md4>
                        {{ c.class | uppercase }}
                    </v-flex>
                    <v-flex xs2 md4>
                        {{ c.w }} x {{ c.h }}
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider></v-divider>
        <v-layout row wrap>
            <v-flex xs2 md12>
                <v-layout row wrap>
                    <v-flex xs2 class="valign-wrapper mt-4 mb-1">
                        <h5>CAMPAIGN TARGETTING</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                        <v-flex xs2 md4>
                            <p>Devices: 
                            <v-icon :key="device.device_id" v-for="device in selectedDevices" large>{{device.icon}}</v-icon></p>
                        </v-flex>
                        <v-flex xs2 md4>
                            <p>Operating Systems: 
                            <v-icon v-for="device in selectedOs" :key="device.type" large>{{device.icon}}</v-icon></p>
                        </v-flex>
                        <v-flex xs2 md4>
                            <p>Browsers: 
                            <v-icon v-for="device in selectedUa" :key="device.type" large>{{device.icon}}</v-icon></p>
                        </v-flex>
                        <v-flex xs2 md4>
                            <p>Target Audience: <b> From {{campaign.user.data.age.min}} to {{campaign.user.data.age.max}}</b></p>
                        </v-flex>
                        <v-flex xs2 md4>
                            <p>Selected Geo: <b v-for="g in campaign.geo.data" :key="g.id">{{g.key}}, </b></p>
                        </v-flex>
                        <v-flex xs12 md4>
                            <p>Gender: <b v-for="gender in campaign.user.data.gender"> {{gender}}</b> </p>
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

        filters: {
            uppercase: function(v) {
                return v.toUpperCase();
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
