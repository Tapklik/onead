<template>
    <v-card :height="height" class="tapklik-card elevation-1">
        <v-card-title :class="padding">
            <span class="subheading right orange--text text--darken-4">{{ title }}</span>
        </v-card-title>
        <v-card-text class="fixed-z-index">
            <v-flex xs12>
                <v-icon :class="size">{{ icon }}</v-icon>
                <v-layout row v-show="showLg">
                    <v-flex xs12 class="pa-1">
                        <span class="caption right grey--text text--lighten-1">{{ subtitle }}</span>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12 class="pa-0">
                        <span class="display-2 right blue-grey--text"><b>{{ unit }} {{ displayValue }}</b></span>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-card-text>
        <v-card-text v-if="value == null">
            <scale-loader :loading="true" color="#9e9e9e" height="15px" width="3px"></scale-loader>
        </v-card-text>
    </v-card>
</template>

<script>
export default {

    props: ['icon', 'value', 'unit', 'defaultValue', 'title', 'subtitle', 'size'],

    data() {
        return {
        }
    },

    computed: {
        displayValue() {
            return this.value == null ? this.defaultValue : this.$currency.seperatorAtThousands(this.value);
        },

        height() {
            return this.size=="lg" ? "142px" : "100px";
        },

        showLg() {
            return this.size=="lg" ? true : false; 
        },

        padding() {
            return this.size == "lg" ? "" : "pb-0";
        },

    },

    watch: {
        value(value) {
            this.loading = false;
        }
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
    font-size: 9rem;
    left: -25px;
    bottom: -60px;
}

.tapklik-card .icon.sm {
    font-size: 5rem;
    left: -20px;
    bottom: -25px;
}
</style>
