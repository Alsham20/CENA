
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.settings.edit',['setting_id' => $param])
    </div> 
@endsection