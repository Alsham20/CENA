<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('videos.index')}}">Vidéos</a></li>
                        <li class="breadcrumb-item active">Afficher</li>
                    </ol>
                </div>
                <h4 class="page-title">Afficher une vidéo</h4>
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
                                <label for="simpleinput" class="form-label">Titre</label>
                                <input disabled wire:model="title" type="text" id="simpleinput" class="form-control">
                                @error('title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Lien</label>
                                <input disabled wire:model="video_path" type="text" id="simpleinput" class="form-control">
                                @error('video_path')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date_video" class="form-label">Date</label>
                                <input disabled wire:model="date_video" type="date" id="date_video" class="form-control">
                                @error('date_video')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <div class="mb-3" wire:ignore>
                                <label for="video_description" class="form-label">Description</label>
                                @error('video_description')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="video_description" class="mb-3" style="height: 100px;">
                                    {!! $video_description !!}
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <p class="mb-1 fw-bold text-muted">Categorie</p>

                                    <select disabled wire:model="category" class="select2 form-control category"
                                        data-toggle="select2" data-placeholder="Choose ...">
                                        <option></option>
                                        @foreach ($categories as $item)
                                        <option value="{{$item->id}}" @if($category==$item->id) selected @endif>{{$item->label}}</option>
                                        @endforeach

                                    </select>
                                    @error('category')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div> <!-- end col -->

                                <div class="col-lg-12 mb-3">
                                    <p class="mb-1 fw-bold text-muted">Activité</p>

                                    <select disabled wire:model="activity" class="select2 form-control activity"
                                        data-toggle="select2" data-placeholder="Choose ...">
                                        <option></option>
                                        @foreach ($activities as $item)
                                        <option value="{{$item->id}}" @if($activity==$item->id) selected @endif>{{$item->label}}</option>
                                        @endforeach

                                    </select>
                                    @error('activity')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div> <!-- end col -->
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
@script()
<script>
    document.addEventListener('livewire:initialized', function() {
        // let modalWidget = null;

        // $('.category').on('change', function() {

        //     @this.set('category', this.value);
        // })

        // $('.activity').on('change', function() {

        //     @this.set('activity', this.value);
        // })

        const video_description = new Quill('#video_description', {
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

        video_description.on('text-change', () => {
            @this.set('video_description', video_description.root.innerHTML, false);
        });

        Livewire.on('resetEditors', function() {
            event_description.root.innerHTML = '';
        });
    });
</script>
@endscript