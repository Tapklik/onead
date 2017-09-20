<template>
    <v-container fluid grid-list-md>
        <v-layout>
            <v-flex xs12>
                <v-card class="elevation-0">
                    <v-card-title>
                        <v-flex xs12 md6 lg9>
                        <v-dialog v-model="showModal" lazy absolute width="70%">
                            <v-btn primary dark class="elevation-0" slot="activator">
                                <v-icon>add</v-icon> New Payment
                            </v-btn>
                            <v-card>
                                <v-card-title>
                                    <h4>Method of payment</h4>
                                </v-card-title>
                                <v-card-text>
                                    <v-layout row wrap>
                                        <v-flex xs12 md7 class="valign-wrapper">
                                            <span class="title">Amount</span><br>
                                            <p class="ma-0">The amount you are paying</p>
                                        </v-flex>
                                        <v-flex xs12 md8 class="valign-wrapper">
                                            <v-text-field
                                            label="0.00"
                                            prepend-icon="attach_money"
                                            v-model="payment"
                                            single-line
                                            type="number"
                                            ></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                    <v-layout row wrap>
                                        <v-flex xs12 md3 class="valign-wrapper mt-4">
                                            <span class="title">Method</span><br>
                                            <p class="ma-0">Payment through credit card or paypal</p>
                                        </v-flex>
                                        <v-flex xs12 md6 class="valign-wrapper mt-4">
                                            <v-radio-group v-model="paymentMethod" row class="pa-1">
                                                <v-radio label="Credit Card" value="cc payment" ></v-radio>
                                                <v-radio label="Paypal" value="paypal payment"></v-radio>
                                            </v-radio-group>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn @click="showModal = false" class="elevation-0">
                                        <v-icon>close</v-icon>                                    
                                        Cancel
                                    </v-btn>
                                    <v-btn primary dark @click="processPayment(), showModal = false" class="elevation-0">
                                        <v-icon>done</v-icon>
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>   
                        </v-dialog>
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
                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
                                <v-data-table 
                                v-bind:items="bills" 
                                v-bind:search="search" 
                                v-bind:rows-per-page-items="[10, 25, { text: 'All', value: -1 }]"
                                >
                                    <template slot="headers" scope="props">
                                        &nbsp;
                                    </template>
                                    <template slot="items" scope="props">
                                        <td width="40px">
                                            <v-chip v-if="props.item.debit == 0" small class="green white--text">
                                                <v-icon class="white--text">add</v-icon>
                                            </v-chip>
                                            <v-chip v-else small class="red white--text">
                                                <v-icon class="white--text">remove</v-icon>
                                            </v-chip>
                                        </td> 
                                        <td>
                                            <span class="title">{{ props.item.id }}</span> <br>
                                            <span class="caption">{{props.item.description | uppercase}}</span>
                                        </td>
                                        <td class="text-xs-left">
                                            <span class="title">{{ props.item.timestamp }}</span>
                                        </td>
                                        <td class="text-xs-right">
                                            <span v-if="props.item.debit == 0" class="title"> $ {{$root.fromMicroDollars(props.item.credit) }}</span>
                                            <span v-else class="title"> $ {{$root.fromMicroDollars(props.item.debit) }}</span>
                                        </td>
                                        <td>
                                            <v-btn icon class="grey--text">
                                                <v-icon>search</v-icon>
                                            </v-btn>
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
        mounted() {
            console.log('Campaigns mounted.');
        },

        data() {
            return {
                success: false,
                error: true,
                alert: true,
                alertMessage: 'Something went wrong',
                bills: [],
                showModal:false,
                paymentMethod: 'cc payment',
                payment: '',
                tabIndex: 0,
                search: ''
            }
        },

        props: ['token', 'user'],

        methods: {

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
        }
    }
}
</script>