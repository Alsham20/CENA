
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.categories.edit',['category_id' => $param])
    </div> 
@endsection