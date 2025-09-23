<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('newsletters.index')}}">Abonnés</a></li>
                        <li class="breadcrumb-item active">Liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Liste des abonnés</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create followers')
                            <div class="col-sm-5">
                                <a href="{{route('newsletters.create-follower')}}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Ajouter des abonnés</a>
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
                        <div class="col-lg-3"></div>

                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="categorie" wire:change="resetPage" class="form-select"
                                        id="example-select">
                                    <option value="">--Catégorie--</option>
                                    <option value="-1">Visiteur</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{$categorie->id}}">{{$categorie->label}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="status" wire:change="resetPage" class="form-select"
                                        id="example-select">
                                    <option value="">--Statut--</option>
                                    <option value="1">Abonné</option>
                                    <option value="0">Désabonné</option>
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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                            <tr>

                                <th class="all">E-mail</th>
                                <th>Nom</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($followers as $follower)
                                <tr>


                                    <td style="width: 20%;white-space :normal">
                                        {{$follower->email}}
                                    </td>
                                    <td style="width: 30%;white-space :normal">
                                        {{$follower->lastname." ".$follower->firstname}}
                                    </td>

                                    <td style="width: 30%;white-space :normal">
                                        {{ ($follower->categorie_abonne_id == null) ? "Visiteur" : $follower->categorie->label  }}
                                    </td>

                                    <td style="width: 20%;white-space :normal">
                                        <span
                                            class="badge badge-outline-{{$follower->is_active ? 'success' : 'danger'}}">{{$follower->is_active ? 'Abonné' : 'Désabonné'}}</span>

                                    </td>

                                    <td>
                                        {{$follower->created_at}}
                                    </td>




                                    <td class="table-action">
                                        <a href="javascript:void(0);" wire:click.prevent="$dispatch('confirm-delete',{{$follower->id}})"> <i class="mdi mdi-delete text-warning h3"></i></a>
                                        @if($follower->is_active)
                                            <a href="javascript:void(0);" wire:click.prevent="$dispatch('confirm-unfollow',{{$follower->id}})"> <i class="mdi mdi-cancel text-danger h3"></i></a>
                                        @else
                                            <a href="javascript:void(0);" wire:click.prevent="$dispatch('confirm-follow',{{$follower->id}})"> <i class="mdi mdi-account-reactivate-outline text-success h3"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($followers->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucun abonné n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$followers->firstItem()}} a {{$followers->lastItem()}}
                                sur {{$followers->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($followers->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($followers->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($followers->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$followers->hasMorePages()) disabled @endif">
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
                            <p class="mt-3">Voulez-vous supprimer ce site? Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2" wire:click="delete({{$confirm_delete}})">Confirmer</button>
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
                Livewire.dispatch('delete', { id: id });
                /*Swal.fire(
                    'Supprimé!',
                    'La composante a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    Livewire.on('confirm-unfollow', id => {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, désabonner!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                //Livewire.emit('deleteArticle', id);
                Livewire.dispatch('unfollow', { id: id });
                /*Swal.fire(
                    'Supprimé!',
                    'La composante a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    Livewire.on('confirm-follow', id => {
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, abonner!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                //Livewire.emit('deleteArticle', id);
                Livewire.dispatch('follow', { id: id });
                /*Swal.fire(
                    'Supprimé!',
                    'La composante a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    $wire.on('follower-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'L\'abonné a été supprimé.',
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

    $wire.on('follower-unfollowed', () => {
        Swal.fire(
            'Désabonné!',
            'L\'abonné a été désactivé.',
            'success'
        );
    })

    $wire.on('error-unfollowed', () => {
        Swal.fire(
            'Erreur!',
            'Une erreur s\'est produite lors de la désactivation.',
            'error'
        );
    })

    $wire.on('follower-followed', () => {
        Swal.fire(
            'Abonné!',
            'L\'abonné a été activé.',
            'success'
        );
    })

    $wire.on('error-followed', () => {
        Swal.fire(
            'Erreur!',
            'Une erreur s\'est produite lors de l\'activation.',
            'error'
        );
    })
    /*$wire.on('confirm-delete', (id) => {
        $modal = $('#danger-alert-modal');
    @this.set('confirm_delete', id);
        $modal.modal('show');
    })
    $wire.on('site-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript
