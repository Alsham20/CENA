@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.roles.show',['role_id' => $param])
    </div> 
@endsection

