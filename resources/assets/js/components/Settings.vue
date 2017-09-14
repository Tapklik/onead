<template>
    <v-container fluid grid-list-md>
        <v-tabs dark fixed icons centered>
            <v-tabs-bar class="white">
                <v-tabs-slider class="orange text--darken-3"></v-tabs-slider>
                <v-tabs-item href="#account-tab">
                    <v-icon class="orange--text text--darken-3">account_balance</v-icon>
                    <span class="orange--text text--darken-3">Account Settings</span>
                </v-tabs-item>
                <v-tabs-item href="#user-tab">
                    <v-icon class="orange--text text--darken-3">person</v-icon>
                    <span class="orange--text text--darken-3">User Settings</span>
                </v-tabs-item>
            </v-tabs-bar>
            <v-tabs-items>
                <v-tabs-content id="account-tab">
                    <settings-account :user="user" :token="token"></settings-account>
                </v-tabs-content>
                <v-tabs-content id="user-tab">
                    <settings-user :user="user" :token="token"></settings-user>
                </v-tabs-content>                
            </v-tabs-items>
        </v-tabs>
    </v-container>
</template>

<script>
    export default {
        mounted() {
        
        },
        props: ['user', 'token'],

        data() {
            return {
            }
        }
    }
</script>