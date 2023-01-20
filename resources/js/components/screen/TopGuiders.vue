<template>
    <section class="top-guiders bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-0">
                    <h2 class="text-primary fw-bold text-center head px-3">
                        {{ $t('here_are_section.heading') }}

                        <span class="text-secondary"> {{ $t('here_are_section.main') }} </span>
                        {{ $t('here_are_section.sub_heading') }}
                    </h2>
                    <p class="text-center sub-head pt-3 px-3">
                        {{ $t('here_are_section.paragraph') }}

                    </p>
                    <div class="col-md-12">
                        <VueSlickCarousel v-bind="settings" v-if="mentors.length > 0">
                            <!-- slide 1 -->
                            <div class="p-3 pb-0" v-for="mentor in mentors" :key="mentor.user_id">
                                <div class="guiders-card position-relative">
                                    <div class="verified position-absolute">
                                        <img src="/assets/images/verified-icon.png" alt="" />
                                    </div>
                                    <div class="guiders-img">
                                        <img v-if="mentor.image_path" :src="mentor.image_path" alt="Team Image"
                                            class="img-fluid" />
                                        <img v-else src="/assets/images/profile_placeholder.png" alt="Team Image"
                                            class="img-fluid" />
                                    </div>
                                    <div class="guiders-content">
                                        <div class="title d-flex flex-column">
                                            <a class="btn btn-transparent border-white text-white mb-3"
                                                :href="url + '/consultant-profile/' + mentor.user_id">View details</a>
                                            <button class="btn btn-secondary text-white"
                                                v-on:click="checkLogin(mentor.user_id)" type="button">Book an
                                                appointment</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="guider-info d-flex justify-content-center align-items-center">
                                    <div class="card border-0 shadow py-3 px-4 text-center"> <a
                                            :href="url + '/consultant-profile/' + mentor.user_id">
                                            <h5 class="text-primary fw-bold mb-1">
                                                {{ mentor.first_name }} {{ mentor.last_name }}
                                            </h5>
                                        </a>
                                        <h6 class="mb-0 text-muted" v-if="mentor.category && mentor.category.name "  >{{ mentor.category.name }}</h6>
                                        <h6 class="mb-0 text-muted" v-else>-</h6>
                                        <div class="">
                                            <!-- also show star in grey color rather then colored star out of 5 stars -->
                                            <i class="fa-solid fa-star me-1 text-secondary"
                                                v-for="rating in mentor.ratingAvg" :key="rating.id"></i>
                                        </div>
                                        <div class="no-rating" v-if="mentor.ratingAvg == 0">
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                            <i class="fa-solid fa-star text-light-muted"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </VueSlickCarousel>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import VueSlickCarousel from "vue-slick-carousel";
import "vue-slick-carousel/dist/vue-slick-carousel.css";
export default {
    name: "MyComponent",
    components: { VueSlickCarousel },
    props: ["url"],
    data() {
        return {
            mentors: [],
            settings: {
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 1,
                            arrows: false,
                            slidesToScroll: 1,
                        },
                    },
                ],
            },
        };
    },
    methods: {
        checkLogin(mentor_id) {
            //   this.appointment_type = type
            var User = JSON.parse(localStorage.getItem("User"));
            if (!User) {
                window.location.href = this.url + "/login";
                this.$toasted.error("Please Login First");
            }
            else {
                if (User.role == "Mentee") {
                    window.location.href = this.url + '/appointment-schedule/' + mentor_id;
                }
                else if (User.role == "Mentor") {
                    this.$toasted.error("Please Login as a User");
                }
            }


        },

        async getTopConsultants() {
            const params = {
                token: 123,
            };
            const res = await axios.get("/api/get-featured-mentors", { params });
            if (res.data && res.data.Status) {
                this.mentors = res.data.data.mentors;

            }
        },
    },
    created() {
        this.getTopConsultants();

    }
};
</script>
