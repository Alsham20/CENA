<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Utilisateurs</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Ajouter un Utilisateur</h4>
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
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Nom</label>
                                <input name="lastname" wire:model="lastname" type="text" id="lastname" class="form-control">
                                @error('lastname')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">Prenom</label>
                                <input name="firstname" wire:model="firstname" type="text" id="firstname" class="form-control">
                                @error('firstname')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emailaddress" class="form-label">Email </label>
                                <input name="email" wire:model="email" class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                @error('email')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phoneaddress" class="form-label">Téléphone </label>
                                <input name="phone" wire:model="phone" class="form-control" type="text" id="phoneaddress" required="" placeholder="+229xxxxxxxxxx">
                                @error('phone')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3">
                                <p class="mb-1 fw-bold text-muted">Role(s)</p>
                                <div wire:ignore>
                                    <select name="roles[]" wire:model="roles" class="select2 form-control select2-multiple" data-toggle="select2" multiple="multiple" data-placeholder="Choose ...">
                                        @foreach ($roles_ as $role)

                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach

                                    </select>
                                    @error('roles')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div> <!-- end col -->
                            @if (!$send_activation_mail)
                                <div class="col-lg-6 mb-3">
                                    <label for="password" class="form-label">Mot de passe (12 caractères minimum, Majuscule, Minuscule, caractères spéciaux)</label>
                                    <div class="input-group input-group-merge">
                                        <input name="password" wire:model="password" type="password" id="password" class="form-control" placeholder="Enter password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="mb-3 mb-3">
                                <div class="form-check">
                                    <input id="sendmail" wire:model.live="send_activation_mail" value="1" type="checkbox" class="form-check-input" id="checkbox-signin">
                                    <label class="form-check-label" for="sendmail">Envoyer le lien</label>
                                </div>
                            </div>
                            <div class="mb-3 mb-0">
                                <button class="btn btn-primary" type="submit">
                                    Valider
                                </button>
                                <div wire:loading>
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <!-- end row -->

</div> <!-- container -->
@include('livewire.chunks.notification')
@script()
<script>
        $('.select2').on('change', function (e) {
            var data = $('.select2').val();
            @this.set('roles', data, false);
        });

        $('#sendmail').on('change', function (e) {
            var data = $('#sendmail').val();
            @this.set('send_activation_mail', data, false);
        });

</script>
@endscript
