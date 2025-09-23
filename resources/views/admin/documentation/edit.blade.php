
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.ressources-utiles.edit',['id' => $param])
    </div>
@endsection
