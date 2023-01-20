<template>
  <div id="accordionExample" class="accordion">
    <div class="accordion-item border-0">
      <div v-for="category in categories" :key="category.id">
        <h6 id="headingTwo" class="accordion-header d-flex align-items-center">
          <a
            :href="`${url + '/categories/' + category.slug}`" :class="`${category.slug==slug ? 'text-success' : 'text-dark'}`"
            class="text-decoration-none mb-4"
            >{{ category.name }}</a
          >
         <div v-if="category.sub_categories && category.sub_categories.length > 0">
              <button
            class="accordion-button collapsed ps-2 py-0 pe-0 mb-4 bg-transparent"
            type="button"
            data-bs-toggle="collapse"
            :data-bs-target="'#cat' + category.id"
            aria-expanded="false"
            aria-controls="collapseTwo"
          ></button>
         </div>

        </h6>
        <div
          :id="'cat' + category.id"
          class="accordion-collapse collapse"
          aria-labelledby="headingTwo"
          :class="
                            'cat' + category.id === 'cat' + selectedCatID
                              ? 'show'
                              : ''
                          "
        >
          <div v-if="category.sub_categories" style="padding-left: 30px">
            <sidebar-categories-list
              :url="url"
              :categories="category.sub_categories"
            ></sidebar-categories-list>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["url", "categories","slug","selectedCatID"],
  data() {
    return {};
  },
};
</script>

<style>
</style>
