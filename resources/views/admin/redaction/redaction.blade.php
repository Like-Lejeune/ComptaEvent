<style>
    th {
        font-size: 20px;
    }

    td {
        font-size: 18px;
    }
</style>

@include('template.header');



<div class="page-content">

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Administrateur</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Rédaction generale</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card card-animate" style="background-color: #1c1c36; color: #ffffff;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                    Rédaction generale
                                </h2>
                            </div>
                            <div>

                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0" style="font-size: 25px">Informations</h5>
                        <br>

                    </div>
                    <div class="card-body">
                        <div class="col-sm-auto mb-2">
                            <div class="modal fade" id="showModal_affect" data-bs-backdrop="static" tabindex="-1"
                                aria-labelledby="exampleModalLabel_" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel_" style="font-size: 20px">
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form id="admin_" action="{{route('affectxedit')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <ul class='alert alert warning d-one' id='save_errorList'></ul>
                                                <div class="row">
                                                    <div class="mb-" id="modal-id" style="display: none;">
                                                        <label for="id-field" class="form-label">ID</label>

                                                    </div>
                                                    @php
                                                        $editeurs = DB::table('users')
                                                            ->where('type', '=', 'editeur')
                                                            ->get();
                                                    @endphp
                                                    <div class="col-lg-12 mb-3">
                                                        <label for="customername-field" class="form-label"
                                                            style="font-size: 20px">Choississez l'éditeur
                                                        </label>
                                                        <select class="form-select" name="editor"
                                                            aria-label="Disabled select example"
                                                            style="font-size: 18px"  required>
                                                            @foreach ($editeurs as $item)
                                                                @php
                                                                    $nb_projet = DB::table('work_editor')
                                                                        ->join('users', 'editor_id', '=', 'users.id')
                                                                        ->select('*')
                                                                        ->where('users.id', '=', $item->id)
                                                                        ->count();
                                                                @endphp

                                                                @if ($nb_projet < 6)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }} -
                                                                        Travaux({{$nb_projet}})</option>
                                                                @endif
                                                            @endforeach

                                                        </select>
                                                        <input name="id_work" id="id_work" type="hidden">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="btnSave"
                                                        class="btn btn-secondary">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <table id="table1"
                            class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">

                            <thead class="table-primary">
                                <tr>

                                    <th data-sort="# ">N°</th>
                                    <th data-sort="">Nom du travail</th>
                                    <th data-sort="">Type de document</th>
                                    <th data-sort=""> Client</th>
                                    <th data-sort="">Action</th>

                                </tr>
                            </thead>
                            @php
                                $works = DB::table('works')
                                    ->select('*')
                                    ->join('services', 'service', '=', 'id_service')
                                    ->where('s_name', '=', 'REDACTION GENERALE')
                                    ->where('w_treatment', '=', 'traitement')
                                    ->get();
                                $val = 1;
                            @endphp
                            <tbody>
                                @forelse($works as $work)
                                    <tr>
                                        <td data-sort="">{{$val++}}</td>
                                        <td data-sort="">{{$work->titre_travail}}</td>
                                        @php
                                            $typeDoc = DB::table('type_document')
                                                ->where('id_type_document','=',$work->type_document)
                                                ->first();
                                        @endphp 
                                        <td data-sort="">{{$typeDoc->name_type}}</td>
                                        @php
                                            $user_n = DB::table('works')
                                                ->join('users', 'user_id', '=', 'users.id')
                                                ->select('*')
                                                ->where('id_work', '=', $work->id_work)
                                                ->first();
                                        @endphp

                                        <td data-sort="">{{$user_n->name}} </td>
                                        <td data-sort="">

                                            @php
                                                $nb_projet = DB::table('work_editor')
                                                    ->join('users', 'editor_id', '=', 'users.id')
                                                    ->select('*')
                                                    ->where('work_id', '=', $work->id_work)
                                                    ->count();
                                            @endphp

                                            @if ($nb_projet == 0)
                                                <button type="button" id="btnAffect" class="btn btn-primary"
                                                    onclick="affect({{$work->id_work}});">Assigner
                                                </button>
                                            @else
                                                <a type="button" id="btnStatus"
                                                    href="{{route('status', $work->id_work)}}"
                                                    class="btn btn-danger">Status
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="6" class="text-center"><b>Aucun travail en traitement</b></td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->

    <!-- container-fluid -->
</div>
</div>


<!-- listjs init -->
<script src="{{ url('control/js/pages/listjs.init.js') }}"></script>

<script src="{{ url('control/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="{{ url('control/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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

<!-- notifications init -->
<script src="{{ url('control/js/pages/notifications.init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function affiche() {


        $('#theme').attr('data-bs-target', '#theme-settings-offcanvas');

    }




    function affect(val) {
        $('#exampleModalLabel_').html("ASSIGNER A L'EDITEUR");
        $('#id_work').val(val);
        $('#showModal_affect').modal('show');
    };


    function status(val) {

        $.get("status" + '/' + val + '/edit', function(data) {

            $('#exampleModalLabel').html("Status project");
            $('#btnSave').text("save");
            $('#showModal').modal('show');
            $('#projet_name').val(data.ptj_name);
            $('#projet_paid').val(data.ptj_paid);
            $('#projet_treatment').val(data.ptj_treatment);
            $('#name').val(data.name);

        })
    };
</script>



@include('template.footer');
