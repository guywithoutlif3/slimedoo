<template>
  <div>
    <form action="/" class="Login">
      <h1>Login</h1>
      <label class="content" for="username">username: </label><br />
      <input v-model="username" id="username" name="username" /><br />
      <label class="content" for="password">password: </label><br />
      <input
        type="password"
        v-model="password"
        id="password"
        name="password"
      /><br /><br />
      <input @click="login" type="submit" value="Submit" />

      <!--<div v-if="Logged">if true display this</div> -->
    </form>

    <label> Register Page </label>
    <button @click="switchTo"></button>
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
          password: this.password
        }),
      })
        .then((res) => res.json())
        .then((obj) => (store.LogID = obj))
        .then(function () {
          if (store.LogID != 0) {
            //this.setLogID(store.LogID);
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
form {
  width: 100%;
  height: 100%;
  display: inline-block;
  border: 5px solid red;
}
</style>