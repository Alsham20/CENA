
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.faqs.edit',['faq_id' => $param])
    </div> 
@endsection