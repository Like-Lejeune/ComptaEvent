@include('template.header');

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Passer au plan Standard</h4>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">Plan Standard</h4>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Débloquez les exports PDF et la gestion illimitée des événements.</p>
                <h2 class="fw-bold text-primary mb-3">4 900 FCFA / mois</h2>

                <form method="POST" action="{{ route('subscription.pay', ['plan' => 'standard']) }}">
                    @csrf
                    <button class="btn btn-primary px-5 py-2">
                        Souscrire maintenant
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('template.footer');
