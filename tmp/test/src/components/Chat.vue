<template>
  <div id="Chat">
    <h1>I am chat</h1>
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
        
        <p style="float: left; background-color: #ffc145; margin: 0 0 0 10%">
          {{ message.message }}
        </p>
        <br />
      </div>
      <!--- styline option 2-->
      <div
        style="margin-bottom: 20px"
        v-else-if="message.userIDfs == clickedChat"
      >
        
        <p style="float: right; background-color: #bbebfa; margin: 0 10% 0 0">
          {{ message.message }}
        </p>
        <br />
      </div>
    </li>
<!--- this is the Button for entering messages where the input is binded to the data input and the button runs the addMessage() method and prevents page reload -->
    <form class="messageAddButton">
      <input v-model="input" type="text" placeholder="Enter message" />
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
    };
  },

  methods: {
    //async method which loads all messages into the messages object (pretty much constantly)
    async loadChatArrays() {
      //async fetch to get messages sent to reciver from Logged in User
      const response = await fetch(
        "/messages/reciever/" + store.ClickedChat + ""
      );
      const messages = await response.json();
      //async fetch to get messages sent from recivier to Logged in User
      const response1 = await fetch(
        "/messages/LoggedIn/" + store.ClickedChat + ""
      );

      this.messages = messages; //add messages sent to reciver to messages object
      const messages1 = await response1.json(); //gets the reponse from second fetch 
      this.messages = this.messages.concat(messages1); //merges the messages object and the results
      this.messages.sort(function (a, b) { //this sorting function sorts the messages per date
        var dateA = new Date(a.created),
          dateB = new Date(b.created);
        return dateA - dateB;
      });
    },

    //async method to add a message
    async addMessage() {
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
    clickedChat: function () { //constantly checks for changes in clickedChat and if any occur ...
      this.messagesClear();// ... clear the messages from the old clicked user ...
      this.loadChatArrays();// ... and reload the new message object with current user. 
      return store.ClickedChat;
    },
  },
  created() { // Lifecyle hook on creating of component ....
    this.loadChatArrays(); //...loads messages with clicked user aswell as...
    this.timer = setInterval(this.loadChatArrays, 2000); // starting this constant interval of 2 seconds where every 2 seconds the messages ger reloaded. (not pretty but functional)
  },
  beforeDestroy() { //before the component gets destroed the Cancel Auto Update method gets called
    this.cancelAutoUpdate();
  },
};
</script>
<!-- TODO: ugly styling please make responsive-->
<style scoped> 
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