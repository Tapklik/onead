<template>
    <v-dialog v-model="emir" lazy absolute width="1120px">
        <v-card>
            <v-card-media>
                <v-carousel :cycle="false">
                        <v-carousel-item src="/images/creatives-tutorial.gif"></v-carousel-item>
                        <v-carousel-item src="/images/campaigns-tutorial.gif"></v-carousel-item>
                </v-carousel>
            </v-card-media>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="elevation-0" @click="emir = false">
                    <v-icon>close</v-icon>
                    Cancel
                </v-btn>
                <v-btn class="elevation-0" primary @click="emir = false">
                    <v-icon>check</v-icon>
                    OK
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        mounted() {

        },

        data() {
            return {
                emir: true
            }
        },

        methods: {
        },

        computed: {
        }
    }
</script>
