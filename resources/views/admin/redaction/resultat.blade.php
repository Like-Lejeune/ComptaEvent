@include('template.header');

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Vérification & validation</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"> <b>Résultat du travail</b> </h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                @forelse ($resultat as $resultat_doc)
                                    <div class="col-3" title="telecharger">
                                        <div class="flex-shrink-0 me-3">
                                            <a href="{{ url('images/work_end', $resultat_doc->code_document)}}" download >
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                             </a>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <br>
                                            <h6 class="fs-14 mb-4">{{$resultat_doc->code_document}}</h6>
                                            <h5 class="fs-13 mb-1">
                                                <a type="button" download  href="{{ url('images/work_end',$resultat_doc->code_document) }}"
                                                    class="text-body text-truncate d-block">Télécharger</a>
                                            </h5>
                                        </div>
                                    </div><!-- end col -->
                                @empty
                                    <div class="col-3" title="telecharger">
                                        <img class="img-thumbnail" alt="200x200" width="200"
                                            src="{{ url('images/nft/img-03.jpg') }}" data-holder-rendered="true">
                                        <a type="button"
                                            class="btn btn-outline-primary btn-icon waves-effect waves-light shadow-none"
                                            title="telecharger"><i class="ri-download-fill"></i></a>
                                    </div><!-- end col -->
                                @endforelse
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                    <div class="col-3">
                                        <button type="button" class="btn btn-primary waves-effect waves-light shadow-none" onclick='refaire()'>à refaire</button>
                                    </div><!-- end col -->
                                    <div class="col-3">
                                        <button type="button" class="btn btn-success waves-effect waves-light shadow-none" onclick='envoyer_client()'>Envoyer</button>
                                    </div><!-- end col -->
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
            {{-- Work time --}}
                <div class="col-sm-auto mb-2">
                    <div class="modal fade" id="refaire" data-bs-backdrop="static" tabindex="-1"
                        aria-labelledby="exampleModalLabel_" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel_" style="font-size: 20px">A refaire par l'éditeur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form id="admin" action="{{ route('refaire') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body text-center p-5">
                                        <lord-icon
                                            src="https://cdn.lordicon.com/puvaffet.json"
                                            trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:130px;height:130px">
                                        </lord-icon>
                                        <div class="mt-4 pt-4">
                                            <h4>Décrire ce qu'il faut refaire</h4>
                                            <div>
                                                <label for="exampleFormControlTextarea5" class="form-label">.</label>
                                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                            </div><br>
                                            <!-- Toogle to second dialog -->
                                            <input name="id_work_end" id="id_work_end" value="{{$id_work_end}}"
                                            type="hidden">
                                            <input name="id_work" id="id_work" value="{{$work_id}}"
                                            type="hidden">
                                            <button class="btn btn-success" type="submit">
                                                Confirmer
                                            </button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            {{-- Work time --}}
            <div class="col-sm-auto mb-2">
                <div class="modal fade" id="envoyer_client" data-bs-backdrop="static" tabindex="-1"
                    aria-labelledby="exampleModalLabel_" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel_" style="font-size: 20px">Confirmer l'envoie au client</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form id="admin" action="{{ route('envoyer_client') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body text-center p-5">
                                    <lord-icon
                                        src="https://cdn.lordicon.com/rhvddzym.json"
                                        trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:130px;height:130px">
                                    </lord-icon>
                                    <div class="mt-4 pt-4">
                                        <h6>Cette action est irréversible.</h6>
                                        <!-- Toogle to second dialog -->
                                        <input name="work_editor_id" id="work_editor_id" value="{{ $work_editor_id }}"
                                            type="hidden">
                                        <button class="btn btn-success" type="submit">
                                            Confirmer
                                        </button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"> <b>Documents à considérer</b> </h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                @forelse ($documents as $work_doc)
                                    <div class="col-3" title="telecharger">
                                        <div class="flex-shrink-0 me-3">
                                            <a href="{{ url('images/works_docs', $work_doc->code_doc)}}" download >
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                             </a>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <br>
                                            <h5 class="fs-13 mb-1">
                                                <a type="button" download  href="{{ url('images/works_docs',$work_doc->code_doc) }}"
                                                    class="text-body text-truncate d-block">Télécharger</a>
                                            </h5>
                                        </div>
                                    </div><!-- end col -->
                                @empty
                                    <div class="col-3" title="telecharger">
                                        <img class="img-thumbnail" alt="200x200" width="200"
                                            src="{{ url('images/nft/img-03.jpg') }}" data-holder-rendered="true">
                                        <a type="button"
                                            class="btn btn-outline-primary btn-icon waves-effect waves-light shadow-none"
                                            title="telecharger"><i class="ri-download-fill"></i></a>
                                    </div><!-- end col -->
                                @endforelse
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
<!-- listjs init -->
<script src="{{ url('control/js/pages/listjs.init.js') }}"></script>

<script src="{{ url('control/libs/list.pagination.js/list.pagination.min.js') }}"></script>


<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('control/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- cleave.js -->
<script src="{{ url('control/libs/cleave.js/cleave.min.js') }}"></script>
<!-- form masks init -->
<script src="{{ url('control/js/pages/form-masks.init.js') }}"></script>
<script>
    function refaire() {
        $('#refaire').modal('show');
    };

    function envoyer_client() {
        $('#envoyer_client').modal('show');
    };
</script>
<script>
    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';

    }, 10000);
    setTimeout(function() {

        document.querySelector('.alert-warning').style.display = 'none';
    }, 10000);
</script>
@include('editeur.template.footer');
