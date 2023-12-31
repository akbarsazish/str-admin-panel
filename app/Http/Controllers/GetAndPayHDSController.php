<?php

namespace App\Http\Controllers;

use App\Models\GetAndPayHDS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GetAndPayBYS;
use DB;

class GetAndPayHDSController extends Controller
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
        try{
            $lastDocNo = GetAndPayHDS::where("GetOrPayHDS",$request->getOrPayHDS)->where('FiscalYear',1402)->where("CompanyNo",5)->max('DocNoHDS');
            $getAndPayHDS = new GetAndPayHDS;
            $getAndPayHDS->CompanyNo = 5;
            $getAndPayHDS->GetOrPayHDS=$request->getOrPayHDS;
            $getAndPayHDS->DocNoHDS=($lastDocNo+1);
            $getAndPayHDS->DocDate=$request->docDateHDS;
            $getAndPayHDS->DocDescHDS=$request->docDescHDS;
            $getAndPayHDS->PeopelHDS=$request->PeopelHDS;
            $getAndPayHDS->FiscalYear=1402;
            $getAndPayHDS->SnFactor=0;
            $getAndPayHDS->InForHDS=$request->InforHDS;
            $getAndPayHDS->NetPriceHDS=$request->netPriceHDS;
            $getAndPayHDS->DocTypeHDS=$request->payType;
            $getAndPayHDS->SnCashMaster=$request->SnCashMaster;
            $savedHds = $getAndPayHDS->save();
            $lastHDS=GetAndPayHDS::WHERE("GetOrPayHDS",$request->getOrPayHDS)->max('SerialNoHDS');
            $byss=$request->input('BYSs');
            
            if($savedHds){
                foreach($byss as $bys){
                    $getAndPayBYS = new GetAndPayBYS;
                    $getAndPayBYS->CompanyNo = 5;
                    $getAndPayBYS->DocTypeBYS=$request->{'BysType'.$bys} ?? 0;
                    $getAndPayBYS->DocDescBys=$request->{'DocDescBys'.$bys} ?? '';
                    $getAndPayBYS->NoPayaneh_KartKhanBys=$request->{'NoPayanehKartKhanBYS'.$bys} ?? '';
                    $getAndPayBYS->SnAccBank=$request->{'SnAccBank'.$bys} ?? 0;
                    $getAndPayBYS->SnBank=$request->{'SnBank'.$bys} ?? 0;
                    $getAndPayBYS->FiscalYear=1402;
                    $getAndPayBYS->SnPeopelPay=$request->{'SnPeopelPay'.$bys} ?? 0;
                    $getAndPayBYS->SnMainPeopel= 0;
                    $getAndPayBYS->ChequeDate=$request->{'checkSarRasidDate'.$bys} ?? '';
                    $getAndPayBYS->ChequeNo=$request->{'chequeNoCheqe'.$bys} ?? 0;
                    $getAndPayBYS->Branch=$request->{'Branch'.$bys} ?? '';
                    $getAndPayBYS->Owner=$request->{'ownerName'.$bys} ?? '';
                    $getAndPayBYS->Price=$request->{'Price'.$bys} ?? 0;
                    $getAndPayBYS->NoSayyadi=$request->{'sayyadiNoCheque'.$bys} ?? 0;
                    $getAndPayBYS->AccBankNo=$request->{'AccBankNo'.$bys} ?? 0;
                    $getAndPayBYS->SnHDS=$lastHDS;
                    $getAndPayBYS->CashNo=$request->SnCashMaster??0;
                    $getAndPayBYS->SnChequeBook=$request->{'SnChequeBook'.$bys} ?? 0;
                    $getAndPayBYS->KarMozdPriceBys=$request->{'Karmozd'.$bys} ?? 0;
                    $getAndPayBYS->save();
                }
            }
            return \response()->json(['success' => $savedHds]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GetAndPayHDS  $getAndPayHDS
     * @return \Illuminate\Http\Response
     */
    public function show(GetAndPayHDS $getAndPayHDS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GetAndPayHDS  $getAndPayHDS
     * @return \Illuminate\Http\Response
     */
    public function edit(GetAndPayHDS $getAndPayHDS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GetAndPayHDS  $getAndPayHDS
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GetAndPayHDS $getAndPayHDS)
    {
        $allSerialNo=array();
        $snHDS;
        try{
            $docDateHDS=$request->PayDocDate;
            $docNoHDS=$request->PayDocNoHDS;
            $docTypeHDS=$request->PayType;
            $peopelHDS=$request->PeopelHDS;
            $docdescHDS=$request->DocDescHDS;
            $snHDS=$request->HDS;
            $inforHDS=$request->InforHDS;
            $byss=$request->BYSs??array();
            
            GetAndPayHDS::where("SerialNoHDS",$snHDS)->update(["DocDate"=>$docDateHDS,"DocDescHDS"=>$docdescHDS,"PeopelHDS"=>$peopelHDS,"InForHDS"=>$inforHDS,"NetPriceHDS"=>$inforHDS]);
            if(count($byss)>0){
                foreach($byss as $bys){
                    $accBankNoBYS=$request->{'AccBankNo'.$bys} ?? 0;
                    $branchBYS=$request->{'Branch'.$bys} ?? '';
                    $doctypeBys=$request->{'BysType'.$bys} ?? 0;
                    $docDescBYS=$request->{'DocDescBys'.$bys}  ?? '';
                    $karmozdBYS=$request->{'Karmozd'.$bys} ?? 0;
                    $nopayanehBYS=$request->{'NoPayanehKartKhanBYS'.$bys}  ?? '';
                    $priceBYS=$request->{'Price'.$bys} ?? 0;
                    $snAccBank=$request->{'SnAccBank'.$bys} ?? 0;
                    $snbankBYS=$request->{'SnBank'.$bys} ?? 0;
                    $snCheckBookBYS=$request->{'SnChequeBook'.$bys} ?? 0;
                    $snMainPeopeBYS=$request->{'SnMainPeopel'.$bys} ?? 0;
                    $snPplPayBYS=$request->{'SnPeopelPay'.$bys} ?? 0;
                    $chequeSarRasidBYS=$request->{'checkSarRasidDate'.$bys} ?? '';
                    $checkNoBYS=$request->{'chequeNoCheqe'.$bys} ?? 0;
                    $docNoBYS=$request->{'hawalaNo'.$bys} ?? 0;
                    $ownerName=$request->{'ownerName'.$bys} ?? '';
                    $sayyadiNoBYS=$request->{'sayyadiNoCheque'.$bys} ?? 0;
                    $serialNoBYS=$request->{'SerialNoBYS'.$bys};
                    array_push($allSerialNo,$serialNoBYS);
                    $isEditable=GetAndPayBYS::where("SnHDS",$snHDS)->where("SerialNoBYS",$serialNoBYS)->get();
                    
                    if(count($isEditable)>0){
                        try{
                            GetAndPayBYS::where("SerialNoBYS",$serialNoBYS)->update(
                                ["CompanyNo"=>5,"DocTypeBYS"=>$doctypeBys,"Price"=>$priceBYS,"ChequeDate"=>$chequeSarRasidBYS,
                                "ChequeNo"=>$checkNoBYS,"AccBankno"=>$accBankNoBYS,"Owner"=>$ownerName,"SnBank"=>$snbankBYS,
                                "Branch"=>$branchBYS,"SnChequeBook"=>$snCheckBookBYS,"FiscalYear"=>1402,"SnHDS"=>$snHDS,
                                "DocDescBYS"=>$docDescBYS,"SnAccBank"=>$snAccBank,"NoPayaneh_KartKhanBys"=>$nopayanehBYS,
                                "KarMozdPriceBys"=>$karmozdBYS,"NoSayyadi"=>$sayyadiNoBYS,"NameSabtShode"=>'',"SnPeopelPay"=>$snPplPayBYS
                                ]);
                            //return $serialNoBYS;
                        }catch(\Exception $e){
                            return $e->getMessage();
                        }
                    }else{
                        try{
                            //return $snAccBank;
                            GetAndPayBYS::create(["CompanyNo"=>5,"DocTypeBYS"=>$doctypeBys,"Price"=>$priceBYS,"ChequeDate"=>$chequeSarRasidBYS,
                            "ChequeNo"=>$checkNoBYS,"AccBankno"=>$accBankNoBYS,"Owner"=>$ownerName,"SnBank"=>$snbankBYS,
                            "Branch"=>$branchBYS,"SnChequeBook"=>$snCheckBookBYS,"FiscalYear"=>1402,"SnHDS"=>$snHDS,
                            "DocDescBYS"=>$docDescBYS,"SnAccBank"=>$snAccBank,"NoPayaneh_KartKhanBys"=>$nopayanehBYS,
                            "KarMozdPriceBys"=>$karmozdBYS,"NoSayyadi"=>$sayyadiNoBYS,"NameSabtShode"=>'',"SnPeopelPay"=>$snPplPayBYS
                            ]);
                            array_push($allSerialNo,GetAndPayBYS::where("SnHDS",$snHDS)->max("SerialNoBYS"));
                    }catch(\Exception $e){
                        return $e->getMessage();
                    }
                    }
                }
                
                try{
                    if(count($allSerialNo)>0){
                        DB::delete("DELETE FROM Shop.dbo.GetAndPayBYS WHERE SnHDS=$snHDS AND SerialNoBYS NOT IN(".implode(",",$allSerialNo).")");
                    }else{
                        DB::delete("DELETE FROM Shop.dbo.GetAndPayHDS WHERE SerialNoHDS=$snHDS");
                    }
                }catch(\Exception $e){
                    return $e->getMessage();
                }
            }else{
                DB::delete("DELETE FROM Shop.dbo.GetAndPayBYS WHERE SnHDS=$snHDS");
                DB::delete("DELETE FROM Shop.dbo.GetAndPayHDS WHERE SerialNoHDS=$snHDS");
            }
        }catch(\Exception $e){
            return $e->getMessage();
        }
        return response(array('result'=>'done'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GetAndPayHDS  $getAndPayHDS
     * @return \Illuminate\Http\Response
     */
    public function destroy($getAndPayHDSId)
    {
        try{
            $getAndPayHDS = GetAndPayHDS::find($getAndPayHDSId);
            GetAndPayBYS::where('SnHDS',$getAndPayHDSId)->delete();
            $getAndPayHDS->delete();
            return \response()->json(['success' => $getAndPayHDS]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
