<template>
  <section class="signup pt-0 pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div
            class="
              h-100
              d-flex
              justify-content-center
              align-content-center
              flex-column
              signup-section
              py-5
            "
          >
          <a href="/">
            <img
              :src="url + '/assets/images/sign-up-logo.png'"
              class="logo"
              alt=""
            /></a>

            <h1 class="fw-bold my-4 text-primary">
              Reset Password <img src="/assets/images/arrow.png" alt="" class="ps-3">
            </h1>


            <div>

                <div class="form-signup">
                 <div class="position-relative">
                    <input
                      :type="type"
                      name="mentee_password"
                      id="mentee_password"
                      v-model="password"
                      placeholder="New Password"
                      class="form-control mt-4"
                    />
                    <i
                      class="fa-solid fa-eye position-absolute"
                      id="togglePassword"
                      @click="showPassword"
                    ></i>
                  </div>
                  <div class="position-relative">
                    <input
                      :type="type"
                      name="mentee_password"
                      id="mentee_password"
                      v-model="confirm_password"
                      placeholder="Confirm New Password"
                      class="form-control mt-4"
                    />
                    <i
                      class="fa-solid fa-eye position-absolute"
                      id="togglePassword"
                      @click="showPassword"
                    ></i>
                  </div>


                  <button
                    class="btn btn-secondary text-white w-100 mt-5"
                    @click="resetPassword"
                  >
                    Update Password
                  </button>
                </div>

            </div>
          </div>
        </div>
        <div class="col-md-6 col-12 px-0">
          <img
            :src="url + '/assets/images/sign-up-side-img.png'"
            alt=""
            class="img-fluid signup-wrapper w-100 d-md-block d-none"
          />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
export default {
  props: ["url", "token"],
  data() {
    return {
        type:'password',
      password:'',
      confirm_password:''
    };
  },
  methods: {
      showPassword() {
       if(this.type === "password") {
          this.type = 'text'
       } else {
          this.type = 'password'
       }
     },

    resetPassword() {
      var toast = this.$toasted;

      const params = {
        password: this.password,
        password_confirmation:this.confirm_password,
        token:this.token
      };
      axios
        .post("/api/reset-password", params)
        .then((response) => {
          if (response.data.Status) {
            toast.success(response.data.msg);
            window.location="/login";
          } else if (!response.data.Status && response.data.errors) {
            for (const property in response.data.errors) {
              toast.error(response.data.errors[property][0]);
            }
          } else {
            toast.error(response.data.msg);
          }
        })
        .catch((error) => {
          toast.error(error);
        });
    },

  },
  created() {

  },
  mounted() {

  },
};
</script>
