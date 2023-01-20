<template>
<div>
<div class="container">
  <div class="row">
    <div class="col-md-12 ps-4 pt-5" style="padding-bottom:9rem !important" >


        <h5 class="text-primary mt-5 mt-md-0">Accept or Reject Live Appointment Request</h5>


        <div class="d-flex pt-5 justify-content-center align-items-center">
        <button
          class="btn btn-secondary  me-2 text-white"
          @click="submitForm"
        >
          <i class="fa-solid fa-angles-left me-1"></i>
          Accept
        </button>

        <button
          class="btn btn-graish text-white"
        >
          Reject
          <i class="fa-solid fa-angles-right ms-1"></i>
        </button>
      </div>

    </div>
    </div>
</div>
</div>
</template>

<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
  props: [
    "url",
    "appointment_id",
    "appointment_fee",
    "mentee_id",
    "route",
    "liveRoute"
  ],
  mixins: [loginMixin],
data(){
    return {
        appointment_no:""
    }


},
  methods: {
    async submitForm() {
      var toast = this.$toasted;
      const headers = {
        "Content-Type": "multipart/form-data",
      };

      let formData = new FormData();
    //   formData.append("book_file", this.formData.book_file);
      formData.append("token", 123);
      formData.append("mentee_id", this.mentee_id);
      formData.append("mentor_id", this.User.user_id);
      formData.append("payment", this.appointment_fee);
      formData.append("payment_id",0);
      formData.append("questions", 'live');
      formData.append("type", "question");
      formData.append("appointment_type_string", 'live');
      formData.append("appointment_type_id", this.appointment_id);

      const res = await axios
        .post("/api/bookAppointment", formData, {
          headers: headers,
        })
        .then((res) => {
          if (res.data.Status) {
            this.appointment_no=res.data.data.appointmentNo;
            toast.success(res.data.msg);
            this.sendBookedAppointmentNotification();

          }
          if (!res.data.Status) {
            toast.error(res.data.errors.questions[0]);
          }
        });
    },
    async sendBookedAppointmentNotification() {
      const params = {
        token: 123,
        user_id: this.mentee_id,
        body: "Your Live Appointment Request Accepted",
        title: "New Appointment for You.",
        link: this.url+"/live/appointment/payment/"+this.appointment_no+"/"+this.appointment_fee,
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
  },
  created() {
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentor") {
    } else if (this.is_loggedIn && this.User.role == "Mentee") {
      this.$toasted.error("Please Login as a Consultant");
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
  },
};
</script>
