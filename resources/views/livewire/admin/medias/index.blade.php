<div class="container-fluid">


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('medias.index')}}">Medias</a></li>
                        <li class="breadcrumb-item active">liste</li>
                    </ol>
                </div>
                <h4 class="page-title">Medias</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        @if(count($photos) == 0)
                        @can('create medias')
                            <div class="col-sm-5">
                                <a href="#" class="btn btn-success mb-2" onclick="$('.add-form').removeClass('d-none'); $(this).addClass('d-none')"><i class="mdi mdi-plus-circle me-2"></i> Ajouter des medias</a>
                            </div>
                        @endcan
                        @endif
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
                        <div class="row add-form @if(count($photos) == 0)d-none @endif">
                            <div class="col-sm-3 col-xl-3 mb-3">
                                <div class="card mb-0 h-100">
                                    <form wire:submit="save">
                                        <div class="card-body">
                                            <div class="border-dashed border-2 border h-100 w-100 rounded d-flex align-items-center justify-content-center">
                                                <a href="#" class="text-center text-muted p-2" onclick="this.parentNode.querySelector('input[type=file]').click()">
                                                    <i class="mdi mdi-plus h3 my-0"></i>
                                                    @if ($photos)
                                                        <span class="badge badge-outline-success b d-block">Modifier l'image</span>
                                                    @else
                                                        <span class="badge badge-outline-info d-block">Ajouter une image </span>
                                                    @endif
                                                </a>
                                                <input type="file" wire:model="photos" class="d-none" multiple>

                                                @error('photos.*') <span class="error">{{ $message }}</span> @enderror

                                            </div>
                                        </div> <!-- end card-body -->
                                        <button type="submit"  class="btn btn-primary mt-1">Valider </button>
                                    </form>
                                </div> <!-- end card -->
                            </div>
                            <div class="col-sm-9 col-xl-9 mb-3">
                                <div class="card mb-0 h-100">
                                    <div class="card-body">
                                        @if(count($photos) != 0)
                                            <div class="border-dashed border-2 border h-100 w-100 rounded row">
                                                @foreach ($photos as $key => $photo)
                                                    <div class="col-2 p-1">
                                                        @can('delete medias')
                                                            <i class="mdi mdi-close text-danger bg-white p-1 rounded" style="cursor: pointer" wire:click="removePhoto({{ $key }})"></i>
                                                        @endcan
                                                        <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div> <!-- end card-body-->
                                </div> <!-- end card -->
                            </div>
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
                        </div>
                        <div class="mb-3 col-md-12">
                            <div class="card mb-0 h-100 ">
                                <div class="card-body">
                                    <div class="border-dashed border-2 border rounded row p-1">
                                        @foreach ($medias as $media)
                                            <div class="col-3 p-1">
                                                @can('delete medias')
                                                <i class="mdi mdi-close text-danger bg-white p-1 rounded position-absolute" style="cursor: pointer" wire:click="$dispatch('confirm-delete',{{ $media->id }})"></i>
                                                @endcan
                                                <img id="media_{{ $media->id }}" src="{{ $media->getUrlThumbnail() }}" class="img-thumbnail border @if($media == $selected) border-success @endif" style="cursor: pointer" alt="" wire:click="dispatchEvent('setMedia','{{ $media->id }}')">
                                            </div>
                                        @endforeach
                                    </div>
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div> <!-- end col -->
                        @if ($medias->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucune media n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">Afficher {{$medias->firstItem()}} a {{$medias->lastItem()}} sur {{$medias->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($medias->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($medias->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($medias->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$medias->hasMorePages()) disabled @endif">
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
                            <p class="mt-3">Voulez-vous supprimer cette image? Cette action est irreversible</p>
                            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-warning my-2" wire:click="deleteMedia({{$confirm_delete}})">Confirmer</button>
                        @endif
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div> <!-- container -->

@script
<script>
        $wire.on('confirm-delete', (id) => {
            $modal = $('#danger-alert-modal');
            $modal.modal('show');
            @this.set('confirm_delete', id);

        })
        $wire.on('media-deleted', () => {
            $modal = $('#danger-alert-modal');
            $modal.modal('hide');
        })
</script>
@endscript
