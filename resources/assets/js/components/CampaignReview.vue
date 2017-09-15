<template>
    <v-container>
        <table class="table table-sm table-responsive table-striped">
            <template>
                <tr>
                    <td class="title">Name: </td>
                    <td>{{campaign.name}}</td>    
                </tr>
                <tr>
                    <td class="title">Runtime: </td>
                    <td>From {{campaign.start_time}} to {{campaign.end_time}}</td>    
                </tr>
                <tr>
                    <td class="title">Budget: </td>
                    <td>$ {{$root.fromMicroDollars(campaign.budget.data.amount)}}, {{campaign.budget.data.type}}</td>    
                </tr>
                <tr>
                    <td class="title">Bid: </td>
                    <td>$ {{$root.fromMicroDollars(campaign.bid)}}</td>    
                </tr>
                <tr>
                    <td class="title">Gender: </td>
                    <td>{{gender}}</td>    
                </tr>
                <tr>
                    <td class="title">Age Group: </td>
                    <td>From {{campaign.user.data.age.min}} to {{campaign.user.data.age.max}}</td>    
                </tr>
            </template>
        </table>
        <v-btn large primary @click="createCampaign()">Start Campaign</v-btn>
    </v-container>
</template>

<script>
    export default {
        mounted() {
            console.log('Review component mounted.')
        },

        props: ['campaign', 'folder', 'gender','token','user'],

        data() {

            return {
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
                }, error => {
                    console.log(error);
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
                    swal('Error', 'Something went wrong', 'error');
                });
            },

            updateCampaignCategories(){

                var payload = this.collectCategories();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/cat', payload, this.$root.config).then(response => {
                    this.batch.push(1);
                }, error => {
                    swal('Error', 'Something went wrong', 'error');
                });
            },

            updateCampaignUser(){
                var payload = this.collectUser();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/users', payload, this.$root.config).then(response => {
                    this.batch.push(2);
                }, error => {

                    swal('Error', 'Something went wrong', 'error');
                });
            },

            updateCampaignGeography(){

                var payload = this.collectGeography();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/geo', {geo: payload}, this.$root.config).then(response => {
                    this.batch.push(3);
                }, error => {
                    swal('Error', 'Something went wrong', 'error');
                });
            },

            updateCampaignDevice(){

                var payload = this.collectDevices();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/type', {types: payload.types}, this.$root.config).then(response => {
                    this.batch.push(4);
                }, error => {

                    swal('Error', 'Something went wrong', 'error');
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/model', {models: payload.models}, this.$root.config).then(response => {
                    this.batch.push(5);

                }, error => {

                    swal('Error', 'Something went wrong', 'error');
                });
                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/os', {os: payload.os}, this.$root.config).then(response => {
                    this.batch.push(6);
                }, error => {

                    swal('Error', 'Something went wrong', 'error');
                });
            },

            updateCampaignBudget()
            {
                var payload = this.collectBudget();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/budget', payload, this.$root.config).then(response => {
                    this.batch.push(7);
                }, error => {

                });
            },

            updateCampaignCreatives() {

                var payload = this.collectCreatives();

                axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/creatives', {creatives: payload}, this.$root.config).then(response => {
                    this.batch.push(8);
                }, error => {

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
                    swal('Success', 'Campaign has been updated', 'success');
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
