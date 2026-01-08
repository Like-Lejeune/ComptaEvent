@include('template.header');
<style>

    @keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.4; }
    100% { opacity: 1; }
    }

    .progress-bar.bg-danger {
    animation: blink 1s infinite;
    }
</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Event-Projet</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                            <li class="breadcrumb-item active"> Event-Projet</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        @php
        $services = DB::table('services')
            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
            ->where('evenements.utilisateur_id', Auth::id())
            ->orderBy('s_name', 'asc')
            ->get();  
        @endphp

        {{-- Modal service --}}
            <div class="modal fade" id="showModal_nouveauService" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="exampleModalLabel_" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="showModal_nouveauService_" style="font-size: 20px">
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close" id="close-modal"></button>
                        </div>
                        <form id="admin" action="{{route('nouveauService')}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <ul class='alert alert warning d-one' id='save_errorList'></ul>
                                <div class="row">
                                    <div class="mb-" id="modal-id" style="display: none;">
                                        <label for="id-field" class="form-label">ID</label>

                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="placeholderInput" class="form-label"> <b style="font-size: 16px">
                                            Nouveau service</label>
                                            <input type="texte" class="form-control" name="s_service" placeholder="Ex: Sonorisation">
                                            <input type="hidden" name="evenement_id">   
                                    </div><br>
                                    <div class="col-lg-12 mb-3">
                                        <label for="placeholderInput" class="form-label"> <b style="font-size: 16px">
                                            Budget du service</label>
                                            <input type="number" class="form-control" name="s_budget" placeholder="Ex: 5000000 XAF">   
                                    </div><br>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" id="btnSave"
                                        class="btn btn-secondary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
     {{-- end Modal service --}}

      {{-- Modal budget --}}
            <div class="modal fade" id="showModal_updateBudget" data-bs-backdrop="static" tabindex="-1"
            aria-labelledby="exampleModalLabel_" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="showModal_updateBudget_" style="font-size: 20px">
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close" id="close-modal"></button>
                    </div>
                    <form id="admin_" action="{{route('updateBudget')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <ul class='alert alert warning d-one' id='save_errorList'></ul>
                            <div class="row">
                                <div class="mb-" id="modal-id" style="display: none;">
                                    <label for="id-field" class="form-label">ID</label>

                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="customername-field" class="form-label"
                                        style="font-size: 16px">Choississez le service
                                    </label>
                                    <select class="form-select" name="service"
                                        aria-label="Disabled select example"
                                        style="font-size: 18
                                        16px"  required>
                                        @foreach ($services as $item)
                                                <option value="{{ $item->id_service }}">
                                                    {{ $item->s_name }}</option>
                                        @endforeach

                                    </select>
                                   
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label for="placeholderInput" class="form-label"> <b style="font-size: 16px">
                                        Nouveau Budget</label>
                                        <input type="number" class="form-control" name="budget" placeholder="Ex: 5000000 XAF">   
                                </div><br>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light"
                                    data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" id="btnSave"
                                    class="btn btn-secondary">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end Modal budget --}}

        <div class="row project-wrapper">
            <div class="col-xxl-8">
                <div class="row">
                   
                     @foreach ($services as $service)
                     <div class="col">
                         <div class="card explore-box card-animate rounded">
                             <div class="bookmark-icon position-absolute top-0 end-0 p-2">
                                 <h5 class="card-title text-uppercase fw-semibold mb-1 fs-15">{{$service->s_name}}</h5>
                             </div><br>
                             <div class="explore-place-bid-img">
                                 <div class="bg-overlay"></div>
                                 <div class="place-bid-btn">
                                     <a href="" class="btn btn-danger"><i class="ri-auction-fill align-bottom me-1"></i>Consulter</a>
                                 </div>
                             </div>
                             @php
                            $sumdep = DB::table('depense')
                                ->where('service_id', '=', $service->id_service)
                                ->where('user_id', Auth::id())
                                ->sum('s_depense');
                             $conso=($sumdep*100)/$service->s_budget
                             
                                $progress = number_format($conso, 2);
                                if ($progress < 90) {
                                    $color = 'bg-success'; // vert
                                } elseif ($progress <= 100) {
                                    $color = 'bg-warning'; // rouge
                                } else {
                                    $color = 'bg-danger'; // dépassement
                                }
                            @endphp
                           
                             <div class="card-footer border-top border-top-dashed">
                                <a type="button" href="{{ route('historique_depense', $service->id_service) }}">
                                 <div class="d-flex align-items-center">
                                     <div class="flex-grow-1 fs-14">
                                         <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> BUDGET: <span class="counter-value" data-target="{{$service->s_budget}}">0</span><br>
                                         <i class="ri-price-tag-3-fill text-warning align-bottom me-1"></i> DEPENSES: <span class="counter-value" data-target="{{$sumdep}}">0</span><br><br>
                                         <p class="mb-1">Consommation du Budget </p>
                                             <div class="progress mt-2" style="height: 15px;">
                                                <div 
                                                    class="progress-bar progress-bar-striped progress-bar-animated {{ $color }}" 
                                                    role="progressbar" 
                                                    style="width: {{ $progress > 100 ? 100 : $progress }}%;" 
                                                    aria-valuenow="{{ $progress }}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                    {{ $progress }}%
                                                </div>
                                             </div>
                                             @if($progress > 100)
                                                <small class="text-danger fw-bold">
                                                    ⚠ Dépassement !
                                                </small>
                                            @else
                                            <p class="mb-1">Pourcentage : {{number_format($conso, 2)}} %</p>
                                            @endif
                                     </div>
                                 </div>
                                </a>
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
                                    <a type="button"  href="{{ route('etat_global_pdf', $service->id_service) }}" class="btn btn-soft-dark btn-sm shadow-none">
                                        IMPRIMER
                                    </a>

                                </div>
                            </div><!-- end card header -->

                            <div class="card-header p-0 border-0 bg-soft-light">
                                <div class="row g-0 text-center">
                                    @php
                                        $countService = DB::table('services')
                                        ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
                                        ->where('evenements.utilisateur_id', Auth::id())
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
                                     $sumPrix = $sumBudget = DB::table('evenements')
                                        ->where('evenements.utilisateur_id', Auth::id())
                                        ->sum('budget_total');
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
                                      $sumDepenses = DB::table('depense')
                                        ->join('evenements', 'evenements.id', '=', 'depense.evenement_id')
                                        ->where('evenements.utilisateur_id', Auth::id())
                                        ->sum('s_depense');
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value"
                                                    data-target="{{$sumDepenses}}">0</span> FCFA</h5>
                                            <p class="text-muted mb-0">Total dépenses</p>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    @php
                                      $sumSolde = DB::table('services')
                                            ->join('evenements', 'evenements.id', '=', 'services.evenement_id')
                                        ->where('evenements.utilisateur_id', Auth::id())
                                        ->sum('s_solde');
                                    @endphp
                                    <div class="col-6 col-sm-3">
                                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                                            <h5 class="mb-1 text-success"><span class="counter-value"
                                                    data-target="{{$sumSolde}}">0</span> FCFA</h5>
                                            <p class="text-muted mb-0">Solde Total restant</p>
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
                                <a href="{{ route('nouvelleDepense') }}" type="button" class="btn btn-outline-secondary waves-effect waves-light">Ajouter une dépense</a>
                                <a type="button" class="btn btn-outline-dark waves-effect waves-light" onclick="service()">Ajouter un service</a>
                                <a type="button" class="btn btn-outline-danger waves-effect waves-light" onclick="budget()">Modifier un Budget</a>
                            </div>
                        </div>
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->

    </div>
    <!-- container-fluid -->
</div>


<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('control/js/pages/notifications.init.js') }}"></script>
<script>
    function budget() {
        $('#showModal_updateBudget_').html("Modifier le Budget");
        $('#showModal_updateBudget').modal('show');
    };
    function service() {
        $('#showModal_nouveauService_').html("Nouveau service");
        $('#showModal_nouveauService').modal('show');
    };
</script>

@include('template.footer')
