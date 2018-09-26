import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import state from '@scripts/store/state.js';
import mutations from '@scripts/store/mutations.js';
import actions from '@scripts/store/actions.js';
import getters from '@scripts/store/getters.js';

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
});
