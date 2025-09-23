<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Utilisateurs</a></li>
                        <li class="breadcrumb-item active">Mot de Passe</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $user->email }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form wire:submit.prevent="updatePassword">


                            <div class="row justify-center">
                                <div class="form-group mt-4">
                                    <label for="old_password" class="form-label">Mot de Passe actuel</label>
                                    <div class="input-group input-group-merge">
                                        <input name="old_password" wire:model="old_password" type="password" id="old_password" class="form-control" placeholder="****">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="password" class="form-label">Nouveau Mot de Passe (12 caractères minimum, Majuscule, Minuscule, caractères spéciaux)</label>
                                    <div class="input-group input-group-merge">
                                        <input name="password" wire:model="password" type="password" id="password" class="form-control" placeholder="****">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe</label>
                                    <div class="input-group input-group-merge">
                                        <input name="password_confirmation" wire:model="password_confirmation" type="password" id="password_confirmation" class="form-control" placeholder="****">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                @error('password')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                         <div class="form-group mt-4">
                                <div class="mb-3 mb-0">
                                    <button class="btn btn-primary" type="submit">
                                        Valider
                                    </button>
                                    <div wire:loading>
                                        <div class="spinner-border text-primary" role="status"></div>
                                    </div>
                                </div>
                            </div>

                    </form>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>

    <!-- end row -->

</div> <!-- container -->
@include('livewire.chunks.notification')
