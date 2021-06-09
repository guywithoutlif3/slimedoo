import Vue from 'vue'
import App from './App.vue'
Vue.config.productionTip = false
import { store, mutations } from "./store";


// const $store = new VueStore();

Vue.use(store);
Vue.use(mutations);


new Vue({
  mutations,
  store,
  render: h => h(App),
  // $store: $store,
}).$mount('#app')
