<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
                <h4 class="page-title">Permissions</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="perPage" wire:change="resetPage" class="form-select" id="example-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>

                        <div class="col-lg-6">
                            <div class="input-group float-end">
                                <input type="text" wire:model.live="search" wire:keyup="resetPage" class="form-control" placeholder="Rechercher...">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>
                                <th class="all">Libellé</th>
                                <th>Roles associé(s)</th>
                                <th>Nombre de compte</th>
                                <th>Date de création</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($permissions as $item)
                                <tr>
                                    <td>
                                        <span class="badge badge-outline-primary">{{$item->name}}</span>
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        @foreach ($item->roles as $role)
                                            <span class="badge bg-info rounded-pill">{{$role->name}}</span>
                                        @endforeach
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{ App\Models\User::permission($item->name)->get()->count()}}
                                    </td>

                                    <td>
                                        {{$item->created_at}}
                                    </td>





                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                    <div class="row" >
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">Afficher {{$permissions->firstItem()}} a {{$permissions->lastItem()}} sur {{$permissions->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end" id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                      <li class="page-item @if($permissions->currentPage() == 1) disabled @endif">
                                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                                      </li>
                                      <li class="page-item"><a class="page-link active" href="#">{{$permissions->currentPage()}}</a></li>
                                      <li class="page-item @if($permissions->currentPage() == $permissions->lastPage()) disabled @endif">
                                        <a class="page-link" href="#" wire:click.prevent="nextPage">Next</a>
                                      </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->
