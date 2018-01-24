<template>
    <v-container grid-list-md>

        <!-- USER DETAILS START -->
        <v-layout row wrap class="mt-3">
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">User ID</span>
                        <p class="caption">This is your ID</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>perm_identity</v-icon>
                        <span>{{user.uuid != null ? $utils.getUuidLength(user.uuid, 8) : null}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Status</span>
                        <p class="caption">This is your status (active or inactive)</p>
                    </v-flex>
                    <v-flex xs8 md5 v-if="user_details.status == 0">
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
                        <span>{{user_details.email}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Password</span>
                        <p class="caption">Click to set a new password</p>
                    </v-flex>

                    <!-- PASSWORD MODAL START -->
                    <v-flex xs8 md6>
                        <v-dialog v-model="show_password_modal" lazy width="500px">
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
                                                    v-model="old_password"
                                                    @blur="checkOldPassword()"
                                                    :rules="oldPasswordRules()"
                                                    type="password"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap class="mt-2">
                                                <v-flex xs12>
                                                    <v-text-field
                                                    label="New Password"
                                                    prepend-icon="lock"
                                                    v-model="new_password"
                                                    type="password"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                            <v-layout row wrap class="mt-2">
                                                <v-flex xs12>
                                                    <v-text-field
                                                    label="New Password (Re-type)"
                                                    prepend-icon="lock"
                                                    v-model="confirm_new_password"
                                                    :rules="newPasswordRules()"
                                                    type="password"
                                                    ></v-text-field>
                                                </v-flex>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                                <v-divider></v-divider>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="show_password_modal = false, clearPasswordModal()" class="elevation-0">
                                        <v-icon>close</v-icon>                                    
                                        Cancel
                                    </v-btn>
                                    <v-btn 
                                    primary 
                                    :loading="password_change_button_loading"
                                    :disabled="!(valid_new_password && valid_old_password)" 
                                    @click="changePassword()" 
                                    class="elevation-0"
                                    >
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-flex>
                    <!-- PASSWORD MODAL END -->

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
                        v-model="user_details.phone"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <!-- USER DETAILS END -->

        <v-divider class="mt-4"></v-divider>

        <!-- ACTIONS START -->
        <v-layout row wrap class="mt-4 mb-4"> 
            <v-flex xs12>
                <v-btn primary large :loading="user_settings_button_loading" @click="updateUser()">
                    <v-icon left class="white--text">cloud_upload</v-icon>
                    Update User Details
                </v-btn>
            </v-flex>
        </v-layout>
        <!-- ACTIONS END -->

    </v-container>
</template>

<script>
    export default {
        
        props:['user', 'token'],

        data() {
            return {
                //OVERALL
                account: false,
                user_settings_button_loading: false,

                //USER
                user_details: {},

                //PASSWORD
                old_password: '',
                new_password: '',
                confirm_new_password: '',
                valid_old_password: false,
                valid_new_password: false,
                password_change_button_loading: false,
                show_password_modal: false
            }
        },

        computed: {
            fullName: {
                get() {
                    return this.user_details.first_name + ' ' + this.user_details.last_name;
                },
             
                set(value) {
                    var names = value.split(' ');
                    this.user_details.first_name = names[0];
                    this.user_details.last_name = names[names.length - 1];
                }
            }
        },

        methods: {
            //OVERALL
            getUserDetails() {
                axios.get(
                    this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, 
                    this.$root.config
                ).then(response => {
                        this.user_details = response.data.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            //PASSWORD VALIDATION
            collectAuth() {
                return {
                    email: this.user_details.email,
                    password: this.old_password                    
                }
            },

            checkOldPassword() {
                axios.post(
                    this.$root.uri + '/auth',
                    this.collectAuth()
                ).then(response => {
                        this.valid_old_password = true;
                    }, error => {
                        this.valid_old_password = false;
                    }
                );
            },

            oldPasswordRules() {
                if(!this.valid_old_password) return ['Your password is incorrect'];
            },

            newPasswordRules() {
                var password = this.new_password;
                var confirm_password = this.confirm_new_password;
                var short_password = ['The password is too short'];
                var different_passwords = ['The passwords do not match'];
                this.valid_new_password = (password != confirm_password || confirm_password.length < 8) ? false : true;
                if(!this.valid_new_password) return password != confirm_password ? different_passwords : short_password;
            },

            //PASSWORD MODAL
            clearPasswordModal() {
                this.old_password = '';
                this.confirm_new_password = '';
                this.new_password = '';
            },

            changePassword() {
                this.password_change_button_loading = true;
                var payload = { password: this.new_password };

                axios.put(
                    this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, 
                    payload, 
                    this.$root.config
                ).then(response => {
                    this.clearPasswordModal();
                    this.$root.showAlertPopUp('success', 'Succesful.');
                    this.password_change_button_loading = false;
                    this.show_password_modal = false;
                }, error => {
                    this.clearPasswordModal();
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                    this.password_change_button_loading = false;
                    this.show_password_modal= false;
                });
            },

            //UPDATE USER
            collectUser() {
                return {
                    id: this.user_details.uuid,
                    first_name: this.user_details.first_name,
                    last_name: this.user_details.last_name,
                    email: this.user_details.email,
                    phone: this.user_details.phone,
                    status: this.user_details.status,
                };
            },

            updateUser(){
                this.user_settings_button_loading = true;

                axios.put(
                    this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, 
                    this.collectUser(), 
                    this.$root.config
                ).then(response => {
                        this.user_settings_button_loading = false;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                        this.user_settings_button_loading = false;
                    }
                );
            }
        },

        watch: {
            user(value) {
                if(!value) return;
                this.getUserDetails();
            }

        }
    }
</script>