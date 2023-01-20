<template>
    <div>
        <section class="wallet">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-secondary ps-4 p-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <p
                                        class="mb-0 text-white d-flex align-items-center"
                                    >
                                        {{
                                            $t(
                                                "wallet_log.current_wallet_balance"
                                            )
                                        }}:<span class="fw-bold ps-md-3"
                                            >{{currency_symbol}}
                                            {{ current_balance }}</span
                                        >
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="d-flex justify-content-md-end align-items-center h-100"
                                    >
                                        <button
                                            class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-if="this.User.role == 'Mentor'"
                                            type="button"
                                            id="withdraw"
                                            :disabled="current_balance == 0"
                                            data-bs-toggle="modal"
                                            data-bs-target="#withdrawModel"
                                        >
                                            {{
                                                $t(
                                                    "wallet_log.btn_label_withdraw"
                                                )
                                            }}
                                        </button>

                                        <button
                                            class="btn btn-primary fw-bold mt-md-0 mt-3 py-2 mb-md-0 mb-3 wallet-btn"
                                            v-else
                                            data-bs-toggle="modal"
                                            data-bs-target="#topUpModel"
                                        >
                                            {{
                                                $t("wallet_log.btn_label_topup")
                                            }}
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    {{ $t("wallet_log.withdraw_amount.title") }}
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
                                    type="number"
                                    class="form-control"
                                    required
                                    v-model="withdraw_amount"
                                    :placeholder="
                                        $t(
                                            'wallet_log.withdraw_amount.placeholder.amount'
                                        )
                                    "
                                />
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    id="withdraw_close"
                                >
                                    {{ $t("wallet_log.button.close") }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    v-on:click="withDrawAmount"
                                >
                                    {{ $t("wallet_log.button.submit") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Model Top Up-->
                <div
                    class="modal fade"
                    id="topUpModel"
                    tabindex="-1"
                    aria-labelledby="topUpModelLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content border-0">
                            <div class="modal-header bg-primary text-white">
                                <h5
                                    class="modal-title"
                                    id="addModelLabel"
                                    style="color: white"
                                >
                                    {{ $t("wallet_log.btn_label_topup") }}
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close text-white"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                    style="color: white"
                                ></button>
                            </div>
                            <div v-if="!loading" class="modal-body form-group">
                                <input
                                    type="number"
                                    class="form-control"
                                    required
                                    v-model="amount"
                                    :placeholder="
                                        $t('wallet_log.placeholder_amount')
                                    "
                                />
                                <div class="col-md-12">
                                    <h6 class="text-primary mt-3 fw-bold">
                                        {{ $t("wallet_log.label_method") }}
                                    </h6>
                                    <div class="payment-card mt-3">
                                        <ul
                                            class="d-inline-flex flex-wrap ps-0"
                                            type="none"
                                        >
                                            <li
                                                v-for="pm in payment_methods"
                                                class="pe-2 mb-2 "
                                            >
                                                <div
                                                    class="card border-0 d-md-flex h-100 bg-transparent align-items-center justify-content-center border-0"
                                                >
                                                    <label class="h-100">
                                                        <input
                                                            type="radio"
                                                            name="payment_method"
                                                            :value="pm.code"
                                                            checked
                                                            v-model="payment_method"
                                                        />
                                                        <img
                                                            :src="`${url + '/' + pm.image_path}`"
                                                            alt=""
                                                            class="img-fluid"
                                                        />
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

            <div class="form-card" v-if="payment_method == 'jazzcash'">
                <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter Jazzcash Mobile Number"
                    v-model="jazzcash.mobile_no" aria-label="default input example" />
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter Last 6 Digit of CNIC"
                    maxlength="6" v-model="jazzcash.cnic_digit" />

            </div>
            <div class="form-card" v-if="payment_method == 'paytm'">
                <h6 class="text-muted pt-3">Enter Mobile Account Detail</h6>
                <input class="form-control py-2 mb-3" type="number" placeholder="Enter  Mobile Number"
                    v-model="paytm.mobile_no" aria-label="default input example" />
                <input class="form-control py-2 mb-3" type="text" placeholder="Enter Email" v-model="paytm.email" />

            </div>
            <div class="form-card"
                v-if="payment_method && (payment_method != 'wallet' && payment_method != 'wave' && payment_method != 'jazzcash' && payment_method != 'easypaisa' && payment_method != 'paytm' && payment_method != 'razorpay' && payment_method != 'flutterwave')">
                <h6 class="text-muted pt-3">Enter Card Details</h6>
                <input type="text" name="" id="" class="form-control border mt-3" placeholder="Card Holder Name" />
                <input type="number" name="" v-model="payment_details.card_number" id=""
                    class="form-control border mt-3" placeholder="Card Number" />
                <div class="row">
                    <div class="col-md-4">
                        <datetime input-class="form-control border mt-3" type="date" :flow="['year']" :format="'yy'"
                            placeholder="Year" v-model="payment_details.exp_year"></datetime>
                    </div>
                    <div class="col-md-4">
                        <datetime input-class="form-control border mt-3" type="date" :flow="['month']" :format="'MM'"
                            placeholder="Month" v-model="payment_details.exp_month"></datetime>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="" id="" class="form-control border mt-3" placeholder="CVV Code"
                            v-model="payment_details.cvc" />
                    </div>
                </div>
            </div>
                                </div>
                            </div>
                            <div v-else class="modal-body form-group">
                                 <img src="/assets/images/loader.gif" height="100px" alt="">
                            </div>
                              <vue-recaptcha
                                :sitekey="google_capcha_site_key"
                                @verify="onVerify"
                                @expired="onExpired"
                                :loadRecaptchaScript="true"
                                ref="recaptcha" class="w-100"
                            ></vue-recaptcha>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal"
                                    id="add_ammount"
                                >
                                    {{ $t("wallet_log.button.close") }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    v-on:click="AddAmountToWallet"
                                    :disabled="loading || !recaptchaVerified"
                                >
                                    {{ $t("wallet_log.button.submit") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-white mt-4">
                            <div class="py-3 border-bottom">
                                <div class="bg-light pe-3">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div
                                                class="p-3 d-flex align-items-center h-100"
                                            >
                                                <p
                                                    class="text-primary mb-0 fw-bold head ps-lg-2"
                                                >
                                                    {{
                                                        $t(
                                                            "wallet_log.table_heading"
                                                        )
                                                    }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <tbody class="text-dark">
                                        <tr>
                                            <td class="py-3 ps-4">
                                                {{
                                                    $t("wallet_log.column.date")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t("wallet_log.column.time")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t(
                                                        "wallet_log.column.amount"
                                                    )
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t("wallet_log.column.type")
                                                }}
                                            </td>
                                            <td class="py-3">
                                                {{
                                                    $t(
                                                        "wallet_log.column.status"
                                                    )
                                                }}
                                            </td>
                                        </tr>
                                        <tr
                                            v-for="t in transactions"
                                            :key="t.id"
                                        >
                                            <td class="ps-4">{{ t.date }}</td>
                                            <td class="text-uppercase">
                                                {{ t.time }}
                                            </td>
                                            <td> {{currency_symbol}} {{ t.amount }}</td>
                                            <td class="text-success">
                                                {{ t.type }}
                                            </td>
                                            <td v-if="t.confirmed">
                                                <i
                                                    class="fa-solid fa-check pe-2 text-success"
                                                ></i
                                                >{{
                                                    $t(
                                                        "wallet_log.button.success"
                                                    )
                                                }}
                                            </td>
                                            <td v-else>
                                                <i
                                                    class="fa-solid fa-times pe-2 text-danger"
                                                ></i
                                                >{{
                                                    $t(
                                                        "wallet_log.button.decline"
                                                    )
                                                }}
                                            </td>

                    </tr>

                    <tr v-if="transactions.length == 0">
                        <td colspan="5" class="text-center">
                            No record found
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import { log } from '../utils/utils.js';
import VueRecaptcha from 'vue-recaptcha';

export default {
    props: ["url", "route","liveRoute" , "currency_symbol", "google_capcha_site_key"],
    mixins: [loginMixin],
     components: {
                VueRecaptcha
            },
    data() {
        return {
            current_balance: 0,
            loading: false,
            transactions: [],
            withdraw_amount: "",
            amount: "",
            payment_method: "",
            payment_details: {
                card_number: "",
                exp_month: "",
                exp_year: "",
                cvc: "",
            },
             jazzcash: {
                mobile_no: "",
                cnic_digit: "",
            },
            paytm: {
                mobile_no: "",
                email: ""
            },
            payment_methods: [],
             recaptchaVerified: false

        };
    },
    methods: {
        async fetchCurrentBalance() {
            const params = {
                token: 123,
                user_id: this.User.user_id,
            };
            const res = await axios.get("/api/check-balance", { params });
            if (res.data && res.data.Status) {
                this.current_balance = res.data.data.userBalance;
            }
        },
        async fetchTransactionHistory() {
            const params = {
                token: 123,
                user_id: this.User.user_id,
            };
            const res = await axios.get("/api/wallet-history", { params });
            if (res.data && res.data.Status) {
                this.transactions = res.data.data.transactions;
                this.loading = false;
            }
        },

        async AddAmountToWallet() {
             var self = this;
                var toast = this.$toasted;
            if (!this.amount) {
                     toast.error("Please Enter Amount");
                     return;
                }
            let expMonth =
                new Date(this.payment_details.exp_month).getUTCMonth() + 1;
                if (expMonth.toString().length == 1) {
                expMonth = '0' + expMonth
            }
            let body = {
                mentee_id: this.User.user_id,
                total: this.amount,
                payment_method_code: this.payment_method,
                cardInfo: {
                    number: this.payment_details.card_number,
                    exp_month: expMonth,
                    exp_year: new Date(
                        this.payment_details.exp_year
                    ).getFullYear(),
                    cvc: this.payment_details.cvc,
                },

                shipping_address: {
                    id: "",
                    first_name: "shahzad",
                    last_name: "Tariq",
                    email: "fharshad842@gmail.com",
                    city_id: 85335,
                    state_id: 3176,
                    country_id: 167,
                    zip_code: "38000",
                    address:
                        "Bismillah General Store Back Saira Mall Plaza Dogar Basti\nPeople Colony # 1 D Ground Faisalabad",
                    phone: "034677992777",
                },
                shipping_id: 1,
                plateForm: "web",
                paytm_mode: "",
                wallat_desposit: true,
            };
            const headers = {
                Accept: "application/json",
                "Content-Type": "application/json",
            };
               var self = this;
                var toast = this.$toasted;
             if (this.payment_method == 'paytm' ) {
                if (!this.paytm.mobile_no || !this.paytm.email) {
                     toast.error("Please Enter Paytm Mobile No.");
                     toast.error("Please Enter Paytm Email");
                     return;
                }
                this.paymentLoading = true;
                window.location.href = this.route + "/" + this.amount + "/" + this.paytm.mobile_no + "/" + this.paytm.email
            }
            if (this.payment_method == 'jazzcash') {
                this.paymentLoading = true;
                var self = this;
                var toast = this.$toasted;
                var params = {
                    token: 123,
                    mobile_no: this.jazzcash.mobile_no,
                    cnic: this.jazzcash.cnic_digit,
                    amount: this.amount,
                    mobile_account: 1,
                    is_wallet_topup: true,
                     mentee_id: this.User.user_id,
                };
                const res = await axios
                    .post("/api/makeJazzcashPayment", params)
                    .then((res) => {
                        if (res.data.Status) {
                            this.loading = false;
                            toast.success(res.data.msg);
                            this.fetchCurrentBalance();
                            this.fetchTransactionHistory();
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
            if (this.payment_method == 'easypaisa') {
                window.open(
                    "/easypaisa-wallet?amount=" +
                    this.amount +
                    "&bookAppointmentId=" +
                    this.appointmentNo,
                    "_blank"
                );
                this.loading = false;
                // window.location.href = "/mentee/appointment-log";
            }
            if (this.payment_method == 'flutterwave') {
                window.location = '/pay?walletTopUp=true&total=' + this.amount + '&mentee_id=' + this.User.user_id;
            }
            else if (this.payment_method == 'razorpay') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                                this.fetchCurrentBalance();
                            this.fetchTransactionHistory();
                            this.loading = false;
                        }
                        else if (!res.data.Status) {
                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }



                    });
            }
            else if (this.payment_method == 'stripe') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.fetchCurrentBalance();
                            this.fetchTransactionHistory();
                            this.loading = false;
                        }
                        else if (!res.data.Status && res.data.authorization_url) {
                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }



                    });
            }
            else if (this.payment_method == 'braintree') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }



                    });
            }
            else if (this.payment_method == 'paypal') {
                const res = await axios
                    .post("/api/execute-payment", body, {
                        headers: headers,
                    }).then((res) => {
                        if (res.data.status == 400) {
                            toast.error(res.data.data.message);

                        }
                        if (res.data.original && res.data.original.Status) {
                            toast.success(res.data.original.msg);
                            this.loading = false;
                            window.location = '/mentee/appointment-log';


                        } else if (!res.data.Status) {
                            localStorage.setItem('appointmentID', this.appointmentNo);
                            window.location = res.data.authorization_url;
                        }

                    })
                    .catch((error) => {

                        if (error.response) {
                            for (const property in error.response.data.errors) {
                                toast.error(error.response.data.errors[property]);
                            }
                        }



                    });
            }
        },
        async withDrawAmount() {
            var self = this;
            var toast = this.$toasted;
            var params = {
                token: 123,
                user_id: this.User.user_id,
                amount: this.withdraw_amount,
            };
            const res = await axios
                .post("/api/withdraw-request", params)
                .then((res) => {
                    if (res.data.Status) {
                        document.getElementById("withdraw_close").click();
                        toast.success(res.data.msg);
                    } else {
                        toast.error(res.data.msg);
                    }
                });
        },
        async fetchAppointmentDetails() {
            var params = {
                token: 123,
                appointment_id: this.appointmentid,
                user_id: this.User.user_id,
            };
            var toast = this.$toasted;
            const res = await axios
                .get("/api/appointmentDetails", { params })
                .then((res) => {
                    if (res.data.Status) {
                        this.loading = false;
                        this.formData.questions =
                            res.data.data.appointment.questions;
                        this.formData.book_file =
                            res.data.data.appointment.file;
                        this.formData.file_type =
                            res.data.data.appointment.file_type;
                        this.formData.payment =
                            res.data.data.appointment.payment;
                    }
                    if (!res.data.Status) {
                        this.loading = false;
                    }
                });
        },
        async fetchPaymentMethods() {
            const res = await axios.get("/api/payment_methods", {
                params: { token: 123, platform:'web' },
            });
            if (res.data) {
                this.payment_methods = res.data.data;
                // let current_method =  res.data.data.find(m => m.code == 'stripe' )
                // this.payment_methods.push(current_method)
            }
        },
        onSubmit: function () {
        this.$refs.invisibleRecaptcha.execute()
        },
        onVerify: function (response) {
        this.recaptchaVerified = true
        },
        onExpired: function () {
        this.recaptchaVerified = false

        },
        resetRecaptcha() {
        this.$refs.recaptcha.reset() // Direct call reset method
        },
    },
    created() {
        this.checkLoggedIn();
    },
    mounted() {
        if (this.is_loggedIn) {
        } else {
            window.location.href = this.url + "/login";
            this.$toasted.error("Please Login First");
        }
        this.fetchCurrentBalance();
        this.fetchTransactionHistory();
        this.fetchPaymentMethods();
    },
};
</script>

<style>
     .payment-card img{
    max-width: 60px;
    height: 40px;
    }
</style>
