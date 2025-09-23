<div class="dataTables_paginate paging_simple_numbers float-end" id="products-datatable_paginate">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
            <!-- Bouton Précédent -->
            <li class="page-item @if($currentPage == 1) disabled @endif">
                <a class="page-link" href="#" wire:click.prevent="previousPage" tabindex="-1">Previous</a>
            </li>

            <!-- Liens vers les pages -->
            @for($page = 1; $page <= $lastPage; $page++)
                <li class="page-item @if($currentPage == $page) active @endif">
                    <a class="page-link" href="#" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                </li>
            @endfor

            <!-- Bouton Suivant -->
            <li class="page-item @if($currentPage == $lastPage) disabled @endif">
                <a class="page-link" href="#" wire:click.prevent="nextPage">Next</a>
            </li>
        </ul>
    </nav>
</div>
