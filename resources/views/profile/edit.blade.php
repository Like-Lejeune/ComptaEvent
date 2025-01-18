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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Modifier un profil</a></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">

                <h1>Modifier le Profil : {{ $profile->name }}</h1>

                <form action="{{ route('profiles.update', $profile->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Méthode PUT pour la mise à jour -->
            
                    <div class="form-group">
                        <label for="name">Nom du Profil :</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nom du profil" value="{{ old('name', $profile->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
            
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description du profil">{{ old('description', $profile->description) }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
            
                    <div class="form-group">
                        <label for="list_response">Réponses Associées (JSON) :</label>
                        <textarea name="list_response" id="list_response" class="form-control" placeholder='Exemple: ["create_user", "edit_user"]'>{{ old('list_response', $profile->list_response) }}</textarea>
                        @error('list_response')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <br>
            
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light">Mettre à Jour</button>
                        <a href="{{ route('profiles.index') }}" class="btn btn-outline-secondary waves-effect waves-light">Annuler</a>
                    </div>
                </form>
            </div>
            <div class="col-lg-2">
            </div>
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('template.footer');
