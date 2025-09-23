
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.events.edit',['id' => $param])
    </div>
@endsection
