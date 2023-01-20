<template>
    <section class="book-appointment pt-80 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img
                            src="/assets/images/WhiteMatte2.png"
                            alt=""
                            class="img-fluid mobile"
                        />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div
                        class="h-100 d-flex justify-content-center flex-column py-5 py-md-0 text-lg-start text-center"
                    >
                        <h2 class="text-white fw-bold mb-0">
                            {{$t('banner_how_to_book_section.heading')}}

                        </h2>
                        <p class="text-white my-4">
                            {{$t('banner_how_to_book_section.paragraph')}}

                        </p>
                        <div class="d-flex mt-2 justify-content-lg-start justify-content-center">
                            <a class="me-3" type="button" href="#" title="Google Play"
                                ><img
                                    src="/assets/images/google-btn.png"
                                    alt=""
                                    class="img-fluid"
                            /></a>
                            <a class="" type="button" href="#" title="Apple Store"
                                ><img src="/assets/images/apple-btn.png" alt=""  class="img-fluid"
                            /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: ["url"],
};
</script>
