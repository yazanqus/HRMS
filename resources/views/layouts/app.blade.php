{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Material Dashboard Laravel - Free Frontend Preset for Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.page_templates.auth')
        @endauth
        @guest()
            @include('layouts.page_templates.guest')
        @endguest
        @if (auth()->check())
        <div class="fixed-plugin">
          <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
              <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
              <li class="header-title"> Sidebar Filters</li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                  <div class="badge-colors ml-auto mr-auto">
                    <span class="badge filter badge-purple " data-color="purple"></span>
                    <span class="badge filter badge-azure" data-color="azure"></span>
                    <span class="badge filter badge-green" data-color="green"></span>
                    <span class="badge filter badge-warning active" data-color="orange"></span>
                    <span class="badge filter badge-danger" data-color="danger"></span>
                    <span class="badge filter badge-rose" data-color="rose"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="header-title">Images</li>
              <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-1.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-2.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-3.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-4.jpg" alt="">
                </a>
              </li>
              <li class="button-container">
                <a href="https://www.creative-tim.com/product/material-dashboard-laravel" target="_blank" class="btn btn-primary btn-block">Free Download</a>
              </li>
              <!-- <li class="header-title">Want more components?</li>
                  <li class="button-container">
                      <a href="https://www.creative-tim.com/product/material-dashboard-pro" target="_blank" class="btn btn-warning btn-block">
                        Get the pro version
                      </a>
                  </li> -->
              <li class="button-container">
                <a href="https://material-dashboard-laravel.creative-tim.com/docs/getting-started/laravel-setup.html" target="_blank" class="btn btn-default btn-block">
                  View Documentation
                </a>
              </li>
              <li class="button-container">
                <a href="https://www.creative-tim.com/product/material-dashboard-pro-laravel" target="_blank" class="btn btn-danger btn-block btn-round">
                  Upgrade to PRO
                </a>
              </li>
              <li class="button-container github-star">
                <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard-laravel" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star ntkme/github-buttons on GitHub">Star</a>
              </li>
              <li class="header-title">Thank you for 95 shares!</li>
              {{-- <li class="button-container text-center">
                <button id="twitter" class="btn btn-round btn-twitter"><i class="fa fa-twitter"></i> &middot; 45</button>
                <button id="facebook" class="btn btn-round btn-facebook"><i class="fa fa-facebook-f"></i> &middot; 50</button>
                <br>
                <br>
              </li> --}}
            {{-- </ul>
          </div>
        </div>
        @endif --}}
        <!--   Core JS Files   -->

        {{-- @stack('js')
    </body>
</html> --}}


<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HRMS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">

  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth
    {{-- @include('layouts.page_templates.auth')
@endauth --}}
@guest()
    @include('layouts.page_templates.guest')
@endguest
@auth

<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
<!-- Left navbar links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
  </li>
  {{-- <li class="nav-item d-none d-sm-inline-block">
    <a href="index3.html" class="nav-link">Home</a>
  </li>
  <li class="nav-item d-none d-sm-inline-block">
    <a href="#" class="nav-link">Contact</a>
  </li> --}}
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
  <!-- Navbar Search -->
  <li class="nav-item">
    <a class="nav-link" href="{{ route('welcome') }}">
        <i class="fas fa-language fa-lg"></i>
      {{-- <p class="d-lg-none d-md-block">
        {{ __('Stats') }}
      </p> --}}
    </a>
  </li>
  {{-- <li class="nav-item">
    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
      <i class="fas fa-search"></i>
    </a>
    <div class="navbar-search-block">
      <form class="form-inline">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
      </form>
    </div>
  </li> --}}

  <!-- Messages Dropdown Menu -->
  {{-- <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-comments"></i>
      <span class="badge badge-danger navbar-badge">3</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              Brad Diesel
              <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm">Call me whenever you can...</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              John Pierce
              <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm">I got your message bro</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
          <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
          <div class="media-body">
            <h3 class="dropdown-item-title">
              Nora Silvester
              <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
            </h3>
            <p class="text-sm">The subject goes here</p>
            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
          </div>
        </div>
        <!-- Message End -->
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
    </div>
  </li> --}}
  <!-- Notifications Dropdown Menu -->
  {{-- <li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
      <i class="far fa-bell"></i>
      <span class="badge badge-warning navbar-badge">15</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      <span class="dropdown-header">15 Notifications</span>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i> 4 new messages
        <span class="float-right text-muted text-sm">3 mins</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-users mr-2"></i> 8 friend requests
        <span class="float-right text-muted text-sm">12 hours</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item">
        <i class="fas fa-file mr-2"></i> 3 new reports
        <span class="float-right text-muted text-sm">2 days</span>
      </a>
      <div class="dropdown-divider"></div>
      <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
  </li> --}}
  {{-- <li class="nav-item">
    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
      <i class="fas fa-expand-arrows-alt"></i>
    </a>
  </li> --}}
  {{-- <li class="nav-item">
    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
      <i class="fas fa-th-large"></i>
    </a>
  </li> --}}
  <li class="nav-item dropdown">
    <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-alt"></i>
      {{-- <p class="d-lg-none d-md-block">
        {{ __('Account') }}
      </p> --}}
      @php
          $user = Auth::user();
      @endphp
      {{$user->name}}
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
      {{-- <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a> --}}
      <a class="dropdown-item" href="{{ route('changePasswordGet') }}">{{ __('Change Password') }}</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
    </div>
  </li>
</ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="{{ route('welcome') }}" class="text-center brand-link">
  {{-- <img src="{{ asset('adminlte') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
  <span class="brand-text">HR</span> <span class="brand-text font-weight-light">Management</span>
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
  <br>

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

           <li class="nav-item">
            <a class="nav-link {{ $activePage == 'dashboard' ? ' active' : '' }}" href="{{ route('welcome') }}">
                <i class="fas fa-address-card nav-icon"></i>
                <p>{{ __('Welcome') }}</p>
            </a>
          </li>
          <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>

  @php
  $user = Auth::user();

//   dd($approvals);
  @endphp
 @if($user->usertype_id == '2')

 <li class="nav-item {{ $activePage == 'leavesapproval'||$activePage == 'overtimesapproval' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'leavesapproval'||$activePage == 'overtimesapproval' ? ' active' : '' }} " >
        <i class="fas fa-check nav-icon"></i>
      <p>{{ __('Approvals') }}
        {{-- @php
            dd($numapproval);
            @endphp --}}
            @if ($numapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numapproval}} </span>
        @endif
        <i class="fas fa-angle-down right"></i>
      </p>
    </a>


      <ul class="nav nav-treeview">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'leavesapproval' ? ' active' : '' }}" href="{{ route('leaves.approval') }}">
            <i style="padding-left:20px" class="fas fa-running nav-icon "></i>
            <p style="padding-left:20px">{{ __('Leave Approval') }}
                @if ($numleaveapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numleaveapproval}} </span>
        @endif

            </p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'overtimesapproval' ? ' active' : '' }}" href="{{ route('overtimes.approval') }}">
            <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
            <p style="padding-left:20px">{{ __('Overtime Approval') }}
                @if ($numoverapproval > '0')
                <span class="ml-1 badge badge-primary"> {{$numoverapproval}} </span>
            @endif</p>
          </a>
        </li>
      </ul>

  </li>



<li class="nav-item">
<a class="nav-link {{ $activePage == 'staffleaves' ? ' active' : '' }}" href="{{ route('staffleaves') }}">
    <i class="fas fa-paste nav-icon"></i>
    <p>{{ __('My Staff') }}</p>
</a>
</li>

<div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
@endif

@if($user->hradmin == 'yes')

  <li class="nav-item {{ $activePage == 'createuser'||$activePage == 'all-users' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'createuser'||$activePage == 'all-users' ? ' active' : '' }}" >
        <i class="fas fa-users nav-icon"></i>
      <p>{{ __('Users') }}
        <i class="fas fa-angle-down right"></i>
      </p>
    </a>


      <ul class="nav nav-treeview ">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'createuser' ? ' active' : '' }}" href="{{ route('admin.users.create') }}">
            <i style="padding-left:20px" class="fas fa-user-plus nav-icon"></i>
            <p style="padding-left:20px">{{ __('Create new user') }}</p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'all-users' ? ' active' : '' }}" href="{{ route('admin.users.index') }}">
            <i style="padding-left:20px" class="fas fa-address-book nav-icon"></i>
            <p style="padding-left:20px">{{ __('All users') }}</p>
          </a>
        </li>
      </ul>

  </li>

  {{-- <li class="nav-item">
    <a class="nav-link {{ $activePage == 'allstaffbalances' ? ' active' : '' }} " href="{{ route('admin.allstaffbalances.index') }}">
        <i class="fas fa-list-ol nav-icon"></i>
        <p>{{ __('All Staff balances') }}</p>
    </a>
  </li> --}}

  <li class="nav-item {{ $activePage == 'hrleavesapproval'||$activePage == 'hrovertimesapproval' ? ' menu-open' : ''  }}">
    <a href="#" class="nav-link {{ $activePage == 'hrleavesapproval'||$activePage == 'hrovertimesapproval' ? ' active' : '' }} " >
        <i class="fas fa-check nav-icon"></i>
      <p>{{ __('HR Approvals') }}
        {{-- @php
            dd($numapproval);
            @endphp --}}
            @if ($numhrapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numhrapproval}} </span>
        @endif
        <i class="fas fa-angle-down right"></i>
      </p>
    </a>


      <ul class="nav nav-treeview">
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'hrleavesapproval' ? ' active' : '' }}" href="{{ route('leaves.hrapproval') }}">
            <i style="padding-left:20px" class="fas fa-running nav-icon "></i>
            <p style="padding-left:20px">{{ __('Leave Approval') }}
                @if ($numleavehrapproval > '0')

            <span class="ml-1 badge badge-primary"> {{$numleavehrapproval}} </span>
        @endif

            </p>
          </a>
        </li>
        <li class="nav-item" >
          <a class="nav-link {{ $activePage == 'hrovertimesapproval' ? ' active' : '' }}" href="{{ route('overtimes.hrapproval') }}">
            <i style="padding-left:20px" class="fas fa-adjust nav-icon"></i>
            <p style="padding-left:20px">{{ __('Overtime Approval') }}
                @if ($numoverhrapproval > '0')
                <span class="ml-1 badge badge-primary"> {{$numoverhrapproval}} </span>
            @endif</p>
          </a>
        </li>
      </ul>

  </li>


  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'allstaffleaves' ? ' active' : '' }}" href="{{ route('admin.allstaffleaves.index') }}">
        <i class="fas fa-paste nav-icon"></i>
        <p>{{ __('All Staff leaves') }}</p>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'allstaffovertimes' ? ' active' : '' }}" href="{{ route('admin.allstaffovertimes.index') }}">
        <i class="fas fa-adjust nav-icon"></i>
        <p>{{ __('All Staff Overtime') }}</p>
    </a>
  </li>



  <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
  @endif




           <li class="nav-item">
            <a class="nav-link {{ $activePage == 'my-leaves' ? ' active' : '' }}" href="{{ route('leaves.index') }}">
                <i class="fas fa-running nav-icon"></i>
                <p>{{ __('Leaves') }}</p>
            </a>
          </li>
      {{-- <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i>
          <p>
            Starter Pages
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Active Page</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Inactive Page</p>
            </a>
          </li>
        </ul>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link {{ $activePage == 'overtime' ? ' active' : '' }}" href="{{ route('overtimes.index') }}">
            <i class="fas fa-adjust nav-icon"></i>
            <p>{{ __('Overtime') }}</p>
        </a>
      </li>
      <div class="dropdown-divider" style="border-color:rgb(77, 77, 77);"></div>
  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'policies' ? ' active' : '' }}" href="{{ route('admin.policies.index') }}">
        <i class="fas fa-file-alt nav-icon"></i>
        <p>{{ __('HR Policies') }}</p>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ $activePage == 'holidays' ? ' active' : '' }}" href="{{ route('admin.holidays.index') }}">
        <i class="fas fa-umbrella-beach nav-icon"></i>
        <p>{{ __('Holidays') }}</p>
    </a>
  </li>

    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
@yield('content')
<!-- Content Header (Page header) -->
{{-- <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Starter Page</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Starter Page</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div> --}}
<!-- /.content-header -->

<!-- Main content -->
{{-- <div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>

            <p class="card-text">
              Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>

            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
          </div>
        </div>

        <div class="card card-primary card-outline">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>

            <p class="card-text">
              Some quick example text to build on the card title and make up the bulk of the card's
              content.
            </p>
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
          </div>
        </div><!-- /.card -->
      </div>
      <!-- /.col-md-6 -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <h5 class="m-0">Featured</h5>
          </div>
          <div class="card-body">
            <h6 class="card-title">Special title treatment</h6>

            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>

        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="m-0">Featured</h5>
          </div>
          <div class="card-body">
            <h6 class="card-title">Special title treatment</h6>

            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
      <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div> --}}
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
{{-- <aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
<div class="p-3">
  <h5>Title</h5>
  <p>Sidebar content</p>
</div>
</aside> --}}
<!-- /.control-sidebar -->
@endauth

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">

    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 .</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

{{-- <script src="{{ asset('adminlte') }}/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte') }}/dist/js/adminlte.min.js"></script>

<script src={{"/adminlte/dist/js/adminlte.min.js"}}></script>
<script src={{"/adminlte/plugins/jquery/jquery.min.js"}}></script>
<script src={{"/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"}}></script> --}}


<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>

@stack('scripts')

</body>
</html>
