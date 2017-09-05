<template>
    <div>
        <div class="col-sm-12">
            <legend><i class="fa fa-fw fa-list"></i> Summary</legend>
            <div class="col-sm-12">
                <div class="row summary">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-2">
                                <small class="summary-title"><i class="fa fa-fw fa-list-alt"></i> Campaign Details
                                </small>
                                <div class="summary-content one-line">
                                    <h5>{{ campaign.name }}</h5>
                                    <p class="no-margin"><span class="text-muted">Flight:</span>
                                        <b>{{ campaign.start_time }} - {{ campaign.end_time }}</b></p>
                                    <p class="no-margin"><span class="text-muted">Budget:</span> <b>${{ campaign.bid }}/day</b></p>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <small class="summary-title"><i class="fa fa-fw fa-check-square"></i> Categories</small>
                                <div class="summary-content">
                                    <ul class="summary-boxes iab-summary">
                                        <li v-for="category in $parent.categories">
                                            <i :class="'select-boxes-btn iabicon iabicon-' + category | lowercase"></i>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <small class="summary-title"><i class="fa fa-fw fa-picture-o"></i> Creatives</small>
                                <div class="summary-content one-line">
                                    <div class="summary-creatives">
                                        <div class="summary-creatives-content">
                                            <img src="/img/folder-open.png">
                                            <b>{{ folder.name }}</b>
                                            <ul>
                                                <li v-for="creative in campaign.creatives.data">
                                                    {{ creative.id }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <small class="summary-title"><i class="fa fa-fw fa-globe"></i> Geo</small>
                                <div class="summary-content">
                                    <ul class="summary-boxes geo-summary">
                                        <li v-for="country in this.campaign.geo.data">
                                            <div class="flags">
                                                <flag :iso2="country.country_iso2"></flag>
                                                {{ country.country }}
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <small class="summary-title"><i class="fa fa-fw fa-female"></i> Audience</small>
                                <div class="summary-content one-line">
                                    <p class="no-margin"><span class="text-muted">Gender:</span> <b>{{ gender }}</b></p>
                                    <p class="no-margin"><span class="text-muted">Age Group:</span>
                                        <b>{{ this.campaign.user.data.age.min }} - {{ this.campaign.user.data.age.max
                                            }}</b></p>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <span v-show="!ajax">
                            <div class="row" v-show="!$root.editMode">
                                <div class="col-sm-12">
                                    <p class="text-center">
                                        <button class="btn btn-lg btn-success"
                                                @click="createCampaign()"
                                                onclick="return false;">Start Campaign
                                        </button>
                                    </p>
                                </div>
                            </div>

                            <div class="row" v-show="$root.editMode">
                                <div class="col-sm-12">
                                    <p class="text-center">
                                        <button class="btn btn-lg btn-success"
                                                @click="updateCampaign()"
                                                onclick="return false;">Edit {{ $parent.campaign.name }}
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </span>

                        <span v-show="ajax">
                            <div class="col-sm-12">
                                    <p class="text-center">
                                        <button class="btn btn-lg btn-success" disabled="disabled">
                                            <i class="fa fa-refresh fa-spin"></i>
                                            {{ progress }}
                                        </button>
                                    </p>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Review component mounted.')
        },

        props: ['campaign', 'folder', 'gender'],

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
