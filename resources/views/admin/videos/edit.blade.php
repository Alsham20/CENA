@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.videos.edit', ['id' => $param])
    </div> 
@endsection