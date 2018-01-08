<template>
    <v-dialog v-model="$root.alertpopup.alert" lazy absolute width="400px">
        <v-card>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper px-4 error-icon">
                        <span v-if="$root.alertpopup.error">
                            <v-icon x-large primary>cancel</v-icon>
                        </span>
                        <span v-else-if="$root.alertpopup.success">
                            <v-icon x-large primary>check</v-icon>
                        </span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 class="error-message">
                        <span>
                            {{$root.alertpopup.alertMessage}}                            
                        </span>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="elevation-0" @click="$root.alertpopup.alert = false">
                    <v-icon>close</v-icon>
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
            }
        },

        methods: {
        },

        computed: {
        }
    }
</script>
<style>
    .error-message, .error-icon {
        text-align: center;
    }
</style>
