<template>
	<v-dialog 
    v-model="data.modal"  
    lazy 
    absolute 
    width="400px"
    >
        <v-btn 
        icon 
        class="grey--text" 
        slot="activator"
        >
            <v-icon>{{ icon }}</v-icon>
        </v-btn>
        <v-card>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper px-4 error-icon">
                        <span>
                            <v-icon 
                            x-large 
                            primary
                            >
                                help
                            </v-icon>
                        </span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md12 class="valign-wrapper px-4">
                        <span class="">
                            <slot></slot>
                        </span><br>
                    </v-flex>
                </v-layout>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn 
                class="elevation-0" 
                @click="data.modal = false"
                >
                    <v-icon>close</v-icon>
                    Cancel
                </v-btn>
                <v-btn 
                primary 
                dark 
                class="elevation-0" 
                @click="startFunction()"
                >
                    <v-icon>done</v-icon>
                    OK
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
	export default {
    
        props: [
	        'icon', 
	        'data'
       	],
       	methods: {

            startFunction() {
                this.$emit('confirmation');
            },
       	}
    
    }
</script>