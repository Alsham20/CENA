
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.faqs.show',['faq_id' => $param])
    </div> 
@endsection