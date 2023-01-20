<template>
    <section class="become-consultant bg-white">
        <div class="container">
            <div class="row">
                <div class="col-xxl-5 col-xl-6 col-md-7 rtl-img">
                    <div
                        class="square-border-img d-flex flex-column justify-content-center h-100"
                    >
                        <div class="border">
                            <img
                                src="/assets/images/video-thumb.jpg"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-6 col-md-5">
                    <div
                        class="d-flex flex-column justify-content-center h-100 pe-lg-5 pe-0 pb-5 pc-lg-5"
                    >
                        <h3 class="text-primary fw-bold">
                            {{ $t("banner_become_consultant.heading") }}

                            <span class="text-secondary"
                                >{{
                                    $t("banner_become_consultant.sub_heading")
                                }}
                            </span>
                        </h3>
                        <p class="mt-3">
                            {{ $t("banner_become_consultant.paragraph_1") }}
                        </p>
                        <p class="">
                            {{ $t("banner_become_consultant.paragraph_2") }}
                        </p>
                        <a
                            href=""
                            type="button"
                            class="btn btn-secondary text-white align-self-baseline mt-3"
                        >
                            {{ $t("banner_become_consultant.button") }}

                            <i class="fa-solid fa-caret-right"></i
                        ></a>
                    </div>
                </div>
            </div>
            <div class="row flex-md-row flex-column-reverse">
                <div class="col-xxl-7 col-xl-6 col-md-5">
                    <div
                        class="d-flex flex-column justify-content-center h-100 px-lg-5"
                    >
                        <h3 class="text-primary fw-bold">
                            {{ $t("banner_payment_method.heading") }}

                            <span class="text-secondary fw-bold">
                                {{ $t("banner_payment_method.main") }}</span
                            >
                        </h3>

                        <p class="mt-3">
                            {{ $t("banner_payment_method.paragraph_1") }}
                        </p>
                        <div class="payment-card mt-2">
                            <ul
                                class="d-inline-flex ps-0 flex-xl-nowrap flex-wrap"
                                type="none"
                            >
                                <li
                                    v-for="pm in payment_methods"
                                    class="pe-2 mt-xl-0 mt-2"
                                >
                                    <div
                                        class="card border d-md-flex h-100 align-items-center justify-content-center"
                                    >
                                        <img
                                            :src="`${
                                                url + '/' + pm.image_path
                                            }`"
                                            alt=""
                                            class="img-fluid h-100"
                                        />
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 col-xl-6 col-md-7 rtl-img">
                    <div
                        class="square-border-img d-flex flex-column justify-content-center h-100"
                    >
                        <div class="border">
                            <img
                                src="/assets/images/payment-img.jpg"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: ["url"],
    data() {
        return {
            payment_methods: [],
        };
    },
    methods: {
        async fetchPaymentMethods() {
            const res = await axios.get("/api/payment_methods", {
                params: { token: 123, platform: "web" },
            });
            if (res.data) {
                this.payment_methods = res.data.data;

            }
        },
    },
    mounted() {
        this.fetchPaymentMethods();
    },
};
</script>
