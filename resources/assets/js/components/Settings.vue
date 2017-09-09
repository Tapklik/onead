<template>
    <v-container fluid grid-list-md>
        <v-tabs dark fixed icons>
            <v-tabs-bar class="grey">
                <v-tabs-slider class="yellow"></v-tabs-slider>
                <v-tabs-item href="#account-tab">
                    <v-icon>account_balance</v-icon>
                    Account Settings
                </v-tabs-item>
                <v-tabs-item href="#user-tab">
                    <v-icon>person</v-icon>
                    User Settings
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