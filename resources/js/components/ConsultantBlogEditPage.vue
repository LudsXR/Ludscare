<template>
  <div>
    <section class="appointment-log">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-secondary fw-bold text-center mb-5">
              {{ $t("consultant_blog_edit.main_title") }}
            </h1>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="bg-white mt-4 px-md-4 border-r-20">
                <div class="pt-2 ">
             <div class="modal-body pt-4">
                        <div class="form-group">
                            <label for="title" class="text-primary h5 fw-bold mb-3">{{ $t("consultant_blog_edit.fields.title") }}</label>
                            <input type="text" v-model="blog.title" placeholder="Enter Blog Title" class="form-control border">
                        </div>
                        <div class="form-group mt-3">
                            <label for="category"  class="text-primary h5 fw-bold  mb-3">{{ $t("consultant_blog_edit.fields.select_category") }}</label><br>
                            <select v-model="blog.category_id" class="form-select border h-auto">
                                <option value="" >{{ $t("consultant_blog_edit.fields.select_category") }}</option>
                                <option :value="category.id" v-for="(category, index) in categories" :key="index">{{category.name}}</option>
                            </select>
                        </div>
                          <div class="form-group mt-3">
                            <label for="description"  class="text-primary h5 fw-bold  mb-3">{{ $t("consultant_blog_edit.fields.description") }}</label>
                            <textarea  class="wysiwyg" rows="4" cols="30" v-model="blog.description"></textarea>
                        </div>
                         <div class="form-group mt-3 d-flex flex-column">
                            <label for="image"  class="text-primary h5 fw-bold  mb-3">{{ $t("consultant_blog_edit.fields.image") }}</label>
                            <input class="form-controll" id="image_blog" ref="image_blog" @change="processBlogFile($event)" type="file" >
                            <img :src="blog.image_path" width="" class="mt-4 img-fluid" alt="" style="max-width:300px;" >
                        </div>
                        <div class="pb-3 pt-2 d-flex justify-content-end">
                            <button type="button" @click="updateBlog" class="btn btn-primary" >{{ $t("consultant_blog_edit.update") }}</button>
                        </div>
                    </div>
                </div>
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
  props: ["url","id"],
  mixins: [loginMixin],
  data() {
    return {
      categories: [],
      blog:{
        title: "",
        category_id: "",
        description: "",
        image: {},
        image_path: ""
      },
      editor: ""
    };
  },
  methods: {
    async fetchBlogData() {
      const params = {
        token: 123,
        id: this.id
      };
      const res = await axios.get("/api/blogDetail", { params });
      if (res.data && res.data.Status) {
        this.blog.title = res.data.data.blog.title;
        this.blog.category_id = res.data.data.blog.category_id;
        this.blog.description = res.data.data.blog.description;
        this.editor.setData(res.data.data.blog.description);
        this.blog.image_path = res.data.data.blog.image_path;
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

        processBlogFile(event) {
            this.blog.image = event.target.files[0];
        },
      async updateBlog(e) {
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
            formData.append("blog_id", this.id);
            formData.append("description", document.getElementsByClassName("ck-editor__editable")[0].innerHTML);
            const res = await axios
                .post("/api/update_consultant_blog", formData, {
                    headers: headers,
                })
                .then((res) => {
                    if (res.data.Status) {
                        toast.success(res.data.msg);
                        window.location.href = "/consultant/blogs";
                    }
                    if (!res.data.Status) {
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
    this.fetchBlogData();
    this.fetchBlogCategories();
  },
  mounted()
  {
     ClassicEditor
        .create(document.querySelector('.wysiwyg'))
        .then(editor => {
        this.editor = editor;
      })
        .catch(error => {
        });
  }
};
</script>
