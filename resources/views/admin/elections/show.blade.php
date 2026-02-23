
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.elections.show',['id' => $param])
    </div>
@endsection
