<template>
    <section class="appointment-screen mt-0 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5 border-end">
                    <div class="position-relative mt-5">
                        <div class="shape"></div>
                        <img
                            src="/assets/images/guider-1.png"
                            alt=""
                            class="img-fluid position-relative w-100 pe-5 margin-neg"
                        />
                    </div>

                    <div class="d-flex justify-content-start flex-column ps-4">
                        <h4 class="text-primary fw-bold mt-3">John Smith</h4>

                        <p class="mb-0 fw-500">Business Consultant</p>
                            <h6 class="text-secondary mb-0 mt-1">
                                <i
                                    class="fa-solid fa-location-dot text-muted me-1"
                                ></i
                                ><span class="location">
                                    North West England
                                </span>
                            </h6>
                    </div>
                </div>
                <div class="col-lg-4 col-md-7">
                    <h5 class="text-primary mt-5 mt-md-0">Ask your Question</h5>
                    <div class="form-ask">
                        <form action="">
                            <div class="custom-select">
                                <select
                                    class="form-select border mt-3"
                                    id="inputGroupSelect01"
                                >
                                    <option selected>
                                        Select Question Type
                                    </option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>


                            <div class="upload-btn-wrapper w-100 mt-3">
                                <button class="btn btn-upload w-100 d-flex">
                                    Upload a file
                                </button>
                                <input type="file" />
                            </div>

                            <textarea
                                name=""
                                id=""
                                rows="5"
                                class="form-control w-100 border p-2 mt-3"
                                placeholder="Type Message"
                            ></textarea>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <h5 class="text-primary mt-lg-0 mt-5">
                        Select Payment Method
                    </h5>
                    <div class="payment-card mt-3">
                        <ul class="d-inline-flex ps-0" type="none">
                            <li class="pe-2">
                                <div class="card active border d-md-flex h-100 align-items-center justify-content-center">
  <img
                                    src="/assets/images/mastercard.png"
                                    alt=""
                                    class="img-fluid h-100"
                                />
                                </div>

                            </li>
                            <li class="pe-2">
                                 <div class="card  border d-md-flex h-100 align-items-center justify-content-center">
                                <img
                                    src="/assets/images/master-card.png"
                                    alt=""
                                    class="img-fluid h-100 "
                                />
                                 </div>
                            </li>
                            <li class="pe-2">
                                 <div class="card  border d-md-flex h-100 align-items-center justify-content-center">
                                <img
                                        src="/assets/images/paypal-icon.png"
                                        alt=""
                                        class="img-fluid h-100 "
                                    />
                                 </div>
                            </li>
                            <li class="pe-2">
                                 <div class="card  border d-md-flex h-100 align-items-center justify-content-center">
                                 <img
                                        src="/assets/images/visa-card.png"
                                        alt=""
                                        class="img-fluid h-100 "
                                    />
                                 </div>
                            </li>
                            <li class="">
                                 <div class="card  border d-md-flex h-100 align-items-center justify-content-center">
                                <img
                                        src="/assets/images/strip.png"
                                        alt=""
                                        class="img-fluid h-100 "
                                    />
                                 </div>
                            </li>
                        </ul>
                    </div>

                    <div class="form-card">
                        <h6 class="text-muted pt-3">
                            Enter Master Card Details
                        </h6>
                        <input
                            type="text"
                            name=""
                            id=""
                            class="form-control border mt-3"
                            placeholder="Card Name"
                        />
                        <input
                            type="number"
                            name=""
                            id=""
                            class="form-control border mt-3"
                            placeholder="Card Number"
                        />
                        <div class="row">
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    name=""
                                    id=""
                                    class="form-control border mt-3"
                                    placeholder="Expiry Date"
                                />
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    name=""
                                    id=""
                                    class="form-control border mt-3"
                                    placeholder="Expiry Month"
                                />
                            </div>
                            <div class="col-md-4">
                                <input
                                    type="number"
                                    name=""
                                    id=""
                                    class="form-control border mt-3"
                                    placeholder="CVV Code"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="d-flex pt-5 justify-content-end align-items-center"
                    >
                        <button class="btn btn-graish me-2 text-white">
                            <i class="fa-solid fa-angles-left me-1"></i>
                            Back
                        </button>
                        <button
                            class="btn btn-secondary text-white"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                        >
                            Make Payment
                            <i class="fa-solid fa-angles-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content p-1">
                    <div class="modal-header bg-primary text-white px-5">
                        <div class="row">
                            <div
                                class="col-md-3 d-flex align-items-center justify-content-md-end justify-content-center"
                            >
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div class="col-md-9">
                                <h6
                                    class="modal-title fw-bold"
                                    id="exampleModalLabel"
                                >
                                    Please register or sign in to continue
                                </h6>
                                <p class="">
                                    Lorem ipsum dolor sit, amet consectetur
                                    adipisicing elit. Omnis molestiae laboriosam
                                    officia voluptas modi distinctio quasi sint,
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body px-5">
                        <div class="form-card">
                            <div class="position-relative">
                                <input
                                    type="text"
                                    name=""
                                    id=""
                                    placeholder="Username here"
                                    class="form-control mt-4"
                                />
                                <i
                                    class="fa-solid fa-user position-absolute text-secondary"
                                    id="togglePassword"
                                ></i>
                            </div>
                            <div class="position-relative">
                                <input
                                    type="password"
                                    name=""
                                    id=""
                                    placeholder="Password here"
                                    class="form-control mt-4"
                                />
                                <i
                                    class="fa-solid fa-lock position-absolute text-secondary"
                                    id="togglePassword"
                                ></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-block border-0 px-5">
                        <div class="row">
                            <div
                                class="col-md-7 d-flex justify-content-start align-items-center"
                            >
                                <p class="text-primary mt-4">
                                    New to site?
                                    <a
                                        href=""
                                        class="text-decoration-none text-secondary"
                                        >Create an account</a
                                    >
                                </p>
                            </div>
                            <div
                                class="col-md-5 justify-content-md-end d-flex align-items-center"
                            >
                                <button
                                    class="btn btn-secondary text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal2"
                                >
                                    Continue
                                    <i
                                        class="fa-solid fa-angles-right ms-1"
                                    ></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- thank u popup -->
        <div
            class="modal fade"
            id="exampleModal2"
            tabindex="-1"
            aria-labelledby="exampleModalLabel2"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content p-1">
                    <div
                        class="modal-header bg-primary text-white px-5 d-flex justify-content-center"
                    >
                        <div class="row">
                            <div class="col-md-12">
                                <h1
                                    class="modal-title text-uppercase"
                                    id="exampleModalLabel"
                                >
                                    Thank you
                                </h1>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body px-5">
                        <div class="thanku-card text-center py-4">
                            <img
                                src="/assets/images/thanku.png"
                                alt=""
                                class="img-fluid mb-2"
                            />
                            <h4 class="text-primary">Your Payment Done</h4>
                            <p>
                                Please click on continue button to go to
                                appointment page
                            </p>
                            <button class="btn btn-secondary text-white">
                                Continue
                                <i class="fa-solid fa-angles-right ms-1"></i>
                            </button>
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
