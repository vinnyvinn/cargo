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
                        <h4 class="card-title">Add Sub Service</h4>
                        <form class="form-material m-t-40" action="{{ route('services.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
{{--<<<<<<< HEAD--}}
                                        <label for="cargo_type_id">Cargo Type</label>
                                        <select name="cargo_type_id" required id="cargo_type_id" class="form-control">
                                            <option value="">Select Cargo Type</option>
                                          @foreach(\App\CargoType::all() as $value)
                                                <option value="{{$value->name}}">{{$value->name}}</option>
                                              @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Sub Service Name </label>
                                        <input type="text" required id="name" name="name" class="form-control" placeholder="Service Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="desc">Description</label>
                                        <input type="text" required id="desc" name="desc" class="form-control" placeholder="Description">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn pull-right btn-primary">Save</button>
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

