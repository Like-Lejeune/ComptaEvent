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
                    <h4 class="mb-sm-0">Définir mon travail</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">REDACTION GENERALE</a></li>
                            <li class="breadcrumb-item active">Définir mon travail</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="progress progress-step-arrow progress-info">
                    <a href="javascript:void(0);" class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">soumission</a>
                    <a href="javascript:void(0);" class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Verification & paiement</a>
                </div>;
            </div>
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
            <div class="col-lg-8">
                <form action="{{route("update_adminxredaction")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                     <input type="hidden"   name="work_id" value="{{ $work_id}}" >
                        @php
                        $works = DB::table('works')
                        ->where('id_work','=',$work_id)
                        ->first();

                        $type = DB::table('type_document')
                        ->where('id_type_document','=',$works->type_document)
                        ->first();
                        @endphp
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="project-title-input">Titre du travail <b style="color: #cf4848; font-size:9px">obligatoire</b> </label>
                                <input type="text" class="form-control" name='name_work' value="{{ htmlspecialchars_decode($works->titre_travail)}}" id="project-title-input" placeholder="Enter project title">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-priority-input" class="form-label">Objet de la rédaction <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <input type="text" class="form-control" name='sujet_redaction' value="{{htmlspecialchars_decode($works->sujet_travail)}}" id="datepicker-deadline-input" placeholder="Votre sujet" data-provider="flatpickr">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        @php
                                            $type_document = DB::table('type_document')
                                            ->select('*')
                                            ->join('service_type_document','type_document_id','=', 'id_type_document')
                                            ->where('service_id','=',$works->service)
                                            ->orderBy('name_type', 'asc')
                                            ->get();
                                         @endphp
                                        <label for="choices-status-input" class="form-label">Type du document à
                                            rédiger  <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <select class="js-example-basic-single" style="font-size: 20 px" name='type_document' data-choices data-choices-search-false id="choices-status-input">
                                            <option value="{{$works->type_document}}" selected>{{$type->name_type}} ({{$type->price}}) Fcfa - Durée: {{$type->duree}}H</option>
                                            @foreach ( $type_document as $type_document_ )
                                            <option value="{{$type_document_->id_type_document}}">
                                                {{$type_document_->name_type}} ({{$type_document_->price}}) Fcfa - Durée: {{$type_document_->duree}}H </option>
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="project-thumbnail-img">Pièces jointes (images ou
                                            textes)</label>
                                        <input class="form-control" id="project-thumbnail-img" type="file" name="link_doc[]" multiple  accept="image/png, image/pdf, image/jpeg, image/word">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    @php
                                    $option_docs = DB::table('options')
                                        ->select('*')
                                        ->where('option_categorie','=', 'redaction nombre document')
                                        ->orderBy('options.option_price', 'asc')
                                        ->get();

                                    $redaction_nombre_document = DB::table('work_option')
                                        ->join('options','id_option','=','wo_option_id')
                                        ->where('option_categorie','=','redaction nombre document')
                                        ->where('wo_work_id','=',$work_id)
                                        ->first();
                                    @endphp
                                    <div class="mb-3">
                                        <label class="form-label" for="project-thumbnail-img">intégrer dans le document
                                            final</label>
                                        <select class="js-example-basic-single" name='element_work'>
                                            <option value="{{$redaction_nombre_document->id_option}}" selected>{{$redaction_nombre_document->option_description}} - prix: {{$redaction_nombre_document->option_price}} Fcfa </option>
                                            @foreach ( $option_docs as $option_doc )

                                            <option value="{{$option_doc->id_option}}">
                                                {{$option_doc->option_description}} ({{$option_doc->option_price}}) Fcfa </option>
                                            </option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @php
                                $nombre_de_mots = DB::table('work_option')
                                ->join('options','id_option','=','wo_option_id')
                                ->where('option_categorie','=','nombre de mots')
                                ->where('wo_work_id','=',$work_id)
                                ->first();

                                $work_doc = DB::table('work_doc')
                                ->where('wd_work_id','=',$work_id)
                                ->count();
                                @endphp

                                <div class="col-lg-6">
                                    @php
                                    $option_mots = DB::table('options')
                                    ->select('*')
                                    ->where('option_categorie','=', 'nombre de mots')
                                    ->orderBy('options.option_price', 'asc')
                                    ->get();
                                    @endphp
                                    <div>
                                        <label class="form-label">Nombre de mots <b style="color: #cf4848; font-size:9px">obligatoire</b> </label>
                                        <select class="js-example-basic-single" name='nb_mots' required="required">
                                            <option value="{{$nombre_de_mots->id_option}}" selected>
                                                {{$nombre_de_mots->option_description}} {{$nombre_de_mots->option_price}} Fcfa</option>
                                            </option>
                                            @foreach ( $option_mots as $option_mot )
                                            <option value="{{$option_mot->id_option}}">
                                                {{$option_mot->option_description}} ({{$option_mot->option_price}}) Fcfa </option>
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="exampleFormControlTextarea5" class="form-label">+ d'informations sur la
                                            rédaction</label>
                                        <textarea class="form-control" name='info_redaction'  id="exampleFormControlTextarea5" rows="3">{{htmlspecialchars_decode($works->info_supplementaire)}} </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">MISE EN FORME DU DOCUMENT</h5>
                        </div>
                        <div class="card-body">
                            @php
                            $mise_en_forme = DB::table('mise_en_forme')
                            ->where('work_id','=',$work_id)
                            ->first();
                            @endphp
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-label">Police </label>
                                        <select class="js-example-basic-single" name='police' >
                                            <option value="{{ $mise_en_forme->police}}" selected >{{ $mise_en_forme->police}}</option>
                                            <option value="Arial" >Arial</option>
                                            <option value="Calibri">Calibri</option>
                                            <option value="Cambria">Cambria</option>
                                            <option value="Candara">Candara</option>
                                            <option value="Century Gothic">Century Gothic</option>
                                            <option value="Comic Sans MS">Comic Sans MS</option>
                                            <option value="Consolas">Consolas</option>
                                            <option value="Constantia">Constantia</option>
                                            <option value="Corbel">Corbel</option>
                                            <option value="Courier New">Courier New</option>
                                            <option value="Franklin Gothic Medium">Franklin Gothic Medium</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Gill Sans MT">Gill Sans MT</option>
                                            <option value="Helvetica">Helvetica</option>
                                            <option value="Lucida Sans Unicode">Lucida Sans Unicode</option>
                                            <option value="Palatino Linotype">Palatino Linotype</option>
                                            <option value="Segoe UI">Segoe UI</option>
                                            <option value="Tahoma">Tahoma</option>
                                            <option value="Times New Roman">Times New Roman</option>
                                            <option value="Verdana">Verdana</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label class="form-label">Mise en forme</label>
                                        <select class="js-example-basic-multiple" multiple="multiple" name="element_forme[]">
                                            <option value="Taille police">Classique</option>
                                            <option value="titre">titre</option>
                                            <option value="sous titre">sous titre</option>
                                            <option value="interligne">interligne</option>
                                            <option value="alignement">alignement</option>
                                            <option value="table de matiere">table de matière</option>
                                            <option value="formes">Graphique</option>
                                            <option value="tableaux">Tableaux</option>
                                            <option value="Numerotation">Numérotation</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <label for="exampleFormControlTextarea5" class="form-label" name="supplement_forme">Informations supplémentaires sur la mise en forme</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea5" rows="3">{{htmlspecialchars_decode($mise_en_forme->info_supp)}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="text-end mb-4">
                        <button type="submit" class="btn btn-success btn-label waves-effect waves-light" >
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>suivant </button>
                    </div>
                </form>
            </div>

            <!-- end col -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Instructions générales</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Rédaction générale ce que nous faisons</label>
                            <div id="ckeditor-classic">
                                <p>Notre service de rédaction générale est la solution idéale pour vous aider à
                                    communiquer
                                    efficacement avec votre public cible. Nous sommes fiers de notre capacité à produire
                                    un contenu de
                                    haute qualité qui répond à vos besoins spécifiques.</p>

                                <p>Pour notre service de rédaction générale, nous avons besoin de quelques informations
                                    de base pour commencer à travailler sur votre projet:</p>
                                <ul>
                                    <li>Le sujet et l'objectif du texte</li>
                                    <li>Type de contenu que vous souhaitez produire</li>
                                    <li>A qui est présenté votre travail</li>
                                    <li>Mise en forme</li>
                                    Cela nous aidera à comprendre le public cible et à produire un contenu adapté à ses
                                    besoins.
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mise en forme : Ce que nous avons besoin</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p>Précisez les détails pour votre mise en forme dans le champ <code style="font-size: 15px">Informations supplémentaires sur la mise en forme</code></p>
                            <ul>
                                <li>Couleur des textes (titres et sous-titre)</li>
                                <li>Marges et type de format</li>
                                <li>Disposition des textes</li>
                                <li>Interligne et pagination</li>
                                <li>Autres préciser </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    <br>
    <div class="col-lg-6">
        <a type="button"
            href="{{route('status',$work_id)}}"
            class="btn btn-primary">Retour
        </a>
    </div>
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


@include('client.template.footer');
