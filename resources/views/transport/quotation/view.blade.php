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
                                    <h4>Currency :  {{ $quotation->customer->iCurrencyID == 1 ? 'USD' : 'KES'}}</h4>
                                    <br>
                                    <p><b>Date : </b> {{ \Carbon\Carbon::parse($quotation->created_at)->format('d-M-y') }}</p>
                                </address>
                            </div>
                        </div>
                        <hr>

                        <div class="col-md-12">
                            <div class="table-responsive" style="clear: both;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-striped table-responsive table-hover">
                                            <thead>
                                            <tr>
                                                <th>DESCRIPTION</th>
                                                <th class="text-right">QUANTITY</th>
                                                <th class="text-right">UNIT PRICE</th>
                                                <th class="text-right">TOTAL AMOUNT</th>
                                                {{--<th class="text-right">Action</th>--}}
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($quotation->services as $service)
                                                <tr id="{{$service->id}}">
                                                    <td> {{ ucwords($service->name) }} </td>
                                                    <td class="text-right">{{$service->total_units}} {{$service->unit}}</td>
                                                    <td class="text-right">{{ number_format($service->selling_price) }}</td>
                                                    <td class="text-right">{{ number_format($service->total) }}</td>
                                                    {{--<td class="text-right">--}}
                                                        {{--<button data-toggle="modal" data-target=".bs-example-modal-lg{{$service->id}}" class="btn btn-xs btn-primary">--}}
                                                            {{--<i class="fa fa-pencil"></i>--}}
                                                        {{--</button>--}}
                                                        {{--<div class="modal fade bs-example-modal-lg{{$service->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">--}}
                                                            {{--<div class="modal-dialog modal-lg">--}}
                                                                {{--<div class="modal-content">--}}
                                                                    {{--<div class="modal-header">--}}
                                                                        {{--<h4 class="modal-title" id="myLargeModalLabel">Edit Service</h4>--}}
                                                                        {{--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
                                                                    {{--</div>--}}
                                                                    {{--<div class="modal-body">--}}
                                                                        {{--<div class="col-12">--}}
                                                                            {{--<form style="text-align: left !important;" id="update_service{{$service->id}}" onsubmit="event.preventDefault(); submitForm(this, '/update-service');" action="" method="post">--}}
                                                                                {{--{{ csrf_field() }}--}}
                                                                                {{--<div class="row">--}}
                                                                                    {{--<div class="col-sm-12">--}}
                                                                                        {{--<div class="form-group">--}}
                                                                                            {{--<label for="name text-left">Description</label>--}}
                                                                                            {{--<input type="text" value="{{ ucwords($service->name) }}" readonly required id="name" name="name" class="form-control" placeholder="Description">--}}
                                                                                        {{--</div>--}}
                                                                                        {{--<div class="form-group">--}}
                                                                                            {{--<label for="total_units">Quantity</label>--}}
                                                                                            {{--<input type="text" required id="{{$service->id}}" onkeyup="updateServiceTotal(this,'{{$service->rate}}')" value="{{ $service->total_units  }}" name="total_units" class="form-control" placeholder="Quantity">--}}
                                                                                        {{--</div>--}}
                                                                                        {{--<input type="hidden" name="service_id" value="{{ $service->id }}">--}}
                                                                                        {{--<div class="form-group">--}}
                                                                                            {{--<label for="rate">Unit Price </label>--}}
                                                                                            {{--<input type="text" required id="rate" value="{{ $service->rate }}" name="rate" readonly class="form-control" placeholder="Unit Price">--}}
                                                                                        {{--</div>--}}
                                                                                        {{--<div class="form-group">--}}
                                                                                            {{--<label for="total">Total </label>--}}
                                                                                            {{--<input type="text" required id="service_total{{$service->id}}" readonly  name="total" value="{{ $service->total }}" class="form-control" placeholder="Total">--}}
                                                                                        {{--</div>--}}
                                                                                        {{--<div class="form-group">--}}
                                                                                            {{--<br>--}}
                                                                                            {{--<input class="btn btn-block btn-primary" type="submit" value="Update">--}}
                                                                                        {{--</div>--}}
                                                                                    {{--</div>--}}
                                                                                {{--</div>--}}
                                                                            {{--</form>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<div class="modal-footer">--}}
                                                                        {{--<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<button onclick="deleteService({{ $service->id }})" class="btn btn-xs btn-danger">--}}
                                                            {{--<i class="fa fa-trash"></i>--}}
                                                        {{--</button>--}}
                                                    {{--</td>--}}
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
                                    <h3 id="total_amount"><b>Total {{ $quotation->inputCur }} :</b> {{ number_format($quotation->services->sum('total')) }}</h3>
                                </div>
                            </div>
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
                                    <th class="text-right">Action</th>
                                </tr>
                                <tbody>
                                @if($quotation->doc_ids != null)
                                    @foreach(json_decode($quotation->doc_ids) as $docs)
                                        <tr>
                                            <td>{{ ucwords($docs->name) }}</td>
                                            <td>{{ ucfirst($docs->description) }}</td>
                                            <td class="text-right"><button onclick="deleteDocs('{{ $docs->doc_id }}','{{ $quotation->id }}')" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="col-sm-12">
                                <h3>Remarks</h3>
                                <hr>
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Remarks</th>
                                        <th class="text-right">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($quotation->remarks->sortByDesc('created_at') as $remark)
                                        <tr>
                                            <td>{{ ucwords($remark->user->name) }}</td>
                                            <td>{{ ucfirst($remark->remark) }}</td>
                                            <td class="text-right">{{ \Carbon\Carbon::parse($remark->created_at)->format('d-M-y') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                <form id="pda_remarks_form" action="" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="remarks">Remarks</label>
                                        <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control"></textarea>
                                    </div>
                                    <input type="hidden" name="quotation_id" id="quotation_id" value="{{ $quotation->id }}">
                                </form>
                                <div class="text-right">
                                    <a href="{{ url('/quotation/preview/'.$quotation->id) }}" class="btn btn btn-outline-success">Preview</a>
                                    @if($quotation->status == \Esl\helpers\Constants::LEAD_QUOTATION_REQUEST)
                                        <button  class="btn btn-danger" onclick="event.preventDefault(); disapprove()"> DISAPPROVE </button>
                                        <button class="btn btn-primary" onclick="event.preventDefault(); approve()"> APPROVE </button>
                                    @endif
                                    @if($quotation->status == \Esl\helpers\Constants::LEAD_QUOTATION_APPROVED)
                                        <a href="{{ url('/quotation/download/'.$quotation->id) }}" class="btn btn">Download</a>
@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var search_item = $('#customer');
        var display_search = $('#display');
        var data = {
            'quotation_id':'{{ $quotation->id }}',
            'services':{},
            'required_docs' : {}
        }

        search_item.on('keyup', function () {

            if(search_item.val() == "") {
                display_search.html("")
            }
            else {
                axios.post('/search-customer', {'search_item' : search_item.val()})
                    .then( function (response) {
                        display_search.empty().append(response.data.output);
                    })
                    .catch( function (response) {
                        console.log(response.data);
                    });
            }
        });

        function addService() {
            var selected = document.getElementById("service")
            var getSelectedService = JSON.parse(selected.options[selected.selectedIndex].value);
            var service_units = $('#service_units').val();

            if(service_units === "" || service_units === null){
                alert('Enter value');
            }
            else {
                addServiceToData({
                    'id':((Object.keys(this.data.services).length) + 1),
                    'service_id':getSelectedService.id,
                    'rate':getSelectedService.rate,
                    'type':getSelectedService.type,
                    'unit':getSelectedService.unit,
                    'total_units':service_units,
                    'name':getSelectedService.name,
                    'total':(getSelectedService.rate * service_units)
                })
            };
        }

        function addDocs() {
            var requiredDoc = document.getElementById("required_docs");
            var selectedDoc = JSON.parse(requiredDoc.options[requiredDoc.selectedIndex].value);
            addDocToData({
                'id':Object.keys(this.data.required_docs).length + 1,
                'doc_id': selectedDoc.id,
                'name' : selectedDoc.name,
                'description': selectedDoc.description
            });

        }

        function addDocToData(doc) {
            $('#doc_table').append('<tr id="' + doc.id + '">' +
                '<td>' + doc.name + '</td>' +
                '<td>' + doc.description+ '</td>' +
                '<td class="text-right"><button onclick="deleteDoc(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
            this.data.required_docs[doc.id] = doc;
        }

        function deleteDoc(doc) {
            var getDoc = doc.parentNode.parentNode;
            getDoc.parentNode.removeChild(getDoc);
            delete this.data.required_docs[getDoc.id];
        }

        function deleteDocs(doc_id, quotation_id) {
            axios.post('{{ url('/delete-doc') }}', {
                'doc_id' : doc_id,
                'quotation_id' : quotation_id,
                '_token' : '{{ csrf_token() }}'
            }).then(function (response) {
                window.location.reload();
            })
                .catch(function (response) {
                    console.log(response);
                });
        }

        var form = $('#pda_remarks_form');

        function approve() {
            var formData = form.serializeArray().reduce(function (obj, item){
                obj[item.name] = item.value;
                return obj;
            }, {});

            submitData(formData,'/agency/approve')
        }

        function disapprove() {
            var formData = form.serializeArray().reduce(function (obj, item){
                obj[item.name] = item.value;
                return obj;
            }, {});

            submitData(formData,'/agency/disapprove')
        }

        function submitData(data, formUrl) {
            axios.post('{{ url('/') }}' + formUrl, data)
                .then(function (response) {
                    console.log(response.data)
                    window.location.reload();
                })
                .catch(function (response) {
                    console.log(response.data);
                });
        }

        function updateServiceTotal(service, rate) {

            if(service.value !== ""){
                $('#service_total'+service.id).val((service.value * rate));
            }
        }

        function storeServiceData() {
//            if (Object.keys(this.data.services).length > 0 && this.data.DCLink !== ''){
            axios.post('{{url('/add-services')}}', this.data)
                .then( function (response) {
                    window.location.href = '{{ url('/quotation/view') }}/' + response.data.quotation_id;
                })
                .catch( function (response) {
                    console.log(response.data);
                });
//            }
//            else {
//                var errorMsg = '';
//                if (Object.keys(this.data.services).length < 1){
//                    errorMsg = errorMsg + '1. No service added \n';
//                }
//                alert(errorMsg);
//            }
        }

        function deleteService(id) {
            axios.post('{{ url('/quotation-service-delete') }}', {
                'service_id' : id,
                '_token' : '{{ csrf_token() }}'
            }).then(function (response) {
                window.location.reload();
            })
                .catch(function (response) {
                    console.log(response);
                });
        }

        function deleteSerive(service) {
            service_id = service.parentNode.parentNode;

            delete this.data.services[service_id.id];
            service_id.parentNode.removeChild(service_id);
            $('#total_amount').empty().append('<b>Total USD :</b>' + getTotal())

        }

        function getTotal() {
            if (Object.keys(this.data.services).length > 0){
                return Object.values(this.data.services).reduce(function (a,b) {
                    return a + b.total;
                },0);
            }
            else{
                return 0;
            }
        }

        function addServiceToData(service) {
            $('#service_table').append('<tr id="' + service.id + '">' +
                '<td>' + service.name + '</td>' +
                '<td class="text-right">' + Number(service.total_units).toFixed(2) + '</td>' +
                '<td class="text-right">' + Number(service.rate).toFixed(2) + '</td>' +
                '<td class="text-right">' + Number(service.total).toFixed(2)+ '</td>' +
                '<td class="text-right"><button onclick="deleteSerive(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td>' +
                '</tr>');
            this.data.services[service.id] = service;
            $('#total_amount').empty().append('<b>Total USD : </b>' + getTotal())

        }

        function fillData(dclink) {
            axios.get('{{ url('/get-customer') }}/' + dclink)
                .then( function (response) {
                    var customer = response.data.customer;

                    $('#add_customer').hide();
                    $('#client_details').empty().append(
                        '<div class="col-sm-12"><h4><b>To</b></h4>'+
                        '<h4 id="client-name"> Name : ' + customer.Name + '</h4>'+
                        '<h4 id="contact-person">Contact Person : ' + customer.Contact_Person + '</h4>'+
                        '<h4 id="contact-phone">Phone : ' + customer.Telephone + '</h4>'+
                        '<h4 id="contact-email">Email : ' + customer.EMail + '</h4></div>'
                    );
                })
                .catch( function (response) {
                    console.log(response.data);
                });

            this.data.DCLink = dclink;
            display_search.empty();
        }
    </script>
@endsection