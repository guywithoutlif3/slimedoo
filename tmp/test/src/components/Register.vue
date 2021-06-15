<template>
  <div>
    <img src="../assets/logo.png" />
    <div id="emptySqure"></div>
    <form action="/" class="Register">
      <div id="wrappContent">
        <h1>Register</h1>

        <input
          v-model="username"
          id="username"
          name="username"
          placeholder="username"
          required
        />

        <input
          v-model="prename"
          id="prename"
          name="prename"
          placeholder="prename"
          required
        />

        <input
          v-model="lastname"
          id="lastname"
          name="lastname"
          placeholder="lastname"
          required
        />

        <input
          v-model="password"
          type="password"
          name="password"
          placeholder="password"
          required
        />
      </div>
      <div id="buttonWrapper">
        <input v-on:click.prevent="clearcheck();register();" id="login" type="submit" value="Submit" />
        <button class="inline" @click="switchTo">Back to Login</button>
        <p>{{error}}</p>
      </div>
    </form>
  </div>
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
      check: [],
      error: "",
    };
  },
  computed: {},
  methods: {
    switchTo: function (event) {
      event.preventDefault();
      store.RegisterClick = false;
    },
    async register() {
     
      
      let url1 = "/friends/" + this.username;
      const response1 = await fetch(url1);
      const friend = await response1.json();
      this.check = friend;
      if(this.check == [] || this.check == "" || Object.keys(this.check).length === 0 && this.check.constructor === Object){
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
        .then((store.RegisterClick = false))
        .catch(function (error) {
          console.log(error);
        });
        }else{
          this.error = "user already exists please choose other username";
        }
    },
    clearcheck: function(){
      this.check = [];
    }
  },
};
</script>

<style scoped>
h1 {
  position: relative;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy;
  font-size: 50px;
  text-align: center;
  margin: 0%;
}
form {
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
</style>