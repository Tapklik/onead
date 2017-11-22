<template>
    <v-dialog v-model="$root.tutorialShow" lazy absolute width="1120px">
        <v-card>
            <v-stepper class="elevation-2" v-model="e1">
            <v-divider></v-divider>
            <v-stepper-header class="elevation-0">
                <v-stepper-step step="1" editable>
                    INTRO
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="2" editable>
                    CREATIVES
                </v-stepper-step>
                <v-divider></v-divider>
                <v-stepper-step step="3" editable>
                    CAMPAIGNS
                </v-stepper-step>
            </v-stepper-header>
            <v-divider></v-divider>
            <v-stepper-content step="1">
                Welcome
            </v-stepper-content>
            <v-stepper-content step="2">
                <v-layout row wrap>
                    <v-flex md3>
                        <v-layout row wrap v-for="r in rowsofline" :key="r">
                            <span class="title">To start off you must add creatives to your account</span><br>
                        </v-layout>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex md8>
                        <v-card-media :src="images[0]" height="400px"></v-card-media>
                    </v-flex>
                </v-layout>
            </v-stepper-content>
            <v-stepper-content step="3">
                <v-layout row wrap>
                    <v-flex md3>
                        <v-layout row wrap v-for="r in rowsofline" :key="r">
                            <span class="title">To start off you must add creatives to your account</span><br>
                        </v-layout>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex md8>
                        <v-card-media :src="images[1]" height="400px"></v-card-media>
                    </v-flex>
                </v-layout>
            </v-stepper-content>
        </v-stepper>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <span class="blue--text caption" style="cursor: pointer" @click="turnOffModal()">Skip the tutorial</span>
                <v-btn primary class="elevation-0" @click="$root.user.tutorial = false">
                    <v-icon>close</v-icon>
                    Don't show this again
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        mounted() {

        },

        data() {
            return {
                emir: true,
                e1: 1,
                images: ["/images/creatives-tutorial.gif", "/images/campaigns-tutorial.gif"],
                rowsofline:[1,2,3,4,5,6,7,8],
                turnOffTutorial: false
            }
        },

        methods: {

            turnOffModal() {
                axios.put(this.$root.uri + '/accounts/' + this.$root.user.accountUuId + '/users/' + this.$root.user.uuid, {tutorial: 0}, this.$root.config).then(response => {
                    this.$root.user.tutorial = 0;
                
                }, error => {
                    this.$root.user.tutorial = 0;
                    this.showAlertPopUp('error', 'Something went wrong');
                });
            }
        },

        computed: {
        }
    }
</script>
