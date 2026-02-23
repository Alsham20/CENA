<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('articles.index')}}">Articles</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Articles</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create articles')
                        <div class="col-sm-5">
                            <a href="{{route('articles.create')}}" class="btn btn-success mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> Ajouter un article</a>
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

                        <div class="col-lg-2">
                            <div class="mb-3" wire:ignore>
                                <select wire:model.live="activity" wire:change="resetPage"
                                    class="select2 form-control activity" data-toggle="select2"
                                    data-placeholder="Choisir ...">
                                    <option value="-1">--Activités--</option>
                                    @foreach ($activities as $item)
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

                        <!-- <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="type" wire:change="resetPage" class="form-select"
                                    id="example-select">
                                    <option value="">--Types--</option>
                                    <option value="0">Public</option>
                                    <option value="1">Privé</option>

                                </select>
                            </div>
                        </div> -->

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="status" wire:change="resetPage" class="form-select"
                                    id="example-select">
                                    <option value="">--Statut--</option>
                                    <option value="0">Non publié</option>
                                    <option value="1">Publié</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4">
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
                                    <!-- <th>Activité(s)</th> -->
                                    <th>Auteur</th>
                                    <th>Statut</th>
                                    <th>Privée</th>
                                    <th>A la une</th>
                                    <th>Date de création
                                        <a href="#" wire:click="sortBy('created_at')">
                                            <i class="mdi mdi-arrow-up"></i>
                                            <i class="mdi mdi-arrow-down"></i>
                                        </a>
                                    </th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                <tr>
                                    <td style="width: 30%;white-space :normal">
                                        {{$article->title}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$article->categories->label}}
                                    </td>
                                    <!-- <td style="width: 20%;white-space :normal">
                                        {{$article->activities->label}}
                                    </td> -->
                                    <td style="width: 20%;white-space :normal">

                                        {{$article->author->email}}

                                    </td>

                                    <td>
                                        <span
                                            class="badge badge-outline-{{$article->is_published ? 'success' : 'warning'}}">{{$article->is_published ? 'Publié' : 'Non publié'}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-outline-{{$article->is_private ? 'success' : 'warning'}}">{{$article->is_private ? 'Oui' : 'Non'}}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-outline-{{$article->is_featured ? 'success' : 'warning'}}">{{$article->is_featured ? 'Oui' : 'Non'}}</span>
                                    </td>
                                    <!-- <td>
                                        {{$article->date_article ? \Carbon\Carbon::parse($article->date_article)->format('d/m/Y H:i') : ""}}
                                    </td> -->
                                    <td>
                                        {{$article->created_at}}
                                    </td>
                                    <td class="table-action p-0">
                                        @can('view articles')
                                        <a href="{{route('articles.show', $article->id)}}" title="Voir"> <i
                                                class="mdi mdi-eye text-info h3"></i></a>
                                        @endcan

                                        @can('edit articles')
                                        <a href="{{route('articles.edit', $article->id)}}" title="Modifier"> <i
                                                class="mdi mdi-square-edit-outline text-primary h3"></i></a>
                                        @endcan

                                        @can('delete articles')
                                        <a href="javascript:void(0);"
                                            wire:click.prevent="$dispatch('confirm-delete',{{$article->id}})"
                                            title="Supprimer"> <i class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan

                                        @can('archive articles')
                                        <a href="javascript:void(0);"
                                            wire:click.prevent="archiveArticle({{$article->id}})" title="Archiver">
                                            <i
                                                class="mdi mdi-archive text-success h3"></i></a>
                                        @endcan

                                        @if(!$article->is_published)
                                        @can('publish articles')
                                        <a href="javascript:void(0);"
                                            wire:click.prevent="publishArticle({{$article->id}})" title="Publié">
                                            <i
                                                class="mdi mdi-bookmark-check text-success h3"></i></a>
                                        @endcan
                                        @else
                                        @can('unpublish articles')
                                        <a href="javascript:void(0);"
                                            wire:click.prevent="unpublishArticle({{$article->id}})"
                                            title="Dépublier"> <i
                                                class="mdi mdi-bookmark-outline text-warning h3"></i></a>
                                        @endcan
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($articles->count() == 0)
                        <div class="alert alert-info" role="alert">
                            Aucun article n'est disponible.
                        </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$articles->firstItem()}} a {{$articles->lastItem()}}
                                sur {{$articles->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($articles->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                                tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($articles->links()->elements[0] as $page => $url)
                                        <li class="page-item @if($articles->currentPage() == $page) active @endif">
                                            <a class="page-link" href="#"
                                                wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                        </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$articles->hasMorePages()) disabled @endif">
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
                        {{$confirm_delete}}
                        @if($confirm_delete)
                        <h4 class="mt-2">Attention!</h4>
                        <p class="mt-3">Voulez-vous supprimer cet article ? Cette action est irreversible</p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-warning my-2"
                            wire:click="deleteArticle({{$confirm_delete}})">Confirmer
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
    document.addEventListener('livewire:initialized', function() {
        $('.category').select2({
            placeholder: '--Catégories-',
            allowClear: true
        });

        $('.category').on('change', function() {
            @this.set('category', this.value);
        })
    });


    Livewire.on('confirm-delete', id => {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "L'élément sera envoyé dans la corbeille!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                //Livewire.emit('deleteArticle', id);
                Livewire.dispatch('deleteArticle', {
                    article_id: id
                });
                /*Swal.fire(
                    'Supprimé!',
                    'L\'article a été supprimé.',
                    'success'
                );*/
            }
        });
    });


    $wire.on('article-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'L\'article a été envoyé dans la corbeille.',
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

    Livewire.on('article-deleted', () => {
        const modal = bootstrap.Modal.getInstance(document.getElementById('danger-alert-modal'));
        if (modal) {
            modal.hide();
        }
    });*/

    /*Livewire.on('confirm-delete', id => {
        @this.set('confirm_delete', id);
        $('#danger-alert-modal').modal('show');
    });*/

    /*$wire.on('confirm-delete', (id) => {
        @this.set('confirm_delete', id);
        $modal = $('#danger-alert-modal');
        $modal.modal('show');


    })
    $wire.on('article-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript