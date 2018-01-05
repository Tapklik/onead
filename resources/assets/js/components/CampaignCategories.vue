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
                <p class="caption ma-0">
                    Select major IAB categories into which your campaign and target audience best fits
                </p>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 class="mt-3">
                <tk-select-list v-model="campaign.cat.data">
                    <tk-select 
                    v-for="category in categories" 
                    :key="category.code" 
                    :icon="category.img" 
                    :trueValue="category.code" 
                    :subtitle="category.code"
                    >
                        {{ category.type }}
                    </tk-select>
                </tk-select-list>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.getCategories();
            this.$root.isLoading = false;
        },


        props: ['campaign', 'valid'],

        data() {
            return {
                categories: []
            }
        },
        
        computed: {
            selected_categories() {
                return this.campaign.cat.data;
            }
        },

        methods: {

            getCategories() {
                axios.get(
                    '/data/categories.json'
                ).then(response => {
                        this.categories = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            categoriesRules() {
                this.valid.categories = this.selected_categories == '' ? false : true;
            },

            updateDraftCategories(){
                if(this.campaign.status != 'draft') return;
                var payload = this.campaign.cat.data;

                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/cat', 
                    this.campaign.cat.data, 
                    this.$root.config
                ).then(response => {

                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            }
        },

        watch: {
            selected_categories(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftCategories();
                this.categoriesRules();
            }
        }
    }
</script>