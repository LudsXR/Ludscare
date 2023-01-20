<template>
  <div>
    <header class="header-categories">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div
              class="
                d-flex
                justify-content-center
                align-items-center
                flex-column
              "
            >
              <h2 class="fw-bold text-white text-center head">
                {{ $t("categories_banner_section.heading") }}
              </h2>
              <p class="text-white text-center mt-3">
                {{ $t("categories_banner_section.paragraph") }}
              </p>
            </div>
          </div>
        </div>
        <div class="search-section">
          <div class="row">
            <div class="col-12 px-4 mb-4">
                <div class="row bg-img py-4 px-c border-8  pb-lg-4 pb-5">

                <div class="col-lg-10 mt-1">
                <treeselect
                  v-model="filters.categories"
                  :multiple="true"
                  :options="categoriesFilteroptions"
                  class="border-r"
                />
              </div>

              <div class="col-lg-2 mb-3 mt-lg-1 mt-3 text-primary ps-lg-4">
                <button
                  class="btn bg-white text-secondary text-uppercase w-100 border-r fw-bold"
                  type="button"
                  id="button-addon2"
                  @click="searchMentors"
                >
                   {{$t("categories_sidebar_section.search") }}
                   <i class="fa-solid fa-arrow-right text-secondary ps-2"></i>
                </button>
              </div>
              <div class="col-lg-3 col-md-6 mt-3">
                <div
                  class="input-group rounded-5 px-1 w-100 bg-white border-r"
                >
                  <input
                    type="text"
                    class="form-control border-0 border-r"
                    placeholder="Type Your Keyword"
                    aria-describedby="button-addon2"
                    v-model="search_mentor"
                  />
                </div>
              </div>
              <div class="col-lg-3 col-md-6 mt-3">
                <ul class="list-unstyled mb-0">
                  <li class="text-white"> {{$t("categories_sidebar_section.price") }}</li>
                  <vue-slider
                    :min="100"
                    :max="10000"
                    :clickable="true"
                    :drag-on-click="true"
                    :min-range="10"
                    v-model="value"
                    ref="slider"
                    :duration="0.5"
                  >
                    <template v-slot:process="{ start, end, style, index }">
                      <div class="vue-slider-process" :style="style">
                        <div
                          :class="[
                            'merge-tooltip',
                            'vue-slider-dot-tooltip-inner',
                            'vue-slider-dot-tooltip-inner-top',
                          ]"
                        >
                          {{ value[index] }} - {{ value[index + 1] }}
                        </div>
                      </div>
                    </template>
                  </vue-slider>
                </ul>
              </div>

              <div
                class="col-lg-2 col-md-6 mt-3 text-primary"
              >
                <div class="custom-select">
                  <select
                    class="form-select border-r"
                    aria-label="Default select example"
                    v-model="filters.country_id"
                    v-on:change="fetchCities($event)"
                  >
                    <option value="" selected>
                      {{
                        $t("mentor.profile.general.place_holder.select_country")
                      }}
                    </option>
                    <option
                      :value="country.id"
                      v-for="country in countries"
                      :key="country.id"
                    >
                      {{ country.name }}
                    </option>
                  </select>
                </div>
              </div>
              <div
                class="col-lg-2 col-md-6 mt-3 text-primary"
              >
                <div class="custom-select">
                  <select
                    class="form-select border-r"
                    aria-label="Default select example"
                    v-model="filters.city"
                  >
                    <option value="" selected>
                      {{
                        $t("mentor.profile.general.place_holder.Select_city")
                      }}
                    </option>
                    <option
                      :value="city.name"
                      v-for="city in cities"
                      :key="city.id"
                    >
                      {{ city.name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="col-lg-2 mt-3  ps-lg-4">
                <button
                  type="button"
                  class="btn btn-gradient border-r w-100 text-white ps-0 text-lg-start"
                  @click="clearRangeFilter"
                >
                <i class="fa-solid fa-arrow-rotate-right pe-2 fs-20"></i> <span class="border-white">Reset All</span>
                </button>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <section class="consultant-section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-lg-3 col-md-4 mb-md-0 mb-3">


            <div class="p-4 sidebar bg-white shadow accordion-2">
              <div class="accordion bg-transparent" id="accordionExample">
                <div class="accordion-item border-0">
                  <div
                    v-for="category in mentorCategories"
                    :key="category.id"
                    class="mb-3 border-bottom"
                  >
                    <h6
                      v-if="category.sub_categories.length > 0"
                      class="accordion-header align-items-center d-flex mb-3"
                      id="headingTwo"
                    >
                      <a
                        class="text-decoration-none"
                        :class="`${
                          category.slug == slug ? 'text-success' : 'text-dark'
                        }`"
                        :href="`${url + '/categories/' + category.slug}`"
                        >{{ category.name }}</a
                      >
                      <button
                        class="
                          accordion-button
                          collapsed
                          ps-2
                          py-0
                          pe-0
                          bg-transparent
                        "
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="'#cat' + category.id"
                        aria-expanded="false"
                        aria-controls="collapseTwo"
                      ></button>
                    </h6>

                    <h6
                      class=""
                      v-if="
                        category.parent_id == 0 &&
                        category.sub_categories.length == 0
                      "
                    >
                      <strong>
                        <a
                          class="text-decoration-none text-dark"
                          :href="`${url + '/categories/' + category.slug}`"
                          >{{ category.name }}</a
                        >
                      </strong>
                    </h6>
                    <div
                      :id="'cat' + category.id"
                      class="accordion-collapse collapse"
                      aria-labelledby="headingTwo"
                      data-bs-parent="#accordionExample"
                      :class="
                        'cat' + category.id === 'cat' + selectedCatID
                          ? 'show'
                          : ''
                      "
                    >
                      <div class="ps-4 sidebar bg-transparent mt-4">
                        <sidebar-categories-list
                          :url="url"
                          :categories="category.sub_categories"
                          :slug="slug"
                          :selectedCatID="selectedCatID"
                          v-if="!categoriesLoading && category.sub_categories"
                        ></sidebar-categories-list>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-9 col-md-8 mb-5">
            <div class="row h-100">
              <div
                class="col-lg-4 col-md-6"
                v-for="mentor in allMentorsFilter"
                :key="mentor.id"
              >
                <div class="">
                  <div class="guiders-card position-relative">
                    <div class="verified position-absolute">
                      <img src="/assets/images/verified-icon.png" alt="" />
                    </div>
                    <div class="guiders-img">
                      <img
                        v-if="mentor && mentor.user && mentor.user.image_path"
                        :src="mentor.user.image_path"
                        alt="Team Image"
                        class="img-fluid"
                      />
                      <img
                        v-else
                        src="/assets/images/profile_placeholder.png"
                        alt="Team Image"
                        class="img-fluid"
                      />
                    </div>
                    <div class="guiders-content">
                      <div class="title d-flex flex-column">
                        <button
                          class="btn btn-secondary text-white fw-500"
                          type="button"
                          v-on:click="checkLogin(mentor.user_id)"
                        >
                          Book an appointment
                        </button>
                      </div>
                    </div>
                  </div>
                  <div
                    class="
                      guider-info
                      d-flex
                      justify-content-center
                      align-items-center
                    "
                  >
                    <div
                      class="
                        card
                        border-0
                        shadow
                        py-3
                        px-4
                        text-center text-capitalize
                      "
                    >
                      <a :href="url + '/consultant-profile/' + mentor.user.id">
                        <h5 class="text-primary fw-bold mb-0 text-ca">
                          {{
                            mentor.user.first_name + " " + mentor.user.last_name
                          }}
                        </h5>
                      </a>
                      <h6 class="mb-0 text-muted mt-1">
                        {{ mentor.category.name }}
                      </h6>
                      <div class="text-secondary">
                        <i
                          class="fa-solid fa-star me-1"
                          v-for="(rate, index) in mentor.rating"
                          :key="index"
                        ></i>
                      </div>
                      <div class="no-rating" v-if="mentor.rating == 0">
                        <i class="fa-solid fa-star text-light-muted"></i>
                        <i class="fa-solid fa-star text-light-muted"></i>
                        <i class="fa-solid fa-star text-light-muted"></i>
                        <i class="fa-solid fa-star text-light-muted"></i>
                        <i class="fa-solid fa-star text-light-muted"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                   <div
                class="container col-lg-4 col-md-6 text-center"
                v-if="allMentorsFilter.length == 0 && !loading"
              >
              No data Found!
             </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="text-center mt-5">
                  <v-page
                    :total-row="mentors.length"
                    align="left"
                    v-model="current"
                    @page-change="mentorsChange"
                    :page-size-menu="[10, 20, 30]"
                    v-if="!loading"
                  ></v-page>
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
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";
import Treeselect from "@riophae/vue-treeselect";
import "@riophae/vue-treeselect/dist/vue-treeselect.css";
export default {
  props: ["url", "slug"],
  components: {
    VueSlider,
    Treeselect
  },
  data() {
    return {
          categoriesFilteroptions: [],
      value: [100, 10000],
      process: (val) => [[val[0], val[1]]],
      mentors: [],
      loading: true,
         countries: {},
      cities: {},
      filters: {
        token: 123,
        search: "",
        minPrice: "",
        maxPrice: "",
        country_id: "",
        city: "",
        categories: null
      },
      mentorCategories: [],
      categoriesLoading: true,
      search_mentor: "",
      allMentorsFilter: [],
      selectedCatID: "",
      allCat: "",
      current: 0,
      pagination: {
        pageNumber: 1,
        pageSize: 10,
      },
    };
  },
  watch: {
    search_mentor: {
      handler(val) {
        if (val) {
        } else {
        //   this.searchMentors();
        }
      },
      deep: true,
      immediate: true,
    },
  },
  methods: {
    checkLogin(mentor_id) {
      //   this.appointment_type = type
      var User = JSON.parse(localStorage.getItem("User"));
      if (!User) {
        window.location.href = this.url + "/login";
        this.$toasted.error("Please Login First");
      } else {
        if (User.role == "Mentee") {
          window.location.href =
            this.url + "/appointment-schedule/" + mentor_id;
        } else if (User.role == "Mentor") {
          this.$toasted.error("Please Login as a User");
        }
      }
    },
    async fetchMentors() {
      this.loading = true;
      const params = {
        token: 123,
        slug: this.slug,
        country: localStorage.getItem("country"),
        city: localStorage.getItem("city"),
      };
      const res = await axios.get("/api/mentors/with/slug", { params });
      if (res.data && res.data.Status == true) {
        // this.allMentorsFilter = res.data.data.mentors;
        this.mentors = res.data.data.mentors;
        this.loading = false;
      } else {
        this.loading = false;
      }
    },
   async fetchMentorCategories() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/mentorCategoriesListWeb", { params });
      if (res.data && res.data.Status == true) {
        this.mentorCategories = res.data.data.mentorCategories;
       if (this.mentorCategories.length>0) {
         this.categoriesFilteroptions = this.makeChildrens(this.mentorCategories);
       }
        var obj = this.mentorCategories.find((category) => {
          if (category.slug === this.slug) {
            return category;
          }
        });
        this.categoriesLoading = false;
        if (obj) {
            this.selectedCatID = obj.id;
        }
      } else {
        this.categoriesLoading = false;
      }
    },
    mentorsChange(pInfo) {
      this.allMentorsFilter.splice(0, this.allMentorsFilter.length);
      let start = 0,
        end = 0;
      start = pInfo.pageSize * (pInfo.pageNumber - 1);
      end = start + pInfo.pageSize;
      if (end > this.mentors.length) end = this.mentors.length;
      for (let i = start; i < end; i++) {
        this.allMentorsFilter.push(this.mentors[i]);
      }
    },
  async searchMentors() {
      if (this.search_mentor) {
        await this.getRangeValue();
        if (this.search_mentor) {
          this.filters.search = this.search_mentor;
          this.loading = true;
          const params = this.filters;
          const res = await axios.get("/api/search-mentor-web", { params });
          if (res.data && res.data.Status) {
            this.mentors = res.data.data.results;
            this.loading = false;
          }
        } else {
          this.fetchMentors();
        }
      } else {
        this.$toasted.error("Search Field is Required");
      }
    },
    async getRangeValue() {
      var value = this.$refs.slider.getValue();
      var min_value = value[0];
      var max_value = value[1];
    //   this.loading = true;
    //   const params = {
    //     token: 123,
    //     slug: this.slug,
    //     country: localStorage.getItem("country"),
    //     city: localStorage.getItem("city"),
    //     minPrice: min_value,
    //     maxPrice: max_value,
    //   };
    //   const res = await axios.get("/api/mentors/price/range", { params });
    //   if (res.data && res.data.Status) {
    //     this.mentors = res.data.data.mentors;
    //     this.loading = false;
    //   }
    },
    async fetchCities(event) {
      var country_id = event.target.value;

      const params = {
        token: 123,
        country_id: country_id,
      };
      const res = await axios.get("/api/cities", {
        params,
      });
      if (res.data && res.data.Status) {
        this.cities = res.data.data.cities;
      }
    },
    async fetchCountries() {
      const params = {
        token: 123,
      };
      const res = await axios.get("/api/countries", {
        params,
      });
      if (res.data && res.data.Status) {
        this.countries = res.data.data.countries;
      }
    },
    clearRangeFilter() {
      this.value = [];
      this.value = [100, 10000];
      this.filters.minPrice = "";
      this.filters.maxPrice = "";
      this.filters.search = "";
      this.search_mentor = "";
      this.filters.country_id = "";
      this.filters.city = "";
      this.filters.categories = null;
      this.cities = {};
      this.fetchMentors();
    },
        makeChildrens(categories) {
      var new_categories = [];
      categories.forEach((category, index) => {
        let cat = {
          id: category.id,
          label: category.name,
        };
        if (category.sub_categories && category.sub_categories.length > 0) {
          cat.children = this.makeChildrens(category.sub_categories);
        }
        new_categories.push(cat);
      });
      return new_categories;
    },
  },
  async created() {
    //   let info={pageNumber: 1, pageSize: 20};

    await this.fetchCountries();
    await this.fetchMentorCategories();

        let searchParams = new URLSearchParams(window.location.search);
            let search_mentor = searchParams.get('search_mentor');
            let country_id = searchParams.get('country_id');
            let city = searchParams.get('city');
            let categories = searchParams.get('categories');
            if (categories == 'null') {
                categories = null
            }
            let minPrice = searchParams.get('minPrice');
            let maxPrice = searchParams.get('maxPrice');
            if (search_mentor) {
                this.search_mentor = search_mentor
            }
            if (country_id) {
                this.filters.country_id = country_id
                     const params = {
                        token: 123,
                        country_id: country_id,
                    };
                    const res = await axios.get("/api/cities", {
                        params,
                    });
                    if (res.data && res.data.Status) {
                        this.cities = res.data.data.cities;
                    }
            }
            if (city) {

                this.filters.city = city
            }
            if (categories) {
                this.filters.categories = [];
                var str = categories;
                    var str_array = str.split(',');
                    for(var i = 0; i < str_array.length; i++) {
                    str_array[i] = str_array[i].replace(/^\s*/, "").replace(/\s*$/, "");
                    this.filters.categories.push(str_array[i]);
                    }
            }
            if (minPrice || maxPrice) {
                this.filters.minPrice = minPrice
                this.filters.maxPrice = maxPrice
                this.value = [];
                this.value.push(minPrice);
                this.value.push(maxPrice);
            }

              if (search_mentor) {
                await this.searchMentors();
            }
            else
            {
                await this.fetchMentors();
            }

  },
};
</script>
