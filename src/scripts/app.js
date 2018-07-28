import store from '@scripts/store';
import router from '@scripts/router';
import App from './App.vue';
import pagination from 'vuejs-uib-pagination';
import { escapeBrackets, dateToISOString, formatBaseLink, formatDate } from '@scripts/utils';

const config = require('../config.json');

// Service Worker
if (process.env.NODE_ENV === 'production' && 'serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker
      .register(config.publicPath + '/dist/sw.js', { scope: '/' })
      .then(registration => {
        registration.update();
      })
      .catch(err => {
        console.log('[Service Worker] failed: ', err);
      });
  });
}

Vue.use(pagination);

// Vue global mixin
Vue.mixin({
  filters: {
    escapeBrackets,
    dateToISOString,
    formatBaseLink,
    formatDate,
  },
});

new Vue({
  el: '#app',
  store,
  router,
  render: h => h(App),
});
