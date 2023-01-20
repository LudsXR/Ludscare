<template>
  <section class="blog-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 p-md-0">
          <h2 class="text-primary fw-bold text-center head px-3">
             {{$t('banner_see_our.heading')}}

            <span class="text-secondary"> {{$t('banner_see_our.sub_heading')}}</span> &
            <span class="text-secondary"> {{$t('banner_see_our.sub_heading1')}}</span>
          </h2>
          <p class="text-center sub-head mt-3 mb-4 px-3">
            {{$t('banner_see_our.paragraph')}}

          </p>


            <VueSlickCarousel v-bind="settings" v-if="allPosts.length>0">
              <!-- slide 1 -->
              <div class="p-3 pt-0" v-for="post in allPosts" :key="post.id">
                <div class="card bg-transparent border-0">
                    <div class="img-wrap  mb-3">
                      <a  :href="`${url + '/blog-detail/' + post.slug}`">
                 <img
                    :src="url+post.image_path"
                    alt=""
                    class="img-fluid"
                  />
                  </a>
                    </div>

                  <p class="text-dark mt-1">
                    <i
                      class="fa-solid fa-calendar-days text-secondary pe-2"
                    ></i>
                    {{new Date(post.created_at).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})}}
                     {{$t('banner_see_our.by')}} {{post.user && post.user.first_name ? post.user.first_name : ""}} {{post.user && post.user.last_name ? post.user.last_name : ""}}
                  </p>
                  <a  :href="`${url + '/blog-detail/' + post.slug}`">
                  <h4 class="text-primary fw-bold">{{post.title}}</h4>
                  </a>
                  <!-- <p v-html="post.description.slice(0, 140)" style="max-height:100px !important; height:80px !important;">
                  </p>
                  <a :href="`${url + '/blog-detail/' + post.slug}`" class="text-secondary">Read More</a> -->
                </div>
              </div>
              <!-- slide 2 -->

            </VueSlickCarousel>

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
        allPosts:[],
      settings: {

        dots: true,
        arrows: false,
        focusOnSelect: true,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            },
          },
          {
            breakpoint: 991,
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
  methods :{
       async getAllBlogs()
       {
            const params = {
                token: 123,
            };
            const res = await axios.get("/api/featured-blogs", { params });
            if (res.data && res.data.Status) {
                this.allPosts = res.data.data.featuredBlogs;

            }
       },
  },
  created()
   {
       this.getAllBlogs();

   }
};
</script>
