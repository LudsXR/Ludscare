<template>
    <section class="customer-review bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="review-label p-3">
                        <div class="row">
                            <div class="col-lg-1 col-md-2">
                                <div
                                    class="satisfied d-flex justify-content-center mb-md-0 mb-2"
                                >
                                    <img
                                        src="/assets/images/satisfied.png"
                                        alt=""
                                        class="img-fluid"
                                    />
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="col-md-12">
                                    <h6 class="text-primary">
                                       {{parseFloat(satisfy_percentage).toFixed(2)}}% customers feel satisfied after
                                        booking appointment from Nictus
                                        consultancy
                                    </h6>
                                    <p class="mb-0">
                                        It takes only 30 sec to book an
                                        appointment
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="reviews pt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <div
                                class="d-flex h-100 justify-content-center flex-column"
                            >
                                <h1 class="text-primary fw-bold">{{
                                    mentorDetail.first_name +
                                    " " +
                                    mentorDetail.last_name
                                }}</h1>
                                <h1 class="text-secondary fw-bold">Reviews</h1>
                                <p>
                                    Lorem ipsum, dolor sit amet consectetur
                                    adipisicing elit. Minus quam sequi hic iusto
                                    sint praesentium obcaecati eius est. Atque,
                                    natus dolorem repellendus hic eaque quo
                                    placeat enim similique totam aliquid?
                                </p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <VueSlickCarousel v-bind="settings" v-if="ratings.length>0">
                                <div class="p-3 ps-0" v-for="rating in ratings" :key="rating.id">
                                    <div class="card border-0 p-md-4 p-3">
                                        <div class="d-flex">
                                            <div class="">
                                                <div class="customer-profile d-flex justify-content-center  align-items-center">
                                                    <img v-if="rating.mentee.image_path"
                                                     :src="rating.mentee.image_path" class="img-fluid" />
                                                    <img
                                                        v-else
                                                        src="/assets/images/profile_placeholder.png"
                                                        alt=""
                                                        class=""
                                                    />
                                                </div>
                                            </div>
                                            <div class="ps-3">
                                                <div
                                                    class="d-flex justify-content-center flex-column"
                                                >
                                                    <div class="col-md-12">
                                                        <h5
                                                            class="text-primary fw-bold mb-1"
                                                        >
                                                            {{rating.mentee.first_name}} {{rating.mentee.last_name}}
                                                        </h5>
                                                        <span>{{new Date(rating.created_at).toLocaleString()}}</span>
                                                        <div class="text-secondary">
                                                            <i class="fa-solid fa-star" v-for="(rate,index) in rating.rating" :key="index" ></i>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <p class="pt-4">
                                                {{rating.comments}}
                                            </p>
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
    props: ["url","mentorDetail","ratings"],
    data() {
        return {
            satisfy_percentage:0,
            settings: {
                dots: true,
                arrows: false,
                focusOnSelect: true,
                infinite: true,
                speed: 500,
                slidesToShow: 2,
                slidesToScroll: 1,
                autoplay: false,
                centerMode: true,
                variablewidth:true,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 1,
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
    created(){
        let total_rating=this.ratings.length;
        let satisfy_rating=0;
        for(const rating in this.ratings){
            if(this.ratings[rating].rating>=4){
                satisfy_rating++;
            }
        }

        this.satisfy_percentage=satisfy_rating*100/total_rating;


    }
};
</script>
