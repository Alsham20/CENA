<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Evènements</a></li>
                        <li class="breadcrumb-item active">Afficher</li>
                    </ol>
                </div>
                <h4 class="page-title">Afficher un évènement</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="update">
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
                                <label for="simpleinput" class="form-label">Nom de l'évènement</label>
                                <input disabled wire:model="event_name" type="text" id="simpleinput" class="form-control">
                                @error('event_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Lieu</label>
                                <input disabled wire:model="place" type="text" id="simpleinput" class="form-control">
                                @error('place')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="example-date" class="form-label">Date de début</label>
                                    <input disabled wire:model="date_debut" class="form-control" id="example-date" type="date">
                                    @error('date_debut')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="example-time" class="form-label">Heure de début</label>
                                    <input disabled wire:model="heure_debut" class="form-control" id="example-time" type="time">
                                    @error('heure_debut')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="example-date" class="form-label">Date de fin</label>
                                    <input disabled wire:model="date_fin" class="form-control" id="example-date" type="date">
                                    @error('date_fin')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="example-time" class="form-label">Heure de fin</label>
                                    <input disabled wire:model="heure_fin" class="form-control" id="example-time" type="time">
                                    @error('heure_fin')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="event_description" class="form-label">Description</label>
                                @error('event_description')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="event_description" class="mb-3" style="height: 100px;">
                                    {!! $event_description!!}
                                </div>
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
        const event_description = new Quill('#event_description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{font: []}, {size: []}],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{color: []}, {background: []}],
                    [{script: 'super'}, {script: 'sub'}],
                    [{header: [1, 2, 3, 4, 5, 6]}, 'blockquote', 'code-block'],
                    [{list: 'ordered'}, {list: 'bullet'}, {indent: '-1'}, {indent: '+1'}],
                    ['direction', {align: []}],
                    ['link', 'image', 'video'],
                    ['clean'],
                ],
            },
        });

        event_description.enable(false);

        event_description.on('text-change', () => {
        @this.set('event_description', event_description.getSemanticHTML(), false);
        });
    });

</script>
@endscript
