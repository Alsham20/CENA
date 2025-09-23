
@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.menus.show-menu-emplacement',['menu_emplacement_id' => $param])
    </div>
@endsection
