<template>
    <v-container grid-list-md>
         <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAMPAIGN CATEGORIES</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md9 class="valign-wrapper mt-4">
                <span class="title">IAB Campaign Categories</span>
                <p class="caption ma-0">Select major IAB categories into which your campaign and target audience best fits</p>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 class="mt-3">
                <tk-select-list v-model="campaign.cat.data">
                <tk-select v-for="category in $parent.$parent.$parent.categoriesList" 
                :key="category.code" :icon="category.img" 
                :trueValue="category.code" 
                :subtitle="category.code">
                    {{ category.type }}
                </tk-select>
            </tk-select-list>
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
