<template>
    <v-container grid-list-md>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                <h5>ACCOUNT DETAILS</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Account ID</span>
                        <p class="caption">This is the unique ID of your account</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>perm_identity</v-icon>
                        <span>{{$root.getFirstUuidSegment}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Account Name</span>
                        <p class="caption">This is the name of your account</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>perm_identity</v-icon>
                        <span>{{account.name}}</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Account Currency</span>
                        <p class="caption">Default is USD</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>monetization_on</v-icon>
                        <span>USD</span>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Country</span>
                        <p class="caption">This is the country your account is located in</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-select
                          v-bind:items="countriesList"
                          v-model="account.localization.country"
                          label="Select" item-text="country_name" item-value="country"
                          single-line
                          prepend-icon="language"
                          bottom
                        ></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">City</span>
                        <p class="caption">This is the city your account is located in</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-text-field
                        label="City or Region"
                        prepend-icon="language"
                        single-line
                        v-model="account.localization.city"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Timezone</span>
                        <p class="caption">This is the timezone your account is located in</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-select
                          v-bind:items="timezoneList"
                          v-model="account.localization.timezone"
                          prepend-icon="language"
                          label="Select" item-text="text" item-value="text"
                          single-line
                          bottom
                        ></v-select>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Language</span>
                        <p class="caption">This is the language your account operates with</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>language</v-icon>
                        <span>{{account.localization.language}}</span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-4"> 
            <v-flex xs12>
                <v-btn primary large @click="updateAccount()"><v-icon left class="white--text">cloud_upload</v-icon>Update Account Details</v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>


<script>

    export default {

        mounted() {
        },

        props:['user','token'],

        data() {
            return {
                something: false,
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
        localization() {
            return this.account.localization;
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