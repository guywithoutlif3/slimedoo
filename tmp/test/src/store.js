import Vue from "vue";

export const store = Vue.observable({
  LogID: 0,
  Logged: false,
  Test: true,
  RegisterClick: false,
});

export const mutations = {
  toggleLogged() {
    store.Logged = !store.Logged;
  },
  setLogID(id) {
    store.LogID = id;
  },
  setRegisterClick(id){
    store.RegisterClick = id;
  },
};