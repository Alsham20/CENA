
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.categories.show',['category_id' => $param])
    </div> 
@endsection