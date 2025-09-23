<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('events.index')}}">Evènements</a></li>
                        <li class="breadcrumb-item active">Liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Evènements</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create events')
                            <div class="col-sm-5">
                                <a href="{{route('events.create')}}" class="btn btn-danger mb-2"><i
                                        class="mdi mdi-plus-circle me-2"></i> Ajouter un évènement</a>
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

                        </div>
                        <div class="col-lg-2">
                            <div class="mb-3">
                                <select wire:model.live="status" wire:change="resetPage" class="form-select"
                                        id="example-select">
                                    <option value="">--Statut--</option>
                                    <option value="1">Publiée</option>
                                    <option value="0">Non publiée</option>
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

                                <th class="all">Evènement</th>
                                <th>Lieu</th>
                                <th>Status</th>
                                <th>Date début</th>
                                <th>Date Fin</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($events as $event)
                                <tr>


                                    <td>
                                        {{$event->event_name}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$event->place}}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-outline-{{$event->is_published ? 'success' : 'warning'}}">{{$event->is_published ? 'Publié' : 'Non publié'}}</span>
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{ ($event->event_start) ? \Carbon\Carbon::parse($event->event_start)->format('d/m/Y H:i') : ""}}
                                    </td>

                                    <td style="width: 20%;white-space :normal">
                                        {{ ($event->event_end) ? \Carbon\Carbon::parse($event->event_end)->format('d/m/Y H:i') : ""}}
                                    </td>

                                    <td>
                                        {{$event->created_at}}
                                    </td>


                                    <td class="table-action">
                                        @can('view events')
                                            <a href="{{route('events.show', $event->id)}}"> <i
                                                    class="mdi mdi-eye text-info h3"></i></a>

                                        @endcan
                                        @can('edit events')
                                            <a href="{{route('events.edit', $event->id)}}"> <i
                                                    class="mdi mdi-square-edit-outline text-primary h3"></i></a>

                                        @endcan
                                        @can('delete events')
                                            <a href="javascript:void(0);"
                                               wire:click.prevent="$dispatch('confirm-delete',{{$event->id}})"> <i
                                                    class="mdi mdi-delete text-danger h3"></i></a>

                                        @endcan

                                        @if(!$event->is_published)
                                            @can('publish events')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="publishEvent({{$event->id}})" title="Publié"> <i
                                                        class="mdi mdi-bookmark-check text-success h3"></i></a>
                                            @endcan
                                        @else
                                            @can('unpublish events')
                                                <a href="javascript:void(0);"
                                                   wire:click.prevent="unpublishEvent({{$event->id}})"
                                                   title="Dépublier"> <i
                                                        class="mdi mdi-bookmark-outline text-warning h3"></i></a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($events->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucun évènement n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$events->firstItem()}} a {{$events->lastItem()}}
                                sur {{$events->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($events->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($events->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($events->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#"
                                                   wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$events->hasMorePages()) disabled @endif">
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
                            <p class="mt-3">Voulez-vous supprimer cet évènement? Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2" wire:click="delete({{$confirm_delete}})">
                                Confirmer
                            </button>
                        @endif
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div> <!-- container -->
@include('livewire.chunks.notification')
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
                Livewire.dispatch('delete', {id: id});
                /*Swal.fire(
                    'Supprimé!',
                    'La composante a été supprimée.',
                    'success'
                );*/
            }
        });
    });

    $wire.on('event-deleted', () => {
        Swal.fire(
            'Supprimé!',
            'L\'évènement a été supprimé.',
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
    $wire.on('event-deleted', () => {
        $modal = $('#danger-alert-modal');
        $modal.modal('hide');
    })*/
</script>
@endscript
