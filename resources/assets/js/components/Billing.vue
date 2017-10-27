<template>
    <v-container fluid grid-list-md>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-divider></v-divider>
                    <v-card-title>
                        <v-flex xs12 md6 lg9>
                       
                        </v-flex>
                        <v-flex xs12 md6 lg3>
                            <v-text-field 
                                append-icon="search" 
                                label="Search" 
                                single-line 
                                hide-details 
                                class="right"
                                v-model="search">
                            </v-text-field>
                        </v-flex>
                    </v-card-title>
                    <v-divider></v-divider>
                    <v-card-text v-if="billLoader == true">
                        <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px" class="mt-5"></scale-loader>
                    </v-card-text>
                    <v-card-text v-else>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-alert 
                                dismissible 
                                v-bind:success='success'
                                v-bind:error='error' 
                                v-model="alert" 
                                transition="scale-transition">
                                    {{alertMessage}}
                                </v-alert>
                                
                                <v-data-table 
                                v-bind:items="trueBills" 
                                v-bind:search="search" 
                                v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                                class="no-headers">
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <td width="40px">
                                            <v-chip v-if="props.item.id.debit == 0" small class="green white--text">
                                                <v-icon class="white--text">add</v-icon>
                                            </v-chip>
                                            <v-chip v-else small class="red white--text">
                                                <v-icon class="white--text">remove</v-icon>
                                            </v-chip>
                                        </td> 
                                        <td>
                                            <span class="title">{{ props.item.id.id }}</span> <br>
                                            <span class="caption">{{props.item.id.description | uppercase}}</span>
                                        </td>
                                        <td class="text-xs-left">
                                            <span class="title">{{ props.item.id.timestamp }}</span>
                                        </td>
                                        <td class="text-xs-right">
                                            <span v-if="props.item.id.debit == 0" class="title"> $ {{$root.fromMicroDollars(props.item.id.credit) }}</span>
                                            <span v-else class="title"> $ {{$root.fromMicroDollars(props.item.id.debit) }}</span>
                                        </td>
                                        <td>
                                            <v-dialog v-model="props.item.modal" lazy absolute width="1500px">
                                                <v-btn icon @click="selectedBill = props.item.id" slot="activator" class="grey--text">
                                                    <v-icon>search</v-icon>
                                                </v-btn>
                                                <v-card>
                                                    <v-card-title>
                                                        <h4>Additional Details</h4>
                                                    </v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-card-text>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                                                                <h5>INVOICE DETAILS</h5>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Registration Number: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>3438</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Invoice ID: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>{{props.item.id.id}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Registration Number: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>3393</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">To: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>{{user.name}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                                                                <h5>OUR DETAILS</h5>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Name: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Tapklik Technologies DWC-LLC</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Base of operation: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Business Center, Dubai World Central</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">P.O. BOX: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>3393</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Location: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Dubai, UAE</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                                                                <h5>SERVICE</h5>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md12>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Description: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>{{props.item.id.description}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Amount: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5 v-if="props.item.id.debit != 0">
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span> ${{$root.fromMicroDollars(props.item.id.debit)}} (Debit)</span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5 v-else>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span> ${{$root.fromMicroDollars(props.item.id.credit)}} (Credit)</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                                                                <h5>PAYMENT DETAILS</h5>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Bank: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Mashreq Bank, Mall of the Emirates, Dubai, United Arab Emirates</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Account Name: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>TAPKLIK TECHNOLOGIES DWC LLC</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Account Number: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>019100114240</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">IBAN: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>AE020330000019100114240</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">SWIFT Code: </span>
                                                                    </v-flex>
                                                                    <v-flex xs8 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>BOMLAEAD</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 class="valign-wrapper mb-1 mt-3">
                                                                <h5>COMMENTS</h5>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md12>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md12 lg12 class="valign-wrapper">
                                                                        <span class="title">* Payment is due in 7 days from the date this invoice is issued</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md12 lg12 class="valign-wrapper">
                                                                        <span class="title">* Payment shall be made through a bank wire transfer to the bank account of Tapklik Technologies DWC-LLC listed below</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md12 lg12 class="valign-wrapper">
                                                                        <span class="title">* Please ONLY quote our invoice number as payment reference to avoid any processing delay</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                    </v-card-text>
                                                </v-card>   
                                            </v-dialog>
                                        </td>
                                    </template>
                                    <template slot="pageText" scope="{ pageStart, pageStop }">
                                        From {{ pageStart }} to {{ pageStop }}
                                    </template>
                                </v-data-table>
                            </v-flex>
                        </v-layout>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

    export default {
        created() {
            this.$root.isLoading = true;
            this.pagetitle = 'Billing';
        },

        mounted() {
            this.$root.isLoading = false;
        },

        data() {
            return {
                selectedBill: {},
                success: false,
                error: false,
                alert: false,
                alertMessage: '',
                bills: [],
                showModal:false,
                paymentMethod: 'cc payment',
                payment: '',
                tabIndex: 0,
                search: '',
                showModal1: false,
                trueBills: [],
                billLoader: true
            }
        },

        props: ['token', 'user'],

        methods: {

            defineBills() {
                var bills = this.bills;
                var boolBills = [];
                for(var b in bills) {
                    boolBills.push({"id": bills[b], "modal": false});
                }
                this.trueBills = boolBills;
            },

            processPayment() {
                axios.post(this.$root.uri + '/accounts/' + this.user.accountUuId + '/banker/main' , this.collectBill(), this.$root.config).then(response => {
                    this.success = true;
                    this.error = false;
                    this.alert = true;
                    this.alertMessage = 'You have created a bill successfully';

                }, error => {
                    this.success = false;
                    this.error = true;
                    this.alert = true;
                    this.alertMessage = 'Something went wrong!';
                });
            },

            collectBill() {
                return {
                    credit: this.$root.toMicroDollars(this.payment),
                    description: this.paymentMethod,
                    type: "billing"
                }
            },

            fetchBills() {

            axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/banker/main?type=billing', this.$root.config).then(response => {
                this.bills = response.data.data;
                this.billLoader = false;

            }, error => {
                this.success = false;
                this.error = true;
                this.alert = true;
                this.alertMessage = 'Something went wrong!';
                this.billLoader = false;
            
            })
        }
    },

    computed: {
        filteredBills() {

            if(!this.bills) return this.bills;

            var obj = this;

            return this.bills.filter(function (bill) {
                return bill.id.toLowerCase().indexOf(obj.search.toLowerCase())>=0;
            });
        }
    },

    filters: {
        uppercase: function(v) {
          return v.toUpperCase();
        }
    },

    watch: {
        user(value) {
            if(!value) return;

            this.fetchBills();
        },
        bills(value) {
            this.defineBills();
        }
    }
}
</script>