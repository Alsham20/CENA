<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('faqs.index')}}">Faq</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier une FAQ</h4>
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
                                <label for="question" class="form-label">Question</label>
                                <input wire:model="question" type="text" id="question" class="form-control">
                                @error('question')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="answer" class="form-label">Reponse </label>
                                @error('answer')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="answer" class="mb-3" style="height: 150px;">
                                    {!! $answer !!}
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <p class="mb-1 fw-bold text-muted">Categorie</p>

                                    <select wire:model="category" class="select2 form-control category"
                                            data-toggle="select2" data-placeholder="Choose ...">
                                        <option></option>
                                        @foreach ($categories as $item)
                                            <option value="{{$item->id}}">{{$item->label}}</option>
                                        @endforeach

                                    </select>
                                    @error('category')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div> <!-- end col -->
                            </div>
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

                            <div class="mb-3">
                                <label for="question" class="form-label">Ordre</label>
                                <input wire:model="order" type="number" value="1" id="order" class="form-control">
                                @error('order')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" wire:model="is_active" id="switch1" @if($is_active) checked @endif data-switch="bool"/>
                                <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>


                            <div class="mb-0">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <!-- end row -->
</div>
@assets
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
@endassets
@include('livewire.chunks.notification')
@script
<script>

    document.addEventListener('livewire:initialized', function () {
        $('.category').on('change', function () {

        @this.set('category', this.value);

        })
        $('.category').val({{$category}}).trigger('change')
        // Runs immediately after Livewire has finished initializing
        // on the page...
        const snowEditor = new Quill('#answer', {
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

        snowEditor.on('text-change', () => {
        @this.set('answer', snowEditor.getSemanticHTML(), false)
            ;
        });

        const toolbar = snowEditor.getModule('toolbar');
        toolbar.addHandler('image', function() {
            $('#bs-example-modal-lg').modal('show'); // Ouvre ton modal Bootstrap ici
        });

        $wire.on('updatePoster', (d) => {
            const range = snowEditor.getSelection();
            //console.log(range.index,d[0]);
            if (range) {
                snowEditor.insertEmbed(range.index, 'image', d[0]);
            }
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });


    })
</script>
@endscript
