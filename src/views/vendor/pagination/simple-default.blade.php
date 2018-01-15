@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>@lang('pagination.previous')</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a></li>
        @endif
        <li>
            <span>
        <form name="paginate_form" class="pagination_form" method="GET" action="{{$paginator->previousPageUrl()}}">

            <select name="paginate" id="paginate">
                 @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))

                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                     <option><a class="btn btn-success btn-block active dropdown-item"><span>Page {{ $page }}</span></a></option>
                    @else
                       <option ><a style="text-align: centre;width:100%" class="btn btn-xs btn-default active dropdown-item"><a href="{{ $url }}">
                          Page {{ $page }}
                       </a>
                       </option>
                    @endif
                @endforeach
            @endif
           <div class="dropdown-divider"></div>
        @endforeach
            </select>
            <input type="hidden" name="from_date" value="{{request()->from_date}}">
            <input type="hidden" name="to_date" value="{{request()->to_date}}">
            <input type="hidden" name="voucher_type_id" value="{{request()->voucher_type_id}}">
        </form>
                </span>
        </li>
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a></li>
        @else
            <li class="disabled"><span>@lang('pagination.next')</span></li>
        @endif
    </ul>
@endif
