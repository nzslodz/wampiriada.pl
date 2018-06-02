<template>
    <section class="section-begin">
        <div v-if="facebookLoginNeedsReload">
            Wygląda na to, że nie mogliśmy wylogować Cię automatycznie.
            <a target="_blank" href="https://facebook.com" class="btn btn-primary btn-large">Przejdź na Facebooka</a>
        </div>
        <div v-else>
            <a class="btn btn-primary btn-lg btn-rozpocznij" v-on:click="nextStep()" href="#">Rozpocznij</a>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';

    export default {
        mixins: [mixins],

        computed: {
            facebookLoginNeedsReload() {
                return this.$store.state.facebook.loginStatus == 'not_authorized'
            }
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
