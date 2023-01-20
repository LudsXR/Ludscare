<template>
    <div>
        <header class="blog-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="d-flex justify-content-center align-items-center flex-column"
                        >
                            <h2 class="text-white text-center head fw-bold">
                               {{$t('blog_banner_section.heading')}}
                            </h2>
                            <p class="text-white text-center mt-3">
                               {{$t('blog_banner_section.paragraph')}}

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="blog-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 p-md-0">
                        <h2 class="text-primary fw-bold text-center head">
                              {{$t('banner_see_our.heading')}}
            <span class="text-secondary"> {{$t('banner_see_our.sub_heading')}}</span> &
            <span class="text-secondary"> {{$t('banner_see_our.sub_heading1')}}</span>

                        </h2>
                        <p class="text-center sub-head mt-3 mb-100">
                               {{$t('banner_see_our.paragraph')}}

                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6" v-for="post in allPosts" :key="post.id">
                        <div class="card bg-transparent border-0 mb-5">
                            <div class="mb-3">
                                <div class="img-wrap">
                                    <a v-if="post.image_path" :href="`${url + '/blog-detail/' + post.slug}`">
                                <img
                                    :src="url+post.image_path"
                                    alt=""
                                    class="img-fluid"
                                />
                                </a>
                                <a v-else :href="`${url + '/blog-detail/' + post.slug}`">
                                <img

                                    src="/assets/images/instructor-2.jpg"
                                    alt=""
                                    class="img-fluid w-100"
                                />
                                </a>
                                </div>
                            </div>
                            <p class="text-dark mt-1">
                                <i
                                    class="fa-solid fa-calendar-days text-secondary pe-3"
                                ></i>
                                {{new Date(post.created_at).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})}}
                                {{$t('banner_see_our.by')}} {{post.user && post.user.first_name ? post.user.first_name : ""}} {{post.user && post.user.last_name ? post.user.last_name : ""}}
                            </p>
                            <a  :href="`${url + '/blog-detail/' + post.slug}`">
                            <h3 class="text-primary fw-bold">
                                {{post.title}}
                            </h3>
                            </a>
                            <p v-html="post.description.slice(0, 140)" style="max-height:100px; height:80px;">
                            </p>
                            <a :href="`${url + '/blog-detail/' + post.slug}`" class="text-secondary">Read More...</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    props: ["url"],
    data(){
        return{
            allPosts: [],
            loading: true,
        }
    },
    methods :{
       async getAllBlogs()
       {
            const params = {
                token: 123,
            };
            const res = await axios.get("/api/blog/list", { params });
            if (res.data && res.data.Status) {
                this.allPosts = res.data.data.allBlogs;
                this.loading = false
            }
       },
    },
created()
   {
       this.getAllBlogs();
   }
};
</script>
