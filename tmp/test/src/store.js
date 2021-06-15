import Vue from "vue";

export const store = Vue.observable({
  LogID: 0,
  Logged: false,
  Test: true,
  RegisterClick: false,
  ClickedChat: null,
  ClickedChatUsername: null,
  IfProfileClick: false,
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
  setClickedChat(id){
    store.ClickedChat = id;
  },
  setClickedChatUsername(id){
    store.ClickedChatUsername = id;
  },
  setIfProfileClick(id){
    store.ifProfileClick = id;
  }
};