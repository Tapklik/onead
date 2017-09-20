<template>
    <v-container fluid grid-list-md>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>User Details</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">User ID</span>
                        <p class="ma-0">This is your ID</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-icon>perm_identity</v-icon>
                        <span>{{$root.getFirstUserUuidSegment}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">First Name</span>
                        <p class="ma-0">This is your first name</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Your first name"
                        prepend-icon="person"
                        single-line
                        v-model="userDet.first_name"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Last Name</span>
                        <p class="ma-0">This is your last name</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Your last name"
                        prepend-icon="person"
                        single-line
                        v-model="userDet.last_name"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Email</span>
                        <p class="ma-0">Your email address</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-icon>email</v-icon>
                        <span>{{userDet.email}}</span>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
            <v-layout row wrap>
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>.</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Phone number</span>
                        <p class="ma-0">Your phone number, where we can contact you</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Your phone number..."
                        prepend-icon="phone"
                        single-line
                        v-model="userDet.phone"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Password</span>
                        <p class="ma-0">This is the password for your profile</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Type here if you want to change your password..."
                        prepend-icon="lock"
                        single-line
                        type="password"
                        v-model="password"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Status</span>
                        <p class="ma-0">This is your status (active or inactive)</p>
                    </v-flex>
                    <v-flex xs12 md8 v-if="userDet.status == 0">
                        <v-icon class="red--text">keyboard_arrow_down</v-icon>
                        <span>Inactive</span>
                    </v-flex>
                    <v-flex xs12 md8 v-else>
                        <v-icon class="green--text">keyboard_arrow_up</v-icon>
                        <span>Active</span>
                    </v-flex>
                </v-layout><br><br>
                <v-layout row wrap>
                    <v-btn @click="updateUser()">Update you details</v-btn>
                </v-layout>
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
                alert: true,
                error: true,
                success: false,
                alertMessage: 'Something went wrong',
                account: false,
                userDet: {},
                password: '',
                ajax: false
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