<template>
    <section class="team-consultant">
        <consultant-search :url= url></consultant-search>
        <div class="container">
            <div class="row">
                <div class="col-md-12 p-0">
                    <h2 class="text-primary fw-bold text-center head">
                        {{ $t("we_will_section.heading") }}

                        <span class="text-secondary">
                            {{ $t("we_will_section.sub_heading") }}</span
                        >
                    </h2>
                    <p class="text-center sub-head pt-3 px-3">
                        {{ $t("we_will_section.paragraph") }}
                    </p>

                    <div>
                        <VueSlickCarousel
                            v-bind="settings"
                            v-if="categories.length > 0"
                        >
                            <!-- slide 1 -->
                            <div
                                class="p-3 pb-4"
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <div class="card bg-transparent border-0">
                                    <div class="img-wrap mb-3">
                                        <a
                                            :href="`${
                                                url +
                                                '/categories/' +
                                                category.slug
                                            }`"
                                            v-if="category.image_path"
                                        >
                                            <img
                                                :src="category.image_path"
                                                alt=""
                                                class="img-fluid"
                                            />
                                        </a>
                                        <a
                                            :href="`${
                                                url +
                                                '/categories/' +
                                                category.slug
                                            }`"
                                            v-else
                                        >
                                            <img
                                                src="/assets/images/profile_placeholder.png"
                                                alt=""
                                                class="img-fluid"
                                            />
                                        </a>
                                    </div>

                                    <!-- <div class="text-secondary">
                        <i class="fa-solid fa-star me-1" v-for="rating in mentor.ratingAvg" :key="rating.id"></i>

                   </div> -->

                                    <!-- <a :href="`${url + '/categories/' + category.slug}`"> <h4 class="text-primary fw-bold">{{category.name}} </h4></a> -->

                                    <div class="tooltip-wrapper">
                                        <a
                                            :href="`${
                                                url +
                                                '/categories/' +
                                                category.slug
                                            }`"
                                        >
                                            <h4 class="text-primary fw-bold">
                                                {{ category.name }}
                                            </h4></a
                                        >
                                        <div class="tooltip text-white">
                                            <p class="mb-0 px-3 py-1">
                                                {{ category.name }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- <h5 class="text-primary fw-bold">{{mentor.first_name}} {{mentor.last_name}}</h5> -->
                                    <p>
                                        ({{
                                            category.mentor_p_count
                                        }}
                                        Consultant)
                                    </p>
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
            categories: [],
            loading: true,
            settings: {
                dots: true,
                arrows: false,
                focusOnSelect: false,
                infinite: true,
                speed: 500,
                slidesToShow: 6,
                slidesToScroll: 2,
                autoplay: true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 2,
                        },
                    },

                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 2,
                            arrows: false,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 350,
                        settings: {
                            slidesToShow: 2,
                            arrows: false,
                            slidesToScroll: 1,
                        },
                    },
                ],
            },
        };
    },
    methods: {
        async fetchCategories() {
            const res = await axios.get("/api/mentorCategories", {
                params: { token: 123 },
            });
            if (res.data && res.data.Status == true) {
                this.categories = res.data.data.mentorCategories;
                this.loading = false;
            } else {
                this.loading = false;
            }
        },
    },

    created() {
        this.fetchCategories();
    },
};
</script>
