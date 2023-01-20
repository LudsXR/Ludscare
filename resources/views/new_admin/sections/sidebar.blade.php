@php
   $general_settings= DB::table('general_setting')->find(1);

@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{$general_settings->logo }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
<br>
      <div class="brand-text font-weight-bold pl-3 pt-3"></div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> --}}
          @permission('add-admin-user')
          <li class="nav-item">
            <a href="{{route('admin.listUser')}}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Admin Users
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          @permission('add-admin-user')
          <li class="nav-item">
            <a href="{{route('admin.wallet-admin')}}" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              <p>
                Admin Wallet
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Access Control
                <i class="fas fa-angle-left right"></i>
                {{-- <span class="badge badge-info right">6</span> --}}
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a  href="{{route('admin.role.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.user.role.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Roles</p>
                </a>
              </li>
              <li class="nav-item">

                <a href="{{route('admin.permission.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
              <li class="nav-item">

                <a href="{{route('admin.rolepermission.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role Permissions</p>
                </a>
              </li>

            </ul>
          </li>
          @permission('mentor-category')
          <li class="nav-item">
            <a href="{{route('admin.mentor.category.list')}}" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>
                Consultant Categories
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          @permission('mentor')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Consultants
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @permission('pending-mentor')
              <li class="nav-item">
                <a href="{{route('admin.mentor.pending.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending Consultant</p>
                </a>
              </li>
              @endpermission
              @permission('approved-mentor')
              <li class="nav-item">
                <a href="{{route('admin.mentor.approved.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Approved Consultant</p>
                </a>
              </li>
              @endpermission
              @permission('rejected-mentor')
              <li class="nav-item">
                <a href="{{route('admin.mentor.rejected.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Rejected Consultant</p>
                </a>
              </li>

              @endpermission
              @permission('add-mentor')
              <li class="nav-item">

                <a href="{{route('admin.mentor.add')}}"class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Consultant</p>
                </a>
              </li>
              @endpermission

            </ul>
          </li>
          @endpermission
          @permission('mentor-occupation')
          <li class="nav-item">
            <a href="{{route('admin.mentor.occupation.list')}}" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Consultant Occupation
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          @permission('mentor-degree')
          <li class="nav-item">
            <a href="{{route('admin.mentor.degree.list')}}" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>
                Consultant Degree
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          @permission('mentor-bank-list')
          <li class="nav-item">
            <a href="{{route('admin.mentor.bank.list')}}" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Consultant Bank
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          @permission('mentee-list')
          <li class="nav-item">
            <a href="{{route('admin.mentee.list')}}" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                User List
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
          </li>
          @endpermission
          <li class="nav-item">
            <a href="{{route('admin.newsletter.list')}}" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Newsletter List
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
        </li>
        @permission('appointment-logs')
        <li class="nav-item">
            <a href="{{url('admin/appointment-log')}}" class="nav-link">
              <i class="nav-icon fas fa-clock"></i>
              <p>
                Appointment Logs
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
        </li>
        @endpermission
        @permission('contact-us-list')
        <li class="nav-item">
            <a href="{{url('admin/contact-us-list')}}" class="nav-link">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Contact Us List
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
        </li>
        @endpermission
        @permission('withdraw-request-list')
        <li class="nav-item">
            <a href="{{url('admin/withdraw-list')}}"class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                WithDraw Request List
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
        </li>
        @endpermission

        @permission('testimonial')
        <li class="nav-item">
            <a href="{{route('admin.testinomials.list')}}"class="nav-link">
              <i class="nav-icon fas fa-comment-dots"></i>
              <p>
                Testimonials
              </p>
            </a>
        </li>
        @endpermission
        @permission('terms_conditions')
        <li class="nav-item">
            <a href="{{route('admin.terms_conditions.list')}}"class="nav-link">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Terms & Conditions
              </p>
            </a>
        </li>
        @endpermission

        @permission('blogs')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-marker"></i>
              <p>
                Blogs
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @permission('add-blogs')
              <li class="nav-item">
                <a href="{{route('admin.blog.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blog Posts</p>
                </a>
              </li>
              @endpermission
              @permission('add-blog-category')
              <li class="nav-item">
                <a href="{{route('admin.blog.category.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>
              @endpermission

            </ul>
          </li>
          @endpermission
          @permission('payment-configuration')
           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @permission('payment-configuration')
              <li class="nav-item">
                <a href="{{route('admin.payment_gateway.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Payment Methods</p>
                </a>
              </li>
                  @endpermission
                @permission('notification-settings')
              <li class="nav-item">
                <a href="{{route('admin.notification_settings.list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notifications</p>
                </a>
              </li>
                @endpermission
              <li class="nav-item">
                <a href="{{route('admin.general.add')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    General Settings
                    {{-- <span class="right badge badge-danger">New</span> --}}
                  </p>
                </a>
            </li>

            <!-- @permission('add-easypaisa')
              <li class="nav-item">
                <a href="{{route('admin.easypaisa_payment_gateway.add')}}"class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> EasyPaisa</p>
                </a>
              </li>
              @endpermission
              @permission('add-jazzcash')
              <li class="nav-item">
                <a href="{{route('admin.jazz_gateway.add')}}"class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p> JazzCash</p>
                </a>
              </li>
              @endpermission -->

            </ul>
          </li>
          @endpermission
          @permission('appointment-ledger')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>
                Appointment Ledger
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                @permission('mentee-appointment-ledger')

              <li class="nav-item">
                <a  href="{{route('admin.mentee-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Appointment Ledger </p>
                </a>
              </li>
              @endpermission
              @permission('mentor-appoitment-ledger')

              <li class="nav-item">
                <a href="{{route('admin.mentor-list')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>  Consultant Appointment Ledger</p>
                </a>
              </li>
              @endpermission


            </ul>
          </li>
          @endpermission


        <li class="nav-item mb-5">
            <a href="{{route('admin.commission.add')}}" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Commission Setup
                {{-- <span class="right badge badge-danger">New</span> --}}
              </p>
            </a>
        </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <style>
    .nav-treeview .nav-icon{
        width: 12px !important;
    }
    .fa-circle{
        font-size: 12px !important;
    }

    .brand-link .brand-image {
    max-height: 47px;
    }
  </style>
