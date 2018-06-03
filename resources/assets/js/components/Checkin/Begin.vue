<template>
    <section class="section-begin">
        <div v-if="waitingForInitialization" class="loading text-center">
            Ładowanie...
        </div>
        <manual-logout v-else-if="showManualLogoutButton"></manual-logout>
        <div v-else>
            <button class="btn btn-primary btn-lg btn-rozpocznij" v-on:click="nextStep()" type="button">Rozpocznij</button>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState, mapMutations } from 'vuex';

    export default {
        mixins: [mixins],

        computed: {
            ...mapState({
                waitingForInitialization: state => state.facebook.waitingForInitialization,
                showManualLogoutButton: state => state.facebook.showManualLogoutButton,
            }),
        },
    }
</script>
