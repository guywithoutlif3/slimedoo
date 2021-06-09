<template>
  <div>
    
    <img src="../assets/logo.png">
       <div id="emptySqure"></div>
    <form action="/" class="Login">
 
      <div id="wrappContent">
        <h1>Login</h1>
        <input
          v-model="username"
          class="username"
          name="username"
          placeholder="Username: "
        /><br />
        <input
          type="password"
          v-model="password"
          class="password"
          name="password"
          placeholder="Password: "
        /><br /><br />
        <div id="buttonWrapper">
          <input @click="login" id="login" type="submit" value="Submit" />
    
          <button class="inline" @click="switchTo">Register</button>
        </div>
          
      </div>
    </form>
  </div>
</template>   
<script>
// import Vue from 'vue'
import { store, mutations } from "./../store";
export default {
  name: "Login",

  data: function () {
    return {
      username: "",
      password: "",
    };
  },
  computed: {
    Logged: function () {
      return store.Logged;
    },
    LogID: function () {
      return store.LogID;
    },
  },
  methods: {
    setLogID(value) {
      mutations.setLogID(value);
    },
    switchTo: function (event) {
      event.preventDefault();
      store.RegisterClick = true;
    },

    login: function (event) {
      event.preventDefault();
      //return;
      //sessionStorage.setItem("isKey",false) -- Old shitty way of doing it -- for learning purposes
      // this.$store.set("Logged", false);
      // document.write("<h1>",this.password," ",this.username,"</h1>")
      let url = "/login";

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.username,
          password: this.password,
        }),
      })
        .then((res) => res.json())
        .then((obj) => (store.LogID = obj))
        .then(function () {
          if (store.LogID != 0) {
            store.Logged = true;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
      //document.write("<h1> password Test:",this.password,"</h1>");
    },
  },
};
</script>

<style scoped>
img{
  position: absolute;
  margin: 0%;
  padding: 0%;
  border: 0;
}
h1{
  position: relative;
  font-family: Copperplate, "Copperplate Gothic Light", 
  fantasy; font-size: 50px;
  text-align: center;
  margin: 0%;
}
form {
  display: flex;
  width: 20%;
  height: 20%;
  padding: 20px;
  background-color: #bbebfa;

  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
}
#wrappContent {
  
  text-align: center;
  margin: 15px;
}
input {
  text-align: center;
}
#emptySqure {
  overflow: auto;
  position: absolute;
  height: 25%;
  width: 20%;
  background-color: #ffc145;
  top: 35%;


  right: 37.5%;
  margin: auto;
}

.inline,
#login {
  background-color: #ffc145;
  flex: 50%;
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  border-radius: 15px;
  margin: 0 15px;
}
#buttonWrapper {
  display: flex;
  padding: 0 75px;
}
</style>