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
                    <v-card-text>
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
                                                        <v-layout row wrap mt-1>
                                                            <v-flex md8>
                                                                <h2> Invoice </h2>
                                                                <span>Invoice no: {{props.item.id.id}}</span>
                                                            </v-flex>
                                                            <v-flex md4>
                                                                <span>Tapklik Technologies DWC-LLC</span><br>
                                                                <span>Business Center</span><br>
                                                                <span>Dubai World Central</span><br>
                                                                <span>P.O.Box 390667</span><br>
                                                                <span>Dubai, UAE</span><br><br>

                                                                <span>Registration Number: 3438</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <v-flex md8>
                                                                <span>To: {{user.name}}</span>
                                                            </v-flex>
                                                            <v-flex md4>
                                                                <span>Date: {{props.item.id.timestamp}}</span>
                                                            </v-flex>
                                                        </v-layout>
                                                        <v-layout row wrap mt-4 mb-4>
                                                            <h4 v-if="props.item.id.credit != 0">Amount: ${{$root.fromMicroDollars(props.item.id.credit)}}(Credit)</h4>
                                                            <h4 v-else>Amount: ${{$root.fromMicroDollars(props.item.id.debit)(Debit)}}</h4>
                                                        </v-layout>
                                                        <v-layout row wrap>
                                                            <span v-if="props.item.id.credit != 0">
                                                                
                                                            </span>
                                                            <span v-else>
                                                            </span>               
                                                        </v-layout>
                                                        <v-layout row wrap mb-4>
                                                            <ol>
                                                                <li>
                                                                    <span class="title">Payment is due in 7 days from the date this invoice is issued</span>   
                                                                </li>  
                                                                <li>
                                                                    <span class="title">Payment shall be made through a bank wire transfer to the bank account of Tapklik Technologies DWC-LLC listed below
                                                                    </span>                                           
                                                                </li>
                                                            </ol>
                                                        </v-layout>
                                                        <v-divider></v-divider>
                                                        <v-layout row wrap mt-4>
                                                            <v-flex md12>
                                                                <span>Payments can be made by direct transfer to Tapklik Technologies DWC-LLC account details as listed below:</span>
                                                            </v-flex>
                                                            <v-flex md12>
                                                                <ul>
                                                                    <li>
                                                                        <span class="title"> Bank:</span><span> Mashreq Bank, Mall of the Emirates, Dubai, United Arab Emirates</span> 
                                                                    </li>
                                                                    <li>
                                                                        <span class="title">Account Name:</span><span> TAPKLIK TECHNOLOGIES DWC LLC</span>    
                                                                    </li>
                                                                    <li>
                                                                        <span class="title">Account Number:</span><span> 019100114240</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="title">IBAN:</span><span> AE020330000019100114240</span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="title">Swift Code:</span><span> BOMLAEAD</span>
                                                                    </li>
                                                                </ul>
                                                            </v-flex>
                                                            <span>Please ONLY quote our invoice number as payment reference to avoid any processing delay</span>
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
                trueBills: []
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

            }, error => {
                this.success = false;
                this.error = true;
                this.alert = true;
                this.alertMessage = 'Something went wrong!';
            
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