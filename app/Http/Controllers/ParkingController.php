<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parking;

class ParkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parkings = Parking::all();
        return view('parkings.index', compact('parkings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parkings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'parking_name'=>'required|unique:parkings',
          'parking_status'=>'required',
          'parking_type'=>'required',
          'parking_capacity'=>'required|integer',
          'parking_price'=>'required|integer',
          'parking_latitude'=>'required',
          'parking_longitude'=>'required'
        ]);
        $parking = new Parking([
          'parking_name'=>$request->get('parking_name'),
          'parking_status'=>$request->get('parking_status'),
          'parking_type'=>$request->get('parking_type'),
          'parking_capacity'=>$request->get('parking_capacity'),
          'parking_price'=>$request->get('parking_price'),
          'parking_latitude'=>$request->get('parking_latitude'),
          'parking_longitude'=>$request->get('parking_longitude')
        ]);
        $parking->save();
        return redirect('/parkings')->with('success','Parking has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $share = Parking::find($id);
        return view('parkings.edit', compact('parking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
          'parking_name'=>'required|unique:parkings',
          'parking_status'=>'required',
          'parking_type'=>'required',
          'parking_capacity'=>'required|integer',
          'parking_price'=>'required|integer',
          'parking_latitude'=>'required',
          'parking_longitude'=>'required'
        ]);
        $parking = Parking::find($id);
        $parking_name = $request->get('parking_name');
        $parking_status = $request->get('parking_status');
        $parking_type = $request->get('parking_type');
        $parking_capacity = $request->get('parking_capacity');
        $parking_price = $request->get('parking_price');
        $parking_latitude = $request->get('parking_latitude');
        $parking_longitude = $request->get('parking_longitude');
        return redirect('/parkings')->with('success', 'Parking has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parking = Parking::find($id);
        $parking->delete();
        return redirect('/parkings')->with('success', 'Parking has been deleted Successfully');
    }
}
