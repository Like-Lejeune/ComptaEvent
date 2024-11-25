<style>
    th {
        font-size: 16px;
    }

    td {
        font-size: 14px;
    }

    .pagination-container {
        margin-top: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Ajoutez d'autres styles personnalisés selon vos préférences */
</style>

@include('template.header')



<div class="page-content">

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between"
                    style="background-color: #1c1c36">
                    <h4 class="mb-sm-0" style="color: #ffffff;"></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
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
                                    Comptes:  
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

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0 align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Statistiques</h4>
                        <div>
                            <a type="button"  href="#" target="_blank" class="btn btn-soft-dark btn-sm shadow-none">
                                Imprimer
                            </a>

                        </div>
                    </div><!-- end card header -->

                    <div class="card-header p-0 border-0 bg-soft-light">
                        <div class="row g-0 text-center">
                            <div class="col-6 col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                    <p class="text-muted mb-0"></p>
                                    <h5 class="mb-1"><span class="counter-value"
                                            data-target="25">0</span></h5>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-6 col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                    <p class="text-muted mb-0">Total budget</p>
                                    <h5 class="mb-1"><span class="counter-value"
                                        data-target="">0</span> XAF</h5>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-6 col-sm-3">
                                <div class="p-3 border border-dashed border-start-0">
                                    <p class="text-muted mb-0">Total dépenses</p>
                                    <h5 class="mb-1"><span class="counter-value"
                                        data-target="">0</span> XAF</h5>
                                </div>
                            </div>
                            <!--end col-->
                           
                            <div class="col-6 col-sm-3">
                                <div class="p-3 border border-dashed border-start-0 border-end-0">
                                    
                                    <p class="text-muted mb-0"><b style="color: red;">Dépassement du Budget de :</b></p> 
                                    <h5 class="mb-1 text-success"><b style="color: red;"><span class="counter-value"
                                        data-target="{">0</span> XAF </b></h5>
                                  
                                    <
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

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0" style="font-size: 25px">Informations</h5>
                        <br>
                    </div>
                    <div class="card-body">
                        <div class=table-responsive>
                            @php
                
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                $users = DB::table('users')
                                    ->where(function ($query) use ($search) {
                                        $query
                                            ->where('name', 'LIKE', '%' . $search . '%')
                                            ->orWhere('email', 'LIKE', '%' . $search . '%');
                                    }) // Filtrer par nom de projet
                                    ->select('*')
                                    ->paginate(10);
                                $val = $users->firstItem();
                            @endphp
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="search-container">
                                            <input type="text" class="form-control" id="search-input"
                                                placeholder="Search..." autocomplete="off" id="search-options"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <a type="button" class="btn btn-dark btn-label waves-effect waves-light"
                                            href="#">
                                            <i
                                                class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>refresh</a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-auto mb-2">
                                <!-- First modal dialog -->
                                <div class="modal fade" id="Delete_" aria-hidden="true" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form id="admin_" action="#" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body text-center p-5">
                                                    <lord-icon src="https://cdn.lordicon.com/jmkrnisz.json"
                                                        trigger="loop" colors="primary:#121331"
                                                        style="width:130px;height:130px">
                                                    </lord-icon>
                                                    <div class="mt-4 pt-4">
                                                        <h4>Supprimer ce compte ? </h4>
                                                        <p class="text-muted"> Action irréversible !.
                                                        </p>
                                                        <!-- Toogle to second dialog -->
                                                        <input name="user_id" id="del_id" type="hidden">
                                                        <button class="btn btn-success" type="submit">
                                                            Ok Supprimer
                                                        </button>
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="ActiveOrDesactive_" aria-hidden="true" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form id="admin_" action="#" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body text-center p-5">
                                                    <lord-icon src="https://cdn.lordicon.com/jmkrnisz.json"
                                                        trigger="loop" colors="primary:#121331"
                                                        style="width:130px;height:130px">
                                                    </lord-icon>
                                                    <div class="mt-4 pt-4">
                                                        <h4>Vous confirmez le changement d'Etat ? </h4>
                                                        <!-- Toogle to second dialog -->
                                                        <input name="user_id" id="ad_id" type="hidden">
                                                        <button class="btn btn-success" type="submit">
                                                            Oui
                                                        </button>
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Annuler</button>
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
                                        <th data-sort="# ">Nom & Prenom</th>
                                        <th data-sort="">email</th>
                                        <th data-sort="">Type</th>
                                        <th data-sort="">Statut</th>
                                        <th data-sort="">Date création</th>
                                        <th data-sort="">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ( $users as $users)
                                        <tr>
                                            <td data-sort="">{{ $val++ }}</td>
                                            <td data-sort="">{{ html_entity_decode($users->name) }}</td>
                                            <td data-sort=""> <b>{{ html_entity_decode($$users->$email) }}</b>
                                            </td>
                                            <td data-sort=""><small>{{ html_entity_decode($users->type) }}</small>
                                            </td>
                                            <td data-sort=""></strong>{{ html_entity_decode($users->status) }}
                                            </td>
                                            <td data-sort=""><small class="badge badge-soft-primary">
                                                {{ html_entity_decode($users->ceated_at) }}</small> </td>
                                            <td data-sort="">
                                                <a href="{{ route('updateUser') }}" type="button" class="btn btn-outline-secondary waves-effect waves-light">Modifier</a>
                                                @if ($users->status == 0)
                                                <a type="button" class="btn btn-outline-dark waves-effect waves-light" onclick="activateOrdesactivate()"> Activer</a>  
                                                @else
                                                <a type="button" class="btn btn-outline-dark waves-effect waves-light" onclick="activateOrdesactivate()">Désactiver</a>  
                                                @endif
                                                <a type="button" class="btn btn-outline-danger waves-effect waves-light" onclick="Delete()">Supprimer</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <b>{{ __('Aucune donnée disponible') }}</b></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{-- <div class="pagination-container">
                                {{ $depense->links('pagination::bootstrap-4') }}
                            </div> --}}
                        </div>
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
</script>
<script>
    const searchInput = document.getElementById('search-input');
    const searchParams = new URLSearchParams(window.location.search);
    searchInput.value = searchParams.get('search') || '';

    searchInput.addEventListener('input', (event) => {
        const searchValue = event.target.value.trim();
        searchParams.set('search', searchValue);
        window.location.href = `{{ request()->url() }}?${searchParams.toString()}`;
    });
</script>
<script>
    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';

    }, 10000);
    setTimeout(function() {

        document.querySelector('.alert-danger').style.display = 'none';
    }, 10000);
</script>

<script>
    function Delete(val) {
        $('#Delete').modal('show');
        $('#del_id').val(val);
    };
    function activateOrdesactivate(val) {
        $('#ActiveOrDesactive').modal('show');
        $('#ad_id').val(val);
    };
</script>

@include('template.footer')
