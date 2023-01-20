<template>
  <div>
    <section class="appointment-log">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-secondary fw-bold text-center mb-5">
              {{ $t("consultant_blogs.main_title") }}
            </h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white my-4">
                <div class="py-3 d-flex justify-content-end px-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBlogModel">{{ $t("consultant_blogs.create") }}</button>
                    <!-- Modal -->
                <div class="modal fade" id="createBlogModel" tabindex="-1" aria-labelledby="createBlogModelLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content  border-r-20">

                    <div class="modal-body px-md-5">
                      <button type="button" class="btn-close position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
                      <h3 class="modal-title text-primary fw-bold mb-4" id="createBlogModelLabel">{{ $t("consultant_blogs.create_blog") }}</h3>

                        <div class="form-group">
                            <label for="title" class="text-primary h6 fw-bold mb-3">{{ $t("consultant_blogs.fields.title") }}</label>
                            <input type="text" v-model="blog.title" placeholder="Enter Blog Title" class="form-control border">
                        </div>
                        <div class="form-group mt-3">
                            <label for="category" class="text-primary h6 fw-bold mb-3">{{ $t("consultant_blogs.fields.select_category") }}</label><br>
                            <select v-model="blog.category_id" class="form-select border h-auto">
                                <option value="" >{{ $t("consultant_blogs.fields.select_category") }}</option>
                                <option :value="category.id" v-for="(category, index) in categories" :key="index">{{category.name}}</option>
                            </select>
                        </div>
                          <div class="form-group mt-3">
                            <label for="description" class="text-primary h6 fw-bold mb-3">{{ $t("consultant_blogs.fields.description") }}</label>
                            <textarea class="wysiwyg" rows="4" cols="30" v-model="blog.description"></textarea>
                        </div>
                         <div class="form-group mt-3">
                            <label for="image" class="text-primary h6 fw-bold mb-3">{{ $t("consultant_blogs.fields.image") }}</label><br>
                            <input class="form-controll" id="image_blog" ref="image_blog" @change="processBlogFile($event)" type="file" >
                        </div>
                    </div>
                    <div class="modal-footer pb-4 pe-md-5">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">{{ $t("consultant_blogs.close") }}</button>
                        <button type="button" @click="createBlog" class="btn btn-primary">{{ $t("consultant_blogs.create") }}</button>
                    </div>
                    </div>
                </div>
                </div>
                </div>
              </div>
              <div class="table-responsive">
                <table
                  class="table table-striped table-borderless align-middle mb-0 bg-white"
                >
                  <thead class="align-middle">
                    <!-- head -->
                    <tr class="bg-primary text-white fw-bold  mt-3">
                      <td class="p-3">{{ $t("consultant_blogs.column.sr_no") }}</td>
                      <td class="p-3">{{ $t("consultant_blogs.column.title") }}</td>
                      <td class="p-3">{{ $t("consultant_blogs.column.category") }}</td>
                      <td class="p-3">{{ $t("consultant_blogs.column.approved") }}</td>
                      <td class="p-3">{{ $t("consultant_blogs.column.image") }}</td>
                      <td class="p-3">{{ $t("consultant_blogs.column.action") }}</td>
                    </tr>
                    <!-- head end -->
                  </thead>
                  <tbody class="text-dark">
                    <tr v-if="loading">
                      <td align="center" colspan="9">loading......</td>
                    </tr>
                    <tr v-else v-for="(blog, index) in filterBlogs" :key="index">
                      <td class="mb-0">
                        <div class="wrap-ques ps-2">
                          {{ index + 1 }}
                        </div>
                      </td>
                      <td class="mb-0">{{ blog.title }}</td>
                      <td class="mb-0">{{ blog.category[0].name }}</td>
                      <td class="mb-0">{{ blog.is_approved ? $t("consultant_blogs.yes") : $t("consultant_blogs.no") }}</td>
                      <td class="mb-0" v-if="blog.image_path">
                        <img :src="blog.image_path" height="60" alt="" />
                      </td>
                      <td v-else>N/A</td>
                      <td class="mb-0">
                        <a
                          :href="'/consultant/blog/'+blog.id"
                        >
                          <i class="fas fa-edit text-primary"></i>
                        </a>
                        <a
                          href="javascript:void(0)"
                          @click="deleteBlog(blog.id, index)"
                        >
                          <i class="fas fa-trash text-danger ps-3"></i>
                        </a>

                      </td>
                    </tr>
                    <tr v-if="filterBlogs.length == 0 && !loading">
                      <td colspan="9" class="text-center">No record found</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            <div
              class="
                btn-load-more
                d-flex
                justify-content-center
                align-items-center
              "
            >
              <v-page
                :total-row="blogs.length"
                align="left"
                v-model="current"
                @page-change="blogsChange"
                :page-size-menu="[10, 20, 30]"
                v-if="!loading && blogs.length > 0"
                :key="blogs.length"
              ></v-page>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import loginMixin from "../mixins/loginMixin.js";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor';
export default {
  props: ["url"],
  mixins: [loginMixin],
  data() {
    return {
      loading: true,
      blogs: [],
      filterBlogs:[],
      categories: [],
        current: 0,
      pagination: {
        pageNumber: 1,
        pageSize: 10,
      },
      blog:{
        title: "",
        category_id: "",
        description: "",
        image: {}
      }
    };
  },
  methods: {
    async fetchAllBlogs() {
      const params = {
        token: 123,
        user_id: this.User.user_id,
      };
      const res = await axios.get("/api/consultant_blogs", { params });
      if (res.data && res.data.Status) {
        this.blogs = res.data.data.blogs;
        if (this.blogs.length == 0) {
          this.blogsChange(1);
        }
        this.loading = false;
      }
      if (!res.data.Status) {
        this.$toasted.error(res.data.msg);
      }
    },
       async fetchBlogCategories() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/blogCategories", { params });
      if (res.data && res.data.Status) {
        this.categories = res.data.data.categories;
        this.loading = false;
      }
      if (!res.data.Status) {
        this.$toasted.error(res.data.msg);
      }
    },
    async deleteBlog(id, index) {
      var self = this;
      var toast = this.$toasted;
      var params = {
        token: 123,
        blog_id: id,
      };
      const res = await axios
        .get("/api/delete_consultant_blog", { params })
        .then((res) => {
          if (res.data.Status) {
            toast.success(res.data.msg);
            // this.blogs.splice(this.blogs.indexOf(index), 1);
            this.fetchAllBlogs();
          }
        });
    },
    blogsChange(pInfo) {
      this.filterBlogs.splice(0, this.filterBlogs.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.blogs.length) end = this.blogs.length;
      for (let i = start; i < end; i++) {
        this.filterBlogs.push(this.blogs[i]);
      }
    },
        processBlogFile(event) {
            this.blog.image = event.target.files[0];
        },
      async createBlog(e) {
        this.blog.description = document.getElementsByClassName("ck-editor__editable")[0].innerHTML;
            var self = this;
            var toast = this.$toasted;
            e.preventDefault();
            const headers = {
                "Content-Type": "multipart/form-data",
            };

            let formData = new FormData();
            formData.append("image", this.blog.image);
            formData.append("token", 123);
            formData.append("user_id", this.User.user_id);
            formData.append("title", this.blog.title);
            formData.append("category_id", this.blog.category_id);
            formData.append("description", document.getElementsByClassName("ck-editor__editable")[0].innerHTML);
            const res = await axios
                .post("/api/create_consultant_blog", formData, {
                    headers: headers,
                })
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        self.fetchAllBlogs();
                        self.blog.title = "";
                        self.blog.category_id = "";
                        self.blog.description = "";
                        self.blog.image = "";
                        $("#image_blog").val("");
                        $(".modal").modal("hide");
                        $("body").removeClass("modal-open");
                        // $("body").addClass("overflow-c");
                        // $("body").addClass("pe-0");
                        $(".modal-backdrop").remove();

                    }
                    if (!res.data.Status) {
                        //  for (const property in res.data.errors) {
                        //     toast.error(res.data.errors[property][0]);
                        // }
                        toast.error("Please Fill all Fields...");
                    }
                });
        },
  },
  created() {
    this.checkLoggedIn();
    if (this.is_loggedIn && this.User.role == "Mentor") {
    } else {
      window.location.href = this.url + "/login";
      this.$toasted.error("Please Login First");
    }
    this.fetchAllBlogs();
    this.fetchBlogCategories();
  },
  mounted()
  {
     ClassicEditor
        .create(document.querySelector('.wysiwyg'))
        .catch(error => {
        });
  }
};
</script>
