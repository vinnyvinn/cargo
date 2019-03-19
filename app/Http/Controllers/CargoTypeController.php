<?php

namespace App\Http\Controllers;

use App\CargoType;
use Illuminate\Http\Request;

class CargoTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cargo-types.index')
            ->withCargotypes(CargoType::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargo-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CargoType::create($request->all());

        return redirect('/cargo-types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CargoType  $cargoType
     * @return \Illuminate\Http\Response
     */
    public function show(CargoType $cargoType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CargoType  $cargoType
     * @return \Illuminate\Http\Response
     */
    public function edit(CargoType $cargoType)
    {
        return view('cargo-types.edit')
            ->withCargotype($cargoType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CargoType  $cargoType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CargoType $cargoType)
    {
        $cargoType->update($request->all());
        return redirect('/cargo-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CargoType  $cargoType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargoType $cargoType)
    {
        $cargoType->delete();

        return redirect('/cargo-types');
    }
}
