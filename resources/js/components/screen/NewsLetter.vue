<template>
<div class=""><div class="newsletter-section">
<div class="container">
    <div class="row">
<div class="col-md-12">
<div class="subscription-section p-5">
<div class="row">
    <div class="col-md-6">
        <h4 class="fw-bold">{{$t('newsletter_section.heading')}}</h4>
<p class="mb-0">{{$t('newsletter_section.sub_heading')}}</p>
    </div>
    <div class="col-md-6 d-flex justify-content-center align-items-center">
      <div class="position-relative form-newsletter w-100 mt-3 mt-md-0 ">
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        ref="email"
                                        :placeholder="$t('newsletter_section.text_placeholder')"
                                        class="form-control"
                                        :class="errors && errors.email ? 'border-danger' : ''"
                                    />
                                    <p v-if="errors && errors.email" class="text-danger position-absolute">

{{errors.email[0]}}

</p>
                                    <i @click="subscribe()" class="fa-solid fa-paper-plane text-primary position-absolute"></i>
                                </div>
    </div>
</div>
</div>
</div>
    </div>
</div>
</div></div>

</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            errors:{}
        };
    },
    methods:{
        subscribe(){
            let toast = this.$toasted;
            let email=this.$refs.email.value;
            const params = {
                email:email,
                token:'123'
            };
            this.errors = {};
            axios
            .post("/api/save-newsletter", params)
            .then((response) => {
            if (response.data.Status) {
                toast.success(response.data.msg);
                this.$refs.email.value='';
            }
            for (const property in response.data.errors) {
                // toast.error(response.data.errors[property][0]);
            }
            this.errors = response.data.errors;
            })
            .catch((error) => {
            toast.error(error);
            });
        }
    }
}
</script>
