<template>
    <div class="meta">
        <header data-hidable role="navigation" :class="currentView > 0 ? 'visible' : 'invisible'">
            <a data-hidable :class="['btn', 'btn-default', 'btn-primary', 'pull-left', previousStepClasses]" @click="previousStep()">&lt;</a>

            <h1>{{ currentTitleView }}</h1>
        </header>

        <div data-hidable class="bar"></div>

        <footer>
            <p>Copyright &copy; 2014 - {{ currentYear }} <a href="http://nzs.lodz.pl">NZS Regionu Łódzkiego</a>. <a href="/facebook/privacy_policy">Polityka prywatności</a>.</p>
        </footer>
    </div>
</template>

<script>
    import { default as mixins } from './mixins';
    import { mapState } from "vuex";

    export default {
        mixins: [mixins],

        computed: {
            ...mapState([
                'currentView',
            ]),
            ...mapState({
                currentYear: state => state.staticData.year,
                // XXX HACK
                currentTitleView: state => state.staticData.viewTitles[state.currentView + state.loginStepDisabled]
            }),

            previousStepClasses() {
                var isVisible = this.$store.state.staticData.previousStepVisibility[this.$store.state.currentView]

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
