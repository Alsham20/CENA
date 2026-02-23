
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.elections.edit',['id' => $param])
    </div>
@endsection
