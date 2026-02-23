<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categories</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Categories</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create categories')
                            <div class="col-sm-5">
                                <a href="{{route('categories.create')}}" class="btn btn-success mb-2"><i
                                        class="mdi mdi-plus-circle me-2"></i> Ajouter une categorie</a>
                            </div>
                        @endcan
                        <!-- end col-->
                    </div>


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

                            {{--<div class="col-lg-3">
                                <div class="mb-3">
                                    <select wire:model.live="perPage" wire:change="resetPage" class="form-select" id="example-select">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>--}}

                            <div class="col-lg-3">
                                <div class="mb-3">
                                    <select wire:model.live="type" wire:change="resetPage" class="form-select"
                                            id="example-select">
                                        <option value="">--Types--</option>
                                        @foreach($types as $t)
                                            <option>{{$t}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-group float-end">
                                    <input type="text" wire:model.live="search" wire:keyup="resetPage"
                                           class="form-control" placeholder="Rechercher...">

                                </div>
                            </div>
                        </div>
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>

                                <th class="all">Libellé</th>
                                <th>Parent(s)</th>
                                <th>Type</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $category)
                                <tr>

                                    <td>
                                        {{$category->label}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$category->parents->label ?? ''}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$category->type}}
                                    </td>

                                    <td>
                                        {{$category->created_at}}
                                    </td>


                                    <td class="table-action">
                                        @can('view categories')
                                            <a href="{{route('categories.show', $category->id)}}"> <i
                                                    class="mdi mdi-eye text-info h3"></i></a>
                                        @endcan

                                        @can('edit categories')
                                                <a href="{{route('categories.edit', $category->id)}}"> <i
                                                        class="mdi mdi-square-edit-outline text-primary h3"></i></a>
                                        @endcan

                                        @can('delete categories')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="$dispatch('confirm-delete',{{$category->id}})"> <i
                                                        class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan



                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($categories->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucune categorie n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$categories->firstItem()}} a {{$categories->lastItem()}}
                                sur {{$categories->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($categories->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($categories->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($categories->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#"
                                                   wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$categories->hasMorePages()) disabled @endif">
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
                            <p class="mt-3">Voulez-vous supprimer cette categorie? Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2"
                                    wire:click="deleteCategorie({{$confirm_delete}})">Confirmer
                            </button>
                        @endif
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
                Livewire.dispatch('deleteCategorie', {category_id: id});
                /*Swal.fire(
                    'Supprimé!',
                    'La catégorie a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    $wire.on('category-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'La catégorie a été supprimée.',
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

    /*Livewire.on('confirm-delete', id => {
    @this.set('confirm_delete', id);

        // Assurez-vous que le modal est correctement initialisé et affiché
        setTimeout(() => {
            const modal = new bootstrap.Modal(document.getElementById('danger-alert-modal'));
            modal.show();
        }, 200); // Un léger délai pour s'assurer que DOM est mis à jour
    });

    Livewire.on('category-deleted', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('danger-alert-modal'));
        if (modal) {
            modal.hide();
        }
    });*/
    /*$wire.on('confirm-delete', (id) => {
        $modal = $('#danger-alert-modal');
        $modal.modal('show');
        @this.set('confirm_delete', id);

    })
    $wire.on('category-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript
