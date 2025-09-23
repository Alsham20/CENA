<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('settings.index')}}">Parametres</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter un paramètre</h4>
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
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Libellé</label>
                                <input wire:model="label" type="text" id="simpleinput" class="form-control">
                                @error('label')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">Clé</label>
                                <input wire:model="key" type="text" id="key" class="form-control">
                                @error('key')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">Valeur</label>
                                <input wire:model="value" @if("password" == $setting->type) type="password" @else type="text" @endif  id="value" class="form-control">
                                @error('value')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Type de valeur</p>

                                <select wire:model="type" class="form-control type">
                                    <option value="">Choisir </option>
                                    @foreach ($types as $item => $value)
                                        <option value="{{$value}}" @if($value == $setting->type) selected @endif>{{$value}}</option>
                                    @endforeach

                                </select>

                                @error('type')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3 mb-0">
                                <button class="btn btn-primary" type="submit">Valider</button>
                            </div>
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
    document.addEventListener('livewire:initialized', function () {
        $('.type').select2(
        {
            placeholder: 'Choisir un type'
        });

        $('.type').on('change', function() {
            console.log(this.value);
            @this.set('type', this.value);
        })
    });
</script>
@endscript
