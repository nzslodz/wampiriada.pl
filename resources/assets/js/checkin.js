
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
        clickedOnFacebookLogout: false,

        error: {
            message: null,
        },

        counters: {
            manualLogout: 60,
            success: 10,
        },

        sendingState: {
            upload: false,
            upload_done: false,
            upload_failed: false,
            logging_out: false,
            logging_out_done: false,
            logging_out_failed: false,
            redirecting: false,
        },

        facebook: {
            waitingForInitialization: true,
            waitingForProfileData: false,
            showManualLogoutButton: false,
            loginStatus: null,
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
                '',
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

        showLoginOptionsScreen(state) {
            if(state.chosenDataProvider == 'manual') {
                return false;
            }

            if(state.facebook.loginStatus == 'connected') {
                return false;
            }

            return true;
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
            // when logged in to API you can still get the unknown response
            // so just make a fallback if someone does not complete the process
            if(payload == 'manual' && state.chosenDataProvider == 'facebook') {
                state.facebook.showManualLogoutButton = true;
            }

            state.chosenDataProvider = payload;
        },

        gotDataFromFacebook(state, payload) {
            state.facebook.waitingForProfileData = false;

            state.userInput.email = payload.email;
            state.userInput.name = payload.name;
            state.userInput.facebook_id = payload.id;
        },

        facebookLoginFinishedWithStatus(state, payload) {
            state.facebook.loginStatus = payload;

            if(payload == 'connected') {
                state.facebook.waitingForProfileData = true;
            } else if(payload == 'not_authorized') {
                state.facebook.showManualLogoutButton = true;
            }
        },

        pushSendingState(state, payload) {
            state.sendingState[payload] = true
        },

        namedNonRecoverableError(state, { message }) {
            state.error.message = message
        },

        facebookInitializationFinishedWithStatus(state, payload) {
            state.facebook.waitingForInitialization = false;

            if(payload == 'not_authorized') {
                state.facebook.showManualLogoutButton = true;
            }
        },

        setClickedOnFacebookLogout(state) {
            state.clickedOnFacebookLogout = true;
        },

        decrementCounter(state, payload) {
            state.counters[payload]--
        }
    },

    actions: {
        async consentToNone({ dispatch, commit }) {
            commit('consentToNone')

            await dispatch('dispatchSendAction')
        },

        async initializeFacebook({ dispatch, commit }) {
            const loginResponse = await FBPromises.getLoginStatus();

            commit('facebookInitializationFinishedWithStatus', loginResponse.status);

            if(!loginResponse.authResponse) {
                return;
            }

            await FBPromises.logout();
        },

        async waitOnCounter({ commit, state }, payload) {
            while(state.counters[payload] > 0) {
                await waitPromise(1000)

                commit('decrementCounter', payload)
            }
        },

        async showManualLogoutStep({ commit, dispatch }) {
            commit('pushSendingState', 'logging_out')

            await waitPromise(1000);

            commit('pushSendingState', 'logging_out_failed')
        },

        async doAutomaticLogoutStep({ commit, dispatch }) {
            commit('pushSendingState', 'logging_out')

            await Promise.all([
                FBPromises.logout(),
                waitPromise(1500)
            ]);

            commit('pushSendingState', 'logging_out_done')

            await dispatch('doReload');
        },

        async doReload({ commit, dispatch }) {
            commit('pushSendingState', 'redirecting')

            await dispatch('waitOnCounter', 'success')

            window.location.reload();
        },

        async dispatchSendAction({ commit, state, dispatch }) {
            commit('nextStep')

            commit('pushSendingState', 'upload')

            try {
                await Promise.all([
                    axios.post('/api/wampiriada/v1/checkin', state.userInput),
                    waitPromise(1500)
                ])

                commit('pushSendingState', 'upload_done')

            } catch(err) {
                if(err.response && err.response.data && err.response.data.str_code) {
                    switch(err.response.data.str_code) {
                        case 'MULTIPLE_CHECKIN':
                            commit('namedNonRecoverableError', {
                                message: 'Już raz oddano krew w tej edycji z użyciem Twojego adresu e-mail. Jeśli to pomyłka, spróbuj z użyciem innego e-maila.'
                            })

                            break;

                        case 'CHECKIN_NOT_AVAILABLE':
                            commit('namedNonRecoverableError', {
                                message: 'Dziś nie ma żadnej zaplanowanej akcji krwiodawstwa.'
                            })

                            break;
                    }
                } else {
                    commit('namedNonRecoverableError', {
                        message: 'Wystąpił nieoczekiwany błąd. Przeładuj proszę stronę. Przepraszamy za problemy.'
                    })
                }

                commit('pushSendingState', 'upload_failed')
            }

            await waitPromise(750);

            if(state.facebook.showManualLogoutButton) {
                await dispatch('showManualLogoutStep')
            } else if(state.chosenDataProvider == 'facebook') {
                await dispatch('doAutomaticLogoutStep')
            } else {
                // manual or no consent
                await dispatch('doReload')
            }
        },

        async doFacebookLogin({ commit }) {
            commit('chooseDataProvider', 'facebook')

            const loginResponse = await FBPromises.login()

            commit('facebookLoginFinishedWithStatus', loginResponse.status)

            if(!loginResponse.authResponse) {
                return;
            }

            const profileResponse = await FBPromises.getProfileData()

            store.commit('gotDataFromFacebook', profileResponse)
        },

        async allowLogoutThenReload({ commit, dispatch }) {
            commit('setClickedOnFacebookLogout')

            await dispatch('waitOnCounter', 'manualLogout')

            window.location.reload();
        }
    }
});

Vue.component('section-begin', require('./components/Checkin/Begin.vue'));
Vue.component('section-agreements', require('./components/Checkin/Agreements.vue'));
Vue.component('section-login-confirm', require('./components/Checkin/Login.vue'));
Vue.component('section-statistics', require('./components/Checkin/Statistics.vue'));
Vue.component('section-success', require('./components/Checkin/Success.vue'));
Vue.component('meta-component', require('./components/Checkin/Meta.vue'));
Vue.component('manual-logout', require('./components/Checkin/ManualLogout.vue'));

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
