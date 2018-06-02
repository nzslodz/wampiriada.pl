<template>
    <section>
        Trwa wysyłanie - SUKCES
        <a href="">Dzięki!</a>

        <div v-if="showManualLogoutButton">
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState } from 'vuex'

    export default {
        mixins: [mixins],

        computed: {
            ...mapState({
                showManualLogoutButton: (state) => state.facebook.showManualLogoutButton
            })
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
