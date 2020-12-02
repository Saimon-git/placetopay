import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VueApollo from 'vue-apollo';
import Vuex from "vuex";
import vSelect from 'vue-select';
import { VueSpinners } from '@saeris/vue-spinners'
import Multiselect from 'vue-multiselect';
import Client from './apollo/client';
import Router from './router';
import createPersistedState from "vuex-persistedstate";
import VueToast from 'vue-toast-notification';
import VueTheMask from 'vue-the-mask';
import VeeValidate from 'vee-validate';
import {Validator} from 'vee-validate';

const dictionary = {
    en: {
        attributes: {
            password_confirmation: 'Password Confirmation'
        }
    }
};

Validator.localize(dictionary);

import 'vue-toast-notification/dist/theme-default.css';

Vue.component('VSelect', vSelect);
Vue.component('NavBarProfile', require('./components/navbar').default);
Vue.component('Menu1', require('./components/menu').default);
Vue.component('AsideMenu', require('./components/aside-menu').default);
Vue.component('HeaderComponent', require('./components/header-component').default);
Vue.component('Modal', require('./components/modal').default);
Vue.component('ShowModal', require('./components/show-modal').default);
Vue.component('ModalDelete', require('./components/modal-delete').default);
Vue.component('Pagination', require('./components/pagination').default);
Vue.component('Loading', require('./components/loading').default);
Vue.component('Dropdown', require('./components/drop-down').default);
Vue.component('Multiselect', Multiselect);
Vue.component('PageError', require('./components/page-errors').default);


Vue.use(VueSpinners);
Vue.use(VueRouter);
Vue.use(VueApollo);
Vue.use(Vuex);
Vue.use(VueToast);
Vue.use(VueTheMask);
Vue.use(VeeValidate, {errorBagName: 'vErrors'});

const apolloProvider = new VueApollo({
    defaultClient: Client,
});

const user = window.user ? window.user : {};

const store = new Vuex.Store({
    state: {
        auth: user,
    },
    mutations: {
        updateUser(state, user) {
            state.auth = user;
        },

        clearState(state) {
            state.auth = {};
            state.notification = false;
        }
    },
    plugins: [createPersistedState()],
});

window.store = store;

window.app = new Vue({// eslint-disable-line
    el: '#app',
    store,
    router: Router,
    apolloProvider
});
