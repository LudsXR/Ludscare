<template>
  <section class="appointment-log-detail mt-0 mb-0">
    <div class="container">
      <div class="bg-white px-5 py-3 mb-3">
        <h3 class="text-secondary fw-bold">
                {{$t('appointment_detail.main_title')}}

        </h3>
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

          <div class="col-lg-8 col-md-12 px-lg-5">
            <h5 class="text-primary mt-lg-0 mt-5 fw-bold">
                {{$t('appointment_detail.info.heading')}}
            </h5>
            <div class="py-3">
              <div class="row">
                <div class="col-md-12">
                    <div class="pt-2 d-flex flex-column" v-if="appointment.appointment_type_id!=3">
                    <label class="text-primary"> Date: </label>
                    <span>
                        {{appointment.date}}
                    </span>
                    </div>
                    <div class="pt-2 d-flex flex-column" v-if="appointment.appointment_type_id!=3">
                    <label class="text-primary"> Time: </label>
                    <span>
                        {{appointment.time}}
                    </span>
                    </div>
                    <div class="pt-2 d-flex flex-column">
                    <label class="text-primary">
                        <!-- Appointment Type: -->
                {{$t('appointment_detail.info.appointment_type')}}

                    </label>
                    <span>
                        {{appointment.appointment_type_string}}
                    </span>
                    </div>
                  <div class="pt-2 d-flex flex-column">
                    <label class="text-primary">
                        <!-- Document -->
                {{$t('appointment_detail.info.document')}}
                    </label>
                    <span v-if="appointment.file_type == 'pdf' ||appointment.file_type == 'docx' ">

                      <a
                              :href="url + '/' + appointment.file"
                              target="_blank"
                              ><i class="fa-solid fa-file-pdf text-danger mt-2"></i
                      ></a>
                    </span>
                    <span v-else>
                        <img
                              :src="url + '/' + appointment.file"
                              alt=""
                              style="width: 70px; heigh: 50px"
                            />
                    </span>
                  </div>
                  <div class="pt-2 d-flex flex-column">
                    <label class="text-primary"> {{$t('appointment_detail.status.label')}}: </label>
                    <span v-if="appointment.appointment_status == 0"
                    >{{$t('appointment_detail.status.pending')}}
                    </span>
                    <span v-if="appointment.appointment_status == 1"
                    >{{$t('appointment_detail.status.accepted')}}
                    </span>
                    <span v-if="appointment.appointment_status == 2"
                    >{{$t('appointment_detail.status.completed')}}
                    </span>
                    <span v-if="appointment.appointment_status == 3"
                    >{{$t('appointment_detail.status.cancel')}}
                    </span>
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

                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="!mentorDataLoading" class="row mb-3">
                  <div class="col-md-12 d-flex justify-content-end">
                    <div class="mt-4">
                      <button
                        type="button"
                        class="btn btn-primary me-4"
                        data-bs-toggle="modal"
                        data-bs-target="#ratingModal"
                        v-if="appointment.appointment_status == 2 && appointment.rating==null"
                      >
                         {{$t('appointment_detail.btn.rate_now')}}
                      </button>
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
                    <div class="mt-4">
                      <button
                        type="button"
                        v-if="!chat"
                        @click="showChat()"
                        class="btn btn-primary me-4"
                      >
                         {{$t('appointment_detail.btn.chat_now')}}
                      </button>
                      <button
                        type="button"
                        v-else
                        @click="closeChat()"
                        class="btn btn-primary me-4"
                      >
                        {{$t('appointment_detail.btn.chat_close')}}
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <VideoChat
                    v-if="
                      appointment.appointment_status == 1 ||
                      appointment.appointment_type_id == 2
                    "
                    :id="appointment_id"
                    :appointment_type_id="appointment.appointment_type_id"
                    :showVideoCount="showVideoCount"
                  ></VideoChat>
                </div>

      </div>
      <div class="bg-white">
          <chat-component :id="appointment_id" v-if="this.chat" />
      </div>
    </div>
    <!-- Rating Model -->
      <div
        class="modal fade"
        id="ratingModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="ratingModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content border-0">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="ratingModalLabel"> {{$t('appointment_detail.btn.rate_now')}}</h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="exampleFormControlSelect1" class="text-dark fw-bold fs-5">{{$t('appointment_detail.btn.select_rating')}}</label>
                <div class="rating">
                    <ul class="rate-area ps-0">
	<input type="radio" id="5" v-model="ratings.rate" name="rating" value="5" /><label for="5" title="Amazing">5 stars</label>
	<input type="radio" id="4" v-model="ratings.rate" name="rating" value="4" /><label for="4" title="Good">4 stars</label>
	<input type="radio" id="3" v-model="ratings.rate" name="rating" value="3" /><label for="3" title="Average">3 stars</label>
	<input type="radio" id="2" v-model="ratings.rate" name="rating" value="2" /><label for="2" title="Not Good">2 stars</label>
	<input type="radio" id="1" v-model="ratings.rate" name="rating" value="1" /><label for="1" title="Bad">1 star</label>
</ul>

                </div>
              </div>
              <br>
              <br>
              <div class="form-group  mt-3">
                <h5 for="review_message" class="text-dark fw-bold fs-5"> {{$t('appointment_detail.btn.comment')}}</h5>
                <textarea
                  class="form-control mt-3"
                  v-model="ratings.comment"
                  id="review_message"
                  rows="3"
                  :placeholder="$t('appointment_detail.btn.placeholder_comment')"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                 {{$t('appointment_detail.btn.close')}}
              </button>
              <button
                type="button"
                id="submit_data"
                v-on:click="submitRating"
                class="btn btn-primary"
              >
                 {{$t('appointment_detail.btn.save')}}
              </button>
            </div>
          </div>
        </div>
      </div>

  </section>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import VideoChat from "./VideoChat.vue";
export default {
  props: ["url", "appointment_id"],
  mixins: [loginMixin],
  components: {
    VideoChat,
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
      rated:false
    };
  },
  methods: {
      async submitRating() {
      if (!this.ratings.rate || !this.ratings.comment) {
        this.$toasted.error("Rating and Comment Field is Required");
      } else {
        $("#ratingModal").modal("hide");
        var toast = this.$toasted;
        var self = this;
        const params = {
          token: 123,
          mentee_id: this.User.user_id,
          mentor_id: this.mentor_id,
          rating: this.ratings.rate,
          comments: this.ratings.comment,
          appointment_id: this.appointment_id,
        };
        const res = await axios
          .post("/api/create-rating", params)
          .then((res) => {
            if (res.data.Status) {
              toast.success(res.data.msg);
              self.appointmentDetails();
              window.location='/mentee/appointment-log'
            }
            if (!res.data.Status) {
              toast.error("Please Fill all Fields...");
            }
          });
      }
    },
      showChat() {
      this.chat = true;
    },
    closeChat() {
      this.chat = false;
      this.appointmentDetails();
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
        this.start_time = res.data.data.appointment.before_two_minute_start_time;
        this.end_time = res.data.data.appointment.end_time;
        this.date = res.data.data.appointment.date;
        this.mentee_number = res.data.data.appointment.mentee.phone;
        this.showVideoCount++
        if (this.User.role == "Mentee") {
          this.fetchUserData();
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
        user_id: this.mentor_id
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
        this.mentorDataLoading=false;
      }
    },
  },
  created() {
    this.checkLoggedIn();
    this.appointmentDetails();
    if (this.is_loggedIn && this.User.role == "Mentee") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    if (this.User.role == "Mentor") {
      this.user_role = "Mentor";
    } else {
      this.user_role = "Mentee";
    }

  },
};
</script>
