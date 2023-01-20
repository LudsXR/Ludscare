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

        <section class="blog-detail-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 p-md-0" v-if="loading">
                         <img src="/assets/images/loader.gif" height="100px" alt="">
                    </div>
                    <div class="col-md-12 p-md-0" v-else>
                        <h2 class="text-primary fw-bold text-center head mb-5">
                            {{post.title}}
                        </h2>

                        <div class="card bg-transparent border-0 mb-2 px-5">
                            <div class="mb-3">
                                <div class="img-wrap-blog-detail">
                                    <img
                                        :src="url+post.image_path"
                                        alt=""
                                        class="img-fluid"
                                    />
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                            <div>
                            <p class="text-dark mt-1">
                                <span>
                                    <i
                                    class="fa-solid fa-calendar-days text-secondary pe-3"
                                ></i>
                               {{new Date(post.created_at).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})}}
                                </span>
                            </p>
                            </div>
                            <div>
                              <span class="d-flex justify-content-end">
                                 {{$t('banner_see_our.by')}} {{post.user && post.user.first_name ? post.user.first_name : ""}} {{post.user && post.user.last_name ? post.user.last_name : ""}}
                              </span>

                            </div>
                            </div>

                            <p v-html="post.description">
                                </p>

                        </div>
                        <h4 class="divider line one-line text-primary fw-bold">See Also</h4>
                    </div>
                </div>
                <div class="row"  v-if="featuredBlogs.length>0">
                    <div class="col-lg-4 col-md-6" v-for="blog in featuredBlogs" :key="blog.id">
                        <div class="card bg-transparent border-0 mt-4">
                            <div class="mb-3 img-wrap">
                                <a :href="`${url + '/blog-detail/' + blog.slug}`" >
                                <img
                                     :src="url+blog.image_path"
                                    alt=""
                                    class="img-fluid"
                                />
                                </a>
                            </div>

                            <p class="text-dark mt-1">
                                <i
                                    class="fa-solid fa-calendar-days text-secondary pe-3"
                                ></i>
                                {{new Date(post.created_at).toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})}}
                            </p>
                            <a :href="`${url + '/blog-detail/' + blog.slug}`" >
                            <h3 class="text-primary fw-bold">
                                {{blog.title}}
                            </h3>
                            </a>
                            <p>
                              {{blog.description.slice(0, 140)}} ...
                            </p>
                            <a :href="`${url + '/blog-detail/' + blog.slug}`" class="text-secondary ">Read More...</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    props: ["url","slug"],
    data(){
      return{
          post: {},
          loading: true,
          featuredBlogs:[]
      }
   },
   methods :{
       async getBlog()
       {
            const params = {
                token: 123,
                slug:this.slug,
            };
            const res = await axios.get("/api/blog-with-slug", { params });
            if (res.data && res.data.Status) {
                this.post = res.data.data.blog;
                this.loading = false
            }
       },
        async getAllFeaturedBlogs()
       {
            const params = {
                token: 123,
            };
            const res = await axios.get("/api/featured-blogs", { params });
            if (res.data && res.data.Status) {
                this.featuredBlogs = res.data.data.featuredBlogs;
                this.loading = false
            }
       }
   },
   created()
   {
       this.getBlog();
       this.getAllFeaturedBlogs();
   }
};
</script>
