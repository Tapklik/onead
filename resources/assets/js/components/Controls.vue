<template>
    <div>

        <!-- CREATE NEW BUG REPORT START-->
        <v-dialog 
        v-model="show_create_new_bug_report" 
        lazy 
        absolute 
        width="400px"
        >
            <span 
            class="blue--text caption mr-2" 
            style="cursor: pointer" 
            slot="activator"
            >
                Report a bug
            </span>
            <v-card>
                <v-card-title>
                    <h4>Report a Bug</h4>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-flex xs12 class="valign-wrapper">
                                <span class="title">Section</span>
                                <p class="caption">
                                    Choose the section where you have found the bug.
                                </p>
                            </v-flex>
                            <v-layout row wrap class="mt-2">
                                <v-flex xs12>
                                    <v-select label="Select a Section"
                                    :items="sections"
                                    v-model="new_bug.section"
                                    prepend-icon="explore"
                                    single-line
                                    ></v-select>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-flex xs12 class="valign-wrapper">
                                <span class="title">Description</span>
                                <p class="caption">Describe the bug.</p>
                            </v-flex>
                            <v-layout row wrap class="mt-2">
                                <v-flex xs12>
                                    <v-text-field
                                    v-model="new_bug.description"
                                    multi-line
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                    class="elevation-0"
                    @click="toggleModal()"
                    >
                    <v-icon>close</v-icon>                                    
                        Cancel
                    </v-btn>
                    <v-btn
                    primary
                    dark
                    class="elevation-0" 
                    @click="createNewBugReport(), 
                    toggleModal()"
                    >
                        <v-icon>done</v-icon>
                        Send
                    </v-btn>
                </v-card-actions>
            </v-card>   
        </v-dialog>
        <!-- CREATE NEW BUG REPORT END-->

        <!-- DETAILS START -->
        <v-avatar 
        size="32px" 
        class="grey lighten-1 white--text"
        >
            {{ first_letter }}
        </v-avatar>
        <span class="ml-2 grey--text text--lighten1">
            {{ account_name }}
        </span> 
        <span class="ml-2 mr-1 grey--text text--lighten1">
            $ {{ $root.fromMicroDollars($root.balance + $root.flight) }}
        </span>
        <v-btn 
        icon 
        class="grey--text text--lighten2" 
        href="/admin/settings"
        >
            <v-icon>settings</v-icon>
        </v-btn>
        <v-btn 
        icon 
        class="grey--text text--lighten2" 
        href="/admin/logout"
        >
            <v-icon>power_settings_new</v-icon>
        </v-btn>
        <!-- DETAILS END -->

    </div> 
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
                //BUG REPORT
                new_bug: {
                    description: '',
                    section: 'Dashboard',
                },
                show_create_new_bug_report: false,
                sections: ['Dashboard', 'Campaigns', 'Creatives', 'Reporting', 'bug_reporting'],

                //DETAILS
                account_name: ''
            }
        },
        
        props: ['user'],

        methods: {

            //BUG REPORT
            toggleModal() {
                this.show_create_new_bug_report = !this.show_create_new_bug_report;
            },

            collectBugReport() {
                return {
                    to: 'halid@tapklik.com', 
                    subject: 'Bug report for ' + this.new_bug.section + ' section.', 
                    message: this.new_bug.description, 
                    from: this.$root.user.name + ' from account: ' + this.$root.user.accountUuId
                }
            },

            createNewBugReport() {
                axios.post(
                    'https://api.tapklik.com/v1/core/mail/send', 
                    this.collectBugReport(),
                    this.$root.config
                ).then(response => {
                        this.$root.showAlertPopUp('success', 'You have successfully sent the bug report');
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            //DETAILS
            getAccountName() {
                axios.get(
                    this.$root.uri + '/accounts/' + this.user.accountUuId,
                    this.$root.config
                ).then(response => {
                        this.account_name = response.data.data.name;
                    }, error => {
                        this.account_name = 'Could not retrieve account name.';
                    }
                );
            },

        },

        computed: {
            first_letter() {
                var name = this.user.name;
                return name ? name.charAt(0).toUpperCase() : '';
            },
        },

        watch: {
            user(value) {
                this.getAccountName();
            },
        }
    }
</script>
