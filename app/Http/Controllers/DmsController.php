<?php

namespace App\Http\Controllers;

use App\BillOfLanding;
use App\Cargo;
use App\DeliveryNote;
use App\DmsComponent;
use App\Mail\ProjectInvoice;
use App\Quotation;
use App\Sof;
use App\Stage;
use App\Truck;
use App\VesselDocs;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;
use Esl\helpers\Constants;
use Esl\Repository\CustomersRepo;
use Esl\Repository\InvNumRepo;
use Esl\Repository\NotificationRepo;
use Esl\Repository\ProjectRepo;
use Esl\Repository\UploadFileRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DmsController extends Controller
{
    public function index()
    {
        $bl = BillOfLanding::with(['quote.services', 'customer'])->get();

        return view('dms.index')
            ->withDms($bl);
    }


    //TODO BL NOT SHOWING
    public function edit($id)
    {
        $dms = BillOfLanding::with(['quote.services', 'deliverynotes', 'transports', 'images',
            'contracts', 'remarks', 'quote.docs', 'quote.cargo', 'customer'])->findOrFail($id);
        $dmsComponents = DmsComponent::with(['scomponent.stage'])
            ->where('bill_of_landing_id', $id)->get();
        $currency = CustomersRepo::customerInit()->getCustomerCurrency($dms->customer->DCLink);
//        dd($dms, Truck::all());
        $checklist = $dmsComponents->map(function ($value) {
            return [
                'title' => $value->scomponent->stage->name,
                $value->scomponent->stage->name => [
                    'name' => $value->scomponent->name,
                    'type' => $value->scomponent->type,
                    'notification' => $value->scomponent->notification,
                    'timing' => $value->scomponent->timing,
                    'doc_links' => json_decode($value->doc_links),
                    'text' => $value->text,
                    'subchecklist' => $value->subchecklist,
                    'created_at' => $value->created_at
                ]
            ];
        })->reject(null);
        $update = false;

        if ($dms->consignee == null || $dms->consignor == null || $dms->esl_ref == null) {
            $update = true;
        }

        return view('dms.edit')
            ->withDms($dms)
            ->withCurrency($currency)
            ->withChecklist($checklist->groupBy('title'))
            ->withUpdate($update)
            ->withStages(Stage::with(['components'])->get());
    }

    public function reportTransportRevenue()
    {
        $dms = BillOfLanding::with(['transports',
            'contracts', 'remarks', 'quote.docs', 'customer'])->get();

        return view('reports.transport-revenue')
            ->withDmss($dms);

    }

    public function downloadReport(Request $request)
    {
        $data = BillOfLanding::with(['transports',
            'contracts', 'remarks', 'quote.docs', 'customer'])
            ->whereBetween('created_at', [Carbon::parse($request->date1), Carbon::parse($request->date2)])->get();

        return view('reports.download-transport-revenue')
            ->withDmss($data);
    }

    public function store(Request $request)
    {
        $data = [];

        if ($request->has('checklist')) {

            foreach ($request->checklist as $key => $check) {
                $checklist = [];
                foreach ($check as $inner_key => $item) {
                    array_push($checklist, $inner_key);
                }
                array_push($data, [$key => ['components' => json_encode($checklist)]]);
            }

        }

        if ($request->has('text_value')) {

            foreach ($request->text_value as $key => $item) {
                array_push($data, [$key => ['text' => $item[0]]]);
            }
        }

        if ($request->has('remark')) {

            foreach ($request->remark as $key => $item) {
                array_push($data, [$key => ['remark' => $item[0]]]);
            }
        }

        if ($request->has('doc_links')) {
            foreach ($request->doc_links as $key => $doc_link) {
                $doc_array = [];
                foreach ($doc_link as $doc) {
                    $image = $doc;
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $filepath = 'documents/uploads/';

                    $image->move(public_path('documents/uploads/'), $name);
                    array_push($doc_array, $filepath . $name);
                }

                array_push($data, [$key => ['doc_links' => json_encode($doc_array)]]);

            }
        }

        $keys = [];

        $insertData = [];
        $now = Carbon::now();
        foreach ($data as $key => $datum) {
            foreach ($datum as $data_key => $value) {
                foreach ($value as $xkey => $inner) {
                    if (!array_key_exists($data_key, $keys)) {
                        array_push($insertData, [
                            'bill_of_landing_id' => $request->dms_id,
                            'stage_component_id' => $data_key,
                            'doc_links' => $xkey == "doc_links" ? $inner : null,
                            'text' => $xkey == "text" ? $inner : null,
                            'remark' => $xkey == "remark" ? $inner : null,
                            'subchecklist' => $xkey == "components" ? $inner : null,
                            'created_at' => $now,
                            'updated_at' => $now
                        ]);
                        $keys[$data_key] = $data_key;
                    } else {
                        foreach ($insertData as $skey => $test) {
                            array_push($insertData, [
                                'bill_of_landing_id' => $request->dms_id,
                                'stage_component_id' => $data_key,
                                'doc_links' => ($xkey == "doc_links" && $test['doc_links'] == null) ? $inner : $test['doc_links'],
                                'text' => ($xkey == "text" && $test['text'] == null) ? $inner : $test['text'],
                                'remark' => ($xkey == "remark" && $test['remark'] == null) ? $inner : $test['remark'],
                                'subchecklist' => ($test['subchecklist'] == null && $xkey == "components") ? $inner : $test['subchecklist'],
                                'created_at' => $now,
                                'updated_at' => $now
                            ]);

                            unset($insertData[$skey]);
                            break;
                        }
                    }

                }
            }
        }

        DmsComponent::insert($insertData);
        return redirect()->back();
    }

    public function addSof(Request $request)
    {
        $data = $request->all();
        $data['from'] = Carbon::parse($request->from);
        $data['to'] = Carbon::parse($request->to);


        $sof = Sof::create($data);

        return Response(['success' => '<tr>' .
            '<td>' . $sof->created_at . '</td>' .
            '<td>' . Carbon::parse($sof->from)->format('H:i') . 'HRS</td>' .
            '<td>' . Carbon::parse($sof->to)->format('H:i') . 'HRS</td>' .
            '<td>' . $sof->crane_working . '</td>' .
            '<td>' . ucfirst($sof->remarks) . '</td>' .
            '</tr>']);
    }

    public function updateDms(Request $request)
    {



        $dms = BillOfLanding::with(['quote.services', 'deliverynotes', 'transports', 'images',
            'contracts', 'remarks', 'quote.docs', 'quote.cargo', 'customer'])->findOrFail($request->dms_id);
        $cargo = Cargo::findOrFail($dms->quote->cargo_id);
        $cargo->bl_number = $request->bl_number;
        $cargo->save();

        $project_id = ProjectRepo::init()->generateName($request->esl_ref)->makeProject();

        $quote = Quotation::findOrFail($dms->quote_id);
        $quote->project_id = $project_id;
        $quote->save();

        $year_now = new Carbon(Carbon::now());
        $jobs = BillOfLanding::whereYear('updated_at', $year_now->year)->count() + 1;
        $file_no = $jobs . '/' . Carbon::now()->format('y') . strtoupper($request->branch_code);
        BillOfLanding::findOrFail($request->dms_id)->update([
            "bl_number" => $request->get('bl_number'),
            "esl_ref" => $request->get('esl_ref'),
            "ctm_ref" => $request->get('ctm_ref'),
            "consignor" => $request->get('consignor'),
            "consignee" => $request->get('consignee'),
            "contract_ids" => $request->get('contract_ids'),
            "client_notification" => $request->get('client_notification'),
            "shipper" => $request->get('shipper'),
            "shipping_line" => $request->get('shipping_line'),
            "file_number" => $file_no
        ]);

        return redirect()->back();
    }

    public function deliveryNote(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['doc_path'] = UploadFileRepo::init()->upload($request->doc, 'documents');
        DeliveryNote::create($data);

        return redirect()->back();
    }

    public function generateLayTime($id)
    {
        $dms = BillOfLanding::with(['sof', 'cargo', 'images', 'vessel', 'customer', 'quote.voyage'])->findOrFail($id);

        $port_stay = ceil($dms->vessel->grt / $dms->discharge_rate);

        $laytime = [];
        $lowerpart['timeallowed'] = $this->getTimeDeatils(($port_stay * 24 * 60 * 60));;

        foreach ($dms->sof->sortByDesc('created_at') as $sof) {
            array_push($laytime, [
                'day' => Carbon::parse($sof->created_at)->format('l'),
                'date' => Carbon::parse($sof->created_at)->format('d-M-y'),
                'period' => Carbon::parse($sof->from)->format('H:i') . ' HRS - ' . Carbon::parse($sof->to)->format('H:i') . ' HRS',
                'time_to_count' => ($sof->crane_working * 100) / $dms->number_of_crane,
                'days' => $this->getTimeDeatils(strtotime(Carbon::parse($sof->to)) - strtotime(Carbon::parse($sof->from))),
                'remarks' => $sof->remarks,
                'secs' => abs(strtotime(Carbon::parse($sof->to)) - strtotime(Carbon::parse($sof->from)))
            ]);
        }

        $lowerpart['laytimeused'] = $this->getTimeDeatils(collect($laytime)->sum('secs'));
        $lowerpart['timesave'] = $this->getTimeDeatils(($port_stay * 24 * 60 * 60) - collect($laytime)->sum('secs'));
        $data = [
            $lowerpart,
            $laytime,
            [
                'vesselname' => $dms->vessel->name,
                'bl' => $dms->bl_number,
                'supplier' => $dms->cargo->first()->shipper,
                'arrive' => Carbon::parse($dms->quote->voyage->vessel_arrived)->format('d-M-y'),
                'weight' => $dms->vessel->grt,
                'rate' => $dms->discharge_rate,
                'time' => $dms->time_allowed,
                'ltime' => $dms->laytime_start,
            ]

        ];


        $pdf = PDF::loadView('pdf.laytime', compact('data'));
        return $pdf->download('laytime.pdf');

        return view('pdf.laytime')
            ->withData($data);
    }

    public function getTimeDeatils($sec)
    {
        $dt1 = new DateTime("@0");
        $dt2 = new DateTime("@$sec");
        return $dt1->diff($dt2)->format('%a, %h, %i');
    }

    public function complete($id)
    {
        $ctm = BillOfLanding::with(['transports'])->findOrFail($id);

        $checkcompleted = true;

        if (count(Truck::where('bl_id', $id)->first()) < 1) {
            $checkcompleted = false;
        }


        if (!$checkcompleted) {
            NotificationRepo::create()->error('Enter all the Trucks DSR records to complete the job');

            return redirect()->back();
        }

        $ctm->update(['status' => 1, 'completed_by' => Auth::user()->id]);

        $quotation = Quotation::with(['user', 'customer', 'services.service'])->findOrFail($ctm->quote_id);

        InvNumRepo::init()->makeInvoice($quotation);

        $projectName = ProjectRepo::init()->getProjectNumber($quotation->project_id);

        Mail::to(['email' => 'accounts@esl-eastafrica.com'])
            ->cc(Constants::TRANSPORT_CC)
            ->send(new ProjectInvoice(['message' => 'Project ' . $projectName .
                ' has been successfully closed by ' . ucwords(Auth::user()->name) . ' on ' . Carbon::now()->format('d-M-y H:m') . '. thank you for your support'], 'PROJECT ' . $projectName . ' COMPLETED'));

        return redirect('/dsr');

    }

}
