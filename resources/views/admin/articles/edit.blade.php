
@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.articles.edit', ['article_id' => $param])
    </div> 
@endsection