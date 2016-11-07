<template>
    <div class="a"><section class="actions">
        <h3>Lista akcji</h3>
        <div class="form-inline" v-for="(action, index) in actionList">
            <div class="form-group">
                <label class="control-label" :for="id(index, 'place')">Miejsce</label>
                <input class="form-control" v-model="actionList[index].place" :id="id(index, 'place')" :name="name(index, 'place')">
            </div>
            <div class="form-group">
                <label class="control-label" :for="id(index, 'day')">Data</label>
                <input class="form-control" v-model="actionList[index].day" :id="id(index, 'day')" :name="name(index, 'day')">
            </div>
        </div>
    </section></div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
            console.log(this.actionList)
        },


        data() {
            if(typeof actionList === 'undefined') {
                console.error("define actionList in the data section of your blade template!")
                return {}
            }

            return {
                actionList: actionList
            }
        },
        methods: {
            id(index, field_name) {
                return "action-" + index + "-" + field_name
            },
            name(index, field_name) {
                return "action[" + index + "][" + field_name + "]"
            }
        }
    }
</script>
