<template>
  <section class="appointment-screen mt-0 mb-0">
      <div v-if="loading">
            <img src="/assets/images/loader.gif" height="100px" alt="">
      </div>
    <div v-else class="container">
      <div class="row">
        <div class="col-lg-3 col-md-4 border-end">
          <div class="position-relative mt-5">
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
              v-if="mentorDetails.image_path"
              :src="url +  mentorDetails.image_path"
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

          <div class="d-flex justify-content-start flex-column ps-4">
            <h4 class="text-primary fw-bold mt-3">
              {{ mentorDetails.first_name }} {{ mentorDetails.last_name }}
            </h4>

            <p
              class="mb-0"
              v-for="category in mentorDetails.mentor.categories"
              :key="category.id"
            >
              {{ category.name }}
            </p>
            <h6 class="text-secondary mb-0 mt-2">
              <i class="fa-solid fa-location-dot text-muted me-2"></i
              >{{ mentorDetails.user_country.name }}
            </h6>
          </div>
        </div>
        <div v-if="appointmentComponent" class="col-lg-9 col-md-8">

            <appointment-book
            :selected_new_date="selected_new_date"
            :type="type"
            :appointment_id="appointment_id"
            :appointmentid="appointmentid"
            :appointment_fee="appointment_fee"
            :user_selected_slot="user_selected_slot"
            :user_selected_slot_endtime="user_selected_slot_endtime"
            :url="url"
            :route="route"
            :google_capcha_site_key="google_capcha_site_key"
            :mentor_id="mentor_id"
            :mentor_number="mentorDetails.phone"
            @cancelAppointment="() => {this.appointmentComponent = false ; this.appointmentComponent = false}"

            ></appointment-book>
        </div>

        <div v-else class="col-lg-9 col-md-8">
          <div class="appointment-pills">
            <div class="row">
              <div class="col-xxl-3 col-lg-4">
                <div
                  class="nav flex-column nav-pills me-3"
                  id="v-pills-tab"
                  role="tablist"
                  aria-orientation="vertical"
                >
                  <h6 class="text-primary py-3">Select Appointment Type</h6>
                  <button
                    class="nav-link active mb-3 shadow-sm"
                    id="v-pills-chat-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-chat"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-chat"
                    @click="changeAppointmentType(mentorDetails.without_schedule_types[0].appointment_type.name,
                    mentorDetails.without_schedule_types[0].appointment_type_id,mentorDetails.without_schedule_types[0].fee
                    )"
                    v-if="mentorDetails.without_schedule_types.length > 0 && mentorDetails.without_schedule_types[0]"
                    aria-selected="false"
                  >
                    <div class="d-flex align-items-center">
                      <i class="fa-solid fa-comments"></i>
                      <span
                        class="
                          d-flex
                          flex-column
                          justify-content-start
                          align-items-baseline
                          ps-xxl-3 ps-2
                        "
                      >
                        <p class="mb-0 text-capitalize">Chat consult</p>
                        <span class="text-muted"
                          >Fee
                          {{
                            mentorDetails.without_schedule_types[0].fee
                          }}</span
                        >
                      </span>
                    </div>
                  </button>
                  <button
                    class="nav-link  mb-3 shadow-sm"
                    id="v-pills-live-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#v-pills-live"
                    type="button"
                    role="tab"
                    aria-controls="v-pills-live"
                    @click="changeAppointmentType(mentorDetails.without_schedule_types[1].appointment_type.name,
                    mentorDetails.without_schedule_types[1].appointment_type_id,mentorDetails.without_schedule_types[1].fee
                    )"
                    v-if="mentorDetails.without_schedule_types.length > 0 && mentorDetails.without_schedule_types[1]"
                    aria-selected="false"
                  >
                    <div class="d-flex align-items-center">
                      <i class="fa-solid fa-comments"></i>
                      <span
                        class="
                          d-flex
                          flex-column
                          justify-content-start
                          align-items-baseline
                          ps-xxl-3 ps-2
                        "
                      >
                        <p class="mb-0 text-capitalize">Live consult</p>
                        <span class="text-muted"
                          >Fee
                          {{
                            mentorDetails.without_schedule_types[1].fee
                          }}</span
                        >
                      </span>
                    </div>
                  </button>
                  <button
                    class="nav-link mb-3 shadow-sm"
                    id="v-pills-home-tab"
                    data-bs-toggle="pill"
                    :data-bs-target="
                      '#v-pills-' + schedule.appointment_type.name
                    "
                    type="button"
                    role="tab"
                    aria-controls="v-pills-home"
                    aria-selected="false"

                    v-for="schedule in mentorDetails.schedule_types"
                    :key="schedule.appointment_type_id"
                    @click="changeAppointmentType( schedule.appointment_type.name,schedule.appointment_type_id,schedule.fee)"
                  >
                    <div class="d-flex align-items-center">
                      <i
                        v-if="schedule.appointment_type_id == 2"
                        class="fa-solid fa-video"
                      ></i>
                      <i
                        v-if="schedule.appointment_type_id == 1"
                        class="fa-solid fa-volume-high"
                      ></i>
                      <i
                        v-if="schedule.appointment_type_id == 5"
                        class="fa-solid fa-house"
                      ></i>
                      <i
                        v-if="schedule.appointment_type_id == 4"
                        class="fa-solid fa-house-chimney-medical"
                      ></i>

                      <span
                        class="
                          d-flex
                          flex-column
                          justify-content-start
                          align-items-baseline
                          ps-xxl-3 ps-2
                        "
                      >
                        <p class="mb-0 text-capitalize">
                          {{ schedule.appointment_type.name }} consult
                        </p>
                        <span class="text-muted">Fee {{ schedule.fee }}</span>
                      </span>
                    </div>
                  </button>
                </div>
              </div>
              <div class="col-xxl-9 col-lg-8">
                <div
                  class="tab-content p-4 mt-lg-0 mt-4"
                  id="v-pills-tabContent"
                >
                  <div
                    class="tab-pane fade show active py-5"
                    id="v-pills-chat"
                    role="tabpanel"
                    aria-labelledby="v-pills-chat-tab"
                  >
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12">
                            <h6 class="text-primary">
                              No Schedule Required
                              <span class="text-muted">(Chat appointment)</span>
                            </h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade show  py-5"
                    id="v-pills-live"
                    role="tabpanel"
                    aria-labelledby="v-pills-livr-tab"
                  >
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12">
                            <h6 class="text-primary">
                              No Schedule Required
                              <span class="text-muted">(Live appointment)</span>
                            </h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade show"
                    :id="'v-pills-' + schedule.appointment_type.name"
                    role="tabpanel"
                    aria-labelledby="v-pills-home-tab"
                    v-for="schedule in mentorDetails.schedule_types"
                    :key="schedule.appointment_type_id"
                  >
                    <div class="row">
                      <div class="col-xl-8 col-md-7">
                        <h6 class="text-primary">
                          Select Date & Time Slots
                          <span class="text-muted"
                            >({{
                              schedule.appointment_type.name
                            }}
                            appointment)</span
                          >
                        </h6>
                        <p class="mb-0 mt-3" v-if="selected_new_date">
                       {{$t('book_appointment.available_time_slots')}}:
                      <span class="text-primary">{{ selected_new_date }}</span>
                    </p>
                      </div>
                      <div
                        class="
                          col-xl-4 col-md-5
                          d-flex
                          justify-content-md-end
                          mt-md-0 mt-2
                        "
                      >

                        <DatePicker
                        input-class="form-control bg-primary ps-4 text-white selectdate"
                        :format="'dd-MM-yyyy'"
                          :placeholder="'Select Date'"
                          v-model="selected_date"
                          :highlighted="hightlight_days"
                          v-on:input="
                            fetchAvailableSlots(
                              $event,
                              schedule.appointment_type_id
                            )
                          "
                          ></DatePicker>

                      </div>
                      <div v-if="!showSlots" class="col-md-12 position-relative">
                           <div class="middle">
                            <div class="text h6 mt-3 text-danger fw-bold">{{$t('book_appointment.placeholder')}}</div>
                        </div>
                        <div class="img-wrapper img-schedule">
                                <img :src= "url+'/assets/images/time-slots2.jpg'" class="img-fluid image w-100" alt="" style="opacity:.3">

                        </div>
                    </div>
                      <div v-else-if="availableSlots.length>0" class="col-md-12 mt-4">

                        <ul
                          class="nav nav-pills mb-3"
                          id="pills-tab"
                          role="tablist"
                        >
                          <li class="nav-item" role="presentation">
                            <button
                              class="btn btn-shift mt-lg-0 mt-3 active"
                              id="pills-morning-tab"
                              data-bs-toggle="pill"
                              :data-bs-target="'#pills-morning'+ schedule.appointment_type.name"
                              type="button"
                              role="tab"
                              aria-controls="pills-morning"
                              aria-selected="true"
                            >
                              <i class="fa-solid fa-sun text-secondary me-2"></i
                              >Morning
                            </button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="btn btn-shift mt-lg-0 mt-3"
                              id="pills-afternoon-tab"
                              data-bs-toggle="pill"
                              :data-bs-target="'#pills-afternoon'+ schedule.appointment_type.name"
                              type="button"
                              role="tab"
                              aria-controls="pills-afternoon"
                              aria-selected="false"
                            >
                              <i class="fa-solid fa-cloud text-info me-2"></i
                              >Afternoon
                            </button>
                          </li>
                          <li class="nav-item" role="presentation">
                            <button
                              class="btn btn-shift mt-lg-0 mt-3"
                              id="pills-eve-tab"
                              data-bs-toggle="pill"
                              :data-bs-target="'#pills-eve'+ schedule.appointment_type.name"
                              type="button"
                              role="tab"
                              aria-controls="pills-eve"
                              aria-selected="false"
                            >
                              <i class="fa-solid fa-moon text-primary me-2"></i
                              >Evening
                            </button>
                          </li>
                        </ul>
                        <div class="tab-content border-0" id="pills-tabContent">
                          <div
                            class="tab-pane fade show active"
                            :id="'pills-morning'+ schedule.appointment_type.name"
                            role="tabpanel"
                            aria-labelledby="pills-morning-tab"
                          >
                            <div class="mt-4">
                              <div class="row slots-overflow">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6"

                                v-for="(slot, index) in sortedSlots.morning" :key="index">
                                  <button
                                    class="btn btn-slots w-100 mb-3"
                                    v-bind:class="{
                                      active:
                                        isActive == index &&
                                        selectedFrom == 'morning',
                                         'bg-danger':
                                        slot.is_booked
                                    }"
                                    v-if="!slot.is_booked"
                                    @click="selectedSlot(index, 'morning')"
                                  >
                                    {{ slot.slot }}
                                  </button>
                                  <button
                                    class="btn btn-slots w-100 mb-3 text-danger"

                                    v-else
                                  >
                                    {{ slot.slot }}
                                  </button>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div
                            class="tab-pane fade"
                            :id="'pills-afternoon'+ schedule.appointment_type.name"
                            role="tabpanel"
                            aria-labelledby="pills-afternoon-tab"
                          >
                            <div class="mt-4">
                              <div class="row slots-overflow">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6"

                                v-for="(slot, index) in sortedSlots.afternoon" :key="index">
                                  <button
                                    class="btn btn-slots w-100 mb-3 "
                                    v-bind:class="{
                                      active:
                                        isActive == index &&
                                        selectedFrom == 'afternoon',
                                         'bg-danger':
                                        slot.is_booked
                                    }"
                                    v-if="slot.is_booked==0"

                                    @click="selectedSlot(index, 'afternoon')"
                                  >
                                   {{ slot.slot }}
                                  </button>
                                  <button
                                    class="btn btn-slots w-100 mb-3 text-danger"

                                    v-else
                                  >
                                    {{ slot.slot }}
                                  </button>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div
                            class="tab-pane fade"
                            :id="'pills-eve'+ schedule.appointment_type.name"
                            role="tabpanel"
                            aria-labelledby="pills-eve-tab"
                          >
                            <div class="mt-4">
                              <div class="row slots-overflow">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-6"

                                v-for="(slot, index) in sortedSlots.evening" :key="index"

                                >
                                  <button
                                    class="btn btn-slots w-100 mb-3"
                                    v-bind:class="{
                                      active:
                                        isActive == index &&
                                        selectedFrom == 'evening',
                                         'bg-danger':
                                        slot.is_booked
                                    }"
                                    v-if="slot.is_booked==0"
                                    @click="selectedSlot(index, 'evening')"
                                  >
                                    {{ slot.slot }}
                                  </button>
                                  <button
                                    class="btn btn-slots w-100 mb-3 text-danger"

                                    v-else
                                  >
                                    {{ slot.slot }}
                                  </button>
                                </div>

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div v-else class="text-danger">
                        No Slots Found
                    </div>

                    </div>
                  </div>
                </div>
                <div class="d-flex mt-4 justify-content-end align-items-center">
                  <button v-if="continue_btn"
                  @click="loadAppointmentComponent()"
                  class="btn btn-secondary text-white px-4">
                    Continue
                    <i class="fa-solid fa-angles-right ms-1"></i>
                  </button>
                  <button v-if="!continue_btn && !appointment_chat"
                  @click="sendLiveAppointmentNotification()"
                  class="btn btn-secondary text-white px-4">
                    Continue
                    <i class="fa-solid fa-angles-right ms-1"></i>
                  </button>
                  <button v-if="appointment_chat"
                  @click="loadAppointmentComponent()"
                  class="btn btn-secondary text-white px-4">
                    Continue
                    <i class="fa-solid fa-angles-right ms-1"></i>
                  </button>

                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </section>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import DatePicker from '@sum.cumo/vue-datepicker'
import '@sum.cumo/vue-datepicker/dist/Datepicker.css'
export default {
  props: ["url", "mentor_id","route","liveRoute","appointmentid","google_capcha_site_key"],
  mixins: [loginMixin],
   components: {
    DatePicker,
  },
  data() {
    return {
      loading: true,
      mentorId: this.mentor_id,
      mentorDetails: [],
      selected_date: "",
      selected_new_date: "",
      availableSlots: [],
      showSlots: false,
      appointment_id: "",
      isActive: null,
      selectedFrom: "",
      sortedSlots: {
        morning: [],
        afternoon: [],
        evening: [],
      },
      user_selected_slot: "",
      user_selected_slot_endtime:"",
      continue_btn: false,
      appointmentComponent: false,
      appointment_fee: "",
      live_fee: "",
      appointment_chat:true,
      appointment_live:false,
      type:'',
      hightlight_days:{}
    };
  },
  methods: {
      changeAppointmentType(appointmentTypeString,appointmentType,fee){
          this.sortedSlots.morning=[];
          this.sortedSlots.afternoon=[];
          this.sortedSlots.evening=[];
          this.availableSlots=[];
          this.showSlots=false;
          this.type=appointmentTypeString;
          this.appointment_fee=fee;
          this.appointment_id=appointmentType;
          if(appointmentType!=3){
              this.appointment_chat=false;
          }
          else if(appointmentType==3){
              this.appointment_chat=true;
          }else if(appointmentType==6){
            this.appointment_live=true;
          }
          this.getAvailableDays()
      },
    async fetchAvailableSlots(e, appointment_type) {
      let today = new Date(e).toLocaleDateString('en-us');
      this.selected_date = today;
      this.selected_new_date = today;
      const params = {
        token: 123,
        mentor_id: this.mentor_id,
        date: this.selected_date,
        appointment_type_id: appointment_type,
      };
      const res = await axios.get("/api/get-date-schedule", { params });
      if (res.data && res.data.Status) {
                this.availableSlots = [];
        this.sortedSlots.morning = [];
        this.sortedSlots.evening = [];
        this.sortedSlots.afternoon = [];
        this.availableSlots = res.data.data.schedule.schedule_slots
          ? res.data.data.schedule.schedule_slots
          : [];
        this.appointment_fee = res.data.data.schedule.fee;
        if (this.availableSlots.length > 0) {
          this.availableSlots.forEach((element) => {
            let time = parseInt(this.getTwentyFourHourTime(element.start_time));
            if (time >= 1 && time < 7) {
              //evening
              this.sortedSlots.evening.push({
                slot: element.start_time,
                is_booked: element.is_booked
                ,'end_time': element.end_time
              });
            } else if (time >= 7 && time < 12) {
              //morning
              this.sortedSlots.morning.push({
                slot: element.start_time,
                is_booked: element.is_booked,'end_time': element.end_time
              });
            } else if (time >= 12 && time < 18) {
              //afternoon
              this.sortedSlots.afternoon.push({
                slot: element.start_time,
                is_booked: element.is_booked,'end_time': element.end_time
              });
            } else if (time >= 18) {
              //evening
              this.sortedSlots.evening.push({
                slot: element.start_time,
                is_booked: element.is_booked,'end_time': element.end_time
              });
            }
          });
        }
        this.selected_date = "";
        this.showSlots = true;
      }
    },
    getTwentyFourHourTime(amPmString) {
      var d = new Date("1/1/2013 " + amPmString);
      return d.getHours() + ":" + d.getMinutes();
    },
    selectedSlot(e, sf) {
      if (this.selectedFrom == sf && this.isActive == e) {
        this.isActive = null;
        this.continue_btn = false;
      } else {
        this.isActive = e;
        this.selectedFrom = sf;
        this.continue_btn = true;
      }

      this.user_selected_slot =
        this.sortedSlots[this.selectedFrom][this.isActive].slot;
      this.user_selected_slot_endtime = this.sortedSlots[this.selectedFrom][this.isActive].end_time;

    },
    async fetchMentorData() {
      const params = {
        token: 123,
        user_id: this.mentor_id,
      };
      const res = await axios.get("/api/getUserById", { params });
      if (res.data && res.data.Status) {
        this.mentorDetails = res.data.data.userDetail;
        // this.live_fee = res.data.data.userDetail.schedule.fee ? res.data.data.userDetail.schedule.fee : ''
        this.loading = false;
      }
    },
    async sendLiveAppointmentNotification() {
      const params = {
        token: 123,
        user_id: this.mentor_id,
        body: "Click here to Accept Live Appointment Request ",
        title: "Live Appointment Request for You.",
        link: this.url+"/live/"+this.User.user_id+"/"+this.appointment_id+"/"+this.appointment_fee,
      };
      const res = await axios
        .post("/api/send-web-notification", params)
        .then((res) => {});
    },
    async loadAppointmentComponent() {

      if(this.appointment_chat){
          await this.fetchAppointmentTypeFee();
      }
      this.appointmentComponent = true;
    },
    async getAvailableDays(){
        const params = {
        token: 123,
        mentor_id: this.mentor_id,
        appointment_type_id: this.appointment_id,
      };
      const res = await axios.get("/api/get-available-days", { params });

      if (res.data && res.data.Status) {
          let days=res.data.data.mentorSchedules;
          let found_days=[];
          days.forEach(function(currentValue, index, arr){
              if(currentValue.is_holiday==0){
                 if(currentValue.day=='monday'){
                     found_days.push(1);
                 }
                 else if(currentValue.day=='tuesday'){
                     found_days.push(2);
                 }
                 else if(currentValue.day=='wednesday'){
                     found_days.push(3);
                 }
                 else if(currentValue.day=='thursday'){
                     found_days.push(4);
                 }
                 else if(currentValue.day=='friday'){
                     found_days.push(5);
                 }
                 else if(currentValue.day=='saturday'){
                     found_days.push(6);
                 }else {
                     found_days.push(7);
                 }

              }
          });

           this.hightlight_days= {
                days:found_days,
            }



      }
    },
    async fetchAppointmentTypeFee() {
      const params = {
        token: 123,
        mentor_id: this.mentor_id,
        appointment_type_id: 3,
      };
      const res = await axios.get("/api/get-mentor-fee", { params });
      if (res.data && res.data.Status) {
        this.appointment_fee = res.data.data.mentor_fee.fee;
        this.appointment_id=3;
        this.type='chat';
      }
    },
  },
  created() {
    this.fetchMentorData();
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentee") {
    } else if (this.is_loggedIn && this.User.role == "Mentor") {
      this.$toasted.error("Please Login as a User");
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
  },
};
</script>
<style>
.selectdate{
    -webkit-text-stroke: .5px white !important;
}
</style>
