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
                                    <h4 class="mt-1 mb-1 text-white">{{ $page->title }}</h4>
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
                    {!!$page->content!!}
                    
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

</div> <!-- container -->