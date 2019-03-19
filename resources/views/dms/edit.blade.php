@extends('layouts.main')
@section('content')
    <div class="row page-titles m-b-0">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div>
            <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="card card-body printableArea">
                <h3 class="text-center">{{ ucwords( $dms->customer->Name)  }}</h3>
                <br>
                <div class="row">
                    <div class="card-body wizard-content">
                        <div class="col-md-12">
                            @if($update)
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Update Client Details</h4>
                                        <div class="col-12">
                                            <form style="text-align: left !important;" id="update_service{{$dms->id}}" action="{{ url('/update-dms') }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="bl_number">BL Number</label>
                                                            <input type="text" required id="bl_number" name="bl_number" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="esl_ref">ESL REF</label>
                                                            <input type="text" required id="esl_ref" name="esl_ref" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ctm_ref">Client REF</label>
                                                            <input type="text" required id="ctm_ref" name="ctm_ref" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="consignor">Consignor</label>
                                                            <input type="text" required id="consignor" name="consignor" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="consignee">Consignee</label>
                                                            <input type="text" value="{{$dms->customer->Name}}" required id="consignee" name="consignee" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="contract_ids">Select Transporters</label>
                                                            <select required name="contract_ids" id="contract_ids"
                                                                    class="form-control select2">
                                                                @foreach(\App\Contract::all() as $value)
                                                                    <option value="{{$value->id}}">{{ ucwords($value->company_name) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="client_notification">Notify Customer</label>
                                                            <select required name="client_notification" id="client_notification"
                                                                    class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="hour">Every 1 Hour</option>
                                                                <option value="twice">Twice Daily</option>
                                                                <option value="once">Once Daily</option>
                                                                <option value="action">When an action occurs</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shipper">Shipper</label>
                                                            <input type="text" required id="shipper" name="shipper" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="shipping_line">Shipping Line</label>
                                                            <input type="text" required id="shipping_line" name="shipping_line" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="branch_code">Branch code</label>
                                                            <input type="text" required id="branch_code" name="branch_code" class="form-control">
                                                        </div>
                                                        <input type="hidden" name="dms_id" value="{{ $dms->id }}">
                                                       <div class="form-group">
                                                            <br>
                                                            <input class="btn text-center btn-primary" type="submit" value="Update">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Client Details</h4>
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#pda" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Client Documents</span>
                                            </a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Cargo Images</span>
                                            </a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Transport</span></a> </li>
                                         {{--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#agency" role="tab">--}}
                                                {{--<span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Actions</span></a> </li>--}}
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#checklist1" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Job Details</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#delivery" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Delivery Docs</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#truck" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Truck DSR</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#cost" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"> Project Finance</span></a> </li>
                                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#complete" role="tab">
                                                <span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Complete</span></a> </li>
                                        {{--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#reports" role="tab">--}}
                                                {{--<span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down"> Report</span></a> </li>--}}
                                        {{--@foreach(\App\Stage::all() as $value)--}}
                                            {{--<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#{{ str_slug($value->name) }}" role="tab">--}}
                                                    {{--<span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">{{ ucwords($value->name) }}</span></a> </li>--}}
                                            {{--@endforeach--}}

                                    </ul>
                                    <div class="tab-content tabcontent-border">
                                        <div class="tab-pane active" id="pda" role="tabpanel">
                                            <div class="p-20">
                                                <div class="col-sm-12">
                                                    <h4>Client Documents</h4>
                                                    <div class="col-sm-12">
                                                        @foreach($dms->quote->docs as $doc)
                                                            {{ $loop->iteration }} . <a href="{{ url($doc->doc_path) }}" target="_blank" >{{ $doc->name }}</a>
                                                        @endforeach
                                                    </div>
                                                    <br>
                                                </div>
                                                @if($dms->status == 1)
                                                    {{--<h4>Project is Completed</h4>--}}
                                                @else
                                                <a href="{{ url('quotation/'.$dms->quote_id) }}" target="_blank" class="btn btn-success">Running Quote</a>
                                                <button data-toggle="modal" data-target=".bs-example-modal-lgvessel" class="btn btn-info">
                                                    Upload Client Doc
                                                </button>
                                                @endif
                                                <div class="modal fade bs-example-modal-lgvessel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Upload</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-12">
                                                                    @if($dms->quote->doc_ids != null)
                                                                        <form class="form-material m-t-40" action="{{ url('/vessel/doc/upload/') }}" method="post" enctype="multipart/form-data" id="vessel">
                                                                            <div class="row">
                                                                                {{ csrf_field() }}
                                                                                <input type="hidden" name="vessel_id" value="{{ $dms->quote->id }}">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label for="name">Select Document</label>
                                                                                        <select name="name" id="name" required
                                                                                                class="form-control">
                                                                                            <option value="">Select Docs</option>
                                                                                            @foreach(json_decode($dms->quote->doc_ids) as $doc)
                                                                                                <option value="{{ $doc->name }}">{{ $doc->name }}</option>
                                                                                                @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="doc">Select Doc</label>
                                                                                        <input type="file" required id="doc" name="doc" class="form-control" placeholder="Select Doc">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input class="btn btn-block btn-primary" type="submit" value="Upload">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                        @else
                                                                    <h4>No Required File</h4>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="images" role="tabpanel">
                                            <div class="p-20">
                                                <div class="col-sm-12">
                                                    <h4>Cargo Images</h4>
                                                    <div class="col-sm-12">
                                                        @foreach($dms->images as $image)
                                                            {{ $loop->iteration }} . <a href="{{ url($image->image_path) }}" target="_blank" >{{ $image->image_path }}</a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if($dms->status == 1)
                                                    {{--<h4>Project is Completed</h4>--}}
                                                @else
                                                <button data-toggle="modal" data-target=".bs-example-modal-lgcargo" class="btn btn-info">
                                                    Add Cargo
                                                </button>
                                                @endif
                                                <div class="modal fade bs-example-modal-lgcargo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myLargeModalLabel">Upload Cargo Image</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-12">
                                                                    <form class="form-material m-t-40" action="{{ url('/cargo/image/upload/') }}" method="post" enctype="multipart/form-data" id="cargo_images">
                                                                            <div class="row">
                                                                                {{ csrf_field() }}
                                                                                <input type="hidden" name="bill_of_landing_id" value="{{ $dms->id }}">
                                                                                <div class="col-sm-12">
                                                                                    <div class="form-group">
                                                                                        <label for="images">Select Images</label>
                                                                                        <input type="file" required id="images" name="images" class="form-control" placeholder="Select Images">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input class="btn pull-right btn-primary" type="submit" value="Upload">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="profile" role="tabpanel">
                                            <div class="col-sm-12">
                                                <div class="col-sm-12">
                                                    @if($dms->status == 1)
                                                        {{--<h4>Project is Completed</h4>--}}
                                                    @else
                                                    <div class="row">
                                                        <a href="{{url('/add-transport/'.$dms->id)}}" class="btn btn-primary">Add Transport</a>
                                                    </div>
                                                        @endif
                                                </div>
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th>File Number</th>
                                                            <th>Transporter</th>
                                                            <th>Address</th>
                                                            <th>Contract Type</th>
                                                            <th>Total Buying</th>
                                                            <th>Total Selling</th>
                                                            <th>Total Profit</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            @if($dms->contracts != null)
                                                                <td>{{ ucwords($dms->esl_ref) }}</td>
                                                                <td>{{ ucwords($dms->contracts->company_name) }}</td>
                                                                <td>{{ ucfirst($dms->contracts->address) }}</td>
                                                                <td>{{ $dms->contracts->contract_type == 'open' ||
                                        $dms->contracts->contract_type == 'rates' ? ($dms->contracts->contract_type ==
                                        'open' ? 'Open' : 'Rates') : ($dms->contracts->contract_type == 'per_km' ?
                                         'Per Kilo Meter' : 'Per Tonne') }}</td>

                                                                <td> KES  {{ number_format($dms->transports->sum('buying'))}} </td>
                                                                <td> KES  {{ number_format($dms->transports->sum('cost'))}} </td>
                                                                <td> KES  {{ number_format($dms->transports->sum('cost') - $dms->transports->sum('buying'))}} </td>
                                                            @endif
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                            </div>
                                            {{--<div class="row">--}}
                                                {{--<div class="col-sm-12">--}}
                                                    {{--<br>--}}
                                                    {{--<h4 class="text-center">{{ ucwords( $dms->customer->Name)  }} TRANSPORT / COST - REVENUE RECORD</h4>--}}
                                                    {{--<hr>--}}
                                                    {{--<div class="row">--}}
                                                        {{--<div class="col-sm-12">--}}
                                                            {{--<a href="{{url('/add-transport/'.$dms->id)}}" class="btn btn-primary pull-right">Add Transport</a>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<table class="table table-striped">--}}
                                                    {{--<thead>--}}
                                                    {{--<tr>--}}
                                                        {{--<th>Truck No</th>--}}
                                                        {{--<th>Destination</th>--}}
                                                        {{--<th>FEU</th>--}}
                                                        {{--<th>TEU</th>--}}
                                                        {{--<th>LCL</th>--}}
                                                        {{--<th>Tonnage</th>--}}
                                                        {{--<th>Depart Date/Time</th>--}}
                                                        {{--<th>Arrival Date/Time</th>--}}
                                                        {{--<th>Return Date/Time</th>--}}
                                                        {{--<th>T.around (Days)</th>--}}
                                                        {{--<th>Standard Days</th>--}}
                                                        {{--<th>Variance</th>--}}
                                                    {{--</tr>--}}
                                                    {{--</thead>--}}
                                                    {{--<tbody>--}}
                                                    {{--@foreach($dms->transports as $transport)--}}
                                                        {{--<tr>--}}
                                                            {{--<td>{{ $transport->truck_no }}</td>--}}
                                                            {{--<td>{{ $dms->start }} - {{ $dms->destination }}</td>--}}
                                                            {{--<td>{{ $transport->feu }}</td>--}}
                                                           {{--<td>{{ $transport->teu }}</td>--}}
                                                            {{--<td>{{ $transport->lcl }}</td>--}}
                                                            {{--<td>{{ $transport->tonne }}</td>--}}
                                                            {{--<td>{{ \Carbon\Carbon::parse($transport->depart)->format('d-M-y H:m:s')  }}</td>--}}
                                                            {{--<td>{{ \Carbon\Carbon::parse($transport->arrival)->format('d-M-y H:m:s')  }}</td>--}}
                                                            {{--<td>{{ \Carbon\Carbon::parse($transport->return)->format('d-M-y H:m:s')  }}</td>--}}
{{--                                                            <td>{{ \Carbon\Carbon::parse($transport->depart)->subDays(\Carbon\Carbon::parse($transport->return)->format('d-M-y H:m:s') ) }}</td>--}}
                                                            {{--<td>33</td>--}}
{{--                                                            <td>{{ (\Carbon\Carbon::parse($transport->depart)->subDays(\Carbon\Carbon::parse($transport->return)->format('d-M-y H:m:s'))) }}</td>--}}
                                                        {{--</tr>--}}
                                                    {{--@endforeach--}}
                                                    {{--</tbody>--}}
                                                {{--</table>--}}

                                            {{--</div>--}}
                                        </div>

                                        <div class="tab-pane p-20" id="agency" role="tabpanel">
                                            <h3 class="text-center"></h3>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <a href="{{url('/delivery-order')}}" class="btn btn-primary">Delivery Order</a>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a href="{{url('/report/transport-revenue')}}" class="btn btn-success">Download DSR</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane p-20" id="truck" role="tabpanel">
                                            <h4>Truck</h4>
                                            <div class="row">
                                                <table class="table table-stripped">
                                                    <thead>
                                                    <tr>
                                                        <th>Truck No</th>
                                                        <th>Trail No</th>
                                                        <th>Driver</th>
                                                        <th>Container No</th>
                                                        <th>Cargo Weight</th>
                                                        <th>Position</th>
                                                        <th>Departure Date</th>
                                                        <th>Arrival Date</th>
                                                        <th>Return Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                   @foreach($dms->transports as $transport)
                                                       <tr>
                                                           @foreach(explode("/",$transport->vehicle_no) as $value)
                                                               <td colspan="{{ count(explode("/",$transport->vehicle_no)) < 2 ? '2' : '' }}">{{ strtoupper($value) }}</td>
                                                           @endforeach

                                                           <td>{{$transport->driver}}</td>
                                                           <td>{{$transport->container_no == 0 ? 'LCL' : $transport->container_no}}</td>
                                                           <td>{{$transport->weight}} (KG)</td>
                                                           <td>{{$transport->current_location}}</td>
                                                           <td>{{$transport->departure != null ? \Carbon\Carbon::parse($transport->departure)->format('d-M-y H:m') : ' '}}</td>
                                                           <td>{{$transport->arrival != null ? \Carbon\Carbon::parse($transport->arrival)->format('d-M-y H:m') : ' '}}</td>
                                                           <td>{{$transport->return != null ? \Carbon\Carbon::parse($transport->return)->format('d-M-y H:m') : ' '}}</td>
                                                           <td>
                                                               <button class="btn btn-sm btn-primary" data-toggle="modal" data-target=".bs-example-modal-tedit{{$transport->id}}"><i
                                                                           class="fa fa-pencil"></i></button>

                                                               <div class="modal fade bs-example-modal-tedit{{$transport->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                   <div class="modal-dialog modal-lg">
                                                                       <div class="modal-content">
                                                                           <div class="modal-header">
                                                                               <h4 class="modal-title" id="myLargeModalLabel">Update Truck DSR</h4>
                                                                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                           </div>
                                                                           <div class="modal-body">
                                                                               <div class="col-12">
                                                                                   <form class="form-material m-t-40" id="truckdsr{{$transport->id}}" onsubmit="event.preventDefault(); submitForm(this, '/truck/dsr/');" method="post">
                                                                                       <div class="row">
                                                                                           {{ csrf_field() }}
                                                                                           <input type="hidden" name="truck_id" value="{{ $transport->id }}">
                                                                                           <div class="col-sm-12">
                                                                                               @if($transport->date_loaded == null)
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Date Uploaded</label>
                                                                                                       <input type="text" required id="date_loaded{{$transport->id}}" name="date_loaded" class="form-control datepicker" >
                                                                                                   </div>
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Time Uploaded</label>
                                                                                                       <input id="timepicker1{{$transport->id}}" name="timer" type="text" class="timepicker1 form-control input-small">
                                                                                                   </div>
                                                                                               @endif
                                                                                               @if($transport->date_loaded != null && $transport->departure == null)
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Departure Date</label>
                                                                                                       <input type="text" required id="departure{{$transport->id}}" name="departure" class="form-control datepicker" >
                                                                                                   </div>
                                                                                                       <div class="form-group">
                                                                                                           <label for="images">Time Uploaded</label>
                                                                                                           <input id="timepicker1{{$transport->id}}" name="timer" type="text" class="timepicker1 form-control input-small">
                                                                                                       </div>
                                                                                               @endif
                                                                                               @if($transport->date_loaded != null && $transport->departure != null && $transport->arrival == null)
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Arrival Date</label>
                                                                                                       <input type="text" required id="arrival{{$transport->id}}" name="arrival" class="form-control datepicker">
                                                                                                   </div>
                                                                                                       <div class="form-group">
                                                                                                           <label for="images">Time Uploaded</label>
                                                                                                           <input id="timepicker1{{$transport->id}}" name="timer" type="text" class="timepicker1 form-control input-small">
                                                                                                       </div>
                                                                                                       <div class="form-group">
                                                                                                       <label for="remarks">Remark</label>
                                                                                                       <input type="text" required id="remarks{{$transport->id}}" name="remarks" class="form-control">
                                                                                                   </div>
                                                                                               @endif
                                                                                               @if($transport->date_loaded != null && $transport->departure != null && $transport->arrival
                                                                                               != null && $transport->date_offloaded == null)
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Date Offloaded</label>
                                                                                                       <input type="text" required id="date_offloaded{{$transport->id}}" name="date_offloaded" class="form-control datepicker">
                                                                                                   </div>
                                                                                                       <div class="form-group">
                                                                                                           <label for="images">Time Uploaded</label>
                                                                                                           <input id="timepicker1{{$transport->id}}" name="timer" type="text" class="timepicker1 form-control input-small">
                                                                                                       </div>
                                                                                               @endif

                                                                                               @if($transport->date_loaded != null && $transport->departure != null && $transport->arrival
                                                                                               != null && $transport->date_offloaded != null && $transport->return == null)
                                                                                                   <div class="form-group">
                                                                                                       <label for="images">Return Date</label>
                                                                                                       <input type="text" required id="return{{$transport->id}}" name="return" class="form-control datepicker">
                                                                                                   </div>
                                                                                                       <div class="form-group">
                                                                                                           <label for="images">Time Uploaded</label>
                                                                                                           <input id="timepicker1{{$transport->id}}" name="timer" type="text" class="timepicker1 form-control input-small">
                                                                                                       </div>
                                                                                               @endif
                                                                                               <div class="form-group">
                                                                                                   <input class="btn pull-right btn-primary" type="submit" value="Update">
                                                                                               </div>
                                                                                           </div>
                                                                                       </div>
                                                                                   </form>
                                                                               </div>
                                                                           </div>
                                                                           <div class="modal-footer">
                                                                               <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>

                                                               <button class="btn btn-sm btn-success"  data-toggle="modal" data-target=".bs-example-modal-locit{{$transport->id}}"><i
                                                                           class="fa fa-map"></i></button>

                                                               <div class="modal fade bs-example-modal-locit{{$transport->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                                   <div class="modal-dialog modal-lg">
                                                                       <div class="modal-content">
                                                                           <div class="modal-header">
                                                                               <h4 class="modal-title" id="myLargeModalLabel">Truck DSR Current Position</h4>
                                                                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                           </div>
                                                                           <div class="modal-body">
                                                                               <div class="col-12">
                                                                                   <form class="form-material m-t-40" id="locit{{$transport->id}}" onsubmit="event.preventDefault(); submitForm(this, '/truck/dsr/');" method="post">
                                                                                       <div class="row">
                                                                                           {{ csrf_field() }}
                                                                                           <input type="hidden" name="truck_id" value="{{ $transport->id }}">
                                                                                           <div class="col-sm-12">
                                                                                                   <div class="form-group">
                                                                                                       <label for="current_location">Current Position</label>
                                                                                                       <input type="text" required id="current_location{{$transport->id}}" name="current_location" class="form-control" >
                                                                                                   </div>
                                                                                               <div class="form-group">
                                                                                                   <input class="btn pull-right btn-primary" type="submit" value="Update Location">
                                                                                               </div>
                                                                                           </div>
                                                                                       </div>
                                                                                   </form>
                                                                               </div>
                                                                           </div>
                                                                           <div class="modal-footer">
                                                                               <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>

                                                           </td>
                                                       </tr>
                                                       @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
{{--                                        @foreach($stages as $stage)--}}
                                            <div class="tab-pane p-20" id="checklist1" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h4>Details <strong class="pull-right">Date started : {{ \Carbon\Carbon::parse($dms->created_at)->format('d-M-y') }}</strong></h4>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <table class="table table-stripped">
                                                            <tbody>
                                                            <tr>
                                                                <td><strong>ESL REF : </strong> {{ strtoupper($dms->esl_ref) }}</td>
                                                                <td><strong>Client REF : </strong> {{ strtoupper($dms->ctm_ref) }}</td>
                                                                <td><strong>BL NO : </strong> {{ strtoupper($dms->quote->cargo->bl_number) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Cargo Weight : </strong> {{ strtoupper($dms->quote->cargo->cargo_weight) }}</td>
                                                                <td><strong>Shipper : </strong> {{ strtoupper($dms->shipper) }}</td>
                                                                <td><strong>Shipping Lines : </strong> {{ strtoupper($dms->shipping_line)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Distance : </strong> {{ strtoupper($dms->quote->cargo->distance) }}</td>
                                                                <td><strong>Pick up Point : </strong> {{ strtoupper($dms->quote->cargo->start) }}</td>
                                                                <td><strong>Destination : </strong> {{ strtoupper($dms->quote->cargo->destination)}}</td>
                                                            </tr><tr>
                                                                <td colspan="3"><strong>Description : </strong> {{ strtoupper($dms->quote->cargo->desc)}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @foreach($checklist as $key => $values)
                                                    <h3>{{ ucwords($key) }}</h3>
                                                    <table class="table table-responsive table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th><b>Checklist</b></th>
                                                            <th><b>Type</b></th>
                                                            <th><b>Data</b></th>
                                                            <th><b>Notification</b></th>
                                                            <th><b>Timing</b></th>
                                                            <th><b>Time Taken</b></th>
                                                            <th><b>Sub checklist</b></th>
                                                            <th class="text-right"><b>Date Added</b></th>
                                                        </tr>
                                                        </thead>
                                                    @foreach($values as $inn)

                                                                <tbody>
                                                                <tr>
                                                                    <th>{{ ucwords($inn[$key]['name'] )}}</th>
                                                                    <th>{{ ucwords($inn[$key]['type']) }}</th>
                                                                    @if($inn[$key]['type'] == 'text' || $inn[$key]['type'] == 'checkbox')
                                                                        <th>{!!  $inn[$key]['type'] == 'text' || $inn[$key]['type'] == 'checkbox' ? ucfirst($inn[$key]['text'])  : implode("<br>",$inn[$key]['doc_links'])  !!}</th>
                                                                    @else
                                                                        <th>
                                                                            @foreach($inn[$key]['doc_links'] as $link)
                                                                                <a href="{{ url($link) }}" target="_blank">{{$link}} <br></a>
                                                                            @endforeach
                                                                        </th>
                                                                    @endif
                                                                    <th>{!! $inn[$key]['notification'] ? '<i class="fa fa-bell"></i>' : '<i class="fa fa-bell-slash"></i>'  !!}</th>
                                                                    <th>{!! $inn[$key]['timing']   !!} Mins</th>
                                                                    <th>{{ \Carbon\Carbon::parse($dms->created_at)->diffInMinutes(\Carbon\Carbon::parse( $inn[$key]['created_at'])) }} Mins</th>
                                                                    <th>{{ $inn[$key]['subchecklist'] != null ? implode(',',json_decode($inn[$key]['subchecklist'])) : ''}}</th>
                                                                    <th class="text-right">{{ \Carbon\Carbon::parse( $inn[$key]['created_at'])->format('d-M-y') }}</th>
                                                                </tr>
                                                                </tbody>

                                                @endforeach
                                                    </table>
                                                @endforeach
                                            </div>
                                        {{--@endforeach--}}
                                        <div class="tab-pane  p-20" id="delivery" role="tabpanel">
                                            <div class="col-sm-12">
                                                <table class="table table-stripped">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Mode</th>
                                                        <th>Document</th>
                                                        <th>Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($dms->deliverynotes as $deliverynote)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{ $deliverynote->driver }}</td>
                                                            <td>{{ $deliverynote->vehicle }}</td>
                                                            <td><a href="{{ url($deliverynote->doc_path)}}">{{ $deliverynote->doc_path }}</a></td>
                                                            <td>{{ \Carbon\Carbon::parse($deliverynote->created_at)->format('d-M-y') }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($dms->status == 1)
                                                {{--<h4>Project is Completed</h4>--}}
                                            @else
                                            <button data-toggle="modal" data-target=".bs-example-modal-lgdoc" class="btn btn-info">
                                                Upload Delivery Note
                                            </button>
                                            @endif
                                            <div class="modal fade bs-example-modal-lgdoc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Upload Delivery Note</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col-12">
                                                                    <form class="form-material m-t-40" action="{{ url('/delivery/note/upload/') }}" method="post" enctype="multipart/form-data" id="vessel">
                                                                        <div class="row">
                                                                            {{ csrf_field() }}
                                                                            <input type="hidden" name="bol_id" value="{{ $dms->id }}">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label for="driver">Name</label>
                                                                                    <input type="text" required id="driver" name="driver" class="form-control" placeholder="Driver Name">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="vehicle">Mode of Deliver</label>
                                                                                    <input type="text" required id="vehicle" name="vehicle" class="form-control" placeholder="Vehicle">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="doc">Select Doc</label>
                                                                                    <input type="file" required id="doc" name="doc" class="form-control" placeholder="Select Doc">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <input class="btn btn-block btn-primary" type="submit" value="Upload">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($dms->deliverynotes == null)
                                                <h4>No Delivery Note</h4>
                                            @endif
                                        </div>
                                        <div class="tab-pane  p-20" id="cost" role="tabpanel">
                                            <div class="card card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button data-toggle="modal" data-target=".bs-example-modal-reqfund" class="btn btn-info">
                                                            Request Fund
                                                        </button>

                                                        <button data-toggle="modal" data-target=".bs-example-modal-servicecost" class="btn btn-info">
                                                            Add Project Service Cost
                                                        </button>

                                                        <button data-toggle="modal" data-target=".bs-example-modal-allreqfund" class="btn btn-success">
                                                            View Requested Fund
                                                        </button>

                                                        <button data-toggle="modal" data-target=".bs-example-modal-statement" class="btn btn-success">
                                                            Project Statement
                                                        </button>
                                                        <a href="{{ url('generate-po/'.$dms->quote->id) }}" class="btn btn-info btn-sm pull-right">
                                                            Generate Purchase Order
                                                        </a>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-servicecost" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Add Service Cost</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-12">
                                                                        <form action="{{ url('service-cost') }}" method="post" enctype="multipart/form-data" id="vessel">
                                                                            <div class="row">
                                                                                {{ csrf_field() }}
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="quotation_id" VALUE="{{ $dms->quote->id }}">

                                                                                    <div class="form-group">
                                                                                        <label for="service_id">Select Service</label>
                                                                                        <select name="service_id" id="service_id"
                                                                                                class="form-control" required>
                                                                                            <option value="">Select Service</option>
                                                                                            @foreach($dms->quote->services as $service)
                                                                                                @if($service->buying_price == null || $service->buying_price == 0)
                                                                                                    <option value="{{$service->id}}">{{ ucwords($service->name) }} ~ SP : {{ number_format($service->selling_price,2) }}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="buying_price">Service Buying Amount</label>
                                                                                        <input type="number" max="{{ $service->selling_price }}" required id="buying_price" name="buying_price" class="form-control" placeholder="Service Buying Amount">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="description">Description</label>
                                                                                        <input type="text" required id="description" name="description" class="form-control" placeholder="Description">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="doc_path">Select Supporting Doc</label>
                                                                                        <input type="file" required id="doc_path" name="doc_path" class="form-control" placeholder="Select Supporting Doc">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input class="btn btn-block btn-primary" type="submit" value="Add">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-reqfund" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Request Fund</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-12">
                                                                        <form action="{{ route('project-cost.store') }}" method="post" enctype="multipart/form-data" id="vessel">
                                                                            <div class="row">
                                                                                {{ csrf_field() }}
                                                                                <div class="col-sm-12">
                                                                                    <input type="hidden" name="quotation_id" VALUE="{{ $dms->quote->id }}">
                                                                                    <input type="hidden" name="user_id" VALUE="{{ \Illuminate\Support\Facades\Auth::id() }}">
                                                                                    <div class="form-group">
                                                                                        <label for="employee_number">Employee Number/ID</label>
                                                                                        <input type="text" required id="employee_number" name="employee_number" class="form-control" placeholder="Employee Number/ID">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="amount">Amount Requested</label>
                                                                                        <input type="number" required id="amount" name="amount" class="form-control" placeholder="Amount Requested">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="deadline">Deadline</label>
                                                                                        <input type="text" required id="deadline" name="deadline" class="form-control datepicker" placeholder="Deadline">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="reason">Reason</label>
                                                                                        <textarea name="reason" id="reason"
                                                                                                  cols="30" rows="3"
                                                                                                  class="form-control"></textarea>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="file_path">Select Supporting Doc</label>
                                                                                        <input type="file" id="file_path" name="file_path" class="form-control" placeholder="Select Supporting Doc">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <input class="btn btn-block btn-primary" type="submit" value="Send Request">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-allreqfund" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">All Requested Fund</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <table class="table table-stripped">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Employee</th>
                                                                                        <th>Em NO/ID</th>
                                                                                        <th>Deadline</th>
                                                                                        <th>Reason</th>
                                                                                        <th>S/File</th>
                                                                                        <th>Status</th>
                                                                                        <th>Amount</th>
                                                                                        <th>Action</th>
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($dms->quote->pettyCash as $cash)
                                                                                        @if(\Illuminate\Support\Facades\Auth::id() == $cash->user_id)
                                                                                            <tr>
                                                                                                <td>{{ ucwords($cash->user->name) }}</td>
                                                                                                <td>{{ $cash->employee_number }}</td>
                                                                                                <td>{{ \Carbon\Carbon::parse($cash->deadline)->format('d-M-y') }}</td>
                                                                                                <td>{{ $cash->reason }}</td>
                                                                                                <td><a target="_blank" href="{{ asset($cash->file_path) }}">{{ $cash->file_path == ' ' ? '' : 'File' }}</a></td>
                                                                                                <td>{{ $cash->status == 0 ? 'Not Approved' : 'Approved' }}</td>
                                                                                                <td>{{ number_format($cash->amount, 2) }}</td>
                                                                                                <td>
                                                                                                    @if($cash->status == 0)
                                                                                                        <a href="{{ url('/approve-project-cost-request/'.$cash->id) }}"
                                                                                                           class="btn btn-xs btn-primary">approve</a>
                                                                                                    @endif
                                                                                                </td>
                                                                                            </tr>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                    <tr>
                                                                                        <th colspan="6">Total</th>
                                                                                        <th>{{ number_format($dms->quote->pettyCash->sum('amount'), 2) }}</th>
                                                                                    </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bs-example-modal-statement" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Project Statement</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <table class="table table-stripped">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th>Service Name</th>
                                                                                        <th>Receipt</th>
                                                                                        <th>Selling Price</th>
                                                                                        <th>Cost</th>
                                                                                        <th>Profit</th>
                                                                                        {{--<th>Action</th>--}}
                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    @foreach($dms->quote->services as $service)
                                                                                        <tr>
                                                                                            <td>{{ ucwords($service->name) }}</td>
                                                                                            <td><a target="_blank" href="{{ url(asset($service->doc_path == null ? '' : $service->doc_path)) }}">{{ $service->doc_path == null ? '' : 'Download'}}</a></td>
                                                                                            <td>{{ number_format($service->selling_price,2)}}</td>
                                                                                            <td>{{ $service->buying_price == null ? 'Add Service Cost' : number_format($service->buying_price,2) }}</td>
                                                                                            <td>{{ $service->buying_price == null ? 'Add Service Cost' : number_format(($service->selling_price - $service->buying_price),2) }}</td>
                                                                                            {{--<td>--}}
                                                                                            {{--<button data-toggle="modal" data-target=".bs-example-modal-servicecost" class="btn btn-xs btn-success" data-dismiss="modal">--}}
                                                                                            {{--<i class="fa fa-pencil"></i>--}}
                                                                                            {{--</button>--}}
                                                                                            {{--</td>--}}
                                                                                        </tr>
                                                                                    @endforeach
                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                    <tr>
                                                                                        <th colspan="2">Total</th>
                                                                                        <th>{{ number_format($dms->quote->services->sum('selling_price'), 2) }}</th>
                                                                                        <th>{{ number_format($dms->quote->services->sum('buying_price'), 2) }}</th>
                                                                                        <th>{{ number_format(($dms->quote->services->sum('selling_price') - $dms->quote->services->sum('buying_price')), 2) }}</th>
                                                                                    </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button data-toggle="modal" data-target=".bs-example-modal-servicecost" class="btn btn-info" data-dismiss="modal">
                                                                        Add Project Service Cost
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <hr>
                                                        <h2>Purchase Orders</h2>
                                                        <table class="table table-stripped">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Supplier</th>
                                                                <th>Created By</th>
                                                                <th>Status</th>
                                                                <th>PO Date</th>
                                                                {{--@can('managerd')--}}
                                                                <th class="text-right">Action</th>
                                                                {{--@endcan--}}
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($dms->quote->purchaseOrder as $po)
                                                                <tr>
                                                                    <td>{{ strtoupper($po->po_no) }}</td>
                                                                    <td>{{ ucwords($po->supplier->Name) }}</td>
                                                                    <td>{{ ucwords($po->user->name) }}</td>
                                                                    <td><button class="btn btn-xs btn-{{ $po->status == \Esl\helpers\Constants::PO_REQUEST ? 'primary' : ($po->status == \Esl\helpers\Constants::PO_APPROVED ? 'success' : 'danger') }}">{{ ucwords($po->status) }}</button></td>
                                                                    <td>{{ \Carbon\Carbon::parse($po->po_date)->format('d-M-y') }}</td>
                                                                    <td class="text-right"><a href="{{ url('/view-po/'. $po->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="complete" role="tabpanel">
                                            <div class="card card-body">
                                                <div class="pull-right">
                                                    @if($dms->status == 1)
                                                        <h4>Project is Completed</h4>
                                                    @else
                                                    <div class="col-sm-4 pull-right">
                                                        <a href="{{ url('/complete-ctm/'.$dms->id) }}" class="btn btn-danger">Are You Sure?</a>
                                                    </div>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane  p-20" id="reports" role="tabpanel">
                                            <h4>TODO:: ask for report format</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--@foreach($stages as $stage)--}}
{{--                                @if(strtoupper($dms->quote->type) == strtoupper($stage->type))--}}
                                {{--<div class="card">--}}
                                    {{--<div class="card-body">--}}
                                        {{--<h4 class="card-title">{{ ucwords($stage->name) }}</h4>--}}
                                        {{--<form action="{{ url('/dms/store/') }}" method="post" enctype="multipart/form-data">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<table class="table table-stripped">--}}
                                                {{--<tbody>--}}
                                                {{--@foreach($stage->components as $component)--}}
                                                    {{--<tr>--}}
                                                        {{--<div class="row">--}}
                                                            {{--<div class="col-sm-2">--}}
                                                                {{--{{ ucfirst($component->name) }}--}}
                                                            {{--</div>--}}
                                                            {{--<div class="col-sm-1">--}}
                                                                {{--{!! $component->notification == true ? '<i class="fa fa-bell"></i>' : '<i class="fa fa-bell-slash"></i>' !!}--}}
                                                            {{--</div>--}}
                                                            {{--<div class="col-sm-2">--}}
                                                                {{--Time allowed {{ $component->timing }} Mins--}}
                                                            {{--</div>--}}
                                                            {{--<input type="hidden" name="stage_component_id[]" value="{{$component->id}}">--}}
                                                            {{--<input type="hidden" name="dms_id" value="{{$dms->id}}">--}}
                                                            {{--<div class="col-sm-2 form-group">--}}
                                                                {{--<input name="{{  $component->type == 'file' ? 'doc_links' : 'text_value'}}[{{$component->id}}][]" placeholder="{{ucfirst($component->name)}}" class="form-control" {{ $component->required == true ? 'required' : '' }} type="{{ $component->type == 'file' ? 'file' : 'text' }}" multiple {{ $component->type == 'file' ? 'multiple' : '' }} >--}}
                                                            {{--</div>--}}
                                                            {{--@if($component->components != null )--}}
                                                                {{--<div class="col-sm-2">--}}
                                                                    {{--<i class="btn btn-success model_img img-responsive fa fa-check" data-toggle="modal" data-target="#responsive-modal{{$component->id}}">Sub checklist</i>--}}
                                                                    {{--<!-- sample modal content -->--}}
                                                                    {{--<div id="responsive-modal{{$component->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">--}}
                                                                        {{--<div class="modal-dialog">--}}
                                                                            {{--<div class="modal-content">--}}
                                                                                {{--<div class="modal-header">--}}
                                                                                    {{--<h4 class="modal-title">{{ ucwords($stage->name)  }} Sub checklist</h4>--}}
                                                                                    {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
                                                                                {{--</div>--}}
                                                                                {{--<div class="modal-body">--}}
                                                                                    {{--<div class="col-sm-12">--}}
                                                                                        {{--<ul class="icheck-list">--}}
                                                                                            {{--@foreach(json_decode($component->components) as $item)--}}
                                                                                                {{--<div class="form-group">--}}
                                                                                                    {{--<input type="checkbox" name="checklist[{{$component->id}}][{{$item}}][]" class="check" id="{{$item}}">--}}
                                                                                                    {{--<label for="{{$item}}">{{ $item }}</label>--}}
                                                                                                {{--</div>--}}
                                                                                            {{--@endforeach--}}
                                                                                        {{--</ul>--}}
                                                                                    {{--</div>--}}
                                                                                  {{--</div>--}}
                                                                                {{--<div class="modal-footer">--}}
                                                                                    {{--<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>--}}
                                                                                {{--</div>--}}
                                                                            {{--</div>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--@endif--}}
                                                            {{--<div class="col-sm-3 form-group">--}}
                                                                {{--<input name="remark[{{$component->id}}][]" placeholder="Remarks" class="form-control" type="text" >--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</tr>--}}
                                                {{--@endforeach--}}
                                                {{--</tbody>--}}
                                            {{--</table>--}}
                                            {{--<button class="btn btn-primary pull-right">Save</button>--}}
                                        {{--</form>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                    {{--@endif--}}
                            {{--@endforeach--}}
                                @endif
                                {{--<div class="card">--}}
                                    {{--<div class="card-body">--}}
                                        {{--<form id="pda_remarks_form" action="{{ url('/ctm-remarks') }}" method="post">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--<div class="form-group">--}}
                                                {{--<label for="remarks">Remarks</label>--}}
                                                {{--<textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control"></textarea>--}}
                                            {{--</div>--}}
                                            {{--<input type="hidden" name="ctm_id" id="ctm_id" value="{{ $dms->id }}">--}}
                                            {{--<button type="submit" class="btn btn-primary pull-right">--}}
                                                {{--Submit--}}
                                            {{--</button>--}}
                                        {{--</form>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
            $('.timepicker1').timepicker();
        function addSof(form, formUrl){

            var formId = form.id;

            var vessel = $('#'+formId);

            console.log(vessel);

            var data = vessel.serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            console.log(data);
            axios.post(formUrl, data)
                .then(function (response) {
                    var details = response.data.success;

                    $('#sof_list').append(details);
                    $('#modal').modal('hide');

                })
                .catch(function (response) {
                    console.log(response.data);
                });

        }
    </script>
@endsection
