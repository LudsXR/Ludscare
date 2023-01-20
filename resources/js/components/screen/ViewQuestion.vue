<template>
    <section class="viewquestions bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="d-flex justify-content-center align-items-center flex-column"
                    >
                        <h2 class="text-primary fw-bold head text-center">
                            <!-- {{$t('categories_banner_view.heading')}} -->

                            View answer & question
                            <span class="text-secondary"
                                ><br />Related your topic</span
                            >
                        </h2>
                        <!-- <h1 class="text-secondary fw-bold head">Related your topic</h1> -->
                        <p>{{ $t("categories_banner_view.sub_heading") }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion mt-5" id="accordionExample">
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="headingOne">
                                <button
                                    class="accordion-button bg-transparent border-0 text-primary fw-bold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne"
                                    aria-expanded="true"
                                    aria-controls="collapseOne"
                                >
                                    {{
                                        $t("categories_banner_view.question_1")
                                    }}
                                </button>
                            </h2>
                            <div
                                id="collapseOne"
                                class="accordion-collapse collapse show"
                                aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    <p>
                                        {{
                                            $t(
                                                "categories_banner_view.answer_1"
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="headingTwo">
                                <button
                                    class="accordion-button collapsed bg-transparent border-0 text-primary fw-bold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo"
                                >
                                    {{
                                        $t("categories_banner_view.question_2")
                                    }}
                                </button>
                            </h2>
                            <div
                                id="collapseTwo"
                                class="accordion-collapse collapse"
                                aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    <p>
                                        {{
                                            $t(
                                                "categories_banner_view.answer_2"
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-0">
                            <h2 class="accordion-header" id="headingThree">
                                <button
                                    class="accordion-button collapsed bg-transparent border-0 text-primary fw-bold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree"
                                    aria-expanded="false"
                                    aria-controls="collapseThree"
                                >
                                    {{
                                        $t("categories_banner_view.question_3")
                                    }}
                                </button>
                            </h2>
                            <div
                                id="collapseThree"
                                class="accordion-collapse collapse"
                                aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample"
                            >
                                <div class="accordion-body">
                                    <p>
                                        {{
                                            $t(
                                                "categories_banner_view.answer_3"
                                            )
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
