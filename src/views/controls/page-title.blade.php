
@php

if(!isset($trans))
$trans = explode('.',$route)[0]

@endphp

        <!-- start: PAGE TITLE -->
<section id="page-title" class="margin-bottom-20">
    <div class="row">
        <div class="col-md-8 col-sm-6">
            <h1 class="mainTitle">{{ $title or trans($trans.'.index.list') }}
                @if(isset($page))
                    <a tabindex="0" class="exclude-title"
                       data-toggle="popover"
                       data-title="{{ $page->title }}"
                       data-content="{{ $page->description }}">
                        <i class="fa fa-question-circle" style="color:#d1d1d1; font-size: 22px;"> </i>
                    </a>
                @endif
            </h1>
            <span class="hidden-xs mainDescription">{{ $description or trans($trans.'.index.description') }}</span>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="hidden-xs ">
                <ol class="breadcrumb">
                    @foreach($breadcrumb as $action)
                        <li class="{{ $loop->last ? 'active' : '' }}">
                            <span>{{ $action }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
            <div class="clearfix"></div>
            <div class="margin-top-30 text-right margin-right-15">
                @foreach($buttons as $button)

                    @if (slug() == 'admin')

                         <a onclick="{{isset($button['click'])?$button['click']:""}}" href="{{ $button['url'] }}" class="{{ $button['class'] or 'btn btn-wide btn-azure' }}" style=""> {{ trans($button['text']) }}</a>

                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- end: PAGE TITLE -->