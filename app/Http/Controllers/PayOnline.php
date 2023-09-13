<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use Response;
use Session;
use Cockie;
use DateTime;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
class PayOnline extends Controller {

    public function index(Request $request)
    {
        $pays=DB::select("SELECT SerialNoHDS,id, Name,PSN,payedMoney,FactNo,FORMAT(payedOnline.TimeStamp,'yyyy/0M/0d','FA-IR') AS payedDate,
							payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) AS TimeStamp FROM NewStarfood.dbo.payedOnline
							JOIN Shop.dbo.FactorHDS ON payedOnline.factorSn=FactorHDS.SerialNoHDS
							JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN WHERE CONVERT(DATE,payedOnline.TimeStamp)=CONVERT(DATE,current_timestamp)");

        return view("payOnline.payedOnline",['pays'=>$pays]);
    }
	
    public function filterPayedOnline(Request $request)
    {
        $payState=$request->get("payState");
        $fromDate='1401/01/01';
        if(strlen($request->get("fromDate"))>3){
            $fromDate=$request->get("fromDate");
        }
        $toDate='1500/01/01';
        if(strlen($request->get("toDate"))>3){
            $toDate=$request->get("toDate");
        }
        $pCodeName=$request->get("PCodeName");

        $pays=DB::select("SELECT SerialNoHDS,id, Name,PSN,payedMoney,FactNo,FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR') as payedDate,
							payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) as TimeStamp from NewStarfood.dbo.payedOnline
							JOIN Shop.dbo.FactorHDS ON payedOnline.factorSn=FactorHDS.SerialNoHDS JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN
							WHERE (Name like '%$pCodeName%' OR PCode like '%$pCodeName%') and FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')>='$fromDate' 
							AND FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')<='$toDate' AND isSent like '%$payState%' order by payedDate desc");
							
        return Response::json($pays);
    }
	
	public function getPayOnlineHistory(Request $request){
		$dayDate=$request->get("dayDate");
		$pays=array();
		if( $dayDate == "TODAY" ){
			$pays=DB::select("SELECT SerialNoHDS,id, Name,PSN,payedMoney,FactNo,FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')
					as payedDate,payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) as TimeStamp
					from NewStarfood.dbo.payedOnline JOIN Shop.dbo.FactorHDS ON
					payedOnline.factorSn=FactorHDS.SerialNoHDS
					JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN WHERE
					convert(date,payedOnline.TimeStamp)=convert(date,current_timestamp)");
		}
		if( $dayDate == "YESTERDAY" ){
					$pays=DB::select("SELECT SerialNoHDS,id, Name,PSN,payedMoney,FactNo,FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')
					as payedDate,payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) as TimeStamp
					from NewStarfood.dbo.payedOnline JOIN Shop.dbo.FactorHDS ON
					payedOnline.factorSn=FactorHDS.SerialNoHDS
					JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN WHERE
					convert(date,payedOnline.TimeStamp)=dateadd(day,-1,convert(date,current_timestamp))");
		}
		if( $dayDate == "LASTHUNDRED" ){
					$pays=DB::select("SELECT top 100 SerialNoHDS,id, Name,PSN,payedMoney,FactNo,
					FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')
					as payedDate,payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) as TimeStamp
					from NewStarfood.dbo.payedOnline JOIN Shop.dbo.FactorHDS ON
					payedOnline.factorSn=FactorHDS.SerialNoHDS
					JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN ORDER BY payedOnline.TimeStamp desc");
		}
		if( $dayDate == "ALL" ){
					$pays=DB::select("SELECT SerialNoHDS,id, Name,PSN,payedMoney,FactNo,FORMAT(payedOnline.TimeStamp,'yyyy/MM/dd','FA-IR')
					as payedDate,payedOnline.isSent,Convert(VARCHAR(10),payedOnline.TimeStamp,8) as TimeStamp
					from NewStarfood.dbo.payedOnline JOIN Shop.dbo.FactorHDS ON
					payedOnline.factorSn=FactorHDS.SerialNoHDS
					JOIN SHop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN  ORDER BY payedOnline.TimeStamp desc");
		}
		
		return Response::json($pays);
	}

    public function getPaymentInfo(Request $request)
    {
        $inVoiceNumber=$request->get("InVoiceNumber");
        $paymentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_paymentResponds WHERE =$inVoiceNumber");
        return Response::json($paymentInfo);
    }
}