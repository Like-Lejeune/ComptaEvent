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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profiles</a></li>
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
                                    PROFILS
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
                            <div class="col-6 col-sm-4">
                                <div class="p-3 border border-dashed border-start-0">
                                    <a href="{{ route('profiles.create') }}" type="button" class="btn btn-outline-success waves-effect waves-light">Ajouter Profil</a>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-6 col-sm-4">
                                <div class="p-3 border border-dashed border-start-0">
                                    <p class="text-muted mb-0">Total Profils</p>
                                    <h5 class="mb-1"><span class="counter-value"
                                        data-target="{{ $profiles->count() }}">0</span> </h5>
                                </div>
                            </div>
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
                        <h5 class="card-title mb-0" style="font-size: 25px">Liste des Profils</h5>
                        <br>
                    </div>
                    <div class="card-body">
                        <div class=table-responsive>
                            <table id="table1"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($profiles as $profile)
                                   
                                @endforeach
                                    @forelse ($profiles as $profile)
                                    <tr>
                                        <td>{{ $profile->id }}</td>
                                        <td>{{ $profile->name }}</td>
                                        <td>{{ $profile->description }}</td>
                                        <td>
                                            {{-- <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-info">Voir</a> --}}
                                            <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-outline-warning waves-effect waves-light">Modifier</a>
                                            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outline-danger waves-effect waves-light" onclick="return confirm('Supprimer ce profil ?')">Supprimer</button>
                                            </form>
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
@include('template.footer')
