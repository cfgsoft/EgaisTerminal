import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

import orders from './modules/Orders';

export default new Vuex.Store({
  modules:{
    orders
  },

})
