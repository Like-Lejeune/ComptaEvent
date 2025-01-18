@include('template.header');
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Action sur utilisateurs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Formulaire Utilisateur</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
        </div>
       
        <div class="row">
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong style="font-size:20px">{{ $message }}</strong>
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <strong style="font-size:20px">{{ $message }}</strong>
            </div>
            @endif
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <form action="{{route("nouvelUser")}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" name='service_id' value="">
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-priority-input" class="form-label">Nom & Prenom <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nom de l'utilisateur" value="{{ old('name') }}" required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-priority-input" class="form-label">Email <b style="color: #cf4848; font-size:9px">obligatoire</b></label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Adresse e-mail" value="{{ old('email') }}" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                <div class="mb-3 mb-lg-0">
                                    <label for="phone">Numéro de Téléphone :</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Numéro de téléphone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3 mb-lg-0">
                                        <label for="choices-status-input" class="form-label">Service</label>
                                        <select class="js-example-basic-multiple"   multiple style="font-size: 20 px" name='service[]' data-choices data-choices-search-false id="choices-status-input">
                                            @foreach ( $services as $service_ )
                                            <option value="{{$service_->id_service}}">{{$service_->s_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="profil_id">Profil :</label>
                                        <select name="profil_id" id="profil_id"  class="js-example-basic-single" data-choices data-choices-search-false id="choices-status-input"  style="font-size: 20 px" required>
                                            @foreach($profiles as $profile)
                                                <option value="{{ $profile->id }}" {{ old('profil_id') == $profile->id ? 'selected' : '' }}>{{ $profile->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('profil_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <br>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light">
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Créer</button>
                        <a href="{{ route('userlist') }}" class="btn btn-secondary btn-label waves-effect waves-light">
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>Annuler</a>
                    </div>
                </form>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('template.footer');
