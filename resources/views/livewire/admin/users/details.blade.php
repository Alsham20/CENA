<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Utilisateurs</a></li>
                        <li class="breadcrumb-item active">Ajouter</li>
                    </ol>
                </div>
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="https://via.placeholder.com/150" alt="" class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white">{{ $user->firstname }} {{ $user->lastname }}</h4>
                                        <p class="font-13 text-white-50"> {{ $user->getRoleNames()->implode(', ') }}</p>
                                    </div>
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
        <div class="col-xl-4">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Informations Personnelles</h4>
                    <p class="text-muted font-13">

                    </p>

                    <hr />

                    <div class="text-start">
                        <p class="text-muted"><strong>Nom complet :</strong> <span class="ms-2">{{ $user->firstname }} {{ $user->lastname }}</span></p>

                        <p class="text-muted"><strong>Email :</strong> <span class="ms-2">{{ $user->email }}</span></p></p>

                        <p class="text-muted"><strong>Téléphone :</strong> <span class="ms-2">{{ $user->phone }}</span></p></p>

                        <p class="text-muted"><strong>Role(s) :</strong> <span class="ms-2">{{ $user->getRoleNames()->implode(', ') }}</span></p>

                        <p class="text-muted"><strong>Statut :</strong> <span class="ms-2"> @if($user->is_active) <span class="badge bg-success">Actif</span> @else <span class="badge bg-danger">Inactif</span> @endif</span></p>

                        <p class="text-muted"><strong>Dernier Connexion :</strong> <span class="ms-2">{{ $user->last_login }}</span></p>
                    </div>
                    <div class="text-start">
                    @if ($user->id == auth()->user()->id)
                        <a href="{{route('users.password', $user->id)}}" class="btn btn-success">Modifier mot de passe</a>
                    @endif
                    </div>
                </div>
            </div>
            <!-- Personal-Information -->


        </div> <!-- end col-->

        <div class="col-xl-8">

            <div class="row">


                <div class="col-sm-6">
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="ri-archive-line float-end text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Articles</h6>
                            <h2 class="m-b-20"><span>{{ Number::format($user->articles->count()) }}</span></h2>
                        </div> <!-- end card-body-->
                    </div> <!--end card-->
                </div><!-- end col -->

                <div class="col-sm-6">
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="ri-vip-diamond-line float-end text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Pages</h6>
                            <h2 class="m-b-20"><span>{{ Number::format($user->pages->count()) }}</span></h2>
                        </div> <!-- end card-body-->
                    </div> <!--end card-->
                </div><!-- end col -->

            </div>
            <!-- end row -->


            <div class="card">
                <div class="card-body">


                    </div> <!-- end table responsive-->
                </div> <!-- end col-->
            </div> <!-- end row-->

        </div>
        <!-- end col -->

    </div>
    <!-- end row -->

</div> <!-- container -->
