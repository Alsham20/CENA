@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.activities.edit',['activity_id' => $param])
    </div>
@endsection
