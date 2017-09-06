<template>
    <div>
        <div class="col-sm-6">
            <legend><i class="fa fa-fw fa-globe"></i> Device Targeting</legend>
            <div class="row form-group form-group-height">
                <div class="col-sm-5">
                    <label class="control-label" for="device-type">Devices</label>
                    <p class="help-block">Select device types</p>
                </div>
                <div class="col-sm-12">
                    <tk-select-list v-model="campaign.device.data.type">
                        <tk-select v-for="technology in technologiesList.devices" :icon="technology.icon" :trueValue="technology.device_id">
                            {{ technology.type }}
                        </tk-select>
                    </tk-select-list>
                </div>
            </div>
            <div class="row form-group form-group-height">
                <div class="col-sm-5">
                    <label class="control-label" for="device-os">Operating systems</label>
                    <p class="help-block">Select targeted operating systems</p>
                </div>
                <div class="col-sm-12">

                    <tk-select-list v-model="campaign.device.data.os">
                        <tk-select v-for="technology in technologiesList.operatingsystems" :icon="technology.icon" :trueValue="technology.device_id">
                            {{ technology.type }}
                        </tk-select>
                    </tk-select-list>
                </div>
            </div>
            <div class="row form-group form-group-height">
                <div class="col-sm-5">
                    <label class="control-label" for="device-browser">Browsers</label>
                    <p class="help-block">Select target browsers</p>
                </div>
                <div class="col-sm-12">
                    <tk-select-list v-model="campaign.device.data.ua">
                        <tk-select v-for="technology in technologiesList.browsers" :icon="technology.icon" :trueValue="technology.device_id">
                            {{ technology.type }}
                        </tk-select>
                    </tk-select-list>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <legend><i class="fa fa-fw fa-female"></i> Audience Targeting</legend>
            <div class="row form-group form-group-height">
                <div class="col-sm-4">
                    <label class=" control-label">Gender</label>
                    <p class="help-block">Set gender for your target audience</p>
                </div>
                <div class="col-sm-6">
                    <tk-select-list v-model="campaign.user.data.gender">
                        <tk-select icon="fa fa-3x fa-male" trueValue="M">
                            Male
                        </tk-select>
                        <tk-select icon="fa fa-3x fa-female" trueValue="F">
                            Female
                        </tk-select>
                    </tk-select-list>
                </div>
            </div>
            <div class="row form-group form-group-height">
                <div class="col-sm-12">
                    <label class=" control-label">Age Group</label>
                    <p class="help-block">Set age group in which your target audience fits</p>

                </div>
                <div class="col-sm-10">
                    <div id="age-slider" class="noUiSlider"></div>
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="pull-left help-block">
                                From
                                <strong>
                                    <span id="fromAge">{{ campaign.user.data.age.min }}</span> y/o
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right help-block">
                                To
                                <strong>
                                    <span>{{ campaign.user.data.age.max }}</span> y/o
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <legend><i class="fa fa-fw fa-globe"></i> Geo Location Targeting</legend>
            <div class="row form-group form-group-height">
                <div class="col-sm-8">
                    <label class="control-label" for="geo">Geo Targeting</label>
                    <p class="help-block">Type country name or city to add to list</p>
                </div>
                <div class="col-sm-8">
                    <div class="geo icon-addon addon-sm">
                        <label class="glyphicon glyphicon-map-marker"></label>
                        
                    </div>

                    <div class="geo-selected">
                        <ul>
                            <li v-for="(location, index) in campaign.geo.data">

                                <div>
                                    <flag :iso2="location.country_iso2"></flag>
                                    <div class="text">
                                        <span class="key">{{ location.key }}</span>
                                        <br><span class="comment">{{ location.comment }}</span>
                                    </div>
                                    <div class="geo-delete">
                                        <span class="fa fa-x2 fa-close" @click="removeGeo(index)"></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
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

            campaign(value) {
            },

            technologies(value) {

                alert(value);
            }
        }
    }
</script>
