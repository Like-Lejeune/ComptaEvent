<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">


<!-- Mirrored from themesbrand.com/velzon/html/material/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jul 2022 01:25:44 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Inscription</title>
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

    <!-- Sweet Alert css-->
    <link href="{{ url('control/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons Css -->
    <link href="{{ url('control/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- preloader.css -->

    <link href="{{ url('control/preloader/css/preloader.css') }}" rel="stylesheet" type="text/css" />

    <!-- App Css-->
    <link href="{{ url('control/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ url('control/css/custom.min.css') }}" rel="stylesheet" type="text/css" />


    <style type="text/css">
        .auth-one-bg-position {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 380px
        }

        @media (max-width:575.98px) {
            .auth-one-bg-position {
                height: 280px
            }
        }

        .auth-one-bg {
            background-image:url('{{ url('template_photoQuix/img/360VirtualStaging.jpg') }}');
            background-position: center;
            background-size: cover
        }
    </style>


</head>

<body>


    <div class="loader flex-column justify-content-center align-items-center" id='charge'>


        <div class="loader7">
            <div class="d-flex justify-content-center">
                <img src="{{ url('control/preloader/Bkfh.gif') }}" alt="Loading...">
            </div>
        </div>
    </div>


    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden m-0">
                            <div class="row justify-content-center g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100" style="background-color:rgb(26, 32, 44)">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="{{ url('control/images/nft/mtwcomplet.png')}}" alt=""
                                                        height="300" class="move-animation" >
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="0" class="active" aria-current="true"
                                                            aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                            data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">"Nous vous surcharger; plus planifiez et déléguez à nos experts"</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">"Un travail rapide et de qualité optimale"</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" 100% satisfaction "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                   
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Register Account</h5>
                                            <p class="text-muted">Get your Free PhotoQuix account now.</p>
                                        </div>
                                        @if(Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                            @php
                                                Session::forget('success');
                                            @endphp
                                        </div>
                                        @endif
                                       
                                        @if(session()->has('message1'))

                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                          <strong  style='font-size:20px;'> &#9940; </strong>  {{ session()->get('message1') }}
                                        </div>
                                        @endif
                                        @if(session()->has('message2'))

                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <strong  style='font-size:20px;'> &#128077;  </strong>  {{ session()->get('message2') }}
                                        </div>
                                        @endif
                                        
                                        <div class="mt-4">
                                            <form method="post"  action="{{ route('validation_inscription') }}">
                                                @csrf


                                                <div class="mb-3">
                                                    <label for="username" class="form-label"> Full name <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="Enter username" required>
                                                    <div class="invalid-feedback">
                                                        Please enter name
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="useremail" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" id="useremail" name="email"
                                                        placeholder="Enter email address" required>
                                                    <div class="invalid-feedback">
                                                        Please enter email
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Phone <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" id="phone" name="phone"
                                                        placeholder="Enter username" required>
                                                    <div class="invalid-feedback">
                                                        Please enter Phone
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Compagny <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="compagny"
                                                        name="compagny" placeholder="Enter username" required>
                                                    <div class="invalid-feedback">
                                                        Please enter compagny
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Country <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="country" required>
                                                        <option selected value="{{ $default_country }}"> {{
                                                            $default_country }}</option>
                                                        @foreach($pays as $pays )
                                                        <option value="{{ $pays }}">{{ $pays }}</option>
                                                        @endforeach

                                                    </select>

                                                    <div class="invalid-feedback">
                                                        Please enter country
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input"
                                                            onpaste="return false" placeholder="Enter password"
                                                            id="password1" aria-describedby="passwordInput"
                                                          name="password" required>
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" id="password-addon"><i
                                                                class="ri-eye-fill align-middle"></i></button>
                                                        <div class="invalid-feedback">
                                                            Please enter password
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Confirm
                                                        Password</label>
                                                    <div class="position-relative auth-pass-inputgroup">
                                                        <input type="password" class="form-control pe-5 password-input"
                                                            onpaste="return false" placeholder="Enter password"
                                                            id="password2" aria-describedby="passwordInput"
                                                            name="password_confirmation" required  onblur = "control_();" >
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                            type="button" id="password-addon"><i
                                                                class="ri-eye-fill align-middle"></i></button>
                                                       
                                                    </div>
                                                </div>


                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit"  id="save_form"  >Sign Up</button>
                                                </div>


                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Already have an account ? <a
                                                    href="{{ route('identification') }}"
                                                    class="fw-semibold text-primary text-decoration-underline">
                                                    Signin</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <p class="mb-0"><b style="color: black;font-size:15px">&copy;
                                <script>document.write(new Date().getFullYear())</script> MY</b><b style="color: rgb(255, 255, 255);font-size:15px">TASKWORK</b>
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

    <script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- particles js -->
    <script src="{{ url('control/libs/particles.js/particles.js') }}"></script>
    <!-- particles app js -->
    <script src="{{ url('control/js/pages/particles.app.js') }}"></script>
    <!-- password-addon init -->
    <script src="{{ url('control/js/pages/password-addon.init.js') }}"></script>

    <script src="{{ url('control/preloader/js/preloader.js') }}"></script>
   <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

 function control_() {
          
           if($('#password1').val()!= $('#password2').val() ){
        
            Swal.fire({             icon: 'warning',
                                    html: 'Passwords not matching',
                                   
                                })
               
          $('#save_form').attr('disabled', true);
          return false;
          }else{
         $('#save_form').attr('disabled', false);
        }

    };


</script>
</body>


<!-- Mirrored from themesbrand.com/velzon/html/material/auth-signin-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jul 2022 01:25:44 GMT -->

</html>