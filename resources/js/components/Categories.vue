<template>
    <div>
        <header class="header-categories">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="d-flex justify-content-center align-items-center flex-column"
                        >
                            <h2 class="fw-bold text-white text-center head">
                                 {{$t('categories_banner_section.heading')}}

                            </h2>
                            <p class="text-white text-center mt-3 ">
                                {{$t('categories_banner_section.paragraph')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="search-topic p-5 shadow">
                    <div class="row">
                        <div class="col-lg-7 col-md-6">
                            <h2 class="fw-bold text-primary">
                                {{$t('categories_label_section.heading')}}
                            </h2>
                            <p class="mb-0 text-dark p-0 fw-400">
                                {{$t('categories_label_section.sub_heading')}}
                            </p>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <div
                                class="d-flex align-items-center h-100 py-3 py-md-0 w-100"
                            >

                                    <div class="input-group border border-secondary">
  <input type="text"
                                        name=""
                                        id=""
                                        :placeholder="$t('all_categories.fields.btn_label')"
                                        aria-describedby="button-addon2"
                                        v-model="search_category"
                                        @change="searchCategories"
                                        class="form-control border-0 rounded-0 p-3">
  <span class="input-group-text bg-white text-primary border-0 fw-bold fs-3 rounded-0 d-flex align-items-center" id="basic-addon2" role="button" v-on:click="searchCategories">{{ $t('all_categories.fields.btn_label') }} <i
                                                class="fa-solid fa-arrow-right-long text-secondary align-baseline ms-1"
                                            ></i></span>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="categories-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center " v-if="loading">
                        <img src="/assets/images/loader.gif" height="100px" alt="">
                    </div>
                    <div class="col-md-12 mt-5" v-if="allCategoriesFilter.length==0 && !loading">
                        <h3>No Record Found</h3>
                    </div>
                    <div class="col-md-12 mt-5" v-if="!loading" >
                        <div class="pt-5">
                            <div class="row"

                            >
                                <div class="col-lg-3 col-md-4 col-6"
                                v-for="category in allCategoriesFilter"
                                :key="category.id"
                                >
                                    <div class="card border-0 bg-transparent mb-4">
                                        <div class="img-wrap mb-3">
                                        <a :href="`${url + '/categories/' + category.slug}`">
                                        <img
                                           :src="category.image_path"
                                            alt=""
                                            class="img-fluid w-100"
                                        />
                                        </a>
                                        </div>
                                        <div class=" pb-4">
                                        <a :href="`${url + '/categories/' + category.slug}`">
                                        <h4 class="text-primary fw-bold">
                                           {{category.name}}
                                        </h4>
                                        </a>
                                        <p class="mb-0" v-if="category.mentor_p_count">( {{category.mentor_p_count}} consultant)</p>
                                        <p class="mb-0" v-else>( 0 consultant )</p>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
<div
                            class="btn-load-more d-flex justify-content-center align-items-center"
                        >
                            <v-page
                                :total-row="categories.length"
                                align="left"
                                v-model="current"
                                @page-change="categoriesChange"
                                :page-size-menu="[20, 40, 60]"
                                v-if="!loading"
                             ></v-page>
                        </div>
                    </div>


                </div>
            </div>

        </section>
        <view-questions-section></view-questions-section>
        <dont-find-answer></dont-find-answer>

    </div>
</template>
<script>
export default {
  props: ["url"],

  data() {
    return {
      categories: [],
      loading: true,
      search_category: "",
      allCategoriesFilter: [],
      current: 0,
      pagination: {
        pageNumber: 1,
        pageSize: 10,
      },
    }

    },
  watch: {
  search_category: {
     handler(val){
       if(val)
       {

       }else
       {
           this.searchCategories();
       }
     },
     deep: true,
     immediate: true
  }
},
  methods: {
    async fetchGenericData() {
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
    categoriesChange(pInfo) {
      this.allCategoriesFilter.splice(0, this.allCategoriesFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.categories.length) end = this.categories.length;
      for (let i = start; i < end; i++) {
        this.allCategoriesFilter.push(this.categories[i]);
      }
    },
    async searchCategories() {
      this.loading = true;
      const params = {
        token: 123,
        search: this.search_category,
      };
      const res = await axios.get("/api/search-category", { params });
      if (res.data && res.data.Status) {
        this.categories = res.data.data.results;
        this.loading = false;
      }
    },
  },
  created() {
    this.fetchGenericData();
  },
};
</script>
