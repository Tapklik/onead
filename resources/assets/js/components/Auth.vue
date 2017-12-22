<template>
    <v-layout>
        <v-flex xs12 sm6 offset-sm3 lg4 offset-lg4>

        	<!-- CARD START -->
            <v-card class="elevation-4">

            <!-- HEADER START -->
            	<v-card-title>
            		<v-layout row wrap>
	                    <v-flex xs12 class="pt-1 pb-2">
							<img width="40%" src="/images/tapklik-onead-logo.png">	
							<span class="right caption">{{ $root.version }}</span>
	                    </v-flex>
	                </v-layout>
	              	<v-divider></v-divider>
            	</v-card-title>
            	<!-- HEADER END -->
            	
            	<!-- LOGIN START -->
            	<v-card-text>
            		<v-layout row wrap>

            			<!-- ERROR START -->
	                	<v-flex xs12 md8 offset-sm2 class="red--text" v-show="error">
	                		{{ error }}
	                	</v-flex>
	                	<!-- ERROR END -->

	                    <v-flex xs12 sm8 offset-sm2 class="pt-4">
							<p class="body-2 text-xs-justify">
								Login to your Tapklik Client account. In case you don't have your access details please get in contact with your Account Manager or the Sales team at 
								<a href="mailto:sales@tapklik.com">sales@tapklik.com</a>
							</p>
	                    </v-flex>
	                </v-layout>
                	<v-layout row wrap>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-1">
	                        <v-text-field
	                        label="Username"
	                        prepend-icon="person"
	                        hint="Username is an email address"
	                        v-model="credentials.email"
	                        ></v-text-field>
	                    </v-flex>
	                </v-layout>
	                <v-layout row wrap>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-2">
	                        <v-text-field
	                        label="Password"
	                        prepend-icon="lock"
	                        type="password"
	                        v-model="credentials.password"
							@keydown.enter="login"
	                        ></v-text-field>
	                    </v-flex>
	                </v-layout>
	                <v-layout row wrap>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-2 pb-5">
	                        <v-btn
	                        primary
	                        large
	                        dark
	                        :loading = "login_button_loading"
	                        class="elevation-0 pl-4 pr-4 ma-0 right"
	                        @click="login()"
	                        > LOGIN </v-btn>
	                    </v-flex>
	                </v-layout>
	                <v-divider></v-divider>
	                <v-layout row wrap>
	                    <v-flex xs12 class="pt-3 pb-5">
	                        <p class="caption text-xs-justify grey--text text--darken-1">
	                        	** IN CASE YOU HAVE FORGOTTEN YOUR USERNAME OR PASSWORD, PLEASE CONTACT YOUR ACCOUNT MANAGER AND REQUEST A PASSWORD RESET.
	                        </p>
	                    </v-flex>
	                </v-layout>
                </v-card-text>
                <!-- LOGIN END -->

            </v-card>
            <!-- CARD END -->
        
        </v-flex>
    </v-layout>
</template>

<script>
	export default {
		data() {

	        return {
	            token: false,
            	credentials: {
		            email: '',
					password: '',
            	},
				error: '',
				login_button_loading: false
			}
		},

		methods: {

	        login () {
	        	this.login_button_loading = true;
	            this.error = '';

	            axios.post(
	            	this.$root.uri + '/auth', 
	            	this.credentials
	            ).then(response => {
						this.token = atob(response.data.token);
                    	this.login_button_loading = false;
					}, error => {
	                    this.login_button_loading = false;
					    this.error = error.response.data.error.details;
					}
				);
			}
		},

		watch: {
	        token () {
	            if(this.token == null) return; // prevent endless loop

	            // Need to save this to local session
				axios.post(
					'/core/token', 
					{ token: this.token	}
				).then(response => {
				    	window.location = '/admin/dashboard';
					}, error => {
				
					}
				);
			}
		}
	}
</script>
