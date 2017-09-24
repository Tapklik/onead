<template>
    <v-container fluid grid-list-md>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAMPAIGN TARGETING</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap xs12 class="mt-4">
                    <v-flex>
                        <span class="title">Devices</span>
                        <p class="caption ma-0">Select device types</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12 class="mt-3">
                        <tk-select-list v-model="campaign.device.data.type">
                            <tk-select v-for="technology in technologiesList.devices" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.type">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Operating Systems</span>
                        <p class="caption ma-0">Select operating systems</p> 
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.os">
                            <tk-select v-for="technology in technologiesList.operatingsystems" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.type">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Browsers</span>
                        <p class="caption ma-0">Select browsers</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.ua">
                            <tk-select v-for="technology in technologiesList.browsers" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.type">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap xs12 class="mt-4">
                    <v-flex>
                        <span class="title">Geo Location</span>
                        <p class="caption ma-0">Choose the countries or cities you want to target</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <v-select
                        @keyup="reloadGeo()"
                          v-bind:items="geo"
                          v-model="campaign.geo.data"
                          item-text="key"
                          return-object
                          cache-items
                          single-line
                          prepernd-icon="add_location"
                          :search-input.sync="searchCountry"
                          label="Select"
                          multiple
                          autocomplete>
                            <template slot="item" scope="data">
                                <v-list-tile-avatar>
                                    <img v-bind:src='"/images/flags/" + data.item.country_iso2 + ".png"'/>
                                </v-list-tile-avatar>
                                <v-list-tile-content>
                                    <v-list-tile-title v-html="data.item.key"></v-list-tile-title>
                                    <v-list-tile-sub-title v-html="data.item.comment"></v-list-tile-sub-title>
                                </v-list-tile-content>
                            </template>
                        </v-select>
                        <v-chip close v-for="g in campaign.geo.data" :key="geo.id" class="grey lighten-4">
                            <v-avatar>
                                <img :src='"/images/flags/" + g.country_iso2 + ".png"'>
                            </v-avatar>
                            {{g.key}}
                        </v-chip>
                    </v-flex>
                </v-layout>
                <v-divider class="mt-5"></v-divider>
                <v-layout row wrap xs12 class="mt-4">
                    <v-flex>
                        <span class="title">Target Audience Gender</span>
                        <p class="caption ma-0">Set gender for target audience</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.user.data.gender">
                            <tk-select icon="mdi-human-male" trueValue="M">
                                Male
                            </tk-select>
                            <tk-select icon="mdi-human-female" trueValue="F">
                                Female
                            </tk-select>
                        </tk-select-list>                        
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12 class="mt-4">
                    <v-flex>
                        <span class="title">Target Audience Age Group</span>
                        <p class="caption ma-0">Set age group in which your target audience fits</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <div id="age-slider" class="noUiSlider"></div>
                           
                    <p>From: {{campaign.user.data.age.min}}</p>
                        <v-slider min="1" max="120" v-model="campaign.user.data.age.min" :toggle-keys="age"></v-slider>
                    <p>To: {{campaign.user.data.age.max}}</p>
                        <v-slider min="1" max="120" v-model="campaign.user.data.age.max"></v-slider>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import noUiSlider from 'nouislider';

    export default {

        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.$root.isLoading = false;
            this.loadTechnologies();
            if(this.$root.editMode == false) this.createSlider(this.campaign.user.data.age.min, this.campaign.user.data.age.max);
        },

        props: ['campaign'],

        data() {
            return {
                alert: false,
                error: false,
                success: false,
                alertMessage: '',
                desktopValue: 2,
                mobileValue: 4,
                tabletValue: 5,
                type: [],
                os: [],
                browser: [],
                geo: [],
                searchCountry: '',
                selectedLocations: this.campaign.geo.data,
                geoTemplate: '<div class="geo-dropdown"><flag :iso2="item.country_iso2"></flag><div class="text"><span class="key">{{ item.key }}</span><br><span class="comment">{{ item.comment }}</span></div></div>',
                technologiesList: false,
                age: [1, 12, 18, 26, 40, 55, 65, 120]
            }
        },

        methods: {
            loadTechnologies() {

                axios.get('/data/technologies.json').then(response => {
                    this.technologiesList = response.data;
                }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                });
            },
            reloadGeo() {
                axios.get(this.$root.uri + '/core/search/geo?key=' + this.searchCountry, this.$root.config).then(response => {
                this.geo = response.data.data;
            }, error => {
                    this.alert = true;
                    this.error = true;
                    this.success = false;
                    this.alertMessage = 'Something went wrong';
                })
            },

            createSlider(from, to) {
                var ageSlider = document.getElementById('age-slider');

                noUiSlider.create(ageSlider, {
                    start: [from, to],
                    connect: [false, true, false],
                    behaviour: 'tap-drag',
                    range: {
                        'min': [1, 12],
                        '12%': [12, 18],
                        '25%': [18, 26],
                        '43%': [26, 40],
                        '62%': [40, 55],
                        '78%': [55, 65],
                        '90%': [65, 120],
                        'max': 120
                    }
                });

                ageSlider.noUiSlider.on('update', function (values, handle) {

                    this.campaign.user.data.age.min = parseInt(values[0]);
                    this.campaign.user.data.age.max = parseInt(values[1]);
                }.bind(this));
            },

            getFlagPath(iso) {
                if (iso) {
                    return "/images/flags/" + iso.toLowerCase() + ".svg"
                } else {
                    return ""
                }
            }

        },

        computed: {
            
        },

        filters: {

             lowercase: function(v) {
              return v.toLowerCase();
          }
        },

        watch: {

            geo(value) {

                this.$parent.countries = value;
            },

            campaign(value) {

                this.createSlider(this.campaign.user.data.age.min, this.campaign.user.data.age.max);
            },

            technologies(value) {

                alert(value);
            }
        }
    }
</script>
