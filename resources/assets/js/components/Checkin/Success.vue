<template>
    <section class="section-success">
        <div class="row">
            <dl class="info">
                <dt v-if="sendingState.upload">Przesyłanie danych<span class="ellipsis-anim" v-if="!uploadFinished"><span>.</span><span>.</span><span>.</span></span></dt>
                <dd class="success" v-if="sendingState.upload_done"><i class="fa fa-check-circle"></i> OK</dd>
                <dd class="error" v-if="sendingState.upload_failed"><i class="fa fa-times-circle"></i> ERR</dd>
                <dt v-if="sendingState.logging_out && !clickedOnFacebookLogout">Wylogowywanie<span class="ellipsis-anim" v-if="!logoutFinished"><span>.</span><span>.</span><span>.</span></span></dt>
                <dd class="success" v-if="sendingState.logging_out_done"><i class="fa fa-check-circle"></i> OK</dd>
                <dd class="success" v-else-if="sendingState.logging_out_failed && !clickedOnFacebookLogout"><i class="fa fa-times-circle"></i> ERR</dd>
            </dl>
            <div class="text-center" v-if="sendingState.redirecting">
                <hr>
                <p v-if="sendingState.upload_done">Dziękujemy za oddanie krwi!</p>
                <p v-else-if="sendingState.upload_failed" class="error">{{ error.message }}</p>
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

            uploadFinished() {
                return this.sendingState.upload_done || this.sendingState.upload_failed
            },

            logoutFinished() {
                return this.sendingState.logging_out_done || this.sendingState.logging_out_failed
            },

            ...mapState([
                'sendingState',
                'error',
                'clickedOnFacebookLogout'
            ])
        }
    }
</script>
