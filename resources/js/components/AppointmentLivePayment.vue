<template>

<div class="container">
  <div class="row">



        <div class="col-md-12 ps-4"  style="padding-bottom:9rem !important">
      <h5 class="text-primary mt-lg-0 mt-5">Select Payment Method</h5>
      <div class="payment-card mt-3">
        <ul class="d-inline-flex ps-0" type="none">
            <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="paytm"
                          />
                            <img

                src="/assets/images/paytm.png"

              /></label
                          >
            </div>
          </li>
            <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="jazzcash"
                          />
                            <img

                src="/assets/images/jazzcash.jpg"

              /></label
                          >
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
             <label  class="h-100">
               <input
                            type="radio"
                            v-model="payment_method"
                            value="easypaisa"
                          />
                            <img

                src="/assets/images/easypaisa.jpg"

              /></label
                          >
            </div>
          </li>
             <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="wave" >
              <img

                src="/assets/images/wave.png"

              />
            </label>
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                d-md-flex
                h-100
                bg-transparent
                align-items-center
                justify-content-center
                border-0
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="braintree" >
              <img

                src="/assets/images/braintree.png"

              />
            </label>
            </div>
          </li>

          <li class="pe-2">
            <div
              class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              "
            >
            <label class="h-100">
  <input type="radio" v-model="payment_method" value="paypal">
              <img
                src="/assets/images/paypal-icon.png"
                alt=""
                class="img-fluid"
              />
            </label>
            </div>
          </li>
          <li class="pe-2">
            <div
              class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              "
            >
              <!-- <input type="radio" v-model="payment_method" name="payment_method" value="stripe" /> -->
              <label class="h-100">
  <input type="radio" v-model="payment_method" name="payment_method" value="stripe">
              <img
                src="/assets/images/strip.png"
                alt=""
                class="img-fluid"
              />
              </label>
            </div>
          </li>
          <li class="">
            <div
              class="
                card
                border-0
                bg-transparent
                d-md-flex
                h-100
                align-items-center
                justify-content-center
              "
            >
              <!-- <input type="radio" v-model="payment_method" name="payment_method" value="stripe" /> -->
              <label class="h-100">
  <input type="radio" v-model="payment_method" name="payment_method" value="wallet">
              <img
                src="/assets/images/wallet.png"
                alt=""
                class="img-fluid"
              />
              </label>
            </div>
          </li>
        </ul>
      </div>
      <div class="form-card" v-if="payment_method=='jazzcash'">
        <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
        <input
          class="form-control py-2 mb-3"
                              type="number"
                              placeholder="Enter Jazzcash Mobile Number"
                              v-model="jazzcash.mobile_no"
                              aria-label="default input example"
        />
        <input
         class="form-control py-2 mb-3"
                              type="number"
                              placeholder="Enter Last 6 Digit of CNIC"
                              maxlength="6"
                              v-model="jazzcash.cnic_digit"
        />

      </div>
      <div class="form-card" v-if="payment_method=='paytm'">
        <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
        <input
          class="form-control py-2 mb-3"
                              type="number"
                              placeholder="Enter  Mobile Number"
                              v-model="paytm.mobile_no"
                              aria-label="default input example"
        />
        <input
         class="form-control py-2 mb-3"
                              type="text"
                              placeholder="Enter Email"

                              v-model="paytm.email"
        />

      </div>
      <div class="form-card" v-if="payment_method!='wallet' && payment_method!='wave' && payment_method!='jazzcash' && payment_method!='easypaisa' && payment_method!='paytm' ">
        <h6 class="text-muted pt-3">Enter Card Details</h6>
        <input
          type="text"
          name=""
          id=""
          class="form-control border mt-3"
          placeholder="Card Holder Name"
        />
        <input
          type="number"
          name=""
          v-model="payment_details.card_number"
          id=""
          class="form-control border mt-3"
          placeholder="Card Number"
        />
        <div class="row">
          <div class="col-md-4">
            <datetime
                          input-class="form-control border mt-3"
                          type="date"
                          :flow="['year']"
                          :format="'yy'"
                          placeholder="Year"
                          v-model="payment_details.exp_year"
                        ></datetime>
          </div>
          <div class="col-md-4">
            <datetime
                          input-class="form-control border mt-3"
                          type="date"
                          :flow="['month']"
                          :format="'MM'"
                          placeholder="Month"
                          v-model="payment_details.exp_month"
                        ></datetime>
          </div>
          <div class="col-md-4">
            <input
              type="number"
              name=""
              id=""
              class="form-control border mt-3"
              placeholder="CVV Code"
              v-model="payment_details.cvc"
            />
          </div>
        </div>
      </div>
      <div class="d-flex pt-5 justify-content-end align-items-center">
        <button
          class="btn btn-graish me-2 text-white"
          @click="$emit('cancelAppointment')"
        >
          <i class="fa-solid fa-angles-left me-1"></i>
          Back
        </button>
         <!-- data-bs-toggle="modal"
          data-bs-target="#exampleModal" -->
        <button
          class="btn btn-secondary text-white"
            @click="makePayment"
        >
          Make Payment
          <i class="fa-solid fa-angles-right ms-1"></i>
        </button>
      </div>
    </div>





    </div>
</div>

</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
export default {
 props: ['url','appointment_id','appointment_fee'],
  mixins: [loginMixin],
data(){
    return {
    payment_details:{
          card_number:'',
          exp_month:'',
          exp_year:'',
          cvc:''
      },
      jazzcash: {
        mobile_no: "",
        cnic_digit: "",
      },
      paytm:{
        mobile_no:"",
        email:""
      },
      payment_method:'',
    }
},
methods:{
    async makePayment(){
        var toast = this.$toasted;
        this.loading = true;
        let total=this.appointment_fee;
        let appointmentID=this.appointment_id;
         let expMonth=new Date(this.payment_details.exp_month).getUTCMonth()+1;
            let body={
                "mentee_id": this.User.user_id,
                "total":total,
                "payment_method_code": this.payment_method,
                "cardInfo": {
                    "number":this.payment_details.card_number,
                    "exp_month": '0'+expMonth,
                    "exp_year": new Date(this.payment_details.exp_year).getFullYear(),
                    "cvc": this.payment_details.cvc
                },

                "shipping_address": {
                    "id": "",
                    "first_name": "shahzad",
                    "last_name": "Tariq",
                    "email": "fharshad842@gmail.com",
                    "city_id": 85335,
                    "state_id": 3176,
                    "country_id": 167,
                    "zip_code": "38000",
                    "address": "Bismillah General Store Back Saira Mall Plaza Dogar Basti\nPeople Colony # 1 D Ground Faisalabad",
                    "phone": "034677992777"
                },
                "shipping_id": 1,
                "plateForm": "web",
                "paytm_mode": "",
                "bookAppointmentId": appointmentID
            };
            const headers = {
                "Accept":"application/json",
                "Content-Type": "application/json",
        };
        if(this.payment_method=='paytm'){
          this.paymentLoading = true;
        var self = this;
        var toast = this.$toasted;

        window.location.href = this.url+"/payTm-order/"+appointmentID+"/"+this.paytm.mobile_no+"/"+this.paytm.email

        }
        if(this.payment_method=='jazzcash'){
          this.paymentLoading = true;
        var self = this;
        var toast = this.$toasted;
        var params = {
          token: 123,
          mobile_no: this.jazzcash.mobile_no,
          cnic: this.jazzcash.cnic_digit,
          amount: total,
          bookAppointmentId: appointmentID,
          mobile_account: 1,
        };
        const res = await axios
          .post("/api/makeJazzcashPayment", params)
          .then((res) => {
            if (res.data.Status) {
              this.loading = false;
              toast.success(res.data.msg);
              window.location.href = "/mentee/appointment/log";
            }
            if (!res.data.Status) {
              this.loading = false;
              toast.error(res.data.msg);
            }
            if (res.data.errors) {
              this.loading = false;
              for (const property in res.data.errors) {
                toast.error(res.data.errors[property][0]);
              }
            }
          });
        }
        if(this.payment_method=='easypaisa'){
             window.open(
          "/easypaisa?amount=" +
            this.formData.payment +
            "&bookAppointmentId=" +
            this.appointmentNo,
          "_blank"
        );
        this.loading = false;
         window.location.href = "/mentee/appointment-log";
        }
        if(this.payment_method =='flutterwave'){
            let base_url = window.location.origin;
          window.location='/pay?bookAppointmentId='+appointmentID+'&total='+total+'&mentee_id='+this.formData.mentee_id;
        }
        else if(this.payment_method =='stripe'){
            const res = await axios
            .post("/api/execute-payment", body, {
            headers: headers,
            }).then((res)=>{
                if(res.data.status==400){
                    toast.error(res.data.data.message);

                }
                if ( res.data.original && res.data.original.Status) {
                    toast.success(res.data.original.msg);
                    this.loading=false;
                    window.location='/mentee/appointment-log';


                }
                else if(! res.data.Status){

                    window.location=res.data.authorization_url;
                }

            })
            .catch((error)=>{

                if(error.response){
                    for (const property in error.response.data.errors) {
                        toast.error(error.response.data.errors[property]);
                    }
                }



            });
        }
        else if(this.payment_method=='wallet'){

        var self = this;

        var params = {
          token: 123,
          from_user_id: this.User.user_id,
          to_user_id: this.mentor_id,
          amount: total,
          bookAppointmentId: appointmentID,
        };
        const res = await axios
          .post("/api/wallet-credit-transfer", params)
          .then((res) => {
            if (res.data.Status) {
              this.loading = false;
              toast.success(res.data.msg);
              window.location.href = "/mentee/appointment-log";
            }
            if (!res.data.Status) {
              this.loading = false;
              toast.error(res.data.msg);
            }
          });
        }
        else if(this.payment_method=='braintree'){
            const res = await axios
            .post("/api/execute-payment", body, {
            headers: headers,
            }).then((res)=>{
                if(res.data.status==400){
                    toast.error(res.data.data.message);

                }
                if ( res.data.original && res.data.original.Status) {
                    toast.success(res.data.original.msg);
                    this.loading=false;
                    window.location='/mentee/appointment-log';


                }

            })
            .catch((error)=>{

                if(error.response){
                    for (const property in error.response.data.errors) {
                        toast.error(error.response.data.errors[property]);
                    }
                }



            });
        }
        else if (this.payment_method=='paypal'){
            const res = await axios
            .post("/api/execute-payment", body, {
            headers: headers,
            }).then((res)=>{
                if(res.data.status==400){
                    toast.error(res.data.data.message);

                }
                if ( res.data.original && res.data.original.Status) {
                    toast.success(res.data.original.msg);
                    this.loading=false;
                    window.location='/mentee/appointment-log';


                }else if(! res.data.Status){
                    localStorage.setItem('appointmentID',this.appointmentNo);
                    window.location=res.data.authorization_url;
                }

            })
            .catch((error)=>{

                if(error.response){
                    for (const property in error.response.data.errors) {
                        toast.error(error.response.data.errors[property]);
                    }
                }



            });
        }


    },
},
created() {

    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentee") {
    } else if (this.is_loggedIn && this.User.role == "Mentor") {
      this.$toasted.error("Please Login as a User");
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
  }

};

</script>
<style scoped>
 /* HIDE RADIO */
    [type=radio] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* IMAGE STYLES */
    [type=radio]+img {
        cursor: pointer;
        border: 2px solid #dee2e6;
        border-radius: 5px;
    }

    /* CHECKED STYLES */
    [type=radio]:checked+img {
        border: 2px solid orange !important;
    }
 .payment-card img{
    max-width: 60px;
    height: 40px;
    }
</style>
