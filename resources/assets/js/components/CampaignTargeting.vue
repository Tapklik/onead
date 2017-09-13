<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                        <h4>Device Targeting</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Devices</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Select device types</p>
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
                        <span class="title">Operating Systems</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Select operating systems</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.type">
                            <tk-select v-for="technology in technologiesList.devices" :icon="technology.icon" :trueValue="technology.device_id" :key="technology.type">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Browsers</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Select browsers</p>
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
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                        <h4>Audience Targeting</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Gender</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Set gender for target audience</p>
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
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Age Group</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Set age group in which your target audience fits</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                    <p>From: {{campaign.user.data.age.min}}</p>
                        <v-slider min="1" max="120" v-model="campaign.user.data.age.min" :toggle-keys="age"></v-slider>
                    <p>To: {{campaign.user.data.age.max}}</p>
                        <v-slider min="1" max="120" v-model="campaign.user.data.age.max"></v-slider>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Gender</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Set gender for target audience</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                        <h4>Geo Location Targeting</h4>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <span class="title">Geo Location</span>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p>Choose the countries you want to target</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <v-select
                        @keyup="reloadGeo()"
                          v-bind:items="geo"
                          chips
                          v-model="campaign.geo.data"
                          item-text="key" item-value=""
                          :search-input.sync="searchCountry"
                          label="Select"
                          multiple
                          autocomplete></v-select>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

    export default {

        props: ['campaign'],

        mounted() {
            console.log('Targeting component mounted.')
            this.loadTechnologies();
        },

        data() {
            return {
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
                    console.log(error);
                });
            },
            reloadGeo() {
                axios.get(this.$root.uri + '/core/search/geo?key=' + this.searchCountry, this.$root.config).then(response => {
                this.geo = response.data.data;
            }, error => {
                alert(error);
            })
            }
        },

        filters: {

            lowercase(input) {

                return input.toLowerCase();
            }
        },

        watch: {

            geo(value) {

                this.$parent.countries = value;
            },

            technologies(value) {

                alert(value);
            }
        }
    }
</script>
