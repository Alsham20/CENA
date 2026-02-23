<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('pages.index')}}">Pages</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Pages</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create pages')
                            <div class="col-sm-5">
                                <a href="{{route('pages.create')}}" class="btn btn-success mb-2"><i
                                        class="mdi mdi-plus-circle me-2"></i> Ajouter une page</a>
                            </div>
                        @endcan
                        <!-- end col-->
                    </div>
                    <div class="row mb-2">
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
                        <div class="col-lg-2">

                        </div>
                        <div class="col-lg-3">
                            <div class="mb-3" wire:ignore>
                                <select wire:model.live="category" wire:change="resetPage"
                                        class="select2 form-control category" data-toggle="select2"
                                        data-placeholder="Choisir ...">
                                    <option value="-1">--Catégories--</option>
                                    @foreach ($categories as $item)
                                        <option value="{{$item->id}}">{{$item->label}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

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


                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="status" wire:change="resetPage" class="form-select"
                                        id="example-select">
                                    <option value="">--Statut--</option>
                                    <option value="0">Non publiée</option>
                                    <option value="1">Publiée</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="input-group float-end">
                                <input type="text" wire:model.live="search" wire:keyup="resetPage" class="form-control"
                                       placeholder="Rechercher...">

                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>
                                <th class="all">Titre
                                    <a href="#" wire:click="sortBy('title')">
                                        <i class="mdi mdi-arrow-up"></i>
                                        <i class="mdi mdi-arrow-down"></i>
                                    </a>
                                </th>
                                <th>Categorie(s)</th>
                                <th>Auteur</th>
                                <th>Statut</th>
                                <th>Date de création
                                    <a href="#" wire:click="sortBy('created_at')">
                                        <i class="mdi mdi-arrow-up"></i>
                                        <i class="mdi mdi-arrow-down"></i>
                                    </a>
                                </th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pages as $page)
                                <tr>

                                    <td style="width: 30%;white-space :normal">
                                        {{$page->title}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$page->categories->label}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">


                                        {{$page->author->email}}

                                    </td>

                                    <td>
                                        <span
                                            class="badge badge-outline-{{$page->is_published ? 'success' : 'danger'}}">{{$page->is_published ? 'Publiée' : 'Non publiée'}}</span>
                                    </td>
                                    <td>
                                        {{$page->created_at}}
                                    </td>


                                    <td class="table-action">
                                        @can('view pages')
                                            <a href="{{route('pages.show', $page->id)}}" title="Voir"> <i
                                                    class="mdi mdi-eye text-info h3"></i></a>
                                        @endcan
                                        @can('edit pages')
                                            <a href="{{route('pages.edit', $page->id)}}" title="Modifier"> <i
                                                    class="mdi mdi-square-edit-outline text-primary h3"></i></a>
                                        @endcan
                                        @can('delete pages')
                                            <a href="javascript:void(0);"
                                               wire:click.prevent="$dispatch('confirm-delete',{{$page->id}})"
                                               title="Supprimer"> <i class="mdi mdi-delete text-danger h3"></i></a>

                                        @endcan


                                        @if(!$page->is_published)
                                            @can('publish pages')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="publishPage({{$page->id}})" title="Publier"> <i
                                                        class="mdi mdi-bookmark-check text-success h3"></i></a>
                                            @endcan
                                        @else
                                            @can('unpublish pages')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="unpublishPage({{$page->id}})" title="Dépublier"> <i
                                                        class="mdi mdi-bookmark-outline text-warning h3"></i></a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($pages->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucune categorie n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$pages->firstItem()}} a {{$pages->lastItem()}} sur {{$pages->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($pages->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($pages->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($pages->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#"
                                                   wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$pages->hasMorePages()) disabled @endif">
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
    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-filled bg-danger">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="ri-close-circle-line h1"></i>
                        @if($confirm_delete)
                            <h4 class="mt-2">Attention!</h4>
                            <p class="mt-3">Voulez-vous supprimer cette page? Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2"
                                    wire:click="deletePage({{$confirm_delete}})">Confirmer
                            </button>
                        @endif
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div> <!-- container -->
@assets
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endassets
@script
<script>
    document.addEventListener('livewire:initialized', function () {
        $('.category').select2(
            {
                placeholder: '--Catégories-',
                allowClear: true
            });

        $('.category').on('change', function () {
        @this.set('category', this.value)
            ;
        })
    });

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
                Livewire.dispatch('deletePage', {page_id: id});
                /*Swal.fire(
                    'Supprimé!',
                    'L\'article a été supprimé.',
                    'success'
                );*/
            }
        });
    });


    $wire.on('page-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'La page a été supprimée.',
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
        $modal.modal('show');
        @this.set('confirm_delete', id);

    })
    $wire.on('page-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript
