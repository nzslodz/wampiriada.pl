
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import Vuelidate from 'vuelidate'

import { mapState } from 'vuex'

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
        'currentView': 0,
        'staticData': {
            'shirtSizes': shirtSizes,
            'bloodTypes': {
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
            'year': (new Date()).getFullYear(),
            'viewTitles': [
                'Rozpocznij',
                'Dane statystyczne',
                'Prywatność',
                'Twoje dane',
                'Wysyłanie danych',
            ],
            'previousStepVisibility': [
                false,
                false,
                true,
                true,
                false,
            ]
        },
        'userInput': {
            'bloodType': null,
            'chosenSize': null,
            'firstTime': false,
        }
    },
    mutations: {
        'nextStep': state => state.currentView++,
        'previousStep': state => state.currentView--,

        setShirtSize(state, value) {
            state.userInput.chosenSize = value
        },

        setBloodType(state, value) {
            state.userInput.bloodType = value
        },

        setFirstTime(state, value) {
            state.userInput.firstTime = value
        },
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
    computed: mapState([
        'currentView',
    ])
});
