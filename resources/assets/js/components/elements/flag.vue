<template>
    <div class="flag-template">
        <img :src="this.path">
    </div>
</template>
<script>
export default {

    props: {
        iso2: {
            default: 'BA'
        }
    },

    computed: {
        path: function() {
            if (this.iso2) {
                return "/img/flags/" + this.iso2.toLowerCase() + ".png"
            } else {
                return ""
            }
        }
    },

    watch: {
        iso2: function(val) {
            path: "/img/flags/" + val.toLowerCase() + ".png"
        }
    },

    methods: {
       
    }
}
</script>

<style>
.flag-template {
    width: 30px;
    vertical-align: middle;
    text-align: center;
    float: left;
}

.flag-template > img {
    width: 24px;
}
</style>
