<?php

namespace App\Http\Controllers;

use App\BillOfLanding;
use App\Lead;
use App\Quotation;
use App\QuotationService;
use App\Transport;
use App\Truck;
use Carbon\Carbon;
use Esl\Repository\CurrencyRepo;
use Esl\Repository\CustomersRepo;
use Esl\Repository\UploadFileRepo;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        return view('transport.dashboard.dashboard')
            ->withQuotations([]);
    }

    public function transport()
    {
        $quotation = Quotation::with(['customer','user'])->simplePaginate(25);

        return view('transport.transport.index')
            ->withQuotations($quotation);
    }

    public function addTransport($id)
    {
        $dms = BillOfLanding::with(['quote.services','quote.cargo.cargoType','contracts','contracts.slubs','remarks',
            'quote.docs','customer'])->findOrFail($id);
        $currency = CustomersRepo::customerInit()->getCustomerCurrency($dms->customer->DCLink);


        $selling = $dms->quote->services->where('name','Transport Charges')->first();
        $selling ? $selling->selling_price : 0;

        return view('transport.transport.add-transport')
            ->withTransport($dms)
            ->withCurrency($currency)
            ->withSelling($selling);
    }

    public function storeTransport(Request $request)
    {
        $data = $request->all();
        $data['image_path'] = UploadFileRepo::init()->upload($request->image_path, 'documents');
        Truck::create($data);

        return redirect('/dms/edit/'.$request->bill_of_landing_id);

    }
}
