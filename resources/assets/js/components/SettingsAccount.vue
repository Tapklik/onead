<template>
    <v-container grid-list-md>

        <!-- ACCOUNT DETAILS START -->
        <v-layout row wrap class="mt-3">
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Account ID</span>
                        <p class="caption">This is the unique ID of your account</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-icon>perm_identity</v-icon>
                        <span>{{user.accountUuId != null ? $utils.getUuidLength(user.accountUuId, 8) : null}}</span>
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
                        v-bind:items="countries"
                        v-model="account.localization.country"
                        label="Select" 
                        item-text="country_name" 
                        item-value="country"
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
                        v-bind:items="timezones"
                        v-model="account.localization.timezone"
                        prepend-icon="language"
                        label="Select" 
                        item-text="text" 
                        item-value="text"
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
        <!-- ACCOUNT DETAILS END -->

        <v-divider class="mt-4"></v-divider>

        <!-- ACTIONS START -->
        <v-layout row wrap class="mt-4 mb-4"> 
            <v-flex xs12>
                <v-btn 
                primary 
                :loading="account_settings_button_loading" 
                large 
                @click="updateAccount()"
                >
                    <v-icon left class="white--text">cloud_upload</v-icon>
                    Update Account Details
                </v-btn>
            </v-flex>
        </v-layout>
        <!-- ACTIONS END -->

    </v-container>
</template>
<script>
    export default {
        mounted() {
            this.getTimezones();
            this.getCountries();
        },

        props:['user','token'],

        data() {
            return {
                //OVERALL
                account_settings_button_loading: false,
                countries: [],
                timezones: [],

                //ACCOUNT
                account: {
                    localization: {
                        country: '',
                        city: '',
                        timezone:'',
                        language: ''
                    }
                }
            }
        },

        methods: {
            //OVERALL
            getCountries() {
                axios.get(
                    '/data/countries.json'
                ).then(response => {
                        this.countries = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            getTimezones() {
                axios.get(
                    '/data/timezones.json'
                ).then(response => {
                        this.timezones = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            //UPDATE ACCOUNT
            getAccount() {
                axios.get(
                    this.$root.uri + '/accounts/' + this.user.accountUuId, 
                    this.$root.config
                ).then( response => {
                        this.account = response.data.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
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

            updateAccount(){
                this.account_settings_button_loading = true; 

                axios.put(
                    this.$root.uri + '/accounts/' + this.user.accountUuId, 
                    this.collectAccount(), 
                    this.$root.config
                ).then(response => {
                        this.account_settings_button_loading = false; 
                        this.$root.showAlertPopUp('success', 'Successful.');
                    }, error => {
                        this.account_settings_button_loading = false; 
                        this.$root.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            }
       },

        watch: {
            user(value) {
                if(!value) return;
                this.getAccount();
            }
        }   
    }
</script>
