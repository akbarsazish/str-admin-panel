<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Cockie;
use DateTime;
use \Morilog\Jalali\Jalalian;
use Session;
use Carbon\Carbon;
class Box extends Controller{
    public function index() {
        $receives=DB::select("SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS WHERE GetOrPayHDS=1 AND FiscalYear=1402 AND CompanyNo=5 AND DocDate=FORMAT(dateadd(DAY,-1,GETDATE()),'yyyy/MM/dd','fa-ir')");
        $users=DB::select("SELECT * FROM Shop.dbo.Users WHERE CompanyNo=5");
        $infors=DB::select("SELECT * FROM Shop.dbo.Infors WHERE CompanyNo=5 AND TypeInfor=4");
        $fiscallYears=DB::select("SELECT * FROM Shop.dbo.FiscalYearList WHERE CompanyNo=5");
        $banks=DB::select("SELECT * FROM Shop.dbo.PubBanks WHERE CompanyNo=5 AND NameBsn!=''");
        return view('receive.receive', ['users'=>$users,'receives'=>$receives,'banks'=>$banks,'infors'=>$infors,'fiscallYears'=>$fiscallYears])->render();
    }
    function getGetAndPayBYS(Request $request) {
        $snGetAndPayHDS=$request->input("snGetAndPay");
        $getOrPayBYS=DB::select("SELECT *,NewStarfood.dbo.getGetAndPayBYSTypeName(DocTypeBYS) docTypeName,concat(NewStarfood.dbo.getGetAndPayBYSTypeName(DocTypeBYS),NewStarfood.dbo.getAccBankInfo(SnAccBank),' '+ ChequeDate)bankDesc FROM Shop.dbo.GetAndPayBYS WHERE SnHDS=$snGetAndPayHDS");
        return Response::json($getOrPayBYS);
    }
    function filterGetPays(Request $request)  {
        $darAmad=0;
        $daryaft=0;
        $firstNum=0;
        $secondNum=5000000;
        $firstDate='1398/01/01';
        $secondDate='1500/01/01';
        $QUERYPART='';
        $SETTERQUERY='';
        if($request->input("darAmad") and $request->input("daryaft")){
            $QUERYPART.='AND (DocTypeHDS=1 or DocTypeHDS=0)';
        }
        if(! $request->input("darAmad") and $request->input("daryaft")){
            $QUERYPART.='AND DocTypeHDS=1';
        }
        if($request->input("darAmad") and !$request->input("daryaft")){
            $QUERYPART.='AND DocTypeHDS=0';
        }
        if(strlen($request->input("firstDate"))>3){
            $firstDate=$request->input("firstDate");
        }
        if(strlen($request->input("secondDate"))>3){
            $secondDate=$request->input("secondDate");
        }
        $getOrPay=$request->input("getOrPay");
        if(strlen($request->input("firstNum"))>0){
            $firstNum=$request->input("firstNum");
        }
        if(strlen($request->input("secondNum"))>0){
            $secondNum=$request->input("secondNum");
        }
        $PCODEQUERY='';
        $pCode=$request->input("pCode");
        if(strlen($pCode)>0){
            $PCODEQUERY="AND PCode =$pCode";
        }
        $name=$request->input("name");
        $setterSn=$request->input("setterSn");
        if(strlen($setterSn)>0){
            $SETTERQUERY="AND SnUser=$setterSn";
        }
        $groupId=$request->input("groupId");

        $receives=DB::select("SELECT * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE  DocNoHDS>=$firstNum AND DocNoHDS<=$secondNum $SETTERQUERY AND FiscalYear=1402 AND GetOrPayHDS=$getOrPay AND CompanyNo=5 $QUERYPART $PCODEQUERY AND DocDate>='$firstDate' AND DocDate<='$secondDate' AND Name LIKE '%$name%'");
        return Response::json($receives);
    }

    function getSandoghs(Request $request) {
        $userId=$request->input("userId");
        $sandoghes=DB::select("SELECT * FROM Shop.dbo.Cashes WHERE CompanyNo=5 AND CashName!='' AND SNCash<920");
        return response()->json($sandoghes, 200);
    }

    function addDaryaft(Request $request) {
        return Response::json($request->all());
    }
}