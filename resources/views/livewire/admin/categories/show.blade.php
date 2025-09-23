<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">categories</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter une categorie</h4>
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
                            
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Libellé</label>
                                <input wire:model="label" type="text" id="simpleinput" class="form-control" disabled>
                                @error('label')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Type de Categorie</p>

                                <select wire:model="type" class="form-control type">
                                    <option value="">Choisir </option>
                                    @foreach ($types as $item => $value)
                                        <option value="{{$value}}" @if($value == $category->type) selected @endif>{{$value}}</option>
                                    @endforeach

                                </select>
                                
                                @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> <!-- end col -->
                            <div class="col-lg-12 mb-3">
                                <p class="mb-1 fw-bold text-muted">Categorie parente</p>

                                <select wire:model="parent" class="select2 form-control parent" data-toggle="select2" data-placeholder="Choisir ...">
                                    <option value="">Choisir</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}" @if($item->id == $category->parent) selected @endif>{{$item->label}}</option>
                                    @endforeach

                                </select>
                                @error('category')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> <!-- end col -->

                            
                        </div> <!-- end row -->
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <!-- end row -->

</div>

@script()
<script>
    document.addEventListener('livewire:initialized', function () {
        $('.type').select2(
        {
            placeholder: 'Choisir un type',
            disabled:true

        });

        $('.parent').select2(
        {
            placeholder: 'Choisir un parent',
            disabled:true
        });
        $('.type').on('change', function() {
            @this.set('type', this.value);
        })

        
        $('.parent').on('change', function() {
            @this.set('parent', this.value);
        })
    });
</script>
@endscript

