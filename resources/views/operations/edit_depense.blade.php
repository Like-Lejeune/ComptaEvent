@include('template.header');
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

    .figure {
        display: inline-block;
    }

    .frame {
        width: 300px;
        /* Ajustez la taille du cadre selon vos besoins */
        height: 200px;
        /* Ajustez la taille du cadre selon vos besoins */
        border: 1px solid #ccc;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image {
        display: block;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Styles spécifiques pour les écrans de petite taille */
    @media (max-width: 767px) {
        figure {
            display: block;
            margin: 0 auto;
            max-width: 300px;
        }

        div {
            max-width: 100%;
        }
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">DEPENSE</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">AJOUTER UNE DEPENSE</a></li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <!-- end page title -->


        <br><br>
        <div class="row mt-2">
            <div class="col-lg-12">
                <form id="admin" action="{{ route('update_depense')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- méthode PUT pour update --}}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">MODIFIER UNE DEPENSE</h4>
                                </div>

                                <div class="card-body">
                                    <div class="col-xxl-6">
                                        <label class="form-label">
                                            <b style="font-size: 16px">Designation<b style="color: red;">*</b></b>
                                        </label>
                                        <input type="hidden" name="id_depense" value = {{$depense->id_depense}} >
                                        <input type="text" class="form-control" name="designation" 
                                            value="{{ old('designation', $depense->d_name) }}" 
                                            placeholder="designation de la dépense">
                                    </div><br>

                                    <div class="col-xxl-6">
                                        <label class="form-label">
                                            <b style="font-size: 16px">Service <b style="color: red;">*</b></b>
                                        </label>
                                        <select class="js-example-basic-multiple" name="service_id">
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id_service }}" 
                                                    {{ $depense->service_id == $service->id_service ? 'selected' : '' }}>
                                                    {{ $service->s_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div><br>

                                    <div class="col-xxl-6">
                                        <label class="form-label">
                                            <b style="font-size: 16px">Choisir le montant (XAF)</b>
                                        </label>
                                        <input type="number" class="form-control" name="depense" id="amount" 
                                            value="{{ old('depense', $depense->s_depense) }}"
                                            min="1000" max="10000000">
                                        <span id="erreurMontant" style="color: red; display: none;">
                                            choisir entre 1 000 XAF et 10 000 000 XAF.
                                        </span>
                                    </div>
                                    <br><br>
                                </div>
                            </div>
                        </div> 

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Détails de l'opération</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Input Date -->
                                        <div class="col-xxl-6">
                                            <div>
                                                <label class="form-label">Date de l'opération <b style="color: red;">*</b></label>
                                                <input type="datetime-local" class="form-control" name="date_operation" 
                                                    value="{{ old('date_operation', \Carbon\Carbon::parse($depense->date_operation)->format('Y-m-d\TH:i')) }}">
                                            </div>
                                        </div>

                                        <div class="col-xxl-6">
                                            <div>
                                                <label class="form-label">Nouvelles pièces jointes (images ou textes)</label>
                                                <input class="form-control" type="file" name="link_piece[]" multiple  
                                                    accept="image/png, application/pdf, image/jpeg, application/msword">
                                            </div>
                                        </div>

                                        <div class="col-xxl-12 mt-3">
                                            <label class="form-label">Pièces jointes existantes :</label><br>
                                            @foreach($pieces as $piece)
                                                <a href="{{ asset('images/work_doc/'.$piece->piece_name) }}" target="_blank">
                                                    📎 {{ $piece->piece_name }}
                                                </a><br>
                                            @endforeach
                                        </div>

                                        <div class="col-xxl-6 mt-3">
                                            <label class="form-label">Informations supplémentaires</label>
                                            <textarea class="form-control" name="sup_info" rows="3">{{ old('sup_info', $depense->d_description) }}</textarea>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-xxl-6">
                                            <button type="submit" class="btn btn-primary btn-label waves-effect waves-light">
                                                <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>
                                                <b style="font-size: 16px">Mettre à jour</b>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>



   <!-- listjs init -->
   <script src="{{ url('control/js/pages/listjs.init.js') }}"></script>

   <script src="{{ url('control/libs/list.pagination.js/list.pagination.min.js') }}"></script>


   <script src="{{ url('control/others/code.jquery.com/jquery-3.6.0.min.js') }}"
       integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


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



<script type="text/javascript">

        const inputMontant = document.getElementById('amount');
        const erreurMontant = document.getElementById('erreurMontant');
        const Bsubmit = document.getElementById('Bsubmit');

        inputMontant.addEventListener('input', function() {
            const valeurMontant = parseInt(inputMontant.value);

            if (isNaN(valeurMontant) || valeurMontant < 1000 || valeurMontant > 10000000) {
                erreurMontant.style.display = 'inline';
                Bsubmit.style.display ='none';
            } else {
                erreurMontant.style.display = 'none';
                Bsubmit.style.display ='block';
            }
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

    @include('template.footer');
