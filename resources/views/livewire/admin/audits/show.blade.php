<div class="container-fluid">
    <!-- end page title -->
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-secondary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row align-items-center">
                                <div>
                                    <h4 class="mt-1 mb-1 text-white">{{$audit->user()->email ?? ''}}</h4>
                                    <p class="text-light label label-primary">{{$audit->role}}</p>
                                    <p class="text-light">{{$audit->created_at}}</p>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-md-12">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4">Adresse Ip</div>
                            <div class="col-lg-8">{{$audit->ip_address ?? ''}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4">Action</div>
                            <div class="col-lg-8">{{$audit->event}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="col-lg-4">Url</div>
                            <div class="col-lg-8">{{$audit->url}}</div>
                        </div>
                    </div>
                    
                </div>
                <!-- Personal-Information -->
            </div> <!-- end col-->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 row bg-transparent text-dark p-2">
                            <div class="col-lg-12">Agent</div>
                            <div class="col-lg-12">{{$audit->user_agent ?? ''}}</div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="col-lg-12">Description</div>
                            <div class="col-lg-12">{{$audit->description ?? ''}}</div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 row">
                            <div class="col-lg-6 bg-dark-subtle  p-2 mb-2">
                                <h3>Old</h3>
                                
                                @foreach ($audit->decodeValues( $audit->old_values) as $key => $value)
                                    {{$key}} : {{$value}} <br>
                                @endforeach
                            </div>
                            <div class="col-lg-6 bg-black p-2 mb-2">
                                <h3>New</h3>
                                @foreach ($audit->decodeValues($audit->new_values) as $key => $value)
                                    {{$key}} : {{$value}} <br>
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
    </div>
    <!-- end row -->

</div> <!-- container -->