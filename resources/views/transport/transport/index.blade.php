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
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Quotations </h4>
                    </div>
                    <div class="comment-widgets m-b-20">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Contact Person</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Created On</th>
                                            <th class="text-nowrap">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="customers">
                                        @foreach($quotations as $quotation)
                                            @if($quotation->status == 'converted' || $quotation->status == 'requested'  )
                                                <tr>
                                                    <td>{{ ucwords($quotation->customer->Name) }}</td>
                                                    <td>{{ ucfirst($quotation->customer->Contact_Person) }}</td>
                                                    <td>{{ $quotation->customer->Telephone }}</td>
                                                    <td>{{ ucwords($quotation->status)}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($quotation->created_at)->format('d-M-y') }}</td>
                                                    <td class="text-nowrap">
                                                        <a href=" {{ url('quotation/view/'. $quotation->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="footable pagination">
                                        {{ $quotations->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notification</h4>
                        <ul class="feeds">
                            @foreach($v_notifications as $notification)
                                <li>
                                    <div class="bg-light-info"><i class="fa fa-bell-o"></i></div>{{ ucfirst($notification->title) }}.
                                    <a href="{{ url('/notifications/'.$notification->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a> <span class="text-muted"></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
