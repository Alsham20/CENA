

@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.users.details',['user_id' => $param])
    </div> 
@endsection
