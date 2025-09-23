<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('newsletters.campaign')}}">Campagnes</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier une campagne</h4>
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
                                <label for="simpleinput" class="form-label">Nom de la campagne</label>
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

                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Abonné</p>

                                <select wire:model="categorie" class="select2 form-control categorie" data-toggle="select2" data-placeholder="Choisir ...">
                                    <option value="">Choisir</option>
                                    <option value="-1" {{($this->categorie == -1) ? "selected":""}}>Visiteur</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}" {{($this->categorie == $item->id) ? "selected":""}}>{{$item->label}}</option>
                                    @endforeach

                                </select>
                                @error('categorie')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> <!-- end col -->


                            <div class="mb-3" wire:ignore>
                                <label for="message" class="form-label">Message</label>
                                <p>Variables: <br> Prénoms: {firstname}, Nom: {lastname}, E-mail: {email}, Bouton: {button :link=https://lelien.com/ :text=Bouton texte} </p>
                                @error('message')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="message" class="mb-3" style="height: 500px;">
                                    {!! $message !!}
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
@include('livewire.chunks.notification')
@script()
<script>

    $('.categorie').select2(
        {
            placeholder: 'Choisir une catégorie'
        });

    document.addEventListener('livewire:initialized', function () {
        const message = new Quill('#message', {
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

        const toolbar = message.getModule('toolbar');
        toolbar.addHandler('image', function() {
            modalWidget = "description";
            $('#bs-example-modal-lg').modal('show'); // Ouvre ton modal Bootstrap ici
        });


        message.on('text-change', () => {
        @this.set('message', message.getSemanticHTML(), false)
            ;
        });

        $wire.on('updatePoster', (d) => {
            if(modalWidget == "description"){
                const range = message.getSelection();
                console.log(range.index,d[0]);
                if (range) {
                    message.insertEmbed(range.index, 'image', d[0]);
                }
            }
            modalWidget = null;
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });



        Livewire.on('resetEditors', function () {
            message.root.innerHTML = '';
        });

        $('.categorie').on('change', function() {
            console.log(this.value);
        @this.set('categorie', this.value);
        })
    });

</script>
@endscript
