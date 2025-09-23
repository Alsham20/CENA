<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('settings.index')}}">Parametres</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Menu</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @can('create settings')
                            <div class="col-sm-5">
                                <a  href="{{route('settings.create')}}" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Ajouter un Paramètre</a>
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
                                <th>Clé(s)</th>
                                <th>Valeur</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Action(s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($settings as $setting)
                                <tr>



                                    <td style="width: 30%;white-space :normal">
                                        {{$setting->label}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$setting->key ?? ''}}
                                    </td>
                                    <td style="width: 30%;white-space :normal">
                                        {{ \Illuminate\Support\Str::substr(($setting->type == "password") ? "****************************" : $setting->value, 0, 40)}} {{ \Illuminate\Support\Str::length($setting->value) > 40 ? '...' : '' }}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        @if($setting->is_active)
                                            <span class="badge badge-outline-success">Actif</span>
                                        @else
                                            <span class="badge badge-outline-danger">Inactif</span>
                                        @endif

                                    </td>

                                    <td>
                                        {{$setting->created_at}}
                                    </td>




                                    <td class="table-action">
                                        {{--<a href="{{route('settings.show', $setting->id)}}"> <i class="mdi mdi-eye text-info h3"></i></a>--}}

                                        @can('edit settings')
                                            <a href="{{route('settings.edit', $setting->id)}}"> <i class="mdi mdi-square-edit-outline text-warning h3"></i></a>
                                        @endcan
                                        @can('delete settings')
                                            <a href="javascript:void(0);" wire:click="$dispatch('confirm-delete','{{$setting->id}}')"> <i class="mdi mdi-delete text-danger h3"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                            @if ($settings->count() == 0)
                                <div class="alert alert-info" role="alert">
                                    Aucun paramètre n'est disponible.
                                </div>
                            @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$settings->firstItem()}} a {{$settings->lastItem()}}
                                sur {{$settings->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($settings->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($settings->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($settings->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$settings->hasMorePages()) disabled @endif">
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
                            <p class="mt-3">Voulez-vous vraiment supprimer le paramètre <span class="text-white font-weight-bold text-uppercase">"{{$settings->find($confirm_delete)->label}}"</span>. Cette action est irreversible</p>
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
        $wire.on('setting-deleted', () => {
            $modal = $('#danger-alert-modal');
            $modal.modal('hide');
        })
</script>
@endscript
