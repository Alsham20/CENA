<div class="container-fluid">
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Roles</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create roles')
                            <div class="col-sm-5">
                                <a href="{{route('roles.create')}}" class="btn btn-success mb-2"><i class="mdi mdi-plus-circle me-2"></i> Ajouter un role</a>
                            </div>
                        @endcan
                        <!-- end col-->
                    </div>
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
                        <!-- end col-->

                    <div class="table-responsive">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>
                                <th class="all">
                                    Libellé
                                    <a href="#" wire:click="sortBy('name')">
                                        <i class="mdi mdi-arrow-up"></i>
                                        <i class="mdi mdi-arrow-down"></i>
                                    </a>
                                </th>
                                <th>Permissions associé(s)</th>
                                <th>Nombre de compte(s)</th>
                                <th>Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $item)
                                <tr>
                                    <td>
                                        <span class="badge badge-outline-primary">{{$item->name}}</span>
                                    </td>
                                    <td style="width: 50%;white-space :normal">
                                        @foreach ($item->permissions as $permission)
                                            <span class="badge bg-info rounded-pill">{{$permission->name}}</span>
                                        @endforeach
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$item->users->count()}}
                                    </td>
                                    <td class="table-action">
                                        @can('view roles')
                                            <a href="{{route('roles.show', $item->id)}}"> <i class="mdi mdi-eye text-info h3"></i></a>
                                        @endcan
                                        @can('edit roles')
                                                <a href="{{route('roles.edit', $item->id)}}"> <i class="mdi mdi-square-edit-outline text-warning h3"></i></a>
                                        @endcan
                                        @can('delete roles')
                                                <a href="javascript:void(0);" wire:click="$dispatch('confirm-delete','{{$item->id}}')"> <i class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                    <!-- pagination -->
                    <div class="row" >
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">Afficher {{$roles->firstItem()}} a {{$roles->lastItem()}} sur {{$roles->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end" id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                      <li class="page-item @if($roles->currentPage() == 1) disabled @endif">
                                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                                      </li>
                                      <li class="page-item"><a class="page-link active" href="#">{{$roles->currentPage()}}</a></li>
                                      <li class="page-item @if($roles->currentPage() == $roles->lastPage()) disabled @endif">
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
    <!-- Danger Alert Modal -->
    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-close-circle-line h1"></i>
                        @if($confirm_delete)
                            <h4 class="mt-2">Attention!</h4>
                            <p class="mt-3">Voulez-vous vraiment supprimer le role <span class="text-white font-weight-bold text-uppercase">"{{$roles->find($confirm_delete)->name}}"</span>. Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2" wire:click="delete({{$confirm_delete}})">Confirmer</button>
                        @endif
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</div> <!-- container -->
@include('livewire.chunks.notification')
@script
<script>
        $wire.on('confirm-delete', (id) => {
            $modal = $('#danger-alert-modal');
            $modal.modal('show');
            @this.set('confirm_delete', id);

        })
        $wire.on('role-deleted', () => {
            $modal = $('#danger-alert-modal');
            $modal.modal('hide');
        })
</script>
@endscript
