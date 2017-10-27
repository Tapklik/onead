<template>
    <v-container fluid grid-list-xs>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-divider></v-divider>
                    <v-card-title>
                        <v-flex xs12 md2>
                            <v-dialog v-model="showModal" lazy absolute width="100%">
                                <v-btn slot="activator" primary dark class="elevation-0">
                                    <v-icon>add</v-icon>
                                    Add Creatives
                                </v-btn>
                                <v-card>
                                    <v-card-title>
                                        <h4>Upload Creatives Here</h4>
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <v-layout row wrap class="pr-5 pl-5">
                                            <v-flex xs12>
                                                <v-layout row wrap>
                                                    <v-flex xs12 class="valign-wrapper">
                                                        <span class="subheading">UPLOAD CREATIVES</span>
                                                    </v-flex>
                                                </v-layout>
                                                <v-layout row wrap class="mt-2">
                                                    <v-flex xs12>
                                                        <v-card 
                                                        id="uploader" 
                                                        height="80px" 
                                                        class="elevation-0"
                                                        @mouseenter="dropzoneMaker()">
                                                            <div class="uploader-title"><v-icon>cloud_upload</v-icon> Drop Files Here</div>
                                                        </v-card>
                                                        <span class="red--text" v-show="!validFile">You must upload an image</span>
                                                    </v-flex>
                                                </v-layout>
                                                <v-divider class="mt-4"></v-divider>
                                                <v-layout row wrap class="mt-2">
                                                    <v-flex xs12 class="valign-wrapper mt-4">
                                                        <span class="subheading">CREATIVE BASIC DETAILS</span>
                                                    </v-flex>
                                                </v-layout>
                                                <v-layout row wrap>
                                                    <v-flex xs12 md6>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                <span class="title">Name</span><br>
                                                                <p class="caption ma-0">Edit default name</p>
                                                            </v-flex>
                                                            <v-flex xs12 md5>
                                                                <v-text-field prepend-icon="mode_edit" v-model="creativeAttributes.name" placeholder="Name" :rules="creativeNameRules()"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                <span class="title">Folder</span><br>
                                                                <p class="caption ma-0">The folder where your creative will be uploaded</p>
                                                            </v-flex>
                                                            <v-flex xs12 md5>
                                                                <v-select :rules="folderRules()" prepend-icon="folder" :items="folders.data" item-text="name" item-value="key" v-model="folderId" placeholder="Folder"></v-select>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-flex>
                                                    <v-flex xs12 md6>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                <span class="title">Creative Class</span><br>
                                                                <p class="caption ma-0">(Banner, Video, Native)</p>
                                                            </v-flex>
                                                            <v-flex xs12 md5>
                                                                <v-select prepend-icon="photo" :items="classList" v-model="creativeAttributes.class" :rules="classRules()"></v-select>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                <span class="title">Dimensions (W x H)</span><br>
                                                                <p class="caption ma-0">Edit default dimensions in px</p>
                                                            </v-flex>
                                                            <v-flex xs5 md3 lg2>
                                                                <v-text-field prepend-icon="code" :rules="widthRules()" v-model="creativeAttributes.w" type="number" placeholder="W"></v-text-field>
                                                            </v-flex>
                                                            <v-flex xs1></v-flex>
                                                            <v-flex xs5 md3 lg2>
                                                                <v-text-field prepend-icon="unfold_more" :rules="heightRules()" v-model="creativeAttributes.h" type="number" placeholder="H"></v-text-field>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md3 class="valign-wrapper">
                                                                <span class="title">Responsive</span><br>
                                                                <p class="caption ma-0">Is this creative responsive?</p>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-switch :false-value="0" :true-value="1" v-model="responsiveData" label="Responsive"></v-switch>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-flex>
                                                </v-layout>
                                                <v-divider></v-divider>
                                                <v-layout row wrap>
                                                    <v-flex xs12 class="valign-wrapper mt-4">
                                                        <span class="subheading">ADVANCED (Optional)</span>
                                                    </v-flex>
                                                </v-layout>
                                                <v-layout row wrap class="mt-4">
                                                    <v-flex xs12 md3 lg2 class="valign-wrapper">
                                                        <span class="title">Click-Through URL</span><br>
                                                        <span class="caption ma-0">Click-through url per creative</span>
                                                    </v-flex>    
                                                    <v-flex xs12 md9>
                                                        <v-text-field prepend-icon="language" :rules="domainRules()" v-model="creativeAttributes.url" placeholder="URL"></v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                                <v-layout row wrap class="mt-4">
                                                    <v-flex xs12 md3 lg2 class="valign-wrapper">
                                                        <span class="title">Ad Markup</span><br>
                                                        <p class="caption ma-0">Set iframe or HTML markup</p>
                                                    </v-flex>
                                                    <v-flex xs12 md9>
                                                        <v-text-field prepend-icon="language" placeholder="Ad Markup"></v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-text>
                                    <v-divider></v-divider>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn @click="showModal = false" class="elevation-0">
                                            <v-icon>close</v-icon>                                    
                                            Cancel
                                        </v-btn>
                                        <v-btn v-if="checkDimensions() == true" :loading="loading" primary :disabled="!(validClass && validWidth && validHeight && validName && validUrl && validFolder)" @click="loading = true, uploadCreative()" class="elevation-0">
                                            <v-icon>done</v-icon>
                                            Save
                                        </v-btn>
                                        <v-dialog v-else v-model="showModalDimensionsCheck" lazy absolute width="100%">
                                            <v-btn slot="activator" :loading="loading" primary :disabled="!(validClass && validWidth && validHeight && validName && validUrl && validFolder)" @click="showModal = false" class="elevation-0">
                                                <v-icon>done</v-icon>
                                                Save
                                            </v-btn>
                                            <v-card>
                                                <v-card-title>
                                                    <h4>Custom Creative Size</h4>
                                                </v-card-title>
                                                <v-divider></v-divider>
                                                <v-card-text>
                                                    <span>Are you sure you want to upload a creative with dimensions that are not up to IAB standard</span>
                                                </v-card-text>
                                                <v-divider></v-divider>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn @click="showModal = false" class="elevation-0">
                                                        <v-icon>close</v-icon>                                    
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn :loading="loading" primary :disabled="!(validClass && validWidth && validHeight && validName && validUrl && validFolder)" @click="loading = true, uploadCreative()" class="elevation-0">
                                                        <v-icon>done</v-icon>
                                                        Save
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </v-card-actions>
                                </v-card>   
                            </v-dialog>
                        </v-flex>
                        <v-flex xs12 md2 lg7>
                            <v-dialog v-model="showModal1" lazy absolute width="500px">
                                <v-btn v-if="!currentFolder.id" slot="activator" class="elevation-0">
                                    <v-icon>create_new_folder</v-icon> &nbsp;&nbsp;
                                     New Folder
                                </v-btn>
                                <v-card>
                                    <v-card-title>
                                        <h4>Create a Folder</h4>
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        <v-layout row wrap class="pl-5 pr-5">
                                            <v-flex xs12>
                                                <v-flex xs12 class="valign-wrapper">
                                                    <span class="title">Folder Name</span>
                                                    <p class="caption">The name of the newly created folder</p>
                                                </v-flex>
                                                <v-layout row wrap class="mt-2">
                                                    <v-flex xs12>
                                                        <v-text-field
                                                        label="Folder"
                                                        prepend-icon="folder"
                                                        v-model="newFolder"
                                                        ></v-text-field>
                                                    </v-flex>
                                                </v-layout>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-text>
                                    <v-divider></v-divider>
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
                    <v-divider></v-divider>
                    <v-card-text v-if="folderLoader == true">
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-text>
                    <v-card-text v-else-if="!currentFolder.id">
                        <v-layout row wrap>
                            <v-flex xs12 md10 lg8>
                                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">
                                {{alertMessage}}
                                </v-alert>
                                <v-data-table :items="filteredFolders" hide-actions class="no-headers creatives-explorer">
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr :active="props.selected" @click="openFolder(props.item.id)">
                                            <td width="40" class="text-xs-right">
                                                <v-icon>folder</v-icon>
                                            </td>
                                            <td class="text-xs-left">
                                                <span class="title">{{ props.item.id.name }}</span>
                                            </td>
                                            <td class="text-xs-right">
                                                <v-dialog v-model="props.item.modal" lazy absolute width="400px">
                                                    <v-btn icon class="grey--text" @click="deleteFolderId = props.item.id.id, deleteFolderName = props.item.id.name" slot="activator">
                                                        <v-icon>delete</v-icon>
                                                    </v-btn>
                                                    <v-card>
                                                        <v-card-title>
                                                            <h4>Delete Folder</h4>
                                                        </v-card-title>
                                                        <v-divider></v-divider>
                                                        <v-card-text>
                                                            <v-layout row wrap>
                                                                <v-flex xs12 md12 class="valign-wrapper px-4">
                                                                    <span class="">Please, make sure that your folder is empty and that the creatives are not used in any campaigns.</span>
                                                                    <br><br>
                                                                    <span>To proceed with deleting folder: {{deleteFolderName | uppercase}}, click DELETE below.</span><br>
                                                                </v-flex>
                                                            </v-layout>
                                                        </v-card-text>
                                                         <v-divider></v-divider>
                                                        <v-card-actions>
                                                            <v-spacer></v-spacer>
                                                            <v-btn class="elevation-0" @click="props.item.modal = false">
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
                    <v-card-text v-else-if="creativesLoader == true">
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-breadcrumbs divider="/" class="left pa-0">
                                    <v-breadcrumbs-item>
                                        <span @click="closeFolder(), imageSource='', sample='sample'">ROOT</span>
                                    </v-breadcrumbs-item>
                                    <v-breadcrumbs-item>
                                        {{ currentFolder.name | uppercase}}
                                    </v-breadcrumbs-item>
                                </v-breadcrumbs>
                            </v-flex>
                        </v-layout>
                        <v-layout row wrap>
                            <v-flex xs12 md9>
                                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                                <v-data-table :items="filteredCreatives" hide-actions class="creatives-explorer no-headers" v-bind:rows-per-page-items="[10, 25, { value: -1 }]">
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <tr 
                                        @mouseenter="imageSource = props.item.id.thumb, sample= props.item.id.name, statusShow = props.item.id.approved, 
                                        typeShow = props.item.id.class, dimensionsShow = props.item.id.w + 'x' + props.item.id.h"
                                        @mouseleave="imageSource = '', sample='sample', statusShow = '', 
                                        typeShow = 'TYPE', dimensionsShow = ''"
                                        >
                                            <td class="text-xs-left">
                                                <span class="title">{{ props.item.id.name }}</span><br>
                                                <span class="caption">{{ props.item.id.id }}</span>
                                            </td>
                                            <td>
                                                <v-chip v-if="props.item.id.approved == 'approved'" small class="green lighten-1 white--text">
                                                    <small>APPROVED</small>
                                                </v-chip>
                                                <v-chip v-else-if="props.item.id.approved == 'pending'" small class="yellow darken-1 white--text">
                                                    <small>PENDING</small>
                                                </v-chip>
                                                <v-chip v-else small class="red lighten-1 white--text">
                                                    <small>DECLINED</small>
                                                </v-chip>
                                            </td>
                                            <td>
                                                {{ props.item.id.class | uppercase }}
                                            </td>
                                            <td>
                                                {{ props.item.id.w }} x {{ props.item.id.h }}
                                            </td>
                                            <td>
                                                <v-dialog v-model="props.item.modal" lazy absolute width="70%">
                                                    <v-btn icon class="grey--text" @click="deleteCreativeId = props.item.id.id, deleteCreativeName = props.item.id.name" slot="activator">
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
                                                            <v-btn class="elevation-0" @click="props.item.modal = false">
                                                                <v-icon>close</v-icon>                                   
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn primary dark class="elevation-0" @click="deleteCreative(deleteCreativeId, deleteCreativeName), props.item.modal=false">
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
                            <v-flex xs12 md3 class="valign-wrapper mt-4">                                
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

    import Dropzone from 'dropzone';

    export default {
        created() {
           this.$root.isLoading = true;
        },

        mounted() {
           this.$root.isLoading = false;
           console.log(this.deleteCreatives);
        },
        props: ['token', 'user'],
        data() {
            return {
                showModalDimensionsCheck: false,
                validName: false,
                validHeight: false,
                validWidth: false,
                validUrl: false,
                validFolder: false,
                validClass: false,
                validFile: false,
                responsiveData: 0,
                sample: 'sample',
                dimensionsShow: '',
                typeShow: '',
                statusShow: '',
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
                    responsive: 0,
                    h: 0,
                    w: 0,
                    class: 'banner',
                },
                thumb: '',
                search: '',
                loading: false,
                folderCreatives: [],
                trueFolders: [],
                folderLoader: true,
                creativesLoader: true
            }
        },
        
        methods: {
            defineCreatives() {
                var creatives = this.creatives.data;
                var boolCreatives = [];
                for(var c in creatives) {
                    boolCreatives.push({"id": creatives[c], "modal": false});
                }
                this.folderCreatives = boolCreatives;
            },

            defineFolders() {
                var folders = this.folders.data;
                var boolFolders = [];
                for(var f in folders) {
                    boolFolders.push({"id": folders[f], "modal": false});
                }
                this.trueFolders = boolFolders;
            },

            creativeNameRules() {
                var name = ['too short'];
                if(this.creativeAttributes.name.length < 4) {
                    this.validName = false;
                    return name;
                }
                else this.validName = true;
            },

            domainRules() {
                var url = ['not a valid url'];
                if((this.creativeAttributes.url.startsWith("http://") && this.creativeAttributes.url.includes("."))|| (this.creativeAttributes.url.startsWith("https://") && this.creativeAttributes.url.includes("."))) {
                    this.validUrl = true;
                }
                
                else {
                    this.validUrl = false;
                    return url;
                }
            },

            heightRules() {
                var dimensions = ['This must be filled in'];
                
                if(this.creativeAttributes.h == '') {
                    this.validHeight = false;
                    return dimensions;
                }
                else {
                    this.validHeight = true;
                }
            },

            widthRules() {
                var dimensions = ['This must be filled in'];
                
                if(this.creativeAttributes.w == '') {
                    this.validWidth = false;
                    return dimensions;
                }
                else {
                    this.validWidth = true;
                }
            },

            folderRules() {
                var folder = ['folder must be selected'];
                if(this.folderId == '') {
                    this.validFolder = false;
                    return folder;
                }
                else this.validFolder = true;
            },

            classRules() {
                var crClass = ['must be selected'];
                if(this.creativeAttributes.class == '') {
                    this.validClass = false;
                    return crClass;
                }
                else this.validClass = true;
            },

            setTimeout(value) {
                setTimeout(value, 500);
            },

            getFolders() {
                this.folderLoader = true;
                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {

                    this.folders = response.data;
                    this.folderLoader = false;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Bim';
                    this.folderLoader = false;
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
                    autoProcessQueue: false,
                    thumbnailWidth: 120,
                    thumbnailHeight: 120
                });

                this.dropzone.on("addedfile", function(file, thumb) {
                    var sizeInterval = setInterval(function () {
                        if(typeof file.width != 'undefined') {
                            console.log(file);
                            this.validFile = true;

                            this.creativeAttributes = {
                                w: file.width, 
                                h: file.height, 
                                name: file.name.slice(0,file.name.lastIndexOf('.')), 
                                class: 'banner',
                                url: '',
                                responsive: 0
                            };
                            clearInterval(sizeInterval);
                        }
                    }.bind(this), 1000);
                }.bind(this));

                this.dropzone.on("thumbnail", function(file, thumb) {
                    this.thumb = thumb;
                }.bind(this));
            },

            openFolder(folderObj) {
                this.creativesLoader = true;
                this.currentFolder = folderObj;
                this.getFolderCreatives(folderObj.id);
                this.folderId = this.currentFolder.key;
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
                this.folderId = 0;
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
                axios.delete(this.$root.uri + '/creatives/' + creativeId, this.$root.config).then(response => {
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
                    this.creativesLoader = false;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Bam';
                    this.creativesLoader = false;
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
                    thumb: this.thumb
                };
                this.dropzone.processQueue();
                
                    this.dropzone.on("complete", function (file) {
                        if (file.status == 'success') {
                            this.dropzone.removeFile(file);
                            this.alert = true;
                            this.error = false;
                            this.success = true;
                            this.alertMessage = 'Uploaded successfully';
                            this.loading = false;
                            this.showModal = false;
                            this.showModalDimensionsCheck = false;

                            setTimeout(function () {
                                this.alert = false;
                            }.bind(this), 2000);

                            if(typeof this.currentFolder.id == 'string') {
                                this.getFolderCreatives(this.currentFolder.id);
                            } else {
                                this.getFolders();
                            }
                        } 
                        else {
                            this.alert = true;
                            this.error = true;
                            this.success = false;
                            this.loading = false;
                            this.showModal = false;
                            this.alertMessage = 'Please choose a folder you wish to upload a creative to.';
                        }
                    }.bind(this));
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

                    setTimeout(function () {
                        this.alert = false;
                    }.bind(this), 2000);
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
                if(!this.folderCreatives) return this.folderCreatives;
                var creatives = this.folderCreatives;
                var result = [];
                var search = this.search;
                for(var c in creatives) {
                    var name = creatives[c].id.name.toLowerCase();
                    var searchLower = search.toLowerCase();
                    if(name.includes(searchLower)) {
                        result.push(creatives[c]);
                    }
                }
                return result;
            },

            filteredFolders() {
                if(!this.folders) return this.folders;
                var search = this.search;
                var folders = this.trueFolders;
                var result = [];
                for(var f in folders) {
                    var name = folders[f].id.name.toLowerCase();
                    var searchLower = search.toLowerCase();
                    if(name.includes(searchLower)) {
                        result.push(folders[f]);
                    }    
                }
                return result;
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

            },
            responsiveData(value) {
                this.creativeAttributes.responsive = value;
            },

            folders(value) {
                this.folderId = value.data[0].key;
                this.defineFolders();
            },
            creatives(value) {
                this.defineCreatives();
            }
        }
    }
</script>
<style type="text/css">
    .dz-preview {
        display:none;
    }
</style>
