<template>
  <section class="appointment-log-detail mt-0 mb-0">
    <div class="container">
      <div class="bg-white px-5 py-3 mb-3">
          <div class="row">
<div class="col-md-6">
            <h3 class="text-secondary fw-bold">

                {{$t('appointment_detail.main_title')}}
                </h3>
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-center">
            <div class="text-md-end">
                      <button
                        v-if="
                          appointment.appointment_status == 1 &&
                          user_role == 'Mentor' &&
                          appointment_completed

                        "

                        type="button"
                        class="btn btn-sm btn-primary py-1 px-4 me-3"
                         data-bs-toggle="modal"
                      data-bs-target="#withdrawModel"
                      >
                        {{$t('appointment_detail.btn.mark_complete')}}
                      </button>
                    </div>
        </div>
          </div>

      </div>

      <div class="bg-white mentee-info px-5 py-4">
        <div class="row">
          <div class="col-lg-3 col-md-5 border-end-c">
            <h4 class="text-primary fw-bold mt-5 mt-md-0">
                {{$t('appointment_detail.sub_heading')}}

            </h4>
            <div class="padding">
              <div class="profile-img-shape">
                <div class="shape"></div>
                <div

                      class="
                        file-upload-div
                        d-flex
                        justify-content-center
                        align-items-center
                        position-relative
                        flex-column
                      "
                    >
                <img
                v-if="profile.image"
                  :src="profile.image"
                  alt=""
                  class="img-fluid position-relative"
                />
                <img
               v-else
                  src="/assets/images/profile_placeholder.png"
                  alt=""
                  class="img-fluid position-relative"
                />
                </div>
              </div>

              <div class="d-flex flex-column">
                <h3 class="text-primary fw-bold mt-3">
                  {{ profile.first_name }} {{ profile.last_name }}
                </h3>
                <p class="mb-0 fw-500"
                v-for="category in profile.categories"
                :key="category.id"
                >{{category.name}}</p>
                <h6 class="text-secondary mb-0 mt-1">
                  <i class="fa-solid fa-location-dot text-muted me-1"></i
                  ><span class="location"> {{profile.country}} </span>
                </h6>
              </div>
            </div>
          </div>
          <div class="col-lg-5 col-md-7 border-end-c px-lg-5">
            <h4 class="text-primary fw-bold mt-5 mt-md-0">
                {{$t('appointment_detail.user_info.info')}}:

            </h4>
            <div class="py-3">
              <div class="row"
              v-if="appointment.mentee_visibility==0"
              >
                <div class="col-md-6">
                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.user_info.name')}}:

                         </label>
                    <p>{{appointment.mentee.first_name}} {{appointment.mentee.last_name}}</p>
                  </div>

                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.user_info.gender')}}:

                    </label>
                    <p>{{appointment.mentee.gender}}</p>
                  </div>

                </div>
                <div class="col-md-6">
                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.user_info.city')}}:

                    </label>
                    <p>{{appointment.mentee.city}}</p>
                  </div>
                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.user_info.member_status')}}:

                    </label>
                    <p>Active</p>
                  </div>
                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.user_info.registration_date')}}:

                    </label>
                    <p>{{new Date(appointment.mentee.created_at).toLocaleString()}}</p>
                  </div>
                </div>
              </div>
              <div class="row" v-else>
                  <div class="col-md-12 py-5 text-center">
                           <span class="fw-400">User Profile is Hidden</span>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-12 px-lg-5">
            <h5 class="text-primary mt-lg-0 mt-5 fw-bold">
                {{$t('appointment_detail.heading')}}

            </h5>
            <div class="py-3">
              <div class="row">
                <div class="col-md-12">
                    <div class="pt-2" v-if="appointment.appointment_type_id!=3">
                    <label class="text-primary"> Date: </label>
                    <p>
                        {{appointment.date}}
                    </p>
                    </div>
                    <div class="pt-2" v-if="appointment.appointment_type_id!=3">
                    <label class="text-primary"> Time: </label>
                    <p>
                        {{appointment.time}}
                    </p>
                    </div>
                    <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.info.appointment_type')}}

                         </label>
                    <p>
                        {{appointment.appointment_type_string}}
                    </p>
                    </div>
                  <div class="pt-2">
                    <label class="text-primary">
                {{$t('appointment_detail.info.document')}}

                    </label>
                    <p v-if="appointment.file_type == 'pdf' ||appointment.file_type == 'docx' ">

                      <a
                              :href="url + '/' + appointment.file"
                              target="_blank"
                              ><i class="fa-solid fa-file-pdf text-danger mt-2"></i
                      ></a>
                    </p>
                    <p v-else>
                        <img
                              :src="url + '/' + appointment.file"
                              alt=""
                              style="width: 70px; heigh: 50px"
                            />
                    </p>
                  </div>
                  <div class="pt-2">
                    <label class="text-primary"> {{$t('appointment_detail.status.label')}}: </label>
                    <p v-if="appointment.appointment_status == 0"
                    >{{$t('appointment_detail.status.pending')}}
                    </p>
                    <p v-if="appointment.appointment_status == 1"
                    >{{$t('appointment_detail.status.accepted')}}
                    </p>
                    <p v-if="appointment.appointment_status == 2"
                    >{{$t('appointment_detail.status.completed')}}
                    </p>
                    <p v-if="appointment.appointment_status == 3"
                    >{{$t('appointment_detail.status.cancel')}}
                    </p>
                  </div>
                   <div class="pt-2">
                    <label class="text-primary" v-if="appointment.notes_consultant " > Notes : </label>
                    <p
                    >{{appointment.notes_consultant }}
                    </p>

                  </div>
                  <div class="pt-2">
                    <label class="text-primary">
                Notes Attachment

                    </label>
                    <p v-if="appointment.filetype_consultant == 'pdf' ||appointment.filetype_consultant == 'docx' ">

                      <a
                              :href="url + '/' + appointment.file_consultant"
                              target="_blank"
                              ><i class="fa-solid fa-file-pdf text-danger mt-2"></i
                      ></a>
                    </p>
                    <p v-else>
                        <img
                              :src="url + '/' + appointment.file_consultant"
                              alt=""
                              style="width: 70px; heigh: 50px"
                            />
                    </p>
                  </div>
                  <div class="pt-2">
                    <button class="btn btn-primary mb-md-0 mb-2 btn-sm mt-1"
                      v-if="appointment.appointment_status == 0"
                        v-on:click="acceptAppointment(appointment.id)"
                     type="button">
                      {{ $t("appointment_log.tab.pending.button.accept") }}</button>
                    <div class="mt-3">
                      <button class="btn btn-danger mb-md-0 mb-2 btn-sm mt-1"
                      v-if="appointment.appointment_status == 0"
                      v-on:click="rejectAppointment(appointment.id)"
                       type="button">
                        {{ $t("appointment_log.tab.pending.button.reject") }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div
                  class="row mb-3"
                  v-if="
                    appointment.appointment_status == 1 &&
                    appointment.appointment_type_id == 3
                  "
                >
                  <div class="col-md-12 d-flex justify-content-end">
                    <div class=" mt-4">
                      <button
                        type="button"
                        v-if="!chat"
                        @click="showChat()"
                        class="btn btn-primary"
                      >
                         {{$t('appointment_detail.btn.chat_now')}}
                      </button>
                      <button
                        type="button"
                        v-else
                        @click="closeChat()"
                        class="btn btn-primary"
                      >
                        {{$t('appointment_detail.btn.chat_close')}}
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                    <LiveVideoChat

                    v-if="
                      appointment.appointment_type_id == 6

                    "
                     :id="appointment_id"
                    :appointment_type_id="appointment.appointment_type_id"
                    :mentee_id="appointment.mentee_id"
                    @leaveAppoinment="appointmentCompleted"
                    >

                    </LiveVideoChat>
                  <VideoChat
                    v-if="
                      appointment.appointment_type_id == 2 ||
                      appointment.appointment_type_id == 1

                    "
                    :id="appointment_id"
                    :appointment_type_id="appointment.appointment_type_id"
                    :appointment_status="appointment.appointment_status"
                    :mentee_id="appointment.mentee_id"
                    :start_time="appointment.before_two_minute_start_time"
                    :end_time="appointment.end_time"
                    :date="appointment.date"
                    :showVideoCount="showVideoCount"
                    @leaveAppoinment="appointmentCompleted"
                  ></VideoChat>
                </div>

        </div>
      </div>
       <div class="bg-white"> <chat-component :id="appointment_id" v-if="this.chat" /></div>
    <!-- Modal Withdraw -->
        <div
          class="modal fade"
          id="withdrawModel"
          tabindex="-1"
          aria-labelledby="withdrawModelLabel"
          aria-hidden="true"
        >
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5

                  class="modal-title"
                  id="withdrawModelLabel"
                  style="color: black"
                >
                  Add Attachment
                </h5>

                <button
                  type="button"
                  class="btn-close text-white"
                  data-bs-dismiss="modal"
                   style="color: white"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body form-group">
                <input
                  type="text"
                  class="form-control"
                  required
                  v-model="notes"
                  placeholder="Enter Notes"
                />
<img
            v-if="image_view"
            :src="image_view"
            height="80px"
            width="80px"
            class="mt-2"
            @click="openFile"
          />
                <div class="upload-btn-wrapper w-100 mt-3">
            <button class="btn btn-upload w-100 d-flex">
              <span v-if="file_name"> {{ file_name }}</span>
              <span v-else>Upload a file</span>
            </button>
            <input
              type="file"
              id="book_file"
              ref="book_file"
              @change="processFile($event)"
              name="file"
            />
          </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-secondary"
                  data-bs-dismiss="modal"
                  id="withdraw_close"
                >
                  Close
                </button>
                <button
                  type="button"
                  class="btn btn-primary"
                  v-on:click="markAppointmentAsComplete(appointment.id)"
                >
                 Save
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>


  </section>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import VideoChat from "./VideoChat.vue";
import LiveVideoChat from "./LiveVideo.vue";
export default {
  props: ["url", "appointment_id"],
  mixins: [loginMixin],
  components: {
    VideoChat,
    LiveVideoChat
  },
  data() {
    return {
        appointment: {},
        payment:"",
      appointmentNo:"",
      is_paid:"",
      mentor_id: "",
      mentee_id: "",
      start_time: "",
      end_time: "",
      date:"",
      mentee_number:"",
      profile: {
        first_name: "",
        last_name: "",
        country: "",
        categories:"",
        image:""
      },
      chat:false,
      user_role:'',
      mentorDataLoading: true,
      ratings: {
        rate: "",
        comment: "",
      },
      appointment_completed:false,
      file:"",
      notes:"",
      file_name:"",
      image_view:""
    };
  },
  methods: {
    openFile(){
        window.open(this.image_view,'_blank');
    },
     processFile(event) {
      this.file = event.target.files[0];
      if (event.target.files[0].type.includes("image")) {
        this.image_view = URL.createObjectURL(event.target.files[0]);
        this.file_name = event.target.files[0].name;
      } else {
        this.image_view = "";
        this.file_name = event.target.files[0].name;
      }
    },
      async acceptAppointment(id) {
      var toast = this.$toasted;
      var self = this;
      const params = {
        token: 123,
        status: 1,
        id: id,
      };
      const res = await axios
        .post("/api/changeAppointmentStatus", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            self.appointmentDetails();
            self.sendAcceptedAppointmentNotification();
            self.sendAcceptedAppointmentSms();
          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
    },
     async sendAcceptedAppointmentSms() {
      const params = {
        token: 123,
        phone: this.mentee_number,
        message: "Your Appointment is Accepted."
      };
      const res = await axios
        .post("/api/send-sms", params)
        .then((res) => {});
    },
    async rejectAppointment(id) {
      var toast = this.$toasted;
      var self = this;
      const params = {
        token: 123,
        status: 3,
        id: id,
      };
      const res = await axios
        .post("/api/changeAppointmentStatus", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            self.sendRejectedAppointmentNotification();
            self.sendRejectedAppointmentSms();
            self.appointmentDetails();
          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
    },
    async sendRejectedAppointmentSms() {
      const params = {
        token: 123,
        phone: this.mentee_number,
        message: "Your Appointment is Rejected."
      };
      const res = await axios
        .post("/api/send-sms", params)
        .then((res) => {});
    },
       async sendAcceptedAppointmentNotification()
    {
        const params = {
        token: 123,
        user_id: this.mentee_id,
          body: "Click here to See your Appointment",
          title: "Your Appointment is Accepted.",
          link:
            "/mentor/appointment/log/",
        };
        const res = await axios
          .post("/api/send-web-notification", params)
          .then((res) => {});
    },
      async sendRejectedAppointmentNotification()
    {
        const params = {
        token: 123,
        user_id: this.mentee_id,
          body: "Click here to See your Appointment",
          title: "Your Appointment is Rejected.",
          link:
            "/mentor/appointment/log/",
        };
        const res = await axios
          .post("/api/send-web-notification", params)
          .then((res) => {});
    },
      appointmentCompleted(){
          this.appointment_completed=true;
      },
      async markAppointmentAsComplete(appointment_id) {
      var toast = this.$toasted;
      var self = this;
      const params = {
        token: 123,
        appointment_id: this.appointment_id,
      };
       const headers = {
        "Content-Type": "multipart/form-data",
      };
      let formData = new FormData();
      formData.append("file", this.file);
      formData.append("notes", this.notes);
      formData.append("appointmentId", this.appointment_id);

      const result = await axios
        .post("/api/appointment-attachments", formData,headers)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);

          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
        $('#withdraw_close').click();
      const res = await axios
        .post("/api/mark-appointment-as-complete", params)
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            self.sendCompletedAppointmentNotification();
            self.appointmentDetails();
            self.closeChat();
          }
          if (!res.data.Status) {
            toast.error("Please Fill all Fields...");
          }
        });
    },
     async sendCompletedAppointmentNotification()
    {
        const params = {
        token: 123,
        user_id: this.mentee_id,
          body: "Click here to See your Appointment",
          title: "Your Appointment is Completed.",
          link:
            "/mentee/appointment-log/",
        };
        const res = await axios
          .post("/api/send-web-notification", params)
          .then((res) => {});
    },
      showChat() {
      this.chat = true;
    },
    closeChat() {
      this.chat = false;
      this.appointment_completed=true;
    },
      async appointmentDetails() {
      const params = {
        token: 123,
        appointment_id: this.appointment_id,
        user_id: this.User.user_id
      };
      const res = await axios.get("/api/appointmentDetails", { params });
      if (res.data && res.data.Status) {
        this.appointment = res.data.data.appointment;
        this.mentor_id = res.data.data.appointment.mentor_id;
        this.mentee_id = res.data.data.appointment.mentee_id;
        this.payment = res.data.data.appointment.payment;
        this.appointmentNo = res.data.data.appointment.id;
        this.is_paid = res.data.data.appointment.is_paid;
        // this.start_time = res.data.data.appointment.time;
        this.start_time = res.data.data.appointment.before_two_minute_start_time;
        this.end_time = res.data.data.appointment.end_time;
        this.date = res.data.data.appointment.date;
        this.mentee_number = res.data.data.appointment.mentee.phone;
        this.showVideoCount++
        if (this.User.role == "Mentee") {
          this.fetchMentorData();
        }
        this.loading = false;
      }
         if (!res.data.Status) {
             this.$toasted.error(res.data.msg)
         }

    },
    async fetchUserData() {
      const params = {
        token: 123,
        user_id: this.User.user_id,
      };

      const res = await axios.get("/api/getUserById", {
        params,
      });
      if (res.data && res.data.Status) {
        this.profile.first_name = res.data.data.userDetail.first_name
          ? res.data.data.userDetail.first_name
          : "";
        this.profile.last_name = res.data.data.userDetail.last_name
          ? res.data.data.userDetail.last_name
          : "";

        this.profile.country = res.data.data.userDetail.user_country
          ? res.data.data.userDetail.user_country.name
          : "";
        this.profile.categories=res.data.data.userDetail.mentor.categories;
        this.profile.image=res.data.data.userDetail.image_path;
        this.loading = false;
        this.mentorDataLoading = false;
      }
    },
  },
  created() {
    this.checkLoggedIn();
    this.appointmentDetails();
    if (this.is_loggedIn && this.User.role == "Mentor") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    if (this.User.role == "Mentor") {
      this.user_role = "Mentor";
    } else {
      this.user_role = "Mentee";
    }
    this.fetchUserData();
  },
};
</script>
