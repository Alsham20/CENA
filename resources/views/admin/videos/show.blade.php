@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.videos.show', ['id' => $param])
    </div> 
@endsection