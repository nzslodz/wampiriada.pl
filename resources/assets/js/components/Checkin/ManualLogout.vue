<template>
    <section class="manual-logout">
        <div v-if="clickedOnFacebookLogout">
            <a href="/facebook/login" class="btn btn-primary btn-large">Przeładuj stronę i zacznij od nowa <span>({{ counter }})</span></a>
        </div>
        <div v-else="showManualLogoutButton">
            Wygląda na to, że nie mogliśmy wylogować Cię automatycznie.
            <a target="_blank" href="https://facebook.com" class="btn btn-primary btn-large" @click="allowLogoutThenReload()">Przejdź na Facebooka</a>, aby wylogować się ręcznie.
        </div>
    </section>
</template>
<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        computed: {
            ...mapState({
                showManualLogoutButton: state => state.facebook.showManualLogoutButton,
                counter: state => state.counters.manualLogout,
            }),

            ...mapState([
                'clickedOnFacebookLogout'
            ])
        },

        methods: {
            ...mapActions([
                'allowLogoutThenReload'
            ])
        }
    }
</script>
