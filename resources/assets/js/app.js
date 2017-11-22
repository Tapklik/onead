
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';

Vue.use(Vuetify);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('sidebar', require('./components/Sidebar.vue'));
Vue.component('auth', require('./components/Auth.vue'));
Vue.component('creatives', require('./components/Creatives.vue'));
Vue.component('controls', require('./components/Controls.vue'));

Vue.component('campaigns', require('./components/Campaigns.vue'));
Vue.component('billing', require('./components/Billing.vue'));

Vue.component('reporting', require('./components/Reporting.vue'));
Vue.component('reporting-tab', require('./components/ReportingTab.vue'));

Vue.component('settings', require('./components/Settings.vue'));
Vue.component('settings-account', require('./components/SettingsAccount.vue'));
Vue.component('settings-user', require('./components/SettingsUser.vue'));
Vue.component('settings-billing', require('./components/SettingsBilling.vue'));


// CREATE
Vue.component('campaign', require('./components/Campaign.vue'));
Vue.component('campaign-details', require('./components/CampaignDetails.vue'));
Vue.component('campaign-categories', require('./components/CampaignCategories.vue'));
Vue.component('campaign-targeting', require('./components/CampaignTargeting.vue'));
Vue.component('campaign-creatives', require('./components/CampaignCreatives.vue'));
Vue.component('campaign-review', require('./components/CampaignReview.vue'));

//Tapklik elements
Vue.component('tk-select-list', require('./components/elements/tk-select-list.vue')); 
Vue.component('tk-tutorial', require('./components/elements/tk-tutorial.vue')); 
Vue.component('tk-popup', require('./components/elements/tk-popup.vue'));           // tk-select-list
Vue.component('tk-select', require('./components/elements/tk-select.vue'));                     // tk-select
Vue.component('tk-filter', require('./components/elements/tk-filter.vue')); 
Vue.component('tk-widget', require('./components/elements/tk-widget.vue'));                     // tk-widget
Vue.component('scale-loader', require('vue-spinner/src/ScaleLoader.vue'));




//var envUri = (window.location.hostname.search('local') == -1) ? '//api.tapklik.com/v1' : '//local.api.tapklik.com/v1';
var envUri = '//104.225.218.101:10006/v1';

const app = new Vue({
    el: '#app',

    mounted() {
      this.getApiToken();
      this.previousURL();
            console.log(this.previousURL().endsWith('auth'))
            console.log(this.currentURL().endsWith('dashboard'))
            console.log(this.user.tutorial);
    },

    data: {
        version: 'v0.6.4-ALPHA',
        uri: envUri,
        reportUri: '//104.225.218.101:10002/api/query',
        user: {
            accountId: null,
            accountUuId: null,
            campaigns: [],
            email: '',
            id: null,
            name: '',
            role: '',
            tutorial: 0,
            uuid: ''

        },
        search: '',
        section: '',
        ajax: false,
        modalIsOpen: false,
        token: false,
        config: {},
        editMode: (window.location.pathname.search('/edit/') == -1) ? false : true,
        isLoading: true,
        pagetitle: 'Something',
        balance: 0,
        flight: 0,
        alert: {
            alert: false,
            error: false,
            success: false,
            alertMessage: ''
        },
        alertpopup: {
            alert: false,
            error: false,
            success: false,
            alertMessage: ''
        }
    },

    methods: {

        previousURL() {
            var oldURL = document.referrer;
            return oldURL;
        },
        currentURL() {
            var URL = window.location.href;
            return URL;
        },

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
                this.showAlertPopUp('error', 'Something went wrong');
            });
        },

        getAccountBalance() {
            axios.get(this.uri + '/accounts/' + this.user.accountUuId + '/banker/main?query=balance', this.config).then(response => {
                this.balance = response.data.data.balance;
                
            }, error => {
                this.showAlertPopUp('error', 'Something went wrong');
            });
            axios.get(this.uri + '/accounts/' + this.user.accountUuId + '/banker/flight?query=balance', this.config).then(response => {
                this.flight = response.data.data.balance;
                
            }, error => {
                this.showAlertPopUp('error', 'Something went wrong');
            });
        },

        getCampaignId() {

            return window.location.pathname.replace('/admin/campaigns/edit/', '');
        },

        fromMicroDollars(value) {
            if(value) {
                return (value / 1000000).toFixed(2);
            } else {
                return 0.00;
            }
        },

        toMicroDollars(value) {
            if(value) {
                return (value * 1000000);
            } else {
                return 0
            }
        },

        twoDecimalPlaces(value) {
            if(value) {
                return value.toFixed(2);
            } else {
                return 0;
            }
        },

        showAlert(type, message, timeout) {

            var timeout = (!timeout) ? 2000 : parseInt(timeout);

            this.alert.alert = true;
            this.alert.success = (type == 'success') ? true : false;
            this.alert.error = (type == 'error') ? true : false;
            this.alert.alertMessage = message;

            setTimeout(function () {
                this.alert.alert = false;
            }.bind(this), timeout);
        },

        showAlertPopUp(type, message) {
            this.alertpopup.alert = true;
            this.alertpopup.success = (type == 'success') ? true : false;
            this.alertpopup.error = (type == 'error') ? true : false;
            this.alertpopup.alertMessage = message;
        }

    },
    watch: {
        token(value) {
            if(value == null) return;

            this.$children[0].token = value;
            this.config = {headers: {'Authorization': "Bearer " + this.token}};

            this.getUserInfo();
        },

        user(value) {
            this.getAccountBalance();
        }
    },
    computed: {

        tutorialShow() {
            if(this.previousURL().endsWith('auth') && this.currentURL().endsWith('dashboard') && this.user.tutorial == 1) {
                return true;
            }
            else return false;
        },

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
