<template>
  <div>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <img src="../assets/logo.png" />
    <div id="emptySqure"></div>
    <div id="form">
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
img {
  position: absolute;
  margin: 0%;
  padding: 0%;
  border: 0;
}
h1 {
  position: relative;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy;
  font-size: 2vw;
  text-align: center;
  margin: 0%;
}
#form {
  width: 20%;
  height: 20%;
  padding: 1%;
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
  max-width: 100%;
  max-height: 100%;
}
input {
  text-align: center;
  max-width: 100%;
  max-height: 100%;
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
  position: relative;
  background-color: #ffc145;
  flex: 50%;
  max-height: 100%;
  max-width: 100%;
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  border-radius: 15px;
  margin: 0 15px;
}
@media only screen and (max-width: 706px) {
  .inline,
  #login {
    position: relative;
    background-color: #ffc145;
    box-shadow: 0 0 0 1px black;

    margin-bottom: 10px;
    border-radius: 15px;
    margin: 0 15px;
  }
}
</style>