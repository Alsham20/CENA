
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.pages.show',['page_id' => $param])
    </div> 
@endsection