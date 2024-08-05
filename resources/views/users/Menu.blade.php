@include('client.template.header');
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
</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Tableau</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau </a></li>
                            <li class="breadcrumb-item active">Accueil</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    @php
                    $num=0;  
                  @endphp
                  @foreach ($work as $projet )
                  @php
                  $num++;  
                @endphp
                    <div class="col-xxl-4">
                        <div class="card">
                            <div class="card-header border-0">
                                <h4 class="card-title mb-0" style="color: red">En attente</h4>
                            </div><!-- end cardheader -->
                            <div class="card-body pt-0">
                                <div class="upcoming-scheduled">
                                    <input type="text" class="form-control" data-provider="flatpickr" data-date-format="d M, Y" data-deafult-date="today" data-inline-date="true">
                                </div>
        
                                <h6 class="text-uppercase fw-semibold mt-4 mb-3 text-muted">Order & Name</h6>
                                
                                <div class="mini-stats-wid d-flex align-items-center mt-3">
                                    <div class="flex-shrink-0 avatar-sm">
                                        <span class="mini-stat-icon avatar-title rounded-circle text-danger bg-soft-danger fs-4">
                                            {{$num}}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $projet->titre_travail }}</h6>
                                        
                                    </div>
                                    <div class="flex-shrink-0">
                                        <p class="text-muted mb-0"> <i data-feather="trash-2" class="icon-md sup"></i></p>
                                       
                                       
                                    </div>
                                </div><!-- end -->
                                    
                              
                                
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    @endforeach
                </div><!-- end row -->

                <div>

                    <div class="team-list grid-view-filter row">


                        @foreach ($service as $service)
                        <div class="col">
                                <div class="card explore-box card-animate rounded">
                                    <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                                        <button type="button" class="btn btn-icon active" data-bs-toggle="button" aria-pressed="true"><i class="mdi mdi-cards-heart fs-16"></i></button>
                                    </div>
                                    <div class="explore-place-bid-img">
                                            @if ($service->s_photo=="default.png")
                                            <img src="{{ url('images/services/image.png') }}" alt="" class="img-fluid card-img-top explore-img" />
                                            @else
                                            <img src="{{ url('images/services') }}{{ '/'.$service->s_photo }}.p" alt=""
                                            alt="" class="img-fluid card-img-top explore-img" /> 
                                            @endif
                                        <div class="bg-overlay"></div>
                                        <div class="place-bid-btn">
                                            <a href="{{ route('submit_c_form',$service->id_service) }}" class="btn btn-danger"><i class="ri-auction-fill align-bottom me-1"></i>Commencer</a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="fw-medium mb-0 float-end"><i class="mdi mdi-18px mdi-comma-circle text-dark align-middle"></i></p>
                                        <h5 class="mb-1"><a href="{{ route('submit_c_form',$service->id_service) }}">{{$service->s_name}}</a></h5>
                                        <p class="text-muted mb-0">{{ Str::of($service->s_description)->limit(300)}}</p>
                                    </div>
                                    <div class="card-footer border-top border-top-dashed">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1 fs-14">
                                                <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> Prix: <span class="fw-medium">{{ $service->s_price }}</span>
                                            </div>
                                            <h5 class="flex-shrink-0 fs-14 text-primary mb-0">Durée: {{$service->s_duree}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-->
                        </div>
                        @endforeach
                    </div>
                    <!--end row-->
                </div>
            </div><!-- end col -->
        </div>
        <!--end row-->
    </div>
    <!-- listjs init -->
<script src="{{ url('control/js/pages/listjs.init.js') }}"></script>
<script src="{{ url('control/libs/list.pagination.js/list.pagination.min.js') }}"></script>
<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!--select2 cdn-->
<script src="{{ url('control/others/cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
<script src="{{ url('control/js/pages/select2.init.js') }}"></script>
<!-- notifications init -->
<script src="{{ url('control/js/pages/notifications.init.js') }}"></script>
<!-- glightbox js -->
<script src="{{ url('control/libs/glightbox/js/glightbox.min.js') }}"></script>
<!-- isotope-layout -->
<script src="{{ url('control/libs/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ url('control/js/pages/gallery.init.js') }}"></script>

<script>
   /* function paiement() {
     alert('ok');
    };*/
  
</script>

@include('client.template.footer');