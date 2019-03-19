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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Transport</h4>
                        <form id="contact_form" class="m-t-40" action="{{ url('/store-transport') }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="driver">Driver Name</label>
                                        <input type="text" required id="driver" name="driver" class="form-control" placeholder="Driver Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="driver_id">Driver ID</label>
                                        <input type="number" required id="driver_id" name="driver_id" class="form-control" placeholder="Driver ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Driver Phone Number</label>
                                        <input type="text" required id="contact" name="contact" class="form-control" placeholder="Driver Phone Number">
                                    </div>
                                    <input type="hidden" name="bl_id" value="{{$transport->id}}">
                                    <div class="form-group">
                                        <label for="vehicle_no">Truck Number / Trail Number</label>
                                        <input type="text" required id="vehicle_no" name="vehicle_no" class="form-control" placeholder="Truck Number / Trail Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="container_no">Container Number</label>
                                        <input type="text" required id="container_no" {{ strpos($transport->quote->cargo->cargoType->name,'Container') == 1 ? ' ' : 'readonly' }} value="{{ strpos($transport->quote->cargo->cargoType->name,'Container') == 1 ? ' ' : '0' }}" name="container_no" class="form-control" placeholder="Container Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="feu">FEU</label>
                                        <input type="text"  id="feu" name="feu" {{ strpos($transport->quote->cargo->cargoType->name,'Container') == 1 ? ' ' : 'readonly' }} value="{{ strpos($transport->quote->cargo->cargoType->name,'Container') == 1 ? ' ' : '0' }}" class="form-control" placeholder="FEU">
                                    </div>
                                    <div class="form-group">
                                        <label for="current_location">Current Location</label>
                                        <input type="text" required id="current_location" name="current_location" class="form-control" placeholder="Current Location">
                                    </div>
                                    <div class="form-group">
                                        <label for="image_path">Cargo Image</label>
                                        <input type="file" required id="image_path" name="image_path" class="form-control" placeholder="">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lcl">LCL</label>
                                        <input type="text"  id="lcl" name="lcl" {{ strpos($transport->quote->cargo->cargoType->name,'Container') ? 'readonly' : ' ' }} value="{{ strpos($transport->quote->cargo->cargoType->name,'Container') ? '0' : ' ' }}" class="form-control" placeholder="LCL">
                                    </div>
                                    <div class="form-group">
                                        <label for="teu">TEU</label>
                                        <input type="text"  id="teu" {{ strpos($transport->quote->cargo->cargoType->name,'Container') ? ' ' : 'readonly' }} value="{{ strpos($transport->quote->cargo->cargoType->name,'Container') ? ' ' : '0' }}" name="teu" class="form-control" placeholder="TEU">
                                    </div>
                                    <div class="form-group">
                                        <label for="weight">Cargo Weight(KG)</label>
                                        <input type="number" required id="weight" value="" name="weight" class="form-control" placeholder="Cargo Weight">
                                    </div>
                                    <div class="form-group">
                                        <label for="qty">Cargo Quantity</label>
                                        <input type="number" required id="qty" value="" name="qty" class="form-control" placeholder="Quantity">
                                    </div>
                                    <div class="form-group">
                                        <label for="good_condition">Cargo Condition</label>
                                        <input type="text" required id="good_condition" value="" name="good_condition" class="form-control" placeholder="Cargo Condition">
                                    </div>
                                    @if($transport->contracts->contract_type == 'rates')
                                        <div class="form-group"><label for="rates">Rates</label>
                                            <select name="rates" id="rates" onchange="changeBuying(this)" class="form-control select2">
                                                <option value="">Select Transport</option>
                                                @foreach($transport->contracts->slubs as $slub)
                                                    <option value="{{$slub}}">{{ $slub->from }} - {{ $slub->to }} @ {{ $slub->charges }} in {{ $slub->t_round }} days</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="buying">Buying </label>
                                            <input type="text" id="buying" name="buying" readonly class="form-control" placeholder="Buying">
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="buying">Buying </label>
                                            <input type="text" id="buying" name="buying" value="{{ $currency == 'USD' ? (($transport->contracts->contract_type == 'open' ? $transport->contracts->value :
                                                        ($transport->contracts->contract_type == 'per_wgt' ? ($transport->contracts->value * $transport->quote->cargo->cargo_weight) : ($transport->contracts->value * $transport->quote->cargo->distance))) / \Esl\Repository\CurrencyRepo::init()->exchangeRate()) : ($transport->contracts->contract_type == 'open' ? $transport->contracts->value :
                                                        ($transport->contracts->contract_type == 'per_wgt' ? ($transport->contracts->value * $transport->quote->cargo->cargo_weight) : ($transport->contracts->value * $transport->quote->cargo->distance)))}}" readonly class="form-control" placeholder="Buying">
                                        </div>
                                    @endif

                                        <input type="hidden" id="bill_of_landing_id" value="{{$transport->id}}" name="bill_of_landing_id" class="form-control" >
                                    <div class="form-group">
                                        <label for="cost">Selling </label>
                                        {{--<input type="text" required id="cost" readonly value="" name="cost" class="form-control" placeholder="Cost">--}}
                                        <input type="text" required id="cost" readonly value="{{  $currency == 'USD' ? (\Esl\Repository\CurrencyRepo::init()->exchangeRate() * ($transport->contracts->contract_type == 'rates' ? $selling : ($transport->contracts->contract_type == 'open' ? $selling :
                                                        ($transport->contracts->contract_type == 'per_wgt' ? ($selling * $transport->quote->cargo->cargo_weight) : ($selling * $transport->quote->cargo->distance))))) : (($transport->contracts->contract_type == 'rates' ? $selling : ($transport->contracts->contract_type == 'open' ? $selling :
                                                        ($transport->contracts->contract_type == 'per_wgt' ? ($selling * $transport->quote->cargo->cargo_weight) : ($selling * $transport->quote->cargo->distance)))))}}" name="cost" class="form-control" placeholder="Cost">
                                    </div>
                                    <div class="form-group">
                                        <br>
                                        <input class="btn pull-right btn-primary gen-transport" type="submit" value="Save">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        function changeBuying(data) {
            var buyingValue = $('#buying');
            var selected = document.getElementById("rates")
            var getSelectedService = JSON.parse(selected.options[selected.selectedIndex].value);

            buyingValue.val(getSelectedService.charges);
            console.log(getSelectedService);
        }

        {{--function contractForm(form) {--}}
            {{--var form_id = form.id;--}}
            {{--var contractForm = $('#' + form_id);--}}

            {{--var data = contractForm.serializeArray().reduce(function(obj, item) {--}}
                {{--obj[item.name] = item.value;--}}
                {{--return obj;--}}
            {{--}, {});--}}

            {{--axios.post('{{ route('contracts.store') }}', data)--}}
                {{--.then( function (response) {--}}

                {{--})--}}
                {{--.catch( function (response) {--}}

                {{--})--}}
        {{--}--}}
    </script>
@endsection

