import Vue from 'vue'
import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { InMemoryCache } from 'apollo-cache-inmemory'
import HighchartsVue from 'highcharts-vue'
import BootstrapVue from 'bootstrap-vue'


import VueApollo from 'vue-apollo'

const httpLink = new HttpLink({
  uri: 'http://localhost:8000/graphql'
});

// Create the apollo client
const apolloClient = new ApolloClient({
  link: httpLink,
  cache: new InMemoryCache(),
  connectToDevTools: true,
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueApollo);
Vue.use(HighchartsVue);
Vue.use(BootstrapVue);

Vue.component('feeds', require('./components/FeedComponent.vue'));
Vue.component('timelines', require('./components/TimelineComponent.vue'));


const apolloProvider = new VueApollo({
  defaultClient: apolloClient,
});

new Vue({
    el: '#app',
    provide: apolloProvider.provide()
});
