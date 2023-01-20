<template>
    <div>
        <section class="video-call">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="d-flex justify-content-center align-items-center"
                        >
                            <div class="video-width">
                                <div class="main position-relative">
                                    <img
                                        src="/assets/images/video-caller.png"
                                        alt="img-1"
                                        class="img-1 position-relative w-100 shadow"
                                    />
                                    <img
                                        src="/assets/images/video-attender.png"
                                        alt="image-small"
                                        class="img-2 position-absolute end-0 top-0 shadow video-attender"
                                    />
                                </div>
                                <div
                                    class="p-3 bg-primary d-flex justify-content-center"
                                >
                                    <div
                                        class="video-icon d-flex justify-content-center align-items-center me-3"
                                    >
                                        <a href=""><i class="fa-solid fa-video text-secondary"></i></a>
                                    </div>

                                    <div
                                        class="audio-icon d-flex justify-content-center align-items-center me-3"
                                    >
                                        <a href=""><i
                                            class="fa-solid fa-microphone text-secondary"
                                        ></i></a>
                                    </div>
                                    <div
                                        class="comment-icon d-flex justify-content-center align-items-center me-3"
                                    >
                                        <a href=""><i
                                            class="fa-solid fa-comments text-secondary"
                                        ></i></a>
                                    </div>
                                    <div
                                        class="call-end-icon d-flex justify-content-center align-items-center"
                                    >
                                        <a href=""><i
                                            class="fa-solid fa-phone text-white"
                                        ></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <customer-reviews-section></customer-reviews-section>

    </div>
</template>
<script>
export default {
    props: ["url"],
};
</script>
