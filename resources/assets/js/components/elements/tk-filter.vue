<template>
    <v-menu offset-y :close-on-content-click='false' :nudge-width="400">
        <v-btn white flat slot="activator">
            <v-icon> {{ leftIcon }} </v-icon> 
            <span style="margin-left:10px;"> {{ buttonText }} </span>
            <v-icon> arrow_drop_down </v-icon>
        </v-btn>
        <v-card>
            <v-list>
                <v-layout row wrap pb-3 pl-3 pr-3>
                    <v-text-field 
                    single-line 
                    hide-details 
                    class="right"
                    label="Search..."
                    append-icon="search"
                    v-model="search">
                    </v-text-field>
                </v-layout>
                <v-divider></v-divider>
                <v-list-tile v-for="item in filtered_items" :key="item[keyValue]">
                    <v-list-tile-action>
                        <v-checkbox 
                        :value="value == 'object' ? item : item[value]"
                        v-model="storage"
                        ></v-checkbox>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title> {{ item[title] }} </v-list-tile-title>
                        <v-list-tile-sub-title v-show="subTitle"> {{ item[subTitle]}} </v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-card>
    </v-menu>
</template>
<script>
    export default {
        props: [
          'leftIcon',  
          'buttonText', 
          'items', 
          'keyValue',
          'subTitle', 
          'title', 
          'value', 
          'selection'
        ],
        data() {
          return {
            storage: this.selection,
            search: ''
          }
        },

        computed: {
            filtered_items() {
                var self = this;
                return this.items.filter(item => 
                    item[self.title].toLowerCase().includes(self.search.toLowerCase())
                );
            }
        },
        
        watch: {
          storage(value) {
            this.$emit('changeSelection', value);
          },

          selection(value) {
            this.storage = value;
          }
        }
    }
</script>