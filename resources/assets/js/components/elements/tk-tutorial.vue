<template>
    <v-dialog v-model="$root.tutorialShow" lazy absolute width="1120px">
        <v-card>
            <v-stepper class="elevation-0" v-model="e1">
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
            <v-stepper-content step="1">
                Welcome
            </v-stepper-content>
            <v-stepper-content step="2">
                <v-layout row wrap>
                    <v-flex md3>
                        <v-carousel 
                        height="200"
                        class="tutorial elevation-0 ml-3" 
                        light 
                        :left-control-icon="false"
                        :right-control-icon="false"
                        >
                            <v-carousel-item v-for="(item,i) in creativesTutorial" :key="i">
                                <v-layout>
                                    <v-flex xs12>
                                        <div class="number-circle orange darken-4 white--text mb-3">{{ i + 1 }}</div>
                                        <h5>{{ item.title }}</h5>
                                        <p>{{ item.text }}</p>
                                    </v-flex>
                                </v-layout>
                            </v-carousel-item>
                        </v-carousel>
                        <!-- <v-layout row wrap v-for="r in rowsofline" :key="r">
                            <span class="title">To start off you must add creatives to your account</span><br>
                        </v-layout>
                         -->
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
                        <v-carousel hide-controls>
                            <v-carousel-item v-for="(item,i) in items" v-bind:src="item.src" :key="i"></v-carousel-item>
                        </v-carousel>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex md8>
                        <img :src="images[1]" height="400px">
                    </v-flex>
                </v-layout>
            </v-stepper-content>
        </v-stepper>
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
                turnOffTutorial: false,
                creativesTutorial: [
                    {
                        title: "CREATIVE FORMATS",
                        text: "Tapklik supports standard banner creative formats in JPEG, PNG, GIF and HTML5"
                    },
                    {
                        title: "CREATIVE SIZES",
                        text: "For best performance, consult with your Account Manager for ad sizes that go well for your industry and target audinece. For the standard IAB ad sizes please visit: https://www.iab.com/guidelines/"
                    },
                    {
                        title: "CREATIVES APPROVALS",
                        text: "To ensure that creatives align with different regulations, all creatives undergo a pre-approval scanning. Please allow up to 24 hours for your creatives to be approved before being able to use them in your campaigns."
                    }
                ]
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
