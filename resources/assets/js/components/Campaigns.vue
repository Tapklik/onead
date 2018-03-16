<template>
    <v-container fluid grid-list-xs>

        <!-- CARD START -->
        <v-card class="elevation-2">    
            <v-divider></v-divider>

            <!-- ACTIONS START -->
            <v-card-title dark>
                <v-flex xs12 md6>
                    <v-btn 
                    primary 
                    dark 
                    class="elevation-0" 
                    href="/admin/campaigns/create"
                    >
                        <v-icon>add</v-icon> Add campaign
                    </v-btn> 
                    <v-menu 
                    offset-y 
                    :close-on-content-click='false'
                    >
                        <v-btn 
                        white 
                        flat 
                        slot="activator"
                        >
                            <v-icon>filter_list</v-icon> 
                            Status 
                            <v-icon>arrow_drop_down</v-icon>
                        </v-btn>
                        <v-list style="max-height: 200px">
                            <v-list-tile 
                            v-for="(value, key) in statuses" 
                            :key="key"
                            >
                                <v-list-tile-action>
                                    <v-checkbox 
                                    :value="key.replace('_', ' ')" 
                                    v-model="selected_statuses"
                                    ></v-checkbox>
                                </v-list-tile-action>
                                <v-list-tile-title>{{ key | capitalize }}</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                    <v-chip 
                    @input="removeTextFromChip('selected_statuses')" 
                    close 
                    v-show="selected_statuses != ''"
                    >
                        <b>Statuses: &nbsp;</b>
                        {{ addTextToChip(selected_statuses, 2) | capitalize }}
                    </v-chip>
                </v-flex>
                <v-flex xs12 md6>
                    <v-layout row wrap>
                        <v-spacer></v-spacer>
                        <v-flex xs12 md5 lg5>
                            <v-text-field 
                            single-line 
                            hide-details 
                            class="right"
                            label="Search..."
                            append-icon="search"
                            v-model="search_campaigns">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-card-title>
            <!-- ACTIONS END -->

            <v-divider></v-divider>

            <!-- CAMPAIGNS START -->
            <!-- TABLE LOADER START -->
            <scale-loader 
            v-if="campaigns_table_loading"
            :loading="true" 
            color="#9e9e9e" 
            height="15px" 
            width="3px" 
            class="mt-5"
            ></scale-loader>
            <!-- TABLE LOADER END -->

            <v-data-table
            v-else
            :pagination.sync="pagination"
            v-bind:items="filtered_campaigns"
            v-bind:rows-per-page-items="[10, 25, { value: -1 }]"
            class="no-headers"
            >
                <template slot="headers" slot-scope="props">
                    &nbsp;
                </template>
                <template slot="items" slot-scope="props">
                    <td>
                        <span class="title">
                            {{ props.item.name }}
                        </span> 
                        <br />
                        <span class="caption">
                            {{props.item.id}}
                        </span>
                    </td>
                    <td>
                        <v-chip 
                        v-for="(value, key) in statuses" 
                        :key="key" 
                        v-if="props.item.status == key.replace('_', ' ')" 
                        small 
                        :class="value"
                        >
                            <small> {{ key | uppercase }} </small>
                        </v-chip>
                    </td>
                    <td class="text-xs-right">
                        <span class="title"> 
                        $ {{$currency.fromMicroDollars(props.item.budget.data.amount) }}
                        </span>
                        <br />
                        <span class="caption"> 
                            {{ props.item.budget.data.type  | uppercase }}
                        </span>
                    </td>
                    <td class="text-xs-right">
                        <span class="caption">
                            FROM
                        </span>
                        &nbsp; 
                        <span class="title">
                            {{ props.item.start_time }}
                        </span>
                        <br />
                        <span class="caption">
                            TO
                        </span>
                        &nbsp; 
                        <span class="title">
                            {{ props.item.end_time }}
                        </span>
                    </td>
                     <td class="text-xs-center">
                        <v-btn 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Pause/Resume campaign"
                        :disabled = "disableButton(props.item.status, 'toggle')"
                        icon 
                        class="grey--text" 
                        :loading = "props.item.toggle_button_loading"
                        @click="toggleCampaignStatus(props.item)"
                        >
                            <v-icon>
                                {{ props.item.status == 'active' ?  
                                'pause_circle_outline' : 'play_circle_outline' }}
                            </v-icon>
                        </v-btn>
                        <v-btn 
                        v-if="props.item.status == 'draft' || props.item.status == 'archived'" 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Delete campaign"
                        :loading="props.item.delete_button_loading" 
                        :disabled="disableButton(props.item.status, 'delete')"
                        icon 
                        class="grey--text" 
                        @click="deleteCampaign(props.item)"
                        >
                            <v-icon>delete</v-icon>
                        </v-btn>
                        <tk-confirm
                        v-else
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Archive campaign"
                        :icon="'archive'"
                        :data = "props.item"
                        :iconButton="true"
                        :loading="props.item.delete_button_loading"
                        @confirmation= "archiveCampaign(props.item)"
                        >
                            {{'Are you sure you want to archive ' + props.item.name + '?'}}
                        </tk-confirm>
                        <v-btn 
                        data-toggle="tooltip" 
                        data-placement="top" 
                        title="Edit campaign"
                        :disabled="props.item.status == 'archived'" 
                        icon 
                        class="grey--text" 
                        :href="'/admin/campaigns/edit/' + props.item.id"
                        >
                            <v-icon>edit</v-icon>
                        </v-btn>
                    </td>
                </template>
                <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                    From {{ pageStart }} to {{ pageStop }}
                </template>
            </v-data-table>
            <!-- CAMPAIGNS END -->
        
        </v-card>
        <!-- CARD END -->

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
                //ACTIONS
                search_campaigns: '',
                selected_statuses: ['active','draft', 'paused', 'not started'],
                statuses: {
                    not_started: 'orange darken-1 white--text', 
                    expired: 'red lighten-1 white--text', 
                    active: 'green lighten-1 white--text', 
                    paused: 'yellow darken-1 white--text', 
                    archived: 'red darken-1 white--text', 
                    draft: 'grey lighten-2 white--text'
                },

                //CAMPAIGNS
                campaigns: [],
                pagination: {},
                campaigns_table_loading: true
            }
        },

        methods: {

            //ACTIONS
            removeTextFromChip(data) {
                this[data] = [];
            },

            addTextToChip(selection, count) {
                var selection_size = selection.length;
                var cut = selection_size > count ? true : false;
                if(!cut) return selection.toString().replace(",", ", ");
                else {
                    var excess = selection_size - count;
                    var shorter_selection = selection.slice(0, count);
                    var stringify = shorter_selection.toString();
                    return stringify.replace(",", ", ") + ' and ' + excess + ' more.';
                }
            },

            //CAMPAIGNS
            disableButton(status, button) {
                if(button == 'delete') return status == 'archived' ? true : false;
                if(button == 'toggle') return status == 'active' || status == 'paused' ? false : true;
            },


            toggleCampaignStatus(campaign) {
                var new_status = campaign.status == 'active' ? 'paused' : 'active';
                campaign.toggle_button_loading = true;
                var additional_message = new_status == 'active' ? ' Go get \'em!' : '';
                axios.put(
                    this.$root.uri + '/campaigns/' + campaign.id, 
                    { status: new_status }, 
                    this.$root.config
                ).then(response => {
                        this.$root.createNotification('Campaign ' + campaign.name + ' (id: ' + campaign.id + ') is ' + new_status + '.' + additional_message);
                        this.getCampaigns();
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not toggle campaign status.');
                    }
                );
            },

            changeCampaignsData(campaigns) {
                campaigns = campaigns.reverse(); //chronological

                //add datapoints
                for(var campaign in campaigns) {
                    Vue.set(campaigns[campaign], 'toggle_button_loading', false);
                    Vue.set(campaigns[campaign], 'delete_button_loading', false);
                    Vue.set(campaigns[campaign], 'show_modal', false);
                }
                return campaigns;
            },

            getCampaigns() {
                axios.get(
                    this.$root.uri + '/campaigns', 
                    this.$root.config
                ).then(response => {
                    this.campaigns = this.changeCampaignsData(response.data.data);
                    this.campaigns_table_loading = false;
                }, error => {
                    this.campaigns_table_loading = false;
                    this.$root.showAlertPopUp('error', 'Can not access campaigns.');
                })
            },

            archiveCampaign(campaign) {
                campaign.delete_button_loading = true;

                axios.put(
                    this.$root.uri + '/campaigns/' + campaign.id, 
                    { status: 'archived' }, 
                    this.$root.config
                ).then(response => {
                        campaign.delete_button_loading = false;
                        campaign.show_modal = false;
                        this.getCampaigns();
                    }, error => {
                        campaign.delete_button_loading = false;
                        campaign.show_modal = false;
                        this.$root.showAlertPopUp('error', 'Can not archive campaign.');
                    }
                );
            },

            deleteCampaign(campaign) {
                campaign.delete_button_loading = true;
                var campaign_name = campaign.name;

                axios.delete(
                    this.$root.uri + '/campaigns/' + campaign.id, 
                    this.$root.config
                ).then(response => {
                        this.getCampaigns();
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Can not delete campaign.');
                    }
                );
            }
        },

        computed: {
            filtered_campaigns() {
                var self = this;
                return this.campaigns.filter(campaign => 
                    campaign.name.toLowerCase().includes(self.search_campaigns.toLowerCase()) &&
                        (this.selected_statuses.indexOf(campaign.status) != -1 || this.selected_statuses.length == 0)
                );
            }
        },

        filters: {
            uppercase(value) {
                value = value.replace('_', ' ');
                return value.toUpperCase();
            },

            capitalize(value) {
                var array = value.split(' ');
                var new_array = [];
                    
                for(var x = 0; x < array.length; x++){
                    new_array.push(array[x].charAt(0).toUpperCase() + array[x].slice(1));
                }
                value = new_array.join(' ');
                value = value.replace('_', ' ');
                return value.charAt(0).toUpperCase() + value.substr(1);
            }
        },

        watch: {
            token(value) {
                this.getCampaigns();
            },
            
            selected_statuses(value) {
                this.pagination.page = 1;
            }
        }
    }
</script>