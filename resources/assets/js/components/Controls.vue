<template>
    <v-flex class="text-xs-right">
        <v-chip class="transparent grey--text text--lighten2">
            <v-avatar class="grey lighten-1 lighten-2 white--text">{{ userLetter }}</v-avatar>
            <span class="ml-4">{{ account.name }}</span> 
            <span class="ml-4 mr-3" v-if="error == false">$ {{ ($root.fromMicroDollars($root.balance + $root.flight)) }}</span>
            <span class="ml-4 mr-3 red--text" v-else>Error</span>
            <v-btn icon class="grey--text text--lighten2" href="/admin/settings">
                <v-icon>settings</v-icon>
            </v-btn>
            <v-btn icon class="grey--text text--lighten2" href="/admin/logout">
                <v-icon>power_settings_new</v-icon>
            </v-btn>
        </v-chip>
        
    </v-flex> 
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.$root.isLoading = false;
        },
        
        data() {
            return {
                account: false,
                accountBalance: '0.00',
                error: false
            }
        },
        
        props: ['user'],

        methods: {
            fetchAccount() {
                var self = this;

                var balance = 0;

                axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId, this.$root.config).then( response => {
                    this.account = response.data.data;

                     axios.get(this.$root.uri + '/accounts/' + this.user.accountUuId + '/banker/main?query=balance', this.$root.config).then( response => {
                        balance = response.data.balance;
                    }, error => {
                        this.error = true;
                    });

                    this.accountBalance = this.$root.fromMicroDollars(balance).toFixed(2)

                }, error => {
                    this.error = true;
                });



            },
        },

        computed: {
            userLetter: function() {
                var name = this.user.name;
                if(name) {
                    return name.charAt(0).toUpperCase();
                } else {
                    return ' '
                }
            },
        },

        filters: {
            uppercase: function(v) {
                return v.toUpperCase();
            },
        },

        watch: {
            user(value) {
                this.fetchAccount();
            },

    
        }
    }
</script>
