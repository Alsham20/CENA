
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.teams.edit',['id' => $param])
    </div>
@endsection
