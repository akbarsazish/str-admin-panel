<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Response;
use Session;
use URL;
use DateTime;
use \Morilog\Jalali\Jalalian;
use Carbon\Carbon;
class TakhfifCode extends Controller{

    public function index(){
        $customerId=Session::get("psn");
                // گیمر لیست کیوری
        $player=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(posId) AS PhoneStr,CRM.dbo.getGameName(gameId) AS GameName FROM (
                SELECT Row,Name,posId,PosName,CONVERT(DATE,a.timestamp) AS timestamp,gameId FROM (
                SELECT ROW_NUMBER() 
                                OVER (ORDER BY id)  AS Row,id,PosName,
                posId,gameId,timestamp
                FROM NewStarfood.dbo.star_game_history
                
                UNPIVOT
                (
                posId
                FOR PosName IN (firstPosId,secondPosId,thirdPosId,fourthPosId,fifthPosId,sixthPosId,seventhPosId,eightPosId,ninthPosId,teenthPosId)
                ) UNPIV
                
                )a 
                
                JOIN Shop.dbo.Peopels ON a.posId=PSN
                
                WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history)
                )b JOIN 
                (
                SELECT * FROM(
                SELECT Row,PrizeName,prize FROM (
                SELECT ROW_NUMBER() OVER (ORDER BY id)  AS Row,id,PrizeName,
                prize
                FROM NewStarfood.dbo.star_game_history
                
                UNPIVOT
                (
                prize
                FOR PrizeName IN (firstPrize,secondPrize,thirdPrize,fourthPrize,fifthPrize,sixthPrize,seventhPrize,eightthPrize,ninthPrize,teenthPrize)
                ) UNPIV
                )a WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history)
                )c )d ON b.Row=d.Row where posId=$customerId and prize>0");
        $prizes=DB::select("SELECT CONVERT(DATE,timestam) AS lastTryDate,Name,CRM.dbo.getCustomerPhoneNumbers(PSN) PhoneStr
                                            ,id,PSN,wonPrize,Istaken,customerId,CONVERT(DATE,tasviyahDate) AS tasviyahDate
                                            FROM NewStarfood.dbo.star_TryLottery JOIN Shop.dbo.Peopels ON customerId=PSN
                                            WHERE customerId=$customerId");
        $takhfifCodes=DB::select("SELECT *,CONVERT(DATE,AssignDate) AS assignedDate FROM NewStarfood.dbo.star_takhfifCodeAssign 
                                    JOIN NewStarfood.dbo.star_SMSModel ON CodeId=Id
                                    WHERE customerId=$customerId");
        $disCountCodes=DB::select("SELECT * FROM NewStarfood.dbo.star_takhfifCodeAssign
        JOIN NewStarfood.dbo.star_SMSModel on CodeId=Id where CustomerId=$customerId");
        // برای توسی کردن هستوری تخفیفات.
        $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerId");
        if(count($attractionVisit)<1){
            DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerId
                                                                       ,"Game" => 0
                                                                       ,"MoneyCase" => 0
                                                                       ,"Discount" => 1
                                                                       ,"StarfoodStar" => 0
                                                                       ,"ViewDate" => new DateTime()]);
        }else{
            DB::table("NewStarfood.dbo.star_attractionVisit")
                ->where("CustomerId",$customerId)
                ->update(["Discount" => 1,"ViewDate" => new DateTime()]);
    
        }
        return view('takhfifCode.discountAndPrize',['disCountCodes'=>$disCountCodes,'prizes'=>$prizes,'player'=>$player,'takhfifCodes'=>$takhfifCodes]);
    }

    public function getTakhfifAndPrize(Request $request){
        $customerId=$request->input("psn");
                // گیمر لیست کیوری
        $prizes=DB::select("SELECT CONVERT(DATE,timestam) AS lastTryDate,Name,CRM.dbo.getCustomerPhoneNumbers(PSN) PhoneStr
                                            ,id,PSN,wonPrize,Istaken,customerId,CONVERT(DATE,tasviyahDate) AS tasviyahDate
                                            FROM NewStarfood.dbo.star_TryLottery JOIN Shop.dbo.Peopels ON customerId=PSN
                                            WHERE customerId=$customerId");
        $takhfifCodes=DB::select("SELECT *,CONVERT(DATE,AssignDate) AS assignedDate FROM NewStarfood.dbo.star_takhfifCodeAssign 
                                    JOIN NewStarfood.dbo.star_SMSModel ON CodeId=Id
                                    WHERE customerId=$customerId");

        // برای توسی کردن هستوری تخفیفات.
        $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerId");
        if(count($attractionVisit)<1){
            DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerId
                                                                       ,"Game" => 0
                                                                       ,"MoneyCase" => 0
                                                                       ,"Discount" => 1
                                                                       ,"StarfoodStar" => 0
                                                                       ,"ViewDate" => new DateTime()]);
        }else{
            DB::table("NewStarfood.dbo.star_attractionVisit")
                ->where("CustomerId",$customerId)
                ->update(["Discount" => 1,"ViewDate" => new DateTime()]);
    
        }
        return Response::json(['prizes'=>$prizes,'takhfifCodes'=>$takhfifCodes]);
    }
	
    public function getTakhfifCodeHistory(Request $request){
		$smsModels=DB::table("NewStarfood.dbo.star_SMSModel")->get();
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE FatherMNM=79");
        $customerStates=DB::select("SELECT * FROM CRM.dbo.crm_customerState");
		$smsHistory=DB::select("SELECT * FROM (SELECT * ,FORMAT(AddedTime,'yyyy/MM/dd','fa-ir') AS HijriDate
									FROM(SELECT count(NewStarfood.dbo.star_SMSHistory.SMSHistorySn) AS countSent,ModelSn
									,Format(convert(date,SabtTime),'yyyy-MM-dd','fa-ir') as sabtDate FROM
									NewStarfood.dbo.star_SMSHistory GROUP BY ModelSn,Format(convert(date,SabtTime),'yyyy-MM-dd','fa-ir') )A 
									INNER JOIN (SELECT *  FROM NewStarfood.dbo.star_SMSModel)B ON A.ModelSn=B.Id)B 
									LEFT JOIN (select count(CodeAssingSn) as countUsed,CodeId
									,Format(convert(date,AssignDate),'yyyy-MM-dd','fa-ir') as AssignDate
									FROM NewStarfood.dbo.star_takhfifCodeAssign  GROUP BY CodeId,
									Format(convert(date,AssignDate),'yyyy-MM-dd','fa-ir'))C
									on B.ModelSn=C.CodeId and B.sabtDate=C.AssignDate");
        return view('takhfifCode.discountCode',['smsModels'=>$smsModels,'smsHistory'=>$smsHistory,'cities'=>$cities,'customerStates'=>$customerStates]);
    }
	
	public function removeNotify(Request $request){
        
		DB::table("NewStarfood.dbo.star_takhfifCodeAssign")->where("isUsed",1)->update(["isSeen"=>1]);
		return Response::json(1);
	}
	
	public function getTakhfifCodeHistoryByDate(Request $request){

		$firstDate=$request->get("firstDate");

		$secondDate=$request->get("secondDate");

		if(strlen($firstDate)<3){
			$firstDate="1401-01-01";
		}

		if(strlen($secondDate)<3){
			$secondDate="1505-01-01";
		}

		$smsHistory=DB::select("SELECT * FROM (SELECT * ,FORMAT(AddedTime,'yyyy/MM/dd','fa-ir') AS HijriDate
                                FROM(SELECT count(NewStarfood.dbo.star_SMSHistory.SMSHistorySn) AS countSent,ModelSn
                                ,Format(convert(date,SabtTime),'yyyy-MM-dd','fa-ir') as sabtDate FROM
                                NewStarfood.dbo.star_SMSHistory GROUP BY ModelSn,Format(convert(date,SabtTime),'yyyy-MM-dd','fa-ir') )A 
                                INNER JOIN (SELECT * FROM NewStarfood.dbo.star_SMSModel)B ON A.ModelSn=B.Id)B 
                                LEFT JOIN (select count(CodeAssingSn) as countUsed,CodeId
                                ,Format(convert(date,AssignDate),'yyyy-MM-dd','fa-ir') as AssignDate
                                FROM NewStarfood.dbo.star_takhfifCodeAssign  GROUP BY CodeId,
                                Format(convert(date,AssignDate),'yyyy-MM-dd','fa-ir'))C
                                on B.ModelSn=C.CodeId and B.sabtDate=C.AssignDate
                                WHERE sabtDate>='$firstDate' and sabtDate<='$secondDate'");
		return Response::json($smsHistory);
	}
	
	public function addTakhfifCodeModel(Request $request){
		$code=$request->get("code");
		$modelName=$request->get("modelName");
		$useDays=$request->get("useDays");
		$money=$request->get("money");
		
		$firstText=$request->get("firstText");
		$firstSelect=$request->get("firstSelect");
		$firstNLine=$request->get("firstNLine");
		
		$secondText=$request->get("secondText");
		$secondSelect=$request->get("secondSelect");
		$secondNLine=$request->get("secondNLine");
		
		$thirdText=$request->get("thirdText");
		$thirdSelect=$request->get("thirdSelect");

		$thirdCurrency=$request->get("Currency");
		$firstCurrency=$request->get("firstCurrency");
		$secondCurrency=$request->get("secondCurrency");
		$fourthCurrency=$request->get("fourthCurrency");
		$fifthCurrency=$request->get("fifthCurrency");
		$sixthCurrency=$request->get("sixthCurrency");

		$thirdNLine=$request->get("thirdNLine");
		
		$fourthText=$request->get("fourthText");
		$fourthSelect=$request->get("fourthSelect");
		$fourthNLine=$request->get("fourthNLine");
		
		$fifthText=$request->get("fifthText");
		$fifthSelect=$request->get("fifthSelect");
		$fifthNLine=$request->get("fifthNLine");
		
		$sixthText=$request->get("sixthText");
		$sixthSelect=$request->get("sixthSelect");
		$sixthNLine=$request->get("sixthNLine");

		$seventhText=$request->get("seventhText");
		
		DB::table("NewStarfood.dbo.star_SMSModel")->insert(["Code"=>"".$code.""
        ,"ModelName"=>"".$modelName.""
        ,"Money"=>$money
        ,"UseDays"=>$useDays
        ,"FstText"=>"".$firstText.""
        ,"FstSelect"=>"".$firstSelect.""
        ,"FstNLine"=>"".$firstNLine.""
        ,"SecText"=>"".$secondText.""
        ,"SecSelect"=>"".$secondSelect.""
        ,"SecNLine"=>"".$secondNLine.""
        ,"ThirdText"=>"".$thirdText.""
        ,"ThirdSelect"=>"".$thirdSelect.""
        ,"ThirdCurrency"=>"".$thirdCurrency.""
        ,"ThirdNLine"=>"".$thirdNLine.""
        ,"FourText"=>"".$fourthText.""
        ,"FourSelect"=>"".$fourthSelect.""
        ,"FourNLine"=>"".$fourthNLine.""
        ,"FiveText"=>"".$fifthText.""
        ,"FiveSelect"=>"".$fifthSelect.""
        ,"FiveNLine"=>"".$fifthNLine.""
        ,"SixText"=>"".$sixthText.""
        ,"SixSelect"=>"".$sixthSelect.""
        ,"SixNLine"=>"".$sixthNLine.""
        ,"SevenText"=>"".$seventhText.""
        ,"SevenSelect"=>"".''.""
        ,"SevenNLine"=>"".''.""
        ,"EightText"=>"".''.""
        ,"EightSelect"=>"".''.""
        ,"EightNLine"=>"".''.""
        ,"FstCurrency"=>"".$firstCurrency.""
        ,"SecCurrency"=>"".$secondCurrency.""
        ,"FourCurrency"=>"".$fourthCurrency.""
        ,"FiveCurrency"=>"".$fifthCurrency.""
        ,"SixCurrency"=>"".$sixthCurrency.""]);
		$models=DB::table("NewStarfood.dbo.star_SMSModel")->get();
		return Response::json($models);
	}
	
	public function updateTakhfifCodeModel(Request $request){
		$code=$request->get("code");
		$modelName=$request->get("modelName");
		$useDays=$request->get("useDays");
		$money=$request->get("money");
		$modelSn=$request->get("modelId");
		$firstText=$request->get("firstText");
		$firstSelect=$request->get("firstSelect");
		$firstNLine=$request->get("firstNLine");
		
		$secondText=$request->get("secondText");
		$secondSelect=$request->get("secondSelect");
		$secondNLine=$request->get("secondNLine");
		
		$thirdText=$request->get("thirdText");
		$thirdSelect=$request->get("thirdSelect");

		$thirdCurrency=$request->get("Currency");
		$firstCurrency=$request->get("firstCurrency");
		$secondCurrency=$request->get("secondCurrency");
		$thirdCurrency=$request->get("thirdCurrency");
		$fourthCurrency=$request->get("fourthCurrency");
		$fifthCurrency=$request->get("fifthCurrency");
		$sixthCurrency=$request->get("sixthCurrency");

		$thirdNLine=$request->get("thirdNLine");
		
		$fourthText=$request->get("fourthText");
		$fourthSelect=$request->get("fourthSelect");
		$fourthNLine=$request->get("fourthNLine");
		
		$fifthText=$request->get("fifthText");
		$fifthSelect=$request->get("fifthSelect");
		$fifthNLine=$request->get("fifthNLine");
		
		$sixthText=$request->get("sixthText");
		$sixthSelect=$request->get("sixthSelect");
		$sixthNLine=$request->get("sixthNLine");

		$seventhText=$request->get("seventhText");
		
		DB::table("NewStarfood.dbo.star_SMSModel")->where("Id",$modelSn)->update(["Code"=>"".$code.""
        ,"ModelName"=>"".$modelName.""
        ,"Money"=>$money
        ,"UseDays"=>$useDays
        ,"FstText"=>"".$firstText.""
        ,"FstSelect"=>"".$firstSelect.""
        ,"FstNLine"=>"".$firstNLine.""
        ,"SecText"=>"".$secondText.""
        ,"SecSelect"=>"".$secondSelect.""
        ,"SecNLine"=>"".$secondNLine.""
        ,"ThirdText"=>"".$thirdText.""
        ,"ThirdSelect"=>"".$thirdSelect.""
        ,"ThirdCurrency"=>"".$thirdCurrency.""
        ,"ThirdNLine"=>"".$thirdNLine.""
        ,"FourText"=>"".$fourthText.""
        ,"FourSelect"=>"".$fourthSelect.""
        ,"FourNLine"=>"".$fourthNLine.""
        ,"FiveText"=>"".$fifthText.""
        ,"FiveSelect"=>"".$fifthSelect.""
        ,"FiveNLine"=>"".$fifthNLine.""
        ,"SixText"=>"".$sixthText.""
        ,"SixSelect"=>"".$sixthSelect.""
        ,"SixNLine"=>"".$sixthNLine.""
        ,"SevenText"=>"".$seventhText.""
        ,"SevenSelect"=>"".''.""
        ,"SevenNLine"=>"".''.""
        ,"EightText"=>"".''.""
        ,"EightSelect"=>"".''.""
        ,"EightNLine"=>"".''.""
        ,"FstCurrency"=>"".$firstCurrency.""
        ,"SecCurrency"=>"".$secondCurrency.""
        ,"FourCurrency"=>"".$fourthCurrency.""
        ,"FiveCurrency"=>"".$fifthCurrency.""
        ,"SixCurrency"=>"".$sixthCurrency.""]);
		$models=DB::table("NewStarfood.dbo.star_SMSModel")->get();
		return Response::json($models);
    }



	public function getTakhfifCodeModel(Request $request){
		$modelSn=$request->get("modelSn");
		$modelInfo=DB::table("NewStarfood.dbo.star_SMSModel")->where("Id",$modelSn)->get();
		return Response::json($modelInfo);
	}

    public function sendTakhfifCode(Request $request){
        $customerIDs=$request->input("customerIDs");
		
		$modelSn=$request->input("modelSn");
		
		$model=DB::table("NewStarfood.dbo.star_SMSModel")->where("Id",$modelSn)->get();
		
        $phones=DB::select("SELECT PhoneStr,SnPeopel,Name FROM SHop.dbo.PhoneDetail
							INNER JOIN Shop.dbo.Peopels on PhoneDetail.SnPeopel=Peopels.PSN
							WHERE PhoneType=2 AND PhoneDetail.CompanyNo=5 AND SnPeopel 
							IN (" . implode(',', $customerIDs) . ") ORDER BY SnPeopel DESC");
		
		foreach($phones as $phone){
			$modelContent="";
			$modelContent.=$model[0]->FstText.' ';
            switch ($model[0]->FstSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date("Y/m/d")))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }
			if($model[0]->FstCurrency=="on"){
				$modelContent.=" ریال ";
			}
			if($model[0]->FstNLine=="on"){
				$modelContent.="\n";
			}
			if(strlen($model[0]->SecText)>0){
				$modelContent.=$model[0]->SecText.' ';
			}
            switch ($model[0]->SecSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date("Y/m/d")))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }
			if($model[0]->SecCurrency=="on"){
				$modelContent.=" ریال ";
			}
			
			if($model[0]->SecNLine=="on"){
				$modelContent.="\n";
			}			
			if(strlen($model[0]->ThirdText)>0){
				$modelContent.=$model[0]->ThirdText.' ';
			}

            switch ($model[0]->ThirdSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date("Y/m/d")))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }

			if($model[0]->ThirdCurrency=="on"){
				$modelContent.=" ریال ";
			}

			if($model[0]->ThirdNLine=="on"){
				$modelContent.="\n";
			}
			if(strlen($model[0]->FourText)>0){
				$modelContent.=$model[0]->FourText.' ';
			}
            switch ($model[0]->FourSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d")))))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }
			
			if($model[0]->FourCurrency=="on"){
				$modelContent.=" ریال ";
			}
            
			if($model[0]->FourNLine=="on"){
				$modelContent.="\n";
			}
			if(strlen($model[0]->FiveText)>0){
				$modelContent.=$model[0]->FiveText.' ';
			}

            switch ($model[0]->FiveSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date("Y/m/d")))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }
			if($model[0]->FiveCurrency=="on"){
				$modelContent.=" ریال ";
			}
			if($model[0]->FiveNLine=="on"){
				$modelContent.="\n";
			}
			if(strlen($model[0]->SixText)>0){
				$modelContent.=$model[0]->SixText.' ';
			}
            switch ($model[0]->SixSelect) {
                case 'Name':
                    $modelContent.=$phone->Name.' ';
                    break;
                case 'Code':
                    $modelContent.=$model[0]->Code.' ';
                    break;
                case 'Money':
                    $modelContent.=$model[0]->Money.' ';
                    break;
                case 'UseDays':
                    $modelContent.=$model[0]->UseDays.' روز ';
                    break;    
                case 'FromDate':
                    $modelContent.=Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d")))))->format('Y/m/d').' ';
                    break;
                case 'ToDate':
                    $modelContent.= Jalalian::fromCarbon(Carbon::parse(date('Y-m-d', strtotime(date("Y/m/d"). ' + '.($model[0]->UseDays).' days'))))->format('Y/m/d').' ';
                    break;              
                default:
                $modelContent.="";
                    break;
            }
			if($model[0]->SixCurrency=="on"){
				$modelContent.=" ریال ";
			}
			if($model[0]->SixNLine=="on"){
				$modelContent.="\n";
			}
			if(strlen($model[0]->SevenText)>0){
				$modelContent.=$model[0]->SevenText;
			}
			$phone->modelContent=$modelContent."استارفود\n";
			$phone->modelSn=$model[0]->Id;
		}
		
		foreach($phones as $phone){
			$result="";
			$soapClient = new \SoapClient('https://dev.homais.com/services/sms/index.asmx?wsdl',['encoding' => 'UTF-8']);
			$parameters['PortalCode'] = "10009613"; // کد پرتال
			$parameters['UserName'] = "fr33768"; // یوزر
			$parameters['PassWord'] = "67536"; // پسورد
			$parameters['Mobile'] = "".$phone->PhoneStr.""; // شماره موبایل
			$parameters['Message'] ="".$phone->modelContent."";// متن پیام
			$parameters['ServerType'] = "100"; // 
			try {
				$result = $soapClient->singleSMS($parameters)->singleSMSResult;
				DB::table("NewStarfood.dbo.star_SMSHistory")->insert(["PeopleSn"=>$phone->SnPeopel
																	  ,"ResponseCode"=>"".$result.""
																	  ,"ModelSn"=>"".$phone->modelSn.""
																	  ,"PhoneNumber"=>"".$phone->PhoneStr.""
																	  ,"SMSText"=>"".$phone->modelContent.""]);
                if(strlen($result)>=15){
                    $usedOrNot=DB::table("NewStarfood.dbo.star_takhfifCodeAssign")
						->where("CustomerId",$phone->SnPeopel)
						->where("CodeId",$model[0]->Id)
						->where('isUsed',0)->get();
                    if(count($usedOrNot)<1){
                        DB::table("NewStarfood.dbo.star_takhfifCodeAssign")->insert(
                                    ["CustomerId"=>"".$phone->SnPeopel.""
                                    ,"isUsed"=>0
                                    ,"CodeId"=>"".$model[0]->Id.""]);
                    }
                }
			} catch (\SoapFault $e) {
				
			}
		}
        return Response::json("done");
    }

    public function getUsedTakhfifCodes(){//  کدهای تخفیف را با مشتریانش که استفاده کرده است, میدهد.
		
		$usedTakhfifCodes=DB::select("select Name,PSN,Format(UsedDate,'yyyy/MM/dd','fa-ir') as UsedDate,UsedMoney,PCode,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr from NewStarfood.dbo.star_takhfifCodeAssign join NewStarfood.dbo.star_SMSModel on CodeId=Id
                                        join Shop.dbo.Peopels on CustomerId=PSN 
                                        where isUsed=1");
		return $usedTakhfifCodes;
	}

    public function checkTakhfifCodeReliablity(Request $request){
        $code=$request->get("code");
        $customerId=$request->get("psn");
        $codeExistance=DB::select("SELECT * FROM NewStarfood.dbo.star_SMSModel 
									INNER JOIN NewStarfood.dbo.star_takhfifCodeAssign ON Id=CodeId 
									WHERE CustomerId=".$customerId." AND isUsed=0 AND Code='$code'");
		$takhfifCodeMoney=0;
		if(count($codeExistance)>0){
			$takhfifCodeMoney=$codeExistance[0]->Money;
		}
        $codeState=array();
        if(count($codeExistance)>0){
            $date = $codeExistance[0]->AssignDate;
            $newDate= Carbon::parse(date('Y-m-d', strtotime($date. ' + '.($codeExistance[0]->UseDays).' days')));
            $codeState=DB::select("SELECT * FROM NewStarfood.dbo.star_takhfifCodeAssign WHERE CodeId=".$codeExistance[0]->Id."
			                        AND CustomerId=".$customerId." AND isUsed=0 and CURRENT_TIMESTAMP<='".$newDate."'");
        }else{

        }
		if(count($codeState)>0){
        	return Response::json(["codeState"=>$codeState,"takhfifCodeMoneyInToman"=>$takhfifCodeMoney/10]);
		}else{
        	return Response::json(["codeState"=>$codeState,"takhfifCodeMoneyInToman"=>0]);		
		}
    }

    public function getTakhfifCodeReciverByDate($modelSn,$sabtDate){
		$modelSn=$modelSn;
		$sms=DB::select("SELECT * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') as hijriDate
								FROM NewStarfood.dbo.star_SMSHistory 
								INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
								INNER JOIN Shop.dbo.Peopels on PSN=star_SMSHistory.PeopleSn)a
								LEFT JOIN NewStarfood.dbo.star_takhfifCodeAssign on
								(a.ModelSn=star_takhfifCodeAssign.CodeId and a.PeopleSn=CustomerId)
								WHERE ModelSn=$modelSn and
								Format(a.SabtTime,'yyyy-MM-dd','fa-ir')='$sabtDate'");
        return view('takhfifCode.discountCodeReceiver',['sms'=>$sms,'modelSn'=>$modelSn,'sabtDate'=>$sabtDate]);
    }
	
	public function getCustomerTakhfifCodes(Request $request){
		$modelSn=$request->get("modelSn");
		$sabtDate=$request->get("sabtDate");
        $sms=DB::select("SELECT * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') as hijriDate FROM NewStarfood.dbo.star_SMSHistory 
                            INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
                            INNER JOIN Shop.dbo.Peopels on PSN=star_SMSHistory.PeopleSn)a
                            LEFT JOIN NewStarfood.dbo.star_takhfifCodeAssign on
                            (a.ModelSn=star_takhfifCodeAssign.CodeId and a.PeopleSn=CustomerId)
                            WHERE ModelSn=$modelSn and
                            Format(a.SabtTime,'yyyy-MM-dd','fa-ir')='$sabtDate'");
		return Response::json($sms);
	}

    public function filterTakhfifCodes(Request $request){
        $sentState=$request->get("state");
		$useState=$request->get("useState");
        $history;
        $modelSn=$request->get("modelSn");
		$sabtDate=$request->get("sabtDate");
		$queryPart="";
        if($sentState==1){
			$queryPart="len(ResponseCode)>15 AND";
		}else{
			if($sentState==0){
				$queryPart="len(ResponseCode)<5 AND";
			}
		}
            $history=DB::select("SELECT * FROM (SELECT *,ISNULL(isUsed,'') AS isUsedCode FROM 
								(SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') as hijriDate
								FROM NewStarfood.dbo.star_SMSHistory 
								INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
								INNER JOIN Shop.dbo.Peopels on PSN=star_SMSHistory.PeopleSn)a
								LEFT JOIN NewStarfood.dbo.star_takhfifCodeAssign ON
								(a.ModelSn=star_takhfifCodeAssign.CodeId AND a.PeopleSn=CustomerId))b
								WHERE ModelSn=$modelSn AND ".$queryPart."
								Format(b.SabtTime,'yyyy-MM-dd','fa-ir')='$sabtDate'
								AND isUsedCode LIKE '%$useState%'");

        return Response::json($history);
    }
    public function getTakhfifCodeHistoryByDay(Request $request){
        $day=$request->get("day");
        $modelSn=$request->get("modelSn");
        $history="";
        if($day=="TODAY"){
            $history=DB::select("SELECT * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') AS hijriDate
                FROM NewStarfood.dbo.star_SMSHistory 
                INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
                INNER JOIN Shop.dbo.Peopels ON PSN=star_SMSHistory.PeopleSn)A  WHERE ModelSn=$modelSn 
                AND hijriDate=FORMAT(CONVERT(DATE,CURRENT_TIMESTAMP),'yyyy/MM/dd','fa-ir')");
        }
        if($day=="YESTERDAY"){
            $history=DB::select("SELECT * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') AS hijriDate
            FROM NewStarfood.dbo.star_SMSHistory 
            INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
            INNER JOIN Shop.dbo.Peopels ON PSN=star_SMSHistory.PeopleSn)A  WHERE ModelSn=$modelSn 
            AND hijriDate=FORMAT(dateadd(day,-1,CONVERT(DATE,CURRENT_TIMESTAMP)),'yyyy/MM/dd','fa-ir')");
        }
        if($day=="LASTHUNDRED"){
            $history=DB::select("SELECT Top 100  * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') AS hijriDate
            FROM NewStarfood.dbo.star_SMSHistory 
            INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
            INNER JOIN Shop.dbo.Peopels ON PSN=star_SMSHistory.PeopleSn)A  WHERE ModelSn=$modelSn ORDER BY hijriDate DESC");
        }
        if($day=="ALL"){
            $history=DB::select("SELECT * FROM (SELECT *,Format(star_SMSHistory.SabtTime,'yyyy/MM/dd','fa-ir') AS hijriDate
            FROM NewStarfood.dbo.star_SMSHistory 
            INNER JOIN NewStarfood.dbo.star_SMSModel ON star_SMSHistory.ModelSn=star_SMSModel.Id 
            INNER JOIN Shop.dbo.Peopels ON PSN=star_SMSHistory.PeopleSn)A  WHERE ModelSn=$modelSn ORDER BY hijriDate DESC");
        }

        return Response::json($history);
    }
}