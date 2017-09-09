<template>

        <v-layout>
            <v-flex xs12 sm6 offset-sm3 lg4 offset-lg4>
                <v-card class="elevation-4">
                	<v-card-title>
                		<v-layout row wrap>
		                    <v-flex xs12 class="pt-1 pb-2">
								<img width="40%" src="/images/tapklik-logo-grey.png">
		                    </v-flex>
		                </v-layout>
		              	<v-divider></v-divider>
                	</v-card-title>
                	<v-card-text>
                		<v-layout row wrap>
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
		                        hint="Username is an email address"
		                        v-model="email"
		                        ></v-text-field>
		                    </v-flex>
		                </v-layout>
		                <v-layout row wrap>
		                    <v-flex xs12 sm8 offset-sm2 class="pt-2">
		                        <v-text-field
		                        label="Password"
		                        hint="At least 8 characters"
		                        password
		                        v-model="password"
		                        ></v-text-field>
		                    </v-flex>
		                </v-layout>
		                <v-layout row wrap>
		                    <v-flex xs12 sm8 offset-sm2 class="pt-2 pb-5">
		                        <v-btn 
		                        primary
		                        large 
		                        dark 
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
                </v-card>
            </v-flex>
        </v-layout>
	<!-- <div class="widget-body">
			<div class="col-xs-12 col-md-4">
				<div class="alert alert-danger" role="alert" v-show="error">
					<i class="fa fa-exclamation-triangle"></i>
					<strong>{{ error.message }} </strong>
					{{ error.details }}
				</div>

				<div class="form-group">
					<div class="row">
						<label for="label-email">Email</label>
						<input type="text" id="label-email" class="form-control" placeholder="you@email.com" v-model="email" />
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<label for="label-password">Password</label>
						<input type="password" id="label-password" class="form-control" placeholder="password" v-model="password" />
					</div>
				</div>

				<div class="form-group">
					<div class="row clearfix">
						<button class="btn btn-primary pull-right" @click="login()">
							<i class="fa fa-lock" v-show="!isLoading"></i>
							<i class="fa fa-refresh fa-spin" v-show="isLoading"></i>
							Login
						</button>
					</div>
				</div>
			</div>
		</div> -->
</template>

<script>
	export default {
	    mounted () {

		},

		data() {

	        return {
	            'token': false,
	            'email': '',
				'password': '',
				'isLoading': false,
				'error': ''
			}
		},

		methods: {

	        login () {
	            this.isLoading = true;
	            this.error = '';

	            console.log(this.$http)

	            axios.post(this.$root.uri + '/auth', {
	                'email': this.email,
					'password': this.password
				}).then(response => {
					this.token = atob(response.data.token);
                    this.isLoading = false;
				}, error => {
				    this.error = error.data.error;
                     this.isLoading = false;
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

				   swal('Error', error.data.error, 'error');
				});
			}
		}
	}
</script>
