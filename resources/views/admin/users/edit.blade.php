

@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.users.edit',['user_id' => $param])
    </div> 
@endsection
