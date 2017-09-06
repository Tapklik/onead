<template>
    <div>
        <div class="col-sm-12">
            <legend><i class="fa fa-fw fa-star"></i> Categories</legend>
            <tk-select-list v-model="campaign.cat.data">
                <tk-select v-for="category in $parent.$parent.$parent.categoriesList" :icon="'iabicon iabicon-' + category.code | lowercase" :trueValue="category.code" :subtitle="category.code">
                    {{ category.type }}
                </tk-select>
            </tk-select-list>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Categories component mounted.');
        },

        props: ['campaign'],

        data() {
           return {
           }
        },

        methods: {

        },

        filters: {
            lowercase(input) {

                return input.toLowerCase();
            }
        }
    }
</script>
