require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import { router } from './router'
import { BootstrapVue } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueRouter);
Vue.use(BootstrapVue);

new Vue({
    router: router,
    render: h => h(App),
}).$mount('#app');
