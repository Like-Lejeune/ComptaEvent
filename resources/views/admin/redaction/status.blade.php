
@if (auth()->User()->type!='client' & auth()->User()->type!='editeur' )
    @include('template.header');
@else
    @include('editeur.template.header');
@endif
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">TRAVAIL</a></li>
                            <li class="breadcrumb-item active">STATUS</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card card-animate" style="background-color: #1c1c36; color: #ffffff;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    Nom du travail: {{ $work->titre_travail }}
                                </h2>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->
        <!-- end page title -->

        @php  
        $existe = DB::table('work_editor')
                ->where('work_id', $id_work)
                ->where('editor_id', $work->id)
                ->first('id_work_editor');                 
        $existingdoc = DB::table('work_end')
            ->where('work_editor_id', $existe->id_work_editor)
            ->get();
        $estimation = DB::table('works')
            ->where('id_work',$id_work)
            ->first();
        $existingcount = DB::table('work_end')
                ->where('work_editor_id', $existe->id_work_editor)
                ->where('work_end_at', '!=', null)
                ->count();
        $exist = DB::table('work_end')
                ->where('work_editor_id', $existe->id_work_editor)
                ->first();      
        @endphp
        <div class="row">
            <div class="col-lg-12">

                <div class="row justify-content-evenly">

                    <div class="col-lg-6">
                        <div class="mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-user-settings-line fs-24 align-middle text-secondary me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-16 mb-0 fw-semibold" style="font-size: 20px">EDITEUR INFORMATIONS
                                    </h5>
                                </div>
                            </div>
                           
                            <div class="accordion accordion-border-box">
                                <div class="accordion-item shadow">
                                    <h2 class="accordion-header" id="manageaccount-headingTwo">
                                        <button class="accordion-button" style="font-size: 20px" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#manageaccount-collapseTwo"
                                            aria-expanded="true" aria-controls="manageaccount-collapseTwo">
                                            NOM: {{ $work->name }}
                                        </button>
                                    </h2>
                                </div>
                                @php
                                    $nb_projet = DB::table('work_editor')
                                        ->join('users', 'editor_id', '=', 'users.id')


                                        
                                        ->select('*')
                                        ->where('users.name', '=', $work->name)
                                        ->count();
                                @endphp
                                <div class="accordion-item shadow">
                                    <h2 class="accordion-header" id="manageaccount-headingThree">
                                        <button class="accordion-button collapsed" style="font-size: 20px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#manageaccount-collapseThree" aria-expanded="false"
                                            aria-controls="manageaccount-collapseThree">
                                            TRAVAUX : {{ $nb_projet }}
                                        </button>
                                    </h2>
                                </div>
                                <div class="accordion accordion-border-box" id="genques-accordion">
                                    <div class="accordion-item shadow">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" style="font-size: 20px" type="button"
                                                aria-expanded="true" aria-controls="genques-collapseOne">
                                                Date butoire : {{$estimation->end_estimation}}
                                            </button>
                                        </h2>
                                    </div>
                                    <div class="accordion-item shadow">
                                        <h2 class="accordion-header" id="genques-headingTwo">
                                            <button class="accordion-button" style="font-size: 20px"
                                                type="button">
                                                 Temps restant: &ensp; <a class="mb-1" id="compte_a_rebours"></a>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                            <!--end accordion-->
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0 me-1">
                                    <i class="ri-shield-keyhole-line fs-24 align-middle text-secondary me-1"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fs-16 mb-0 fw-semibold" style="font-size: 20px">INFORMATIONS CLIENT
                                    </h5>
                                </div>
                            </div>
                            @php
                                $user_n = DB::table('works')
                                    ->join('users', 'user_id', '=', 'users.id')
                                    ->select('*')
                                    ->where('id_work', '=', $id_work)
                                    ->first();
                            @endphp
                            <div class="accordion accordion-border-box" id="privacy-accordion">
                                <div class="accordion-item shadow">
                                    <h2 class="accordion-header" id="privacy-headingOne">
                                        <button class="accordion-button" style="font-size: 20px" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#privacy-collapseOne"
                                            aria-expanded="true" aria-controls="privacy-collapseOne">
                                            NOM: {{ $user_n->name }}
                                        </button>
                                    </h2>
                                </div>
                                <div class="accordion-item shadow">
                                    <h2 class="accordion-header" id="privacy-headingTwo">
                                        <button class="accordion-button collapsed" style="font-size: 20px"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#privacy-collapseTwo" aria-expanded="false"
                                            aria-controls="privacy-collapseTwo">
                                            Email : {{ $user_n->email }}
                                        </button>
                                    </h2>
                                </div>
                            </div>
                            <!--end accordion-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->.
        </div>
        <!--end row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0" style="font-size: 25px">Détails </h5>    @if ($existingcount!=0)
                        <input type="hidden" id="date_fin" value="{{$exist->work_end_at}}">
                        <input type="hidden" id="stop" value="1">
                        
                        <h5 class="card-title mb-0" style="font-size: 20px"><b id="envoie_client">En attente de Vérification et d'envoie au client</b></h5> 
                    @else
                        <input type="hidden" id="date_fin" value="{{$estimation->end_estimation}}">
                        <input type="hidden" id="stop" value="0">
                    @endif
                        <br>
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
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                @php
                                    $works = DB::table('works')
                                        ->where('id_work', '=', $id_work)
                                        ->first();
                                    $typeDoc = DB::table('type_document')
                                        ->where('id_type_document','=',$works->type_document)
                                        ->first();
                                @endphp
                                <div class="col-lg-4">

                                    <div class="card-body">
                                        <h4 class="card-title mb-0" style="text-align: center">Travail
                                            commandé</h4><br>
                                        <div class="alert alert-primary alert-top-border alert-dismissible shadow fade show"
                                            role="alert">
                                            <i
                                                class="ri-user-smile-line me-3 align-middle fs-16 text-primary"></i><strong>Titre
                                                du travail :</strong> - {{ htmlspecialchars_decode($works->titre_travail) }} <br>
                                            <i
                                                class="ri-user-smile-line me-3 align-middle fs-16 text-primary"></i><strong>Sujet
                                                abordé :</strong> - {{ htmlspecialchars_decode($works->sujet_travail) }} <br>
                                            <i
                                                class="ri-user-smile-line me-3 align-middle fs-16 text-primary"></i><strong>
                                                Type de document à rendre : </strong> -
                                            {{$typeDoc->name_type}} <br>
                                            <i
                                                class="ri-user-smile-line me-3 align-middle fs-16 text-primary"></i><strong>
                                                Supplément d'information :</strong> -
                                            {{ htmlspecialchars_decode($works->info_supplementaire) }}
                                        </div>

                                    </div>
                                </div>

                                @php
                                    $nombre_de_mots = DB::table('work_option')
                                        ->join('options', 'id_option', '=', 'wo_option_id')
                                        ->where('option_categorie', '=', 'nombre de mots')
                                        ->where('wo_work_id', '=', $id_work)
                                        ->first();
                                    
                                    $redaction_nombre_document = DB::table('work_option')

                                        ->join('options', 'id_option', '=', 'wo_option_id')
                                        ->where('option_categorie', '=', 'redaction nombre document')
                                        ->where('wo_work_id', '=', $id_work)
                                        ->first();
                                    if(  $redaction_nombre_document== NULL){
                                        $mot_redac=0;
                                    } else{
                                        $mot_redac=$redaction_nombre_document->option_price;
                                    }
                                    $work_doc = DB::table('work_doc')
                                        ->where('wd_work_id', '=', $id_work)
                                        ->count();
                                    if($nombre_de_mots== NULL){
                                        $nombreDemots=0;
                                    }else{
                                        $nombreDemots=$nombre_de_mots->option_price;
                                    }
                                    $total = $nombreDemots + $mot_redac;
                                @endphp
                                <div class="col-lg-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0" style="text-align: center">Documents
                                            inclus & Frais</h4> <br>
                                        <div class="alert alert-danger alert-top-border alert-dismissible shadow fade show"
                                            role="alert">
                                            <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>Nombre
                                                de mots </strong> -
                                            {{ $nombre_de_mots->option_description }}<br>
                                            {{-- <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>Document
                                                à inclure :</strong> -
                                            {{ $redaction_nombre_document->option_description }}<br> --}}
                                            <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>
                                                Total document à considérer : </strong> {{ $work_doc }}<a
                                                href="{{ route('DocsTelecharger', $id_work) }}"> Telecharger</a>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $mise_en_forme = DB::table('mise_en_forme')
                                        ->where('work_id', '=', $id_work)
                                        ->first();
                                @endphp
                                <div class="col-lg-4">
                                    <div class="card-body">
                                        <h4 class="card-title mb-0" style="text-align: center">Mise en
                                            forme</h4> <br>
                                        <div class="alert alert-danger alert-top-border alert-dismissible shadow fade show"
                                            role="alert">
                                            <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>Police
                                                choisie : </strong> - {{ $mise_en_forme->police }} <br>
                                            <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>Eléments
                                                :</strong> - {{ $mise_en_forme->element_inclure }} <br>
                                            <i
                                                class="ri-check-double-line me-3 align-middle fs-16 text-danger"></i><strong>
                                                Supplément d'informations : </strong>
                                            {{ empty($mise_en_forme->info_supp) ? 'Aucun' : $mise_en_forme->info_supp }}
                                            <br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4"></div>
                                @php
                                        $existingcount = DB::table('work_end')
                                            ->where('work_editor_id',  $work->id_work_editor)
                                            ->where('work_end_at', '!=', null)
                                            ->count();
                                @endphp
                                @if ($existingcount!=0)
                                    <div class="col-lg-4 d-flex justify-content-start ml-auto">
                                        <a type="button" class="btn btn-success waves-effect waves-light shadow-none"
                                            href="{{ route('resultat', $id_work) }}">Resultats</a>
                                    </div>
                                @else
                                    <div class="col-lg-4 d-flex justify-content-start ml-auto">
                                        <a type="button" class="btn btn-primary waves-effect waves-light shadow-none"
                                            href="{{ route('update_admin_redation', $id_work) }}">Modifier les
                                            choix</a>
                                    </div>
                                @endif
                                <br>.
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-lg-6">
            <a type="button" id="btnStatus" style="font-size: 20px" href="{{ route('redaction') }}"
                class="btn btn-secondary">Retour
            </a>
        </div>
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- listjs init -->
<script src="{{ url('rendu/js/pages/listjs.init.js') }}"></script>

<script src="{{ url('rendu/libs/list.pagination.js/list.pagination.min.js') }}"></script>


<script src="{{ url('rendu/others/code.jquery.com/jquery-3.6.0.min.js') }}"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('rendu/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- cleave.js -->
<script src="{{ url('rendu/libs/cleave.js/cleave.min.js') }}"></script>
<!-- form masks init -->
<script src="{{ url('rendu/js/pages/form-masks.init.js') }}"></script>

<script>
    function reaffect(val) {
        $('#exampleModalLabel_').html("Re-Affect Editor");
        $('#id_option').val(val);
        $('#showModal_reaffect').modal('show');
    };

    function remove_editor(val, val2) {
        $('#exampleModalLabel_').html("Remove Editor");
        $('#id_option2').val(val);
        $('#id_editor2').val(val2);
        $('#showModal_remove').modal('show');
    };

    function affect_cancelled(val) {
        $('#exampleModalLabel_').html("(Redo) Affect Editor");
        $('#id_option1').val(val);
        $('#showModal_affect_cancelled').modal('show');
    };

    function add_time_to_work(id_option, id_projet) {
        $('#exampleModalLabel_').html("EDIT TIME");
        $("#firstmodal").data("id_projet_add_time", id_projet);
        $("#firstmodal").data("id_option_add_time", id_option);
        // set the values of the hidden inputs in the modal form
        $('#id_projet_add_time').val(id_projet);
        $('#id_option_add_time').val(id_option);
        $('#showModal_add').modal('show');
    };

    function impossibilite_de_rajouter_du_temps() {
        alert('Impossibilité de rajouter du temps à la tâche! Compteur pas encore terminé.');
    };
</script>
<script src="{{ url('control/js/compte_a_rebours.js') }}"></script>
<script>
    var date_fin = document.getElementById("date_fin").value;
    var date_fin = new Date(date_fin);
    var stop = document.getElementById("stop").value;
    compte_a_rebours(date_fin, stop);
    document.getElementById("envoie_client").style.color = "#e03245"; // Changer la couleur du texte en rouge
    document.getElementById("envoie_client").style.animation = "blink 1.5s infinite"; // Faire clignoter le texte
</script>
<script>
    var inputTime = document.getElementById("exampleInputtime");
    inputTime.value = hours + ":" + minutes;
    current_time();
</script>

@include('template.footer');
