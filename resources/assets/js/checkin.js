
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

function waitPromise(time) {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve()
        }, time)
    });
}

window.FBPromises = {
    getLoginStatus() {
        return new Promise((resolve) => {
            FB.getLoginStatus((response) => {
                console.log("FB.getLoginStatus");
                console.log(response);

                resolve(response);
            });
        });
    },

    logout() {
        return new Promise((resolve) => {
            FB.logout((response) => {
                console.log("FB.logout");
                console.log(response);
                resolve(response);
            })
        })
    },

    login() {
        return new Promise((resolve) => {
            FB.login(function(response) {
                console.log('FB.login')
                console.log(response)
                resolve(response);
            }, {
                scope: 'email'
            });
        })
    },

    getProfileData() {
        return new Promise((resolve) => {
            FB.api('/me', { locale: 'pl_PL', fields: 'name,email,first_name,last_name' }, function(response) {
                console.log('FB.api /me')
                console.log(response)

                resolve(response)
            });
        })
    }
}

// main datastore and view declarations
const store = new Vuex.Store({
    state: {
        currentSlide: 0,
        loginStepDisabled: false,
        extendedAgreementsView: false,
        chosenDataProvider: false,

        sendingState: {
            'upload': false,
            'upload_done': false,
            'logging_out': false,
            'logging_out_done': false,
            'logging_out_failed': false,
            'redirecting': false,
        },

        facebook: {
            waitingForProfileData: false,
            showManualLogoutButton: false,
        },

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
            facebook_id: null,

            agreementDataProcessing: false,
            agreementEmailWampiriada: false,
            agreementEmailNZS: false,
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
            state.userInput.agreementEmailNZS = true
            state.userInput.agreementDataProcessing = true
            state.userInput.agreementEmailWampiriada = true

            state.currentSlide++
        },

        consentToSelected(state, payload) {
            state.userInput['agreement' + payload.key] = payload.value

            if(payload.key == 'DataProcessing') {
                state.loginStepDisabled = !payload.value

                if(payload.value === false) {
                    state.userInput.agreementEmailNZS = false
                    state.userInput.agreementEmailWampiriada = false
                }
            } else if(payload.value === true) {
                state.userInput.agreementDataProcessing = true
                state.loginStepDisabled = false
            }
        },

        consentToNone(state) {
            state.userInput.agreementEmailNZS = false
            state.userInput.agreementDataProcessing = false
            state.userInput.agreementEmailWampiriada = false

            state.loginStepDisabled = true
            state.currentSlide++
        },

        extendAgreementsView(state) {
            state.extendedAgreementsView = true;
            state.userInput.agreementDataProcessing = true;
        },

        setEmail(state, payload) {
            state.userInput.email = payload;
        },

        setName(state, payload) {
            state.userInput.name = payload;
        },

        chooseDataProvider(state, payload) {
            if(payload == 'manual' && state.chosenDataProvider == 'facebook') {
                state.facebook.showManualLogoutButton = true;
            }

            state.chosenDataProvider = payload;

            if(payload == 'facebook') {
                state.facebook.waitingForProfileData = true;
            }
        },

        gotDataFromFacebook(state, payload) {
            state.facebook.waitingForProfileData = false;

            state.userInput.email = payload.email;
            state.userInput.name = payload.name;
            state.userInput.facebook_id = payload.id;
        },

        showManualLogoutButton(state, payload) {
            state.facebook.showManualLogoutButton = true;
        },

        pushSendingState(state, payload) {
            state.sendingState[payload] = true
        }
    },

    actions: {
        async initializeFacebook({ dispatch, commit }) {
            const loginResponse = await FBPromises.getLoginStatus();

            if(!loginResponse.authResponse) {
                if(loginResponse.status == 'not_authorized') {
                    commit('showManualLogoutButton')
                }

                return;
            }

            await FBPromises.logout();
        },

        async send({ commit, state }) {
            commit('pushSendingState', 'upload')

            const response = await axios.post('/api/wampiriada/v1/checkin', state.userInput)

            commit('pushSendingState', 'upload_done')

            await waitPromise(500);

            commit('pushSendingState', 'logging_out')

            if(!state.facebook.showManualLogoutButton) {
                await FBPromises.logout();

                commit('pushSendingState', 'logging_out_done')

                await waitPromise(500);

                commit('pushSendingState', 'redirecting')

                let seconds = 10;

                commit('setRedirectCount', seconds)

                for(let i = seconds; i >= 0; i--) {

                    await waitPromise(1000)

                    commit('setRedirectCount', i)
                }

                window.location.reload();

            } else {
                await waitPromise(100);

                commit('pushSendingState', 'logging_out_failed')
            }
        },

        async doFacebookLogin({ commit }) {
            commit('chooseDataProvider', 'facebook')

            const loginResponse = await FBPromises.login()

            if(!loginResponse.authResponse) {
                commit('showManualLogoutButton')

                return;
            }

            const profileResponse = await FBPromises.getProfileData()

            store.commit('gotDataFromFacebook', profileResponse)
        }
    }
});

Vue.component('section-begin', require('./components/Checkin/Begin.vue'));
Vue.component('section-agreements', require('./components/Checkin/Agreements.vue'));
Vue.component('section-login-confirm', require('./components/Checkin/Login.vue'));
Vue.component('section-statistics', require('./components/Checkin/Statistics.vue'));
Vue.component('section-success', require('./components/Checkin/Success.vue'));
Vue.component('meta-component', require('./components/Checkin/Meta.vue'));

window.fbHasLoaded = function() {
    store.dispatch('initializeFacebook')
}

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
