<template>
    <div class="services-section">
        <div class="container">
     <div class="row">
          <div class="col-12 px-4 mb-4">
                <div class="row bg-img py-4 px-c border-8 pb-lg-4 pb-5">

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

</template>

<script>
import axios from "axios";
import { log } from "../utils/utils";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/antd.css";
// import the component
import Treeselect from "@riophae/vue-treeselect";
// import the styles
import "@riophae/vue-treeselect/dist/vue-treeselect.css";
export default {
  props: ["url"],
    components: {
    VueSlider,
    Treeselect,
  },
  data() {
    return {
      categoriesFilteroptions: [],
      value: [100, 10000],
      process: (val) => [[val[0], val[1]]],
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
      search_mentor: "",

    };
  },
  methods:{
        async searchMentors() {
      if (this.search_mentor) {
        await this.getRangeValue();

        if (this.filters.categories == null) {
           window.location.href = '/categories/unassign?search_mentor='+this.search_mentor+'&country_id='+this.filters.country_id+'&city='+this.filters.city+'&categories='+this.filters.categories+'&minPrice='+this.filters.minPrice+'&maxPrice='+this.filters.maxPrice;
        }
        else{
              var obj = this.mentorCategories.find((category) => {
          if (category.id === this.filters.categories[0]) {
            return category;
          }
        });
        window.location.href = "/categories/"+obj.slug+'?search_mentor='+this.search_mentor+'&country_id='+this.filters.country_id+'&city='+this.filters.city+'&categories='+this.filters.categories+'&minPrice='+this.filters.minPrice+'&maxPrice='+this.filters.maxPrice;
        }

      } else {
        this.$toasted.error("Search Field is Required");
      }
    },
    async getRangeValue() {
      var value = this.$refs.slider.getValue();
      this.filters.minPrice = value[0];
      this.filters.maxPrice = value[1];
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
      } else {
      }
    },

  },
       async created() {

    await this.fetchMentorCategories();
    await this.fetchCountries();

  },
}
</script>

<style>

</style>
