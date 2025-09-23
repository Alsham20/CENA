<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Menus</a></li>
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

                                <th class="all">login</th>
                                <th>Adresse Ip</th>
                                <th>Action(s)</th>
                                <th>Role(s)</th>
                                <th>Date de création</th>
                                <th style="width: 85px;">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($audits as $audit)
                                <tr>


                                    <td>
                                        {{$audit->user()->email ?? ''}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$audit->ip_address ?? ''}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$audit->event}}
                                    </td>
                                    <td style="width: 20%;white-space :normal">
                                        {{$audit->role}}
                                    </td>

                                    <td>
                                        {{$audit->created_at}}
                                    </td>


                                    <td class="table-action">
                                        @can('view audits')
                                            <a href="{{route('audits.show', $audit->id)}}" class="action-icon"> <i
                                                    class="mdi mdi-eye"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                        @if ($audits->count() == 0)
                            <div class="alert alert-info" role="alert">
                                Aucun log audit n'est disponible.
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="products-datatable_info" role="status" aria-live="polite">
                                Afficher {{$audits->firstItem()}} a {{$audits->lastItem()}}
                                sur {{$audits->total()}}</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers float-end"
                                 id="products-datatable_paginate">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-end">
                                        <!-- Bouton Précédent -->
                                        <li class="page-item @if($audits->onFirstPage()) disabled @endif">
                                            <a class="page-link" href="#" wire:click.prevent="previousPage"
                                               tabindex="-1">Previous</a>
                                        </li>

                                        <!-- Liens vers les pages -->
                                        @foreach ($audits->links()->elements[0] as $page => $url)
                                            <li class="page-item @if($audits->currentPage() == $page) active @endif">
                                                <a class="page-link" href="#"
                                                   wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        <!-- Bouton Suivant -->
                                        <li class="page-item @if(!$audits->hasMorePages()) disabled @endif">
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
