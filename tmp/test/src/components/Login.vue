<template>
  <form class="Login">
    <label for="username">username: </label><br />
    <input v-model="username" id="username" name="username" /><br />
    <label for="password">password: </label><br />
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

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.username,
          password: this.password,
        }),
      }).catch(function (error) {
        console.log(error);
      });
    },
  },
};
</script>

<style scoped>
</style>