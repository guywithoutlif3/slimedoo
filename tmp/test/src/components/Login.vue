<template>
  <form action="/" class="Login">
    <h1>Login</h1>
    <label class="content" for="username">username: </label><br />
    <input v-model="username" id="username" name="username" /><br />
    <label class="content" for="password">password: </label><br />
    <input v-model="password" id="password" name="password" /><br /><br />
    <input @click="login" type="submit" value="Submit" />

      <div v-if="Logged">
        if true display this
      </div>    
  </form>
</template>   
<script>
// import Vue from 'vue'
import { store, mutations } from "./../store";
export default {
  name: "Login",

  data: function () {
    return {
      username: "",
      password: ""      
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
  methods: {
    setLogID(value) {
      mutations.setLogID(value);
    },   
    login: function (event) {
      event.preventDefault();
      this.setLogID(9999990);
      return;
      //sessionStorage.setItem("isKey",false) -- Old shitty way of doing it -- for learning purposes
      // this.$store.set("Logged", false);
      // document.write("<h1>",this.password," ",this.username,"</h1>")
      // let url = "/login";
      // fetch(url, {
      //   method: "POST",
      //   headers: {
      //     "Content-Type": "application/json",
      //   },
      //   body: JSON.stringify({
      //     username: this.username,
      //     password: this.password,
      //   }),
      // })
      //   .then((res) => res.json())
      //   .then((obj) => this.$store.set("LogID", obj))
      //   .catch(function (error) {
      //     console.log(error);
      //   });
      // if (this.$store.get("LogID") !== null) {
      //   this.$store.set("Logged", true);
      // }
    }
    
  }
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