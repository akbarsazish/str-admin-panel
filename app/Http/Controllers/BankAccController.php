<?php

namespace App\Http\Controllers;

use App\Models\AccBanks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankAccController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(AccBanks::where("CompanyNo",5)->get());
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
     * @param  \App\Models\AccBanks  $accBanks
     * @return \Illuminate\Http\Response
     */
    public function show($snAcc)
    {
        return response()->json(AccBanks::where("SerialNoAcc",$snAcc)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccBanks  $accBanks
     * @return \Illuminate\Http\Response
     */
    public function edit($snAcc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccBanks  $accBanks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccBanks $accBanks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccBanks  $accBanks
     * @return \Illuminate\Http\Response
     */
    public function destroy($snAcc)
    {
        AccBanks::where("SerialNoAcc",$snAcc)->delete();
        return response()->json(['result'=>"Deleted"]);
    }
    public function getByBank($snBank){
        return response()->json(AccBanks::where("SnBank",$snBank)->get());
    }
}
