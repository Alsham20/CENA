<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('menu-emplacements.index')}}">Menu emplacements</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Menu emplacements</h4>
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
                                <a href="{{route('menu-emplacements.create')}}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Ajouter un emplacement</a>
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
                                <th>Code emplacement</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($menuEmplacements as $menuEmplacement)
                                <tr>



                                    <td style="width: 30%;white-space :normal">
                                        {{$menuEmplacement->label}}
                                    </td>

                                    <td>
                                       {{$menuEmplacement->code_menu}}
                                    </td>


                                    <td>
                                        {{$menuEmplacement->created_at}}
                                    </td>




                                    <td class="table-action">
                                        @can('view menus')
                                            <a href="{{route('menu-emplacements.show',$menuEmplacement->id)}}" title="Menus"> <i class="mdi mdi-format-list-bulleted text-info h3"></i></a>
                                        @endcan
                                        @can('edit menus')
                                                <a href="{{route('menu-emplacements.edit',$menuEmplacement->id)}}" title="Modifier"> <i class="mdi mdi-square-edit-outline text-warning h3"></i></a>
                                        @endcan
                                        @can('delete menus')
                                                <a href="javascript:void(0);" wire:click.prevent="$dispatch('confirm-delete','{{$menuEmplacement->id}}')" title="Supprimer" > <i class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan

                                        {{--<a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                        <a href="javascript:void(0);" wire:click.prevent="deleteCategorie({{$menu->id}})" class="action-icon"> <i class="mdi mdi-delete"></i></a>--}}
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                            @if ($menuEmplacements->count() == 0)
                                <div class="alert alert-info" role="alert">
                                    Aucun marché public n'est disponible.
                                </div>
                            @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$menuEmplacements->firstItem()}} a {{$menuEmplacements->lastItem()}}
                                sur {{$menuEmplacements->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item @if($menuEmplacements->currentPage() == 1) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item"><a class="page-link active"
                                                                 href="#">{{$menuEmplacements->currentPage()}}</a></li>
                                        <li class="page-item @if($menuEmplacements->currentPage() == $menuEmplacements->lastPage()) disabled @endif">
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
            'L\'emplacement menu a été supprimé.',
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
