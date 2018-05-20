<template>
    <section>
        Trwa wysyłanie - SUKCES
        <a href="">Dzięki!</a>
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
