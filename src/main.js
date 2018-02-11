import 'es6-promise/auto'
import './assets/css/font-awesome.min.css'
import './assets/sass/global.scss'

import Vue from 'vue'
import App from './App'
import { router } from './router'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import store from './store'
import infiniteScroll from 'vue-infinite-scroll'
import axios from 'axios';

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(infiniteScroll)
Vue.router = router

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
