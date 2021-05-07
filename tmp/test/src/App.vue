

<template>
  <div id="App">
      {{ this.Logged }}

      <login/>
          
  </div>  
</template>                                         

<script>

//import HelloWorld from './components/HelloWorld.vue'
import Login from './components/Login.vue'

export default {
  name: 'App',
  components: {
    //HelloWorld,
    
    Login
  } ,
  methods: {
    el: "Login",
    data: function () {
      return {
        message: "SDFhjiovycpc",
      Logged: sessionStorage.getItem('key')
      };
    },
}}

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
