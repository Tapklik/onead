<template>
    <div>
        <div class="widget-body">
            <div class="row clearfix well" v-show="createFolderFlag">
                <div class="col-xs-6">
                    <h3>Create New Folder</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <input type="text" class="form-control" v-model="newFolder"  placeholder="Cool folder" />
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <button class="btn btn-default" @click="storeNewFolder()">
                                    <span class="fa fa-pencil"></span>
                                    Create
                                </button>
                                <button class="btn btn-danger" @click="createFolderFlag = false">
                                    <span class="fa fa-trash"></span>
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p>&nbsp;</p>

            <div class="row actions-toolbar" v-show="!currentFolder.id">
                <div class="col-sm-6">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-default" @click="createNewFolder()" :disabled="createFolderFlag">
                            <i class="fa fa-fw fa-plus-square-o"></i> New Folder
                        </button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="icon-addon addon-sm pull-right">
                        <label class="glyphicon glyphicon-search"></label>                        
                        <input id="campaigns-search-1"
                               name="campaigns-search-1"
                               class="form-control input-sm"
                               placeholder="Search"
                               type="text"
                               v-model="search">
                    </div>
                    <div class="btn-group btn-group-sm pull-right">
                        
                    </div>
                </div>
            </div>

            <div class="row actions-toolbar" v-show="currentFolder.id">
                <div class="col-sm-6">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-default" @click="closeFolder()" onclick="return false;">
                            <i class="fa fa-fw fa-arrow-left"></i> Back
                        </button>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-primary" @click="showModal = true" :disabled="createFolderFlag">
                            <i class="fa fa-fw fa-arrow-up"></i> Upload Creatives
                        </button>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="icon-addon addon-sm pull-right">
                        <label class="glyphicon glyphicon-search"></label>                        
                        <input id="campaigns-search-1"
                               name="campaigns-search-1"
                               class="form-control input-sm"
                               placeholder="Search"
                               type="text"
                               v-model="search">
                    </div>
                    <div class="btn-group btn-group-sm pull-right">
                        
                    </div>
                </div>
            </div>            

            <div id="dt_basic_wrapper" class="dataTables_wrapper form-inline no-footer">
                <div class="row" v-show="showCreateFolder">
                    <h3></h3>
                    <div class="col-xs-4">
                        <input type="text" class="form-control" placeholder="Type folder name..." style="width: 100%" v-model="folderName"/>
                    </div>
                    <div class="col-xs-3">
                        <button class="btn btn-default" @click="createFolder()">
                            Create Folder
                        </button>
                    </div>
                </div>

                <div class="row" v-show="!currentFolder.id">
                    <p>&nbsp;</p>
                    <div class="col-sm-12">
                        <legend><i class="fa fa-fw fa-folder"></i> Media Repository</legend>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-md-2 col-sm-3 col-xs-6 creatives-closed"  v-for="folder in folders.data">
                            <span class="badge">{{ folder.items }}</span>
                            <a href="#" @click="openFolder(folder)" onclick="return false;">
                                <img src="/img/folder-closed.png">
                                <br><span>{{ folder.name }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row" v-show="currentFolder.id">
                    <div class="col-xs-12 padd">
                        <p>&nbsp;</p>
                        <p>Upload creatives to <strong>/media/{{ currentFolder.name }}/</strong></p>
                    </div>

                    <div class="col-xs-12">
                        <legend><i class="fa fa-fw fa-picture-o"></i> List of Creatives</legend>

                        <table id="dt_basic" class="table table-creatives table-striped table-hover" width="100%">
                            <thead>
                            <tr class="hidden">
                                <th data-hide="phone">ID</th>
                                <th data-class="expand">Type</th>
                                <th>Size</th>
                                <th data-hide="phone">File</th>
                                <th data-hide="phone,tablet">IAB</th>
                                <th data-hide="phone,tablet">Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody class="creatives-list">
                            <tr v-for="creative in creatives.data">
                                <td>{{ creative.id }}</td>
                                <td>Banner</td>
                                <td>{{ creative.ctrurl }}</td>
                                <td>HTML5</td>
                                <td>M Rect.</td>
                                <td>
                                    <span :class="renderIconFromStatus(creative.approved)"></span>
                                </td>
                                <td>
                                    <a class="btn btn-success btn-xs" @click="openCreative(creative.iurl)">&nbsp;
                                        <i class="fa fa-fw fa-picture-o"></i>&nbsp;Preview&nbsp;
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <modal title="Upload Creatives" v-model="showModal" :large="true" @ok="uploadCreative();">
            <div class="row form-group form-group-height">
                 <div class="col-sm-12">
                    <legend><i class="fa fa-fw fa-arrow-circle-o-up"></i> Upload Creatives</legend>
                </div>
                <div class="col-sm-12">
                    <div id="uploader" class="text-center well">
                        DROP FILES HERE
                    </div>
                </div>
            </div>
            <div class="row form-group form-group-height">
                 <div class="col-sm-12">
                    <legend><i class="fa fa-fw fa-arrow-circle-o-up"></i> Creative Basic Details</legend>
                </div>
                <div class="col-sm-8">
                    <div class="row form-group form-group-height">
                        <div class="col-sm-3">
                            <label class=" control-label" >Name</label>
                            <p class="help-block">Edit default name</p>
                        </div>
                        <div class="col-sm-7">
                            <div class="icon-addon addon-sm">
                                <label class="glyphicon glyphicon-pencil"></label>
                                <input type="text" class="form-control"
                                       placeholder="creative_01"
                                        v-model="creativeAttributes.name">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-height">
                        <div class="col-sm-3">
                            <label class=" control-label" >Creative Class</label>
                            <p class="help-block">(Banner, Video, Native)</p>
                        </div>
                        <div class="col-sm-5">
                            <div class="icon-addon addon-sm">
                                <label class="glyphicon glyphicon-globe"></label>
                                <select class="form-control" v-model="creativeAttributes.class">
                                    <option value="banner">Banner</option>
                                    <option value="video">Video</option>
                                    <option value="native">Native</option>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="row form-group form-group-height">
                        <div class="col-sm-3">
                            <label class=" control-label" >Dimensions (W x H)</label>
                            <p class="help-block">Edit default dimensions</p>
                        </div>
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <div class="icon-addon addon-sm">
                                        <label class="glyphicon glyphicon-resize-horizontal"></label>
                                        <input type="text" class="form-control"
                                               placeholder="Width"
                                                v-model="creativeAttributes.w"/>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="icon-addon addon-sm">
                                        <label class="glyphicon glyphicon-resize-vertical"></label>
                                        <input  type="text" class="form-control"
                                               placeholder="Height"
                                                v-model="creativeAttributes.h"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <p>&nbsp;</p>
                                    <label>
                                        <input type="checkbox" class="checkbox style-orange" >
                                        <span>Responsive</span> 
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row form-group form-group-height">
                 <div class="col-sm-12">
                    <legend><i class="fa fa-fw fa-arrow-circle-o-up"></i> Advanced (Optional)</legend>
                </div>
                <div class="col-sm-12">
                    <div class="row form-group form-group-height">
                        <div class="col-sm-3">
                            <label class=" control-label" >Click-through URL</label>
                            <p class="help-block">Click through URL per creative</p>
                        </div>
                        <div class="col-sm-6">
                            <div class="icon-addon addon-sm">
                                <label class="glyphicon glyphicon-globe"></label>
                                <input type="url" class="form-control"
                                       placeholder="http://www.company.com/landing"
                                        v-model="creativeAttributes.url">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group form-group-height">
                        <div class="col-sm-3">
                            <label class=" control-label" >Ad markup</label>
                            <p class="help-block">Set iframe or HTML markup</p>
                        </div>
                        <div class="col-sm-8">
                            <div class="icon-addon addon-sm">
                                <label class="glyphicon glyphicon-globe"></label>
                                <textarea rows="3" class="form-control"
                                       placeholder="Ad markup..."> </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</template>
<script>

    export default {
        mounted() {

            this.token = this.$root.getApiToken();
        },

        data() {
            return {
                showModal: false,
                token: {},
                dropzone: false,
                newFolder: '',
                folders: {
                    data: {}
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

            openFolder(folderObj) {

                this.currentFolder = folderObj;

                this.getFolderCreatives(this.currentFolder.id);
            },

            closeFolder() {

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

                });
            },

            openModal() {
                this.$root.modalIsOpen = true;
                return false;
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

        watch: {
            token(value) {

                if(typeof value != 'undefined') {
                    this.getFolders();

                    this.dropzone = new Dropzone("div#uploader", {
                        url: this.$root.uri + '/creatives',
                        paramName: 'file',
                        maxFilesize: 2,
                        headers: {'Authorization': "Bearer " + this.token},
                        autoProcessQueue: false
                    });
                }
            }
        }
    }
</script>
