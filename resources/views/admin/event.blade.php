@include('template.header');



<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Evenement</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Evenement</a></li>
                            <li class="breadcrumb-item active"></li>
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
                                   Mes Activités
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
                        <h5 class="card-title mb-0">Informations</h5>
                        <br>

                    </div>
                    <div class="card-body">
                        <div class="col-sm-auto mb-2">

                            <div>
                                <a class="btn btn-outline-info btn-label waves-effect right waves-light  mb-3  "
                                    type="button" id="addService" >

                                    <i class="ri-add-line label-icon align-middle fs-16 me-2 "></i>
                                    <span class="flex-grow-1 ms-2">
                                      Ajouter une activité
                                    </span>

                                </a>
                                @if(session()->has('success'))

                                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong  style='font-size:20px;'> &#128077; </strong>  {{ session()->get('success') }}
                                  </div>
                                    
                                       
                                 
                                @endif
                            </div>
                        </div>
                        <table id="table1" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th data-sort="#">ID</th>
                                    <th data-sort="">Nom</th>
                                    <th data-sort="">Description</th>
                                    <th data-sort="">Date Début</th>
                                    <th data-sort="">Date Fin</th>
                                    <th data-sort="" >Budget Total</th>
                                    <th data-sort="">Année</th>
                                    <th data-sort="">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @forelse ($evenements as $evt)
                                <tr>
                                    <td>{{ $evt->id }}</td>
                                    <td>{{ $evt->nom }}</td>
                                    <td>{{ Str::limit($evt->description, 50) }}</td>
                                    <td>{{ $evt->date_debut }}</td>
                                    <td>{{ $evt->date_fin }}</td>
                                    <td>{{ number_format($evt->budget_total, 2, ',', ' ') }}</td>
                                    <td class="{{ $evt->jours_color }}">{{ $evt->jours_text }}</td>
                                    <td>
                                    <a href="{{ route('serviceMenu', $evt->id) }}" type="button" class="btn btn-outline-secondary waves-effect waves-light">Consulter</a>
                                    <a href="" type="button" class="btn btn-outline-secondary waves-effect waves-light">Modifier</a>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td style="align-items: center;"> Aucune activité</td>
                            </tr>
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
    function affiche(){
        $('#theme').attr('data-bs-target','#theme-settings-offcanvas');
        }
</script>
@include('template.footer');