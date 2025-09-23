<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">menu</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier un menu</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="store">
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
                                <label for="simpleinput" class="form-label">Titre primaire</label>
                                <input wire:model="primary_title" type="text" id="simpleinput" class="form-control">
                                @error('primary_title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Titre secondaire</label>
                                <input wire:model="secondary_title" type="text" id="simpleinput" class="form-control">
                                @error('secondary_title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Emplacement menu</p>

                                <select wire:model="menu_emplacement_id" class="form-control menu_emplacement_id">
                                    <option value="">Choisir </option>
                                    @foreach ($menuEmplacements as $menuEmplacement)

                                        <option value="{{$menuEmplacement->id}}">{{$menuEmplacement->label}}
                                            [{{$menuEmplacement->code_menu}}]
                                        </option>
                                    @endforeach

                                </select>
                                @error('menu_emplacement_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="url" class="form-label">Url</label>
                                <input wire:model="url" type="text" id="url" class="form-control">
                                @error('url')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3">
                                <p class="mb-1 fw-bold text-muted">Menu parent</p>

                                <select wire:model="parent_id" class="form-control parent_id" >
                                    <option value="">Choisir </option>
                                    @foreach ($menus as $menu)
                                        <option value="{{$menu->id}}">{{$menu->label}}</option>
                                    @endforeach

                                </select>
                                @error('parent_id')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Permission</p>

                                <select wire:model="permission" class="form-control permission">
                                    <option value="">Choisir </option>
                                    @foreach ($permissions as $permis)

                                        <option value="{{$permis->name}}">{{$permis->name}}</option>
                                    @endforeach

                                </select>
                                @error('permission')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Ouvrir sur une nouvelle page</p>

                                <select wire:model="new_tab" class="form-control new_tab">
                                    <option value="">Choisir </option>
                                    @foreach ($new_tabs as $item => $value)
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endforeach


                                </select>
                                @error('new_tab')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="icon" class="form-label">Icône</label>
                                <input wire:model="icon" type="text" id="icon" class="form-control">
                                @error('icon')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <input wire:model="position" type="number" id="position" class="form-control">
                                @error('position')
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


        $('.menu_emplacement_id').select2({
            placeholder: 'Choisir un emplacement'
        });
        $('.parent_id').select2({
            placeholder: 'Choisir un menu parent'
        });
        $('.permission').select2({
            placeholder: 'Choisir une permission'
        });
        $('.new_tab').select2({
            placeholder: 'Choisir une option'
        });

        $('.menu_emplacement_id').on('change', function () {
            @this.set('menu_emplacement_id', this.value);
        });

        $('.parent_id').on('change', function () {
            @this.set('parent_id', this.value);
        });

        $('.permission').on('change', function () {
            @this.set('permission', this.value);
        });

        $('.new_tab').on('change', function () {
            @this.set('new_tab', this.value);
        });
    });
    document.addEventListener('menu-added', event => {
        $('.parent_id').val(null).trigger('change');
        $('.menu_emplacement_id').val(null).trigger('change');
        $('.permission').val(null).trigger('change');
        $('.new_tab').val(null).trigger('change');
    })
</script>
@endscript
