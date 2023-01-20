<template >
    <div>

        <footer class="bg-primary text-white ">
            <news-letter-section></news-letter-section>
            <div class="footer-links pb-5">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-3 col-md-12">
                            <h5>{{$t('about_us_section.heading')}}</h5>

                            <p class="mt-4 pe-lg-5">


                              {{about_company}}

                            </p>
                            <div class="d-flex mt-4 mb-xl-0 mb-lg-3 mb-4">
                                <div class="social-links mb-3"><a :href="facebook_link"> <i
                                        class="fa-brands fa-facebook-f text-secondary me-3"
                                    ></i></a>

                                </div>
                                <div class="social-links mb-3">
                                    <a :href="twitter_link">
                                    <i
                                        class="fa-brands fa-twitter text-secondary me-3"
                                    ></i>
                                    </a>
                                </div>
                                <div class="social-links mb-3">
                                    <a :href="linkden_link">
                                   <i class="fa-brands fa-linkedin-in text-secondary"></i>
                                   </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                              <h5>{{$t('overview_section.heading')}}</h5>

                            <ul type="none" class="mt-4">
                                <li><a href="/">{{$t('overview_section.heading1')}}</a></li>

                                <li>
                                    <a href="/categories"
                                         >{{$t('overview_section.heading2')}}</a

                                    >
                                </li>

                                <li>
                                    <a href="/blog">{{$t('overview_section.heading3')}}</a>

                                </li>
                                <li>
                                     <a href="/contact-us">{{$t('overview_section.heading4')}}</a>

                                </li>
                                <li>
                                    <a href="/about-us">{{$t('overview_section.heading45')}}</a>

                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <h5>{{$t('services_section.heading')}}</h5>

                            <ul type="none" class="mt-4">
                                <li>
                                    <a href="#"
                                        >{{$t('services_section.heading1')}}</a
                                    >
                                </li>
                                <li>
                                    <a href="#"
                                           >{{$t('services_section.heading2')}}</a
                                    >
                                </li>
                                <li>
                                    <a href="#"
                                        >{{$t('services_section.heading3')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                           >{{$t('services_section.heading4')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                        >{{$t('services_section.heading5')}}</a

                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                             <h5>{{$t('useful_links_section.heading')}}</h5>

                            <ul type="none" class="mt-4">
                                <li>
                                    <a href="#"
                                            >{{$t('useful_links_section.heading1')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                            >{{$t('useful_links_section.heading2')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                            >{{$t('useful_links_section.heading3')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                        >
                                            {{$t('useful_links_section.heading4')}}</a

                                    >
                                </li>
                                <li>
                                    <a href="#"
                                            >{{$t('useful_links_section.heading5')}}</a

                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6">
                             <h5>{{$t('contact_information_section.heading')}}</h5>

                            <ul type="none" class="mt-4">
                                <li>
                                    <div
                                        class="d-flex justify-content-start align-items-baseline flex-row"><i class="fa-solid fa-location-dot text-white pe-3"></i> <span>{{address}}</span> </div
                                    >
                                </li>
                                <li>
                                    <div
                                        ><i class="fa-solid fa-phone text-white pe-3"></i>{{phone}}</div
                                    >
                                </li>
                                <li>
                                    <div
                                        ><i class="fa-solid fa-envelope-open-text text-white pe-3"></i>{{email}}</div
                                    >
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
         <div class="bg-primary p-3"></div>
    </div>
</template>
<script>
export default {
  props: ["url","address","phone","email","facebook_link","twitter_link","linkden_link","about_company"],

}
</script>
