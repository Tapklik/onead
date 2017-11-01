<template>
    <v-container grid-list-xs>
        <popup></popup>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CREATIVES VAULT</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-card-text v-if="loading">
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-text>
                    <v-card-text v-else-if="!currentFolder.id">
                        <v-layout row wrap>
                            <v-flex xs12>                      
                            <v-alert dismissible v-bind:success='$root.alert.success' v-bind:error='$root.alert.error' v-model="$root.alert.alert" transition="scale-transition">{{$root.alert.alertMessage}}</v-alert>
                                <v-data-table 
                                :items="folders.data"
                                hide-actions
                                class="creatives-explorer no-headers"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr :active="props.selected" @click="openFolder(props.item)">
                                            <td width="40" class="text-xs-right"><v-icon>folder</v-icon></td>
                                            <td class="text-xs-left"><span class="title">{{ props.item.name }}</span></td>
                                        </tr>
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-breadcrumbs divider="/" class="left pa-0">
                                    <v-breadcrumbs-item >
                                        <span @click="closeFolder(), imageSource=''">ROOT</span>
                                    </v-breadcrumbs-item>
                                    <v-breadcrumbs-item>
                                        {{ currentFolder.name | uppercase}}
                                    </v-breadcrumbs-item>
                                </v-breadcrumbs>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 md8 >
                            <v-alert dismissible v-bind:success='$root.alert.success' v-bind:error='$root.alert.error' v-model="$root.alert.alert" transition="scale-transition">{{$root.alert.alertMessage}}</v-alert>
                            <div v-for="c in activeCreatives">{{c.id}}</div>
                                <v-data-table                                        
                                :items="creatives.data"
                                hide-actions
                                v-model="campaign.creatives.data"
                                class="creatives-explorer no-headers"
                                v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr @mouseenter="imageSource = props.item.thumb, sample= props.item.name, statusShow = props.item.approved, typeShow = props.item.class, dimensionsShow = props.item.w + 'x' + props.item.h" v-show="props.item.approved == 'approved'">
                                            <td width="40" class="text-xs-right">
                                                <v-checkbox
                                                @click="props.selected = !props.selected, creativesRules(), $parent.$parent.$parent.trueCreatives()"
                                                @change="updateDraftCreatives()"
                                                :input-value="props.selected"
                                                hide-details
                                                ></v-checkbox>
                                            </td>
                                            <td class="text-xs-left">
                                                <span class="title">{{ props.item.name }}</span><br>
                                                <span class="caption">{{ props.item.id }}</span>
                                            </td>
                                            <td>
                                                <v-chip v-if="props.item.approved == 'approved'" small class="green white--text">
                                                    <small>APPROVED</small>
                                                </v-chip>
                                                <v-chip v-else-if="props.item.approved == 'pending'" small class="yellow darken-2 white--text">
                                                    <small>PENDING</small>
                                                </v-chip>   
                                                <v-chip v-else small class="red white--text">
                                                 <small>DECLINED</small>
                                             </v-chip>   
                                             </td>
                                             <td>{{ props.item.class | uppercase }}</td>
                                             <td>{{ props.item.w }} x {{ props.item.h }}</td>
                                        </tr>
                                    </template>
                                    <template slot="pageText" scope="{ pageStart, pageStop }">
                                        From {{ pageStart }} to {{ pageStop }}
                                    </template>
                                </v-data-table>
                            </v-flex>             
                            <v-flex xs12 md3 offset-md1 class="valign-wrapper mt-4">                                
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-card class="elevation-0 left-border pl-3" height="500px">
                                            <v-card-title>
                                                <span class="title">Creative Details</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <div class="preview">
                                                            <img width="128" :src="imageSource">
                                                        </div>
                                                    </v-flex>
                                                </v-layout>
                                                <v-layout row wrap>
                                                    <v-flex xs12>
                                                        <span v-if="sample != 'sample'"> {{sample}}</span>
                                                        <span v-else> Creative </span>
                                                        <br>
                                                        <span v-if="typeShow != ''" class="grey--text">{{typeShow | uppercase}}</span>
                                                        <span v-else class="grey--text">TYPE</span>
                                                        <br><br>
                                                        <span class="caption"><b>Status:</b> {{statusShow | uppercase}}</span><br>
                                                        <span class="caption"><b>Dimensions:</b> {{dimensionsShow}}</span>
                                                    </v-flex>
                                                </v-layout>
                                            </v-card-text>
                                          </v-card>
                                    </v-flex>
                                </v-layout>
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
        },

        props:['token','user','campaign'],

        data() {
            return {
                dimensionsShow: '',
                loading: true,
                typeShow: '',
                statusShow: '',
                sample:'sample',
                imageSource: '',
                showModal: false,
                dropzone: false,
                newFolder: '',
                checked:[],
                folders: {
                    data: []
                },
                creatives: {},
                activeCreatives: this.campaign.creatives.data,
                currentFolder: {},
                createFolderFlag: false,
                creativeAttributes: {
                    name: '',
                    url: '',
                    responsive: false,
                    h: 0,
                    w: 0,
                    class: 'banner'
                },
                search: ''
            }
        },

        methods: {
            creativesRules() {
                if(this.campaign.creatives.data == '') {
                    this.$parent.$parent.$parent.validCreatives = false;
                }
                
                else {
                    this.$parent.$parent.$parent.validCreatives = true;
                }
            
            },

            collectCreatives() {

                var ids = [];

                for(var i in this.campaign.creatives.data)
                {
                    ids.push(this.campaign.creatives.data[i].id);
                }

                return ids;
            },

            updateDraftCreatives() {

                if(this.$root.editMode == true) return;

                else {
                    var payload = this.collectCreatives();
    
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/creatives', {creatives: payload}, this.$root.config).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    });
                }
            },

            consoleLog(value) {
                console.log(value);
            },
            getFolders() {

                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {
                    this.folders = response.data;
                    if(!this.currentFolder.id) {
                        this.loading = false;
                    }
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                });
            },

            openFolder(folderObj) {

                this.currentFolder = folderObj;
                this.loading=true;

                this.getFolderCreatives(this.currentFolder.id);
            },

            closeFolder() {
                this.currentFolder = {};
                this.creatives = {};
            },

            getFolderCreatives(folderId) {
                axios.get(this.$root.uri + '/creatives/folders/' + folderId, this.$root.config).then(response => {
                    this.creatives = response.data;
                    this.loading=false;
                }, error => {                  
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                    this.loading=false;
                });
            },

            renderIconFromStatus(status) {

                return (status == 'approved') ? 'fa fa-fw fa-check green' : 'fa fa-fw fa-times red';
            },

            openCreative(src) {
                window.open(src);
            },

            openModal() {
                this.$root.modalIsOpen = true;
                return false;
            },

            toggleAll () {
                if (this.selected.length) this.selected = []
                    else this.selected = this.items.slice()
                }
        },

        computed: {
        },

        filters: {
            uppercase: function(v) {
              return v.toUpperCase();
          }
      },

    watch: {
        token(value) {
            if(typeof value != 'undefined') {
                this.getFolders();
            }
        },
        campaign(value) {
            this.creativesRules();
        }
    },
}
</script>
