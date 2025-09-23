<div class="row">
    

    <div class="col-sm-3 col-xl-3 mb-3">
        <div class="card mb-0 h-100">
            <div class="card-body">
                <form wire:submit="save">
                    
                    <div class="border-dashed border-2 border h-100 w-100 rounded d-flex align-items-center justify-content-center"
                    @if ($photo)
                        style="background-image: url({{ $photo->temporaryUrl() }}); background-size: cover;"
                    @endif
                    >
                        <a href="#" class="text-center text-muted p-2" onclick="this.parentNode.querySelector('input[type=file]').click()">
                                <i class="mdi mdi-plus h3 my-0"></i>
                            
                                @if ($photo)
                                    <span class="badge badge-outline-success b d-block">Modifier l'image</span>
                                @else
                                    <span class="badge badge-outline-info d-block">Ajouter une image </span>
                                @endif
                           
                        </a>
                        <input type="file" wire:model="photo" class="d-none">
                        @error('photo') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit"  class="btn btn-primary mt-1">Valider </button>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="col-md-8">
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
    <div class="mb-3 col-md-12">
        <div class="card mb-0 h-100 ">
            <div class="card-body">
                <div class="border-dashed border-2 border rounded row p-1">
                    @foreach ($medias as $media)
                        <img id="media_{{ $media->id }}" src="{{ $media->getUrlThumbnail() }}" class="img-thumbnail col-3 border @if($media->id == $selected) border-success @endif" style="cursor: pointer" alt="" wire:click="dispatchEvent('setMedia','{{ $media->id }}')">
                    @endforeach
                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
    <div class="row mt-3" >
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">Afficher {{$medias->firstItem()}} a {{$medias->lastItem()}} sur {{$medias->total()}}</div>
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="dataTables_paginate paging_simple_numbers float-end" id="products-datatable_paginate">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                      <li class="page-item @if($medias->currentPage() == 1) disabled @endif">
                        <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
                      </li>
                      <li class="page-item"><a class="page-link active" href="#">{{$medias->currentPage()}}</a></li>
                      <li class="page-item @if($medias->currentPage() == $medias->lastPage()) disabled @endif">
                        <a class="page-link" href="#" wire:click.prevent="nextPage">Next</a>
                      </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@script
<script>
    document.addEventListener('livewire:initialized', function () {

        $wire.on('setMedia', (d) => {
            //remove border-success to all img-thumbnail
            $('.img-thumbnail').removeClass('border-success');
            
            //add border-success
            $('#media_'+d[0]).addClass('border-success');
        });
    });
</script>
@endscript