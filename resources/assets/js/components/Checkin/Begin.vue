<template>
    <section class="section-begin">
        <a class="btn btn-primary btn-lg btn-rozpocznij" v-on:click="nextStep()" href="#">Rozpocznij</a>
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
