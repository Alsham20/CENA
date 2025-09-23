
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.events.show',['id' => $param])
    </div>
@endsection
