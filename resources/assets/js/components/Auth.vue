<template>
    <v-layout>
        <v-flex xs12 sm6 offset-sm3 lg4 offset-lg4>
            <v-card class="elevation-4">
            	<v-card-title>
            		<v-layout row wrap>
	                    <v-flex xs12 class="pt-1 pb-2">
							<img width="40%" src="/images/tapklik-onead-logo.png">	
							<span class="right caption">v0.5.1 BETA</span>
	                    </v-flex>
	                </v-layout>
	              	<v-divider></v-divider>
            	</v-card-title>
            	<v-card-text>
            		<v-layout row wrap>
	                	<v-flex xs12 md8 offset-sm2 class="red--text" v-show="errorMessageDisplay">
	                		{{errorMessage}}
	                	</v-flex>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-4">
							<p class="body-2 text-xs-justify">
							Login to your Tapklik Client account. In case you don't have your access details please get in contact with your Account Manager or the Sales team at <a href="mailto:sales@tapklik.com">sales@tapklik.com</a>
							</p>
	                    </v-flex>
	                </v-layout>
                	<v-layout row wrap>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-1">
	                        <v-text-field
	                        label="Username"
	                        prepend-icon="person"
	                        hint="Username is an email address"
	                        v-model="email"
	                        ></v-text-field>
	                    </v-flex>
	                </v-layout>
	                <v-layout row wrap>
	                    <v-flex xs12 sm8 offset-sm2 class="pt-2">
	                        <v-text-field
	                        label="Password"
	                        prepend-icon="lock"
	                        hint="At least 8 characters"
	                        type="password"
	                        v-model="password"
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
	                        :loading = "loading"
	                        class="elevation-0 pl-4 pr-4 ma-0 right"
	                        @click="loading = true, login()"
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
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
	export default {
	    mounted () {

		},

		data() {

	        return {
	        	errorMessageDisplay: false,
	            token: false,
	            email: '',
				password: '',
				errorMessage: '',
				loading: false
			}
		},

		methods: {

	        login () {
	            this.isLoading = true;
	            this.error = '';

	            axios.post(this.$root.uri + '/auth', {
	                'email': this.email,
					'password': this.password
				}).then(response => {
					this.token = atob(response.data.token);
                    this.isLoading = false;
				}, error => {
                    this.loading = false;
				    this.errorMessage = error.response.data.error.details;
					this.errorMessageDisplay = true;
				});
			}
		},

		watch: {
	        token () {
	            if(this.token == null) return; // prevent endless loop

	            // Need to save this to local session
				axios.post('/core/token', {
				    token: this.token
				}).then(response => {

				    window.location = '/admin/dashboard';
				}, error => {
				});
			}
		}
	}
</script>
