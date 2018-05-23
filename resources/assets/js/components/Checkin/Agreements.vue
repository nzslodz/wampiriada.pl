<template>
    <section class="section-agreements">
        <div class="content">
            <div v-if="!extendedAgreementsView">
                <p>Za chwilę poprosimy Cię o e-mail, imię i nazwisko, których używamy, aby:</p>
                <ol>
                    <li>prowadzić listę wydanych koszulek;</li>
                    <li>móc powiadomić Cię o kolejnych edycjach Wampiriady;</li>
                    <li>móc powiadomić Cię o innych działaniach NZSu;</li>
                    <li>zaprosić Cię do wzięcia udziału w Wampiriadowym konkursie.</li>
                </ol>
                <p>Możesz też zalogować się Facebookiem. Twoje dane pobierzemy automatycznie.</p>

                <div class="text-center btn-margin">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default btn-main btn-primary" type="button" @click="consentToAll()"><i class="fa fa-check"></i> Zgadzam się</button>
                        <button type="button" class="btn btn-default btn-extend btn-primary" @click="extendAgreementsView()"><i class="fa fa-cog"></i> Zarządzaj</button>
                    </div>
                </div>
                <div class="text-center btn-margin">
                    <button type="button" class="btn btn-transparent" @click="consentToNone()">Nie, dziękuję</button>
                </div>
            </div>
            <div v-else class="container">
                <div class="row row-first">
                    <div class="col-sm-4">
                        <h2>Przetwarzanie danych</h2>

                        <ul>
                            <li>Zapiszemy Twoje imię, nazwisko i e-mail na liście odbioru koszulek.</li>
                            <li>Otrzymasz e-maila z podziękowaniem po akcji Wampiriady.</li>
                            <li>Możesz wziąć udział w naszych konkursach.</li>
                        </ul>

                        <div class="text-center snap-to-bottom">
                            <button type="button" :class="['btn', 'btn-lg', 'btn-toggle', {'active': consentDataProcessing}]" v-bind:aria-pressed="consentDataProcessing ? 'true' : 'false'" autocomplete="off" @click="consentTo('dataProcessing')">
                                <div class="handle"></div>
                            </button>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h2>E-maile Wampiriady</h2>

                        <ul>
                            <li>Otrzymasz e-maile o nadchodzących edycjach Wampiriady.</li>
                            <li>Otrzymasz e-maile, dzięki którym będziesz w stanie pomóc nam w promocji Wampiriady.</li>
                        </ul>

                        <div class="text-center snap-to-bottom">
                            <button type="button" :class="['btn', 'btn-lg', 'btn-toggle', {'active': consentEmailWampiriada}]" v-bind:aria-pressed="consentEmailWampiriada ? 'true' : 'false'" autocomplete="off" @click="consentTo('emailWampiriada')">
                                <div class="handle"></div>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <h2>E-maile NZS</h2>

                        <ul>
                            <li>Otrzymasz e-maile o innych działaniach NZSu.</li>
                        </ul>

                        <p>Obiecujemy nie wysyłać zbyt wiele takich e-maili (nie więcej niż 2 w miesiącu).</p>

                        <div class="text-center snap-to-bottom">
                            <button type="button" :class="['btn', 'btn-lg', 'btn-toggle', {'active': consentEmailNZS}]" v-bind:aria-pressed="consentEmailNZS ? 'true' : 'false'" autocomplete="off" @click="consentTo('emailNZS')">
                                <div class="handle"></div>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-right">
                        <button type="button" class="btn btn-default btn-primary btn-margin" v-on:click="nextStep()">Przejdź dalej</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapMutations, mapState } from 'vuex'

    export default {
        mixins: [mixins],

        computed: {
            ...mapState([
                'extendedAgreementsView',
            ]),

            ...mapState({
                consentDataProcessing: state => state.userInput.agreements.dataProcessing,
                consentEmailWampiriada: state => state.userInput.agreements.emailWampiriada,
                consentEmailNZS: state => state.userInput.agreements.emailNZS,
            }),
        },

        methods: {
            ...mapMutations([
                'consentToNone',
                'consentToAll',
                'extendAgreementsView',
            ]),

            consentTo(key) {
                this.$store.commit('consentToSelected', {
                    key,
                    value: !this.$store.state.userInput.agreements[key]
                });
            }
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
