

<template>
  <div id="App">
    <!-- checks with vue if for clicking of Regiser button-->
    <Register v-if="RegisterClick == true" />
    <div v-else>
      <div>
        <body v-if="Logged"> <!-- If login was succeful display evertyhing in Body -->
          <Sidebar /> <!-- display Sidebar with no condtion -->
          <Chat v-if="clickedChat !== null" /> <!--As soon as a User is Clicked display Chat-->
        </body>

        <Login v-else-if="RegisterClick == false" />  <!-- If Register Click is false the login button is pressed in register -->
            
      </div>
    </div>
  </div>
</template>                                         

<script>
// All Components need to be imported here ...
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Sidebar from "./components/Sidebar.vue";
import Chat from "./components/Chat.vue";
import { store, mutations } from "./store";
//...and Here  :D
export default {
  name: "App",
  components: {
    Login,
    Register,
    Sidebar,
    Chat,
  },
  created: function () {
  },
  methods: {
    toggleLogged() {
      mutations.toggleLogged();
    },
    setLogID(value) {
      mutations.setLogID(value);
    },
  },
  computed: {
    Logged: function () {
      return store.Logged;
    },
    LogID: function () {
      return store.LogID;
    },
    RegisterClick: function () {
      return store.RegisterClick;
    },
    LoginFalse: function () {
      return store.RegisterClick;
    },
    clickedChat: function () {
      return store.ClickedChat;
    },
  },
};
</script>

<style>
body {
  background: #396795;
}
template {
  text-align: center;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
