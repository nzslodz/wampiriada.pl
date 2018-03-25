<template>
    <div class="a"><section class="actions">
        <h3>Lista akcji</h3>
        <div class="form-inline" v-for="(action, index) in actionList">
            <input type="hidden" :name="name(index, 'id')" v-model="actionList[index].id">
            <div class="form-group">
                <label class="control-label" :for="id(index, 'place')">Miejsce</label>
                <input class="form-control" v-model="actionList[index].place" :id="id(index, 'place')" :name="name(index, 'place')">
            </div>
            <div class="form-group">
                <label class="control-label" :for="id(index, 'day')">Data</label>
                <input class="form-control" v-model="actionList[index].day" :id="id(index, 'day')" :name="name(index, 'day')">
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

        /*

        // XXX need to make place selector + add new
        $action_day->place_id = $action_input['place_id'];
        $action_day->start = $action_input['start'];
        $action_day->end = $action_input['end'];
        $action_day->marrow = isset($action_input['marrow']);
        $action_day->hidden = isset($action_input['hidden']);
        // XXX add date selector
        $action_day->created_at = $action_input['day'];
        $action_day->created_at = $action_input['id'];
        */

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
