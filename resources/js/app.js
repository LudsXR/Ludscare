import { Datetime } from 'vue-datetime'
 import 'vue-datetime/dist/vue-datetime.css'
 import 'animate.css';
 import AOS from 'aos'
 import 'aos/dist/aos.css'
 import VTooltip from 'v-tooltip'
 import Vue from 'vue'
 import i18n from '../js/utils/i18n.js'
 import VueChatScroll from 'vue-chat-scroll'
 import Page from 'v-page'
 import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
 import { CarouselPlugin } from 'bootstrap-vue'
 Vue.use(CarouselPlugin)
 Vue.use(VueChatScroll);
 Vue.use(Page, { language : 'en'});
 require('./bootstrap');

 window.Vue = require('vue').default;
 import Toasted from 'vue-toasted';
 import ToggleButton from 'vue-js-toggle-button'
 Vue.use(ToggleButton)
 Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(Toasted,{
    position: 'top-right',
    duration: 2000,
    theme: 'bubble',
    closeOnSwipe: true
},
AOS.init(),VTooltip);

// Header & Footer
Vue.component('site-header', require('./components/HeaderComponent.vue').default);
Vue.component('site-footer', require('./components/FooterComponent.vue').default);
//Chat Component
Vue.component('chat-component', require('./components/ChatComponent.vue').default);
// Pages
Vue.component('home-page', require('./components/Homepage.vue').default);
Vue.component('signup-page', require('./components/SignupScreen.vue').default);
Vue.component('login-page', require('./components/LoginScreen.vue').default);
Vue.component('forgot-pass-page', require('./components/ForgotPassword.vue').default);
Vue.component('reset-pass-page', require('./components/ResetPassword.vue').default);
Vue.component('appointment-schedule-page', require('./components/AppointmentSchedule.vue').default);
Vue.component('appointment-section', require('./components/AppointmentScreen.vue').default);
Vue.component('appointment-payment-section', require('./components/PaymentSection.vue').default);
Vue.component('appointment-payment-page', require('./components/AppointmentPayment.vue').default);
Vue.component('wallet-page', require('./components/Wallet.vue').default);
Vue.component('appointment-log-page', require('./components/AppointmentLog.vue').default);
Vue.component('appointment-mentee-log-page', require('./components/AppointmentMenteeLog.vue').default);
Vue.component('appointment-live', require('./components/AppointmentLive.vue').default);
Vue.component('appointment-live-payment', require('./components/AppointmentLivePayment.vue').default);

Vue.component('appointment-log-detail-page', require('./components/AppointmentLogDetail.vue').default);
Vue.component('appointment-mentee-log-detail-page', require('./components/AppointmentMenteeLogDetail.vue').default);

Vue.component('categories-page', require('./components/Categories.vue').default);
Vue.component('consultant-page', require('./components/Consultant.vue').default);
Vue.component('sidebar-categories-list', require('./components/SidebarCategoriesList.vue').default);
Vue.component('consultant-profile-page', require('./components/ConsultantProfile.vue').default);
Vue.component('contact-us-page', require('./components/ContactUs.vue').default);
Vue.component('about-us-page', require('./components/AboutUs.vue').default);
Vue.component('blog-page', require('./components/BlogPage.vue').default);
Vue.component('blog-detail-page', require('./components/BlogDetail.vue').default);
Vue.component('consultant-blog-page', require('./components/ConsultantBlogPage.vue').default);
Vue.component('consultant-blog-edit-page', require('./components/ConsultantBlogEditPage.vue').default);

Vue.component('video-chat', require('./components/VideoChat.vue').default);
Vue.component('stream-player', require('./components/stream-player.vue').default);
Vue.component('audio-call-page', require('./components/AudioCall.vue').default);
Vue.component('video-call-page', require('./components/VideoCall.vue').default);
Vue.component('mentor-profile-page', require('./components/MentorProfile.vue').default);
Vue.component('mentee-profile-page', require('./components/MenteeProfile.vue').default);
Vue.component('dashboard-page', require('./components/Dashboard.vue').default);
Vue.component('generate-schedule', require('./components/GenerateSchedule.vue').default);

// screen
Vue.component('hero-section', require('./components/screen/HeroSection.vue').default);
Vue.component('consultant-search', require('./components/ConsultantSearch.vue').default);
Vue.component('consultant-services', require('./components/screen/ConsultantServices.vue').default);
Vue.component('news-letter-section', require('./components/screen/NewsLetter.vue').default);
Vue.component('blog-section', require('./components/screen/Blog.vue').default);
Vue.component('book-appointment-section', require('./components/screen/BookAppointment.vue').default);
Vue.component('customer-reviews-section', require('./components/screen/CustomerReviews.vue').default);
Vue.component('become-consultant-section', require('./components/screen/BecomeConsultant.vue').default);
Vue.component('why-you-choose-section', require('./components/screen/WhyYouChoose.vue').default);
Vue.component('consultant-section', require('./components/screen/ConsultantTeam.vue').default);
Vue.component('top-guiders-section', require('./components/screen/TopGuiders.vue').default);
Vue.component('happy-clients-section', require('./components/screen/HappyClients.vue').default);
Vue.component('view-questions-section', require('./components/screen/ViewQuestion.vue').default);
Vue.component('dont-find-answer', require('./components/screen/DontFindAnswer.vue').default);
Vue.component('datetime', Datetime);
Vue.component('appointment-book', require('./components/AppointmentBook.vue').default);

const app = new Vue({
    el: '#app',
    i18n
});
