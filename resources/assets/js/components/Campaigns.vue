<template>

    <v-container fluid grid-list-md>
        <v-layout>
            <v-flex xs12>
        <v-card>
            <v-toolbar class="elevation-0 grey lighten-3">
                <v-btn primary dark class="elevation-0" :href="createCampaignRouter">
                    <v-icon>add</v-icon> Add campaign
                </v-btn> 
            </v-toolbar>
            <v-card-title>
                <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search">
                </v-text-field>
            </v-card-title>
            <v-data-table v-bind:items="campaigns" v-bind:search="search">

                                        <template slot="headers" scope="props">
                                            &nbsp;
                                        </template>
                <template slot="items" scope="props">
                    <td>
                        <span class="title">{{ props.item.name }}</span> <br>
                        <span class="caption">{{props.item.id}}</span>
                    </td>
                    <td>
                    <v-chip v-if="props.item.status == 'active'" small class="green white--text">
                        <small>APPROVED</small>
                    </v-chip>
                    <v-chip v-else-if="props.item.status == 'archived'" small class="yellow darken-2 white--text">
                        <small>PENDING</small>
                    </v-chip>   
                    <v-chip v-else small class="red white--text">
                       <small>DECLINED</small>
                   </v-chip>
                   </td>
                   <td class="text-xs-center">
                        <span class="title"> {{  $root.fromMicroDollars(props.item.budget.data.amount) }} </span><br>
                        <span class="caption"> {{ props.item.budget.data.type  | uppercase }}</span>
                    </td>
                   <td class="text-xs-center">{{ props.item.start_time }} <br>to<br>{{ props.item.end_time }}</td>
                   <td class="text-xs-center">

                    <v-btn icon class="grey--text">
                        <v-icon>play_circle_outline</v-icon>
                    </v-btn>
                    <v-btn icon class="grey--text">
                        <v-icon>delete</v-icon>
                    </v-btn>
                    <v-btn icon class="grey--text">
                        <v-icon>edit</v-icon>
                    </v-btn>
                </td>
            </template>
            <template slot="pageText" scope="{ pageStart, pageStop }">
                From {{ pageStart }} to {{ pageStop }}
            </template>
        </v-data-table>
    </v-card>
    </v-flex>
    </v-layout>
</v-container>
</template>

<script>
    export default {
        mounted() {
            console.log('Campaigns mounted.');
        },

        props: ['token'],

        data() {
            return {
                campaigns: [],
                max25chars: (v) => v.length <= 25 || 'Input too long!',
                tmp: '',
                search: '',
                pagination: {},
                createCampaignRouter: "/admin/campaigns/create"
                
            }
        },

        methods: {

            fetchCampaigns() {

                axios.get(this.$root.uri + '/campaigns', {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                }).then(response => {
                    this.campaigns = response.data.data;
                }, error => {
                    swal('Error', error, 'error');
                })
            },

            deleteCampaign(campaignId) {

                alert('This will delete campaign. But not yet. If you want to delete it send DELETE request to api @ api.tapklik.com/v1/campaigns/' + campaignId + ' endpoint');
                return false;
            },

            getCampaignProgress(campaign) {
                var start = new Date(campaign.start_time);
                var end   = new Date(campaign.end_time);
                var d     = new Date();
                var timeDiff = Math.abs(end.getTime() - start.getTime());
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                var timeDiffFromNow = end.getTime() - d.getTime();
                var diffDaysFromNow =  Math.ceil(timeDiffFromNow / (1000 * 3600 * 24));

                // Has end passed
                var hasPassed  =  ((end.getTime() - d.getTime()) < 0) ? true : false;
                var hasStarted = ((start.getTime() - d.getTime()) <= 0) ? true : false;

                // Now we know how many days between dates
                // Calculate percentages
                var percent  = diffDays * 0.1;
                var progress = (hasStarted && !hasPassed) ? diffDaysFromNow * percent : 0;
                if(hasPassed) progress = 100;

                progress = '0';

                return progress;
            },

            isRunning(campaign) {

                var start = new Date(campaign.start_time);
                var end   = new Date(campaign.end_time);
                var d     = new Date();

                var hasPassed  =  ((end.getTime() - d.getTime()) < 0) ? true : false;
                var hasStarted = ((start.getTime() - d.getTime()) <= 0) ? true : false;

                return hasStarted && !hasPassed;
            },
        },

        computed: {
            filteredCampaigns() {

                if(!this.campaigns) return this.campaigns;

                var obj = this;

                return this.campaigns.filter(function (campaign) {
                    return campaign.name.toLowerCase().indexOf(obj.$root.search.toLowerCase())>=0;
                });
            }
        },

        filters: {
            uppercase: function(v) {
              return v.toUpperCase();
            }
        },

        watch: {
            token(value) {
                this.fetchCampaigns();
            }
        }
    }
</script>
