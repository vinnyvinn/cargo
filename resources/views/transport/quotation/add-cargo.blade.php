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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Cargo Details</h4>
                        <div class="col-12">
                            <form action="{{ url('/store-cargo') }}"  method="post">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"><label for="desc">Cargo Description</label>
                                            <textarea name="desc" id="desc" cols="30" rows="1"
                                                      class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="cargo_type">Cargo Type</label>
                                            <select name="cargo_type" required id="cargo_type"
                                                    class="form-control">
                                                <option value="">Select</option>
                                                @foreach(\App\CargoType::all() as $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="start">Pick-up Point</label>
                                            <input type="text" required id="start" name="start" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="destination">Destination</label>
                                            <input type="text" required id="destination" name="destination" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="distance">Distance(KM)</label>
                                            <input type="number" required id="distance" name="distance" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cargo_weight">Total Cargo Weight(KG)</label>
                                            <input type="number" required id="cargo_weight" name="cargo_weight" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="cargo_quantity">Cargo Quantity</label>
                                            <input type="number" required id="cargo_quantity" name="cargo_quantity" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea name="remarks" id="remarks" cols="30" rows="1"
                                                      class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <br>
                                            <input class="btn pull-right btn-primary" type="submit" value="Add Cargo Detail">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
