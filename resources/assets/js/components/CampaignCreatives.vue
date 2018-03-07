<template>
    <v-container grid-list-xs>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CREATIVES VAULT</h5>
            </v-flex>
        </v-layout>

        <!-- SUBHEADER START -->
        <v-layout row wrap>
            <v-flex xs12 md8 class="valign-wrapper">
                <span class="title">Campaign Creatives</span>
                <p class="caption ma-0">
                    Select creatives that are a part of the campaign you are going to run.
                </p>
            </v-flex>
            <v-spacer></v-spacer>
            <v-dialog v-model="show_formats_modal" lazy absolute width="50%">
                <span slot="activator" class="clickable caption">
                    <v-icon class="small orange--text text--darken-2">help_outline</v-icon>
                    <a> Learn about supported creative formats </a>
                </span> 
                <v-card>
                    <v-card-title>
                        <h4>Supported Creative Formats</h4>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="pr-5 pl-5">
                        <v-chip v-for="size in iab_standard_sizes" :key="size" text-color="white">
                            <v-icon right>star</v-icon>
                            {{ size }}
                        </v-chip>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn 
                        @click="show_formats_modal = false" 
                        class="elevation-0"
                        >
                            <v-icon>close</v-icon>                                    
                            OK
                        </v-btn>
                    </v-card-actions>
                </v-card>   
            </v-dialog>
        </v-layout>
        <!-- SUBHEADER END -->

        <v-card class="elevation-0">
            <v-card-text v-if="loading">
                <scale-loader 
                :loading="true" 
                color="#9e9e9e" 
                height="15px" 
                width="3px" 
                class="mt-5"
                ></scale-loader>
            </v-card-text>
            <v-card-text v-else-if="!currentFolder.id">
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-data-table
                        no-data-text="Create your first Ad group through the Creatives page!"
                        :items="folders.data"
                        hide-actions
                        class="creatives-explorer no-headers"
                        >
                            <template slot="headers" slot-scope="props">
                                &nbsp;
                            </template>
                            <template slot="items" slot-scope="props">
                                <tr :active="props.selected" @click="openFolder(props.item)">
                                    <td width="40" class="text-xs-right clickable"><v-icon>folder</v-icon></td>
                                    <td class="text-xs-left clickable"><span class="title">{{ props.item.name }}</span></td>
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
                        <v-data-table
                        no-data-text="Upload your first creative in this Ad group through the Creatives page!"
                        :items="creatives.data"
                        hide-actions
                        v-model="campaign.creatives.data"
                        class="creatives-explorer no-headers"
                        v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                        >
                            <template slot="headers" slot-scope="props">
                                &nbsp;
                            </template>
                            <template slot="items" slot-scope="props">
                                <tr 
                                @mouseenter="imageSource = props.item.thumb, 
                                sample= props.item.name, 
                                statusShow = props.item.approved, 
                                typeShow = props.item.class, 
                                dimensionsShow = props.item.w + 'x' + props.item.h" 
                                v-show="props.item.approved == 'approved' || 
                                props.item.approved == 'pending'"
                                >
                                    <td width="40" class="text-xs-right">
                                        <v-checkbox
                                        v-if="props.item.approved == 'pending'"
                                        :disabled="true"
                                        indeterminate
                                        ></v-checkbox>
                                        <v-checkbox
                                        v-else
                                        @click="props.selected = !props.selected, creativesRules()"
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
                            <template slot="pageText" slot-scope="{ pageStart, pageStop }">
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

    props:['token','campaign','valid'],

    data() {
        return {
            show_formats_modal: false,
            iab_standard_sizes: ['300x250','250x250','240x400','336x280','180x150','300x100','720x300','468x60','234x60','88x31','120x90','120x60','120x240','125x125','728x90','160x600','120x600','300x600'],
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
            currentFolder: {},
            createFolderFlag: false,
            creativeAttributes: {
                name: '',
                url: '',
                responsive: false,
                h: 0,
                w: 0,
                class: 'banner'
            }
        }
    },
    
    computed: {
        selected_creatives() {
            return this.campaign.creatives.data;
        }
    },

    methods: {

        creativesRules() {
            this.valid.creatives = this.campaign.creatives.data == '' ? false : true;
        },

        collectCreatives() {
            return this.campaign.creatives.data.map(creative => creative.id);
        },

        updateDraftCreatives() {
            if(this.campaign.status != 'draft') return;
            
            axios.post(
                this.$root.uri + '/campaigns/' + this.campaign.id + '/creatives', 
                { creatives: this.collectCreatives() }, 
                this.$root.config
            ).then(response => {

                }, error => {
                    this.$root.showAlertPopUp('error', 'Can not update campaign creatives.');
                }
            );
        },

        getFolders() {
            axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {
                this.folders = response.data;
                if(!this.currentFolder.id) {
                    this.loading = false;
                }
            }, error => {
                this.$root.showAlertPopUp('error', 'Can not access ad groups.');
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
                this.$root.showAlertPopUp('error', 'Can not access creatives');
                this.loading=false;
            });
        }
    },

    filters: {
        uppercase(value) {
            return value.toUpperCase();
        }
    },

    watch: {
        token(value) {
            this.getFolders();
        },

        selected_creatives(value) {
            this.updateDraftCreatives();
        },

        campaign(value) {
            this.creativesRules();
        }
    },
}
</script>
