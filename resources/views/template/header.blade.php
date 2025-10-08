<!doctype html>

    <html lang="en" data-layout="horizontal" data-layout-style="lg" data-layout-position="fixed" data-topbar="dark" data-sidebar-image="none">

<!-- Mirrored from themesbrand.com/velzon/html/material/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jul 2022 01:25:14 GMT -->
<head>
    <meta charset="utf-8" />
    <title>Cpanel MTW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />

    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('template_photoQuix/logo/logo-mini.png') }}">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- jsvectormap css -->
    <link href="{{ url('control/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ url('control/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ url('control/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ url('control/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ url('control/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ url('control/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ url('control/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
      <!-- Sweet Alert css-->
     <link href="{{ url('control/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

     <link href="{{ url('control/others/cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet" />
    <!--datatable css-->
    <link rel="stylesheet" href="{{ url('control/others/cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css') }}" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="{{ url('control/others/cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url('control/others/cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css') }}">
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
        .profile-offcanvas .team-cover::before,
        .team-box .team-cover::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: -webkit-gradient(linear, left bottom, left top, from(#221a52), to(#4b38b3));
            background: linear-gradient(to top, #ffffff00, #ffffff00);
            opacity: .6;


        }

        .btn-light:hover {
            background-color: rgb(221, 71, 71);
            color: white;
            border-color: #f3f6f9;
        }

        .sup:hover {
            background-color: rgb(221, 71, 71);
            color: white;
            border-color: #f3f6f9;
        }

        .P1 {

            border-width: 1px;
            border-style: solid;
            border-color: rgb(255, 255, 255);
        }

        .P2 {
            border-width: 1px;
            border-style: solid;
            border-color: rgb(255, 255, 255);

        }

        .P3 {

            border-width: 1px;
            border-style: solid;
            border-color: rgb(255, 255, 255);
        }

        .P4 {
            border-width: 1px;
            border-style: solid;
            border-color: rgb(255, 255, 255);

        }

    </style>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ url('control/images/nft/mtw_nice.png')}}" alt="" height="65">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ url('control/images/nft/mtw_nice.png')}}" alt="" height="65">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ url('control/images/nft/mtwlogo_light.png')}}" alt="" height="65">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ url('control/images/nft/mtwlogo_light.png')}}" alt="" height="65">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>


                <div class="dropdown ms-sm-3 header-item topbar-user" >
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">

                            <b style="color: white">{{auth()->User()->name}}</b>
                       </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">{{auth()->User()->name}}</h6>

                        <a class="dropdown-item" href="{{ route('deconnexion') }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Se deconnecter</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ route('administrator') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ url('control/images/nft/mtw_nic.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="65">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('control/images/nft/mtw_nic.png')}}" class="card-logo card-logo-dark" alt="logo dark" height="65">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ route('administrator') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ url('control/images/nft/mtwlogo_ligh.png')}}" class="card-logo card-logo-light" alt="logo light" height="65">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ url('control/images/nft/mtwlogo_ligh.png')}}" class="card-logo card-logo-light" alt="logo light" height="65">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        @if (auth()->User()->type =='super')
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('administrator') }}">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards" style="font-size:12px;">Accueil</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('afficherService') }}" >
                            <i class="ri-dashboard-fill"></i> <span data-key="t-dashboards" style="font-size:12px;">Evenements</span>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('afficherService') }}" >
                            <i class="ri-dashboard-fill"></i> <span data-key="t-dashboards" style="font-size:12px;">Services</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('profiles.index') }}">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards" style="font-size:12px;">Profils</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ route('userlist') }}">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards" style="font-size:12px;">Utilisateur</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="" >
                            <i class="ri-dashboard-fill"></i> <span data-key="t-dashboards" style="font-size:12px;">Activité</span>
                            </a>
                        </li>
                        @else
                            <a class="nav-link menu-link" href="{{ route('user_menu') }}">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards" style="font-size:12px;">Accueil</span>
                            </a>
                        @endif
                       <!-- end Dashboard Menu -->
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
