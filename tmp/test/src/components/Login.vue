<template>
  <form  action="/" class="Login">
    <h1>Login</h1>
    <label class="content" for="username">username: </label><br />
    <input v-model="username" id="username" name="username" /><br />
    <label class="content" for="password">password: </label><br />
    <input v-model="password" id="password" name="password" /><br /><br />
    <input @click="login" type="submit" value="Submit" />
 
  </form>
</template>   
<script>
export default {
  name: "Login",

  props: {},
  methods: {
    el: "Login",
    data: function () {
      return {
        username: "",
        password: "",
      };
    },
    login: function (event) {
      event.preventDefault();
   
      // document.write("<h1>",this.password," ",this.username,"</h1>")
      let url = "/login";
      var obj;
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
        .then((data) => (obj = data))
        .then(() => sessionStorage.setItem("key",obj))
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