

<template>
  <div id="App" >
  
     <Register v-if="RegisterClick == true"   />
     <div v-else>
         <div>
      <body v-if="Logged">

        <Sidebar />
        <Chat  v-if="clickedChat !== null" />
      </body>
  
      <Login v-else-if="RegisterClick == false"    />
     
      <h3>status: {{ Logged }} </h3>
      <h3>User: {{ LogID }}</h3> 
  
    </div>
     </div>
      
  </div>

</template>                                         

<script>

//import HelloWorld from './components/HelloWorld.vue'
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Sidebar from "./components/Sidebar.vue";
import Chat from "./components/Chat.vue";
// import Vue from 'vue'
import { store, mutations } from "./store";


export default {
  name: "App",
  components: {
    Login,
    Register,
    Sidebar,
    Chat
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
    // this.setLogID(return of fetch);
    //   this.toggleNavbar();
    //TODO: put fetch here for intial values
    //3
    //    let url = "/login";
    //    fetch(url, {
    //      method: "POST",
    //      headers: {
    //        "Content-Type": "application/json",
    //      },
    //      body: JSON.stringify({
    //        username: this.username,
    //        password: this.password,
    //      }),
    //    })
    //      .then((res) => res.json())
    //      .then((obj) => this.$store.set("LogID", obj))
    //      .catch(function (error) {
    //        console.log(error);
    //     });
    //if (store.LogID  !== null) {
    //  store.Logged = false;
    //  store.LogID = 13;
    //}
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
    clickedChat: function (){
      return store.ClickedChat;
    }
  },
};
</script>

<style>
body{
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
