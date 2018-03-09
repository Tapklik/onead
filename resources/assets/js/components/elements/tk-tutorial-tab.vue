<template>
    <v-layout row wrap>
        <v-flex xs12 md4>
            <v-carousel 
            class="tutorial elevation-0 ml-3" 
            hide-controls
            light 
            :interval="10000"
            >
                <v-carousel-item 
                v-for="(slide,index) in dataset" 
                :key="index" 
                src=""
                >
                    <v-layout row wrap>
                        <v-flex xs2 v-show="singleSlide()"></v-flex>
                        <v-flex xs10 v-show="singleSlide()">
                            <v-layout row wrap class="mb-2">
                                <v-flex xs12>
                                    <img width="200" src="/images/tapklik-onead-logo.png">
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs2></v-flex>
                        <v-flex xs10>
                            <v-layout row wrap>
                                <v-flex xs2 v-show="!singleSlide()">
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
                        <v-flex xs2></v-flex>
                        <v-flex xs10>
                            <v-layout row wrap>
                                <v-flex xs10>
                                    <p>{{ slide.text }}</p><br v-show="singleSlide()">
                                    <a 
                                    class="clickable"
                                    v-show="singleSlide()" 
                                    @click="emitStepChange(2)"
                                    >
                                        Check creatives tutorial
                                    </a>
                                    <br />
                                    <a 
                                    class="clickable"
                                    v-show="singleSlide()" 
                                    @click="emitStepChange(3)"
                                    >
                                        Check campaigns tutorial
                                    </a>
                                    <a 
                                    class="clickable"
                                    @click="emitPrevious()" 
                                    v-show="!singleSlide()"
                                    >Previous</a>
                                    <a 
                                    class="right clickable" 
                                    @click="emitNext()" 
                                    v-show="!singleSlide()"
                                    >Next</a>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-carousel-item>
            </v-carousel>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex xs12 md7>
            <img :src="image" height="360px">
        </v-flex>
    </v-layout>
</template>
<script type="text/javascript">
    export default {
        props: ['step', 'dataset', 'image'],

        mounted() {
            this.displayNone();
        },
        
        methods: {
            singleSlide() {
                return this.dataset.length == 1 ? true : false;
            },

            emitStepChange(value) {
                this.$emit('changeStep', value);
            },

            displayNone() {
                $('.carousel__left').hide();
                $('.carousel__right').hide();
            },

            emitPrevious() {
                $(".carousel__left button").click();
            },

            emitNext() {
                $(".carousel__right button").click();
            }
        }
    }
</script>