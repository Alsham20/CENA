<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('newsletters.index')}}">Abonnés</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter des abonnés</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="store" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Modèle de fichiers de chargement des abonnés</label>
                                <br>
                                <a href="{{url('assets/FOLLOWERS_CREATE_MODEL.xlsx')}}" download="">FOLLOWER_MODELE.XLSX</a>
                            </div>

                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Catégorie</p>

                                <select wire:model="categorie" class="select2 form-control categorie" data-toggle="select2" data-placeholder="Choisir ...">
                                    <option value="">Choisir</option>
                                    <option value="-1">Visiteur</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->label}}</option>
                                    @endforeach

                                </select>
                                @error('categorie')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> <!-- end col -->

                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Pièce jointe</label>
                                <input type="file" wire:model="attached_file_" id="example-fileinput" class="form-control">
                            </div>

                            <div class="mb-0">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
                        </div>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <!-- end row -->

</div>
@include('livewire.chunks.notification')
@script()
<script>
    document.addEventListener('livewire:initialized', function () {
        $('.categorie').select2(
            {
                placeholder: 'Choisir une catégorie'
            });
        $('.categorie').on('change', function() {
            console.log(this.value);
        @this.set('categorie', this.value);
        })
    });
</script>
@endscript
