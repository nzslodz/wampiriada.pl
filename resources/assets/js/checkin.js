
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import Vuex from 'vuex'
import { mapState } from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        'currentView': 0,
        'tshirtSizes': shirtSizes,
    },
    mutations: {
        'nextStep': state => state.currentView++,
        'previousStep': state => state.currentView--,
    }
});

Vue.component('section-begin', require('./components/Checkin/Begin.vue'));
Vue.component('section-agreements', require('./components/Checkin/Agreements.vue'));
Vue.component('section-login-confirm', require('./components/Checkin/Login.vue'));
Vue.component('section-statistics', require('./components/Checkin/Statistics.vue'));
Vue.component('section-success', require('./components/Checkin/Success.vue'));

const app = new Vue({
    el: '#application',
    store,
    computed: mapState([
        'currentView',
    ])
});

/*$(function() {
    var $views = $('.views')

    $views.find('section').each(function() {
        var $view = $(this)

        $view.find('[data-progress]').click(function() {
            var current_view = parseInt($views.attr('data-view'));

            console.log(current_view)

            $views.attr('data-view', $(this).data('progress') == 'next' ? current_view + 1 : current_view - 1);

            return false;
        })
    })
});
*/
