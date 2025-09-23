@extends('admin.layouts.base')
@section('content')
    <div class="content">
        @livewire('admin.newsletters.details-campaign-message',['id' => $param])
    </div>
@endsection
