<template>
    <div>
        <div class="hero py-0 bg-white "
                    style="text-shadow: 1px 1px 2px #333;background-size:cover;background-repeat:no-repeat;background:url('/assets/images/header-background.png')">
            <div>
                <b-carousel
                    id="carousel-1"
                    :interval="6000"
                    indicators

                >
                    <b-carousel-slide

                    >
                        <!-- <div style="background-image:url('/assets/images/header-background.png');" class="carousel-bg"> -->
                        <div class="carousel-bg">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div
                                        class="d-flex justify-content-center flex-column align-items-start h-100"
                                    >
                                        <h1 class="fw-bold text-primary head mt-lg-0 mt-5">
                                            <span
                                                class="h1 fw-normal text-primary"
                                            >
                                                {{$t("banner_section.main")}}
                                            </span>
                                            <br />

                                            {{$t("banner_section.heading1")}}

                                        </h1>
                                        <p class="mt-2 fw-400">
                                            {{$t("banner_section.paragraph")}}

                                        </p>
                                        <a
                                            class="btn btn-secondary mt-2 text-white px-3 align-self-start"
                                            href="/categories"
                                        >
                                            {{$t("banner_section.button")}}

                                            <i
                                                class="fa-solid fa-arrow-right ps-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-end mt-md-3 mt-5">
                                        <img
                                            src="/assets/images/main-img.png"
                                            alt=""
                                            class="img-fluid"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </b-carousel-slide>
                    <b-carousel-slide

                    >
                        <!-- <div style="background-image:url('/assets/images/header-background.png');" class="carousel-bg"> -->
                        <div class="carousel-bg">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div
                                        class="d-flex justify-content-center flex-column align-items-start h-100"
                                    >
                                        <h1 class="fw-bold text-primary head mt-lg-0 mt-5">
                                            <span
                                                class="h1 fw-normal text-primary"
                                            >
                                                {{$t("banner_section.main")}}
                                            </span>



                                            <br>   {{$t("banner_section.heading2")}}
                                        </h1>
                                        <p class="mt-2 fw-400">
                                            {{$t("banner_section.paragraph")}}

                                        </p>
                                        <a
                                            class="btn btn-3 btn-secondary mt-2 text-white px-3 align-self-start"
                                            href="/categories"
                                        >
                                            {{$t("banner_section.button")}}

                                            <i
                                                class="fa-solid fa-arrow-right ps-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-end mt-md-3 mt-5">
                                        <img
                                            src="/assets/images/doctor-img.png"
                                            alt=""
                                            class="img-fluid"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </b-carousel-slide>

                    <b-carousel-slide

                    >
                        <!-- <div style="background-image:url('/assets/images/header-background.png');" class="carousel-bg"> -->
                        <div class="carousel-bg">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div
                                        class="d-flex justify-content-center flex-column align-items-start h-100"
                                    >
                                        <h1 class="fw-bold text-primary head mt-lg-0 mt-5">
                                            <span
                                                class="h1 fw-normal text-primary"
                                            >
                                                {{$t("banner_section.main")}}
                                            </span>


                                            <br/> {{$t("banner_section.heading3")}}
                                        </h1>
                                        <p class="mt-2 fw-400">
                                            {{$t("banner_section.paragraph")}}

                                        </p>
                                        <a
                                            class="btn btn-secondary mt-2 text-white px-3 align-self-start"
                                            href="/categories"
                                        >
                                            {{$t("banner_section.button")}}

                                            <i
                                                class="fa-solid fa-arrow-right ps-2"
                                            ></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="d-flex justify-content-end mt-md-3 mt-5">
                                        <img
                                            src="/assets/images/handyman.png"
                                            alt=""
                                            class="img-fluid"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </b-carousel-slide>
                </b-carousel>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            slide: 0,
            sliding: true,
            indicators: true,
        };
    },
    methods: {
        onSlideStart(slide) {
            this.sliding = true;
        },
        onSlideEnd(slide) {
            this.sliding = false;
        },


      },
}
