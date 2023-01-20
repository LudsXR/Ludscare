<?php

use App\Http\Controllers\Admin\AppointmentLogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\ContactUsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenteeController;
use App\Http\Controllers\Admin\MentorBankController;
use App\Http\Controllers\Admin\MentorCategoryController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\MentorDegreeController;
use App\Http\Controllers\Admin\MentorOccupationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolePermissionController;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Front\WebNotificationController;
use App\Http\Controllers\Admin\JazzcashMerchantController;
use App\Http\Controllers\Admin\EasypaisaMerchantController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\LedgerController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\WalletAdminController;
use App\Http\Controllers\Admin\WithDrawController;
use App\Http\Controllers\Front\EasypaisaController;
use App\Http\Controllers\Front\AppointmentBookingController;
use App\Http\Controllers\Front\SocialController;
use App\Http\Controllers\PaymentGateway\Paypal;
use App\Http\Controllers\PaymentGateway\Stripe;
use App\Http\Controllers\PaymentGateway\FlutterWave;
use App\Http\Controllers\PaymentGateway\Razorpay;
use App\Models\GeneralSetting;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TestinomialsController;
use App\Http\Controllers\Admin\TermsConditonsController;
use App\Http\Controllers\Front\WalletController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Social facebook Login
Route::get('auth/facebook', [SocialController::class, 'facebookRedirect']);
Route::get('auth/facebook/callback', [SocialController::class, 'loginWithFacebook']);
//Social Google Login

Route::get('auth/google', [SocialController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
//push notification
Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');
// Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');

Route::group(['middleware' => ['XssSanitizer']], function () {
    Route::get('/', function () {
        $url = URL::to('/');

        return view('welcome', compact('url'));
    });
    Route::get('/test', function () {
        $url = URL::to('/');
        return "working ";
    });


});


// Frontend routes
// Route::get('/', function () {
//     $url = URL::to('/');
//     return view('welcome', compact('url'));
// });
Route::get('/signup', function () {
    $url = URL::to('/');
    return view('signup',compact('url'));
});

Route::get('/login', function () {
    $url = URL::to('/');
    return view('login',compact('url'));
});

Route::get('/forgot-password', function () {
    $url = URL::to('/');
    return view('forgot-password',compact('url'));
});

Route::get('/reset-password/{token}', function ($token) {
    $url = URL::to('/');
    return view('reset-password',compact('url','token'));
})->name('reset.password.get');
Route::get('/appointment-schedule/{id}/{appointmentid?}', function ($id,$appointmentid=null)
{
  $url = URL::to('/');
  $mentor_id=$id;
  $routeLive=route('live',['','','']);
  $googleSiteKey = DB::table('settings')->where('name' , 'google_recapcha_site_key')->first();
  $googleSiteKey = $googleSiteKey->value;
  if($appointmentid){
          return view('appointment-schedule', compact('url', 'mentor_id', 'routeLive','appointmentid','googleSiteKey'));
      }
    return view('appointment-schedule',compact('url','mentor_id','routeLive','googleSiteKey'));
});
Route::get('/appointment-payment', function () {
    $url = URL::to('/');
    return view('appointment-payment',compact('url'));
});
Route::get('/wallet', function () {
    $url = URL::to('/');
    $routeLive=route('live',['','','']);
    $googleSiteKey = DB::table('settings')->where('name' , 'google_recapcha_site_key')->first();
    $googleSiteKey = $googleSiteKey->value;
    return view('wallet',compact('url','routeLive','googleSiteKey'));
});
Route::get('/mentor/appointment-log', function () {
    $url = URL::to('/');
    return view('appointment-log',compact('url'));
});
Route::get('/mentee/appointment-log', function () {
    $url = URL::to('/');
    return view('appointment-mentee-log',compact('url'));
});
Route::get('/mentor/appointment-log-detail/{appointment_id}', function ($appointment_id) {
    $url = URL::to('/');
    return view('appointment-log-detail',compact('url','appointment_id'));
});

Route::get('/mentee/appointment-log-detail/{appointment_id}', function ($appointment_id) {
    $url = URL::to('/');
    return view('appointment-mentee-log-detail',compact('url','appointment_id'));
});
Route::get('/categories', function () {
    $url = URL::to('/');
    return view('categories',compact('url'));
});
Route::get('/consultant-profile/{id}', function ($id) {
    $url = URL::to('/');
    return view('consultant-profile',compact('url','id'));
});
Route::get('/categories/{slug}', function ($slug) {
    $url = URL::to('/');
    $arSlug=explode(" ",$slug);
    $slug1=$arSlug[0];
    return view('consultant',compact('url','slug1'));
});
Route::get('/generate-schedule', function () {
    $url = URL::to('/');
    return view('generate-schedule',compact('url'));
});
Route::get('/audio-call', function () {
    $url = URL::to('/');
    return view('audio-call',compact('url'));
});
Route::get('/video-call', function () {
    $url = URL::to('/');
    return view('video-call',compact('url'));
});
Route::get('/live/{mentee_id}/{appointment_id}/{appointment_fee}', function ($mentee_id,$appointment_id,$appointment_fee) {
    $url = URL::to('/');
    return view('live-appointment',compact('url','mentee_id','appointment_id','appointment_fee'));
})->name('live');
Route::get('/live/appointment/payment/{appointment_id}/{appointment_fee}', function ($appointment_id,$appointment_fee) {
    $url = URL::to('/');
    return view('live-appointment-payment',compact('url','appointment_id','appointment_fee'));
})->name('live-payment');
Route::get('/mentor-profile', function () {
    $url = URL::to('/');
    return view('mentor-profile',compact('url'));
});
Route::get('/dashboard', function () {
    $url = URL::to('/');
    return view('dashboard',compact('url'));
});


Route::get('/mentee-profile', function () {
    $url = URL::to('/');
    return view('mentee-profile',compact('url'));
});

Route::get('/contact-us', function () {
    $url = URL::to('/');
    return view('contact-us',compact('url'));
});

Route::get('/about-us', function () {
    $url = URL::to('/');
    return view('about-us',compact('url'));
});

Route::get('/blog', function () {
    $url = URL::to('/');
    return view('blog',compact('url'));
});

Route::get('/blog-detail/{slug}', function ($slug) {
    $url = URL::to('/');
    return view('blog-detail',compact('url','slug'));
});

Route::get('/consultant/blogs', function () {
    $url = URL::to('/');
    return view('consultant-blog',compact('url'));
});
Route::get('/consultant/blog/{id}', function ($id) {
    $url = URL::to('/');
    return view('consultant-blog-edit',compact('url','id'));
});

//payment process paypal
Route::get('/processingPayment',[Paypal::class,'verifyPayment']);
//payment process stripe
Route::get('/processingPaymentStripe',[Stripe::class,'verifyPayment']);
//payment proccess razorpay
Route::get('/processingPaymentRazorpay',[Razorpay::class,'verifyPayment']);
//Admin login Routes
Route::get('admin/login', [LoginController::class, 'loginView'])->name('login.view');
Route::post('do/login', [LoginController::class, "doLogin"])->name('do.login');

Route::get('/payTm-order/{appointmentID}/{mobile_no}/{email}',[AppointmentBookingController::class,'payTmorder'])->name('paytm.order');
Route::post('/payTm-callback',[AppointmentBookingController::class,'payTmpaymentCallback']);

Route::get('/wallet-payTm-order/{amount}/{mobile_no}/{email}',[WalletController::class,'payTmorder'])->name('wallet.paytm.order');
Route::post('/wallet-payTm-callback',[WalletController::class,'payTmpaymentCallback']);
//Admin Auth
Route::middleware('auth')->group(function () {

    Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
        //create Admin User ->middleware('can:add-admin-user')
        Route::get('/create-user', [LoginController::class, 'createUser'])->name('createUser');
        Route::post('/save-user', [LoginController::class, 'saveUser'])->name('saveUser');
        //list Admin user
        Route::get('/list-user', [LoginController::class, 'listUser'])->name('listUser');
        //edit Admin User
        Route::get('/edit-user/{id}', [LoginController::class, 'editUser'])->name('editUser');
        //update Admin User
        Route::post('/update-user', [LoginController::class, 'updateUser'])->name('updateUser');
        //delete Admin user
        Route::get('/delete-user/{id}', [LoginController::class, 'deleteUser'])->name('deleteUser');
        //dashboard
        Route::get('dashboard', [DashboardController::class, "dashboard"])->name('dashboard');
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        //Route::get('mentor/profile',[])->name('mentor.profile');
        //newsletter List
        Route::get('/newsletter-list', [WithDrawController::class, 'newsletter_list'])->name('newsletter.list');


        // Route for Mentor Category

        Route::get('mentor/category/list', [MentorCategoryController::class, 'showMentorCategoryList'])->name('mentor.category.list');
        Route::get('mentor/category/add', [MentorCategoryController::class, 'addMentorCategory'])->name('mentor.category.add');
        Route::post('mentor/category/store', [MentorCategoryController::class, 'saveMentorCategory'])->name('mentor.category.store');
        Route::get('mentor/category/detail/{id}', [MentorCategoryController::class, 'mentorCategoryDetail'])->name('mentor.category.detail');
        Route::post('mentor/category/update/', [MentorCategoryController::class, 'mentorCategoryUpdate'])->name('mentor.category.update');
        Route::get('mentor/category/delete/{id}', [MentorCategoryController::class, 'mentorCategoryDelete'])->name('mentor.category.delete');


        // Route for Blog Category

        Route::get('blog/category/list', [BlogCategoryController::class, 'showBlogCategoryList'])->name('blog.category.list');
        Route::get('blog/category/add', [BlogCategoryController::class, 'addBlogCategory'])->name('blog.category.add');
        Route::post('blog/category/store', [BlogCategoryController::class, 'saveBlogCategory'])->name('blog.category.store');
        Route::get('blog/category/detail/{id}', [BlogCategoryController::class, 'blogCategoryDetail'])->name('blog.category.detail');
        Route::post('blog/category/update/', [BlogCategoryController::class, 'blogCategoryUpdate'])->name('blog.category.update');
        Route::get('blog/category/delete/{id}', [BlogCategoryController::class, 'blogCategoryDelete'])->name('blog.category.delete');


        // Route for Blog

        Route::get('blog/list', [BlogController::class, 'showBlogList'])->name('blog.list');
        Route::get('blog/add', [BlogController::class, 'addBlog'])->name('blog.add');
        Route::post('blog/store', [BlogController::class, 'saveBlog'])->name('blog.store');
        Route::get('blog/detail/{id}', [BlogController::class, 'blogDetail'])->name('blog.detail');
        Route::post('blog/update/', [BlogController::class, 'blogUpdate'])->name('blog.update');
        Route::get('blog/delete/{id}', [BlogController::class, 'blogDelete'])->name('blog.delete');

        // Route for PaymentGateway

        Route::get('payment/gateway/add', [PaymentMethodController::class, 'add'])->name('payment_gateway.add');
        Route::post('payment/gateway/store', [PaymentMethodController::class, 'store'])->name('payment_gateway.store');
        Route::get('payment/gateway/list', [PaymentMethodController::class, 'list'])->name('payment_gateway.list');
        Route::get('payment/gateway/edit/{id}', [PaymentMethodController::class, 'edit'])->name('payment_gateway.edit');

        Route::get('payment/gateway/status/{payment_method}', [PaymentMethodController::class, 'updateStatus'])->name('payment_gateway.status');
        Route::get('payment/gateway/setDefault/{payment_method}', [PaymentMethodController::class, 'setDefault'])->name('payment_gateway.setDefault');

        Route::post('payment/gateway/update', [PaymentMethodController::class, 'update'])->name('payment_gateway.update');
        Route::get('payment/gateway/delete/{id}', [PaymentMethodController::class, 'destroy'])->name('payment_gateway.delete');
        Route::get('payment/settings/add', [PaymentSettingsController::class, 'add'])->name('payment_settings.add');
        Route::post('payment/settings/store', [PaymentSettingsController::class, 'store'])->name('payment_settings.store');
        Route::get('payment/settings/list', [PaymentSettingsController::class, 'list'])->name('payment_settings.list');
        Route::get('payment/settings/edit/{id}', [PaymentSettingsController::class, 'edit'])->name('payment_settings.edit');
        Route::post('payment/settings/update', [PaymentSettingsController::class, 'update'])->name('payment_settings.update');


// Route for PaymentGateway

        Route::get('jazz/gateway/add', [JazzcashMerchantController::class, 'addPayment'])->name('jazz_gateway.add');
        Route::post('jazz/gateway/store', [JazzcashMerchantController::class, 'savePayment'])->name('jazz_gateway.store');
        Route::get('easypaisa/payment/gateway/add', [EasypaisaMerchantController::class, 'addPayment'])->name('easypaisa_payment_gateway.add');
        Route::post('easypaisa/payment/gateway/store', [EasypaisaMerchantController::class, 'savePayment'])->name('easypaisa_payment_gateway.store');
//Commission
        Route::get('commission/add',[CommissionController::class,'index'])->name('commission.add');
        Route::post('commission/store',[CommissionController::class,'store'])->name('commission.store');
        //General Settings
        Route::get('general/add',[GeneralSettingsController::class,'index'])->name('general.add');
        Route::post('general/store',[GeneralSettingsController::class,'store'])->name('general.store');

        // Route for Mentee list

        Route::get('mentee/list', [MenteeController::class, 'showMenteeList'])->name('mentee.list');
        Route::get('mentee/add', [MenteeController::class, 'addMentee'])->name('mentee.add');
        Route::post('mentee/store', [MenteeController::class, 'saveMentee'])->name('mentee.store');
        Route::get('mentee/detail/{id}', [MenteeController::class, 'menteeDetail'])->name('mentee.detail');
        Route::post('mentee/update/', [MenteeController::class, 'menteeUpdate'])->name('mentee.update');
        Route::get('mentee/delete/{id}', [MenteeController::class, 'menteeDelete'])->name('mentee.delete');
        //Route for Permission
        Route::get('permission/list', [PermissionController::class, 'index'])->name('permission.list');
        Route::get('permission/add', [PermissionController::class, 'add_view'])->name('permission.add');
        Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
        Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('permission/update', [PermissionController::class, 'update'])->name('permission.update');
        Route::get('permission/delete/{id}', [PermissionController::class, 'destory'])->name('permission.delete');
        //Route for Role
        Route::get('role/list', [RoleController::class, 'index'])->name('role.list');
        Route::get('role/add', [RoleController::class, 'add_view'])->name('role.add');
        Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('role/update', [RoleController::class, 'update'])->name('role.update');
        Route::get('role/delete/{id}', [RoleController::class, 'destory'])->name('role.delete');


        //Route for Role Permission Assigment
        Route::get('rolepermission/list', [RolePermissionController::class, 'index'])->name('rolepermission.list');
        Route::get('rolepermission/add', [RolePermissionController::class, 'add'])->name('rolepermission.add');
        Route::post('rolepermission/store', [RolePermissionController::class, 'store'])->name('rolepermission.store');
        Route::get('rolepermission/edit/{id}', [RolePermissionController::class, 'edit'])->name('rolepermission.edit');
        Route::post('rolepermission/update', [RolePermissionController::class, 'update'])->name('rolepermission.update');
        Route::get('rolepermission/delete/{id}', [RolePermissionController::class, 'destroy'])->name('rolepermission.delete');
        Route::get('rolepermission/test', [RolePermissionController::class, 'Permission'])->name('rolepermission.test');

        //Route for Role Permission Assigment
        Route::get('user-role/list', [UserRoleController::class, 'index'])->name('user.role.list');
        Route::get('user-role/add', [UserRoleController::class, 'add'])->name('user.role.add');
        Route::post('user-role/store', [UserRoleController::class, 'store'])->name('user.role.store');
        Route::get('user-role/edit/{id}', [UserRoleController::class, 'edit'])->name('user.role.edit');
        Route::post('user-role/update', [UserRoleController::class, 'update'])->name('user.role.update');
        Route::get('user-role/delete/{id}', [UserRoleController::class, 'destroy'])->name('user.role.delete');
        Route::get('user-role/test', [UserRoleController::class, 'Permission'])->name('user.role.test');

        // Route for Mentor list

        Route::get('mentor/pending/list', [MentorController::class, 'showPendingMentorList'])->name('mentor.pending.list');
        Route::get('mentor/approved/list', [MentorController::class, 'showAcceptedMentorList'])->name('mentor.approved.list');
        Route::get('mentor/rejected/list', [MentorController::class, 'showRejectedMentorList'])->name('mentor.rejected.list');
        //  Route::get('mentor/add', [MentorController::class, 'addMentee'])->name('mentor.add');
        //  Route::post('mentor/store', [MentorController::class, 'saveMentee'])->name('mentor.store');
        Route::get('mentor/detail/{id}', [MentorController::class, 'mentorDetail'])->name('mentor.detail');
        Route::get('mentor/status/update/{status}/{id}', [MentorController::class, 'mentorStatusUpdate'])->name('mentor.status.update');
        Route::post('mentor/update/', [MentorController::class, 'mentorUpdate'])->name('mentor.update');
        //make featured to mentor
        Route::post('mentor/update/feature', [MentorController::class, 'mentorFeatureUpdate'])->name('mentor.update.feature');

        Route::post('mentor/education/update/', [MentorController::class, 'mentorEducationUpdate'])->name('mentor.education.update');
        Route::post('mentor/experience/update/', [MentorController::class, 'mentorExperienceUpdate'])->name('mentor.experience.update');
        Route::post('mentor/skill/update/', [MentorController::class, 'mentorSkillUpdate'])->name('mentor.skill.update');
        Route::post('mentor/bank_detail/update/', [MentorController::class, 'mentorBankDetailUpdate'])->name('mentor.bank_detail.update');
        Route::get('mentor/add', [MentorController::class, 'addMentor'])->name('mentor.add');
        Route::post('mentor/store', [MentorController::class, 'saveMentor'])->name('mentor.store');
        //delete mentors
        Route::get('mentor/delete/{id}', [MentorController::class, 'mentorDelete'])->name('mentor.delete');

        //add mentor Eduaction
        Route::get('/mentor/education', [MentorController::class, 'mentorShowAddEducation'])->name('mentor.add.education');
        Route::post('/mentor/add-education/save', [MentorController::class, 'mentorAddEducation'])->name('mentor.add.education.save');
        //add mentor Experience
        Route::get('/mentor/experience', [MentorController::class, 'mentorShowAddExperience'])->name('mentor.add.experience');
        Route::post('/mentor/save/experience', [MentorController::class, 'mentorAddExperience'])->name('mentor.save.experience');
        // Route for Mentor Occupation list

        Route::get('mentor/occupation/list', [MentorOccupationController::class, 'showMentorOccupationList'])->name('mentor.occupation.list');
        Route::get('mentor/occupation/add', [MentorOccupationController::class, 'addMentorOccupation'])->name('mentor.occupation.add');
        Route::post('mentor/occupation/store', [MentorOccupationController::class, 'saveMentorOccupation'])->name('mentor.occupation.store');
        Route::get('mentor/occupation/detail/{id}', [MentorOccupationController::class, 'mentorOccupationDetail'])->name('mentor.occupation.detail');
        Route::post('mentor/occupation/update/', [MentorOccupationController::class, 'mentorOccupationUpdate'])->name('mentor.occupation.update');
        Route::get('mentor/occupation/delete/{id}', [MentorOccupationController::class, 'mentorOccupationDelete'])->name('mentor.occupation.delete');



        // Route for Mentor Degree list

        Route::get('mentor/degree/list', [MentorDegreeController::class, 'showMentorDegreeList'])->name('mentor.degree.list');
        Route::get('mentor/degree/add', [MentorDegreeController::class, 'addMentorDegree'])->name('mentor.degree.add');
        Route::post('mentor/degree/store', [MentorDegreeController::class, 'saveMentorDegree'])->name('mentor.degree.store');
        Route::get('mentor/degree/detail/{id}', [MentorDegreeController::class, 'mentorDegreeDetail'])->name('mentor.degree.detail');
        Route::post('mentor/degree/update/', [MentorDegreeController::class, 'mentorDegreeUpdate'])->name('mentor.degree.update');
        Route::get('mentor/degree/delete/{id}', [MentorDegreeController::class, 'mentorDegreeDelete'])->name('mentor.degree.delete');


        // Route for Mentor Degree list

        Route::get('mentor/bank/list', [MentorBankController::class, 'showMentorbankList'])->name('mentor.bank.list');
        Route::get('mentor/bank/add', [MentorBankController::class, 'addMentorbank'])->name('mentor.bank.add');
        Route::post('mentor/bank/store', [MentorBankController::class, 'saveMentorbank'])->name('mentor.bank.store');
        Route::get('mentor/bank/detail/{id}', [MentorBankController::class, 'mentorbankDetail'])->name('mentor.bank.detail');
        Route::post('mentor/bank/update/', [MentorBankController::class, 'mentorbankUpdate'])->name('mentor.bank.update');
        Route::get('mentor/bank/delete/{id}', [MentorBankController::class, 'mentorbankDelete'])->name('mentor.bank.delete');

        //Appointment Logs
        Route::get('/appointment-log', [AppointmentLogController::class, 'getAppointmentLog'])->name('appointment.log');
        //contact us List
        Route::get('/contact-us-list', [ContactUsController::class, 'list']);
        //ledeger
        //mentee ledger
        Route::get('/mentee-list', [LedgerController::class, 'mentee_list'])->name('mentee-list');
        //mentee Appointments List
        Route::get('/mentee-appointments/{id}', [LedgerController::class, 'mentee_appointments'])->name('mentee-appointments');
        //mentor ledger
        Route::get('/mentor-list', [LedgerController::class, 'mentor_list'])->name('mentor-list');
        //mentor Appointments List
        Route::get('/mentor-appointments/{id}', [LedgerController::class, 'mentor_appointments'])->name('mentor-appointments');
        //refund to Mentee
        Route::get('/mentee-refund/{id}/{payment}/{appointment_id}', [LedgerController::class, 'mentee_refund'])->name('mentee-refund');
        //withdraw request
        Route::get('/withdraw-list', [WithDrawController::class, 'withdraw_list']);
        //Approve or paid withdraw Request
        Route::get('/paid-withdraw/{id}', [WithDrawController::class, 'paid_withdraw'])->name('paid-withdraw');
        //wallet for admin
        Route::get('/wallet-admin',[WalletAdminController::class,'index'])->name('wallet-admin');

        //Settings Route

      Route::get('notification_settings/list', [SettingsController::class, 'notificationSettings'])->name('notification_settings.list');
      Route::post('notification_settings/update', [SettingsController::class, 'updateNotificationSettings'])->name('notification_settings.update');

      //Testinomials Crud Routes
      Route::get('testinomials/list', [TestinomialsController::class, 'index'])->name('testinomials.list');
      Route::get('testinomials/add', [TestinomialsController::class, 'addTestinomial'])->name('testinomials.add');
      Route::post('testinomials/store', [TestinomialsController::class, 'store'])->name('testinomials.store');
      Route::get('testinomials/detail/{id}', [TestinomialsController::class, 'show'])->name('testinomials.detail');
      Route::post('testinomials/update/', [TestinomialsController::class, 'update'])->name('testinomials.update');
      Route::get('testinomials/delete/{id}', [TestinomialsController::class, 'destory'])->name('testinomials.delete');


        //Terms and Conditions
        Route::get('terms_conditions/list', [TermsConditonsController::class, 'index'])->name('terms_conditions.list');
        Route::post('terms_conditions/store', [TermsConditonsController::class, 'store'])->name('terms_conditions.update');

    });
});


//For Appointment Booking EasyPaisa Payment
Route::get('/easypaisa', [EasypaisaController::class, 'makeEasyPaisaPaymentHash']);
Route::get('/easypaisa-after-payment', [EasypaisaController::class, 'easypaisaAfterpayment']);
//For Wallet Deposit using Easypaisa Payment
Route::get('/easypaisa-wallet', [EasypaisaController::class, 'makeEasyPaisaPaymentHashForWallet']);
Route::get('/easypaisa-after-payment-wallet', [EasypaisaController::class, 'easypaisaAfterpaymentForWallet']);

Route::get('/clear-cache', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('clear-compiled');
    return "Cache Cleared";
});

Route::get('/completed-appointment-invoice/{appointment_id}', [AppointmentBookingController::class, 'completedAppointmentInvoice']);


Route::get('/pay', [FlutterWave::class, 'initialize'])->name('pay');
// The callback url after a payment
Route::get('/rave/callback', [FlutterWave::class, 'callback'])->name('callback');
