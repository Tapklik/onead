<template>
    <v-container fluid grid-list-md>

                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>Account Details</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md9 class="valign-wrapper mt-4">
                        <span class="title">Account Name</span>
                        <p class="ma-0">This is the name of your account</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-icon>perm_identity</v-icon>
                        <span>{{account.name}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Account ID</span>
                        <p class="ma-0">This is the unique ID of your account</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-icon>perm_identity</v-icon>
                        <span>{{$root.getFirstUuidSegment}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Country</span>
                        <p class="ma-0">This is the country your account is located in</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-select
                          v-bind:items="countriesList"
                          v-model="account.localization.country"
                          label="Select" item-text="country_name" item-value="country"
                          single-line
                          bottom
                          autocomplete
                        ></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">City</span>
                        <p class="ma-0">This is the city your account is located in</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field
                        label="Your first name"
                        prepend-icon="person"
                        single-line
                        v-model="account.localization.city"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Timezone</span>
                        <p class="ma-0">This is the timezone your account is located in</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-select
                          v-bind:items="timezoneList"
                          v-model="account.localization.timezone"
                          label="Select" item-text="text" item-value="text"
                          single-line
                          bottom
                          autocomplete
                        ></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper mt-4">
                        <span class="title">Language</span>
                        <p class="ma-0">This is the language your account operates with</p>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-icon>perm_identity</v-icon>
                        <span>{{account.localization.language}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-btn @click="updateAccount()">Update you details</v-btn>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mb-3 mt-4">
                        <h4>User List</h4>
                    </v-flex>
                </v-layout>
                <v-card height="300px" class="elevation-1">
                    <v-card-title>
                        <span class="subheading orange--text text--darken-4">USERS</span>
                    </v-card-title>
                    <v-data-table v-bind:items="usersList" hide-actions>
                        <template slot="headers" scope="props">
                            &nbsp;
                        </template>
                        <template slot="items" scope="props">
                            <td>
                                <v-icon>person</v-icon>
                                <span  class="title">{{props.item.name}}</span> 
                            </td>
                            <td>
                                <span class="text-xs-left">{{props.item.email}}</span> 
                            </td>
                            <td>
                                <span class="small">{{ props.item.status }}</span>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>

    export default {

        mounted() {
        },

        props:['user'],

        data() {
            return {
                alert: false,
                error: false,
                success: false,
                alertMessage: '',
                campaigns: [],
                account: {  
                    localization: {
                        country: '',
                        city: '',
                        timezone:'',
                        language: ''
                    }
                },
                countriesList: [],
                selectedCountries: [],
                usersList: [],
                countryReadonly: true,
                cityReadonly: true,
                timezoneReadonly: true,
                ajax: false,
                timezoneList: []
            }
        },

        methods: {

            loadTimezones() {

                axios.get('/data/timezones.json').then(response => {
                    this.timezoneList = response.data;
                }, error => {
                    console.log(error);
                });
            },

            fetchUsers: function () {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users', this.$root.config).then( response => {
                    this.usersList = response.data.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            fetchUsersDet: function () {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, this.$root.config).then( response => {
                    this.account = response.data.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },

            updateAccount(){
                this.ajax = true;

                this.updateAccountDetails();
            },

            updateUser(){
                this.ajax = true;

                this.updateaccountails();
            },

            updateaccountails() {
                var payload = this.collectUser();

                axios.put(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, payload, this.$root.config).then(response => {
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },
            updateAccountDetails() {
                var payload = this.collectAccount();

                axios.put(this.$root.uri + '/accounts/' + this.user.accountUuId, payload, this.$root.config).then(response => {
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

            collectAccount() {
                return {
                    id: this.account.id,
                    name: this.account.name,
                    country: this.account.localization.country,
                    city: this.account.localization.city,
                    timezone: this.account.localization.timezone,
                    language: this.account.localization.language,
                    status: this.account.status
                };
            },

            collectUser() {
                return {
                    id: this.account.uuid,
                    first_name: this.account.first_name,
                    last_name: this.account.last_name,
                    email: this.account.email,
                    phone: this.account.phone,
                    status: this.account.status,
                    password: this.account.password
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

          loadCountries() {

            axios.get('/data/countries.json').then(response => {
                this.countriesList = response.data;
            }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
            });
        },

        confirmEdit(){
           if (this.countryReadonly == false) this.countryReadonly = true;
       }
   },

    computed: {
        token() {
            return this.$parent.token;
        }
    },

    watch: {

        user(value) {

            if(!value) return;
            this.fetchAccount();
            this.loadTimezones();
            this.loadCountries();
            this.fetchUsers();
        }

    }   
}
</script>