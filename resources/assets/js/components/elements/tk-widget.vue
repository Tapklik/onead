<template>
    <v-card :height="height" class="tapklik-card elevation-1">
        <v-card-title>
            <span class="subheading right orange--text text--darken-4">{{ title }}</span>
        </v-card-title>
        <v-card-text class="fixed-z-index">
            <v-flex xs12>
                <v-icon x-large>{{ icon }}</v-icon>
                <v-layout row>
                    <v-flex xs12 class="pa-1">
                        <span class="caption right grey--text text--lighte-1">TOTAL THIS MONTH</span>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12 class="pa-0">
                        <span class="display-2 right">{{ displayValue }}</span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-card-text>
    </v-card>
</template>

<script>
export default {

    props: {

        icon: {
            type: String,
            default: null
        },

        value: {
            default: null
        },

        defaultValue: {
            default: null
        },

        title: {
            type: String,
            default: null
        },

        size: {
            type: String,
            default: "lg"
        }

    },

    data: function() {
        return {
            
        }
    },

    computed: {
        displayValue() {
                if(this.value==null) {
                    return this.defaultValue
                } else {
                    return this.value
                }
            },

        height() {
            if(this.size=="lg") {
                return "142px"
            } else {
                return "100px" 
            }
        }
    },

    methods: {

    }
}
</script>

<style>
.tapklik-card {
    overflow: hidden;
}

.tapklik-card span {
    position: relative;
    z-index: 5500;
}
    
.tapklik-card .icon {
    position: absolute;
    left: -25px;
    bottom: -25px;
    color: #f5f5f5;
    font-size: 8rem;
    -ms-transform: rotate(17deg); /* IE 9 */
    -webkit-transform: rotate(17deg); /* Chrome, Safari, Opera */
    transform: rotate(17deg);
    z-index: 3000;
}
</style>
