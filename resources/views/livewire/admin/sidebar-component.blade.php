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
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="{{route('dashboard')}}" class="side-nav-link">
                    <i class="uil-home-alt"></i>

                    <span> Dashboards </span>
                </a>
            </li>
            @can('list roles')
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarRole" aria-expanded="false" aria-controls="sidebarRole" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Roles </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarRole">
                        <ul class="side-nav-second-level">
                            <li>
                                <a wire:click="setActiveSection('roles_list')" href="#">Liste des roles</a>
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
                        <i class="uil-store"></i>
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
                    <a data-bs-toggle="collapse" href="#sidebarPermissions" aria-expanded="false" aria-controls="sidebarPermissions" class="side-nav-link">
                        <i class="uil-store"></i>
                        <span> Utilisateurs </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarPermissions">
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
                        <i class="uil-store"></i>
                        <span> Categories </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="categories">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="{{route('users.index')}}">Categories</a>
                            </li>
                            <li>
                                @can('create categories')
                                    <a href="{{route('users.create')}}">Ajouter une categorie</a>
                                @endcan
                            </li>
                        </ul>
                    </div>
                </li>
            @endcan









        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
