<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('menus.index')}}">Emplacement menu</a></li>
                        <li class="breadcrumb-item active">Détails</li>
                    </ol>
                </div>
                <h4 class="page-title">Détails</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Détails de l'emplacement menus</h4>
                    <p class="text-muted font-13">

                    </p>

                    <hr />
                    <div class="text-start">
                        <p class="text-muted"><strong>Nom de l'emplacement menu :</strong> <span class="ms-2">{{ $menuEmplacement->label }}</span></p>

                        <p class="text-muted"><strong>Code Emplacement :</strong> <span class="ms-2">{{ $menuEmplacement->code_menu }}</span></p></p>

                        <p class="text-muted"><strong>Description :</strong> <span class="ms-2">{{ $menuEmplacement->descriptions }}</span></p>

                        <p class="text-muted"><strong>Date de création :</strong> <span class="ms-2">{{ $menuEmplacement->created_at }}</span></p>
                    </div>

                    <h4 class="header-title mt-4 mb-3">Arborescence du menu</h4>
                    <p class="text-muted font-13">

                    </p>

                    <hr />
                    <ul class="list-group m-5">
                        @foreach($menus as $menu)
                            <li class="list-group-item">
                                <a href="#">{{ $menu->label }} @if($menu->permission !== null) <span class="text-danger">[{{$menu->permission}}]</span> @endif</a>
                                @if($menu->children->count())
                                    <ul class="list-group mt-2">
                                        @foreach($menu->children as $child)
                                            <li class="list-group-item">
                                                <a href="#">{{ $child->label }} @if($child->permission !== null) <span class="text-danger">[{{$child->permission}}]</span> @endif</a>
                                                @if($child->children->count())
                                                    <ul class="list-group mt-2">
                                                        @foreach($child->children as $subchild)
                                                            <li class="list-group-item">
                                                                <a href="#">{{ $subchild->label }} @if($subchild->permission !== null) <span class="text-danger">[{{$subchild->permission}}]</span> @endif</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
