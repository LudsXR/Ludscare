<template>
    <div>
        <header class="about-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="d-flex justify-content-center align-items-center flex-column"
                        >
                            <h2 class="text-white text-center head fw-bold">
                                  {{$t('about_banner_section.heading')}}
                            </h2>
                            <p class="text-white text-center mt-3">
                                 {{$t('about_banner_section.paragraph')}}

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="about-section">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-md-5 d-flex justify-content-center flex-column">
                        <h2 class="head text-primary fw-bold">
                             {{$t('about_our_agency_section.heading')}}
                            <span class="text-secondary"><br> {{$t('about_our_agency_section.sub_heading')}}</span>

                        </h2>

                        <p class="sub-head mt-3">
                             {{$t('about_our_agency_section.paragraph_1')}}

                        </p>

                        <p class="sub-head mt-2">
                             {{$t('about_our_agency_section.paragraph_2')}}

                        </p>
                    </div>

                    <div class="col-xl-6 col-md-7 rtl-img">
                        <div
                            class="square-border-img d-flex flex-column justify-content-center h-100 mt-md-0 mt-4"
                        >
                            <div class="border">
                                <img
                                    src="/assets/images/agency.png"
                                    alt=""
                                    class="img-fluid"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-secondary text-white why-choose-us">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="head text-center fw-bold">
                            {{$t('about_why_choose_section.heading')}}

                        </h2>
                        <p class="text-center mt-3 mb-5">
                           {{$t('about_why_choose_section.paragraph')}}

                        </p>
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                        <div
                            class="card border-0 bg-transparent d-flex justify-content-center align-items-center mt-5"
                        >
                            <img
                                src="/assets/images/sales.png"
                                alt=""
                                class="img-fluid"
                            />
                            <h3 class="fw-bold mt-3 text-center">
                                {{$t('about_why_choose_section.heading_1')}}

                            </h3>
                            <span class="text-center">
                                {{$t('about_why_choose_section.paragraph_1')}}

                            </span>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                        <div
                            class="card border-0 bg-transparent d-flex justify-content-center align-items-center mt-5"
                        >
                            <img
                                src="/assets/images/intelligence.png"
                                alt=""
                                class="img-fluid"
                            />
                            <h3 class="fw-bold mt-3 text-center">
                                 {{$t('about_why_choose_section.heading_2')}}

                            </h3>
                            <span class="text-center">
                                {{$t('about_why_choose_section.paragraph_2')}}

                            </span>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                        <div
                            class="card border-0 bg-transparent d-flex justify-content-center align-items-center mt-5"
                        >
                            <img
                                src="/assets/images/hassle.png"
                                alt=""
                                class="img-fluid"
                            />
                            <h3 class="fw-bold mt-3 text-center">
                                {{$t('about_why_choose_section.heading_3')}}

                            </h3>
                            <span class="text-center">                                                             {{$t('about_why_choose_section.paragraph_3')}}
                             {{$t('about_why_choose_section.paragraph_3')}}

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white our-mission">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div
                            class="d-flex justify-content-center align-items-center h-100"
                        >
                            <img
                                src="/assets/images/ourmission.png"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h2 class="head text-primary fw-bold mt-lg-0 mt-5">
                            {{$t('about_our_mission_section.heading')}}

                           <span class="text-secondary"><br> {{$t('about_our_mission_section.sub_heading')}}</span>


                        </h2>

                        <p class="sub-head mt-3">
                            {{$t('about_our_mission_section.paragraph_1')}}
L
                        </p>

                        <p class="sub-head mt-4">
                            {{$t('about_our_mission_section.paragraph_2')}}

                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
export default {
    props: ["url"],
};
</script>
