
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.resultats.edit',['id' => $param])
    </div>
@endsection
