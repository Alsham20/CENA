<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('events.index')}}">Evènements</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier un évènement</h4>
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
                                <input wire:model="event_name" type="text" id="simpleinput" class="form-control">
                                @error('event_name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Lieu</label>
                                <input wire:model="place" type="text" id="simpleinput" class="form-control">
                                @error('place')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="event_date" class="form-label">Date</label>
                                <input wire:model="event_date" type="date" id="event_date" class="form-control">
                                @error('event_date')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="example-date" class="form-label">Date de début</label>
                                    <input wire:model="date_debut" class="form-control" id="example-date" type="date">
                                    @error('date_debut')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="example-time" class="form-label">Heure de début</label>
                                    <input wire:model="heure_debut" class="form-control" id="example-time" type="time">
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
                                    <input wire:model="date_fin" class="form-control" id="example-date" type="date">
                                    @error('date_fin')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="example-time" class="form-label">Heure de fin</label>
                                    <input wire:model="heure_fin" class="form-control" id="example-time" type="time">
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
                                    {!! $event_description !!}
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <p class="mb-1 fw-bold text-muted">Categorie</p>

                                    <select wire:model="category" class="select2 form-control category"
                                        data-toggle="select2" data-placeholder="Choose ...">
                                        <option></option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}" @if($category == $item->id) selected @endif>{{$item->label}}</option>
                                        @endforeach

                                    </select>
                                    @error('category')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div> <!-- end col -->

                                <div class="mb-3">
                                    <label for="poster" class="form-label">Poster</label>

                                    <div class="card mb-0 h-100 poster_card d-none">
                                        <div class="card-body">
                                            <div class="border-dashed border rounded col-3 p-1">
                                                <img src="#" class="img-thumbnail m-1 poster_thumb"
                                                    style="cursor: pointer" alt="">
                                            </div>
                                        </div> <!-- end card-body -->
                                    </div>
                                    @error('poster') <span class="error">{{ $message }}</span> @enderror
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#bs-example-modal-lg">Choisir une image
                                    </button>
                                    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Choisir une
                                                        image</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @livewire('admin.medias.widget')
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>


                                </div>
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
    @include('livewire.chunks.widget-model')
</div>
@assets
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
<script src="{{ asset('assets/datepicker.js') }}"></script>
<script src=" https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js "></script>
@endassets
@include('livewire.chunks.notification')
@script
<script>
    document.addEventListener('livewire:initialized', function() {
        let modalWidget = null;

        $('.category').on('change', function() {

            @this.set('category', this.value);
        })
        $('.poster_thumb').attr('src', '{{ $poster_url }}');
        $('.poster_card').removeClass('d-none');

        const event_description = new Quill('#event_description', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        script: 'super'
                    }, {
                        script: 'sub'
                    }],
                    [{
                        header: [1, 2, 3, 4, 5, 6]
                    }, 'blockquote', 'code-block'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }, {
                        indent: '-1'
                    }, {
                        indent: '+1'
                    }],
                    ['direction', {
                        align: []
                    }],
                    ['link', 'image', 'video'],
                    ['clean'],
                ],
            },
        });


        event_description.on('text-change', () => {
            @this.set('event_description', event_description.getSemanticHTML(), false);
        });

        $wire.on('updatePoster', (d) => {
            if (modalWidget == "event_description") {

                const range = snowEditor.getSelection();
                console.log(range.index, d[0]);
                if (range) {
                    snowEditor.insertEmbed(range.index, 'image', d[0]);
                }
            } else {
                $('.poster_thumb').attr('src', d);
                $('.poster_card').removeClass('d-none');
            }
            modalWidget = null;
            @this.set('modalWidget', null, true);
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });
    });
</script>
@endscript