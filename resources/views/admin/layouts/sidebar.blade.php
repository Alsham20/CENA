@php
$adminSidebarMenu = \App\Helpers\Helper::buildMenu();
//dd($adminSidebarMenu);
@endphp
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="#" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{asset('assets/images/logo.png')}}" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{asset('assets/images/logo-sm.png')}}" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="#" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{asset('assets/images/logo-dark.png')}}" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{asset('assets/images/logo-dark-sm.png')}}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="{{asset('assets/images/users/avatar-1.jpg')}}" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>
            @foreach($adminSidebarMenu as $menu)

            @if($menu->children->count())
            @can($menu->permission)
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarMenu{{$menu->id}}" aria-expanded="false" aria-controls="sidebarMenu{{$menu->id}}" class="side-nav-link">
                    <i class="{{$menu->icon}}"></i>
                    <span> {{$menu->label}} </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarMenu{{$menu->id}}">
                    <ul class="side-nav-second-level">
                        @foreach($menu->children as $child)
                        @can($child->permission)
                        <li>
                            <a href="{{$child->url}}">{{$child->label}}</a>
                        </li>
                        @endcan
                        @endforeach
                    </ul>
                </div>
            </li>
            @endcan
            @else
            <li class="side-nav-item">
                <a href="{{$menu->url}}" class="side-nav-link">
                    <i class="{{$menu->icon}}"></i>

                    <span> {{$menu->label}} </span>
                </a>
            </li>
            @endif
            @endforeach

            {{--

            <li class="side-nav-item">
                <a href="{{route('dashboard')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>

            <span> Dashboards </span>
            </a>
            </li>
            @can('list roles')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                    <i class="uil-boombox"></i>
                    <span> Roles </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarRole">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('roles.index')}}">Liste des roles</a>
                        </li>
                        <li>
                            @can('create roles')
                            <a href="{{route('roles.create')}}">Ajouter un roles</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list roles')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPermissions" aria-expanded="false" aria-controls="sidebarPermissions" class="side-nav-link">
                    <i class="uil-shield-question"></i>
                    <span> Permissions </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPermissions">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('roles.permissions.index')}}">Liste des permissions</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list users')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUtilisateurs" aria-expanded="false" aria-controls="sidebarUtilisateurs" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Utilisateurs </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUtilisateurs">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('users.index')}}">Liste des Utilisateurs</a>
                        </li>
                        <li>
                            @can('create users')
                            <a href="{{route('users.create')}}">Ajouter un Utilisateur</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            @can('list categories')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#categories" aria-expanded="false" aria-controls="sidebarPermissions" class="side-nav-link">
                    <i class="uil-layer-group"></i>
                    <span> Categories </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="categories">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('categories.index')}}">Categories</a>
                        </li>
                        <li>
                            @can('create categories')
                            <a href="{{route('categories.create')}}">Ajouter une categorie</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list articles')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#articles" aria-expanded="false" aria-controls="articles" class="side-nav-link">
                    <i class="uil-notebooks"></i>
                    <span> Articles </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="articles">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('articles.index')}}">articles</a>
                        </li>
                        <li>
                            @can('create articles')
                            <a href="{{route('articles.create')}}">Ajouter un article</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list pages')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#pages" aria-expanded="false" aria-controls="pages" class="side-nav-link">
                    <i class="uil-copy-alt"></i>
                    <span> Pages </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="pages">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('pages.index')}}">Pages</a>
                        </li>
                        <li>
                            @can('create pages')
                            <a href="{{route('pages.create')}}">Ajouter une page</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list medias')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#medias" aria-expanded="false" aria-controls="medias" class="side-nav-link">
                    <i class="uil-scenery"></i>
                    <span> Medias </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="medias">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('medias.index')}}">Medias</a>
                        </li>

                    </ul>
                </div>
            </li>
            @endcan
            @can('list menus')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#menus" aria-expanded="false" aria-controls="menus" class="side-nav-link">
                    <i class="uil-layers-alt"></i>
                    <span> Menus </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="menus">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('menu-emplacements.index')}}">Emplacements menus</a>
                        </li>

                        <li>
                            <a href="{{route('menus.index')}}">Menus</a>
                        </li>

                        <li>
                            @can('create menus')
                            <a href="{{route('menus.create')}}">Ajouter un menu</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list settings')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings" class="side-nav-link">
                    <i class="uil-sliders-v"></i>
                    <span> Paramètres </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="settings">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('settings.index')}}">Parametre</a>
                        </li>
                        <li>
                            @can('create settings')
                            <a href="{{route('settings.create')}}">Ajouter un parametre</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('list faqs')
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#faqs" aria-expanded="false" aria-controls="faqs" class="side-nav-link">
                    <i class="uil-question-circle"></i>
                    <span>FAQs</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="faqs">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('faqs.index')}}">FAQs</a>
                        </li>
                        <li>
                            @can('create faqs')
                            <a href="{{route('faqs.create')}}">Ajouter une FAQ</a>
                            @endcan
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            <li class="side-nav-item">
                <a href="{{route('audits.index')}}" class="side-nav-link">
                    <i class="uil-map-pin"></i>

                    <span> Audits </span>
                </a>
            </li>



            --}}

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>