<div class="container-fluid">
    <style>
        .datepicker {
            display: block;
            width: 100%;
            padding: .45rem .9rem;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--ct-body-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: var(--ct-input-bg);
            background-clip: padding-box;
            padding: 0px !important;
        }

        progress {
            width: 100%;
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
        }

        progress::-webkit-progress-bar {
            background-color: #f3f3f3;
            border-radius: 10px;
        }

        progress::-webkit-progress-value {
            background-color: #4caf50;
            border-radius: 10px;
        }

        progress::-moz-progress-bar {
            background-color: #4caf50;
            border-radius: 10px;
        }
    </style>
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('documentation.index')}}">Documents</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter un document</h4>
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
                                <label for="simpleinput" class="form-label">Libellé</label>
                                <input wire:model="name" type="text" id="simpleinput" class="form-control">
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Objet</label>
                                <input wire:model="object" type="text" id="simpleinput" class="form-control">
                                @error('object')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <p class="mb-1 fw-bold text-muted">Catégorie</p>

                                <select wire:model="category" class="form-control parent">
                                    <option value="">--Choisir--</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->label }}</option>
                                    @endforeach

                                </select>
                                @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="date_creation" class="form-label">Date de publication</label>
                                <input wire:model="date_creation" type="date" id="date_creation" class="form-control">
                                @error('date_creation')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                            <div class="mb-3">
                                <label for="example-fileinput" class="form-label">Pièce jointe</label>
                                <input type="file" wire:model="attached_file_" id="example-fileinput"
                                    class="form-control">

                                <div wire:loading wire:target="attached_file_">
                                    <div class="d-flex align-items-center">
                                        <strong>Chargement du fichier en cours...</strong>
                                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3" wire:ignore>
                                <label for="description" class="form-label">Description</label>
                                @error('description')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="description" class="mb-3" style="height: 200px;">

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
<script src="{{ asset('assets/datepicker.js') }}"></script>
<script src=" https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js "></script>
@endassets
@include('livewire.chunks.notification')
@script()
<script>
    document.addEventListener('livewire:initialized', function() {
        let modalWidget = null;
        const description = new Quill('#description', {
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

        const toolbar = description.getModule('toolbar');
        toolbar.addHandler('image', function() {
            modalWidget = "description";
            $('#bs-example-modal-lg').modal('show'); // Ouvre ton modal Bootstrap ici
        });
        description.on('text-change', () => {
            @this.set('description', description.root.innerHTML, false);
        });
        $wire.on('updatePoster', (d) => {
            if (modalWidget == "description") {
                const range = description.getSelection();
                console.log(range.index, d[0]);
                if (range) {
                    description.insertEmbed(range.index, 'image', d[0]);
                }
            }
            modalWidget = null;
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });
        Livewire.on('resetEditors', function() {
            description.root.innerHTML = '';
        });
    });
</script>
@endscript