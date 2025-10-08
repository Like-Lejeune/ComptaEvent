@include('template.header');

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Plans d’abonnement</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">
                            <b>Choisissez le plan qui vous convient</b>
                        </h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                {{-- Freemium --}}
                                <div class="col-md-4 mb-4">
                                    <div class="card border shadow-none">
                                        <div class="card-header bg-light text-center">
                                            <h5 class="mb-0">Freemium</h5>
                                            <p class="text-muted small mb-0">Idéal pour débuter</p>
                                        </div>
                                        <div class="card-body text-center">
                                            <h2 class="fw-bold">0 FCFA</h2>
                                            <p class="text-muted mb-4">Gratuit à vie</p>
                                            <ul class="list-unstyled text-start small">
                                                <li>✅ 1 événement</li>
                                                <li>✅ 5 services max</li>
                                                <li>❌ Pas d’export PDF</li>
                                                <li>❌ Pas de multi-utilisateurs</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer text-center bg-light">
                                            <a href="#" class="btn btn-secondary w-100">
                                                Déjà activé
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Standard --}}
                                <div class="col-md-4 mb-4">
                                    <div class="card border-primary border-2 shadow-sm">
                                        <div class="card-header bg-primary text-center text-white">
                                            <h5 class="mb-0">Standard</h5>
                                            <p class="text-white-50 small mb-0">Pour les organisateurs actifs</p>
                                        </div>
                                        <div class="card-body text-center">
                                            <h2 class="fw-bold text-primary">4 900 FCFA</h2>
                                            <p class="text-muted mb-4">par mois</p>
                                            <ul class="list-unstyled text-start small">
                                                <li>✅ Événements illimités</li>
                                                <li>✅ Services illimités</li>
                                                <li>✅ Export PDF</li>
                                                <li>❌ Pas de multi-utilisateurs</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer text-center bg-light">
                                            <a href="{{ route('subscription.upgrade') }}" class="btn btn-primary w-100">
                                                Passer en Standard
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pro --}}
                                <div class="col-md-4 mb-4">
                                    <div class="card border-warning border-2 shadow-sm">
                                        <div class="card-header bg-warning text-center text-white">
                                            <h5 class="mb-0">Pro</h5>
                                            <p class="text-white-50 small mb-0">Pour les grandes organisations</p>
                                        </div>
                                        <div class="card-body text-center">
                                            <h2 class="fw-bold text-warning">9 900 FCFA</h2>
                                            <p class="text-muted mb-4">par mois</p>
                                            <ul class="list-unstyled text-start small">
                                                <li>✅ Tout du plan Standard</li>
                                                <li>✅ Multi-utilisateurs</li>
                                                <li>✅ Duplication d’événements</li>
                                                <li>✅ Support prioritaire</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer text-center bg-light">
                                            <a href="{{ route('subscription.pro') }}" class="btn btn-warning w-100 text-white">
                                                Passer en Pro
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end row -->
                        </div> <!-- end live-preview -->
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    </div> <!-- container-fluid -->
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

@include('template.footer');
