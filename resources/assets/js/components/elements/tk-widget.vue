<template>
    <v-card :height="height" class="tapklik-card elevation-1">
        <v-card-title :class="padding">
            <span class="subheading right orange--text text--darken-4">{{ title }}</span>
        </v-card-title>
        <v-card-text v-if="value >= 0" class="fixed-z-index">
            <v-flex xs12>
                <v-icon :class="size">{{ icon }}</v-icon>
                <v-layout row v-show="showLg">
                    <v-flex xs12 class="pa-1">
                        <span class="caption right grey--text text--lighte-1">{{ subtitle }}</span>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12 class="pa-0">
                        <span class="display-2 right">{{ unit }} {{ displayValue }}</span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-card-text>
        <v-card-text v-else><scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px"></scale-loader></v-card-text>
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
            default: -1
        },

        unit: {
            default: null
        },

        defaultValue: {
            default: null
        },

        title: {
            type: String,
            default: null
        },

        subtitle: {
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
        },

        showLg() {
            if(this.size=="lg") {
                return true
            } else {
                return false
            }
        },

        padding() {
            if(this.size=="lg") {
                return ""
            } else {
                return "pb-0"
            }
        },

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
}
    
.tapklik-card .icon {
    position: absolute; 
    color: #f5f5f5;
    -ms-transform: rotate(17deg); /* IE 9 */
    -webkit-transform: rotate(17deg); /* Chrome, Safari, Opera */
    transform: rotate(17deg);
}

.tapklik-card .icon.lg {
    font-size: 8rem;
    left: -25px;
    bottom: -25px;
}

.tapklik-card .icon.sm {
    font-size: 5rem;
    left: -20px;
    bottom: -25px;
}
</style>
