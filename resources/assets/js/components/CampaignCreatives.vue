<template>
    <div>
        <!-- FOLDERS -->
        <div class="col-sm-12" v-show="!folder.id">
            <legend><i class="fa fa-fw fa-picture-o"></i> Select a Folder</legend>
            <div class="row form-group actions-toolbar">
                <div class="col-sm-12">
                    <div class="icon-addon addon-sm pull-right">
                        <label class="glyphicon glyphicon-search"></label>                        
                        <input id="creatives-search-1"
                               name="creatives-search-1"
                               class="form-control input-sm"
                               placeholder="Search"
                               type="text"
                               v-model="search">
                    </div>
                    <div class="btn-group btn-group-sm pull-right">
                       
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="col-md-2 col-sm-3 col-xs-6 creatives-closed"  v-for="(item, index) in folders.data">
						<span class="badge">{{ item.items }}</span>
                        <a href="javascript;" @click="openFolder(item)" onclick="return false;">
                            <img src="/img/folder-closed.png">
                            <br><span>{{ item.name }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- CREATIVES -->
        <div class="col-sm-12" v-show="folder.id">
            <legend><i class="fa fa-fw fa-picture-o"></i> Select Creatives</legend>
            <div class="row actions-toolbar">
                <div class="col-md-6 col-sm-12">
                    <div class="back pull-left">
                        <a href="" name="creatives-back" @click="closeFolder" onclick="return false;">
                            <i class="fa fa-2x fa-arrow-left"></i>
                        </a>
                    </div>
                    <div class="creatives-open" @click="closeFolder()">
                        <img src="/img/folder-open.png">
                        <span></span>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="search pull-right">
                        <input id="creatives-search-2" name="creatives-search-2" class="form-control" placeholder="Search" type="text">
                    </div>
                </div>
            </div>
            <table id="dt_basic" class="table table-creatives table-striped table-hover" width="100%">
                <thead>
                    <tr class="hidden">
                        <th align="right"></th>
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
                    <tr>
                        <td colspan="8" v-show="!folder.items">
                            <strong>Sorry, there are no creatives in this folder.</strong>
                        </td>
                    </tr>
                    <tr v-for="(creative, index) in creatives.data" :data-tr-id="index + '-item'">
                        <td align="right">
                            <label>
                                <input type="checkbox"
                                       class="checkbox style-orange"
                                       :value="creative.id"
                                       @click="addCreative(creative, index)"
                                       :data-item="creative.id" />
                                <span>&nbsp;</span>
                            </label>
                        </td>
                        <td>{{ creative.id }}</td>
                        <td>Banner</td>
                        <td>{{ creative.type }}</td>
                        <td>HTML5</td>
                        <td>M Rect.</td>
                        <td><span :class="renderCreativeStatusAsIcon(creative.status)"></span></td>
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
</template>

<script>
    export default {
        mounted() {
            console.log('Creatives component mounted.');
        },

        props: ['campaign', 'state', 'folder'],

        data() {
            return {
                folders: {},
                creatives: {}
            }
        },

        methods: {

            openFolder(folderObj) {

                this.$emit('folderChanged', {folder: folderObj});

                axios.get(this.$root.uri + '/creatives/folders/' + folderObj.id, this.$root.config).then(response => {
                    this.creatives = this.$parent.__toObject(response.data);
                }, error => {
                    alert(error);
                });

                return false;
            },

            closeFolder(e) {

                this.creatives = {};
                this.$emit('folderChanged', {folder: {}});
                return false;
            },

            addCreative(creative, index)  {

                if($('tr[data-tr-id="' + index + '-item"]').find('input[type="checkbox"]').is(':checked'))
                {
                        this.campaign.creatives.data.push(creative);
                } else {
                    for(var i in this.campaign.creatives.data) {
                        if(this.campaign.creatives.data[i].id == creative.id) {
                           this.campaign.creatives.data.splice(i, 1)
                        }
                    }
                }
            },

            fetchFolders() {

                axios.get(this.$root.uri + '/creatives/folders', this.$root.config).then(response => {
                    this.folders = response.data;
                }, error => {
                    console.log(error);
                });
            },

            pushStack(item) {
                var cat = $('.creatives-list').find('input[data-item="' + item + '"]');

                if(cat.is(':checked')) {
                    this.$parent.creatives.push(item);
                } else {
                    var obj = this;
                    this.$parent.creatives.forEach(function(val, index) {
                        if(val == item) delete obj.$parent.creatives.splice(index, 1);
                    });
                }
            },

            renderCreativeStatusAsIcon(status) {

                return (status) ? 'fa fa-fw fa-check green' : 'fa fa-fw fa-times red';
            },

            openCreative(src) {
                window.open(src);
            }
        },

        watch: {

            state(value) {
                this.fetchFolders();
            }
        }
    }
</script>
