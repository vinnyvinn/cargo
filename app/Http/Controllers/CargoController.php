<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\ServiceTax;
use App\TransportService;
use Esl\Repository\CurrencyRepo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function addCargo()
    {
        return view('transport.quotation.add-cargo');
    }

    public function storeCargo(Request $request)
    {
        $cargo = Cargo::create($request->all());

        $type = $cargo->cargoType()->first();

        $services = TransportService::all();

        return view('transport.quotation.generate')
            ->withServices($services)
            ->withCargo($cargo)
            ->withType($type)
            ->withExrate(CurrencyRepo::init()->exchangeRate())
            ->withTaxs(ServiceTax::all()->sortBy('Description'));
    }
}
