
<script src="{{ mix('/js/app.js') }}"></script>
{{-- <script src="https://code.jquery.com/jquery-latest.min.js"></script> --}}

<script>
     // Vanilla Javascript
var mentor_tel = document.querySelector("#mentor_tel");
var mentee_tel = document.querySelector("#mentee_tel");
window.intlTelInput(mentee_tel,({
    initialCountry: "pk",
        separateDialCode: true
}));

window.intlTelInput(mentor_tel,({
    initialCountry: "pk",
        separateDialCode: true
}));



</script>
</body>
</html>
