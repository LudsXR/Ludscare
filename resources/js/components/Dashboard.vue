<template>
  <section class="pb-0 pt-0 bg-white">
    <div class="wrapper d-sm-flex w-100">
      <!-- Sidebar Holder -->
      <nav id="sidebar">
        <div class="sidebar-header d-flex justify-content-center">
          <img  v-if="mentorDetails.image_path" :src="mentorDetails.image_path" alt="" />
            <img
                    v-else
                      src="/assets/images/deashboard-img.png"
                      class="rounded-circle"
                    />
        </div>
      </nav>

      <!-- Page Content Holder -->
      <div id="content" class="p-2 pt-3 bg-white w-100">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
          <div class="container-fluid ps-0">
            <div class="col-md-3">
              <button
                type="button"
                id="sidebarCollapse"
                class="btn btn-toggle p-0"
                @click="sidebar"
              >
                <span><i class="fas fa-bars"></i></span>
              </button>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-5">
              <div
                class="
                  bg-secondary
                  profile-bar
                  text-white
                  py-1
                  pe-2
                  ps-4
                  d-flex
                "
              >

                <div
                  class="
                    dropdown
                    me-2
                    d-flex
                    justify-content-center
                    align-items-center
                    lang-text
                    text-dark
                  "
                >
                  <a
                    href="#"
                    class="
                      dropdown-toggle
                      text-white
                      d-flex
                      px-2
                      py-1
                      justify-content-center
                      align-items-center
                    "
                    data-bs-toggle="dropdown"
                    >
                    <div class="sticky-bar-img rounded-circle  me-2">
                    <img
                    v-if="mentorDetails.image_path"
                        :src="mentorDetails.image_path"
                      class="rounded-circle"
                        />
                    <img
                    v-else
                      src="/assets/images/deashboard-img.png"
                      class="rounded-circle"
                    />
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item text-dark" :href="url+'/dashboard'">Dashboard</a>
                    <a class="dropdown-item text-dark" :href="url+'/mentor-profile'">Profile</a>
                    <a class="dropdown-item text-dark" :href="url+'/generate-schedule'">Generate Schedule</a>
                    <a class="dropdown-item text-dark" :href="url+'/mentor/appointment-log'">Appointment Log</a>
                    <a class="dropdown-item text-dark" :href="url+'/wallet'">Wallet</a>
                    <a class="dropdown-item text-dark"  href="#" v-if="is_loggedIn && this.User.role"
                    @click="logout()"
                    >Logout</a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
        <div class="content-section mt-4">
          <div class="row">
              <div class="alert alert-danger" role="alert" v-if="!loading && mentorDetails.mentor.status == 0">
         {{ $t('mentor.profile.under_review') }}
            </div>
            <div class="col-lg-6">
              <div class="card card-intro border-0 p-4">
                <div class="row">
                  <div
                    class="
                      col-md-4
                      d-flex
                      justify-content-center
                      flex-column
                      align-items-center
                    "
                  >
                  <div class="img-wrap rounded-circle">
                    <img
                    v-if="mentorDetails.image_path"
                        :src="mentorDetails.image_path"
                        alt="profile-img"
                        class="rounded-circle"
                    />
                    <img
                    v-else
                    src="/assets/images/profile_placeholder.png"
                        alt="profile-img"
                        class="rounded-circle"
                    />
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div
                      class="d-flex flex-column h-100 justify-content-center"
                    >
                      <h6 class="text-dark mt-md-0 mt-3">
                       {{ shiftMessage }},
                        <span class="text-primary fw-bold">{{
                            this.mentorDetails.first_name +
                            " " +
                            this.mentorDetails.last_name
                          }}</span>
                      </h6>
                      <p class="mb-0">
                        {{ $t('mentor.dashboard.paragraph_text1') }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div
                class="
                  card card-total-appointment
                  border-0
                  py-lg-4 py-5
                  px-4
                  h-100
                  mt-lg-0 mt-4
                "
              >
                <h6 class="text-white">{{ $t('mentor.dashboard.total_appointment') }}</h6>
                <label class="h1 mb-0 mt-2 text-white">{{totalAppointment}}</label>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6">
              <div
                class="
                  card card-cancel-appointment
                  border-0
                  py-lg-4 py-5
                  px-4
                  h-100
                  mt-lg-0 mt-sm-4 mt-5
                "
              >
                <h6 class="text-dark fw-bold">{{ $t('mentor.dashboard.appointment_cancelled') }}</h6>
                <label class="h1 mb-0 mt-2 fw-bold">{{cancelledAppointment}}</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-9 mt-md-0 mt-5">
              <div class="head-bg py-3 px-4 mt-5">
                <div class="row">
                  <div class="col-md-7 d-flex align-items-center">
                    <h6 class="text-dark fw-bold mb-0">{{ $t('mentor.dashboard.todays_appointment') }}</h6>
                  </div>
                  <div
                    class="
                      col-md-5
                      d-flex
                      align-items-center
                      justify-content-md-end
                    "
                  >
                    <a href="" class="text-success mt-md-0 mt-2 fw-bold">
                        {{ $t('mentor.dashboard.view_all') }}
                    </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive mt-md-5 mt-4">
                    <table class="table table-borderless">
                      <thead class="text-dark fw-bold border-bottom">
                        <tr>
                          <td>{{ $t('mentor.dashboard.table.questions') }}</td>
                          <td>{{ $t('mentor.dashboard.table.date') }}</td>
                          <td>{{ $t('mentor.dashboard.table.time') }}</td>
                          <td>{{ $t('mentor.dashboard.table.type') }}</td>
                          <td>{{ $t('mentor.dashboard.table.amount') }}</td>
                          <td>{{ $t('mentor.dashboard.table.p_status') }}</td>
                          <td>{{ $t('mentor.dashboard.table.action') }}</td>
                        </tr>
                      </thead>
                      <tbody class="text-dark">
                        <tr class="align-middle border-bottom"
                        v-for="appointment in todayAppointment" :key="appointment.id"

                        >
                          <td>{{appointment.questions}}</td>
                          <td>{{appointment.date}}</td>
                          <td>{{appointment.time}}</td>
                          <td>{{appointment.appointment_type_string}}</td>
                          <td class="text-success">Rs: {{appointment.payment}}</td>
                          <td v-if="appointment.is_paid == 0" class="py-3">
                            <span class="text-danger me-2"
                                ><i class="fas fa-times"></i
                            ></span>
                            {{ $t('mentor.dashboard.table.unpaid_text') }}
                            </td>
                            <td v-if="appointment.is_paid == 1" class="py-3">
                            <span class="text-primary me-2"
                                ><i class="fas fa-check"></i
                            ></span>
                            {{ $t('mentor.dashboard.table.paid_text') }}
                            </td>
                          <td>
                            <a
                              :href="`${
                                    url + '/mentor/appointment-log-detail/' + appointment.id
                                }`"

                              class="btn btn-dark-primary text-white mt-1"
                              >{{ $t('mentor.dashboard.table.view_details') }}</a
                            >
                          </td>
                        </tr>
                        <tr v-if="todayAppointment.length == 0">
                        <td colspan="9" class="text-center">
                            No record found
                        </td>
                    </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3">
              <div class="head-bg py-3 px-4 mt-5">
                <div class="row">
                  <div class="col-12 d-flex align-items-center">
                    <h6 class="text-dark fw-bold mb-0">{{ $t('mentor.dashboard.rating.label') }}</h6>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div
                    class="card border-0 shadow-c mt-md-5 mt-4 py-3 px-5 rating"
                  >
                  <div class="row">
                      <div class="col-md-12 ps-0">
<h1 class="text-dark" v-if="ratingsData.totalRatings == 0" >N/A<span>/5</span></h1>
                   <h1 class="text-dark" v-else >{{this.ratingsData.avgRatings}}<span>/5</span></h1>
                      </div>
                  </div>
<div class="row">
    <div class="col-md-12 ps-0">
  <div class="rating-stars d-inline-block position-relative w-star" v-if="ratingsData.totalRatings == 0">

                        <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                        <div class="filled-star" style="width: 0%"></div>

                    </div>
                    <div class="rating-stars d-inline-block position-relative w-star" v-else>

                        <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                        <div class="filled-star" style="width: 100%"></div>

                    </div>

    </div>
</div>
<div class="row">
    <div class="col-md-12 ps-0 mb-3">
        <span class="rating-count mt-2 ">{{ $t('mentor.dashboard.rating.total') }}: {{this.ratingsData.totalRatings}}</span>
    </div>
</div>

                    <div class="rating-bar" v-if="ratingsData.fiveRatings == 0">
                      <div class="row d-flex align-items-center" >
                        <div class=" d-inline-block position-relative
                        col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        ">
                        <div class="rating-stars">
 <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" style="width: 0%"></div>
                        </div>

                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              aria-valuenow="75"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">5</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-else>
                      <div class="row d-flex align-items-center" >
                        <div class="rating-stars d-inline-block position-relative
                        col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        ">
                            <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" :style="'width:' +this.bindStar.five+'%'"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar "
                              role="progressbar"
                              :style="'width:' +this.bindStar.five+'%'"
                              :aria-valuenow="this.bindStar.five"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">5</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-if="ratingsData.fourRatings == 0">
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" style="width: 0%"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              aria-valuenow="75"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">4</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-else>
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" :style="'width:' +this.bindStar.four+'%'"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar"
                              role="progressbar"
                              :style="'width:' +this.bindStar.four+'%'"
                               :aria-valuenow="this.bindStar.four"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">4</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-if="ratingsData.threeRatings == 0">
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" style="width: 0%"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              aria-valuenow="75"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">3</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-else>
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                            <div class="filled-star" :style="'width:' +this.bindStar.three+'%'"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar"
                              role="progressbar"
                              :style="'width:' +this.bindStar.three+'%'"
                              :aria-valuenow="this.bindStar.three"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">3</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-if="ratingsData.twoRatings == 0">
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                         <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                         <div class="filled-star" style="width: 0%"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              aria-valuenow="75"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">2</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-else>
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                         <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                         <div class="filled-star" :style="'width:' +this.bindStar.two+'%'"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              :style="'width:' +this.bindStar.two+'%'"
                              :aria-valuenow="this.bindStar.two"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">2</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-if="ratingsData.oneRatings == 0">
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                          <div class="filled-star" style="width: 0%"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              aria-valuenow="75"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">1</span>
                        </div>
                      </div>
                    </div>
                    <div class="rating-bar" v-else>
                      <div class="row d-flex align-items-center">
                        <div class="col-xl-5 col-lg-2 col-md-2 col-5 pe-0 ps-0
                        rating-stars d-inline-block position-relative
                        ">
                          <img :src="url + '/assets/images/grey-star.svg'" alt="" />
                          <div class="filled-star" :style="'width:' +this.bindStar.one+'%'"></div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-5 col-5">
                          <div class="progress mt-1">
                            <div
                              class="progress-bar w-0"
                              role="progressbar"
                              :style="'width:' +this.bindStar.one+'%'"
                              :aria-valuenow="this.bindStar.one"
                              aria-valuemin="0"
                              aria-valuemax="100"
                            ></div>
                          </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-2">
                          <span class="rating-count">1</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script type="text/javascript">
import loginMixin from "../mixins/loginMixin.js";
export default {
  props: ["url"],
  mixins: [loginMixin],
  data() {
    return {
      loading: true,
      ratingLoading: true,
      mentorDetails: {},
      totalAppointment: 0,
      cancelledAppointment: 0,
      todayAppointment: [],
      shiftMessage: "",
      mentor_id: "",
      ratingsData:{},
      bindStar: {
          five:'',
          four:'',
          three:'',
          two:'',
          one:''
      }
    };
  },
  methods: {
      logout() {
      var toast = this.$toasted;
      toast.success("Logout Successfully");
      localStorage.removeItem("User");
      window.location.href = "/";
    },

    async sidebar(){
            $('#sidebar').toggleClass('active');
    },
    async fetchMentorData() {
      const params = {
        token: 123,
        user_id: this.mentor_id,
      };
      const res = await axios.get("/api/getUserById", {
        params,
      });
      if (res.data && res.data.Status) {
        this.mentorDetails = res.data.data.userDetail;
        this.loading = false;
      }
    },
    async fetchAppointmentCount() {
      const params = {
        token: 123,
        user_id: this.mentor_id,
      };
      const res = await axios.get("/api/appointment-count", {
        params,
      });
      if (res.data.Status) {
        this.totalAppointment = res.data.data.allAppointmentsCount
          ? res.data.data.allAppointmentsCount
          : 0;
        this.cancelledAppointment = res.data.data.cancelAppointments
          ? res.data.data.cancelAppointments
          : 0;
      }
    },

    async fetchMentorTodayAppointment() {
      const params = {
        token: 123,
        mentor_id: this.mentor_id,
      };
      const res = await axios.get("/api/today-appointments", {
        params,
      });
      if (res.data && res.data.Status) {
        this.todayAppointment = res.data.data.results;
      }
    },
    async fetchMentorRatings() {
      const params = {
        token: 123,
        mentor_id: this.mentor_id,
      };
      const res = await axios.get("/api/get-ratings-detail", {
        params,
      });
      if (res.data && res.data.Status) {
        this.ratingsData = res.data.data;
        if(this.ratingsData.totalRatings > 0)
        {
            var five = (res.data.data.fiveRatings * 100)/ res.data.data.totalRatings;
            this.bindStar.five = Math.round(100 - five);
             var four = (res.data.data.fourRatings * 100)/ res.data.data.totalRatings;
            this.bindStar.four = Math.round(100 - four);
             var three = (res.data.data.threeRatings * 100)/ res.data.data.totalRatings;
            this.bindStar.three = Math.round(100 - three);
             var two = (res.data.data.twoRatings * 100)/ res.data.data.totalRatings;
            this.bindStar.two = Math.round(100 - two);
             var one = (res.data.data.oneRatings * 100)/ res.data.data.totalRatings;
            this.bindStar.one = Math.round(100 - one);
        }
        this.ratingLoading = false
      }
    },
  },
  created() {
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentor") {
        this.mentor_id = this.User.user_id
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }

    var today = new Date();
    var curHr = today.getHours();

    if (curHr < 12) {
      this.shiftMessage = "Good Morning";
    } else if (curHr < 18) {
      this.shiftMessage = "Good Afternoon";
    } else {
      this.shiftMessage = "Good Evening";
    }
    this.fetchMentorData();
    this.fetchAppointmentCount();
    this.fetchMentorTodayAppointment();
    this.fetchMentorRatings();
  },

};


</script>


