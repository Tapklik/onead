<template>
    <ul class="tk-select-list">
        <slot></slot>
    </ul>
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
.tk-select-list {
    display: block;
    list-style: none;
    padding: 0;
    margin: 0;
}

.tk-select-list > li {
    display: inline-block;
    vertical-align: top;
}
</style>
