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
                <v-dialog v-model="showModal" lazy absolute width="400px">
                    <span class="blue--text caption" style="cursor: pointer" slot="activator">Report a bug</span>
                    <v-card>
                        <v-card-title>
                            <h4>Report a Bug</h4>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-layout row wrap class="pl-3 pr-5">
                                <v-flex xs12>
                                    <v-flex xs12 class="valign-wrapper">
                                        <span class="title">Section</span>
                                        <p class="caption">Choose the section where you have found the bug.</p>
                                    </v-flex>
                                    <v-layout row wrap class="mt-2">
                                        <v-flex xs12>
                                            <v-select label="Select a Section"
                                              :items="sections"
                                              v-model="selectedSection"
                                              prepend-icon="explore"
                                              >
                                              </v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap class="pl-3 pr-5">
                                <v-flex xs12>
                                    <v-flex xs12 class="valign-wrapper">
                                        <span class="title">Description</span>
                                        <p class="caption">Describe the bug.</p>
                                    </v-flex>
                                    <v-layout row wrap class="mt-2">
                                        <v-flex xs12>
                                            <v-text-field label="Description of bug" prepend-icon="description" v-model="bugDescription"></v-text-field>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn class="elevation-0" @click="showModal = false">
                                <v-icon>close</v-icon>                                    
                                Cancel
                            </v-btn>
                            <v-btn primary dark class="elevation-0" @click="sendBug(), showModal=false">
                                <v-icon>done</v-icon>
                                Send
                            </v-btn>
                        </v-card-actions>
                    </v-card>   
                </v-dialog>
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
                bugDescription: '',
                selectedSection: 'Dashboard',
                showModal: false,
                account: false,
                accountBalance: '0.00',
                error: false,
                sections: ['Dashboard', 'Campaigns', 'Creatives', 'Reporting', 'Billing']
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
            sendBug() {
                axios.post(this.$root.uri + '/core/mail', {to: 'halid@tapklik.com', subject: 'Bug report from ' + this.selectedSection + ' section.', message: this.bugDescription}, this.$root.config).then( response => {
                    this.$root.showAlertPopUp('success', 'You have successfully sent the bug report');
                }, error => {
                    this.$root.showAlertPopUp('error', 'Something went wrong');
                });
            }
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
