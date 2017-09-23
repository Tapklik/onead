<template>
    <v-container fluid grid-list-xs>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAREATIVES VAULT</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6 class="valign-wrapper mt-4">
                <span class="title">Browse Campaign Creatives</span>
                <p class="caption ma-0">Select creatives for your campaign. Make sure that your creatives fit target devices</p>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-card-text v-if="!currentFolder.id">
                        <v-layout row wrap>
                            <v-flex xs12>                      
                            <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                                <v-data-table 
                                :items="folders.data"
                                hide-actions
                                class="creatives-explorer"
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
                            <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                                <v-data-table                                        
                                :items="creatives.data"
                                hide-actions
                                class="creatives-explorer"
                                v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr @click="imageSource = props.item.iurl" v-show="props.item.approved == 'approved'">
                                            <td width="40" class="text-xs-right">
                                                <v-checkbox
                                                primary
                                                hide-details
                                                :value="props.item"
                                                v-model="campaign.creatives.data"
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
                            <v-flex xs12 md4 class="valign-wrapper mt-4">                                
                                <!--<v-card-media class="portrait" style="background-position: center; background-size: 100%; background-repeat: no-repeat;" width="100%" height="100%" transition="scale-transition" :src="imageSource"></v-card-media>-->
                                <img style="max-width: 100%; width: auto;" :src="imageSource">
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
        mounted() {

        },
        props:['token','user','campaign'],
        data() {
            return {
                imageSource: '',
                alert: false,
                error: false,
                success: false,
                alertMessage: 'Something went wrong',
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
                },
                search: ''
            }
        },

        methods: {
            getFolders() {

                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {

                    this.folders = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            openFolder(folderObj) {

                this.currentFolder = folderObj;

                this.getFolderCreatives(this.currentFolder.id);
            },

            closeFolder() {
                console.log("lcossssing")
                this.currentFolder = {};
                this.creatives = {};
            },

            getFolderCreatives(folderId) {
                axios.get(this.$root.uri + '/creatives/folders/' + folderId, this.$root.config).then(response => {
                    this.creatives = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            renderIconFromStatus(status) {

                return (status == 'approved') ? 'fa fa-fw fa-check green' : 'fa fa-fw fa-times red';
            },

            openCreative(src) {
                window.open(src);
            },

            createNewFolder() {
                this.createFolderFlag = true;
            },

            uploadCreative() {

                this.dropzone.options.params = {
                    folder_id: this.currentFolder.key,
                    name: this.creativeAttributes.name,
                    ctrurl: this.creativeAttributes.url,
                    w: this.creativeAttributes.w,
                    h: this.creativeAttributes.h,
                    responsive: this.creativeAttributes.responsive,
                    class: this.creativeAttributes.class,
                };

                this.dropzone.processQueue();

                var obj = this;
                this.dropzone.on("complete", function (file) {
                    if(file.status == 'success') {
                        obj.dropzone.removeFile(file);

                        obj.getFolderCreatives(obj.currentFolder.id);

                        swal('Success', 'The upload has finished successfully!', 'success');
                    } else {
                        swal('Error', 'Something went wrong.', 'error');
                    }
                });
            },

            storeNewFolder() {
                var payload = {name: this.newFolder, status: 0};

                if(this.newFolder.name == '') {
                    swal('Error', 'Folder name can\'t be empty', 'error');
                    throw 'Missing folder name';
                }

                axios.post(this.$root.uri + '/creatives/folders', payload, this.$root.config).then(response => {
                    this.getFolders();

                    this.currentFolder = {};
                    this.createFolderFlag = false;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';

                });
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

            filteredCreatives() {
                if(!this.folders) return this.folders;

                var obj = this;

                return this.folders.filter(function (folder) {
                    return folder.name.toLowerCase().indexOf(obj.$root.search.toLowerCase())>=0;
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

            if(typeof value != 'undefined') {
                this.getFolders();
            }
        }
    }
}
</script>
