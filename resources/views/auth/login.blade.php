@extends('auth.base')
@section('form')
<div class="card">

    <!-- Logo -->
    <div class="card-header py-4 text-center " style="background-color: #050826">
        <a href="">
            <span><img src="{{asset('assets/images/logo.png')}}" alt="logo" height="22"></span>
        </a>
    </div>

    <div class="card-body p-4">

        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">Connexion</h4>
        </div>
        @error('email')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror
        @error('otp')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror



        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <form action="#" method="POST">
            @csrf
            @if (session('otp_token'))
            <div class="mb-3">
                Veuillez entrer le code OTP envoyé {{ config('otp_channel') == 'email' ? 'à votre adresse email' : 'à votre numero de telephone' }}
            </div>
            <div class="mb-3">
                <input name="otp_token" type="hidden" value="{{session('otp_token')}}">
                <label for="emailaddress" class="form-label">OTP </label>
                <input name="otp" class="form-control" type="text" id="emailaddress" required="" placeholder="Veuillez saisir votre OTP">
            </div>
            <div class="mb-3 text-center">
                <button class="btn btn-primary" type="submit"> Valider </button>
            </div>
            @else
            <div class="mb-3">
                <label for="emailaddress" class="form-label">Email </label>
                <input name="email" class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
            </div>

            <div class="mb-3">
                <a href="{{route('password.request')}}" class="text-muted float-end"><small>Mode passe oublier?</small></a>
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group input-group-merge">
                    <input name="password" type="password" id="password" class="form-control" placeholder="Enter your password">
                    <div class="input-group-text" data-password="false">
                        <span class="password-eye"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                    <label class="form-check-label" for="checkbox-signin">Se souvenir de moi</label>
                </div>
            </div>
            @if($recaptcha)

            @error('g-recaptcha-response')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
            @enderror
            {!! htmlFormSnippet() !!}

            @endif
            <div class="mb-3 mb-0 text-center">
                <button class="btn btn-primary" type="submit"> Se connecter </button>
            </div>
            @endif

        </form>
    </div> <!-- end card-body -->
</div>
@endsection