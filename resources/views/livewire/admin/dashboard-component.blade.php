<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card rounded-0 shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="ri-group-line text-muted font-24"></i>
                                    <h3><span>{{$user}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Utilisateurs actifs</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-newspaper-line text-muted font-24"></i>
                                    <h3><span>{{$article}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Articles publiés</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-file-2-line text-muted font-24"></i>
                                    <h3><span>{{$page}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Pages publiées</p>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-6 col-lg-3">
                            <div class="card rounded-0 shadow-none m-0 border-start border-light">
                                <div class="card-body text-center">
                                    <i class="ri-line-chart-line text-muted font-24"></i>
                                    <h3><span>{{$composante}}</span></h3>
                                    <p class="text-muted font-15 mb-0">Composantes</p>
                                </div>
                            </div>
                        </div> -->

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->
</div>
