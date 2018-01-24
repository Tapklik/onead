<template>
    <v-container grid-list-md>
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
                            <tk-select 
                            v-for="technology in technologies.devices" 
                            :icon="technology.icon" 
                            :trueValue="technology.device_id" 
                            :key="technology.device_id"
                            >
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
                            <tk-select 
                            v-for="technology in technologies.operatingsystems" 
                            :icon="technology.icon" 
                            :trueValue="technology.device_id" 
                            :key="technology.device_id"
                            >
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
                            <tk-select 
                            v-for="technology in technologies.browsers" 
                            :icon="technology.icon" 
                            :trueValue="technology.device_id" 
                            :key="technology.device_id"
                            >
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
                        :items="geo"
                        v-model="campaign.geo.data"
                        :rules="geoRules()"
                        item-text="key"
                        return-object
                        prepend-icon="add_location"
                        :search-input.sync="search_geo"
                        @change="showNothing()"
                        @blur="geo_blurred = true"
                        label="Country or city name"
                        hint="Start typing location name to see the list..."
                        multiple
                        single-line
                        autocomplete
                        >
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
                        <v-chip 
                        close 
                        @input="removeGeo(g.id)" 
                        v-for="g in campaign.geo.data" 
                        :key="g.id"
                        >
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
                        v-model="selected_age"
                        v-bind="age_slider"
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
            this.getTechnologies();
        },


        components: {
            vueSlider
        },

        props: ['campaign', 'valid'],

        data() {
            return {
                //GEO
                geo_blurred: false,
                geo: this.campaign.geo.data,
                search_geo: '',

                //TOOLS
                technologies: [],
                age_range: [1, 120],
                age_slider: {
                    width: "100%",
                    tooltip: "always",
                    disabled: false,
                    piecewise: true,
                    piecewiseLabel: true,
                    style: {
                      
                    },
                    data: [1, 12, 18, 26, 40, 55, 65, 120],
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

            //VALIDATION
            geoRules() {
                var geo = ['you must select at least one location']
                this.valid.geo = this.campaign.geo.data == '' ? false : true;
                if(!this.valid.geo && this.geo_blurred) return geo;
            },

            devicesRules() {
                this.valid.devices = this.campaign.device.data.type == '' ? false : true;
            },

            //TARGETTING TOOLS
            getTechnologies() {
                axios.get(
                    '/data/technologies.json'
                ).then(response => {
                        this.technologies = response.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            createSlider(from, to) {
                var age_slider = document.getElementById('age-slider');

                noUiSlider.create(age_slider, {
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

                age_slider.noUiSlider.on('update', function (values, handle) {
                    this.campaign.user.data.age.min = parseInt(values[0]);
                    this.campaign.user.data.age.max = parseInt(values[1]);
                }.bind(this));
            },

            //GEO
            getGeo() {
                axios.get(
                    this.$root.uri + '/core/search/geo?key=' + this.search_geo, 
                    this.$root.config
                ).then(response => {
                        this.geo = response.data.data;
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            reloadGeo() {
                if(!this.search_geo || this.search_geo.length < 3) this.geo = this.campaign.geo.data;
                else this.getGeo();
            },

            showNothing() {
                var empty = { key: '' };
                return empty;
            },

            removeGeo(id) {
                var removed_geo = this.campaign.geo.data.map(location => location.id).indexOf(id);
                this.campaign.geo.data.splice(removed_geo, 1);
            },

            //DRAFT UPDATE
            updateDraftOs() {
                if(this.campaign.status != 'draft') return;
                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/device/os', 
                    { os: this.campaign.device.data.os }, 
                    this.$root.config).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            updateDraftUa() {
                if(this.campaign.status != 'draft') return;
                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/device/model', 
                    { models: this.campaign.device.data.ua }, 
                    this.$root.config
                ).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );

            },
            
            updateDraftTypes() {
                if(this.campaign.status != 'draft') return;
                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/device/type', 
                    { types: this.campaign.device.data.type }, 
                    this.$root.config
                ).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            collectGeography() {
                return this.campaign.geo.data.map(geo => geo.id);
            },

            updateDraftGeography(){
                if(this.campaign.status != 'draft') return;

                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/geo', 
                    { geo: this.collectGeography() }, 
                    this.$root.config
                ).then(response => {
                
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            },

            collectUser() {
                return this.campaign.user.data;
            },

            updateDraftUser(){
                if(this.campaign.status != 'draft') return;
                axios.post(
                    this.$root.uri + '/campaigns/' + this.campaign.id + '/users', 
                    this.collectUser(), 
                    this.$root.config
                ).then(response => {
                    }, error => {
                        this.$root.showAlertPopUp('error', 'Something went wrong');
                    }
                );
            }
        },

        computed: {
            selected_os() {
                return this.campaign.device.data.os;
            },

            selected_geo() {
                return this.campaign.geo.data;
            },

            selected_ua() {
                return this.campaign.device.data.ua;
            },

            selected_types() {
                return this.campaign.device.data.type;
            },

            selected_gender() {
                return this.campaign.user.data.gender;
            },

            stepActive() {
                return this.$parent.isActive
            },

            selected_age: {
                get() {
                    var min = this.campaign.user.data.age.min;
                    var max = this.campaign.user.data.age.max;
                    return [min, max]
                },

                set(value) {
                    this.age_range = [value[0], value[1]];
                }
            },
        },

        watch: {

            geo(value) {
                this.$parent.countries = value;
            },

            stepActive(value) {
                this.$nextTick(() => this.$refs.slider.refresh())
            },

            age_range(value) {
                if(this.campaign.id == undefined) return;
                this.campaign.user.data.age.min = value[0];
                this.campaign.user.data.age.max = value[1];
                this.updateDraftUser();
            },

            selected_ua(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftUa();
            },

            selected_os(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftOs();
            },
            
            selected_geo(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftGeography();
            },
            
            selected_types(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftTypes();
                this.devicesRules();
            },
            
            selected_gender(value) {
                if(this.campaign.id == undefined) return;
                this.updateDraftUser();
            },

            search_geo(value) {
                this.reloadGeo();
            }
        }
    }
</script>
