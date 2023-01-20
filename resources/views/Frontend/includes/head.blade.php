<!DOCTYPE html>
<html lang="en">

<head>
    <title>Consultant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="{{ asset('assets/intel/css/intlTelInput.css') }}">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('assets/intel/js/intlTelInput.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js" crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_maps_api_key')}}&libraries=places">
    </script>

    <script>

        const firebaseConfig = {
            apiKey: {{'`' . config('services.firebase.api_key') . '`'}},
            authDomain: {{'`' . config('services.firebase.auth_domain') . '`'}},
            projectId: {{'`' . config('services.firebase.project_id') . '`'}},
            storageBucket: {{'`' . config('services.firebase.storage_bucket') . '`'}},
            messagingSenderId: {{'`' . config('services.firebase.messaging_sender_id') . '`'}},
            appId: {{'`' . config('services.firebase.app_id') . '`'}},
            measurementId: {{'`' . config('services.firebase.measurement_id') . '`'}}
            };
        firebase.initializeApp(firebaseConfig);

        if (localStorage.getItem('User') != null) {

            var navigator_info = window.navigator;
            var screen_info = window.screen;
            var uid = navigator_info.mimeTypes.length;
            uid += navigator_info.userAgent.replace(/\D+/g, '');
            uid += navigator_info.plugins.length;
            uid += screen_info.height || '';
            uid += screen_info.width || '';
            uid += screen_info.pixelDepth || '';
            var user = JSON.parse(localStorage.getItem('User'));
            const messaging = firebase.messaging();

            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajax({
                        url: '{{ route('store.token') }}',
                        type: 'POST',
                        data: {
                            fcm_token: response,
                            token: 123,
                            device_id: uid+user.user_id,
                            user_id: user.user_id


                        },
                        dataType: 'JSON',
                        success: function(response) {
                        },
                        error: function(error) {
                        },
                    });

                }).catch(function(error) {
                    alert(error);
                });
            messaging.onMessage(function(payload) {
                const title = payload.notification.title;
                const options = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(title, options);

            });
        }


    </script>
</head>
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="" src="{{ asset('assets/images/loader.gif') }}" alt="AdminLTELogo" height="120" width="120">
</div>
<style>
    body {
  overflow-y: hidden;
}
    .preloader {
        display: flex;
        background-color: #f4f6f9;
        height: 100vh;
        width: 100%;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 9999;

    }
</style>
<script>
    //Preloader
    $(window).on('load', function() { // makes sure the whole site is loaded
        $('#status').fadeOut(); // will first fade out the loading animation
        $('.preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(100).css({
            'overflow': 'visible'
        });
    })
</script>


<body>
