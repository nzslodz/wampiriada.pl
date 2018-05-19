<template>
    <section>
        Logowanie (hide this jeśli zgody) - continue with Facebook lub (podaj dane)
        Podaj/potwierdź dane (hide this jeśli zgody)
        <button v-on:click="nextStep()" type="button">yo</button>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';

    export default {
        mixins: [mixins],

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
