<template>
	<div class="widget-body">
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
		</div>
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
