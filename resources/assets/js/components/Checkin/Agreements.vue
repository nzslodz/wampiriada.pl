<template>
    <section>
        Zgody (zastąp zgodami)
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
