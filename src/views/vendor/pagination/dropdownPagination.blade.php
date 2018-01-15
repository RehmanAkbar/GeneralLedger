@if ($paginator->hasPages())
      {{-- Previous Page Link --}}
      <div class="row">
      <div class="col-lg-4"> 
        @if ($paginator->onFirstPage())
           <a class="disabled active"><span>Previous Page</span></a>
        @else
          <a class="dropdown-item active dropdown-item" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous Page</a>
        @endif
       </div>
       <div class="col-lg-4">
        <div class="dropdown show">
            <a class="btn btn-default dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Page {{$paginate}}
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                         {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                  {{-- Array Of Links --}}
                  @if (is_array($element))
                     @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                          <a class="btn btn-success btn-block active dropdown-item"><span>Page {{ $page }}</span></a>
                        @else
                          <a style="text-align: centre;width:100%" class="btn btn-xs btn-default active dropdown-item" href="{{ $url }}">
                          Page {{ $page }}
                          </a> 
                        @endif
                    @endforeach
                  @endif
                @endforeach
            </div>
      </div>
    </div>
    <div class="col-lg-4">
{{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
           <a class="dropdown-item dropdown-item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">Next Page</a>
        @else
         <a class="disabled dropdown-item btn btn-xs btn-warning dropdown-item"><span>Next Page</span></a>
        @endif
        </div>
@endif
