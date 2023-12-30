<?php

namespace App\Http\Controllers;

use App\Models\ChequeBooks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GetAndPayBYS;

class ChequeBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ChequeBooks::where("CompanyNo",5)->get());
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
     * @param  \App\Models\ChequeBooks  $chequeBooks
     * @return \Illuminate\Http\Response
     */
    public function show($snChequeBook)
    {
        return response()->json(ChequeBooks::where("CompanyNo",5)->where("SnChequeBook",$snChequeBook)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChequeBooks  $chequeBooks
     * @return \Illuminate\Http\Response
     */
    public function edit($snChequeBook)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChequeBooks  $chequeBooks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChequeBooks $chequeBooks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChequeBooks  $chequeBooks
     * @return \Illuminate\Http\Response
     */
    public function destroy($snChequeBook)
    {
        ChequeBooks::where("CompanyNo",5)->where("SerialNoChequeBook",$snChequeBook)->delete();
        return response()->json(['result'=>"Deleted"]);
    }

    public function getChequesByAcc($snAcc){
        return response()->json(ChequeBooks::where("CompanyNo",5)->where("SnAccBank",$snAcc)->get());
    }
    public function checkChequeNo($sNCheque,$chequeNo){
        
        $isChequeNoExist=ChequeBooks::where("CompanyNo",5)->where("SnChequeBook",$sNCheque)->where("FirstSerialNo",'<=',$chequeNo)->where("EndSerialNo",'>=',$chequeNo)->first();
        if($isChequeNoExist){
            $isChequeNoUsed=GetAndPayBYS::where("CompanyNo",5)->where("SnChequeBook",$sNCheque)->where('ChequeNo',$chequeNo)->first();
            if($isChequeNoUsed){
                return response()->json(['result'=>"Used"]);
            }else{
                return response()->json(['result'=>"Exist"]);
            }

        }else{
            return response()->json(['result'=>"Not Exist"]);
        }

    }
}
