<template>
    <div class="lol">
        <h3>Hello</h3>
        <div v-for="action in actionList">
            <p>{{ action.day }} omg</p>
        </div>
    </div>
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
        }
    }
</script>
