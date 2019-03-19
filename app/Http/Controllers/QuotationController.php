<?php

namespace App\Http\Controllers;

use App\BillOfLanding;
use App\Customer;
use App\GoodType;
use App\Mail\ProjectInvoice;
use App\Mail\RequestApproval;
use App\Quotation;
use App\QuotationService;
use App\ServiceTax;
use App\Tariff;
use App\TransportDoc;
use App\TransportService;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Esl\helpers\Constants;
use Esl\Repository\CurrencyRepo;
use Esl\Repository\CustomersRepo;
use Esl\Repository\InvNumRepo;
use Esl\Repository\NotificationRepo;
use Esl\Repository\QuotationRepo;
use Esl\Repository\UploadFileRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{
    public function showQuotation($id)
    {

        $quote = Quotation::with(['customer','services','cargo.cargoType','remarks.user'])
            ->findOrFail($id);

        return view('transport.quotation.show')
            ->withQuotation($quote)
            ->withCargo($quote->cargo)
            ->withType($quote->cargo->cargoType)
            ->withServices(TransportService::all()->sortBy('name'))
            ->withExrate(CurrencyRepo::init()->exchangeRate())
            ->withTaxs(ServiceTax::all()->sortBy('Description'))
            ->withCurrency(CustomersRepo::customerInit()->getCustomerCurrency($quote->customer->DCLink))
            ->withDocs(TransportDoc::all()->sortBy('name'));
    }

    public function requestQuotation($id)
    {
        Quotation::findOrFail($id)->update(['status' => Constants::LEAD_QUOTATION_REQUEST]);

        NotificationRepo::create()->notification(Constants::Q_APPROVAL_TITLE, Constants::Q_APPROVAL_TEXT,
            '/quotation/preview/'.$id,0,Constants::DEPARTMENT_AGENCY);

        Mail::to(['email'=>'accounts@esl-eastafrica.com'])
            ->cc(Constants::TRANSPORT_CC)
            ->send(new ProjectInvoice(['message'=>'Kindly review this quotation ( '.url('/quotation/preview/'.$id).' )and advice Head of Transport in case the project is making lose otherwise ignore'],'Client Quotation Review'));

        Mail::to(['email'=>'erick.osinya@esl-eastafrica.com'])
            ->cc(Constants::TRANSPORT_CC)
            ->send(new RequestApproval([
                'user' => Auth::user()->name,
                'url'=>'/quotation/view/'.$id]));

        return redirect()->back();
    }

    public function allQuotations()
    {
        return view('transport.quotation.all')
            ->withQuotations(Quotation::all());
    }

    public function userQuotations()
    {
        return view('transport.quotation.all')
            ->withQuotations(Quotation::where('user_id',Auth::user()->id)->get());
    }

    public function viewQuotation($id)
    {
        $quote = Quotation::with(['customer','services','remarks.user'])->findOrFail($id);

        return view('transport.quotation.view')
            ->withQuotation($quote)
            ->withServices(TransportService::all()->sortBy('name'))
            ->withDocs(TransportDoc::all()->sortBy('name'));
    }

    public function previewQuotation($id)
    {
        $quote = Quotation::with(['customer','services'])->findOrFail($id);

        return view('transport.quotation.preview')
            ->withQuotation($quote)
            ->withServices(TransportService::all()->sortBy('name'));
    }

    public function sendToCustomer(Request $request)
    {
        QuotationRepo::make()->changeStatus($request->quotation_id,
            Constants::LEAD_QUOTATION_WAITING);

        NotificationRepo::create()->notification(Constants::Q_APPROVED_TITLE,
            Constants::Q_APPROVED_TEXT,
            '/quotation/preview/'.$request->quotation_id,0,'Agency', Auth::user()->id);

        Mail::to(['email'=>$request->email])
            ->cc(Constants::TRANSPORT_CC)
            ->send(new \App\Mail\Quotation([
                'message' => $request->message,
                'user'=>Auth::user()->name,
                'url'=>'/quotation/download/'.$request->quotation_id], $request->subject));

        $quotation = Quotation::with(['customer','services','remarks.user'])->findOrFail($request->quotation_id);
        $currency = ((Customer::where('DCLink',$quotation->customer->DCLink)->get()->first()->iCurrencyID) == 1 ? 'USD' : 'KES' );

        //send mail
//        $pdf = PDF::loadView('pdf.invoice',compact(['quotation','currency']));
//        return $pdf->download($quotation->customer->Name.'_Q00'.$quotation->id.'.pdf');

        return redirect()->back();
    }

    public function pdfQuotation($id)
    {
        $quotation = Quotation::with(['lead','cargos.goodType','vessel','services.tariff'])->findOrFail($id);

        $pdf = PDF::loadView('quotation.pdf', compact('quotation'));
        return $pdf->download('pda.pdf');


    }

    public function customerAccept($id)
    {
        QuotationRepo::make()->changeStatus($id,
            Constants::LEAD_QUOTATION_ACCEPTED);

        NotificationRepo::create()->notification(Constants::Q_APPROVED_TITLE,
            Constants::Q_APPROVED_TEXT,
            '/quotation/preview/'.$id,0,'Agency', Auth::user()->id);

        return redirect()->back();
    }

    public function downloadPdf($id)
    {
        $quotation = Quotation::with(['customer','user','services','remarks.user'])->findOrFail($id);
//        dd($quotation);
        $currency = ((Customer::where('DCLink',$quotation->customer->DCLink)->get()->first()->iCurrencyID) == 1 ? 'USD' : 'KSHS' );

        $pdf = PDF::loadView('pdf.invoice',compact(['quotation','currency']));
        return $pdf->download($quotation->customer->Name.'_Q00'.$quotation->id.'.pdf');
    }

    public function pdaStatus($status)
    {
        if ($status == Constants::LEAD_QUOTATION_PENDING){
            $dms = Quotation::with(['lead','vessel','cargos'])->where('status',
                Constants::LEAD_QUOTATION_PENDING)->simplePaginate(25);
        }

        if ($status == Constants::LEAD_QUOTATION_REQUEST){
            $dms = Quotation::with(['lead','vessel','cargos'])->where('status',
                Constants::LEAD_QUOTATION_REQUEST)->simplePaginate(25);
        }

        if ($status == Constants::LEAD_QUOTATION_APPROVED){
            $dms = Quotation::with(['lead','vessel','cargos'])->where('status',
                Constants::LEAD_QUOTATION_APPROVED)->simplePaginate(25);
        }

        return view('pdas.index')
            ->withDms($dms)
            ->withStatus($status);

    }

    public function customerDecline($id)
    {
        QuotationRepo::make()->changeStatus($id,
            Constants::LEAD_QUOTATION_DECLINED_CUSTOMER);

        NotificationRepo::create()->notification(Constants::Q_DECLINED_C_TITLE,
            Constants::Q_DECLINED_C_TEXT,
            '/quotation/preview/'.$id,0,'Agency', Auth::user()->id);

        return redirect()->back();
    }

    public function convertCustomer(Request $request, $id)
    {
        QuotationRepo::make()->changeStatus($id,
            Constants::LEAD_QUOTATION_CONVERTED);

        NotificationRepo::create()->notification(Constants::Q_DECLINED_C_TITLE,
            Constants::Q_DECLINED_C_TEXT,
            '/quotation/preview/'.$id,0,'Transport', Auth::user()->id);

        $quotation = Quotation::with(['user','customer','services.service'])->findOrFail($id);

//        InvNumRepo::init()->makeInvoice($quotation);
//        $leadData =  $quotation->lead;
//        $customer = CustomersRepo::customerInit()->convertLeadToCustomer($leadData->toArray());
        $bl = BillOfLanding::create([
            'quote_id' => $quotation->id,
            'Client_id' => $quotation->DCLink,
            'stage' => 'Pre-arrival docs',
            'status' => 0,
        ]);

        return redirect('/dms/edit/'.$bl->id);
    }

    public function serviceCost(Request $request)
    {
        $filepath = ' ';
        if ($request->has('doc_path')){
            $filepath = UploadFileRepo::init()->upload($request->doc_path);
        }

        $service = QuotationService::find($request->service_id);
        $service->buying_price = $request->buying_price;
        $service->purchase_desc = $request->description;
        $service->doc_path = $filepath;
        $service->save();

        return redirect()->back();
    }
}
