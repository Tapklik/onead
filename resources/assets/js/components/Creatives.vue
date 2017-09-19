<template>
    <v-container fluid grid-list-xs>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-card-title>
                        <v-flex xs12 md2>
                            <v-dialog v-model="showModal" width="1500px">
                                <v-btn slot="activator" @click="dropzoneMaker()" primary dark class="elevation-0">
                                    <v-icon>add</v-icon> Add Creatives
                                </v-btn> 
                                <v-card>
                                    <v-container fluid grid-list-md>
                                        <v-layout row wrap>
                                            <v-flex xs12 class="mb-3 mt-4">
                                                <h4>Basic Creative Details</h4>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md12>
                                                <div id="uploader">Drop Files Here</div>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-text-field v-model="creativeAttributes.name" label="Creatives Name"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-text-field v-model="creativeAttributes.class" label="Class"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md3>
                                                <v-text-field v-model="creativeAttributes.h" label="Height"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md3>
                                                <v-text-field v-model="creativeAttributes.w" label="Width"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-switch label="Responsive" v-model="creativeAttributes.responsive"></v-switch>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md2 v-for="f in folders.data" :key="f.id"> 
                                                <v-checkbox :label="f.name" v-model="folderId" :value="f.id"></v-checkbox>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 class="mb-3 mt-4">
                                                <h4>Advanced Details</h4>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-text-field v-model="creativeAttributes.url" label="Class"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-text-field label="Class"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md6>
                                                <v-btn @click="uploadCreative()"></v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-card>   
                            </v-dialog>
                        </v-flex>
                        <v-flex xs12 md2 lg7>
                            <v-edit-dialog lazy> 
                                <v-btn v-if="!currentFolder.id" class="elevation-0">
                                    <v-icon>add</v-icon> Add Folder
                                </v-btn>
                                <v-layout slot="input" class="elevation-0"> 
                                    <v-text-field class="elevation-0" slot="input" label="Search" v-model="newFolder" single-line></v-text-field><v-btn primary dark class="elevation-0" slot="input" @click="storeNewFolder()">Create</v-btn>
                                </v-layout>
                            </v-edit-dialog>
                        </v-flex>
                        <v-flex xs12 md8 lg3>
                            <v-text-field 
                                append-icon="search" 
                                label="Search" 
                                single-line 
                                hide-details 
                                class="right"
                                v-model="search">
                            </v-text-field>
                        </v-flex>
                    </v-card-title>
                    <v-card-text v-if="!currentFolder.id">
                        <v-layout row wrap>
                            <v-flex xs12>
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
                                            <td class="text-xs-right">
                                                <v-btn icon class="grey--text">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </td>
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
                                        <span @click="closeFolder()">ROOT</span>
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
                                :items="creatives.data"
                                hide-actions
                                class="creatives-explorer"
                                v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr>
                                            <td width="40" class="text-xs-right">
                                                <v-checkbox
                                                primary
                                                hide-details
                                                v-model="campaign.creatives.data"
                                                :input-value="props.item"
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
                                             <td>
                                                <v-btn icon class="grey--text">
                                                    <v-icon>delete</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
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

    import Dropzone from 'dropzone';

    export default {
        mounted() {

        },
        props: ['token', 'user'],
        data() {
            return {
                showModal: false,
                dropzone: false,
                classList: ['banner','video','native'],
                newFolder: '',
                folderId: '',
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
                    console.log(error);
                });
            },

            dropzoneMaker() {
                this.dropzone = new Dropzone('div#uploader', {
                        url: this.$root.uri + '/creatives',
                        paramName: 'file',
                        maxFilesize: 2,
                        headers: {'Authorization': "Bearer " + this.token},
                        autoProcessQueue: false
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
                    console.log(error);
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
                    folder_id: this.folderId,
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
