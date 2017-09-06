<template>
    <div class="dropdown-container" :class="state">
        <button type="button" class="btn btn-default btn-sm dropdown-toggle" :disabled="checkDisabled" @click="toggleDropdown()">
            <slot></slot><span class="caret"></span>
        </button>
        
        <div class="modal-backdrop" @click="close" v-show="show" transition="modal"></div>

        <div class="row dropdown-menu form-group tk-filter-menu">
            <div class=" col-sm-12">
                <div class="row form-group">
                <div class="col-sm-12">
                      <div class="icon-addon addon-sm">
                         <label class="glyphicon glyphicon-search"></label> 
                         <input placeholder="Search" type="text" class="form-control" v-model="keyword">
                     </div>
                 </div>
             </div>
             <div class="row">
                <div class="col-sm-12">
                    <div class="tk-filter-table table-responsive">
                        <table class="table table-striped table-hover table-condensed">
                            <tbody>
                                <tr v-for="(item, index) in filteredItems">
                                    <td class="valign-m">
                                        <label>
                                            <input type="checkbox" :value="'checkbox-' + index" v-model="checkedCheckboxes" class="checkbox style-0" @click="updateValue(item,index, keys)"> <span>&nbsp;</span>
                                        </label>
                                    </td>
                                    <td v-for="(element, pos) in keys" :class="element" class="valign-m sorting_1">
                                     {{ item[element] }}
                                 </td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>      
 </div>
</div>
</template>
<script>
    export default {

        props: ['data', 'keys', 'value', 'name', 'pkey'],
        data: function () {
            return {
                keyword: '',
                state: "",
                show: false,
                checkedCheckboxes: []
            }
        },
        computed: {
            filteredItems() {
                if(!this.data) return this.data;
                var obj = this;
                var keys = this.keys;
                return this.data.filter(function (item) {
                    for (var i in keys) {
                        var include = item[keys[i]].toLowerCase().indexOf(obj.keyword.toLowerCase())>=0;
                        if(include == true) {
                            return true;
                        }
                    }
                });
            },
            checkDisabled() {
                if (this.data) {
                    return this.data.length == 0
                }
            }
        },
        methods: {

            toggleDropdown() {
                this.show = !this.show
                this.show == true ? this.state = "open" : this.state = ""
            },

            close() {
                this.show = false
                this.state = ""
            },

            toggleClick(item, index, keys) {
                var checkbox = 'checkbox-' + index
                var checked = this.checkedCheckboxes.indexOf(checkbox) >= 0
                if (!checked) this.checkedCheckboxes.push(checkbox);
                if (checked) this.checkedCheckboxes.splice(checkbox, 1);
                this.updateValue(item, index, keys)
            },

            updateValue(item, index, keys) {
                var checkbox = 'checkbox-' + index
                var checked = this.checkedCheckboxes.indexOf(checkbox) >= 0
                var kv = {
                    name: this.name,
                    value: item[this.pkey]
                }
                var kvIndex = this.findKvIndex(kv)
                if (checked && !~kvIndex) this.value.push(kv) 
                    if (!checked && ~kvIndex) this.value.splice(kvIndex, 1)
                },

            findKvIndex(kv) {
                var value = this.value
                var pk = this.pkey
                var i = 0;
                for (var v in value) {
                    if (value[v].value == kv.value) {
                        return i
                    }
                    i++
                }
                return -1
            }
        }
    }
</script>
<style>
  
  .dropdown-container {
      position: relative;
  }

  .dropdown-menu {
      position: absolute;
      top: 100%; /* Bottom of button */
      left: 0;
      padding-top: 14px !important;
      white-space: nowrap;
      z-index: 9999;
  }

  .tk-filter-table  {

    max-height: 250px;
    overflow: scroll;
    overflow-x:hidden;
  }

  ::-webkit-scrollbar { 
    display: none; 
}

  .modal-backdrop {
      background-color: rgba(0, 0, 0, 0);
  }

</style>