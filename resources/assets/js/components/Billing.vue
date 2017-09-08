<template>

    <v-container fluid grid-list-md>
        <v-layout>
            <v-flex xs12>
        <v-card>
            <v-toolbar class="elevation-0 grey lighten-3">
                <v-btn primary dark class="elevation-0">
                    <v-icon>add</v-icon> New Payment
                </v-btn> 
            </v-toolbar>
            <v-card-title>
                <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search">
                </v-text-field>
            </v-card-title>
            <v-data-table v-bind:items="bills" v-bind:search="search">
                <template slot="headers" scope="props">
                    &nbsp;
                </template>
                <template slot="items" scope="props">
                    <td width="40px">
                        <v-btn v-if="props.item.debit == 0" icon class="green--text">
                            <v-icon>add_circle_outline</v-icon>
                        </v-btn>
                        <v-btn v-if="props.item.credit == 0" icon class="red--text">
                            <v-icon>remove_circle_outline</v-icon>
                        </v-btn>
                    </td> 
                    <td>
                        <span class="title">{{ props.item.id }}</span> <br>
                        <span class="caption">{{props.item.description | uppercase}}</span>
                    </td>
                    
                   <td class="text-xs-center">
                        <span v-if="props.item.debit == 0" class="title"> $ {{$root.fromMicroDollars(props.item.credit) }}</span><br>
                        <span v-if="props.item.credit == 0" class="title"> $ {{$root.fromMicroDollars(props.item.debit) }}</span>
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
                bills: [],
                showModal:false,
                paymentMethods: false,
                credit: 1,
                paypal: 1,
                tabIndex: 0,
                search: ''
            }
        },

        props: ['token', 'user'],

        methods: {

            processPayment() {
                axios.post(this.$root.uri + '/accounts/' + this.user.accountUuId + '/banker/main' , this.collectBill(), this.$root.config).then(response => {
                    swal('Success', 'Bill created successfully', 'success');

                }, error => {
                    swal('Error', error, 'error');
                });
            },

            collectBill() {
                if (this.tabIndex == 0) {
                    return {
                        credit: this.$root.toMicroDollars(this.paypal),
                        description: "paypal payment",
                        type: "billing"
                    }
                }
                else {
                    return {
                        credit: this.$root.toMicroDollars(this.credit),
                        description: "cc payment",
                        type: "billing"
                    }
                }
            },

            fetchBills() {

            axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/banker/main?type=billing', this.$root.config).then(response => {
                this.bills = response.data.data;
            }, error => {
                swal('Error', error, 'error');
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