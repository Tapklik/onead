<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs12>
                <v-checkbox v-for="category in $parent.$parent.$parent.categoriesList" 
                v-model="campaign.cat.data"  
                :label="category.type"
                :value="category.code">
                </v-checkbox>
            </v-flex>
        </v-layout>
    </v-container>
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
