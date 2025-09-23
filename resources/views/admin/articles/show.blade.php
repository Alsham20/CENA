
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.articles.show',['article_id' => $param])
    </div> 
@endsection