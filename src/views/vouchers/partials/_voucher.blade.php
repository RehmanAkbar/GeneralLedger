

    <div class="row">
        @if($buttons)
            <div class="col-md-12 text-right">
                <a style="margin-left:5px" onclick="window.print();" class="hide_print btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" href="javascript:void(0)">
                    <i class="ti-printer" aria-hidden="true"></i>
                </a>

                <a class="hide_print btn margin-bottom-5 pull-right btn-wide btn-o btn-primary" href="{{route('download_voucher',['voucher_id' => $voucher->id])}}">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>
            </div>
        @endif
        <div class="col-md-12 text-right">
            <img src="{{asset('company/images')}}/{{$voucher['company']->image}}" width="150" >
        </div>
        <div class="col-md-12">
            <h5 class="over-title margin-bottom-15 text-center"><span class="text-bold">{{$voucher['company']->name}}</span></h5>
            <p class="text-center">
                {{$voucher['office']->address}}
            </p>
        </div>

        {{--<div class="col-md-4">--}}
            {{--<div class="text-right text_date_page_no">--}}
                {{--<h5 class="over-title margin-bottom-15"><span>Page 1 to 50</span></h5>--}}
            {{--<p>--}}
                {{--<strong> Date:</strong> 2018-20--}}
            {{--</p>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="clear"></div>--}}
        <table class="table table-bordered tbl_voucher">
            <thead>
            <tr >
                <th style="border-bottom: none" class="text-center padding-top-5" colspan="5">{{$voucher['type']->description}}</th>
            </tr>
            <tr>
                <th class="text-left" colspan="5">
                    <div>
                        <p class="font-weight">Voucher No. : {{$voucher->voucher_code}}</p>

                    </div>
                    <div>
                        <p class="font-weight">Date............. : {{$voucher->voucher_date}}</p>

                    </div>
                </th>
            </tr>
            <tr>
                {{--<th class="center">#</th>--}}
                <th>Code</th>
                <th>Account Description/Narration</th>
                <th>C.C / Dept</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($voucher['details'] as $detail)
                <tr>
                    {{--<td class="center">{{$loop->iteration}}</td>--}}
                    <td>{{$detail['account']->code or ""}}</td>
                    <td style="width: 60%">

                        <div style="border-bottom: dashed 1px #000">
                            <p class="text-bold">{{$detail['account']->description or ""}}</p>
                        </div>
                        <div style="margin-top: 5px">
                            <p>{{$detail->narration}}</p>
                        </div>

                    </td>
                    <td width="90"></td>
                    <td class="text-right">{{number_format($detail->debit, 2, '.', ',')}}</td>
                    <td class="text-right">{{number_format($detail->credit, 2, '.', ',')}}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-right text-bold padding-top-5 padding-bottom-5" colspan="3">Total Amount:</td>
                <td class="text-right text-bold padding-top-5 padding-bottom-5">{{number_format($voucher['details']->sum('debit'), 2, '.', ',')}}</td>
                <td class="text-right text-bold padding-top-5 padding-bottom-5">{{number_format($voucher['details']->sum('credit'), 2, '.', ',')}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="clear10"></div>
    <dl>
        <div class="clear"></div>
        <dt class="col-md-3">
            Amount In Words:
        </dt>
        <dd class="col-md-9">
            {{ucwords($numberFormatter->format(collect($voucher['details'])->sum('credit'))) }}
        </dd>
        <div class="clear"></div>
        <dt class="col-md-3">
            Remarks:
        </dt>
        <dd class="col-md-9">
            {{$voucher->remarks}}
        </dd>
        <div class="clear"></div>
    </dl>

    <div class="clear10"></div>
    <div class="row">

        <div class="margin-top-30 prepared_checked">

            @if($voucher['type']->prepared_by)
                <div class="col-md-3">
                    <p class="text-center" style="border-bottom: 1px solid #000;margin-bottom: 0px"></p>
                    <p class="text-center">{{$voucher['type']->prepared_by}}</p>
                </div>
            @endif
            @if($voucher['type']->checked_by)
                <div class="col-md-3">
                    <p class="text-center" style="border-bottom: 1px solid #000;margin-bottom: 0px"></p>
                    <p class="text-center">{{$voucher['type']->checked_by}}</p>
                </div>
            @endif
            @if($voucher['type']->approved_by)
                <div class="col-md-3">
                    <p class="text-center" style="border-bottom: 1px solid #000;margin-bottom: 0px"></p>
                    <p class="text-center">{{$voucher['type']->approved_by}}</p>
                </div>
            @endif
            @if($voucher['type']->accepted_by)
                <div class="col-md-3">
                    <p class="text-center" style="border-bottom: 1px solid #000;margin-bottom: 0px"></p>
                    <p class="text-center">{{$voucher['type']->accepted_by}}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="clear10"></div>
