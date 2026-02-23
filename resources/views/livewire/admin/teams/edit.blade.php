<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('teams.index')}}">Membres</a></li>
                        <li class="breadcrumb-item active">Modifier</li>
                    </ol>
                </div>
                <h4 class="page-title">Modifier un membre</h4>
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
                                <label for="simpleinput" class="form-label">Nom</label>
                                <input wire:model="lastname" type="text" id="simpleinput" class="form-control">
                                @error('lastname')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Prénom</label>
                                <input wire:model="firstname" type="text" id="simpleinput" class="form-control">
                                @error('firstname')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Titre</label>
                                <input wire:model="title" type="text" id="simpleinput" class="form-control">
                                @error('title')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Fonction</label>
                                <input wire:model="fonction" type="text" id="simpleinput" class="form-control">
                                @error('fonction')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="facebook_link" class="form-label">Facebook</label>
                                <input wire:model="facebook_link" type="text" id="facebook_link" class="form-control">
                                @error('facebook_link')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="tweeter_link" class="form-label">Tweeter</label>
                                <input wire:model="tweeter_link" type="text" id="tweeter_link" class="form-control">
                                @error('tweeter_link')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="linkedin_link" class="form-label">Linkedin</label>
                                <input wire:model="linkedin_link" type="text" id="linkedin_link" class="form-control">
                                @error('linkedin_link')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="simpleinput" class="form-label">Numéro d'ordre</label>
                                <input wire:model="order" type="number" id="simpleinput" class="form-control">
                                @error('order')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3" wire:ignore>
                                <label for="avatar" class="form-label">Avatar</label>

                                <div class="card mb-0 avatar_card d-none">
                                    <div class="card-body">
                                        <div class="border-dashed border-2 h-100 border rounded col-3 p-1">
                                            <img src="#" class="img-thumbnail m-1 avatar_thumb"
                                                style="cursor: pointer" alt="">
                                        </div>
                                    </div> <!-- end card-body -->
                                </div>
                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input id="is_private" wire:model.live="is_private" value="1" type="checkbox" class="form-check-input" @if($is_private) checked @endif id="checkbox-signin">
                                        <label class="form-check-label" for="is_featured">Privé</label>
                                    </div>
                                </div>
                                @error('avatar') <span class="error">{{ $message }}</span> @enderror
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
                                </div><!-- /.modal -->

                            </div>

                        </div>
                        <div class="mb-0 mt-4">
                            <button class="btn btn-primary" type="submit">Valider</button>
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
        let modalWidget = null;

        $('.avatar_thumb').attr('src', '{{ $avatar_url }}');
        $('.avatar_card').removeClass('d-none');
        $wire.on('updateAvatar', (d) => {

            $('.avatar_thumb').attr('src', d);
            $('.avatar_card').removeClass('d-none');
            modalWidget = null;
            @this.set('modalWidget', null, true);
            // Fermer le modal une fois l'image insérée
            $('#bs-example-modal-lg').modal('hide');
        });
    });
</script>
@endscript