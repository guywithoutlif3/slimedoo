<template>
  <div id="Sidebar">
    <form action="/" class="Sidebar">
      <input
        v-model="input"
        placeholder="type Username"
        id="input"
        name="input"
      /><br />
      <button
        id="add"
        v-on:click.prevent="
          addFriend();
          loadFriends();
        "
        type="submit"
        value="Submit"
      >
        Add
      </button>
    </form>
    <li
      style="list-style-type: none"
      v-for="friend in friends"
      :key="friend.FriendID"
    >
      <form class="userAddbutton">
        <button v-on:click.prevent="chatClick(friend.username)" class="userButton" style="margin: 10px">
          {{ friend.username }}
        </button>
      </form>
    </li>
  </div>
</template>   
<script>
import { store } from "./../store";
export default {
  name: "Sidebar",

  data: function () {
    return {
      input: "",
      friends: null,
      friendAdd: null,
    };
  },
  methods: {
    async loadFriends() {
      const response = await fetch("/friends/all");
      const friends = await response.json();
      this.friends = friends;
    },
    async addFriend() {
      //we need to fetch /friends/{username}
      let url = "/friends/" + this.input;
      const response1 = await fetch(url);
      const friend = await response1.json();
      this.friendAdd = friend;
      //console.log(this.friendAdd["0"].userID);

      let url1 = "/friendlist/add";
      fetch(url1, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          UserID_fs: store.LogID,
          FriendID: this.friendAdd["0"].userID,
        }),
      }).catch(function (error) {
        console.log(error);
      });

      this.loadFriends();
    },
    chatClick: function(username){

      //function sets the Chat that was clicked on with username and loads component or smt like that:
      store.ClickedChat = username;

    }
  },
  created() {
    this.loadFriends();
  },
};
</script>

<style scoped>
.userButton {
  width: 80%;
  height: 100%;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy; 
  font-size: 24px;
  color: #ffc145;
  background-color: #396795;
  flex: 50%;
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  margin: 0 15px;
}
form {
  display: flex;
  margin: 10px;
}
#add {
  flex-grow: 0.2;
}
div {
  background-color: #bbebfa;
  position: fixed;
  width: 15%;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  overflow: auto;
  border-right: 30px solid #ffc145;
}
</style>