<template>
    <v-container fluid grid-list-md>
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
                        {{$root.getFirstUuidSegment}}
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
                        label="Your first name"
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
                        <span v-if="userDet.email == ''">Undefined Email</span>
                        <span v-else>{{userDet.email}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Phone number</span>
                        <p class="ma-0">Your phone number, where we can contact you</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Your first name"
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
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Status</span>
                        <p class="ma-0">This is your status (active or inactive)</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <span v-if="userDet.status == 0">Inactive</span>
                        <span v-else>Active</span>
                    </v-flex>
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
                account: false,
                userDet: {},
                password: ''
            }
        },

        methods: {

            fetchUsersDet() {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, this.$root.config).then( response => {
                    this.userDet = response.data.data;
                }, error => {
                    alert(error);
                });
            },            

            updateUser(){
                this.ajax = true;

                this.updateUserDetails();
            },

            updateUserDetails() {
                var payload = this.collectUser();

                axios.put(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, payload, this.$root.config).then(response => {
                }, error => {
                    swal('Error', 'Something went wrong', 'error');
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
                    console.log(error);
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