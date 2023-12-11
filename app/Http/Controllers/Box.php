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
        return view('getAndPay.receive', ['users'=>$users,'receives'=>$receives,'banks'=>$banks,'infors'=>$infors,'fiscallYears'=>$fiscallYears])->render();
    }

  public function pays() {
    $pays=DB::select("SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS WHERE GetOrPayHDS=2 AND FiscalYear=1402 AND CompanyNo=5 AND DocDate=FORMAT(dateadd(DAY,-1,GETDATE()),'yyyy/MM/dd','fa-ir')");
    $users=DB::select("SELECT * FROM Shop.dbo.Users WHERE CompanyNo=5");
    $infors=DB::select("SELECT * FROM Shop.dbo.Infors WHERE CompanyNo=5 AND TypeInfor=4");
    $fiscallYears=DB::select("SELECT * FROM Shop.dbo.FiscalYearList WHERE CompanyNo=5");
    $banks=DB::select("SELECT * FROM Shop.dbo.PubBanks WHERE CompanyNo=5 AND NameBsn!=''");
        return view('getAndPay.pays', ['users'=>$users,'pays'=>$pays,'banks'=>$banks,'infors'=>$infors,'fiscallYears'=>$fiscallYears])->render();
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
        $sn=$request->input("byss");
        $cashMasterId=0;
        $snPeopel=3609;
        $daryaftType=0;

        
        $byss=$request->input("byss");
        $addDaryaftDate=$request->input("addDaryaftDate");
        
        if($request->input("customerId")){
            $snPeopel=$request->input("customerId");
        }
        
        if($request->input("daryaftType")==1){
            $daryaftType=$request->input("daryaftType");
            $snPeopel=0;
        }else{
            $snPeopel=$request->input("customerId");
        }
    
        
        $daryaftHdsDesc=$request->input("daryaftHdsDesc");
        $inforTypeDaryaft=0;
        

        if($request->input("inforTypeDaryaft")){
            $inforTypeDaryaft=$request->input("inforTypeDaryaft");
        }
        
        $netPriceHDS=0;
        if($request->input("netPriceHDS")){
            $netPriceHDS=$request->input("netPriceHDS");
        }
        
        if($request->input("sandoghIdDar")){
            $cashMasterId=$request->input("sandoghIdDar");
        }
        
        $snHDS=0;
        
        $docNoHDS=0;
        
       
        $docNoHDS=DB::table("Shop.dbo.GetAndPayHDS")->where("GetOrPayHDS",1)->max("DocNoHDS");
       //return Response::json($request->all());
        DB::table("Shop.dbo.GetAndPayHDS")->insert(["CompanyNo"=>5
                                                    ,"GetOrPayHDS"=>1
                                                    ,"DocNoHDS"=>($docNoHDS+1)
                                                    ,"DocDate"=>"$addDaryaftDate"
                                                    ,"DocDescHDS"=>"$daryaftHdsDesc"
                                                    ,"StatusHDS"=>0 //should be added
                                                    ,"PeopelHDS"=>$snPeopel
                                                    ,"FiscalYear"=>1402
                                                    ,"InForHDS"=>$inforTypeDaryaft
                                                    ,"NetPriceHDS"=>0
                                                    ,"DocTypeHDS"=>$daryaftType
                                                    ,"SnCashMaster"=>$cashMasterId
                                                    ,"SnUser"=>12]);

        $snHDS=DB::table("Shop.dbo.GetAndPayHDS")->max("SerialNoHDS");
        
        foreach ($byss as $bysNumber) {
            $accBankNo=0;
            $cashNo=0;
            $chequeDate="";
            $chequeNo=0;
            $docDescBys="";
            $docTypeBys=0;
            $noPayanehKartKhanBYS="";
            $owener="";
            $price=0;
            $snAccBank=0;
            $snBank=0;
            $snChequeBook=0;
            $snPeopelPay=0;
            $statusBYS=0;

            if($request->input("AccBankNo".$bysNumber)){
                $accBankNo=$request->input("AccBankNo".$bysNumber);
            }

            if($request->input("CashNo".$bysNumber)){
                $cashNo=$request->input("CashNo".$bysNumber);
            }

            if($request->input("ChequeDate".$bysNumber)){
                $chequeDate=$request->input("ChequeDate".$bysNumber);
            }

            if($request->input("ChequeNo".$bysNumber)){
                $chequeNo=$request->input("ChequeNo".$bysNumber);
            }

            if($request->input("DocDescBys".$bysNumber)){
                $docDescBys=$request->input("DocDescBys".$bysNumber);
            }

            if($request->input("DocTypeBys".$bysNumber)){
                $docTypeBys=$request->input("DocTypeBys".$bysNumber);
            }

            if($request->input("NoPayanehKartKhanBYS".$bysNumber)){
                $noPayanehKartKhanBYS=$request->input("NoPayanehKartKhanBYS".$bysNumber);
            }

            if($request->input("Owener".$bysNumber)){
                $owener=$request->input("Owener".$bysNumber);
            }

            if($request->input("Price".$bysNumber)){
                $price=$request->input("Price".$bysNumber);
            }

            if($request->input("SnAccBank".$bysNumber)){
                $snAccBank=$request->input("SnAccBank".$bysNumber);
            }

            if($request->input("SnBank".$bysNumber)){
                $snBank=$request->input("SnBank".$bysNumber);
            }

            if($request->input("SnChequeBook".$bysNumber)){
                $snChequeBook=$request->input("SnChequeBook".$bysNumber);
            }
            
            if($request->input("SnPeopelPay".$bysNumber)){
                $snPeopelPay=$request->input("SnPeopelPay".$bysNumber);
            }
            
            DB::table("Shop.dbo.GetAndPayBYS")->insert(["CompanyNo"=>5
                                                        ,"DocTypeBYS"=>$docTypeBys
                                                        ,"Price"=>$price
                                                        ,"ChequeDate"=>"$chequeDate"
                                                        ,"ChequeNo"=>$chequeNo
                                                        ,"AccBankno"=>$accBankNo
                                                        ,"Owner"=>"$owener"
                                                        ,"SnBank"=>$snBank
                                                        ,"Branch"=>""//should be added
                                                        ,"SnChequeBook"=>$snChequeBook
                                                        ,"FiscalYear"=>1402
                                                        ,"SnHDS"=>$snHDS
                                                        ,"DocDescBYS"=>"$docDescBys"
                                                        ,"StatusBYS"=>$statusBYS
                                                        ,"SnAccBank"=>$snAccBank
                                                        ,"CashNo"=>$cashNo
                                                        ,"NoPayaneh_KartKhanBys"=>"$noPayanehKartKhanBYS"
                                                        ,"KarMozdPriceBys"=>0 //should be added
                                                        ,"NoSayyadi"=>""//should be added
                                                        ,"NameSabtShode"=>"" //should be added
                                                        ,"SnPeopelPay"=>0// should be added
                                                    ]);

        }

        return Response::json("دیتا موفقانه ثبت شد!");
    }

    function getGetAndPayInfo(Request $request){

        $snGetAndPayHDS=$request->input("snGetAndPay");
        // return Response::json($request->all());

        $getAndPay=DB::select("SELECT *,NewStarfood.dbo.getFactNo(SnFactForTasviyeh)FactNo,SHop.dbo.FuncPeopelName(PeopelHDS,5)Name,SHop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncInforCode(InForHDS,4,5)INforCode FROM Shop.dbo.GetAndPayHDS WHERE SerialNoHDS=$snGetAndPayHDS");
        $getAndPayBYS=DB::select("SELECT *,concat(NewStarfood.dbo.getGetAndPayBYSTypeName(DocTypeBYS),NewStarfood.dbo.getAccBankInfo(SnAccBank),' '+ ChequeDate)bankDesc FROM Shop.dbo.GetAndPayBYS WHERE SnHDS=$snGetAndPayHDS");
        $getAndPay[0]->BYS=$getAndPayBYS;
        
        return Response::json(['response'=>$getAndPay]);
    }

    function deleteGetAndPayBYSBtn(Request $request) {

        $snHDS=$request->input("snHDS");
        
    }
    function getAndPayHistory(Request $request)  {
        $historyFlag=$request->input("historyFlag");
        $getOrPay=$request->input("getOrPay");
        $getAndPays=array();
        switch ($historyFlag) {
            case 'YESTERDAY':
                {
                    $getAndPays=DB::select("SELECT * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE GetOrPayHDS=$getOrPay AND DocDate=Format(dateadd(day,-1,GetDate()),'yyyy/MM/dd','fa-ir')");
                    
                }
                break;
            case 'TODAY':
                {
                    $getAndPays=DB::select("SELECT * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE GetOrPayHDS=$getOrPay AND DocDate=Format(GetDate(),'yyyy/MM/dd','fa-ir')");
                }
                break;
            case 'TOMORROW':
                {
                    $getAndPays=DB::select("SELECT * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE GetOrPayHDS=$getOrPay AND DocDate=Format(dateadd(day,1,GetDate()),'yyyy/MM/dd','fa-ir')");
                    
                }
                break;
            case 'AFTERTOMORROW':
                {
                    $getAndPays=DB::select("SELECT * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE GetOrPayHDS=$getOrPay AND DocDate=Format(dateadd(day,2,GetDate()),'yyyy/MM/dd','fa-ir')");

                }
                break;
            case 'HUNDRED':
                {
                    $getAndPays=DB::select("SELECT TOP 100 * FROM (SELECT *,NewStarfood.dbo.getCashName(SnCashMaster)cashName,Shop.dbo.FuncPeopelCode(PeopelHDS,5)PCode,Shop.dbo.FuncUserName(SnUser)userName,Shop.dbo.FuncPeopelName(PeopelHDS,5)Name FROM SHop.dbo.GetAndPayHDS)a WHERE GetOrPayHDS=$getOrPay order by DocDate desc");
                    
                }
            break;
        }
        return response()->json($getAndPays);

    }
    public function getBYSInfo(Request $request) {
        $snBYS=$request->input("SerialNoBYS");
        $BYS=DB::select("SELECT * FROM Shop.dbo.GetAndPayBYS WHERE SerialNoBYS=$snBYS");
        return Response::json(['response'=>$BYS]);
    }
}