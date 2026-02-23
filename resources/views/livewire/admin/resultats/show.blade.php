<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('resultats.index')}}">Résultats</a></li>
                        <li class="breadcrumb-item active">Afficher</li>
                    </ol>
                </div>
                <h4 class="page-title">Afficher un résultet</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                    <form>
                        <div class="col-lg-12 mb-3" wire:ignore>
                            <p class="mb-1 fw-bold text-muted">Election</p>
                            <select disabled wire:model="election_id" class="form-control election_id">
                                <option value="">Choisir </option>
                                @foreach ($elections as $election)
                                <option value="{{$election->id}}">{{$election->title}}
                                </option>
                                @endforeach

                            </select>
                            @error('election_id')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Titre du résultat</label>
                            <input disabled wire:model="title" type="text" id="simpleinput" class="form-control">
                            @error('title')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Zone</label>
                            <input disabled wire:model="zone" type="text" id="simpleinput" class="form-control">
                            @error('zone')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_resultat" class="form-label">Date de délibération</label>
                            <input disabled wire:model="date_resultat" type="date" id="date_resultat" class="form-control">
                            @error('date_resultat')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Lien du fichier</label>
                            <input disabled wire:model="url" type="text" id="simpleinput" class="form-control">
                            @error('url')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                            @enderror

                        </div> <!-- end row -->
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
    document.addEventListener('livewire:initialized', function() {


        $('.election_id').select2({
            placeholder: 'Choisir une election',
            clearAll: true
        });

        $('.election_id').on('change', function() {
            @this.set('election_id', this.value);
        });;

    });
</script>
@endscript