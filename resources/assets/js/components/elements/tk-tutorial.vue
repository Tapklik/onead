<template>
    <v-dialog v-model="emir" lazy absolute width="800px">
        <v-card>
            <v-card-media>
                <v-carousel>
                        <v-carousel-item src="https://static.pexels.com/photos/207962/pexels-photo-207962.jpeg"></v-carousel-item>
                        <v-carousel-item src="https://static.pexels.com/photos/207962/pexels-photo-207962.jpeg"></v-carousel-item>
                        <v-carousel-item src="https://static.pexels.com/photos/207962/pexels-photo-207962.jpeg"></v-carousel-item>
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
