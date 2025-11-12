@include('template.header');

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Passer au plan Pro</h4>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0 text-center">Plan Pro</h4>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Profitez de toutes les fonctionnalités premium : multi-utilisateurs, duplication d’événements et support prioritaire.</p>
                <h2 class="fw-bold text-warning mb-3">9 900 FCFA / mois</h2>

                <form method="POST" action="{{ route('subscription.pay', ['plan' => 'pro']) }}">
                    @csrf
                    <button class="btn btn-warning text-white px-5 py-2">
                        Souscrire maintenant
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
 
@include('template.footer');
