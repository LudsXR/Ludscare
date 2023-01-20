 <template><div class="mt-5">

  <div class="main chat p-md-5">
    <div class="">
      <div class="row clearfix">
        <div class="col-lg-12">
          <div class="card chat-app border-0">
            <div class="chat">

              <div class="chat-history border" v-chat-scroll>
                <ul class="m-b-0" type="none">
                  <div v-for="message in messages" :key="message.id">
                    <li v-if="sender_id === message.sender_id" class="clearfix">
                      <div class="message-data text-end">

                      </div>
                        <div class="d-flex flex-row justify-content-end my-4">

                      <div class="message my-message float-right">
                        {{ message.message }}
                      </div>
                         <a
                      href="javascript:void(0);"
                      data-toggle="modal"
                      data-target="#view_info"
                      class="d-flex justify-content-center"
                    >
                      <img
                        src="https://bootdey.com/img/Content/avatar/avatar2.png"
                        alt="avatar"
                        class="chat-profile"
                        height="50px"
                      />
                    </a>
                        </div>
                    </li>
                    <li v-else class="clearfix">
                      <div class="message-data">

                      </div>
                      <div class="d-flex my-4">
                          <a
                      href="javascript:void(0);"
                      data-toggle="modal"
                      data-target="#view_info"
                      class="d-flex justify-content-center"
                    >
                      <img
                        src="https://bootdey.com/img/Content/avatar/avatar2.png"
                        alt="avatar"
                        class="chat-profile"
                        height="50px"
                      />
                    </a>
                      <div class="message other-message">
                        {{ message.message }}
                      </div></div>

                    </li>
                  </div>
                </ul>
              </div>
              <div class="chat-message clearfix bg-light d-flex px-3">
                <div class="input-group">
                  <input
                  :placeholder="$t('mentee_chat.placeholder_1')"
                    type="text"
                    class="form-control"
                    aria-label="Amount (to the nearest dollar)"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                  />

                  <button type="button" v-on:click="sendMessage" class="btn btn-transparent text-secondary">
                    <i class="fas fa-paper-plane"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
           </div>
</template>


<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
  props: ["url", "id"],
  mixins: [loginMixin],
  data() {
    return {
      messages: [],
      newMessage: "",
      users: [],
      activeUser: false,
      typingTimer: false,
      sender_id: "",
      receiver_id: "",
      appointment: {},
    };
  },
  created() {
    this.checkLoggedIn();
    this.appointmentDetails();

    window.Echo.channel("chat").listen("MessageSent", (e) => {
      if (e.message.receiver_id == this.sender_id) {
        this.messages.push({
          message: e.message.message,
          receiver_id: e.message.receiver_id,
        });
      }
    });
  },

  methods: {
    async appointmentDetails() {
      const params = {
        token: 123,
        appointment_id: this.id,
        user_id: this.User.user_id
      };
      const res = await axios.get("/api/appointmentDetails", { params });
      if (res.data && res.data.Status) {
        this.appointment = res.data.data.appointment;
        // this.loading = false;
        if (this.User.role == "Mentor") {
          this.sender_id = this.User.user_id;
          this.receiver_id = res.data.data.appointment.mentee_id;
        }
        if (this.User.role == "Mentee") {
          this.sender_id = this.User.user_id;
          this.receiver_id = res.data.data.appointment.mentor_id;
        }
        this.fetchMessages();
      }
    },
    async sendMessage() {
        var self = this;
      var message = this.newMessage;
      this.newMessage = "";
      this.messages.push({
        message: message,
        sender_id: this.sender_id,
      });

      var params = {
        token: 123,
        sender_id: this.sender_id,
        receiver_id: this.receiver_id,
        message: message,
      };
      const res = await axios.post("/api/send-message", params).then((res) => {
        if (res.data.Status) {
          this.sendNewMessageNotification(message);
        }
      });
    },
    async sendNewMessageNotification(message) {
      const params = {
        token: 123,
        user_id: this.receiver_id,
        body: message,
        title: "New Message",
        link: "",
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
    async fetchMessages() {
      const params = {
        token: 123,
        receiver_id: this.receiver_id,
        sender_id: this.sender_id,
      };
      const res = await axios.get("/api/fetch-messages", { params });
      if (res.data && res.data.Status) {
        this.messages = res.data.data.messages;
      }
    },
    //    async saveMessageIntoDb(e)
    //     {
    //            var params = {
    //                 token: 123,
    //                 receiver_id: e.message.receiver_id,
    //                 sender_id: e.message.sender_id,
    //                 message: e.message.message,
    //             }
    //         const res = await axios
    //         .post("/api/send-message", params )
    //         .then((res) => {
    //         if (res.data.Status) {

    //         }
    //         });
    //     }
  },
};
</script>

<style scoped>
/* .chat-profile{
height: 70px;
width: 70px;
border-radius: 50%;
}
.chat-app{
    position: fixed;
    width: 400px;
    bottom: 0;
    right: 12px;
    z-index: 99999;

} */
.chat-history {
  height: 350px;
  overflow-y: auto;
}
@media only screen and (max-width: 767px) {
  .chat-history {
    height: 300px;
    overflow-y: auto;
  }
}
</style>
