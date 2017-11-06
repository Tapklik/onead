<template>
    <v-container fluid grid-list-xs>
        <popup></popup>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-2">    
                    <v-divider></v-divider>
                    <v-card-title dark class="">
                        <v-flex xs12 md6>
                            <v-btn primary dark class="elevation-0" :href="createCampaignRouter">
                                <v-icon>add</v-icon> Add campaign
                            </v-btn> 
                        </v-flex>
                        <v-flex xs12 md6>
                            <v-layout row wrap justify-space-between>
                                    <v-flex xs8 md4 class="text-lg-right">
                                        <v-chip @input="removeChip('selectedStatuses')" close v-show="selectedStatuses != ''">
                                            <b>Statuses: &nbsp;</b>
                                            {{chipContent(selectedStatuses, 10)}}
                                        </v-chip>
                                    </v-flex>
                                    <v-flex xs4 md2>
                                        <v-menu offset-y :close-on-content-click='false'>
                                            <v-btn white flat slot="activator">
                                                <v-icon>filter_list</v-icon> Status 
                                                <v-icon>arrow_drop_down</v-icon>
                                            </v-btn>
                                            <v-list style="max-height: 200px">
                                                <v-list-tile v-for="status in statuses" :key="status.status">
                                                    <v-list-tile-action>
                                                        <v-checkbox :value="status.status" v-model="selectedStatuses"></v-checkbox>
                                                    </v-list-tile-action>
                                                    <v-list-tile-title>{{ status.status }}</v-list-tile-title>
                                                </v-list-tile>
                                            </v-list>
                                        </v-menu>
                                    </v-flex>
                                    <v-flex xs12 md5 lg5>
                                        <v-text-field 
                                            label="Search" 
                                            single-line 
                                            hide-details 
                                            class="right"
                                            v-model="search">
                                        </v-text-field>
                                    </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text v-if="campaignsLoader == true">
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-layout row wrap>
                            <v-flex xs12>   
                                <v-alert dismissible v-bind:success='this.$root.alert.success' v-bind:error='this.$root.alert.error' v-model="this.$root.alert.alert" transition="scale-transition">{{this.$root.alert.alertMessage}}</v-alert>
                                <v-data-table
                                :pagination.sync="pagination"
                                v-bind:items="filteredCampaigns"
                                no-data-text=""
                                v-bind:rows-per-page-items="[10, 25, { value: -1 }]"
                                class="no-headers"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <td>
                                            <span class="title">{{ props.item.id.name }}</span> <br>
                                            <span class="caption">{{props.item.id.id}}</span>
                                        </td>
                                        <td>
                                            <v-chip v-for="s in statuses" :key="s.status" v-if="props.item.id.status == s.status" small :class="s.color">
                                                <small>{{s.status  | uppercase}}</small>
                                            </v-chip>
                                        </td>
                                        <td class="text-xs-right">
                                            <span class="title"> $ {{$root.fromMicroDollars(props.item.id.budget.data.amount) }}</span><br>
                                            <span class="caption"> {{ props.item.id.budget.data.type  | uppercase }}</span>
                                        </td>
                                        <td class="text-xs-right">
                                            <span class="caption">FROM</span>&nbsp; <span class="title">{{ props.item.id.start_time }}</span><br>
                                            <span class="caption">TO</span>&nbsp; <span class="title">{{ props.item.id.end_time }}</span>
                                        </td>
                                         <td class="text-xs-center">
                                            <v-btn :loading="props.item.loading" icon class="grey--text" v-if="props.item.id.status == 'active'" @click="props.item.loading= true, toggleCampaignStatus(props.index, props.item.id.id, props.item.id.status)">
                                                <v-icon>pause_circle_outline</v-icon>
                                            </v-btn>
                                            <v-btn :loading="props.item.loading" icon class="grey--text" v-else  @click="props.item.loading= true, toggleCampaignStatus(props.index, props.item.id.id, props.item.id.status)">
                                                <v-icon>play_circle_outline</v-icon>
                                            </v-btn>
                                            <v-btn icon class="grey--text" @click="deleteCampaign(props.item.id.id, props.item.id.status)">
                                                <v-icon>delete</v-icon>
                                            </v-btn>
                                            <v-btn icon class="grey--text" :href="editCampaignRouter + props.item.id.id">
                                                <v-icon>edit</v-icon>
                                            </v-btn>
                                        </td>
                                    </template>
                                    <template slot="pageText" scope="{ pageStart, pageStop }">
                                        From {{ pageStart }} to {{ pageStop }}
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
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
            this.$root.isLoading = false;

            if(typeof data !== 'undefined') {
                this.$root.showAlertPopUp('success', data.message);
            }
        },

        props: ['token'],

        data() {
            return {
                loadingPress: false,
                campaigns: [],
                max25chars: (v) => v.length <= 25 || 'Input too long!',
                tmp: '',
                search: '',
                pagination: {},
                createCampaignRouter: "/admin/campaigns/create",
                editCampaignRouter: "/admin/campaigns/edit/",
                statusFilter: ['active', 'archived', 'draft','declined', 'paused'],
                statuses: [],
                selectedStatuses: [],
                statusColors: {active: 'green lighten-1 white--text', paused: 'yellow darken-1 white--text', archived: 'grey lighten-1 white--text', declined: 'red lighten-1 white--text', deleted: 'red darken-1 white--text', draft: 'grey lighten-2 white--text'},
                campaignsLoader: true
            }
        },

        methods: {
            
            removeChip(data) {
                this[data] = [];
            },

            chipContent(selection, characters) {
                var selection = selection;
                var show = '';
                var characterCount = 0;
                var plusMany = 0;
                for(var s in selection) {
                    if(characterCount + selection[s].length > characters) {
                        plusMany = plusMany + 1;
                    }
                    else {
                        show = show + selection[s] + ', '
                        characterCount = characterCount + selection[s].length;
                    }
                }
                show = show.slice(0,-2);
                if(plusMany != 0) {
                    show = show + ' and ' + plusMany + ' more';
                }
                console.log(show);
                return show;
            },

            populateStatuses() {
                var statuses = [];
                var a = 0;
                var campaigns = this.campaigns;
                var colors = this.statusColors;
                for(var c in campaigns) {
                    for(var s in statuses) {
                        if(statuses[s].status == campaigns[c].id.status) a++;
                    }
                   
                    if(a == 0) {
                        var b = campaigns[c].id.status;
                        statuses.push({status: b, color: colors[b]});
                        a = 0;
                    }
                    else {
                        a = 0
                    }    
                }
                this.statuses = statuses;
            },

            toggleCampaignStatus(index, id, status) {
                if(status == 'active' || status == 'paused') {
                    var changeStatusTo = (status == 'active') ? 'paused' : 'active';

                    axios.put(this.$root.uri + '/campaigns/' + id, {status: changeStatusTo}, this.$root.config).then(response => {
                        this.fetchCampaigns();
                    }, error => {
                        this.fetchCampaigns();
                    });
                }
                else {
                    this.fetchCampaigns();
                }
            },

            fetchCampaigns() {
                var a = [];
                axios.get(this.$root.uri + '/campaigns', this.$root.config).then(response => {
                    var campaigns = response.data.data;
                    for(var c in campaigns) {
                        a.push({id: campaigns[c], loading: false})
                    }
                    this.campaigns = a;
                    this.campaignsLoader = false;
                }, error => {
                    this.campaignsLoader = false;
                    this.$root.showAlertPopUp('error', 'Error fetching folders.');
                })
            },

            deleteCampaign(campaignId, status) {
                if(status != 'draft'){
                    axios.put(this.$root.uri + '/campaigns/' + campaignId, {status: 'deleted'}, this.$root.config).then(response => {
                        this.fetchCampaigns();
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }).bind(this);
    
                    return false;
                }
                else {
                    axios.delete(this.$root.uri + '/campaigns/' + campaignId, this.$root.config).then(
                        response => {
                            this.fetchCampaigns();
                    }, error => {  
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    });
            
                    return false;
                }
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

                var campaigns = this.campaigns;
                var statuses = this.selectedStatuses;
                var result = [];
                var search = this.search;
                if(statuses == '') {
                    for(var c in campaigns) {
                        var name = campaigns[c].id.name.toLowerCase();
                        var searchLower = search.toLowerCase();
                        if(campaigns[c].id.status != 'archived' && name.includes(searchLower)) {
                            result.push(campaigns[c]);
                        }
                    }
                    return result;
                }

                else {
                    for(var c in campaigns) {
                        for(var s in statuses) {
                            var name = campaigns[c].id.name.toLowerCase();
                            var searchLower = search.toLowerCase();
                            if(campaigns[c].id.status == statuses[s] && name.includes(searchLower)) {
                                result.push(campaigns[c]);
                            }
                        }   
                    }
                    return result;
                }
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
        },
        campaigns(value) {
            this.populateStatuses();
        },
        selectedStatuses(value) {
            this.pagination.page = 1;
        }
    }
}
</script>
