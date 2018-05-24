
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import Vuelidate from 'vuelidate'

import { mapState, mapGetters } from 'vuex'

Vue.use(Vuelidate)
Vue.use(Vuex)

// reload page after minutes of inactivity (for keeping fresh PHP Facebook SDK nonces)
var idleTime = 0;
var minutesOfInactivity = 5;
var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

document.addEventListener('mousemove', function() {
    idleTime = 0;
});

document.addEventListener('keypress', function() {
    idleTime = 0;
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > minutesOfInactivity) {
        window.location.reload();
    }
};

// main datastore and view declarations
const store = new Vuex.Store({
    state: {
        currentSlide: 0,
        loginStepDisabled: false,
        extendedAgreementsView: false,
        chosenDataProvider: false,

        staticData: {
            shirtSizes: shirtSizes,
            bloodTypes: {
                'a_plus': 'A+',
                'a_minus': 'A-',
                'b_plus': 'B+',
                'b_minus': 'B-',
                'ab_plus': 'AB+',
                'ab_minus': 'AB-',
                'zero_plus': '0+',
                'zero_minus': '0-',
                'unknown': 'Nie wiem'
            },
            year: (new Date()).getFullYear(),

            viewTitles: [
                'Rozpocznij',
                'Dane statystyczne',
                'Prywatność',
                'Twoje dane',
                'Wysyłanie danych',
            ],
            previousStepVisibility: [
                false,
                false,
                true,
                true,
                false,
            ]
        },
        userInput: {
            bloodType: null,
            chosenSize: null,
            firstTime: false,
            name: null,
            email: null,

            agreements: {
                dataProcessing: false,
                emailWampiriada: false,
                emailNZS: false,
            }
        }
    },

    getters: {
        currentView(state) {
            if(state.loginStepDisabled && state.currentSlide >= 3) {
                return state.currentSlide + 1;
            }

            return state.currentSlide;
        },

        viewLength(state) {
            if(state.loginStepDisabled) {
                return 4;
            }

            return 5;
        },

        currentViewTitle(state, getters) {
            return state.staticData.viewTitles[getters.currentView];
        },

        currentViewPreviousStepVisibility(state, getters) {
            return state.staticData.previousStepVisibility[getters.currentView];
        },
    },

    mutations: {
        'nextStep': state => state.currentSlide++,
        'previousStep': state => state.currentSlide--,

        setShirtSize(state, value) {
            state.userInput.chosenSize = value
        },

        setBloodType(state, value) {
            state.userInput.bloodType = value
        },

        setFirstTime(state, value) {
            state.userInput.firstTime = value
        },

        consentToAll(state) {
            state.userInput.agreements = {
                dataProcessing: true,
                emailWampiriada: true,
                emailNZS: true,
            }

            state.currentSlide++
        },

        consentToSelected(state, payload) {
            state.userInput.agreements[payload.key] = payload.value

            if(payload.key == 'dataProcessing') {
                state.loginStepDisabled = !payload.value

                if(payload.value === false) {
                    state.userInput.agreements.emailNZS = false
                    state.userInput.agreements.emailWampiriada = false
                }
            } else if(payload.value === true) {
                state.userInput.agreements.dataProcessing = true
                state.loginStepDisabled = false
            }
        },

        consentToNone(state) {
            state.userInput.agreements = {
                dataProcessing: false,
                emailWampiriada: false,
                emailNZS: false,
            }

            state.loginStepDisabled = true
            state.currentSlide++
        },

        extendAgreementsView(state) {
            state.extendedAgreementsView = true;
            state.userInput.agreements.dataProcessing = true;
        },

        setEmail(state, payload) {
            state.userInput.email = payload;
        },

        setName(state, payload) {
            state.userInput.name = payload;
        },

        chooseDataProvider(state, payload) {
            state.chosenDataProvider = payload;
        }
    }
});

Vue.component('section-begin', require('./components/Checkin/Begin.vue'));
Vue.component('section-agreements', require('./components/Checkin/Agreements.vue'));
Vue.component('section-login-confirm', require('./components/Checkin/Login.vue'));
Vue.component('section-statistics', require('./components/Checkin/Statistics.vue'));
Vue.component('section-success', require('./components/Checkin/Success.vue'));
Vue.component('meta-component', require('./components/Checkin/Meta.vue'));


const app = new Vue({
    el: '#application',
    store,
    computed: {
         ...mapState([
             'loginStepDisabled',
             'currentSlide',
         ]),

         viewsWidth() {
             return {
                 width: (this.$store.getters.viewLength * 100) + 'vw',
             };
         }
    },
});
