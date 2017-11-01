<template>
    <v-dialog v-model="$root.alertpopup.alert" lazy absolute width="400px">
        <v-card>
            <v-card-title>
                <h4>Notification</h4>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper px-4">
                        <span v-if="$root.alertpopup.error">
                            <v-icon>cancel</v-icon>
                            {{$root.alertpopup.alertMessage}}</span>
                        <span v-else-if="$root.alertpopup.success">
                            <v-icon>check</v-icon>
                            {{$root.alertpopup.alertMessage}}</span>
                    </v-flex>
                </v-layout>
            </v-card-text>
             <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="elevation-0" @click="$root.alertpopup.alert = false">
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
