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
                                    <h4 class="mt-1 mb-1 text-white">{{ $article->title }}</h4>
                                    <p class="text-white">

                                    {{ ($article->date_article) ? \Carbon\Carbon::parse($article->date_article)->format('d/m/Y H:i') : ""}}
                                    </p>
                                </div>
                                <div>
                                    <span class="badge badge-outline-{{$article->is_published ? 'success' : 'warning'}}">{{$article->is_published ? 'Publié' : 'Non publié'}}</span>
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
                    {!!$article->content!!}
                    
                </div>
            </div>
            <!-- Personal-Information -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->

</div> <!-- container -->