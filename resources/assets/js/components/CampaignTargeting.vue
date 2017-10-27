<template>
    <v-container grid-list-md>
        <v-alert dismissible v-bind:success='success' v-bind:error='error' v-model="alert" transition="scale-transition">{{alertMessage}}</v-alert>
        <v-layout row wrap>
            <v-flex xs12 class="valign-wrapper mb-1">
                <h5>CAMPAIGN TARGETING</h5>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mt-4">
                        <span class="title">Devices</span>
                        <p class="caption ma-0">Select device types</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 class="mt-3">
                        <tk-select-list v-model="campaign.device.data.type">
                            <tk-select v-for="technology in technologiesList.devices" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12>
                        <span class="title">Operating Systems</span>
                        <p class="caption ma-0">Select operating systems</p> 
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12>
                            <tk-select-list v-model="campaign.device.data.os">
                            <tk-select v-for="technology in technologiesList.operatingsystems" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12>
                        <span class="title">Browsers</span>
                        <p class="caption ma-0">Select browsers</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.ua">
                            <tk-select v-for="technology in technologiesList.browsers" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="mt-4">
                        <span class="title">Geo Location</span>
                        <p class="caption ma-0">Choose the countries or cities you want to target</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <v-select
                          v-bind:items="geo"
                          v-model="campaign.geo.data"
                          :rules="geoRules()"
                          item-text="key"
                          return-object
                          prepend-icon="add_location"
                          :search-input.sync="searchCountry"
                          @change="showNothing()"
                          @blur="updateDraftGeography()"
                          label="Country or city name"
                          hint="Start typing location name to see the list..."
                          multiple
                          single-line
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
                            <template slot="selection" scope="data">
                            </template>
                        </v-select>
                        <v-chip close @input="removeGeo(g.id)" v-for="g in campaign.geo.data" :key="g.id">
                            <v-avatar>
                                <img :src='"/images/flags/" + g.country_iso2 + ".png"'>
                            </v-avatar>
                            {{g.key}}
                        </v-chip>
                    </v-flex>
                </v-layout>
                <v-divider class="mt-5"></v-divider>
                <v-layout row wrap class="mt-4">
                    <v-flex xs12>
                        <span class="title">Target Audience Gender</span>
                        <p class="caption ma-0">Set gender for target audience</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
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
                <v-layout row wrap  class="mt-4">
                    <v-flex xs12>
                        <span class="title">Target Audience Age Group</span>
                        <p class="caption ma-0">Set age group in which your target audience fits</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 md10 lg8 class="mt-5">
                        <vue-slider
                        ref="slider"
                        v-model="ageRange"
                        v-bind="ageSlider"
                        :show="true"
                        :real-time="true"
                        ></vue-slider>
                    </v-flex>  
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import vueSlider from 'vue-slider-component'


    export default {

        created() {
            this.$root.isLoading = true;
        },

        mounted() {
            this.$root.isLoading = false;
            this.loadTechnologies();
        },


        components: {
            vueSlider
        },

        props: ['campaign', 'selectedDevices','selectedUa','selectedOs'],

        data() {
            return {
                writtenCountries: '',
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
                geo: this.campaign.geo.data,
                searchCountry: '',
                selectedLocations: this.campaign.geo.data,
                geoTemplate: '<div class="geo-dropdown"><flag :iso2="item.country_iso2"></flag><div class="text"><span class="key">{{ item.key }}</span><br><span class="comment">{{ item.comment }}</span></div></div>',
                technologiesList: false,
                ageRange: [1, 120],
                ageSlider: {
                    width: "100%",
                    tooltip: "always",
                    disabled: false,
                    piecewise: true,
                    piecewiseLabel: true,
                    style: {
                      
                    },
                    data: [
                      1,
                      12,
                      18,
                      26,
                      40,
                      55,
                      65,
                      120
                    ],
                    formatter: "{value} y/o",
                    piecewiseStyle: {
                      "backgroundColor": "#ccc",
                      "visibility": "visible",
                      "width": "12px",
                      "height": "12px"
                    },
                    piecewiseActiveStyle: {
                      "backgroundColor": "#e65100"
                    },
                    tooltipStyle: {
                        "color": "#555",
                        "backgroundColor": "#f5f5f5",
                        "borderColor": "#f5f5f5"
                    },
                    processStyle: {
                        "backgroundColor": "#e65100"
                    }
                }
            }
        },
        methods: {
            geoRules() {
                var geo = ['you must select at least one location']
                if(this.campaign.geo.data == '') {
                    this.$parent.$parent.$parent.validGeo = false;
                    return geo;
                }
                else {
                    this.$parent.$parent.$parent.validGeo = true;
                }
            },

            devicesRules() {
                if(this.campaign.device.data.type == '') {
                    this.$parent.$parent.$parent.validDevices = false;
                }
                else {
                    this.$parent.$parent.$parent.validDevices = true;
                }
            },

            showNothing() {
                var a = {key: ''};
                return a;
            },

            removeGeo(id) {
                var locations = this.campaign.geo.data;
                for(var l in locations) {
                    if(id == locations[l].id) {
                        locations.splice(l,1);
                    }    
                }
                this.campaign.geo.data = locations;
            },

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
                var locations = this.campaign.geo.data;
                if(!this.searchCountry) {
                    for(var l in locations) {
                        this.geo.push(locations[l]);
                    }
                }

                else if(this.searchCountry.length >= 3){
                    axios.get(this.$root.uri + '/core/search/geo?key=' + this.searchCountry, this.$root.config).then(response => {
                            this.geo = response.data.data;
                            for(var l in locations) {
                                this.geo.push(locations[l]);
                            }
                        }, error => {
                            this.alert = true;
                            this.error = true;
                            this.success = false;
                            this.alertMessage = 'Something went wrong';
                        }
                    )
                }
                
                else {
                    for(var l in locations) {
                        this.geo.push(locations[l]);
                    }
                }
            },

            updateDraftDevice(){

                if(this.$root.editMode == true) return;

                else {
                    var payload = this.collectDevices();
    
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/type', {types: payload.types}, this.$root.config).then(response => {
                    }, error => {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Something went wrong';
                    });
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/model', {models: payload.models}, this.$root.config).then(response => {
                    }, error => {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Something went wrong';
                    });
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/device/os', {os: payload.os}, this.$root.config).then(response => {
                    }, error => {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Something went wrong';
                    });
                }
            },

            collectDevices() {
                return {
                    types: this.campaign.device.data.type,
                    models: this.campaign.device.data.ua,
                    os: this.campaign.device.data.os,
                };
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

            collectGeography() {
                return this.campaign.geo.data.map(function (geo) {
                    return geo.id;
                });
            },

            updateDraftGeography(){

                if(this.$root.editMode == true) return;

                else {
                    var payload = this.collectGeography();
    
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/geo', {geo: payload}, this.$root.config).then(response => {
                    }, error => {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Something went wrong';
                    });
                }
            },
            collectUser() {
                return this.campaign.user.data;
            },

            updateDraftUser(){
                
                if(this.$root.editMode == true) return;

                else {
                    var payload = this.collectUser();
    
                    axios.post(this.$root.uri + '/campaigns/' + this.campaign.id + '/users', payload, this.$root.config).then(response => {
                    }, error => {
                        this.alert = true;
                        this.error = true;
                        this.success = false;
                        this.alertMessage = 'Something went wrong';
                    });
                }
            }

        },

        computed: {
            stepActive() {
                return this.$parent.isActive
            }
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

            stepActive: function(v) {
                this.$nextTick(() => this.$refs.slider.refresh())
            },

            technologies(value) {

                console.log(value);
            },
            ageRange(value) {
                if(this.campaign.id == undefined) return;
                this.campaign.user.data.age.min = value[0];
                this.campaign.user.data.age.max = value[1];
                this.updateDraftUser();
            },
            selectedUa(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftDevice();
            },

            selectedOs(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftDevice();
            },
            
            selectedDevices(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftDevice();
                this.devicesRules();
            },
            gender(value) {
                if(this.campaign.id) return;
                this.updateDraftUser();
            },
            searchCountry(value) {
                this.reloadGeo();
            }
        }
    }
</script>
