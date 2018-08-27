<template>
    <section class="section-success">
        <div class="row">
            <dl class="info">
                <dt v-if="sendingState.upload">Przesyłanie danych...</dt>
                <dd class="success" v-if="sendingState.upload_done"><i class="fa fa-check"></i> OK</dd>
                <dd class="error" v-if="sendingState.upload_failed"><i class="fa fa-times"></i> {{ error.message }}</dd>
                <dt v-if="sendingState.logging_out && !clickedOnFacebookLogout">Wylogowywanie</dt>
                <dd class="success" v-if="sendingState.logging_out_done"><i class="fa fa-check"></i> OK</dd>
                <dd class="success" v-else-if="sendingState.logging_out_failed && !clickedOnFacebookLogout"><i class="fa fa-close"></i> Nieudane</dd>
            </dl>
            <div class="text-center" v-if="sendingState.redirecting">
                <p v-if="sendingState.upload_done">Dziękujemy za oddanie krwi!</p>
                <a class="btn btn-large btn-primary" href="/facebook/login">Zakończ ({{ counter }})</a>
            </div>
            <manual-logout v-if="sendingState.logging_out_failed"></manual-logout>
        </div>
    </section>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        computed: {
            ...mapState({
                counter: (state) => state.counters.success,
            }),

            ...mapState([
                'sendingState',
                'error',
                'clickedOnFacebookLogout'
            ])
        }
    }
</script>
