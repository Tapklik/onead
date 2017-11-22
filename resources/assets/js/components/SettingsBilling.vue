<template>
    <v-container grid-list-md>
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
                        <p class="caption mb-0">Please, specify company address that will show on your invoices</p>
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
                        <v-text-field
                        label="Country"
                        prepend-icon="language"
                        single-line
                        v-model="billing.billing_country"
                        ></v-text-field>
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
        <v-divider class="mt-4"></v-divider>
        <v-layout row wrap class="mt-4 mb-4"> 
            <v-flex xs12>
                <v-btn primary large :loading="loading" @click="loading = true, updateBillingDetails()"><v-icon left class="white--text">cloud_upload</v-icon>Update Billing Details</v-btn>
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
                ajax: false,
                loading: false,
                billing: {
                    company: '',
                    billing_email: '',
                    billing_address: '',
                    billing_country: '',
                    billing_city: ''
                }
            }
        },

        computed: {
        },

        methods: {
            fetchUsersDet() {
                var self = this;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/users/' + this.user.uuid, this.$root.config).then( response => {
                    this.userDet = response.data.data;
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong.');
                });
            },     

            updateBillingDetails() {
                this.loading = true;

                axios.put(this.$root.uri + '/accounts/' + this.user.accountUuId, this.billing, this.$root.config).then( response => {
                    this.$root.showAlertPopUp('success', 'Upadated billing details successfully');
                    this.loading = false;
                }, error => {
                    this.showAlertPopUp('error', 'Something went wrong.');
                    this.loading = false;
                });
            }
        },

        watch: {

            user(value) {

                if(!value) return;
                this.fetchUsersDet();
            }

        }
    }
</script>