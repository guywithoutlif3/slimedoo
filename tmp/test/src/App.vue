

<template>
  <div id="App">
    <div>
      <h1>If-Else-Test 1</h1>

      <body v-if="Logged">
        if true display this
      </body>
      <Login v-else />
      <h3>status: {{ Logged }}</h3>
      <h3>User: {{ LogID }}</h3>
    </div>
  </div>
</template>                                         

<script>
//import HelloWorld from './components/HelloWorld.vue'
import Login from "./components/Login.vue";
// import Vue from 'vue'
import { store, mutations } from "./store";

export default {
  name: "App",
  components: {
    Login,
  },
  // props: {
  //   isLogged: { type: Boolean, required: false },
  //   LogID: { type: Number, required: false }
  // },  
  // data: function () {
  //   return {
  //     Logged: this.getLogID(),
  //     LogID: store.LogID
  //   };
  // },
  created: function () {
   // this.setLogID(0);
 //   this.toggleNavbar();
//TODO: put fetch here for intial values
  }, 
  methods: {
    toggleLogged() {
      mutations.toggleLogged();
    },
    setLogID(value) {
      mutations.setLogID(value);
    }
  },
  computed: {
    Logged: function() {
      return store.Logged;
    },
    LogID: function() {
      return store.LogID;
    }
  },
};
</script>

<style>
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
