@include('template.header');



<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Services</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">services</a></li>
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
                                   Tous les services
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
                                      Ajouter les services
                                    </span>

                                </a>
                                @if(session()->has('success'))

                                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong  style='font-size:20px;'> &#128077; </strong>  {{ session()->get('success') }}
                                  </div>
                                    
                                       
                                 
                                @endif
                            </div>

                            <div class="modal fade" id="showModal" data-bs-backdrop="static" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel"> </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form id="service" method="POST" action="{{ route('update_service') }}" enctype="multipart/form-data">

                                            @csrf
                                            <div class="modal-body">

                                                <ul class='alert alert warning d-one' id='save_errorList'></ul>
                                                <div class="row">
                                                    <div class="mb-" id="modal-id" style="display: none;">
                                                        <label for="id-field" class="form-label">ID</label>

                                                    </div>

                                                    <div class="col-lg-12 mb-3">
                                                        <label for="customername-field" class="form-label">Name
                                                        </label>
                                                        <input name="id_service" id="id_service" type="hidden">
                                                        <input name="name_service" id="name_service"
                                                            class="form-control" type="text" readonly>
                                                        <br>
                                                        <label for="customername-field" class="form-label">Prix min 
                                                        </label>
                                                        <input name="price_service" id="price_service"
                                                            class="form-control" type="float">
                                                        <br>
                                                        <label for="customername-field" class="form-label">Description
                                                        </label>
                                                        <textarea class="form-control" aria-label="With textarea"
                                                            rows="3" name="description_service"
                                                            id="description_service"></textarea>
                                                        <br>
                                                        <br>
                                                        <label for="formFileMultiple" class="form-label">Image
                                                        </label>
                                                        <input class="form-control" type="file" name="image" id="imagecreate"
                                                            accept="png,jpg,jpeg" required>


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


                            <div class="modal fade" id="showModal_" data-bs-backdrop="static" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">

                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel_"> </h5>
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

                        </div>
                        <table id="table1" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th data-sort="#">N°</th>
                                    <th data-sort="">Service</th>
                                    <th data-sort="">Budget</th>
                                    <th data-sort="">Solde</th>
                                    <th data-sort="">Action</th>
                                </tr>
                            </thead>
                            @php
                            $services = DB::table('services')
                                         ->select('*')
                                         ->orderby('s_name', 'ASC')
                                         ->get();
                                         $pos=1;
                            @endphp
                            <tbody>
                                @forelse ($services as $service)
                                <tr>
                                  <td>{{$pos++}}</td>
                                  <td>{{$service->s_name}}</td>
                                  <td>{{$service->s_budget}}</td>
                                  <td>{{$service->s_solde}}</td>
                                  <td>
                                    <a href="" type="button" class="btn btn-outline-secondary waves-effect waves-light">Modifier</a>
                                  </td>
                                </tr><!-- end tr -->
                            @empty
                            <tr>
                                <td style="align-items: center;"> No service</td>
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


<script type="text/javascript">

$(document).ready(function() {
 
$('body').on('click', '.editService', function () {
    $('#service')[0].reset();
        var service_id = $(this).data('id');
        $.get("ajax_admin_service" +'/' + service_id +'/edit', function (data) {
            $('#exampleModalLabel').html("Editer le service");
            $('#btnSave').text("save");
           
            $('#showModal').modal('show');
            $('#id_service').val(data.id_service); 
            $('#name_service').val(data.s_name); 
            $('#description_service').val(data.s_description);   
            $('#price_service').val(data.s_price); 
             
        })
    });
  

    $('body').on('click', '#addService', function () {
     
       
       
            $('#exampleModalLabel_').html("Add service");
            $('#btnSave_').text("Enregistrer");
            $('#service_')[0].reset();
            $('#showModal_').modal('show');
    });
});
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function affiche(){
        $('#theme').attr('data-bs-target','#theme-settings-offcanvas');
        }
</script>
@include('template.footer');