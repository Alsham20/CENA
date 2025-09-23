
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.pages.edit',['page_id' => $param])
    </div> 
@endsection