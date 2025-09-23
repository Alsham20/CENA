<div class="container-fluid">



    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter un role</h4>
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
                                <input wire:model="name" type="text" id="simpleinput" class="form-control">
                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-lg-12 mb-3" wire:ignore>
                                <p class="mb-1 fw-bold text-muted">Permission(s)</p>

                                <select wire:model="role_permissions" class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                    @foreach ($permissions as $permission)

                                        <option value="{{$permission->name}}">{{$permission->name}}</option>
                                    @endforeach

                                </select>
                                @error('role_permissions')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div> <!-- end col -->

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
@script
<script>
    document.addEventListener('livewire:initialized', function () {
        $('.select2').select2({})
        $('.select2').on('change', function (e) {
            var data = $('.select2').val();
            @this.set('role_permissions', data, false);
        })
        $wire.on('roleCreated', () => {
            $('.select2').val(null).trigger('change');
        })
    });
</script>
@endscript
