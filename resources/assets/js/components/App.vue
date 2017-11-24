<template>
    <v-container fluid grid-list-md>
        <v-tabs icons light fixed :scrollable="false" class="elevation-2 white">
            <v-divider></v-divider>
            <v-card light extended  class="elevation-0">
                <v-tabs-bar class="white">
                    <v-tabs-slider class="orange darken-3"></v-tabs-slider>
                    <v-tabs-item href="#account-tab">
                        <v-icon class="orange--text text--darken-3">account_balance</v-icon>
                        <span class="orange--text text--darken-3">Account Settings</span>
                    </v-tabs-item>
                    <v-tabs-item href="#user-tab">
                        <v-icon class="orange--text text--darken-3">person</v-icon>
                        <span class="orange--text text--darken-3">User Settings</span>
                    </v-tabs-item>
                    <v-tabs-item href="#billing-tab">
                        <v-icon class="orange--text text--darken-3">attach_money</v-icon>
                        <span class="orange--text text--darken-3">Billing Settings</span>
                    </v-tabs-item>
                </v-tabs-bar>
            </v-card>
            <v-divider></v-divider>
            <v-tabs-items>
                <v-tabs-content id="account-tab">
                    <settings-account :user="user" :token="token"></settings-account>
                </v-tabs-content>
                <v-tabs-content id="user-tab">
                    <settings-user :user="user" :token="token"></settings-user>
                </v-tabs-content>                
                <v-tabs-content id="billing-tab">
                    <settings-billing :user="user" :token="token"></settings-billing>
                </v-tabs-content>                
            </v-tabs-items>
        </v-tabs>
    </v-container>
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.$root.isLoading = false;
        },
        
        props: ['user', 'token'],

        data() {
            return {
            }
        }
    }
</script>