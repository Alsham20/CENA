

@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.users.password',['user_id' => $param])
    </div> 
@endsection
