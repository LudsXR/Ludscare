<template>
    <section class="happy-clients">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-primary fw-bold text-center head px-3">
                         {{$t('banner_meet_the_people.heading')}}

                        <span class="text-secondary"> {{$t('banner_meet_the_people.sub_text')}}</span>
                         {{$t('banner_meet_the_people.sub_text2')}}
                        <span class="text-secondary"> {{$t('banner_meet_the_people.sub_text1')}}</span>
                    </h2>
                    <p class="text-center mt-4 sub-head ">
                          {{$t('banner_meet_the_people.paragraph')}}

                    </p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">

                <div class="col-lg-8">
                    <div class="clients-slick ">
                        <VueSlickCarousel v-bind="settings" v-if="clients.length>0">
                            <!-- slider 1 -->
                            <div
                                class="happy-clients-card p-md-0 p-3"
                                style="width: fit-content"
                                v-for="client in clients" :key="client.id"
                            >
                                <div class="card border-0 bg-primary px-5 py-3">
                                    <p class="p-0 text-white mb-0 text-clients">
                                       <span  data-bs-toggle="tooltip" data-bs-placement="top" :title="client.description">

                                            {{client.description}}
                                        </span>
                                    </p>
                                    <h6 class="fw-bold text-white pb-3">
                                        {{client.name}}
                                    </h6>
                                </div>
                                <div
                                    class="position-relative d-md-block d-none"
                                >

                                    <img v-if="client.image_path" :src="`${url  + client.image_path}`" alt="Team Image"
                                            class="img-fluid" />
                                        <img v-else src="/assets/images/profile_placeholder.png" alt="Team Image"
                                            class="img-fluid" />
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
            clients:[],
            settings: {
                dots: true,
                arrows: false,
                focusOnSelect: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: false,
            },
        };
    },
    methods:{
        async getHappyCustomers() {
            const params = {
                token: 123,
            };
            const res = await axios.get("/api/testinomials", { params });
            if (res.data) {
                this.clients = res.data.data;

            }
        },
    },
    created() {
        this.getHappyCustomers();

    },
};
</script>
