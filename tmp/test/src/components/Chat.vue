<template>
  <div id="Chat">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <h1
      style="
        font-family: Copperplate, 'Copperplate Gothic Light', fantasy;
        text-align: center;
      "
    >
      <b style="background-color: #ffc145"> You </b>are Chatting with:
      <b style="background-color: #bbebfa">{{ clickedChatUsername }}</b>
      <p style="font-size: 25px">Chatting since: {{ createdChat }}</p>
    </h1>
    <!--- The list Tag here has a vue for loop insides that loads all messages from data messages and assigns the key to loop thru to the messageID -->
    <li
      style="list-style-type: none"
      v-for="message in messages"
      :key="message.messageID"
    >
      <!--- The Divs here is for conditional styling depening the message is sent from the Logged in user or recived -->
      <!--- Deffentetly not best solution but it work -->
      <!--- styline option 1 -->
      <div style="margin-bottom: 20px" v-if="message.userIDfs == LogID">
        <p
          style="
            padding: 8px;
            float: left;
            background-color: #ffc145;
            margin: 0 0 0 10%;
            border-radius: 7px;
          "
        >
          {{ message.message }}
        </p>
        <br />
      </div>
      <!--- styline option 2-->
      <div
        style="margin-bottom: 20px"
        v-else-if="message.userIDfs == clickedChat"
      >
        <p
          style="
            padding: 8px;
            float: right;
            background-color: #bbebfa;
            margin: 0 10% 0 0;
            border-radius: 5px;
          "
        >
          {{ message.message }}
        </p>
        <br />
      </div>
    </li>
    <!--- this is the Button for entering messages where the input is binded to the data input and the button runs the addMessage() method and prevents page reload -->
    <form class="messageAddButton">
      <input v-model="input" type="text" placeholder="Enter message" />
      <p>{{ empty }}</p>
      <button v-on:click.prevent="addMessage()">send</button>
    </form>
  </div>
</template>   
<script>
import { store } from "./../store";
export default {
  name: "Chat",

  data: function () {
    return {
      input: "",
      messages: null, //object with all messages from loadChatArrays()
      empty: " ",
      createdChat: " never  ",
    };
  },

  methods: {
    //async method which loads all messages into the messages object (pretty much constantly)
    async loadChatArrays() {
      //async fetch to get messages sent to reciver from Logged in User
      let response = await fetch(
        "/messages/reciever/" + store.ClickedChat + ""
      );
      let messages = await response.json();
      //async fetch to get messages sent from recivier to Logged in User
      let response1 = await fetch(
        "/messages/LoggedIn/" + store.ClickedChat + ""
      );

      //this.messages = messages; //add messages sent to reciver to messages object

      let messages1 = await response1.json(); //gets the reponse from second fetch
      messages = messages.concat(messages1);
      //this.messages = this.messages.concat(messages1); //merges the messages object and the results
      this.messages = messages;
      this.messages.sort(function (a, b) {
        //this sorting function sorts the messages per date
        var dateA = new Date(a.created),
          dateB = new Date(b.created);
        return dateA - dateB;
      });
      if (this.messages == [] || this.messages === null || this.messages == null || this.messages == "") {
        this.createdChat = " never ";
      } else {
        this.createdChat = this.messages["0"].created;
      }
    },

    //async method to add a message
    async addMessage() {
      this.empty = "";
      if (this.input == "") {
        this.empty = "sorry but message can't be emtpy";
      }
      {
        let url1 = "/messages/add";
        fetch(url1, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            message: this.input, //the input from the data gets used here for POST
            userIDfs: store.LogID, // the currently Logged in User
            recieverID: store.ClickedChat, //The reciver of the message
          }),
        }).catch(function (error) {
          console.log(error);
        });

        this.loadChatArrays(); //runs the loading method again for displaying the new version of messages
        this.input = " "
      }
      
    },
    //this method stops the AutoUpdate becuase if its not canceld it keeps running
    cancelAutoUpdate() {
      clearInterval(this.timer);
    },
    //this method clears the messages object for switchin recievers
    messagesClear: function () {
      this.messages = [];
    },
  
  },
  computed: {
    LogID: function () {
      return store.LogID;
    },
    clickedChat: function () {
      //constantly checks for changes in clickedChat and if any occur ...
      this.messagesClear(); // ... clear the messages from the old clicked user ...
      this.loadChatArrays(); // ... and reload the new message object with current user.
      return store.ClickedChat;
    },
    clickedChatUsername: function () {
      return store.ClickedChatUsername;
    },
  },
  created() {
    // Lifecyle hook on creating of component ....
    this.loadChatArrays(); //...loads messages with clicked user aswell as...
    this.timer = setInterval(this.loadChatArrays, 500); // starting this constant interval of 2 seconds where every 2 seconds the messages ger reloaded. (not pretty but functional)
  },
  beforeDestroy() {
    //before the component gets destroed the Cancel Auto Update method gets called
    this.cancelAutoUpdate();
  },
};
</script>
<!-- ugly styling please make responsive-->
<style scoped>
form {
  display: flex;
  justify-content: center;
}
#Chat {
  background-color: #396795;
  position: fixed;
  width: 82%;
  top: 0;
  left: 18%;
  bottom: 0;
  right: 0;
  overflow: auto;
}
</style>