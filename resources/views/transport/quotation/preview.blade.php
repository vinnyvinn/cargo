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
                <h3 class="text-center">Proposal</h3>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <address>
                                <img src="{{ asset('images/logo.png') }}" alt="">
                                <h4>Express Shipping & Logistics (EA) Limited</h4>
                                <h4>Cannon Towers <br>
                                    6th Floor, Moi Avenue Mombasa - Kenya <br>
                                    Email :agency@esl-eastafrica.com or ops@esl-eastafrica.com <br>
                                    Web: www.esl-eastafrica.com</h4>
                            </address>
                        </div>
                        <div class="pull-right">
                            <address id="client_details">
                                <h4><b>To</b></h4>
                                <h4>Name : {{ ucwords($quotation->customer->Name) }} </h4>
                                <h4>Contact Person : {{ mb_strimwidth(ucwords($quotation->customer->Contact_Person),0,16,"...") }} </h4>
                                <h4>Phone : {{ $quotation->customer->Telephone }} </h4>
                                <h4>Email :  {{ $quotation->customer->EMail }}</h4>
                                <br>
                                <p><b>Date : </b> {{ \Carbon\Carbon::parse($quotation->created_at)->format('d-M-y') }}</p>
                            </address>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-responsive table-hover">
                                        <thead>
                                        <tr>
                                            <th>DESCRIPTION</th>
                                            <th class="text-right">QUANTITY</th>
                                            <th class="text-right">UNIT PRICE</th>
                                            <th class="text-right">TAX</th>
                                            <th class="text-right">TOTAL AMOUNT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($quotation->services as $service)
                                            <tr id="{{$service->id}}">
                                                <td> {{ ucwords($service->name) }} </td>
                                                <td class="text-right">{{$service->total_units}} {{$service->unit}}</td>
                                                <td class="text-right">{{ number_format($service->rate) }}</td>
                                                <td class="text-right">{{ number_format($service->tax) }}</td>
                                                <td class="text-right">{{ number_format($service->total) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right m-t-30 text-right">
                            <div class="col-sm-12">
                                <h3 id="total_amount"><b>Total USD :</b> {{ number_format($quotation->services->sum('total')) }}</h3>
                            </div>
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Required Documents</h4>
                    </div>
                    <div class="col-sm-12">
                        <table class="table table-strpped">
                            <tr>
                                <th>Document Name</th>
                                <th>Description</th>
                                {{--<th class="text-right">Action</th>--}}
                            </tr>
                            <tbody>
                            @if($quotation->doc_ids != null)
                            @foreach(json_decode($quotation->doc_ids) as $docs)
                                <tr>
                                    <td>{{ ucwords($docs->name) }}</td>
                                    <td>{{ ucfirst($docs->description) }}</td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
