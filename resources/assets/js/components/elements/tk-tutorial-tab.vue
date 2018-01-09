<template>
    <v-layout row wrap>
        <v-flex xs12 md3>
            <v-carousel 
            class="tutorial elevation-0 ml-3" 
            hide-controls
            light 
            :left-control-icon="false"
            :right-control-icon="false"
            >
                <v-carousel-item 
                v-for="(slide,index) in dataset" 
                :key="index" 
                src=""
                >
                    <v-layout row wrap>
                        <v-flex xs12 v-show="singleSlide()">
                            <v-layout row wrap class="mb-2">
                                <v-flex xs12>
                                    <img width="200" src="/images/tapklik-onead-logo.png">
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex xs1 v-show="!singleSlide()">
                                    <div class="number-circle orange darken-4 white--text">
                                        {{ index + 1 }}
                                    </div>
                                </v-flex>
                                <v-spacer v-show="!singleSlide()"></v-spacer>
                                <v-flex xs10>
                                    <h5 style="margin-top: 5px;">
                                        {{ slide.title }}
                                    </h5>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <p>{{ slide.text }}</p>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-carousel-item>
            </v-carousel>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex xs12 md8>
            <img :src="image" height="400px">
        </v-flex>
    </v-layout>
</template>
<script type="text/javascript">
    export default {
        props: ['step', 'dataset', 'image'],
        
        methods: {
            singleSlide() {
                return this.dataset.length == 1 ? true : false;
            }
        }
    }
</script>