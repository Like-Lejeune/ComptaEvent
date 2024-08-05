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
                    <h4 class="mb-sm-0">RECETTE </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">AJOUTER UNE RECETTE</a></li>
                        </ol>
                    </div>

                </div>

            </div>
        </div>
        <!-- end page title -->


        <br><br>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif

        <div class="row mt-2">
            <div class="col-lg-12">
                <form id="admin" action="{{ route('submit_recette') }}"  method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">AJOUTER UNE RECETTE</h4>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="col-xxl-6">
                                    <label for="placeholderInput" class="form-label"> <b style="font-size: 16px">
                                        Service </b> </label>
                                    <select class="js-example-basic-multiple"  name="service_id">
                                        @foreach ( $service as $service )
                                        <option value="{{$service->id_service}}">
                                            {{$service->s_name}}</option>
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xxl-6">
                                    <label for="placeholderInput" class="form-label"> <b style="font-size: 16px">
                                        Choisir le montant (XAF) </b> </label>
                                        <input type="number" class="form-control" name="recette" id="amount" placeholder="Votre montant" min="1000" max="10000000">
                                        <span id="erreurMontant" style="color: red; display: none;">choisir entre 1 000 XAF et  10 000 000 XAF.</span>
                                        
                                </div>
                                <br><br>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Détails de l'opération</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xxl-6">
                                        <div>
                                            <label class="form-label" for="project-thumbnail-img">Pièces jointes (images ou
                                                textes)</label>
                                            <input class="form-control" id="project-thumbnail-img" type="file" name="link_doc[]" multiple  accept="image/png, image/pdf, image/jpeg, image/word">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xxl-6">
                                        <div>
                                            <label for="exampleFormControlTextarea5" class="form-label" name="supplement_forme">Informations supplémentaires</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea5" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xxl-6">
                                            <button type="submit"
                                            class="btn btn-danger btn-label waves-effect waves-light" id="Bsubmit"><i
                                                class="ri-check-double-line label-icon align-middle fs-16 me-2"></i><b
                                                style="font-size: 20px">PAYER</b> </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
               
                </div>
            </form>
                <!-- end row -->
            </div>
            <!-- end col -->
        </div>
        <div class="col-sm-auto mb-2">
            <div class="modal fade" id="paiement" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="exampleModalLabel_" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel_" style="font-size: 20px">Confirm payment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        
                            @csrf
                            <div class="modal-body text-center p-5">
                                <div class="mt-4 pt-4">
                                    <h4>Ce montant sera déduit de ton compte Mytaskwork.</h4>
                                    <!-- Toogle to second dialog -->
                                    <input name="wallet_mtw" id="wallet_mtw" type="hidden">
                                    <button class="btn btn-success" type="submit">
                                        Confirmer
                                    </button>
                                    <button type="button" class="btn btn-light"
                                        data-bs-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
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
        var save_method; //for save method string
        var table;
        $(document).ready(function() {

            $('body').on('click', '.btn btn-success', function() {

                var option_id = $(this).data('.img');
                alert(option_id)
            });

        });

        function typePaiement() {

            //var input = document.getElementById("carte");
            var input = document.getElementById("wallet").value;
            const radios = document.getElementsByName("paid_option");

            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    // Récupérer la valeur du radio bouton coché
                    const valeurCochee = radios[i].value;
                    /* Faire quelque chose avec la valeur (afficher dans la console, etc.)
                    alert("Le radio bouton coché a la valeur : " + valeurCochee); */
                    // Récupérer l'ID de l'élément coché et l'afficher dans l'alerte
                  
                    const idElementCoche = radios[i].id;
                    if(idElementCoche =="comptePhotoquix"){
                        if(Number(valeurCochee)<Number(input)){
                            $('#paiement').modal('show');
                            $('#wallet_mtw').val(Number(valeurCochee));
                        }else{
                            alert(" BALANCE INSUFFISSANTE");
                        }
                       
                    }else{
                        alert("NON VALIDE");
                    }
                    break;
                }
            }
        };

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
