<template>
    <v-container grid-list-md>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                <h5>USER DETAILS</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">User ID</span>
                        <p class="caption">This is your ID</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>perm_identity</v-icon>
                        <span>{{$root.getFirstUserUuidSegment}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Status</span>
                        <p class="caption">This is your status (active or inactive)</p>
                    </v-flex>
                    <v-flex xs8 md5 v-if="userDet.status == 0">
                        <v-chip small class="red white--text">
                            <small>INACTIVE</small>
                        </v-chip>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <v-chip small class="green white--text">
                            <small>ACTIVE</small>
                        </v-chip>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Username</span>
                        <p class="caption">Your email address</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>email</v-icon>
                        <span>{{userDet.email}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Password</span>
                        <p class="caption">Click to set a new password</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-dialog v-model="showModal" lazy width="500px">
                            <v-btn slot="activator"  
                            ><v-icon left class="small">lock_open</v-icon>Change Password</v-btn>
                            <v-card>
                                <v-card-title>
                                    <h4>Change Password</h4>
                                </v-card-title>
                                <v-divider></v-divider>
                                <v-card-text>
                                    <v-layout row wrap class="pl-5 pr-5">
                                        <v-flex xs12>
                                             <v-flex xs12 class="valign-wrapper">
                                                <span class="title">Change Password</span>
                                                <p class="caption">Change your password. Make sure to change your password frequently.</p>
                                            </v-flex>
                                            <v-layout row wrap class="mt-2">
                                                <v-flex xs12>
                                                    <v-text-field
                                                    label="Old password"
                                                    prepend-icon="lock"
                                                    v-model="oldPassword"
                                                    hint="Type your old password"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap class="mt-2">
                                                <v-flex xs12>
                                                    <v-text-field
                                                    label="New Password"
                                                    prepend-icon="lock"
                                                    v-model="password"
                                                    hint="Type your new password. Minimum 8 characters"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap class="mt-2">
                                                <v-flex xs12>
                                                    <v-text-field
                                                    label="New Password (Re-type)"
                                                    prepend-icon="lock"
                                                    v-model="confPassword"
                                                    hint="Retype your new password"
                                                    ></v-text-field>
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
                                    <v-btn primary dark @click="applyPlan(),showModal=false" class="elevation-0">
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Name</span>
                        <p class="caption">This is your name</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-text-field
                        label="Your first name"
                        prepend-icon="person"
                        single-line
                        v-model="fullName"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Phone number</span>
                        <p class="caption">Your phone number, where we can contact you</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-text-field
                        label="+(xxx)-xx-xxxxxxx"
                        prepend-icon="phone"
                        single-line
                        v-model="userDet.phone"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-4"> 
            <v-flex xs12>
                <v-btn primary large @click="updateUser()"><v-icon left class="white--text">cloud_upload</v-icon>Update you details</v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

    export default {


        mounted() {
        },

        props:['user', 'token'],

        data() {
            return {
                alert: false,
                error: false,
                success: false,
                alertMessage: '',
                account: false,
                userDet: {},
                password: '',
                confPassword: '',
                showModal: false,
                oldPassword: '',
                ajax: false
            }
        },

        computed: {
            fullName: {
                get() {
                var a = this.userDet.first_name;
                var b = this.userDet.last_name;
                return a + ' ' + b;
                },
             
                set(value) {
                    var names = value.split(' ')
                    this.userDet.first_name = names[0]
                    this.userDet.last_name = names[names.length - 1]
                }
            }
        },

        methods: {

            fetchUsersDet() {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, this.$root.config).then( response => {
                    this.userDet = response.data.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },            

            updateUser(){
                this.ajax = true;

                this.updateUserDetails();
            },

            updateUserDetails() {
                var payload = this.collectUser();

                axios.put(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, payload, this.$root.config).then(response => {
                    this.alert = true;
                    this.error = false;
                    this.success = true;
                    this.alertMessage = 'Succesful';
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            collectUser() {
                return {
                    id: this.userDet.uuid,
                    first_name: this.userDet.first_name,
                    last_name: this.userDet.last_name,
                    email: this.userDet.email,
                    phone: this.userDet.phone,
                    status: this.userDet.status,
                    password: this.password
                };
            },

            fetchAccount() {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId, this.$root.config).then( response => {
                    this.account = response.data.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },
        },

        watch: {

            user(value) {

                if(!value) return;
                this.fetchAccount();
                this.fetchUsersDet();
            }

        }
    }
</script>