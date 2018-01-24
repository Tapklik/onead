<template>
    <v-container grid-list-md>

        <!-- BILLING DETAILS START -->
        <v-layout row wrap class="mt-3">
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Company</span>
                        <p class="caption">This is your company name for your bills</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-text-field
                        label="Company"
                        prepend-icon="perm_identity"
                        single-line
                        v-model="billing.company"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Email</span>
                        <p class="caption">This is your email</p>
                    </v-flex>
                    <v-flex xs8 md6>
                        <v-text-field
                        label="Email"
                        prepend-icon="email"
                        single-line
                        v-model="billing.billing_email"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap class="mt-4">
                    <v-flex xs8 class="valign-wrapper">
                        <span class="title">Address</span>
                        <p class="caption mb-0">
                            Please, specify company address that will show on your invoices
                        </p>
                    </v-flex>
                    <v-flex xs8 class="mt-0">
                        <v-text-field
                        multi-line
                        v-model="billing.billing_address"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                        <span class="title">Country</span>
                        <p class="caption">Your country for your invoices</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-select
                        v-bind:items="countries"
                        v-model="billing.billing_country"
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
                        <p class="caption">Your city for your invoices</p>
                    </v-flex>
                    <v-flex xs8 md5>
                        <v-text-field
                        label="City"
                        prepend-icon="language"
                        single-line
                        v-model="billing.billing_city"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
        <!-- BILLING DETAILS END -->

        <v-divider class="mt-4"></v-divider>

        <!-- ACTIONS START -->
        <v-layout row wrap class="mt-4 mb-4"> 
            <v-flex xs12>
                <v-btn 
                primary 
                large 
                :loading="billing_button_loading" 
                @click="updateBillingDetails()"
                >
                    <v-icon left class="white--text">cloud_upload</v-icon>
                    Update Billing Details
                </v-btn>
            </v-flex>
        </v-layout>
        <!-- ACTIONS END -->

    </v-container>
</template>
<script>

    export default {

        props:['user', 'token'],

        mounted() {
            this.getCountries();
        },

        data() {
            return {
                //OVERALL
                countries: [],
                billing_button_loading: false,
                
                //BILLING
                billing: {
                    company: '',
                    billing_email: '',
                    billing_address: '',
                    billing_country: '',
                    billing_city: ''
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

            //UPDATE BILLING
            assignBillingDetails(results) {
                this.billing.billing_city = results.city;
                this.billing.billing_country = results.country;
                this.billing.billing_address = results.address;
                this.billing.company = results.company;
                this.billing.billing_email = results.email;
            },

            getBillingDetails() {
                axios.get(
                    this.$root.uri + '/accounts/' + this.user.accountUuId, 
                    this.$root.config
                ).then( response => {
                        var results = response.data.data.billing;
                        this.assignBillingDetails(results);
                    }, error => {
                        this.showAlertPopUp('error', 'Something went wrong.');
                    }
                );
            },

            updateBillingDetails() {
                this.billing_button_loading = true;

                axios.put(
                    this.$root.uri + '/accounts/' + this.user.accountUuId, 
                    this.billing, 
                    this.$root.config
                ).then( response => {
                        this.$root.showAlertPopUp('success', 'Updated billing details successfully');
                        this.billing_button_loading = false;
                    }, error => {
                        this.showAlertPopUp('error', 'Something went wrong.');
                        this.billing_button_loading = false;
                    }
                );
            }
        },

        watch: {
            user(value) {
                this.getBillingDetails();
            }
        }
    }
</script>