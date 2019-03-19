<?php

namespace App\Http\Controllers;

use App\Truck;
use App\TruckDsr;
use Carbon\Carbon;
use Esl\Repository\NotificationRepo;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function show(Truck $truck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function edit(Truck $truck)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truck $truck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truck  $truck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truck $truck)
    {
        //
    }

    public function updates(Request $request)
    {

        $trck = Truck::findORFail($request->truck_id);

        if ($trck->date_loaded){
            $lastdata = $trck->date_loaded;
        }
        elseif($trck->departure){
            $lastdata =  $trck->departure;
        }
        elseif($trck->arrival){
            $lastdata =  $trck->arrival;
        }
        elseif($trck->date_offloaded){
            $lastdata =  $trck->date_offloaded;
        }
        else{
            $lastdata = Carbon::now();
        }

        if ($request->has('date_loaded')){
            $trck->date_loaded = Carbon::parse($request->date_loaded.' '. $request->timer);
        }

        if ($request->has('date_offloaded')){
            if (Carbon::parse($request->date_offloaded.' '. $request->timer)->lt(Carbon::parse($lastdata))){
                return $this->returnBack();
            }
            $trck->date_offloaded = Carbon::parse($request->date_offloaded.' '. $request->timer);
        }
        if ($request->has('current_location')){
            TruckDsr::create([
                'title' => $request->current_location,
                'truck_id' => $request->truck_id,
                'description' => $request->current_location,
            ]);
            $trck->current_location = $request->current_location;
        }
        if ($request->has('departure')){
            if (Carbon::parse($request->departure.' '. $request->timer)->lt(Carbon::parse($lastdata))){
                return $this->returnBack();
            }

            $trck->departure = Carbon::parse($request->departure.' '. $request->timer);
        }
        if ($request->has('arrival')){
            if (Carbon::parse($request->arrival.' '. $request->timer)->lt(Carbon::parse($lastdata))){
                return $this->returnBack();
            }
            $trck->arrival = Carbon::parse($request->arrival.' '. $request->timer);
            $trck->remarks = $request->remarks;
        }
        if ($request->has('return')){
            if (Carbon::parse($request->return.' '. $request->timer)->lt(Carbon::parse($lastdata))){
                return $this->returnBack();
            }
            $trck->return = Carbon::parse($request->return.' '. $request->timer);
        }

        $trck->save();

        return Response(['success'=>'success']);
    }

    public function returnBack()
    {
        NotificationRepo::create()->error('Invalid Date Input');
        return Response(['success'=>'success']);

    }
}
