<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                        <h5><i class="material-icons">add_box</i> Device Targeting</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <label class="control-label" for="device-type">Devices</label>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p class="help-block">Select device types</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.os">
                            <tk-select v-for="technology in technologiesList.operatingsystems" :icon="technology.icon" :trueValue="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <label class="control-label" for="device-type">Devices</label>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p class="help-block">Select device types</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.type">
                            <tk-select v-for="technology in technologiesList.devices" :icon="technology.icon" :trueValue="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.device.data.ua">
                            <tk-select v-for="technology in technologiesList.browsers" :icon="technology.icon" :trueValue="technology.device_id">
                                {{ technology.type }}
                            </tk-select>
                        </tk-select-list>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex xs12 md6>
                <v-layout row wrap>
                    <v-flex xs12 class="valign-wrapper mb-3 mt-4">
                        <h5><i class="material-icons">add_box</i> Audience Targeting</h5>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <label class="control-label" for="device-type">Gender</label>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p class="help-block">Set gender for target audience</p>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex xs12>
                        <tk-select-list v-model="campaign.user.data.gender">
                            <tk-select icon="fa fa-3x fa-male" trueValue="M">
                                Male
                            </tk-select>
                            <tk-select icon="fa fa-3x fa-female" trueValue="F">
                                Female
                            </tk-select>
                        </tk-select-list>                        
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <label class="control-label" for="device-type">Age Group</label>
                    </v-flex>
                </v-layout>
                <v-layout row wrap xs12>
                    <v-flex>
                        <p class="help-block">Set age group in which your target audience fits</p>
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

            pushGeo(geo) {
                this.campaign.geo.data.push(geo)
            },

            removeGeo(index) {
                this.campaign.geo.data.splice(index, 1);
            },
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
