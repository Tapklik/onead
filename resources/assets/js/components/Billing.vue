<template>
    <v-container fluid grid-list-md>
        <popup></popup>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-2">
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
                                v-bind:success='$root.alert.success'
                                v-bind:error='$root.alert.error' 
                                v-model="$root.alert.alert" 
                                transition="scale-transition">
                                    {{$root.alert.alertMessage}}
                                </v-alert>
                                
                                <v-data-table 
                                v-bind:items="filteredBills"
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
                                                        <h4>Additional Details ({{props.item.id.id}})</h4>
                                                    </v-card-title>
                                                    <v-divider></v-divider>
                                                    <v-card-text>
                                                        <v-layout row wrap class="mt-2">
                                                            <v-flex xs12 class="valign-wrapper mt-4">
                                                                <span class="subheading">INVOICE DETAILS</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Registration Number: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The registration number
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>local_offer</v-icon>
                                                                        <span>3438</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Date: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The date of this bill
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>date_range</v-icon>
                                                                        <span>{{props.item.id.timestamp}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Company Name: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The company name
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Tapklik Technologies DWC-LLC</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">P.O. Box: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The number for the P.O. Box
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>local_offer</v-icon>
                                                                        <span>390667</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Amount: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The amount of this invoice
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>attach_money</v-icon>
                                                                        <span v-if="props.item.id.credit == 0">{{$root.fromMicroDollars(props.item.id.debit)}}</span>
                                                                        <span v-else>$ {{$root.fromMicroDollars(props.item.id.credit)}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Location: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The location of employment
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>language</v-icon>
                                                                        <span>Business Center</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">To: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The receiver of this invoice
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>Someone Something</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Location: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The location of our workforce
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>language</v-icon>
                                                                        <span>Dubai World Center</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">City: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The city we reside in
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>language</v-icon>
                                                                        <span>Dubai, UAE</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Description: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The description of this invoice
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>description</v-icon>
                                                                        <span>{{props.item.id.description}}</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-divider></v-divider>
                                                        <v-layout row wrap class="mt-2">
                                                            <v-flex xs12 class="valign-wrapper mt-4">
                                                                <span class="subheading">COMMENTS</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md12 lg12 class="valign-wrapper">
                                                                <v-icon>check</v-icon>
                                                                <span>Payment is due in 7 days from the date this invoice is issued</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-4">
                                                            <v-flex xs12 md12 lg12 class="valign-wrapper">
                                                                <v-icon>check</v-icon>
                                                                <span>Payment shall be made through a bank wire transfer to the bank account of Tapklik Technologies DWC-LLC listed below</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap class="mt-2">
                                                            <v-flex xs12 class="valign-wrapper mt-4">
                                                                <span class="subheading">PAYMENT DETAILS</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Bank: </span><br>
                                                                        <p class="caption ma-0">
                                                                            Our bank name and location
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>language</v-icon>
                                                                        <span>Mashreq Bank, Mall of the Emirates, Dubai, United Arab Emirates</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">IBAN: </span><br>
                                                                        <p class="caption ma-0">
                                                                            Our IBAN
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>local_offer</v-icon>
                                                                        <span>AE020330000019100114240</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Account Name: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The account name
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>perm_identity</v-icon>
                                                                        <span>TAPKLIK TECHNOLOGIES DWC LLC</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                            </v-flex>
                                                            <v-flex xs12 md6>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">Account Number: </span><br>
                                                                        <p class="caption ma-0">
                                                                            The account number
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>local_offer</v-icon>
                                                                        <span>019100114240</span>
                                                                    </v-flex>
                                                                </v-layout>
                                                                <v-layout row wrap class="mt-4">
                                                                    <v-flex xs12 md4 lg3 class="valign-wrapper">
                                                                        <span class="title">SWIFT Code: </span><br>
                                                                        <p class="caption ma-0">
                                                                            Our SWIFT code
                                                                        </p>
                                                                    </v-flex>
                                                                    <v-flex xs12 md5>
                                                                        <v-icon>local_offer</v-icon>
                                                                        <span>BOMLAEAD</span>
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
                bills: [],
                showModal:false,
                paymentMethod: 'cc payment',
                payment: '',
                tabIndex: 0,
                search: '',
                showModal1: false,
                trueBills: [],
                billLoader: true,
                tester: true
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
                    this.$root.showAlertPopUp('success', 'You have created a bill successfully.');

                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
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
                this.$root.showAlertPopUp('error', 'Something went wrong');
                this.billLoader = false;
            
            })
        }
    },

    computed: {
        filteredBills() {

            if(!this.bills) return this.bills;
            var bills = this.trueBills;
            var search = this.search;
            var result = [];
            for(var b in bills) {
                var name = bills[b].id.id.toLowerCase();
                var searchLower = search.toLowerCase();
                if(name.includes(searchLower)) {
                    result.push(bills[b]);
                }
                        
            }
            return result;
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