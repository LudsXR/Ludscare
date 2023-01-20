<template>
  <div>
    <div class="nav-top">
      <nav class="navbar bg-primary">
        <div class="container">
          <p class="text-white mb-0">
              {{$t('company_name.title')}}
              </p>
          <div class="dropdown
                  me-2
                  d-flex
                  align-items-center
                  lang-text
                  text-white">
            <button
              class="py-0 px-md-2 px-0 btn btn-pirmary dropdown-toggle text-white nav-link border-0"
              type="button"
              id="dropdownMenuButton1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              {{ current_language }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" style="z-index:9999">
              <li>
                <a
                  class="dropdown-item"
                  v-on:click="changeLanguage('en')"
                  href="javascript:void(0)"
                  ><img
                    :src="url + '/assets/images/eng.png'"
                    alt=""
                    style="height: 20px"
                    class="img-fluid pe-2"
                  />English</a
                >
              </li>
              <li>
                <a
                  class="dropdown-item"
                  v-on:click="changeLanguage('ur')"
                  href="javascript:void(0)"
                  ><img
                    :src="url + '/assets/images/pak.png'"
                    alt=""
                    style="height: 20px"
                    class="img-fluid pe-2"
                  />اردو</a
                >
              </li>
              <li>
                <a
                  class="dropdown-item"
                  v-on:click="changeLanguage('hi')"
                  href="javascript:void(0)"
                  ><img
                    :src="url + '/assets/images/ind.png'"
                    alt=""
                    style="height: 20px"
                    class="img-fluid pe-2"
                  />हिन्दी</a
                >
              </li>
              <li>
                <a
                  class="dropdown-item"
                  v-on:click="changeLanguage('bn')"
                  href="javascript:void(0)"
                  ><img
                    :src="url + '/assets/images/bang.png'"
                    alt=""
                    style="height: 20px"
                    class="img-fluid pe-2"
                  />বাংলা</a
                >
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <div class="main-menu">
      <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
          <a class="navbar-brand" href="/">
            <img :src="url+logo" alt=""
          /></a>
          <button
            class="navbar-toggler border-0"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-0 ms-auto">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" :href="url">{{
                  $t("header_menu.home")
                }}</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" :href="url + '/categories'">{{
                  $t("header_menu.categories")
                }}</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/blog">{{
                  $t("header_menu.blogs")
                }}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/about-us">{{
                  $t("header_menu.about_us")
                }}</a>
              </li>
              <li class="nav-item pe-lg-3">
                <a class="nav-link" href="/contact-us">{{
                  $t("header_menu.contact_us")
                }}</a>
              </li>

            <li class="nav-item">
                <a
                  class="text-white fw-400 btn btn-secondary px-5"
                  v-if="!is_loggedIn && !this.User.role"
                  href="/login"
                  type="button"
                  >Login</a
                >
              </li>
              <div
                v-if="is_loggedIn && this.User.role == 'Mentee'"
                class="
                  dropdown navbar-nav
                  me-2
                  d-flex
                  justify-content-center
                  align-items-start
                  align-items-lg-center
                  lang-text
                  text-dark navbar-nav
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
                  <span class="text-dark me-2">{{User.name}}</span>
                  <img
                    :src="`${this.User.image?url+this.User.image:'/assets/images/profile_placeholder.png'}`"

                    width="30"
                    height="30"
                    class="rounded-circle me-2"
                  />
                </a>
                <div class="dropdown-menu dropdown-menu-end fw-500 w-100">
                  <a class="dropdown-item text-dark"
                  :href="this.url + '/mentee-profile'">
                  <!-- Profile -->
                 {{$t('mentee_profile_menu.profile')}}
                  </a>
                    <a
                    class="dropdown-item text-dark"
                    :href="this.url + '/mentee/appointment-log'"
                    >
                  {{$t('mentee_profile_menu.appointment')}}

                    </a
                  >
                  <a class="dropdown-item text-dark"
                  :href="this.url + '/wallet'"

                  >
                  {{$t('mentee_profile_menu.wallet')}}
                  </a>
                  <a
                    class="dropdown-item text-danger"
                    href="#"
                    v-if="is_loggedIn && this.User.role"
                    @click="logout()"
                    >
                  {{$t('mentee_profile_menu.logout')}}
                    </a
                  >
                </div>
              </div>

              <div
                v-if="is_loggedIn && this.User.role == 'Mentor'"
                class="
                  dropdown navbar-nav
                  me-2
                  d-flex
                  justify-content-start
                  align-items-start
                  align-items-lg-center
                  lang-text
                  text-dark
                  ps-lg-0
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
                  <span class="text-dark me-2">{{User.name}}</span>

                  <img
                    :src="`${this.User.image?url+this.User.image:'/assets/images/profile_placeholder.png'}`"

                    width="30"
                    height="30"
                    class="rounded-circle me-2"
                  />
                </a>
                <div class="dropdown-menu dropdown-menu-end  fw-500 w-100">
                  <a class="dropdown-item text-dark" :href="url + '/dashboard'"
                    >{{$t('header_menu.dropdown.dashboard')}}</a
                  >
                  <a
                    class="dropdown-item text-dark"
                    :href="this.url + '/mentor-profile'"
                    >
                    {{$t('header_menu.dropdown.profile')}}
                    </a
                  >
                  <a
                    class="dropdown-item text-dark"
                    :href="this.url + '/generate-schedule'"
                    >
                    {{$t('header_menu.dropdown.generate_schedule')}}
                    </a
                  >
                  <a
                    class="dropdown-item text-dark"
                    :href="this.url + '/mentor/appointment-log'"
                    >
                    {{$t('header_menu.dropdown.appointment_log')}}
                    </a
                  >
                  <a class="dropdown-item text-dark"
                  :href="this.url + '/wallet'"

                  >
                    {{$t('header_menu.dropdown.wallet')}}

                  </a>
                       <a class="dropdown-item text-dark"
                  :href="this.url + '/consultant/blogs'"

                  >
                    {{$t('header_menu.dropdown.blogs')}}

                  </a>
                  <a
                    class="dropdown-item text-danger"
                    href="#"
                    v-if="is_loggedIn && this.User.role"
                    @click="logout()"
                    >
                    {{$t('header_menu.dropdown.logout')}}

                    </a
                  >
                </div>
              </div>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
  props: ["url","logo"],
  mixins: [loginMixin],
  data(){
      return{
          locale: "",
        current_language: "",
        current_direction: "",
      }

  },
  watch: {
    locale(val) {
      this.$i18n.locale = val;
    },
  },
  methods: {
      changeLanguage(val) {
      this.$i18n.locale = val;
      localStorage.setItem("locale", val);
      if (val == "en") {
        this.current_language = "English";
        this.current_direction = "ltr";
        document.body.style.direction = this.current_direction;
        var body = document.body;
        body.classList.remove("lang_urdu");
      } else if (val == "hi") {
        this.current_language = "हिन्दी";
        this.current_direction = "ltr";
        document.body.style.direction = this.current_direction;
        var body = document.body;
        body.classList.remove("lang_urdu");
      } else if (val == "bn") {
        this.current_language = "বাংলা";
        this.current_direction = "ltr";
        document.body.style.direction = this.current_direction;
        var body = document.body;
        body.classList.remove("lang_urdu");
      } else {
        this.current_language = "اردو";
        this.current_direction = "rtl";
        document.body.style.direction = this.current_direction;
        var body = document.body;
        body.classList.add("lang_urdu");
      }
      localStorage.setItem("direction", this.current_direction);
    },
    logout() {
      var toast = this.$toasted;
      toast.success("Logout Successfully");
      localStorage.removeItem("User");
      window.location.href = "/";
    },
  },
  created() {

    this.checkLoggedIn();

    var lang = localStorage.getItem("locale");
    var body = document.body;
    if (lang) {
      this.locale = lang;
      if (lang == "en") {
        this.current_language = "English";
        this.current_direction = "ltr";
        body.classList.remove("lang_urdu");
        document.body.style.direction = this.current_direction;
      } else if (lang == "hi") {
        this.current_language = "हिन्दी";
        this.current_direction = "ltr";
        body.classList.remove("lang_urdu");
        document.body.style.direction = this.current_direction;
      } else if (lang == "bn") {
        this.current_language = "বাংলা";
        this.current_direction = "ltr";
        body.classList.remove("lang_urdu");
        document.body.style.direction = this.current_direction;
      } else {
        this.current_language = "اردو";
        this.current_direction = "rtl";
        body.classList.add("lang_urdu");
        document.body.style.direction = this.current_direction;


      }
    } else {
      this.current_language = "English";
      this.locale = "en";
      this.current_direction = "ltr";
      body.classList.remove("lang_urdu");
      document.body.style.direction = this.current_direction;
    }
  },
};
</script>
