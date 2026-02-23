
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.resultats.show',['id' => $param])
    </div>
@endsection
