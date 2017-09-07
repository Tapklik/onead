<template>
<v-container>
<v-card>
    <v-card-title>
      Nutrition
      <v-spacer></v-spacer>
      <v-text-field
        append-icon="search"
        label="Search"
        single-line
        hide-details
        v-model="search"
      ></v-text-field>
    </v-card-title>
    <v-data-table
        v-bind:items="items"
        v-bind:search="search"
      >
      <template slot="items" scope="props">
        <td>
          <v-edit-dialog
            lazy
          > {{ props.item.name }}
            <v-text-field
              slot="input"
              label="Edit"
              v-model="props.item.name"
              single-line
              counter
              :rules="[max25chars]"
            ></v-text-field>
          </v-edit-dialog>
        </td>
        <td class="text-xs-right">{{ props.item.calories }}</td>
        <td class="text-xs-right">{{ props.item.fat }}</td>
        <td class="text-xs-right">{{ props.item.carbs }}</td>
        <td class="text-xs-right">{{ props.item.protein }}</td>
        <td class="text-xs-right">{{ props.item.sodium }}</td>
        <td class="text-xs-right">{{ props.item.calcium }}</td>
        <td class="text-xs-right">
          <v-edit-dialog
            @open="tmp = props.item.iron"
            @save="props.item.iron = tmp || props.item.iron"
            large
            lazy
          >
            <div>{{ props.item.iron }}</div>
            <div slot="input" class="mt-3 title">Update Iron</div>
            <v-text-field
              slot="input"
              label="Edit"
              v-model="tmp"
              single-line
              counter
              autofocus
              :rules="[max25chars]"
            ></v-text-field>
          </v-edit-dialog>
        </td>
      </template>
      <template slot="pageText" scope="{ pageStart, pageStop }">
        From {{ pageStart }} to {{ pageStop }}
      </template>
    </v-data-table>
  </v-card>
    <table id="dt_basic" class="table table-striped table-campaigns dataTable no-footer" width="100%" role="grid">
        <tbody>
            <tr :class="{'edit-campaign running': isRunning(campaign), 'edit-campaign paused' : !isRunning(campaign)}"
                role="row"
                v-for="campaign in filteredCampaigns">
                <td class="text-center valign-m sorting_1">
                    <span class="badge txt-color-white">
                        <span class="status"></span>
                    </span>
                </td>
                <td class="text-left valign-m expand"><span class="responsiveExpander"></span>
                    <h4>{{ campaign.name }}</h4>
                    <small class="text-muted">cp{{ campaign.id }}</small>
                </td>
                <td>
                    <div>
                        <small class="text-muted">Campaign Flight</small>
                        <br><span class="value">{{ campaign.start_time }} - {{ campaign.end_time }}</span>
                        <div class="progress progress-sm progress-striped">
                            <div class="progress-bar" role="progressbar" :style="'width: ' + getCampaignProgress(campaign) + '%'"></div>
                        </div>
                        <span class="pull-right text-muted">{{ getCampaignProgress(campaign) }}% Complete</span>
                    </div>
                </td>
                <td>
                    <div>
                        <small class="text-muted">Campaign Budget</small>
                        <br><span class="value">${{ campaign.bidmax }} (daily)</span>
                        <div class="progress progress-sm progress-striped">
                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <span class="pull-right text-muted">$0 spent</span>
                    </div>
                </td>
                <td>
                    <div>
                        <small class="text-muted">Impressions : </small><span class="value">0</span><br>
                        <small class="text-muted">Clicks : </small><span class="value">0</span><br>
                        <small class="text-muted">CPM : </small><span class="value">$0</span><br>
                        <small class="text-muted">CPC : </small><span class="value">$0</span>
                    </div>
                </td>
                <td class="valign-m">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary">
                            <i :class="{'fa fa-play': !isRunning(campaign), 'fa fa-pause': isRunning(campaign)}"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary" @click="deleteCampaign(campaign.id)">
                            <i class="fa fa-trash-o inactive"></i>
                        </button>
                        <a :href="'/admin/campaigns/edit/' + campaign.id" class="btn btn-sm btn-primary">
                            <i class="fa fa-pencil inactive"></i>
                        </a>
                    </div>
                </td>
            </tr>

            <div class="alert alert-info" role="alert" v-show="!campaigns.length">
                <strong>
                    <i class="fa fa-exclamation-triangle"></i>
                    You currently have no campaigns,</strong>
                <a href="/admin/campaigns/create">why not create oneeee</a>?
            </div>
        </tbody>
    </table>

</v-container>
</template>

<script>
    export default {
        mounted() {
            console.log('Campaigns mounted.');
        },

        data() {
            return {
                campaigns: false,
                token: this.token
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

        watch: {
            token(value) {
                this.fetchCampaigns();
            }
        }
    }
</script>
