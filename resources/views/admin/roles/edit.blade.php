@extends('admin.layouts.base')
@section('content')
<div class="content">
    @livewire('admin.roles.edit',['role_id' => $param])
</div>
@endsection