<template>
    <section class="section-success">
        Trwa wysyłanie - SUKCES
        <a href="">Dzięki!</a>

        <manual-logout v-if="showManualLogoutButton"></manual-logout>
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
        }
    }
</script>
