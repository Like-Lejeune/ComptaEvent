@include('editeur.template.header');

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Télécharger</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"> <b>Documents à considérer</b> </h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row">
                                @forelse ($documents as $work_doc)
                                    <div class="col-3" title="telecharger">
                                        <div class="flex-shrink-0 me-3">
                                            <a href="{{ url('images/works_docs', $work_doc->code_doc)}}" download >
                                                <div class="avatar-md">
                                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                                        <i class="ri-folder-zip-line"></i>
                                                    </div>
                                                </div>
                                             </a>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <br>
                                            <h5 class="fs-13 mb-1">
                                                <a type="button" download  href="{{ url('images/works_docs',$work_doc->code_doc) }}"
                                                    class="text-body text-truncate d-block">Télécharger</a>
                                            </h5>
                                        </div>
                                    </div><!-- end col -->
                                @empty
                                    <div class="col-3" title="telecharger">
                                        <img class="img-thumbnail" alt="200x200" width="200"
                                            src="{{ url('images/nft/img-03.jpg') }}" data-holder-rendered="true">
                                        <a type="button"
                                            class="btn btn-outline-primary btn-icon waves-effect waves-light shadow-none"
                                            title="telecharger"><i class="ri-download-fill"></i></a>
                                    </div><!-- end col -->
                                @endforelse
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div>
        </div>
    </div>
    <!-- container-fluid -->
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
<script>
    function submit(val) {

        $('#submit')[0].reset();
        if (val == 1) {
            $('#submitLabel').html("Documents traités");
            document.querySelector('#add_update').style.display = 'block';
            document.querySelector('#delete').style.display = 'none';
            document.querySelector('#lord').style.display = 'none';
            document.querySelector('#lord2').style.display = 'block';

        } else if (val == 2) {
            $('#submitLabel').html("Modifier les documents");
            document.querySelector('#add_update').style.display = 'block';
            document.querySelector('#delete').style.display = 'none';
            document.querySelector('#lord').style.display = 'none';
            document.querySelector('#lord2').style.display = 'block';
        } else if (val == 3) {
            $('#submitLabel').html("Suppression ?");
            document.querySelector('#add_update').style.display = 'none';
            document.querySelector('#delete').style.display = 'block';
            document.querySelector('#lord').style.display = 'block';
            document.querySelector('#lord2').style.display = 'none';
        }
        $('#action_').val(val);
        $('#submitModal').modal('show');
    };
</script>
<script>
    setTimeout(function() {
        document.querySelector('.alert-success').style.display = 'none';

    }, 10000);
    setTimeout(function() {

        document.querySelector('.alert-warning').style.display = 'none';
    }, 10000);
</script>
@include('editeur.template.footer');
