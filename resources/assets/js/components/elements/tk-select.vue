<template>

    <li class="tk-select" @click="toggleClick()">

        <div class="tk-select-wrapper" @mouseenter="toggleHover()" @mouseleave="toggleHover()" v-bind:class="{active: 

            checked, hovered: hovering }">
            
            <i :class="icon"></i>
            
            <label class="tk-select-checkbox">
            
                <input type="checkbox" class="checkbox style-0" v-model="checked"> <span>&nbsp;</span>
            
            </label>
        
        </div>
        
        <span class="title">
        
            <slot></slot>
        
        </span>
        
        <br>
        
        <span class="subtitle">{{ this.subtitle }}</span>
    
    </li>

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
                return this.value === this.trueValue
            }
        }

    },

    computed: {
        inGroup() {
            return this.$parent.name == "tk-select-list"
        },
        parentValue() {
            return this.$parent.val
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
    margin: 0 10px 20px 10px;
    text-align: center;
    width: 90px;
    list-style: none;
}

.tk-select-wrapper {
    height: 60px;
    width: 60px;
    display: block;
    color: #CCC;
    background: #eeeeee;
    border: dashed 1px rgba(0, 0, 0, 0.2);
    padding: 11px !important;
    vertical-align: top;
    margin: 0 15px 5px 15px;
    text-align: center;
    position: relative;
}

.tk-select-wrapper .tk-select-checkbox {
    position: absolute;
    left: 3px;
    top: 0px;
}

.tk-select-wrapper:hover, .tk-select-wrapper:hover input[type=checkbox].checkbox+span:before {
    color: #f76c06;
    border-color: #f76c06;
}

.tk-select-wrapper.active {
    color: #f76c06;
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
    color: #f76c06;
    border-color: #CCC;
}

i {
    z-index: 1000;
}
</style>
