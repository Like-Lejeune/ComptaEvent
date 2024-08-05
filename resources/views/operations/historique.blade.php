<style>
    th {
        font-size: 20px;
    }

    td {
        font-size: 18px;
    }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Ajoutez d'autres styles personnalisés selon vos préférences */
</style>

@include('client.template.header');



<div class="page-content">

    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between"
                    style="background-color: #1c1c36">
                    <h4 class="mb-sm-0" style="color: #ffffff;">Home</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Transactions</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card card-animate" style="background-color: #1c1c36; color: #ffffff;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="mt-4 ff-secondary fw-semibold text-white">
                                   Historique des transactions
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
                        <div class=table-responsive>
                            @php
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                $transaction = DB::table('transactions')
                                    ->join('users', 'intervenant_id', '=', 'users.id')
                                    ->where('users.id', '=', auth()->user()->id)
                                    ->where(function ($query) use ($search) {
                                        $query
                                            ->where('amount', 'LIKE', '%' . $search . '%')
                                            ->orWhere('transaction_type', 'LIKE', '%' . $search . '%')
                                            ->orWhere('transaction_mode', 'LIKE', '%' . $search . '%')
                                            ->orWhere('description', 'LIKE', '%' . $search . '%')
                                            ->orWhere('transactions.created_at', 'LIKE', '%' . $search . '%')
                                            ->orWhere('balance_after_transaction', 'LIKE', '%' . $search . '%');
                                    }) // Filtrer par nom de projet
                                    ->select('users.id','amount' ,'intervenant_id','transaction_type','transaction_mode','description','transactions.created_at','balance_after_transaction')
                                    ->orderBy('transactions.created_at','desc')
                                    ->paginate(20);
                                $val = $transaction->firstItem();
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
                                            href="{{ route('historique_transaction') }}">
                                            <i
                                                class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>refresh</a>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <table id="table1"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead class="table-primary">
                                    <tr>
                                        <th data-sort="# ">N°</th>
                                        <th data-sort="">Date</th>
                                        <th data-sort="">Montant</th>
                                        <th data-sort="">Type </th>
                                        <th data-sort="">Mode</th>
                                        <th data-sort="">Description</th>
                                        <th data-sort="">Balance</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($transaction as $transactions)
                                        <tr>
                                            <td data-sort="">{{ $val++ }}</td>
                                            <td data-sort="">{{ $transactions->created_at }}</td>
                                            <td data-sort=""> <b>{{$transactions->amount}}</b>
                                            </td>
                                            <td data-sort="">{{ $transactions->transaction_type }}</td>
                                            <td data-sort="">{{ $transactions->transaction_mode }}</td>
                                            <td data-sort=""><small
                                                    class="badge badge-soft-dark">{{ html_entity_decode($transactions->description) }}</small>
                                            </td>
                                            <td data-sort=""><small class="badge badge-soft-primary">
                                                {{ $transactions->balance_after_transaction }}</small> </td>  
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <b>{{ __('Aucune donnée disponible') }}</b></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination-container">
                                {{ $transaction->links('pagination::bootstrap-4') }}
                            </div>
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
@include('template.footer');
