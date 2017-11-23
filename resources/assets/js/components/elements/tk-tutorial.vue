<template>
    <v-dialog :value="$root.tutorialShow" lazy absolute width="1180px">
        <v-card>
            <v-stepper class="elevation-0" v-model="e1">
            <v-divider></v-divider>
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
            <v-stepper-content step="1">
                <v-layout row wrap>
                    <v-flex xs12 md3>
                        <v-carousel 
                        class="tutorial elevation-0 ml-3" 
                        hide-controls
                        light 
                        :left-control-icon="false"
                        :right-control-icon="false"
                        >
                            <v-carousel-item v-for="(item,i) in welcomeTutorial" :key="i" src="">
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap class="mb-2">
                                            <v-flex xs12>
                                                <img width="200" src="/images/tapklik-onead-logo.png">
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <h5 style="margin-top: 5px;">{{ item.title }}</h5>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p>{{ item.text }}</p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-carousel-item>
                        </v-carousel>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs12 md8>
                        <img :src="images[0]" height="400px">
                    </v-flex>
                </v-layout>
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
                            <v-carousel-item v-for="(item,i) in creativesTutorial" :key="i" src="">
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap mb-2>
                                            <v-flex xs1>
                                                <div class="number-circle orange darken-4 white--text">{{ i + 1 }}</div>
                                            </v-flex>
                                            <v-spacer></v-spacer>
                                            <v-flex xs10>
                                                <h5 style="margin-top: 5px;">{{ item.title }}</h5>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p>{{ item.text }}</p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-carousel-item>
                        </v-carousel>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex md8>
                        <v-card-media :src="images[1]" height="400px"></v-card-media>
                    </v-flex>
                </v-layout>
            </v-stepper-content>
            <v-stepper-content step="3">
                <v-layout row wrap>
                    <v-flex xs12 md3>
                        <v-carousel 
                        class="tutorial elevation-0 ml-3" 
                        light 
                        :left-control-icon="false"
                        :right-control-icon="false"
                        >
                            <v-carousel-item v-for="(item,i) in campaignsTutorial" :key="i" src="">
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap mb-2>
                                            <v-flex xs1>
                                                <div class="number-circle orange darken-4 white--text">{{ i + 1 }}</div>
                                            </v-flex>
                                            <v-spacer></v-spacer>
                                            <v-flex xs10>
                                                <h5 style="margin-top: 5px;">{{ item.title }}</h5>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex xs12>
                                                <p>{{ item.text }}</p>
                                            </v-flex>
                                        </v-layout>
                                    </v-flex>
                                </v-layout>
                            </v-carousel-item>
                        </v-carousel>
                    </v-flex>
                    <v-spacer></v-spacer>
                    <v-flex xs12 md8>
                        <img :src="images[2]" height="400px">
                    </v-flex>
                </v-layout>
            </v-stepper-content>
        </v-stepper>
            <v-card-actions>
                <v-checkbox class="caption" v-model="turnOnTutorial" label="Show this tutorial at next login"></v-checkbox> 
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
                e1: 1,
                images: ["/images/dashboard-tutorial.gif","/images/creatives-tutorial.gif", "/images/campaigns-tutorial.gif"],
                rowsofline:[1,2,3,4,5,6,7,8],
                turnOnTutorial: true,
                welcomeTutorial: [
                    {
                        title: "WELCOME TO TAPKLIK ONEAD TUTORIAL",
                        text: "This brief tutorial will guide you through the basics of uploading your first creatives and running your first campaign"
                    }
                ],
                creativesTutorial: [
                    {
                        title: "CREATIVE FORMATS",
                        text: "Tapklik supports standard banner creative formats in JPEG, PNG, GIF and HTML5"
                    },
                    {
                        title: "CREATIVE SIZES",
                        text: "For best performance, consult with your Account Manager for ad sizes that go well for your industry and target audience. For the standard IAB ad sizes please visit: https://www.iab.com/guidelines/"
                    },
                    {
                        title: "CREATIVES APPROVALS",
                        text: "To ensure that creatives align with different regulations, all creatives undergo a pre-approval scanning. Please allow up to 24 hours for your creatives to be approved before being able to use them in your campaigns"
                    }
                ],
                campaignsTutorial: [
                    {
                        title: "BEFORE FIRST CAMPAIGN",
                        text: "Before starting your first campaign make sure to have a few things ready, such as creative design and conversion site or landing page"
                    },
                    {
                        title: "ACCOUNT MANAGEMENT",
                        text: "Allow for our Account Managers to understand your conversion targets and to walk you through your first campaign "
                    }
                ],
            }
        },

        methods: {
            turnOffModal() {
                axios.put(this.$root.uri + '/accounts/' + this.$root.user.accountUuId + '/users/' + this.$root.user.uuid, {tutorial: 0}, this.$root.config).then(response => {                    
                }, error => {
                    this.showAlertPopUp('error', 'Something went wrong');
                });    
            },

            turnOnModal() {
                axios.put(this.$root.uri + '/accounts/' + this.$root.user.accountUuId + '/users/' + this.$root.user.uuid, {tutorial: 1}, this.$root.config).then(response => {                    
                }, error => {
                    this.showAlertPopUp('error', 'Something went wrong');
                });
            },
        },

        computed: {
        },
        watch: {
            turnOnTutorial(value) {
                if(value == true) this.turnOnModal();
                else this.turnOffModal();
            }
        }
    }
</script>
