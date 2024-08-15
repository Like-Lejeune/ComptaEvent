<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">


<!-- Mirrored from themesbrand.com/velzon/html/material/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jul 2022 01:25:44 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('control/images/nft/mtwcomplet.png')}}">
    
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

    <!-- preloader.css -->

    <link href="{{ url('control/preloader/css/preloader.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ url('control/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ url('control/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- toast -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Sweet Alert css-->
    <link href="{{ url('control/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />


</head>

<body>
    </div>

     <!-- auth-page wrapper -->
     <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100" style="background-color: rgb(255, 255, 255)">  <!--  style="background-color: rgb(26, 32, 44)" ici --> 
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mt-auto">
                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">"SUIVI"</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">"SIMPLE"</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" 100% EFFICACE"</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">COMPTA-EVENT</h5>
                                            <p class="text-muted">connexion.</p>
                                        </div>
                                        <h6 style="color: red ;">
                                            @foreach($errors->all() as $error )
        
                                            {{ $error }}
        
                                            @endforeach
                                        </h6>
                                        <div class="mt-4">
                                            <form method="post"  action="{{ route('verification') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" name="email" placeholder="Entrez votre email">
                                                    <span class="focus-input100" data-placeholder="&#xf207;"></span>
                                                </div>
        
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Mot de passe</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5" name="password" placeholder="Mot de passe">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Connexion</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0"><b>&copy;
                              <script>document.write(new Date().getFullYear())</script> </b><b>COMPTA-EVENT</b>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="{{ url('control/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('control/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ url('control/libs/node-waves/waves.min.j') }}"></script>
    <script src="{{ url('control/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ url('control/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ url('control/js/plugins.js') }}"></script>

    <script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- particles js -->
    <script src="{{ url('control/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ url('control/js/pages/particles.app.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ url('control/js/pages/password-addon.init.js') }}"></script>

    <script src="{{ url('control/preloader/js/preloader.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>


<!-- Mirrored from themesbrand.com/velzon/html/material/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jul 2022 01:25:44 GMT -->

</html>