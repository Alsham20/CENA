@extends('auth.base')
@section('form')
<div class="card">

    <!-- Logo -->
    <div class="card-header py-4 text-center" style="background-color: #050826">
        <a href="">
            <span><img src="{{asset('assets/images/logo.png')}}" alt="logo" height="22"></span>
        </a>
    </div>

    <div class="card-body p-4">

        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">Réinitialisation de mot de passe</h4>
        </div>
        @error('email')
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

            <div class="mb-3">
                <label for="emailaddress" class="form-label">Email </label>
                <input name="email" class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
            </div>

            <div class="mb-3 mb-0 text-center">
                <button class="btn btn-primary" type="submit">Valider </button>
            </div>

        </form>
    </div> <!-- end card-body -->
</div>
@endsection