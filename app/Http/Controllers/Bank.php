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
class Bank extends Controller {
    public function allBanks(Request $request){
        $bankKarts=DB::select("SELECT ab.SerialNoAcc,pb.SerialNoBSN,ab.AccNo, CONCAT(AccNo,' بانک '+NameBsn,' شعبه '+ab.branch)bsn from Shop.dbo.AccBanks ab Join SHop.dbo.PubBanks pb on SnBank=SerialNoBSN where ab.CompanyNo=5 and NameBsn!=''");
        return Response::json(['bankKarts'=>$bankKarts,'status'=>"200 OK"]);
    }
    public function getBankInfo(Request $request){
        $bankSn=$request->input("bankSn");
        $bankInfo=DB::select("SELECT * FROM (SELECT ab.SerialNoAcc,pb.SerialNoBSN,ab.AccNo, CONCAT(AccNo,' بانک '+NameBsn,' شعبه '+ab.branch)bsn FROM Shop.dbo.AccBanks ab JOIN SHop.dbo.PubBanks pb ON SnBank=SerialNoBSN WHERE ab.CompanyNo=5 AND NameBsn!='')a WHERE a.SerialNoAcc=$bankSn");
        return Response::json($bankInfo);
    }
    public function getAllShobeBanks(Request $request) {
        $shobes=DB::select("SELECT * FROM Shop.dbo.branch");
        return Response::json($shobes);
    }
    public function getBankList(Request $request){
        $bankList=DB::select("SELECT * FROM Shop.dbo.PubBanks WHERE CompanyNo=5 and NameBsn!=''");
        return Response::json($bankList);
    }
}