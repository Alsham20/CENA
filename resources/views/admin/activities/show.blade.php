<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
</div>

@extends('admin.layouts.base')
@section('content')  
    <div class="content">
        @livewire('admin.activities.show',['activity_id' => $param])
    </div> 
@endsection