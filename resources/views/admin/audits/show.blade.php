
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.audits.show',['audit_id' => $param])
    </div> 
@endsection