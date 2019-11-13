<template>
    <div class="a">
        <section class="actions">
            <h3>Lista akcji</h3>

            <list-item
                :item="action"
                :index="index"
                :key="action.id"
                v-for="(action, index) in actionList"
                @remove="removeAction">
            </list-item>

            <div>
                <button class="btn btn-default" @click.prevent="addAction">Dodaj akcje</button>
            </div>
        </section>
    </div>
</template>
<script>
import moment from 'moment';

import ListItem from './ListItem.vue';

const EMPTY_ACTION = {
    place_id: null,
    start: "10:00",
    end: "16:00",
    marrow: true,
    hidden: null,
    created_at: null,
};

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

const transform = (actionList) => actionList.map((item) => ({
    ...item,
    start: moment(item.start.date).format('HH:mm'),
    end: moment(item.end.date).format('HH:mm'),

    created_at: moment(item.created_at).format('YYYY-MM-DD'),
}));


export default {
    components: {
        ListItem,
    },

    data() {
        if(typeof window.actionList === 'undefined') {
            console.error("define actionList in the data section of your blade template!")
            return {}
        }

        return {
            actionList: transform(window.actionList)
        }
    },

    methods: {
        addAction() {
            this.actionList = [
                ...this.actionList,
                { ...EMPTY_ACTION }
            ]
        },

        removeAction({ index }) {
            this.actionList.splice(index, 1)
        }
    }
}
</script>
