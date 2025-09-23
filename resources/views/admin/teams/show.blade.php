
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.teams.show',['id' => $param])
    </div>
@endsection
