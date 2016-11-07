<template>
    <div class="a"><section class="actions">
        <h3>Lista akcji</h3>
        <div class="form-inline" v-for="(action, index) in actionList">
            <div class="form-group">
                <label class="control-label">Miejsce</label>
                <input class="form-control" v-model="actionList[index].place">
            </div>
            <div class="form-group">
                <label class="control-label">Data</label>
                <input class="form-control" v-model="actionList[index].day" :id="abc(index)">
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
            abc(index) {
                return "A" + index
            }
        }
    }
</script>
