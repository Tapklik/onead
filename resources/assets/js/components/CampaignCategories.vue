<template>
    <v-container fluid grid-list-md>
         <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                <h5><i class="material-icons">add_box</i> Campaign Categories</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12>
                <tk-select-list v-model="campaign.cat.data">
                <tk-select v-for="category in $parent.$parent.$parent.categoriesList" 
                :key="category.code" :icon="'iabicon iabicon-' + category.code | lowercase" 
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
            ct: "sasassa"
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
