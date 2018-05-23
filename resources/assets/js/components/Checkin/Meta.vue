<template>
    <div class="meta">
        <header data-hidable role="navigation" :class="currentView > 0 ? 'visible' : 'invisible'">
            <a data-hidable :class="['btn', 'btn-navigation-back', previousStepClasses]" @click="previousStep()">&lt;</a>

            <h1>{{ currentViewTitle }}</h1>
        </header>

        <div class="bar" :style="barSize"></div>

        <footer>
            <p>Copyright &copy; 2014 - {{ currentYear }} <a href="http://nzs.lodz.pl">NZS Regionu Łódzkiego</a>. <a href="/facebook/privacy_policy">Polityka prywatności</a>.</p>
        </footer>
    </div>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState, mapGetters } from "vuex";

    export default {
        mixins: [mixins],

        computed: {
            ...mapGetters([
                'currentView',
                'currentViewTitle',
            ]),
            ...mapState({
                currentYear: state => state.staticData.year,
            }),

            barSize() {
                return {
                    width: (100 * this.$store.state.currentSlide / (this.$store.getters.viewLength - 1)) + "%",
                };
            },

            previousStepClasses() {
                var isVisible = this.$store.getters.currentViewPreviousStepVisibility;

                return {
                    invisible: !isVisible
                }
            }
        },

        mounted() {
            console.log('Component ready.')
        }
    }
</script>
