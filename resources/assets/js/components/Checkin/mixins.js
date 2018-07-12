import { mapMutations } from 'vuex'


export default {
    methods: {
        ...mapMutations([
            'nextStep',
            'previousStep',
        ]),
    }
}
