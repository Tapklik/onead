<template>
    <v-card class="tk-select pa-1 elevation-0 grey lighten-4" height="85px" @click="toggleClick()">
        <div class="tk-select-wrapper" @mouseenter="toggleHover()" @mouseleave="toggleHover()" v-bind:class="{active:
            checked, hovered: hovering }">         
            <v-icon large :class="textColor">{{ icon }}</v-icon>  
            <v-checkbox :input-value="checked" :true-value="trueValue" :false-value="falseValue" class="tk-select-checkbox" color="orange darken-4"></v-checkbox>
            <p class="body-1" :class="textColor"><slot></slot></p>
        </div>      
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

        trueValue: {
            default: true
        },

        falseValue: {
            default: false
        },

        subtitle: {
            type: String,
            default: null
        }

    },

    data: function() {
        return {
            hovering: false,
            checked: function() {
                return this.parentValue
            }
        }

    },

    computed: {
        inGroup() {
            return this.$parent.name == "tk-select-list"
        },
        parentValue() {
            return this.$parent.val
        },
        textColor() {
            if (this.checked || this.hovering) {
                return "orange--text text--darken-4"
            }
        }
    },

    watch: {

        parentValue: function(val) {
            this.updateFromParent();
        },

        checked: function(val, old) {
            var value = val ? this.trueValue : this.falseValue
            this.$emit('checked', val)
            this.$emit('input', value)
            this.updateParent()
        },

        value: function(val) {
            if (val === this.trueValue) {
                this.$emit('input', this.trueValue)
                return this.checked = true
            } 

            else {
                this.$emit('input', this.falseValue)
                return this.checked = false
            }
        }
    },

    created() {
        if (this.inGroup) {
            const parent = this.$parent
            if (!(parent.val instanceof Array)) {
                parent.val = []
            }
        }
    },

    mounted() {
        this.updateFromParent()
    },

    methods: {

        updateFromParent() {
            if (this.inGroup) {
                var index = this.$parent.val.indexOf(this.trueValue)
                this.checked = ~index
            }
        },

        updateParent() {
            if (this.inGroup) {
                var index = this.$parent.val.indexOf(this.trueValue)
                if (this.checked && !~index) this.$parent.val.push(this.trueValue)
                if (!this.checked && ~index) this.$parent.val.splice(index, 1)
            }
        },

        toggleHover() {
            this.hovering = !this.hovering
        },

        toggleClick() {
            this.checked = !this.checked
        }

    }
}
</script>

<style>
.tk-select {
    margin: 0 20px 40px 20px;
    text-align: center;
    width: 120px;
    border-radius: 4px;
}

.tk-select p {
    width: 112px;
    display: block;
    text-align: center;
}

.tk-select-wrapper {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.tk-select-wrapper .tk-select-checkbox {
    position: absolute;
    left: 1px;
    top: -7px;
}

.tk-select-wrapper:hover, .tk-select-wrapper:hover input[type=checkbox].checkbox+span:before {
    color: #e65100;
    border-color: #e65100;
}

.tk-select-wrapper.active {
    color: #e65100;
}

.tk-select-wrapper:hover {
    cursor: pointer;
}

.tk-select .subtitle {
    font-size: 80%;
    line-height: 80%;
    color: #999;
}

label input[type="checkbox"].checkbox:checked + span:before {
    color: #e65100;
    border-color: #CCC;
}

</style>
