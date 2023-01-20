@extends('new_admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Consultant Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.mentor.approved.list') }}"> Consultant
                                Approved List</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <section class="content">
        <div class="container-fluid">
                <input type="hidden" id="mentor_id"/>

                <!-- Setups Form-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Consultant</h3>
                            </div>
                            <div class="card-body p-md-0 p-3">
                                <div class="bs-stepper linear">
                                    <div class="bs-stepper-header flex-md-nowrap flex-wrap justify-content-center" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step active" data-target="#personal-info">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="personal-info" id="personal-info-trigger"
                                                aria-selected="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Personal Info</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#skills">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="skills" id="skills-trigger" aria-selected="false"
                                                disabled="disabled">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Skills</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#bank-info">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="bank-info" id="bank-info-trigger" aria-selected="false"
                                                disabled="disabled">
                                                <span class="bs-stepper-circle">3</span>
                                                <span class="bs-stepper-label">Bank Account Details</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#education-info">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="education-info" id="education-info-trigger"
                                                aria-selected="false" disabled="disabled">
                                                <span class="bs-stepper-circle">4</span>
                                                <span class="bs-stepper-label">Education</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#experience-info">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="experience-info" id="experience-info-trigger"
                                                aria-selected="false" disabled="disabled">
                                                <span class="bs-stepper-circle">5</span>
                                                <span class="bs-stepper-label">Experience</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="personal-info" class="content active dstepper-block" role="tabpanel"
                                            aria-labelledby="personal-info-trigger">

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input type="text" class="form-control" name="first_name"
                                                                placeholder="Enter First Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input type="text" class="form-control" name="last_name"
                                                                placeholder="Enter Last Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Father Name</label>
                                                            <input type="text" class="form-control" name="father_name"
                                                                placeholder="Enter Father Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" autocomplete="off" name="email"
                                                                placeholder="Enter Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input type="password" class="form-control" autocomplete="off" name="password"
                                                                placeholder="Enter Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>CNIC</label>
                                                            <input type="text" class="form-control" name="cnic"
                                                                placeholder="Enter CNIC">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                placeholder="Enter Phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>DOB</label>
                                                            <input type="date" class="form-control" id="birthday"
                                                                name="dob">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Gender</label>
                                                            <select aria-label="Default select example" name="gender"
                                                                class="form-control">
                                                                <option value="" selected="selected">
                                                                    Select Gender
                                                                </option>
                                                                <option value="male">
                                                                    Male
                                                                </option>
                                                                <option value="female">
                                                                    Female
                                                                </option>
                                                                <option value="other">
                                                                    Other
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Occupation</label>
                                                            <select aria-label="Default select example" name="occupation"
                                                                class="form-control">
                                                                <option value="" selected="selected">
                                                                    Select Occupation
                                                                </option>
                                                                @foreach ($occupations as $occupation)
                                                                    <option value="{{ $occupation->id }}">
                                                                        {{ $occupation->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Religion</label>
                                                            <select aria-label="Default select example"
                                                                name="religion"class="form-control">
                                                                <option value="" selected="selected">
                                                                    Select Religion
                                                                </option>
                                                                <option value="islam">Islam</option>
                                                                <option value="christian">Christian</option>
                                                                <option value="hindu">Hindu</option>
                                                                <option value="sikh">Sikh</option>
                                                                <option value="jew">Jew</option>
                                                                <option value="buddist">Buddhist</option>
                                                                <option value="other">Others</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <select class="form-control" name="country" id="country">
                                                                <option value=""> Select Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}">
                                                                        {{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <input type="text" class="form-control" name="city"
                                                                placeholder="Enter City">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" class="form-control" name="address"
                                                                placeholder="Enter Address">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Postal Code</label>
                                                            <input type="number" class="form-control" name="postal_code"
                                                                placeholder="Enter Postal Code">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>Profile Image</label>
                                                            <input type="file" accept="image/*"  onchange="openFile(this)" id="img"
                                                                class="form-control h-100 " name="image">
                                                        </div>
                                                        <div class="image_preview mb-3">

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label>About Consultant</label>
                                                                <textarea name="about" placeholder="Enter About for Consultant" class="form-control"  cols="30" rows="5"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <button class="btn btn-primary" onclick="stepper.next()">Next</button> -->
                                                <button class="btn btn-primary" onclick="saveMentor()">Save & Contunue</button>

                                            </div>
                                        </div>
                                        <div id="skills" class="content" role="tabpanel"
                                            aria-labelledby="skills-trigger">


                                            <div class="form-group">
                                                <label>Parent Category</label>
                                                <select class="form-control" name="categories[]" id="parent_category">
                                                    <option value=""> Choose Parent Category</option>
                                                    @foreach ($mentor_parent_categories as $parent_category)
                                                        <option value="{{ $parent_category->id }}">
                                                            {{ $parent_category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>SubCategory</label>
                                                <select class="form-control" name="categories[]" id="sub_category">
                                                    <option value="">Choose SubCategory</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>SubCategory</label>
                                                <select class="form-control" name="categories[]" id="child_sub_category">
                                                    <option value="">Choose Child SubCategory</option>
                                                </select>
                                            </div>


                                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                            <button class="btn btn-primary" onclick="saveSkills(true)">Next</button>
                                            <button class="btn btn-success" onclick="saveSkills(false)">save</button>

                                        </div>
                                        <div id="bank-info" class="content" role="tabpanel"
                                            aria-labelledby="bank-info-trigger">
                                            <div class="col-lg-12 px-0">
                                                <div class="card shadow-none">
                                                    <div class="card-body p-0">
                                                        <div class="row">
                                                        <div class="form-group col-md-6 ps-0">
                                                            <label>Account Holder Name</label>
                                                            <input type="text" class="form-control"
                                                                name="account_title" placeholder="Enter Account Title">
                                                        </div>
                                                        <div class="form-group col-md-6 ps-0">
                                                            <label>Account Number</label>
                                                            <input type="text" class="form-control"
                                                                name="account_number" placeholder="Enter Account Number">
                                                        </div>
                                                        <div class="form-group col-md-6 ps-0">
                                                            <label>Bank</label>
                                                            <select name="bank" class="form-control" id="">
                                                                <option value=""> Select Bank</option>
                                                                @foreach ($banks as $bank)
                                                                    <option value="{{ $bank->name }}">
                                                                        {{ $bank->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                            <button class="btn btn-primary" onclick="saveBank(true)">Next</button>
                                            <button class="btn btn-success" onclick="saveBank(false)">Save</button>

                                        </div>
                                        <div id="education-info" class="content" role="tabpanel"
                                            aria-labelledby="education-info-trigger">
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Institute</label>
                                                        <input type="text" class="form-control" name="institute"
                                                            placeholder="Enter Institute">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Degree</label>
                                                        <input type="text" class="form-control" required
                                                            name="degree" placeholder="Enter degree">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <input type="text" class="form-control" name="subject"
                                                            placeholder="Enter subject">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Period</label>
                                                        <input type="text" class="form-control h-50" name="period"
                                                            placeholder="Enter period">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Education Image</label>
                                                        <input type="file"   onchange="openFile(this)" class="form-control h-50" name="image">
                                                    </div>
                                                    <div class="image_preview mb-3">

                                                    </div>
                                                </div>

                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                            <button class="btn btn-primary" onclick="saveEducation(true)">Next</button>
                                            <button class="btn btn-success" onclick="saveEducation(false)">Save</button>

                                        </div>
                                        <div id="experience-info" class="content" role="tabpanel"
                                            aria-labelledby="experience-info-trigger">
                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Company</label>
                                                        <input required type="text" class="form-control" required
                                                            name="company" placeholder="Enter company">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>From</label>
                                                        <input type="date" class="form-control" name="from"
                                                            placeholder="Enter from">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>To</label>
                                                        <input type="date" class="form-control" name="to"
                                                            placeholder="Enter to">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Experience Image</label>
                                                        <input type="file"  onchange="openFile(this)" class="form-control h-50" name="image">
                                                    </div>
                                                    <div class="image_preview mb-3">

                                                    </div>
                                                </div>

                                            </div>
                                            <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                            <button class="btn btn-success" onclick="saveExperience()">Save</button>

                                            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">

                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>

    </section>
@endsection
@section('footer_script')
    <script>
        var base_url = "<?php echo URL::to('/'); ?>";
        var stepperElement = document.querySelector('.bs-stepper')
        var stepper = new Stepper(stepperElement)



        var currentIndex = stepper._currentIndex;

        stepperElement.addEventListener('shown.bs-stepper', function(event) {
        });

        function saveMentor(){
            var formData = new FormData()
            var first_name = $('#personal-info input[name="first_name"]').val();
                var last_name = $('#personal-info input[name="last_name"]').val();
                var email = $('#personal-info input[name="email"]').val();
                var password = $('#personal-info input[name="password"]').val();
                var cnic = $('#personal-info input[name="cnic"]').val();
                var phone = $('#personal-info input[name="phone"]').val();
                var dob = $('#personal-info input[name="dob"]').val();
                var gender = $('#personal-info select[name="gender"] option:selected').val();
                var occupation = $('#personal-info select[name="occupation"] option:selected').val();
                var religion = $('#personal-info select[name="religion"] option:selected').val();
                var country = $('#personal-info select[name="country"] option:selected').val();
                var city = $('#personal-info input[name="city"]').val();
                var address = $('#personal-info input[name="address"]').val();
                var postal_code = $('#personal-info input[name="postal_code"]').val();
                var about = $('#personal-info textarea[name="about"]').val();
                var img = $('#personal-info input[name="image"]')[0].files[0];
                  // $( "#img_preview" ).each(function( index ) {
                  //     $( this ).attr("src"," ");
                  //     });
                  $('*[id*=img_preview]').each(function( index ) {
                            $( this ).attr("src"," ");
                  });
                     formData.append('first_name', first_name);
                     formData.append('last_name', last_name);
                     formData.append('email', email);
                     formData.append('password', password);

                     formData.append('cnic', cnic);

                     formData.append('phone', phone);

                     formData.append('dob', dob);
                     formData.append('gender', gender);
                     formData.append('occupation', occupation);
                     formData.append('religion', religion);
                     formData.append('country', country);
                     formData.append('city', city);

                     formData.append('address', address);
                     formData.append('postal_code', postal_code);
                     formData.append('about', about);
                     formData.append('image', img);




                $.ajax({
                    url: base_url + '/api/store-mentor',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.msg){
                            var id=data.mentor_id;
                           $('#mentor_id').val(id);
                            stepper.next();
                            toastr.info(data.msg)
                        }
                        else{

                            for (const property in data.errors) {
                                toastr.error(data.errors[property][0]);
                            }

                        }



                    },
                    error:function(error){
                        toastr.error(error);
                    }
                });
        }
        function saveSkills(is_next){
            var next=is_next;
            var formData = new FormData();
            var mentor_id=$('#mentor_id').val();
            var parent_category = $('#parent_category option:selected').val();
            var sub_category = $('#sub_category option:selected').val();
            var child_sub_category = $('#child_sub_category option:selected').val();
            var categories=[parent_category,sub_category,child_sub_category];
            formData.append('categories',categories);
            formData.append('mentor_id',mentor_id);
            $('*[id*=img_preview]').each(function( index ) {
                      $( this ).attr("src"," ");
            });
            $.ajax({
                    url: base_url + '/api/store-skills',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.msg){
                          if(next){
                            stepper.next();
                          }
                            toastr.info(data.msg)
                        }

                        else{

                            for (const property in data.errors) {
                                toastr.error(data.errors[property][0]);
                            }

                        }


                        stepper.next();
                    },
                    error:function(error){
                        toastr.error(error);
                    }
                });
        }
        function saveBank(is_next){
            var next=is_next;
            var formData = new FormData();
            var mentor_id=$('#mentor_id').val();
            var bank = $('#bank-info select[name="bank"] option:selected').val();
            var account_number = $('#bank-info input[name="account_number"]').val();
            var account_title = $('#bank-info input[name="account_title"]').val();
            formData.append('bank',bank);
            formData.append('account_number',account_number);
            formData.append('account_title',account_title);
            formData.append('mentor_id',mentor_id);
            $('*[id*=img_preview]').each(function( index ) {
                      $( this ).attr("src"," ");
            });
            $.ajax({
                    url: base_url + '/api/store-bank',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.msg){
                          if(next){
                            stepper.next();
                          }
                            toastr.info(data.msg)
                        }

                        else{

                            for (const property in data.errors) {
                                toastr.error(data.errors[property][0]);
                            }

                        }



                    },
                    error:function(error){
                        toastr.error(error);
                    }
                });
        }
        function saveEducation(is_next){
            var next=is_next;
            var formData = new FormData()
            var mentor_id=$('#mentor_id').val();
            var institute = $('#education-info input[name="institute"]').val();
                var degree = $('#education-info input[name="degree"]').val();
                var subject = $('#education-info input[name="subject"]').val();
                var period = $('#education-info input[name="period"]').val();
                $('*[id*=img_preview]').each(function( index ) {
                          $( this ).attr("src"," ");
                });
                var image = $('#education-info input[name="image"]')[0].files[0];

                     formData.append('degree', degree);

                     formData.append('subject', subject);
                     formData.append('period', period);
                     formData.append('image', image);

                     formData.append('mentor_id',mentor_id)


                $.ajax({
                    url: base_url + '/api/store-education',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.msg){
                          if(next){
                            stepper.next();
                          }
                        }

                        else{

                            for (const property in data.errors) {
                                toastr.error(data.errors[property][0]);
                            }

                        }



                    },
                    error:function(error){
                        toastr.error(error);
                    }
                });
        }
        function saveExperience(){
            var formData = new FormData()
            var mentor_id=$('#mentor_id').val();
            var company = $('#experience-info input[name="company"]').val();
                var from = $('#experience-info input[name="from"]').val();
                var to = $('#experience-info input[name="to"]').val();
                var image = $('#experience-info input[name="image"]')[0].files[0];

                     formData.append('company', company);

                     formData.append('from', from);
                     formData.append('to', to);
                     formData.append('image', image);

                     formData.append('mentor_id',mentor_id)

                $.ajax({
                    url: base_url + '/api/store-experience',
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if(data.msg){
                            window.location.href = "{{route('admin.mentor.pending.list')}}"
                            toastr.info(data.msg);
                            stepper.next();
                        }
                        else{

                            for (const property in data.errors) {
                                toastr.error(data.errors[property][0]);
                            }

                        }



                    },
                    error:function(error){
                        toastr.error(error);
                    }
                });
        }
        $('#parent_category').on('change', function() {
            var parent_category_id = $(this).val();

            if (parent_category_id) {
                $.ajax({
                    url: base_url + '/api/mentorChildCategoriesList',
                    type: "GET",
                    data: {
                        "token": "123",
                        parent_id: parent_category_id
                    },
                    dataType: "json",
                    success: function(data) {
                        var sub_category_select = $('#sub_category');
                        if (data) {

                            sub_category_select.empty();
                            sub_category_select.append('<option value="">Choose SubCategory</option>');
                            $.each(data.data.mentorCategories, function(key, sub_category) {
                                sub_category_select.append('<option value="' + sub_category.id +
                                    '">' + sub_category.name + '</option>');
                            });
                        } else {
                            sub_category.empty();
                        }
                    }
                });
            } else {
                $('#sub_category').empty();
            }
        });

        $('#sub_category').on('change', function() {
            var parent_category_id = $(this).val();
            var base_url = "<?php echo URL::to('/'); ?>";
            if (parent_category_id) {
                $.ajax({
                    url: base_url + '/api/mentorChildCategoriesList',
                    type: "GET",
                    data: {
                        "token": "123",
                        parent_id: parent_category_id
                    },
                    dataType: "json",
                    success: function(data) {
                        var child_sub_category = $('#child_sub_category');
                        if (data) {
                            child_sub_category.empty();
                            child_sub_category.append(
                                '<option value="">Choose Child SubCategory</option>');
                            $.each(data.data.mentorCategories, function(key, sub_category) {
                                child_sub_category.append('<option value="' + sub_category.id +
                                    '">' + sub_category.name + '</option>');
                            });
                        } else {
                            child_sub_category.empty();
                        }
                    }
                });
            } else {
                $('#sub_category').empty();
            }
        });
        // var stepper = new Stepper($('.bs-stepper'))
    </script>
@endsection
