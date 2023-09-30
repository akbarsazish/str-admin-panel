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
        $masterBargiriInfo=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(PSN)PhoneStr FROM Shop.dbo.BargiryHDS H JOIN Shop.dbo.BargiryBYS B ON H.SnMasterBar=B.SnMaster JOIN Shop.dbo.FactorHDS F ON F.SerialNoHDS=B.SnFact JOIN Shop.dbo.Peopels P ON F.CustomerSn=P.PSN  WHERE H.CompanyNo=5 AND SnMasterBar=$snMaster");
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
            $factorStuff=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(PSN)PhoneStr FROM Shop.dbo.FactorHDS F join Shop.dbo.Peopels P on CustomerSn=PSN
            join Shop.dbo.BargiryBYS B on SnFact=SerialNoHDS
            WHERE F.CompanyNo=5 and SerialNoHDS=$snFact");
            array_push($allFactors,$factorStuff);
        }
        return Response::json($allFactors);
    }
    public function addFactorsToBargiri(Request $request) {
        $factorsSn;
        $mashinNo="";
        $datePeaper="";
        $descPeaper="";
        $bargiri_NoPayaneh="";
        $bargiri_VarizSnAccBank="";
        $bargiri_SnAccBank=0;
        $noPaper=1;
        $snUser1=21;
        $snDriver=1;
        if($request->input("FactSns")){
            $factorsSn=$request->input("FactSns");
        }
        if($request->input("MashinNo")){
            $mashinNo=$request->input("MashinNo");
        }
        
        if($request->input("DatePaper")){
            $datePeaper=$request->input("DatePaper");
        }
        if($request->input("DescPeaper")){
            $descPeaper=$request->input("DescPeaper");
        }
        if($request->input("factorDriver")){
            $snDriver=$request->input("factorDriver");
        }
        if($request->input("Bargiri_SnAccBank")){
            $bargiri_SnAccBank=$request->input("Bargiri_SnAccBank");
        }
        if($request->input("Bargiri_NoPayaneh")){
            $bargiri_NoPayaneh=$request->input("Bargiri_NoPayaneh");
        }
        if($request->input("Bargiri_VarizSnAccBank")){
            $bargiri_VarizSnAccBank=$request->input("Bargiri_VarizSnAccBank");
        }
        
        $snMasterBar=1;
        $maxPaperNo=DB::table('Shop.dbo.BargiryHDS')->where("CompanyNo",5)->max("NoPaper");
        if($maxPaperNo>0){
            $noPaper=$maxPaperNo+1;
        }
        DB::table("Shop.dbo.BargiryHDS")->insert(
            ["CompanyNo"=>5
            ,"FiscalYear"=>1402
            ,"NameRanandeh"=>""
            ,"MashinNo"=>"".$mashinNo.""
            ,"NoPaper"=>$noPaper
            ,"DatePeaper"=>"".$datePeaper.""
            ,"SnUser1"=>$snUser1
            ,"DescPeaper"=>"".$descPeaper.""
            ,"SnDriver"=>$snDriver
            ,"Bargiri_SnAccBank"=>$bargiri_SnAccBank
            ,"Bargiri_NoPayaneh"=>$bargiri_NoPayaneh
            ,"Bargiri_VarizSnAccBank"=>$bargiri_VarizSnAccBank]);
        $maxMasterBar=DB::table("Shop.dbo.BargiryHDS")->max("SnMasterBar");
        if($maxMasterBar>0){
            $snMasterBar=$maxMasterBar;
        }
        foreach($factorsSn as $factSn){
            DB::table("Shop.dbo.BargiryBYS")->insert(["CompanyNo"=>5
                                                    ,"SnMaster"=>$snMasterBar
                                                    ,"SnFact"=>$factSn
                                                    ,"NaghdPrice"=>0
                                                    ,"KartPrice"=>0
                                                    ,"DifPrice"=>0
                                                    ,"DescRec"=>""
                                                    ,"VarizPrice"=>0
                                                    ,"TakhfifPriceBar"=>0]);
        }
        $todayDrivers=DB::select("SELECT NewStarfood.dbo.getDriverName(SnDriver)driverName,* FROM Shop.dbo.BargiryHDS WHERE CompanyNo=5 order by DatePeaper desc");
        return Response::json(["todayDrivers"=>$todayDrivers]);
    }

    public function doEditBargiriFactors(Request $request) {
        $factorsSn;
        $mashinNo="";
        $datePeaper="";
        $descPeaper="";
        $bargiri_NoPayaneh="";
        $bargiri_VarizSnAccBank="";
        $bargiri_SnAccBank=0;
        $noPaper=$request->input("NoPaper");
        $snMasterBar=$request->input("SnMasterBar");
        $snUser1=21;
        $snDriver=1;
        if($request->input("FactSnsEdit")){
            $factorsSn=$request->input("FactSnsEdit");
        }
        if($request->input("MashinNo")){
            $mashinNo=$request->input("MashinNo");
        }
        
        if($request->input("DatePaper")){
            $datePeaper=$request->input("DatePaper");
        }
        if($request->input("DescPeaper")){
            $descPeaper=$request->input("DescPeaper");
        }
        if($request->input("factorDriver")){
            $snDriver=$request->input("factorDriver");
        }
        if($request->input("Bargiri_SnAccBank")){
            $bargiri_SnAccBank=$request->input("Bargiri_SnAccBank");
        }
        if($request->input("Bargiri_NoPayaneh")){
            $bargiri_NoPayaneh=$request->input("Bargiri_NoPayaneh");
        }
        if($request->input("Bargiri_VarizSnAccBank")){
            $bargiri_VarizSnAccBank=$request->input("Bargiri_VarizSnAccBank");
        }
        
        DB::table("Shop.dbo.BargiryHDS")->where("SnMasterBar",$snMasterBar)->update(
            ["CompanyNo"=>5
            ,"FiscalYear"=>1402
            ,"NameRanandeh"=>""
            ,"MashinNo"=>"".$mashinNo.""
            ,"NoPaper"=>$noPaper
            ,"DatePeaper"=>"".$datePeaper.""
            ,"SnUser1"=>$snUser1
            ,"DescPeaper"=>"".$descPeaper.""
            ,"SnDriver"=>$snDriver
            ,"Bargiri_SnAccBank"=>$bargiri_SnAccBank
            ,"Bargiri_NoPayaneh"=>$bargiri_NoPayaneh
            ,"Bargiri_VarizSnAccBank"=>$bargiri_VarizSnAccBank]);

        foreach($factorsSn as $factSn){
            DB::table("Shop.dbo.BargiryBYS")->insert(["CompanyNo"=>5
                                                    ,"SnMaster"=>$snMasterBar
                                                    ,"SnFact"=>$factSn
                                                    ,"NaghdPrice"=>0
                                                    ,"KartPrice"=>0
                                                    ,"DifPrice"=>0
                                                    ,"DescRec"=>""
                                                    ,"VarizPrice"=>0
                                                    ,"TakhfifPriceBar"=>0]);
        }
        $todayDrivers=DB::select("SELECT NewStarfood.dbo.getDriverName(SnDriver)driverName,* FROM Shop.dbo.BargiryHDS WHERE CompanyNo=5 order by DatePeaper desc");
        return Response::json(["todayDrivers"=>$todayDrivers]);      
    }
    public function deleteBargiriHDS(Request $request) {
        $snMasterBar=$request->input("SnMasterBar");
        DB::table("Shop.dbo.BargiryBYS")->where("SnMaster",$snMasterBar)->delete();
        DB::table("Shop.dbo.BargiryHDS")->where("SnMasterBar",$snMasterBar)->delete();
        $todayDrivers=DB::select("SELECT NewStarfood.dbo.getDriverName(SnDriver)driverName,* FROM Shop.dbo.BargiryHDS WHERE CompanyNo=5 order by DatePeaper desc");
      
        return Response::json(["todayDrivers"=>$todayDrivers]);
    }

}