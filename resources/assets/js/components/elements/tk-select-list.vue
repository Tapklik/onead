<template>
    <v-container fluid>
        <v-layout row wrap>
            <slot></slot>
        </v-layout>
    </v-container>
</template>
<script>
export default {

    props: {
        value: {
            default: null
        }
    },

    computed: {
        isTkSelectList: function() {
            return true
        }
    },

    data() {
        return {
            val: this.value,
            name: "tk-select-list"
        }
    },

    watch: {

        val(val) {
            this.$emit('input', val)
        },

        value(val) {
            this.val = val
        }
    }
}
</script>

<style>

</style>
