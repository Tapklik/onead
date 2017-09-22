<template>
    <v-container fluid grid-list-xs>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-card-title>
                        <v-flex xs12 md2>
                            <v-dialog v-model="showModal" lazy absolute width="50%">
                                <v-btn slot="activator" primary dark class="elevation-0">
                                    <v-icon>add</v-icon>
                                    Add Creatives
                                </v-btn>
                                <v-card>
                                    <v-card-title>
                                        <h4>Upload Creatives Here</h4>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-layout row wrap>
                                            <v-flex xs12 class="valign-wrapper">
                                                <span class="title">Upload Creatives</span>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md12>
                                                <div id="uploader" @mouseenter="dropzoneMaker()" style="width: 100%; background-color: grey; text-align: center; font-size: 16pt; padding-top:30px">Drop Files Here</div>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 class="valign-wrapper mt-4">
                                                <span class="title">Creative Basic Details</span>
                                            </v-flex>
                                        </v-layout>
                                        <br>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7 class="valign-wrapper">
                                                <span class="title">Name</span><br>
                                                <p class="ma-0">Edit default name</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-text-field prepend-icon="mode_edit" v-model="creativeAttributes.name" placeholder="Name"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7 class="valign-wrapper">
                                                <span class="title">Creative Class</span><br>
                                                <p class="ma-0">(Banner, Video, Native)</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-select prepend-icon="photo" :items="classList" v-model="creativeAttributes.class" autocomplete></v-select>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md12 class="valign-wrapper">
                                                <span class="title">Dimensions (W x H)</span><br>
                                                <p class="ma-0">Edit default dimensions</p>
                                            </v-flex>
                                            <v-flex xs12 md2>
                                                <v-text-field prepend-icon="code" v-model="creativeAttributes.w" placeholder="W"></v-text-field>
                                            </v-flex>
                                            <v-flex xs12 md1>
                                            </v-flex>
                                            <v-flex xs12 md2>
                                                <v-text-field prepend-icon="unfold_more" v-model="creativeAttributes.h" placeholder="H"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md3 class="valign-wrapper">
                                                <span class="title">Responsive</span><br>
                                                <p class="ma-0">Is this creative responsive?</p>
                                            </v-flex>
                                            <v-flex xs12 md6>
                                                <v-switch v-model="creativeAttributes.responsive" label="Responsive"></v-switch>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7 class="valign-wrapper">
                                                <span class="title">Folder</span><br>
                                                <p class="ma-0">Choose the folder you want to save in?</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-select prepend-icon="folder" :items="folders.data" item-text="name" item-value="key" v-model="folderId" placeholder="Folder"></v-select>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 class="valign-wrapper mt-4">
                                                <span class="title">Advanced (Optional)</span>
                                            </v-flex>
                                        </v-layout>
                                        <br>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7  class="valign-wrapper">
                                                <span class="title">Click-Through URL</span><br>
                                                <p class="ma-0">Click-through url per creative</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-text-field prepend-icon="language" v-model="creativeAttributes.url"
                                                placeholder="URL"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7 class="valign-wrapper">
                                                <span class="title">Ad Markup</span><br>
                                                <p class="ma-0">Set iframe or HTML markup</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-text-field prepend-icon="language" placeholder="Ad Markup"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn @click="showModal = false" class="elevation-0">
                                            <v-icon>close</v-icon>                                    
                                            Cancel
                                        </v-btn>
                                        <v-btn primary dark @click="uploadCreative(), showModal = false" class="elevation-0">
                                            <v-icon>done</v-icon>
                                            Save
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>   
                            </v-dialog>
                        </v-flex>
                        <v-flex xs12 md2 lg7>
                            <v-dialog v-model="showModal1" lazy absolute width="70%">
                                <v-btn v-if="!currentFolder.id" slot="activator" class="elevation-0">
                                    <v-icon>add</v-icon>
                                    Add Folder
                                </v-btn>
                                <v-card>
                                    <v-card-title>
                                        <h4>Create a Folder</h4>
                                    </v-card-title>
                                    <v-card-text>
                                        <v-layout row wrap>
                                            <v-flex xs12 md7 class="valign-wrapper">
                                                <span class="title">Folder Name</span><br>
                                                <p class="ma-0">The name of the newly created folder</p>
                                            </v-flex>
                                            <v-flex xs12 md8>
                                                <v-text-field prepend-icon="folder" v-model="newFolder" placeholder="Folder Name"></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn class="elevation-0" @click="showModal1 = false">
                                            <v-icon>close</v-icon>                                    
                                            Cancel
                                        </v-btn>
                                        <v-btn primary dark class="elevation-0" @click="storeNewFolder(), showModal1=false">
                                            <v-icon>done</v-icon>
                                            Save
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>   
                            </v-dialog>
                        </v-flex>
                        <v-flex xs12 md8 lg3>
                            <v-text-field append-icon="search" label="Search" single-line hide-details class="right" v-model="search">
                            </v-text-field>
                        </v-flex>
                    </v-card-title>
                    <v-card-text v-if="!currentFolder.id">
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">
                                {{alertMessage}}
                                </v-alert>
                                <v-data-table :items="folders.data" hide-actions class="creatives-explorer">
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr :active="props.selected" @click="openFolder(props.item)">
                                            <td width="40" class="text-xs-right">
                                                <v-icon>folder</v-icon>
                                            </td>
                                            <td class="text-xs-left">
                                                <span class="title">{{ props.item.name }}</span>
                                            </td>
                                            <td class="text-xs-right">
                                                <v-dialog v-model="showModal2" lazy absolute width="70%">
                                                    <v-btn icon class="grey--text" @click="deleteFolderId = props.item.id, deleteFolderName = props.item.name" slot="activator">
                                                        <v-icon>delete</v-icon>
                                                    </v-btn>
                                                    <v-card>
                                                        <v-card-title>
                                                            <h4>Delete Folder</h4>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-layout row wrap>
                                                                <v-flex xs12 md12 class="valign-wrapper text-xs-center">
                                                                    <span class="">ARE YOU SURE YOU WANT TO DELETE {{deleteFolderName | uppercase}}?</span><br>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-card-text>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn class="elevation-0" @click="showModal2 = false">
                                                                <v-icon>close</v-icon>                                   
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn primary dark class="elevation-0" @click="deleteFolder(deleteFolderId, deleteFolderName), showModal2=false">
                                                                <v-icon>done</v-icon>
                                                                Delete
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>   
                                                </v-dialog> 
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
                                    <v-breadcrumbs-item>
                                        <span @click="closeFolder(), imageSource=''">ROOT</span>
                                    </v-breadcrumbs-item>
                                    <v-breadcrumbs-item>
                                        {{ currentFolder.name | uppercase}}
                                    </v-breadcrumbs-item>
                                </v-breadcrumbs>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 md8>
                                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                                <v-data-table :items="creatives.data" hide-actions class="creatives-explorer" v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]">
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr>
                                            <td @click="imageSource = props.item.iurl" class="text-xs-left">
                                                <span class="title">{{ props.item.name }}</span><br>
                                                <span class="caption">{{ props.item.id }}</span>
                                            </td>
                                            <td @click="imageSource = props.item.iurl">
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
                                            <td @click="imageSource = props.item.iurl">
                                                {{ props.item.class | uppercase }}
                                            </td>
                                            <td @click="imageSource = props.item.iurl">
                                                {{ props.item.w }} x {{ props.item.h }}
                                            </td>
                                            <td>
                                                <v-dialog v-model="showModal3" lazy absolute width="70%">
                                                    <v-btn icon class="grey--text" @click="deleteCreativeId = props.item.id, deleteCreativeName = props.item.name" slot="activator">
                                                        <v-icon>delete</v-icon>
                                                    </v-btn>
                                                    <v-card>
                                                        <v-card-title>
                                                            <h4>Delete Creative</h4>
                                                        </v-card-title>
                                                        <v-card-text>
                                                            <v-layout row wrap>
                                                                <v-flex xs12 md12 class="valign-wrapper text-xs-center">
                                                                    <span class="">ARE YOU SURE YOU WANT TO DELETE {{deleteCreativeName | uppercase}}?</span><br>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-card-text>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn class="elevation-0" @click="showModal3 = false">
                                                                <v-icon>close</v-icon>                                   
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn primary dark class="elevation-0" @click="deleteCreative(deleteCreativeId, deleteCreativeName), showModal3=false">
                                                                <v-icon>done</v-icon>
                                                                Delete
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-card>   
                                                </v-dialog>
                                            </td>
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

    import Dropzone from 'dropzone';

    export default {
        created() {
           this.$root.isLoading = true;
        },

        mounted() {
           this.$root.isLoading = false;
        },
        props: ['token', 'user'],
        data() {
            return {
                creativeIAB: ['300x250','250x250','240x400','336x280','180x150','300x100','720x300','468x60','234x60','88x31','120x90','120x60','120x240','125x125','728x90','160x600','120x600','300x600'],
                deleteCreativeId: '',
                deleteCreativeName: '',
                deleteFolderId: '',
                deleteFolderName: '',
                imageSource: '',
                alert: false,
                success: false,
                error: false,
                alertMessage: 'Something went wrong',
                showModal: false,
                showModal1: false,
                showModal2: false,
                showModal3: false,
                dropzone: false,
                classList: ['banner', 'video', 'native'],
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
            setTimeout(value) {
                setTimeout(value, 500);
            },
            getFolders() {

                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {

                    this.folders = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Bim';
                });
            },

            dropzoneMaker() {
                if (this.dropzone !== false) return;

                this.dropzone = new Dropzone("#uploader", {
                    url: this.$root.uri + '/creatives',
                    paramName: 'file',
                    maxFilesize: 2,
                    acceptedFiles: 'image/*',
                    headers: {"Authorization": 'Bearer ' + this.token},
                    autoProcessQueue: false
                });

                this.dropzone.on("addedfile", function(file) {
                    var sizeInterval = setInterval(function () {
                        if(typeof file.width != 'undefined') {
                            this.creativeAttributes = {w: file.width, h: file.height, name: file.name.slice(0,(file.name.length-4))};
                            clearInterval(sizeInterval);
                        }
                    }.bind(this), 1000);
                }.bind(this));
            },

            openFolder(folderObj) {
                this.currentFolder = folderObj;
                this.getFolderCreatives(folderObj.id);
            },

            checkDimensions() {
                var iabs = this.creativeIAB;
                var dimension = this.dimension;
                var check = 0;
                for(var iab in iabs) {
                    if(dimension == iabs[iab]) {
                        check = check + 1;
                    }
                }
                if (check > 0) {
                    return true;
                }
                else { 
                    return false
                }
            },

            closeFolder() {
                this.currentFolder = {};
                this.creatives = {};
            },

            deleteFolder(folderId, folderName) {
                axios.delete(this.$root.uri + '/creatives/folders/' + folderId, this.$root.config).then(response => {
                    this.alert = true;
                    this.success = true;
                    this.error = false;
                    this.alertMessage = 'You have successfully deleted ' + folderName;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong'; 
                });
            },

            deleteCreative(creativeId, creativeName) {
                axios.delete(this.$root.uri + '/creatives/' + creativeId +'', this.$root.config).then(response => {
                    this.alert = true;
                    this.success = true;
                    this.error = false;
                    this.alertMessage = 'You have successfully deleted ' + creativeName;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong'; 
                });
            },

            getFolderCreatives(folderId) {
                axios.get(this.$root.uri + '/creatives/folders/' + folderId, this.$root.config).then(response => {
                    this.creatives = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Bam';
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
                if(this.checkDimensions() == false) {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'The dimensions are not qualified and not up to iab standard';
                }
                else
                {
                this.dropzone.processQueue();
                
                    this.dropzone.on("complete", function (file) {
                        if (file.status == 'success') {
                            this.dropzone.removeFile(file);
                        this.alert = true;
                        this.error = false;
                        this.success = true;
                        this.alertMessage = 'Uploaded successfully';
                        } else {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Boom';
                        }
                    }.bind(this));
                }
            },

            storeNewFolder() {
                var payload = {name: this.newFolder, status: 0};

                if (this.newFolder.name == '') {
                    swal('Error', 'Folder name can\'t be empty', 'error');
                    throw 'Missing folder name';
                }

                axios.post(this.$root.uri + '/creatives/folders', payload, this.$root.config).then(response => {
                    this.getFolders();
                    this.currentFolder = {};
                    this.createFolderFlag = false;
                    this.error = false;
                    this.success = true;
                    this.alert = true;
                    this.alertMessage = 'You have successfully created a new folder';
                }, error => {
                    this.error = true;
                    this.success = false;
                    this.alert = true;
                    this.alertMessage = 'Bem';
                });
            },

            openModal() {
                this.$root.modalIsOpen = true;
                return false;
            },

            toggleAll() {
                if (this.selected.length) this.selected = []
                    else this.selected = this.items.slice()
                }
        },

        computed: {

            filteredCreatives() {
                if (!this.folders) return this.folders;

                var obj = this;

                return this.folders.filter(function (folder) {
                    return folder.name.toLowerCase().indexOf(obj.$root.search.toLowerCase()) >= 0;
                });
            },
            
            dimension() {
                return this.creativeAttributes.w + 'x' + this.creativeAttributes.h;
            }
        },

        filters: {
            uppercase: function (v) {
                return v.toUpperCase();
            }
        },


        watch: {

            token(value) {

                if (typeof value != 'undefined') {
                    this.getFolders();
                }

            }
        }
    }
</script>
