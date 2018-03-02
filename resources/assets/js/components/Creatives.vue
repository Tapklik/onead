<template>
    <v-container fluid grid-list-xs>

        <!-- CARD START -->
        <v-card class="elevation-2">
            <v-divider></v-divider>
            <v-card-title>

                <!-- ACTIONS START -->
                <v-flex xs12 md7>

                    <!-- ADD CREATIVE START -->
                    <v-btn @click="showNoFoldersError()" primary dark class="elevation-0" v-if="folders == ''">
                        <v-icon>add</v-icon>
                        Add Creatives
                    </v-btn>
                    <v-dialog v-else v-model="show_new_creative_modal" lazy absolute width="100%">
                        <v-btn slot="activator" primary dark class="elevation-0">
                            <v-icon>add</v-icon>
                            Add Creatives
                        </v-btn>
                        <v-card>
                            <v-card-title>
                                <h4>Upload Creatives Here</h4>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text class="pr-5 pl-5">
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
                                            <div 
                                            class="uploader-title" 
                                            v-if="new_file_status == 'empty'"
                                            >
                                                <v-icon>cloud_upload</v-icon> 
                                                Drop Files Here
                                            </div>
                                            <div 
                                            class="uploader-title" 
                                            v-else-if="new_file_status == 'nofile'"
                                            >
                                                <v-icon>cancel</v-icon>
                                                No File Found
                                            </div>
                                            <div 
                                            class="uploader-title" 
                                            v-else
                                            >
                                                <v-icon>check</v-icon> 
                                                File Uploaded
                                            </div>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                                <v-divider class="mt-4"></v-divider>
                                <v-layout row wrap class="mt-2">
                                    <v-flex xs12 class="valign-wrapper mt-4">
                                        <span class="subheading">
                                            CREATIVE BASIC DETAILS
                                        </span>
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
                                                <v-text-field 
                                                prepend-icon="mode_edit" 
                                                v-model="new_creative.name" 
                                                placeholder="Name" 
                                                :rules="nameRules()" 
                                                @keyup="checkFile()"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap class="mt-4">
                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                <span class="title">Ad Group</span><br>
                                                <p class="caption ma-0">
                                                    The Ad group where your creative will be uploaded
                                                </p>
                                            </v-flex>
                                            <v-flex xs12 md5>
                                                <v-select 
                                                :rules="folderRules()" 
                                                prepend-icon="folder" 
                                                :items="folders" 
                                                item-text="name" 
                                                item-value="key" 
                                                v-model="new_creative.folder" 
                                                placeholder="Ad Group" 
                                                @change="checkFile()"
                                                ></v-select>
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
                                                <v-select 
                                                prepend-icon="photo" 
                                                :items="classes" 
                                                v-model="new_creative.class" 
                                                :rules="classRules()" 
                                                @change="checkFile()"
                                                ></v-select>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap class="mt-4">
                                            <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                <span class="title">Dimensions (W x H)</span><br>
                                                <p class="caption ma-0">Edit default dimensions in px</p>
                                            </v-flex>
                                            <v-flex xs5 md3 lg2>
                                                <v-text-field 
                                                prepend-icon="code" 
                                                :rules="widthRules()" 
                                                v-model="new_creative.w" 
                                                type="number" 
                                                placeholder="W" 
                                                @keyup="checkFile()"
                                                ></v-text-field>
                                            </v-flex>
                                            <v-flex xs1></v-flex>
                                            <v-flex xs5 md3 lg2>
                                                <v-text-field 
                                                prepend-icon="unfold_more" 
                                                :rules="heightRules()" 
                                                v-model="new_creative.h" 
                                                type="number" 
                                                placeholder="H" 
                                                @keyup="checkFile()"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                        <v-layout row wrap class="mt-4">
                                            <v-flex xs12 md3 class="valign-wrapper">
                                                <span class="title">Responsive</span><br>
                                                <p class="caption ma-0">Is this creative responsive?</p>
                                            </v-flex>
                                            <v-flex xs12 md6>
                                                <v-switch 
                                                :false-value="0" 
                                                :true-value="1" 
                                                v-model="new_creative.responsive" 
                                                label="Responsive" 
                                                @change="checkFile()"
                                                ></v-switch>
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
                                        <v-text-field 
                                        prepend-icon="language" 
                                        v-model="new_creative.url" 
                                        placeholder="URL" 
                                        @keyup="checkFile()"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                                <v-layout row wrap class="mt-4">
                                    <v-flex xs12 md3 lg2 class="valign-wrapper">
                                        <span class="title">Ad Markup</span><br>
                                        <p class="caption ma-0">Set iframe or HTML markup</p>
                                    </v-flex>
                                    <v-flex xs12 md9>
                                        <v-text-field 
                                        prepend-icon="language" 
                                        placeholder="Ad Markup" 
                                        @keyup="checkFile()"
                                        ></v-text-field>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn 
                                @click="show_new_creative_modal = false,
                                clearUploadModal()" 
                                class="elevation-0"
                                >
                                    <v-icon>close</v-icon>                                    
                                    Cancel
                                </v-btn>
                                <v-btn 
                                v-if="iab_standard_sizes.includes(dimensions) || !validCreative()" 
                                :loading="new_creative_button_loading" 
                                primary 
                                :disabled="!validCreative()" 
                                @click="new_creative_button_loading = true, 
                                uploadCreative()" 
                                class="elevation-0"
                                >
                                    <v-icon>done</v-icon>
                                    Save
                                </v-btn>
                                <v-dialog 
                                v-else
                                v-model="show_confirmation_modal"  
                                lazy
                                absolute 
                                width="400px"
                                >
                                    <v-btn  
                                    primary 
                                    slot="activator"
                                    @click="show_new_creative_modal = false"
                                    >
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                    <v-card>
                                        <v-card-text>
                                            <v-layout row wrap>
                                                <v-flex xs12 class="valign-wrapper px-4 error-icon">
                                                    <span>
                                                        <v-icon 
                                                        x-large 
                                                        primary
                                                        >
                                                            help
                                                        </v-icon>
                                                    </span>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap>
                                                <v-flex xs12 md12 class="valign-wrapper px-4">
                                                    <span class="">
                                                        Are you sure you want to upload a creative that is not up to IAB standard?
                                                    </span><br>
                                                </v-flex>
                                            </v-layout>
                                        </v-card-text>
                                        <v-divider></v-divider>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn 
                                            class="elevation-0" 
                                            @click="show_confirmation_modal = false,
                                            clearUploadModal()"
                                            >
                                                <v-icon>close</v-icon>
                                                Cancel
                                            </v-btn>
                                            <v-btn 
                                            primary 
                                            dark 
                                            class="elevation-0" 
                                            :loading="new_creative_button_loading"
                                            @click="show_confirmation_modal = false, 
                                            uploadCreative()"
                                            >
                                                <v-icon>done</v-icon>
                                                OK
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-card-actions>
                        </v-card>   
                    </v-dialog>
                    <!-- ADD CREATIVE END -->

                    <!-- ADD FOLDER START -->
                    <v-dialog v-model="show_new_folder_modal" lazy absolute width="500px">
                        <v-btn 
                        v-if="!current_folder.id" 
                        slot="activator" 
                        class="white elevation-0"
                        >
                            <v-icon>create_new_folder</v-icon>&nbsp;
                            New Ad Group
                        </v-btn>
                        <v-card>
                            <v-card-title>
                                <h4>Create New Ad Group</h4>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-card-text>
                                <v-layout row wrap class="pl-5 pr-5">
                                    <v-flex xs12>
                                        <v-flex xs12 class="valign-wrapper">
                                            <span class="title">Ad Group Name</span>
                                            <p class="caption">The name of the newly created Ad group</p>
                                        </v-flex>
                                        <v-layout row wrap class="mt-2">
                                            <v-flex xs12>
                                                <v-text-field
                                                label="Ad Group"
                                                prepend-icon="folder"
                                                v-model="new_folder.name"
                                                ></v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-divider></v-divider>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn 
                                class="elevation-0" 
                                @click="show_new_folder_modal = false"
                                >
                                    <v-icon>close</v-icon>                                    
                                    Cancel
                                </v-btn>
                                <v-btn 
                                primary 
                                dark 
                                class="elevation-0" 
                                @click="createNewFolder(), show_new_folder_modal=false"
                                >
                                    <v-icon>done</v-icon>
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>   
                    </v-dialog>
                    <!-- ADD FOLDER END -->

                </v-flex>
                <v-flex xs12 md5>
                    <v-layout row wrap>
                        <v-spacer></v-spacer>
                        <v-flex xs12 md6>
                            <v-text-field 
                                label="Search..."
                                append-icon="search"
                                single-line 
                                hide-details 
                                class="right" 
                                v-model="search_creatives_and_folders">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-card-title>
            <!-- ACTIONS END -->

            <v-divider></v-divider>

            <!-- FOLDERS START -->
            <!-- FOLDERS LOADER START -->
            <v-card-text v-if="folders_table_loading">
                <scale-loader 
                :loading="true" 
                color="#9e9e9e" 
                height="15px" 
                width="3px" 
                class="mt-5"
                ></scale-loader>
            </v-card-text>
            <!-- FOLDERS LOADER END -->

            <v-card-text v-else-if="!current_folder.id">
                <v-layout row wrap>
                    <v-flex xs12 md10 lg8>
                        <v-data-table
                        no-data-text="Create your first Ad Group by clicking above!"
                        :items="filteredFolders" 
                        hide-actions 
                        class="no-headers creatives-explorer"
                        >
                            <template slot="headers" scope="props">
                                &nbsp;
                            </template>
                            <template slot="items" scope="props">
                                <tr :active="props.selected">
                                    <td width="40" class="text-xs-right clickable" @click="openFolder(props.item)">
                                        <v-icon>folder</v-icon>
                                    </td>
                                    <td class="text-xs-left clickable" @click="openFolder(props.item)">
                                        <span class="title">{{ props.item.name }}</span>
                                    </td>
                                    <td class="text-xs-right">
                                        <v-btn 
                                        v-if="props.item.items == 0" 
                                        icon class="grey--text" 
                                        @click="deleteFolder(props.item.id, props.item.name)"
                                        >
                                                <v-icon>delete</v-icon>
                                        </v-btn>
                                        <v-dialog 
                                        v-else 
                                        v-model="props.item.show_modal" 
                                        lazy absolute 
                                        width="400px"
                                        >
                                            <v-btn icon class="grey--text" slot="activator">
                                                <v-icon>delete</v-icon>
                                            </v-btn>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout row wrap>
                                                        <v-flex xs12 class="valign-wrapper px-4 error-icon">
                                                            <span>
                                                                <v-icon x-large primary>cancel</v-icon>
                                                            </span>
                                                        </v-flex>
                                                    </v-layout>
                                                    <v-layout row wrap>
                                                        <v-flex xs12 md12 class="valign-wrapper px-4">
                                                            <span class="">
                                                                Please, make sure that your folder is empty.
                                                            </span>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                                 <v-divider></v-divider>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn 
                                                    class="elevation-0" 
                                                    @click="props.item.show_modal = false"
                                                    >
                                                        <v-icon>close</v-icon>
                                                        Cancel
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
            <!-- FOLDERS END -->

            <!-- CREATIVES START -->
            <!-- CREATIVES LOADER START -->
            <v-card-text v-else-if="creatives_table_loading">
                <scale-loader 
                :loading="true" 
                color="#9e9e9e" 
                height="15px" 
                width="3px" 
                class="mt-5"
                ></scale-loader>
            </v-card-text>
            <!-- CREATIVES LOADER END -->

            <v-card-text v-else>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-breadcrumbs divider="/" class="left pa-0">
                            <v-breadcrumbs-item>
                                <span @click="closeFolder()">ROOT</span>
                            </v-breadcrumbs-item>
                            <v-breadcrumbs-item>
                                {{ current_folder.name | uppercase}}
                            </v-breadcrumbs-item>
                        </v-breadcrumbs>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9>
                        <v-data-table 
                        no-data-text="Create a creative by clicking the Add Creative button above"
                        :items="filteredCreatives" 
                        hide-actions 
                        class="creatives-explorer no-headers" 
                        v-bind:rows-per-page-items="[10, 25, { value: -1 }]"
                        >
                            <template slot="headers" scope="props">
                                &nbsp;
                            </template>
                            <template slot="items" scope="props">
                                <tr
                                @mouseenter="togglePreview(props.item, true)"
                                @mouseleave="togglePreview(props.item, false)"
                                >
                                    <td class="text-xs-left">
                                        <span class="title">{{ props.item.name }}</span><br>
                                        <span class="caption">{{ props.item.id }}</span>
                                    </td>
                                    <td>
                                        <v-chip v-if="props.item.approved == 'approved'" small class="green lighten-1 white--text">
                                            <small>APPROVED</small>
                                        </v-chip>
                                        <v-chip v-else-if="props.item.approved == 'pending'" small class="yellow darken-1 white--text">
                                            <small>PENDING</small>
                                        </v-chip>
                                        <v-chip v-else small class="red lighten-1 white--text">
                                            <small>DECLINED</small>
                                        </v-chip>
                                    </td>
                                    <td>
                                        {{ props.item.class | uppercase }}
                                    </td>
                                    <td>
                                        {{ props.item.w }} x {{ props.item.h }}
                                    </td>
                                    <td>
                                        <v-dialog 
                                        v-model="props.item.show_preview" 
                                        lazy 
                                        :width="props.item.w + 80"
                                        max-width="100%"
                                        >
                                            <v-btn 
                                            icon 
                                            class="grey--text" 
                                            slot="activator">
                                                <v-icon>search</v-icon>
                                            </v-btn>
                                            <v-card>
                                                <v-card-title>
                                                    <h4>Preview</h4>
                                                </v-card-title>
                                                <v-divider></v-divider>
                                                <v-card-text>
                                                    <v-layout row wrap>
                                                        <v-flex 
                                                        xs12 
                                                        class="valign-wrapper px-4" 
                                                        v-html="getPreview(props.item)"
                                                        ></v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                                <v-divider></v-divider>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn 
                                                    class="elevation-0" 
                                                    @click="props.item.show_preview = false"
                                                    >
                                                        <v-icon>close</v-icon>
                                                        OK
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog 
                                        v-model="props.item.show_modal" 
                                        lazy 
                                        absolute width="400px"
                                        >
                                            <v-btn 
                                            icon 
                                            class="grey--text" 
                                            slot="activator">
                                                <v-icon>delete</v-icon>
                                            </v-btn>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout row wrap>
                                                        <v-flex xs12 class="valign-wrapper px-4 error-icon">
                                                            <span>
                                                                <v-icon x-large primary>help</v-icon>
                                                            </span>
                                                        </v-flex>
                                                    </v-layout>
                                                    <v-layout row wrap>
                                                        <v-flex xs12 md12 class="valign-wrapper px-4">
                                                            <span class="">
                                                                Are you sure you want to delete 
                                                                {{props.item.name | uppercase}}?
                                                            </span> <br>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                                <v-divider></v-divider>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn 
                                                    class="elevation-0" 
                                                    @click="props.item.show_modal = false"
                                                    >
                                                        <v-icon>close</v-icon>
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn 
                                                    primary 
                                                    dark 
                                                    class="elevation-0" 
                                                    @click="deleteCreative(props.item.id, props.item.name), 
                                                    props.item.show_modal=false"
                                                    >
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
                    
                    <!-- PREVIEW START -->
                    <v-flex xs12 md3 class="valign-wrapper mt-4">
                        <v-card class="elevation-0 left-border pl-3" height="500px">
                            <v-card-title>
                                <span class="title">Creative Details</span>
                            </v-card-title>
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <div class="preview">
                                            <img width="128" :src="creative_preview.thumbnail" />
                                        </div>
                                    </v-flex>
                                </v-layout>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <span> 
                                            {{creative_preview.name}}
                                        </span><br>
                                        <span class="grey--text">
                                            {{creative_preview.class | uppercase}}
                                        </span><br><br>
                                        <span class="caption">
                                            <b>Status:</b> 
                                            {{creative_preview.status | uppercase}}
                                        </span><br>
                                        <span class="caption">
                                            <b>Dimensions:</b> 
                                            {{creative_preview.dimensions}}
                                        </span>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                          </v-card>
                    </v-flex>
                    <!-- PREVIEW END -->

                </v-layout>
            </v-card-text>
            <!-- CREATIVES END -->

        </v-card>
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
                //OVERALL
                search_creatives_and_folders: '',
                dropzone: false,
                iab_standard_sizes: ['300x250','250x250','240x400','336x280','180x150','300x100','720x300','468x60','234x60','88x31','120x90','120x60','120x240','125x125','728x90','160x600','120x600','300x600'],
                classes: ['banner', 'video', 'native','html5'],

                //NEW CREATIVE
                new_file_status: 'empty',
                new_creative_button_loading: false,
                show_new_creative_modal: false,
                show_confirmation_modal: false,
                valid_new_creative: {
                    name: false,
                    h: false,
                    w: false,
                    folder: false,
                    class: false,
                    file: false
                },
                new_creative: {
                    name: '',
                    url: '',
                    responsive: 0,
                    h: 0,
                    w: 0,
                    class: 'banner',
                    folder: ''
                },
                thumbnail: '',

                //NEW FOLDER
                show_new_folder_modal: false,
                new_folder: {
                    name: '',
                    status: 0
                },

                //FOLDERS
                folders_table_loading: true,
                folders: [],

                //CREATIVES
                current_folder: {},
                creatives_table_loading: true,
                creative_preview: {
                    thumbnail: '',
                    name: '',
                    class: '',
                    status: '',
                    dimensions: ''
                },
                creatives: []
            }
        },

        methods: {
            //ESSENTIALS
            dropzoneMaker() {
                if (this.dropzone !== false) return;

                this.dropzone = new Dropzone("#uploader", {
                    url: this.$root.uri + '/creatives',
                    paramName: 'file',
                    maxFilesize: 2,
                    acceptedFiles: 'image/*, application/zip',
                    headers: {"Authorization": 'Bearer ' + this.token},
                    autoProcessQueue: false,
                    thumbnailWidth: 120,
                    thumbnailHeight: 120,
                    clickable: ['.uploader-title', '#uploader']
                });

                this.dropzone.on("addedfile", function(file, thumb) {
                    var is_zip = file.type.indexOf('zip') != -1 ? true : false;
                    var sizeInterval = setInterval(function () {
                        if(typeof file.width != 'undefined' || is_zip) {
                            this.valid_new_creative.file = true;
                            this.new_file_status = 'uploaded';

                            this.new_creative = {
                                w: is_zip ? 0 : file.width,
                                h: is_zip ? 0 : file.height,
                                name: file.name.slice(0,file.name.lastIndexOf('.')),
                                class: is_zip ? 'html5' : 'banner',
                                url: '',
                                responsive: 0,
                                folder: this.new_creative.folder
                            };
                            clearInterval(sizeInterval);
                        }
                    }.bind(this), 1000);
                }.bind(this));

                this.dropzone.on("thumbnail", function(file, thumb) {
                    this.thumbnail = thumb;
                }.bind(this));
            },

            changeFoldersAndCreativesData(data) {
                for(var index in data) Vue.set(data[index], 'show_modal', false); //add datapoint
                for(var index in data) Vue.set(data[index], 'show_preview', false); //add datapoint
                return data;
            },

            //NEW CREATIVE
            showNoFoldersError() {
                axios.get(
                    this.$root.uri + '/creatives/folders', 
                    this.$root.config
                ).then(response => {
                        if(response.data.data == '') {
                            this.$root.showAlertPopUp('error', 'You have no ad groups. You should create an ad group in the creatives tab by pressing the "New Ad Group" button');
                        }
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Error fetching folders.');
                    }
                );
            },

            uploadCreative() {
                this.dropzone.options.params = {
                    folder_id: this.new_creative.folder,
                    name: this.new_creative.name,
                    ctrurl: this.new_creative.url,
                    w: this.new_creative.w,
                    h: this.new_creative.h,
                    responsive: this.new_creative.responsive,
                    class: this.new_creative.class,
                    thumb: this.thumbnail
                };
                this.dropzone.processQueue();

                this.dropzone.on("complete", function (file) {
                    if (file.status == 'success') {
                        this.clearUploadModal();
                        this.new_file_status = 'empty';
                        this.show_new_creative_modal = false;
                        this.new_creative_button_loading = false;

                        if(file.status != 'success') {
                            this.$root.showAlertPopUp('error', 'Error uploading the creative.');
                        }
                        else {
                            this.$root.showAlertPopUp('success', 'Uploaded successfully');
                            if(this.current_folder.id) this.getFolderCreatives(this.current_folder.id);
                        }
                    }
                }.bind(this));
            },

            clearUploadModal() {
                this.new_file_status = 'empty';
                this.dropzone.removeAllFiles(true);
                this.new_creative.name = '';
                this.new_creative.url = '';
                this.new_creative.w = 0;
                this.new_creative.h = 0;
                this.new_creative.responsive = 0;
                this.new_creative.class = 'banner'; 
                this.new_creative.folder = '';            
            },

            validCreative() {
                var keys = Object.keys(this.valid_new_creative);
                return keys.every(key => this.valid_new_creative[key] == true);
            },

            checkFile() {
                if(this.new_file_status != 'uploaded') this.new_file_status = 'nofile';
            },

            nameRules() {
                this.valid_new_creative.name = this.new_creative.name.length < 4 ? false : true;
                if(!this.valid_new_creative.name) return ['Too short'];
            },

            heightRules() {
                this.valid_new_creative.h = this.new_creative.h <= 0 ? false : true;
                if(!this.valid_new_creative.h) return ['This must be filled in'];
            },

            widthRules() {
                this.valid_new_creative.w = this.new_creative.w <= 0 ? false : true;
                if(!this.valid_new_creative.w) return ['This must be filled in'];
            },

            folderRules() {
                this.valid_new_creative.folder = this.new_creative.folder == '' ? false : true;
                if(!this.valid_new_creative.folder) return ['folder must be selected'];
            },

            classRules() {
                this.valid_new_creative.class = this.new_creative.class == '' ? false : true;
                if(!this.valid_new_creative.class) return ['must be selected'];
            },

            //NEW FOLDER
            createNewFolder() {
                axios.post(
                    this.$root.uri + '/creatives/folders', 
                    this.new_folder, 
                    this.$root.config
                ).then(response => {
                        this.getFolders();
                        this.current_folder = {};
                        this.createFolderFlag = false;
                        this.$root.showAlertPopUp('success', 'You have successfully created a new folder.');
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Error creating folder.');
                    }
                );
            },

            //FOLDERS
            getFolders() {
                this.folders_table_loading = true;

                axios.get(
                    this.$root.uri + '/creatives/folders', 
                    this.$root.config
                ).then(response => {
                        this.folders = this.changeFoldersAndCreativesData(response.data.data);
                        if(this.folders != '') this.new_creative.folder = this.folders[0].key;
                        this.folders_table_loading = false;
                    }, error => {
                        this.folders_table_loading = false;
                        this.$root.showAlertPopUp('error', 'Error fetching folders.');
                    }
                );
            },

            openFolder(folder) {
                this.creatives_table_loading = true;
                this.current_folder = folder;
                this.getFolderCreatives(folder.id);
            },

            closeFolder() {
                this.current_folder = {};
                this.creatives = {};
            },

            togglePreview(creative, show) {
                this.creative_preview.thumbnail = creative && show ? creative.thumb : '';
                this.creative_preview.name = creative && show ? creative.name : 'Creative';
                this.creative_preview.class = creative && show ? creative.class : 'Class';
                this.creative_preview.status = creative && show ? creative.approved : 'Status';
                this.creative_preview.dimensions = creative && show ? creative.w + 'x' + creative.h : '0x0';
            },

            deleteFolder(folder_id, folder_name) {
                this.folders_table_loading = true;

                axios.delete(
                    this.$root.uri + '/creatives/folders/' + folder_id, 
                    this.$root.config
                ).then(response => {
                        this.folders_table_loading = false;
                        this.$root.showAlertPopUp('success', 'You have successfully deleted ' + folder_name + '.');
                        this.getFolders();
                    }, error => {
                        this.folders_table_loading = false;
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                        this.getFolders();
                    }
                );
            },

            //CREATIVES
            getPreview(creative) {
                var html5 = creative.class != 'html5' ? false : true;
                var validate = '';
                var url = creative.ctrurl == null ? creative.adm_url : creative.ctrurl;
                if(html5) {
                    validate = creative.adm_iframe;
                    var adm_url_replacement = 'ct=' + encodeURIComponent(url) + '?preview=1';
                    var result = validate.replace('{{ADM_URL}}', adm_url_replacement);
                    return result;
                } else {
                    validate = creative.adm;
                    var result = validate.replace('{{ADM_URL}}', url + '?preview=1');
                    return result;
                }
            },

            getFolderCreatives(folder_id) {
                this.creatives_table_loading = true; 

                axios.get(
                    this.$root.uri + '/creatives/folders/' + folder_id, 
                    this.$root.config
                ).then(response => {
                        this.creatives = this.changeFoldersAndCreativesData(response.data.data);
                        this.creatives_table_loading = false;
                    }, error => {
                        this.creatives_table_loading = false;
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            deleteCreative(creative_id, creative_name) {
                this.creatives_table_loading = true;

                axios.delete(
                    this.$root.uri + '/creatives/' + creative_id, 
                    this.$root.config
                ).then(response => {
                        this.$root.showAlertPopUp('success', 'You have successfully deleted ' + creative_name + '.');
                        this.getFolderCreatives(this.current_folder.id);
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                        this.getFolderCreatives(this.current_folder.id);
                    }
                );
            }    
        },

        computed: {
            filteredCreatives() {
                var self = this;
                return this.creatives.filter(creative => 
                    creative.name.toLowerCase().includes(self.search_creatives_and_folders.toLowerCase())
                );
            },

            filteredFolders() {
                var self = this;
                return this.folders.filter(folder => 
                    folder.name.toLowerCase().includes(self.search_creatives_and_folders.toLowerCase())
                );
            },
            
            dimensions() {
                return this.new_creative.w + 'x' + this.new_creative.h;
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

            current_folder(value) {
                this.new_creative.folder = value.key == undefined ? this.folders[0].key : value.key;
            }
        }
    }
</script>
<style type="text/css">
    .dz-preview {
        display:none;
    }
</style>