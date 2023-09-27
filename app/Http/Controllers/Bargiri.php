<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Session;
use Cockie;
use DateTime;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
class Bargiri extends Controller {
    public function getMasterBarInfo(Request $request){
        $snMaster=$request->input("snMasterBar");
        $masterBargiriInfo=DB::select("SELECT * FROM Shop.dbo.BargiryHDS  WHERE CompanyNo=5 and SnMasterBar=$snMaster");
        return Response::json(['masterInfo'=>$masterBargiriInfo,'status'=>"200 OK"]);
    }
    public function addFactorToBargiri(Request $request) {
        return 1;
        $factorsSn=$request->input("allFactors");
        $nameRanendah=$request->input("NameRanandeh");
        $mashinNo=$request->input("MashinNo");
        $datePeaper=$request->input("DatePeaper");
        $descPeaper=$request->input("DescPeaper");
        $snDriver=$request->input("SnDriver");
        $bargiri_SnAccBank=$request->input("Bargiri_SnAccBank");
        $bargiri_NoPayaneh=$request->input("Bargiri_NoPayaneh");
        $bargiri_VarizSnAccBank=$request->input("Bargiri_VarizSnAccBank");
        $noPaper=1;
        $lastPaperNo=DB::table('Shop.dbo.BargiriHDS')->where("FiscalYear",1402)->max("NoPaper");
        if($lastPaperNo){
            $lastPaperNo+=1;
            $noPaper=$lastPaperNo;
        }
        DB::table('Shop.dbo.BargiriHDS')->insert(["CompanyNo"=>5
                                                ,"FiscalYear"=>1402
                                                ,"NameRanandeh"=>"".$nameRanendah.""
                                                ,"MashinNo"=>"".$mashinNo.""
                                                ,"NoPaper"=>$noPaper
                                                ,"DatePeaper"=>"".$datePeaper.""
                                                ,"SnUser1"=>12
                                                ,"DescPeaper"=>"".$descPeaper.""
                                                ,"SnDriver"=>$snDriver
                                                ,"Bargiri_SnAccBank"=>$bargiri_SnAccBank
                                                ,"Bargiri_NoPayaneh"=>"".$bargiri_NoPayaneh.""
                                                ,"Bargiri_VarizSnAccBank"=>$bargiri_VarizSnAccBank]);
        $snMasterBar=1;
        $lastSnMasterBar=DB::table('Shop.dbo.BargiriHDS')->where("CompanyNo",5)->where("FiscalYear",1402)->max("SnMasterBar");
        if($lastSnMasterBar){
            $lastSnMasterBar+=1;
            $snMasterBar=$lastSnMasterBar;
        }
    foreach ($factorsSn as $snFact) {
        DB::table('Shop.dbo.BargiriBYS')->insert(
        ["CompanyNo"=>5
        ,"SnMaster"=>$snMasterBar
        ,"SnFact"=>$snFact
        ,"NaghdPrice"=>0
        ,"KartPrice"=>0
        ,"DifPrice"=>0
        ,"DescRec"=>""
        ,"VarizPrice"=>0
        ,"TakhfifPriceBar"=>0]);
    }
    return Response::json($factorsSn);
}
public function getFactorsInfoToBargiriTbl(Request $request) {
    
    $factorsSn=$request->input("allFactors");
    $allFactors=array();
    foreach ($factorsSn as $snFact) {
        $factorStuff=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE CompanyNo=5 and SerialNoHDS=$snFact");
        array_push($allFactors,$factorStuff);
    }
    return Response::json($allFactors);
}
}