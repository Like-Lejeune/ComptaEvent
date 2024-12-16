@include('template.header');
<style>
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

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Action sur utilisateurs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Formulaire Utilisateur</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
        </div>
       
        <div class="row">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong style="font-size:20px">{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <strong style="font-size:20px">{{ $message }}</strong>
            </div>
            @endif
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <form action="{{route("nouvelUser")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name='service_id' value="">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-priority-input" class="form-label">Nom & Prenom <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <input type="text" class="form-control" name='name' id="datepicker-deadline-input" placeholder="Yves Saint Laurent" data-provider="flatpickr">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-priority-input" class="form-label">Email <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <input type="email" class="form-control" name='email' id="datepicker-deadline-input" placeholder="yvesl@gmail.com" data-provider="flatpickr">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-status-input" class="form-label">Service</label>
                                        <select class="js-example-basic-multiple"   multiple style="font-size: 20 px" name='service[]' data-choices data-choices-search-false id="choices-status-input">
                                            @foreach ( $services as $service_ )
                                            <option value="{{$service_->id_service}}">{{$service_->s_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-success btn-label waves-effect waves-light" >
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Enrégistrer</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->



<!-- listjs init -->
<script src="{{ url('control/js/pages/listjs.init.js') }}"></script>

<script src="{{ url('control/libs/list.pagination.js/list.pagination.min.js') }}"></script>


<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('control/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!--select2 cdn-->
<script src="{{ url('control/others/cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
<script src="{{ url('control/js/pages/select2.init.js') }}"></script>

<!-- notifications init -->
<script src="{{ url('control/js/pages/notifications.init.js') }}"></script>

<!--datatable js-->
<script src="{{ url('control/others/cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('control/others/cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ url('control/others/cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('control/others/cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('control/others/cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js') }}"></script>
<script src="{{ url('control/others/cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('control/others/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ url('control/others/cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ url('control/others/cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>

<!-- glightbox js -->
<script src="{{ url('control/libs/glightbox/js/glightbox.min.js') }}"></script>

<!-- isotope-layout -->
<script src="{{ url('control/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>

<script src="{{ url('control/js/pages/gallery.init.js') }}"></script>

<script>
    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';

    }, 10000);
    setTimeout(function() {

        document.querySelector('.alert-danger').style.display = 'none';
    }, 10000);

</script>


@include('template.footer');
