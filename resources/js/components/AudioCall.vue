<template>
    <div>
        <section class="audio-call">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="d-flex justify-content-center align-items-center"
                        >
                            <div class="bg-primary audio-width">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            class="d-flex justify-content-md-start justify-content-center"
                                        >
                                            <img
                                                src="/assets/images/audiocaller.png"
                                                alt=""
                                                class="img-fluid pe-lg-3 w-100"
                                            />
                                        </div>
                                        <div class="microphone">
                                            <img
                                                src="/assets/images/microphone.png"
                                                alt=""
                                                class="img-fluid pe-3"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="d-flex justify-content-md-start justify-content-center mt-4 mt-md-0"
                                        >
                                            <img
                                                src="/assets/images/audioattender.png"
                                                alt=""
                                                class="img-fluid ps-lg-3 w-100"
                                            />
                                        </div>
                                        <div class="microphone">
                                            <img
                                                src="/assets/images/microphone.png"
                                                alt=""
                                                class="img-fluid pe-md-0 pe-3"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div
                                            class="pt-5 d-flex justify-content-center"
                                        >
                                             <div
                                        class="audio-icon d-flex justify-content-center align-items-center me-3 mt-4"
                                    >
                                        <a href=""><i
                                            class="fa-solid fa-microphone text-secondary"
                                        ></i></a>
                                    </div>
                                    <div
                                        class="comment-icon d-flex justify-content-center align-items-center me-3 mt-4"
                                    >
                                        <a href=""><i
                                            class="fa-solid fa-comments text-secondary"
                                        ></i></a>
                                    </div>
                                    <div
                                        class="call-end-icon d-flex justify-content-center align-items-center mt-4"
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
