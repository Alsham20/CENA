
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.menus.edit', ['menu_id' => $param])
    </div> 
@endsection