<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('menus.index')}}">Menus</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Menus</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create menus')
                            <div class="col-sm-5">
                                <a href="{{route('menus.create')}}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Ajouter un menu</a>
                            </div>
                        @endcan
                        <!-- end col-->
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="perPage" wire:change="resetPage" class="form-select"
                                        id="example-select">
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
                                <input type="text" wire:model.live="search" wire:keyup="resetPage" class="form-control"
                                       placeholder="Rechercher...">

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>

                                <th class="all">Libellé</th>
                                <th>Parent(s)</th>
                                <th>Url</th>
                                <th>Emplacement</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($menus as $menu)
                                <tr>



                                    <td style="width: 30%;white-space :normal">
                                        {{$menu->label}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$menu->parent->label ?? ''}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        <span class="text-primary-emphasis">{{$menu->url}}</span>
                                    </td>

                                    <td style="width: 20%;white-space :normal">
                                        {{$menu->emplacement->label ?? ''}}
                                    </td>

                                    <td>
                                        {{$menu->created_at}}
                                    </td>




                                    <td class="table-action">
                                        @can('edit menus')
                                        <a href="{{route('menus.edit', $menu->id)}}" class="action-icon"> <i class="mdi mdi-square-edit-outline text-primary h3"></i></a>
                                        @endcan
                                        @can('delete menus')
                                            <a href="javascript:void(0);" wire:click="$dispatch('confirm-delete','{{$menu->id}}')" class="action-icon"> <i class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan
                                                {{--<a href="{{route('menus.edit', $menu->id)}}" title="Voir"> <i class="mdi mdi-eye text-info h3"></i></a>
                                        <a href="javascript:void(0);" wire:click.prevent="deleteCategorie({{$menu->id}})" class="action-icon"> <i class="mdi mdi-delete"></i></a>--}}
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                            @if ($menus->count() == 0)
                                <div class="alert alert-info" role="alert">
                                    Aucun menu n'est disponible.
                                </div>
                            @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$menus->firstItem()}} a {{$menus->lastItem()}}
                                sur {{$menus->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item @if($menus->currentPage() == 1) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link active"
                                                                 href="#">{{$menus->currentPage()}}</a></li>
                                        <li class="page-item @if($menus->currentPage() == $menus->lastPage()) disabled @endif">
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
@assets
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endassets
@script
<script>

    Livewire.on('confirm-delete', id => {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "Vous ne pourrez pas revenir en arrière!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                //Livewire.emit('deleteArticle', id);
                Livewire.dispatch('delete', { id: id });
                /*Swal.fire(
                    'Supprimé!',
                    'La composante a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    $wire.on('menu-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'Le menu a été supprimé.',
            'success'
        );
    })

    $wire.on('error-deleted', () => {
        Swal.fire(
            'Erreur!',
            'Une erreur s\'est produite lors de la suppression.',
            'error'
        );
    })
    /*$wire.on('confirm-delete', (id) => {
        $modal = $('#danger-alert-modal');
    @this.set('confirm_delete', id);
        $modal.modal('show');
    })
    $wire.on('team-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript
