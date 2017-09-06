
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'

Vue.use(Vuetify)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('sidebar', require('./components/Sidebar.vue'));
Vue.component('auth', require('./components/Auth.vue'));

// CREATE
Vue.component('campaign', require('./components/Campaign.vue'));
Vue.component('campaign-details', require('./components/CampaignDetails.vue'));
Vue.component('campaign-categories', require('./components/CampaignCategories.vue'));


//var envUri = (window.location.hostname.search('local') == -1) ? '//api.tapklik.com/v1' : '//local.api.tapklik.com/v1';
var envUri = '//api.tapklik.com/v1';

const app = new Vue({
    el: '#app',

    mounted() {
      this.getApiToken();
    },

    data: {
        uri: envUri,
        reportUri: '//app.dcos.service.tapklik.com:10002/api/query',
        user: false,
        search: '',
        section: '',
        ajax: false,
        modalIsOpen: false,
        token: false,
        config: {},
        editMode: (window.location.pathname.search('/edit/') == -1) ? false : true
    },

    methods: {

        getApiToken() {

            axios.get('/core/token').then(response => {
                this.token = response.data.token;
            }, error => {
               swal('Error', error, 'error');
            });
        },

        getUserInfo() {
            axios.get(this.uri + '/accounts/info', this.config).then(response => {
                this.user = response.data;
                
            }, error => {
                swal('error', error, 'error');
            });
        },

        getCampaignId() {

            return window.location.pathname.replace('/admin/campaigns/edit/', '');
        },

        fromMicroDollars(value) {
            return (value / 1000000).toFixed(2);
        },


        toMicroDollars(value) {
            return (value * 1000000);
        },

        twoDecimalPlaces(value) {
            return (value).toFixed(2);
        }

    },
    watch: {
        token(value) {
            if(value == null) return;

            this.$children[0].token = value;
            this.config = {headers: {'Authorization': "Bearer " + this.token}};

            this.getUserInfo();
        }
    },
    computed: {

        getFirstUuidSegment() {

            if(!this.user.accountUuId) return '';

            return this.user.accountUuId.slice(0, 8);
        },

        getFirstUserUuidSegment() {

            if(!this.user.uuid) return '';

            return this.user.uuid.slice(0, 8);
        }
    }
});
