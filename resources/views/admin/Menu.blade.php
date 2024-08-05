@include('template.header');


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Accueil</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                            <li class="breadcrumb-item active">Accueil</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row project-wrapper">
            <div class="col-xxl-8">
                <div class="row">
                    @php
                    $services = DB::table('services')
                                ->get();        
                    @endphp
                     @foreach ($services as $service)
                    <div class="col">
                        <div class="card explore-box card-animate rounded">
                            <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                                <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{$service->s_name}}</h5>
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
                                    <a href="" class="btn btn-danger"><i class="ri-auction-fill align-bottom me-1"></i>Consulter</a>
                                </div>
                            </div>
                            @php
                            $sumdep = DB::table('depense')
                            ->where('service_id', '=', $service->id_service)
                            ->sum('s_depense');
                            $sumrec = DB::table('recette')
                            ->where('service_id', '=', $service->id_service)
                            ->sum('s_recette');
                           @endphp
                            <div class="card-footer border-top border-top-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 fs-14">
                                        <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> BUDGET: <span class="counter-value" data-target="{{$service->s_budget}}">0</span><br>
                                        <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> DEPENSES: <span class="counter-value" data-target="{{$sumdep}}">0</span><br>
                                        <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> RECETTES: <span class="counter-value" data-target="{{$sumrec}}">0</span><br>
                                        <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> SOLDE : <span class="counter-value" data-target="{{$service->s_solde}}">0</span><br>
                                    </div>
                                    <h5 class="flex-shrink-0 fs-14 text-primary mb-0"></h5>
                                </div>
                            </div>
                        </div>
                        <!--end card-->
                </div>
                    @endforeach
                    <!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Statistiques</h4>
                                <div>
                                    <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                                        TOUT
                                    </button>

                                </div>
                            </div><!-- end card header -->

                            <div class="card-header p-0 border-0 bg-soft-light">
                                <div class="row g-0 text-center">
                                    @php
                                         $countService = DB::table('services')
                                        ->count();
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value"
                                                    data-target="{{$countService}}">0</span></h5>
                                            <p class="text-muted mb-0">Total service</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    @php
                                     $sumPrix = DB::table('services')
                                    ->sum('s_budget');
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value"
                                                    data-target="{{$sumPrix}}">0</span></h5>
                                            <p class="text-muted mb-0">Total budget</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    @php
                                     $sumPrix = DB::table('depense')
                                    ->sum('s_depense');
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value"
                                                    data-target="{{$sumPrix}}">0</span> FCFA</h5>
                                            <p class="text-muted mb-0">Total dépenses</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    @php
                                      $sumPrix = DB::table('recette')
                                      ->sum('s_recette');
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <h5 class="mb-1 text-success"><span class="counter-value"
                                                    data-target="{{$sumPrix}}">0</span> FCFA</h5>
                                            <p class="text-muted mb-0">Total recettes</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div><!-- end card header -->
                            <div class="card-body p-0 pb-2">
                                <div>
                                    <div id="projects-overview-chart"
                                        data-colors='["--vz-secondary", "--vz-secondary", "--vz-success"]'
                                        class="apex-charts" dir="ltr"></div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end col -->

            <div class="col-xxl-4">
                <div class="card">
                    <div class="card-header border-0">
                        <h4 class="card-title mb-0">ACTIONS</h4>
                    </div><!-- end cardheader -->
                    <div class="card-body pt-0">
                        <div class="live-preview">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="{{ route('nouvelleRecette') }}" type="button" class="btn btn-outline-dark waves-effect waves-light">Ajouter une recette</a>
                                <a href="{{ route('nouvelleDepense') }}" type="button" class="btn btn-outline-secondary waves-effect waves-light">Ajouter une dépense</a>
                                <a href="#" type="button" class="btn btn-outline-danger waves-effect waves-light">Modifier un Budget</a>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
@include('template.footer');
