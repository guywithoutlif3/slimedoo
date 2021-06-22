<template>
  <div id="Sidebar">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <Profile v-if="IfProfileClick == true" />
    <div v-if="IfProfileClick == false">
      <!---Form which is reponsible for adding user to Friendlist-->
      <form action="/" class="UserAddForm">
        <!---Input field for username input binded to input in data-->
        <input
          v-model="input"
          placeholder="type Username"
          id="input"
          name="input"
        /><br />
        <!--- button calls addFriend for adding a friend aswell as load friends to keep rendering in sync with db -->
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
      <!-- li with for inside that lists all Friends from friends object an sets the key to iterate thru to the FriendID-->
      <form>
        <button class="ProfileClick" v-on:click.prevent="ProfileClick()">
          My Profile
        </button>
      </form>
      <li
        style="list-style-type: none"
        v-for="friend in friends"
        :key="friend.FriendID"
      >
        <!-- here a form with a button inside gets generated for each user on Friendlist ... -->
        <form class="userAddbutton" style="font-size: 4vw">
          <button
            v-on:click.prevent="chatClick(friend.username, friend.FriendID)"
            class="userButton"
            style="margin: 10px"
          >
            <!-- ... and runs chatClick method aswell as preventing default event -->
            {{ friend.username }}
          </button>
        </form>
      </li>
    </div>
  </div>
</template>   
<script>
import Profile from "./Profile.vue";
import { store } from "./../store";
export default {
  components: {
    Profile,
  },
  name: "Sidebar",

  data: function () {
    return {
      input: "",
      friends: null,
      friendAdd: null,
      users: null,
      friendsR: null,
    };
  },
  computed: {
    IfProfileClick: function () {
      return store.IfProfileClick;
    },
  },
  methods: {
    ProfileClick() {
      store.IfProfileClick = true;
    },
    //async fetch method which fetches all Friends and saves them in friends object
    async loadFriends() {
      const response = await fetch("/friends/all");
      const friends = await response.json();

      const response1 = await fetch("/friends/allReverse");
      const friendsR = await response1.json();

      let array1 = friends;
      let array2 = friendsR;
      let array3 = array1.concat(array2);
      var dataArray = array3.map((item) => {
        return [item.username, item];
      }); // creates array of array
      var maparr = new Map(dataArray); // create key value pair from array of array

      var result = [...maparr.values()]; //converting back to array from mapobject
      this.friends = result;
    },
    //async fetch post method which adds friend
    async addFriend() {
      //we need to fetch /friends/{username} for the route that checks existance
      let url = "/friends/" + this.input;
      const response1 = await fetch(url);
      const friend = await response1.json();
      this.friendAdd = friend;

      //second fetch to actually add to friendlist
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
      this.input = "";
      this.loadFriends(); // loads friends to keep rendered same as db
    },
    //function sets the Chat that was clicked on with username and loads component
    chatClick: function (username, id) {
      store.ClickedChatUsername = username;
      store.ClickedChat = id;
    },
  },
  created() {
    this.loadFriends();
     this.timer = setInterval(this.loadFriends, 500);
  },
};
</script>
<!-- TODO: ugly css please make responsive -->
<style scoped>
form {
  display: flex;
  margin: 10px;
}
.ProfileClick {
  flex-grow: 0.2;
  width: 80%;
  height: 100%;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy;
  font-size: 1.5vw;
  color: #396795;
  background-color: #ffc145;
  flex: 50%;
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  margin: 0 15px;
}
.userButton {
  width: 80%;
  height: 100%;
  font-family: Copperplate, "Copperplate Gothic Light", fantasy;
  font-size: 1.5vw;
  color: #ffc145;
  background-color: #396795;
  flex: 50%;
  box-shadow: 0 0 0 1px black;
  margin-bottom: 10px;
  margin: 0 15px;
}

#add {
  flex-grow: 0.2;
}
#Sidebar {
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