
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
Vue.component('tk-datepicker', require('./components/elements/tk-datepicker.vue'));
Vue.component('tk-confirm', require('./components/elements/tk-confirm.vue'));
Vue.component('tk-tutorial', require('./components/elements/tk-tutorial.vue'));
Vue.component('tk-tutorial-tab', require('./components/elements/tk-tutorial-tab.vue'));
Vue.component('tk-popup', require('./components/elements/tk-popup.vue'));           // tk-select-list
Vue.component('tk-select', require('./components/elements/tk-select.vue'));                     // tk-select
Vue.component('tk-filter', require('./components/elements/tk-filter.vue'));
Vue.component('tk-widget', require('./components/elements/tk-widget.vue'));                     // tk-widget
Vue.component('scale-loader', require('vue-spinner/src/ScaleLoader.vue'));

var currency = require('../../../modules/Tapklik/helpers/currency');
var utils = require('../../../modules/Tapklik/helpers/utils');

Vue.use(currency);
Vue.use(utils);

var envUri = 'https://api.tapklik.com/v1';

if(window.location.hostname.search('local') > -1 || window.location.hostname.search('127')  > -1) envUri = '//local.api.tapklik.com/v1';
if(window.location.hostname.search('alpha') > -1) envUri = '//104.225.218.101:10006/v1';
if(window.location.hostname.search('local.material.tapklik.com') > -1) envUri = '//104.225.218.101:10006/v1';

const app = new Vue({
    el: '#app',

    mounted() {
      this.getApiToken();
    },
    
    data: {
        version: 'v0.7.1',
        uri: envUri,
        reportUri: 'https://reports.tapklik.com/api/query',
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
        drawer: null,
        section: '',
        token: false,
        config: {},
        editMode: (window.location.pathname.search('/edit/') == -1) ? false : true,
        isLoading: true,
        alertpopup: {
            alert: false,
            error: false,
            success: false,
            alertMessage: ''
        }
    },

    methods: {
        getAccountTimezone() {
            axios.get(
                this.uri + '/accounts/' + this.user.accountUuId,
                this.config
            ).then(response => {
                    this.account_timezone = response.data.data.localization.timezone;
                }, error => {
                    
                }
            );
        },

        getApiToken() {
            axios.get('/core/token').then(response => {
                this.token = response.data.token;
            }, error => {
               swal('Error', error, 'error');
            });
        },

        createNotification(notification_message) {
            var today = new Date();
            var created_at = today.getTime() / 1000;
            var payload = {
                service: ['onead'],
                message: notification_message,
                users: [this.user.id],
                created_at: created_at.toString()
            }
            axios.post(
                this.uri + '/core/notifications',
                {config: payload},
                this.$root.config
            ).then(response => {
                
            }, error => {

            });
        },

        getUserInfo() {
            axios.get(
                this.uri + '/accounts/info', 
                this.config
            ).then(response => {
                    this.user = response.data;
                }, error => {
                    this.showAlertPopUp('error', 'Something went wrong');
                }
            );
        },

        showAlertPopUp(type, message) {
            this.alertpopup.alert = true;
            this.alertpopup.success = (type == 'success') ? true : false;
            this.alertpopup.error = (type == 'error') ? true : false;
            this.alertpopup.alertMessage = message;
        }

    },
    watch: {
        user(value) {
            this.getAccountTimezone();
        },

        token(value) {
            if(value == null) return;
            this.$children[0].token = value;
            this.config = {headers: {'Authorization': "Bearer " + this.token}};
            this.getUserInfo();
        }
    },
    computed: {
        tutorial_show() {
            var previous_url = document.referrer;
            return previous_url.endsWith('auth') && this.user.tutorial == 1 ? true : false;
        }
    }
});