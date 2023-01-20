<template>
  <div>
    <appointment-section
      :url="url"
      :mentor_id="mentor_id"
      :route="route"
      :liveRoute="liveRoute"
      :appointmentid="appointmentid"
      :google_capcha_site_key="google_capcha_site_key"
    ></appointment-section>
    <customer-reviews-section
      v-if="!loading && ratings.length > 0"
      :mentorDetail="mentorDetails"
      :ratings="ratings"
      :url="url"
    ></customer-reviews-section>
  </div>
</template>

<script>
export default {
  props: ["url", "mentor_id","route","liveRoute","appointmentid","google_capcha_site_key"],
  data() {
    return {
      user_id: this.mentor_id,
      mentorDetails: {},
      ratings: [],
      loading: true
    };
  },
  methods: {
    async fetchMentorDetails() {
      const params = {
        token: 123,
        user_id: this.user_id,
      };
      const res = await axios.get("/api/getUserById", { params });
      if (res.data && res.data.Status) {
        this.mentorDetails = res.data.data.userDetail;
        this.ratings = res.data.data.userDetail.ratings;
        this.loading = false;
      }
    },
  },
  created() {
      this.fetchMentorDetails();
  },

};
</script>
