
<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('articles.index')}}">Articles</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter un article</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="store">

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
                                <label for="title" class="form-label">Titre</label>
                                <input wire:model="title" type="text" id="title" class="form-control">
                                @error('title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="is_featured" wire:model.live="is_featured" value="1" type="checkbox" class="form-check-input" id="checkbox-signin" @if($is_featured) checked @endif>
                                    <label class="form-check-label" for="is_featured">A la une</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date_article" class="form-label">Date</label>

                                <input value="{{ \Carbon\Carbon::parse($date_article)->format('d/m/Y') }}" type="text" id="date_article" class="form-control">
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input id="is_private" wire:model.live="is_private" value="1" type="checkbox" class="form-check-input" id="checkbox-signin" @if($is_private) checked @endif>
                                    <label class="form-check-label" for="is_featured">Privé (Annonce)</label>
                                </div>
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="resume" class="form-label">Extrait</label>
                                @error('resume')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="resume" class="mb-3" style="height: 100px;">
                                    {!! $resume !!}
                                </div>
                                <div class="mb-3" wire:ignore>
                                    <label for="snow-editor" class="form-label">Contenu</label>
                                    @error('content')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div id="snow-editor" class="mb-3" style="height: 300px;">
                                        {!! $content !!}
                                    </div>
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
                                            <div class="border-dashed border-2 rounded col-3 p-1">
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
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <label for="tags">Tags</label>
                                        <input class="form-control form-control-solid p-0" id="tags"/>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="keywords">Keywords</label>
                                        <input class="form-control form-control-solid p-0" id="keywords"/>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label for="slug_">Slug</label>
                                        <input wire:model="slug_" type="text" id="slug_" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="form-floating">
                                            <textarea wire:model="content_description" class="form-control"
                                                      id="content_description" style="height: 100px;"></textarea>
                                            <label for="content_description">Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <button class="btn btn-primary" type="submit">Valider</button>
                                </div>
                            </div><!-- end row -->
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

    document.addEventListener('livewire:initialized', function () {
        let modalWidget = null;
        
        $('.category').on('change', function () {

        @this.set('category', this.value)
            ;
        })
        $('.poster_thumb').attr('src', '{{ $poster_url }}');
        $('.poster_card').removeClass('d-none');

        // Runs immediately after Livewire has finished initializing
        // on the page...
        const snowEditor = new Quill('#snow-editor', {
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
        const toolbar = snowEditor.getModule('toolbar');
        toolbar.addHandler('image', function() {
            modalWidget = "content";
            @this.set('modalWidget', "content",true);
            $('#bs-example-modal-lg').modal('show'); // Ouvre ton modal Bootstrap ici
        });
        snowEditor.on('text-change', () => {
        @this.set('content', snowEditor.getSemanticHTML(), false)
            ;
        });

        const resume = new Quill('#resume', {
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
        const resumeToolbar = resume.getModule('toolbar');
        resumeToolbar.addHandler('image', function() {
            modalWidget = "resume";            
            @this.set('modalWidget', "resume",true);
            $('#bs-example-modal-lg').modal('show'); // Ouvre ton modal Bootstrap ici
        });
        resume.on('text-change', () => {
        @this.set('resume', resume.getSemanticHTML(), false)
            ;
        });

        
        $wire.on('updatePoster', (d) => {
            if(modalWidget == "content"){

                const range = snowEditor.getSelection();
                console.log(range.index,d[0]);
                if (range) {
                snowEditor.insertEmbed(range.index, 'image', d[0]);
                }
            }else if(modalWidget == "resume"){
                const range = resume.getSelection();
                console.log(range.index,d[0]);
                if (range) {
                    resume.insertEmbed(range.index, 'image', d[0]);
                }
            }else{
                $('.poster_thumb').attr('src', d);
                $('.poster_card').removeClass('d-none');
            }
            modalWidget = null;
            @this.set('modalWidget', null,true);
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });
        var input = document.querySelector("#tags");
        new Tagify(input, {
            whitelist: [],
            maxTags: 10,
            dropdown: {
                maxItems: 20,           // <- mixumum allowed rendered suggestions
                classname: "", // <- custom classname for this dropdown, so it could be targeted
                enabled: 0,             // <- show suggestions on focus
                closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
            },
            callbacks: {
                change: function(tag) {
                    labels = JSON.parse(tag.detail.value);
                    @this.set('tags', labels, false);
                },

            }

        });
        var keywords = document.querySelector("#keywords");
        new Tagify(keywords, {
            whitelist: [],
            maxTags: 10,
            dropdown: {
                maxItems: 20,           // <- mixumum allowed rendered suggestions
                classname: "", // <- custom classname for this dropdown, so it could be targeted
                enabled: 0,             // <- show suggestions on focus
                closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
            },
            callbacks: {
                change: function(tag) {
                    labels = JSON.parse(tag.detail.value);
                    @this.set('content_keywords', labels, false);
                },

            }

        });
        var datepicker = new Datepicker('#date_article',{
            onChange: function(date) {
                var DateTime = luxon.DateTime;
                const dateFormatted = DateTime.fromJSDate(date).toFormat('yyyy-MM-dd');
                console.log(dateFormatted);
                @this.set('date_article', dateFormatted, false)
            },
        });

    })
</script>
@endscript
