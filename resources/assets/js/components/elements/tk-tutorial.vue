<template>
    <v-dialog 
    :value="$root.tutorialShow" 
    lazy 
    absolute 
    width="1180px"
    >
        <!-- CARD START -->
        <v-card>

            <v-stepper class="elevation-0" v-model="current_step">
                <v-divider></v-divider>

                <!-- TABS START -->
                <v-stepper-header class="elevation-0">
                    <v-stepper-step step="1" editable>
                        WELCOME
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="2" editable>
                        CREATIVES TUTORIAL
                    </v-stepper-step>
                    <v-divider></v-divider>
                    <v-stepper-step step="3" editable>
                        CAMPAIGNS TUTORIAL
                    </v-stepper-step>
                </v-stepper-header>
                <!-- TABS END -->

                <!-- TUTORIALS START -->
                <v-stepper-content step="1">
                    <tk-tutorial-tab
                    :dataset="tutorials.welcome"
                    :image="images.welcome"
                    ></tk-tutorial-tab>
                </v-stepper-content>
                <v-stepper-content step="2">
                    <tk-tutorial-tab
                    :dataset="tutorials.creatives"
                    :image="images.creatives"
                    ></tk-tutorial-tab>
                </v-stepper-content>
                <v-stepper-content step="3">
                    <tk-tutorial-tab
                    :dataset="tutorials.campaigns"
                    :image="images.campaigns"
                    ></tk-tutorial-tab>
                </v-stepper-content>
                <!-- TUTORIALS END -->
            
            </v-stepper>

            <!-- ACTION BUTTONS START -->
            <v-card-actions>
                <v-checkbox 
                class="caption" 
                v-model="show_tutorial" 
                @change="toggleShowTutorial(show_tutorial)"
                label="Show this tutorial at next login"
                ></v-checkbox> 
            </v-card-actions>
            <!-- ACTION BUTTONS END -->

        </v-card>
        <!-- CARD END -->

    </v-dialog>
</template>

<script>
    export default {
        mounted() {
            this.getTutorials();
        },

        data() {
            return {
                //ESSENTIALS
                current_step: 1,
                
                //TUTORIALS
                images: {
                    welcome: "/images/dashboard-tutorial.gif",
                    creatives: "/images/creatives-tutorial.gif", 
                    campaigns: "/images/campaigns-tutorial.gif"
                },
                tutorials: {},

                //ACTION BUTTONS
                show_tutorial: true,

            }
        },

        methods: {

            //TUTORIALS
            getTutorials() {
                axios.get(
                    '/data/tutorials.json'
                ).then(response => {
                        this.tutorials = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            //ACTION BUTTONS
            toggleShowTutorial(status) {
                var show_tutorial = status ? 1 : 0;

                axios.put(
                    this.$root.uri + '/accounts/' + this.$root.user.accountUuId + '/users/' + this.$root.user.uuid, 
                    { tutorial: show_tutorial }, 
                    this.$root.config
                ).then(response => {                    
                
                    }, error => {
                        this.showAlertPopUp('error', 'Something went wrong');
                    }
                );    
            }
        }
    }
</script>
