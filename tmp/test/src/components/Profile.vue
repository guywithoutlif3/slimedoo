<template>
  <div id="Profile">
    <p>User info</p>
    <p style="font-size: 15px">
      Change values and click Save for permanent change
    </p>
    <input v-model="usernameInput" type="text" class="userinfo" /> <br />
    <input v-model="prenameInput" type="text" class="userinfo" /><br />
    <input v-model="lastnameInput" type="text" class="userinfo" /><br />
    <button v-on:click.prevent="UpdateUserInfo()" class="userinfo">Save</button>
    <p>{{ error }}{{ success }}</p>
    <p>Change Password</p>
    <p style="font-size: 15px">Enter new Password</p>
    <input
      v-model="passwordInput"
      placeholder="Enter Password"
      type="text"
      class="userinfo"
    />
    <br />
    <input
      v-model="passwordrepeatInput"
      placeholder="Repeat Password"
      type="text"
      class="userinfo"
    />
    <br />
    <button v-on:click.prevent="ChangePassword()" class="userinfo">
      Change Password
    </button>
    <p style="font-size: 15px">{{ errorPassword }}{{ successPassword }}</p>

    <button id="back" v-on:click.prevent="BackClick()">back</button>
  </div>
</template>   
<script>
import { store } from "./../store";
export default {
  name: "Profile",

  data: function () {
    return {
      AllUser: null,
      usernameInput: null,
      prenameInput: null,
      lastnameInput: null,
      passwordInput: null,
      passwordrepeatInput: null,
      check: [],
      error: "",
      success: "",
      errorPassword: "",
      successPassword: "",
      /* username: null,
        prename: null,
        lastname: null,*/
    };
  },

  methods: {
    async UpdateUserInfo() {
      this.error = "";
      this.success = "";
      let url1 = "/friends/" + this.usernameInput;
      const response1 = await fetch(url1);
      const friend = await response1.json();
      this.check = friend;
      if (
        this.check == [] ||
        this.check == "" ||
        (Object.keys(this.check).length === 0 &&
          this.check.constructor === Object) ||
        this.check["0"].username == this.AllUser["0"].username
      ) {
        let url1 = "/users/update/user";
        fetch(url1, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: this.usernameInput,
            prename: this.prenameInput,
            lastname: this.lastnameInput,
          }),
        }).catch(function (error) {
          console.log(error);
        });
        this.success =
          "your profile has been sucessfully updated, either change it again or go back ";
      } else {
        this.error = "this username already has been taken /:";
      }
    },
    ChangePassword() {
      this.successPassword = "";
      this.errorPassword = "";
      let url1 = "/users/update/password";
      if (this.passwordInput === this.passwordrepeatInput) {
        fetch(url1, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            password: this.passwordInput,
          }),
        }).catch(function (error) {
          console.log(error);
        });
        this.successPassword = "Password has been changed :D";
      } else {
        this.errorPassword = "the Passwords dont match";
      }
    },
    async loadProfile() {
      const response = await fetch("/users/LoggedIn");
      const friends = await response.json();
      this.AllUser = friends;
      this.usernameInput = this.AllUser["0"].username;
      this.prenameInput = this.AllUser["0"].prename;
      this.lastnameInput = this.AllUser["0"].lastname;
    },
    BackClick() {
      store.IfProfileClick = false;
    },
  },
  computed: {
    IfProfileClick: function () {
      return store.IfProfileClick;
    },
  },
  created() {
    this.loadProfile();
  },
};
</script>
<!-- TODO: ugly styling please make responsive-->
<style scoped>
.userinfo {
  margin: auto;
  display: block;
}
button {
  background-color: #ffc145;
  border-radius: 15px;
  margin: 0 15px;
}
p {
  font-size: 18px;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy;
  text-align: center;
}
</style>