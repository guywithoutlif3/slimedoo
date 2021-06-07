<template>
  <form action="/" class="Register">
    <h1>Register</h1>
    <label class="content" for="username">username: </label><br />
    <input v-model="username" id="username" name="username" required /><br />

    <label class="content" for="prename" >prename: </label><br />
    <input v-model="prename" id="prename" name="prename" required /><br /><br />

    <label class="content" for="lastname">lastname: </label><br />
    <input v-model="lastname" id="lastname" name="lastname" required /><br /><br />

    <label class="content" for="password">password: </label><br />
    <input v-model="password" id="password" name="password" required /><br /><br />

    <input @click="register" type="submit" value="Submit" />

    <label> Back to Login </label>
    <button @click="switchTo"></button>


  </form>
</template>   
<script>
// import Vue from 'vue'
//import { store, mutations } from "./../store";
import { store } from "./../store";
export default {
  name: "Login",

  data: function () {
    return {
      username: "",
      prename: "",
      lastname: "",
      password: "",
    };
  },
  computed: {

  },
  methods: {
    switchTo: function (event) {
      event.preventDefault();
      store.RegisterClick = false;
    },
    register: function (event) {
      event.preventDefault();
      let url = "/users/add";
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.username,
          prename: this.prename,
          lastname: this.lastname,
          password: this.password,
        }),
      })
      .then(store.RegisterClick = false)
      .catch(function (error) {
        console.log(error);
      });
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