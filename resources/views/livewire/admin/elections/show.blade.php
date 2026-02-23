<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('elections.index')}}">Elections</a></li>
                        <li class="breadcrumb-item active">Afficher</li>
                    </ol>
                </div>
                <h4 class="page-title">Afficher une élection</h4>
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
                                <label for="simpleinput" class="form-label">Titre de l'élection</label>
                                <input disabled wire:model="title" type="text" id="simpleinput" class="form-control">
                                @error('title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <p class="mb-1 fw-bold text-muted">Categorie</p>

                                <select disabled wire:model="category" class="form-control parent">
                                    <option value="">--Choisir--</option>
                                    @foreach ($categories as $item)
                                    <option value="{{$item->id}}" @if($category==$item->id) selected @endif>{{$item->label}}</option>
                                    @endforeach

                                </select>
                                @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="date_election" class="form-label">Date de l'élection</label>
                                <input disabled wire:model="date_election" type="date" id="date_election" class="form-control">
                                @error('date_election')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Nom de l'élection</label>
                                <input disabled wire:model="year" type="text" id="simpleinput" class="form-control">
                                @error('year')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3" wire:ignore>
                                <label for="description" class="form-label">Description</label>
                                @error('description')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div id="description" class="mb-3" style="height: 100px;">
                                    {!! $description !!}
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
    document.addEventListener('livewire:initialized', function() {
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
        description.enable(false);
        description.on('text-change', () => {
            @this.set('description', description.getSemanticHTML(), false);
        });
    });
</script>
@endscript