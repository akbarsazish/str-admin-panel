<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Response;
use Carbon\Carbon;
use App\Http\Controllers\TakhfifCode;
use App\Http\Controllers\Customer;
use DateTime;
class Lottery extends Controller
{
    public function index(Request $request)
    {
        $customerId=Session::get("psn");
        $bonusInfo = new Customer;
        //برای محاسبه کیف تخفیفی
        $bonusResult=$bonusInfo->getTargetsAndBonuses($customerId);
		$allMoneyTakhfifResult=$bonusInfo->getTakhfifCaseMoneyBeforeNazarSanji($customerId);

        //کالا برای  امتحان لاتاری
        $porducts=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
		$nazars=DB::select("SELECT * FROM NewStarfood.dbo.star_nazarsanji join NewStarfood.dbo.star_question on
							star_nazarsanji.id=star_question.nazarId where nazarId=(select max(id) from NewStarfood.dbo.star_nazarsanji)");
        //ختم محسبه امتیازات مشتری
		//محاسبه حاضری مشتری 

		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle
								WHERE CustomerId=$customerId");
		$todayDay="FirstDay";
		if(count($presentInfo)<1){
			DB::table("NewStarfood.dbo.star_presentCycle")->insert(["First"=>new DateTime()
																	,"CustomerId"=>$customerId
																   	,"FirstB"=>5
																	,"SecondB"=>5
																	,"ThirdB"=>5
																	,"FourthB"=>10
																	,"FifthB"=>10
																	,"SixthB"=>15
																	,"SeventhB"=>20]);
		}
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle
								WHERE CustomerId=$customerId");
		$currentDay="First";
		$prevDay="First";
		for($i=0 ;$i<=6;$i++){
			switch($i){
				case 0: $currentDay="First";
					break;
				case 1: $currentDay="Second";
					break;
				case 2: $currentDay="Third";
					break;
				case 3: $currentDay="Fourth";
					break;
				case 4: $currentDay="Fifth";
					break;
				case 5: $currentDay="Sixth";
					break;
				case 6: $currentDay="Seventh";
					break;
			}
			
			switch($i){
				case 1: $prevDay="First";
					break;
				case 2: $prevDay="Second";
					break;
				case 3: $prevDay="Third";
					break;
				case 4: $prevDay="Fourth";
					break;
				case 5: $prevDay="Fifth";
					break;
				case 6: $prevDay="Sixth";
					break;
			}
			
			$curDayPrFild=$currentDay."Pr";
			$prevDayPrFild=$prevDay."Pr";
			$firstDate=$presentInfo[0]->First;
			$interval=(new DateTime($presentInfo[0]->First))->diff(new DateTime());
			if($i<=$interval->d){
				if(count($presentInfo)>0){
					DB::update("UPDATE NewStarfood.dbo.star_presentCycle SET
					$currentDay=DATEADD(day, $i,CAST('$firstDate' AS DATE)) WHERE CustomerId=$customerId");
				}

				$todayDate=date('Y-m-d');
				$currentDayDate=$presentInfo[0]->$currentDay;
				$currentDayPresentState=$presentInfo[0]->$curDayPrFild;
				$prevDayPresentState=$presentInfo[0]->$prevDayPrFild;

				if((($currentDayDate != $todayDate) or ($currentDayPresentState==1 and $prevDayPresentState==0))
				   or 
				   ($currentDayPresentState == 0 and $prevDayPresentState == 0)){
					DB::update("UPDATE NewStarfood.dbo.star_presentCycle SET 
					   First=cast('".date('Y-m-d')."' as date)
					  ,Second=NULL
					  ,Third=NULL
					  ,Fourth=NULL
					  ,Fifth=NULL
					  ,Sixth=NULL
					  ,Seventh=NULL
					  ,CustomerId=$customerId
					  ,FirstB=5
					  ,SecondB=5
					  ,ThirdB=5
					  ,FourthB=10
					  ,FifthB=10
					  ,SixthB=15
					  ,SeventhB=20 
					  ,FirstPr=0
					  ,SecondPr=0
					  ,ThirdPr=0
					  ,FourthPr=0
					  ,FifthPr=0
					  ,SixthPr=0
					  ,SeventhPr=0 
					  WHERE CustomerId=$customerId");
				}

				if($presentInfo[0]->$curDayPrFild==0 and $presentInfo[0]->$prevDayPrFild==0){
					
					DB::delete("DELETE NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
			 	}
			}
			
			$allBonus=$presentInfo[0]->FirstB+$presentInfo[0]->SecondB+
				$presentInfo[0]->ThirdB+$presentInfo[0]->FourthB+
				$presentInfo[0]->FifthB+$presentInfo[0]->SixthB+
				$presentInfo[0]->SeventhB;
			
			if($currentDay=="Seventh" and $presentInfo[0]->SeventhPr==1){
				DB::delete("DELETE NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
			}
		}
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
		
		if(count($presentInfo)<1){
			DB::table("NewStarfood.dbo.star_presentCycle")->insert(["First"=>new DateTime()
																	,"CustomerId"=>$customerId
																   	,"FirstB"=>5
																	,"SecondB"=>5
																	,"ThirdB"=>5
																	,"FourthB"=>10
																	,"FifthB"=>10
																	,"SixthB"=>15
																	,"SeventhB"=>20]);
		}
		
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
		
		$attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerId");
		if(count($attractionVisit)<1){
			DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerId
																	   ,"Game" => 0
																	   ,"MoneyCase" => 0
																	   ,"Discount" => 0
																	   ,"StarfoodStar" => 1
																	   ,"ViewDate" => new DateTime()]);
		}else{
			DB::table("NewStarfood.dbo.star_attractionVisit")
				->where("CustomerId",$customerId)
				->update(["StarfoodStar" => 1,"ViewDate" => new DateTime()]);

		}
		$allBonus=$bonusResult[5];
        return view('lottery.bagCash',['monyComTg'=>$bonusResult[0],'aghlamComTg'=>$bonusResult[1],
									   'monyComTgBonus'=>$bonusResult[2],'aghlamComTgBonus'=>$bonusResult[3],
									   'lotteryMinBonus'=>$bonusResult[4],'allBonus'=>$bonusResult[5],'presentInfo'=>$presentInfo,
									   'allMoneyTakhfifResult'=>$allMoneyTakhfifResult,'products'=>$porducts,'nazar'=>$nazars]);
    }

    public function getLotteryInfoApi(Request $request){
        $customerId=$request->input('psn');
        $bonusInfo = new Customer;
        //برای محاسبه کیف تخفیفی
        $bonusResult=$bonusInfo->getTargetsAndBonuses($customerId);

        //کالا برای  امتحان لاتاری
        $porducts=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
		$nazars=DB::select("SELECT * FROM NewStarfood.dbo.star_nazarsanji join NewStarfood.dbo.star_question on
							star_nazarsanji.id=star_question.nazarId where nazarId=(select max(id) from NewStarfood.dbo.star_nazarsanji)");
        //ختم محسبه امتیازات مشتری
		//محاسبه حاضری مشتری 

		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle
								WHERE CustomerId=$customerId");
		$todayDay="FirstDay";
		if(count($presentInfo)<1){
			DB::table("NewStarfood.dbo.star_presentCycle")->insert(["First"=>new DateTime()
																	,"CustomerId"=>$customerId
																   	,"FirstB"=>5
																	,"SecondB"=>5
																	,"ThirdB"=>5
																	,"FourthB"=>10
																	,"FifthB"=>10
																	,"SixthB"=>15
																	,"SeventhB"=>20 ]);
		}
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
		$currentDay="First";
		$prevDay="First";
		for($i=0 ;$i<=6;$i++){
			switch($i){
				case 0: $currentDay="First";
					break;
				case 1: $currentDay="Second";
					break;
				case 2: $currentDay="Third";
					break;
				case 3: $currentDay="Fourth";
					break;
				case 4: $currentDay="Fifth";
					break;
				case 5: $currentDay="Sixth";
					break;
				case 6: $currentDay="Seventh";
					break;
			}
			
			switch($i){
				case 1: $prevDay="First";
					break;
				case 2: $prevDay="Second";
					break;
				case 3: $prevDay="Third";
					break;
				case 4: $prevDay="Fourth";
					break;
				case 5: $prevDay="Fifth";
					break;
				case 6: $prevDay="Sixth";
					break;
				case 6: $prevDay="Seventh";
				break;
			}
			
			$curDayPrFild=$currentDay."Pr";
			$prevDayPrFild=$prevDay."Pr";
			$firstDate=$presentInfo[0]->First;
			$interval=(new DateTime($presentInfo[0]->First))->diff(new DateTime());
			if($i<=$interval->d){
				if(count($presentInfo)>0){
					DB::update("UPDATE NewStarfood.dbo.star_presentCycle SET
								$currentDay=DATEADD(day, $i,CAST('$firstDate' AS DATE)) WHERE CustomerId=$customerId");
				}
				$todayDate=date('Y-m-d');
				$currentDayDate=$presentInfo[0]->$currentDay;
				$currentDayPresentState=$presentInfo[0]->$curDayPrFild;
				$prevDayPresentState=$presentInfo[0]->$prevDayPrFild;

				if((($currentDayDate != $todayDate) or ($currentDayPresentState==1 and $prevDayPresentState==0))
				   or 
				   ($currentDayPresentState == 0 and $prevDayPresentState == 0)){
					DB::update("UPDATE NewStarfood.dbo.star_presentCycle SET 
					   First=cast('".date('Y-m-d')."' as date)
					  ,Second=NULL
					  ,Third=NULL
					  ,Fourth=NULL
					  ,Fifth=NULL
					  ,Sixth=NULL
					  ,Seventh=NULL
					  ,CustomerId=$customerId
					  ,FirstB=5
					  ,SecondB=5
					  ,ThirdB=5
					  ,FourthB=10
					  ,FifthB=10
					  ,SixthB=15
					  ,SeventhB=20 
					  ,FirstPr=0
					  ,SecondPr=0
					  ,ThirdPr=0
					  ,FourthPr=0
					  ,FifthPr=0
					  ,SixthPr=0
					  ,SeventhPr=0 
					  WHERE CustomerId=$customerId");
				}
			}
			
			$allBonus=$presentInfo[0]->FirstB+$presentInfo[0]->SecondB+
				$presentInfo[0]->ThirdB+$presentInfo[0]->FourthB+
				$presentInfo[0]->FifthB+$presentInfo[0]->SixthB+
				$presentInfo[0]->SeventhB;
			
			if($currentDay=="Seventh" and $presentInfo[0]->SeventhPr==1){
				DB::delete("DELETE NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
			}
		}
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
		
		if(count($presentInfo)<1){
			DB::table("NewStarfood.dbo.star_presentCycle")->insert(["First"=>new DateTime()
																	,"CustomerId"=>$customerId
																   	,"FirstB"=>5
																	,"SecondB"=>5
																	,"ThirdB"=>5
																	,"FourthB"=>10
																	,"FifthB"=>10
																	,"SixthB"=>15
																	,"SeventhB"=>20]);
		}
		
		$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
		
		$attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerId");
		if(count($attractionVisit)<1){
			DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerId
																	   ,"Game" => 0
																	   ,"MoneyCase" => 0
																	   ,"Discount" => 0
																	   ,"StarfoodStar" => 1
																	   ,"ViewDate" => new DateTime()]);
		}else{
			DB::table("NewStarfood.dbo.star_attractionVisit")
				->where("CustomerId",$customerId)
				->update(["StarfoodStar" => 1,"ViewDate" => new DateTime()]);

		}
		$allBonus=$bonusResult[5];
        return Response::json(['lotteryMinBonus'=>$bonusResult[4],'allBonus'=>$bonusResult[5],'presentInfo'=>$presentInfo,'products'=>$porducts,'todayDate'=>new DateTime()]);
    }

    public function editLotteryPrize(Request $request){
        $firstPrize=$request->get("firstPrize");
        $secondPrize=$request->get("secondPrize");
        $thirdPrize=$request->get("thirdPrize");
        $fourthPrize=$request->get("fourthPrize");
        $fifthPrize=$request->get("fifthPrize");
        $sixthPrize=$request->get("sixthPrize");
        $seventhPrize=$request->get("seventhPrize");
        $eightthPrize=$request->get("eightthPrize");
        $ninethPrize=$request->get("ninethPrize");
        $teenthPrize=$request->get("teenthPrize");
        $eleventhPrize=$request->get("eleventhPrize");
        $twelvthPrize=$request->get("twelvthPrize");
        $therteenthPrize=$request->get("thirteenthPrize");
        $fourteenthPrize=$request->get("fourteenthPrize");
        $fifteenthPrize=$request->get("fiftheenthPrize");
        $sixteenthPrize=$request->get("sixteenthPrize");
        $lotteryMinBonus=$request->get("lotteryMinBonus");
        $introductionBonus=$request->get("introductionBonus");

        $showfirstPrize=self::changeToOneOrZero($request->get("showfirstPrize"));
        $showsecondPrize=self::changeToOneOrZero($request->get("showsecondPrize"));
        $showthirdPrize=self::changeToOneOrZero($request->get("showthirdPrize"));
        $showfourthPrize=self::changeToOneOrZero($request->get("showfourthPrize"));
        $showfifthPrize=self::changeToOneOrZero($request->get("showfifthPrize"));
        $showsixthPrize=self::changeToOneOrZero($request->get("showsixthPrize"));
        $showseventhPrize=self::changeToOneOrZero($request->get("showseventhPrize"));
        $showeightthPrize=self::changeToOneOrZero($request->get("showeightthPrize"));
        $showninethPrize=self::changeToOneOrZero($request->get("showninethPrize"));
        $showteenthPrize=self::changeToOneOrZero($request->get("showteenthPrize"));
        $showeleventhPrize=self::changeToOneOrZero($request->get("showeleventhPrize"));
        $showtwelvthPrize=self::changeToOneOrZero($request->get("showtwelvthPrize"));
        $showtherteenthPrize=self::changeToOneOrZero($request->get("showtherteenthPrize"));
        $showfourteenthPrize=self::changeToOneOrZero($request->get("showfifteenthPrize"));
        $showfifteenthPrize=self::changeToOneOrZero($request->get("showfifteenthPrize"));
        $showsixteenthPrize=self::changeToOneOrZero($request->get("showsixteenthPrize"));
        $isFilledPrizes=DB::table("NewStarfood.dbo.star_lotteryPrizes")->count();
        DB::table("NewStarfood.dbo.star_webSpecialSetting")->update(['lotteryMinBonus'=>$lotteryMinBonus,'useIntroBonus'=>$introductionBonus]);
        if($isFilledPrizes>0){
            DB::table("NewStarfood.dbo.star_lotteryPrizes")->where('id',1)->update(
			['firstPrize'=>"".$firstPrize.""
			,'secondPrize'=>"".$secondPrize.""
			,'thirdPrize'=>"".$thirdPrize.""
			,'fourthPrize'=>"".$fourthPrize.""
			,'fifthPrize'=>"".$fifthPrize.""
			,'sixthPrize'=>"".$sixthPrize.""
			,'seventhPrize'=>"".$seventhPrize.""
			,'eightthPrize'=>"".$eightthPrize.""
			,'ninethPrize'=>"".$ninethPrize.""
			,'teenthPrize'=>"".$teenthPrize.""
			,'eleventhPrize'=>"".$eleventhPrize.""
			,'twelvthPrize'=>"".$twelvthPrize.""
			,'therteenthPrize'=>"".$therteenthPrize.""
			,'fourteenthPrize'=>"".$fourteenthPrize.""
			,'fifteenthPrize'=>"".$fifteenthPrize.""
			,'sixteenthPrize'=>"".$sixteenthPrize.""
			,'showfirstPrize'=>$showfirstPrize
			,'showsecondPrize'=>$showsecondPrize
			,'showthirdPrize'=>$showthirdPrize
			,'showfourthPrize'=>$showfourthPrize
			,'showfifthPrize'=>$showfifthPrize
			,'showsixthPrize'=>$showsixthPrize
			,'showseventhPrize'=>$showseventhPrize
			,'showeightthPrize'=>$showeightthPrize
			,'showninethPrize'=>$showninethPrize
			,'showteenthPrize'=>$showteenthPrize
			,'showeleventhPrize'=>$showeleventhPrize
			,'showtwelvthPrize'=>$showtwelvthPrize
			,'showtherteenthPrize'=>$showtherteenthPrize
			,'showfourteenthPrize'=>$showfourteenthPrize
			,'showfifteenthPrize'=>$showfifteenthPrize
			,'showsixteenthPrize'=>$showsixteenthPrize
        ]);

        }else{
            DB::table("NewStarfood.dbo.star_lotteryPrizes")->insert(
                ['firstPrize'=>"".$firstPrize.""
                ,'secondPrize'=>"".$secondPrize.""
                ,'thirdPrize'=>"".$thirdPrize.""
                ,'fourthPrize'=>"".$fourthPrize.""
                ,'fifthPrize'=>"".$fifthPrize.""
                ,'sixthPrize'=>"".$sixthPrize.""
                ,'seventhPrize'=>"".$seventhPrize.""
                ,'eightthPrize'=>"".$eightthPrize.""
                ,'ninethPrize'=>"".$ninethPrize.""
                ,'teenthPrize'=>"".$teenthPrize.""
                ,'eleventhPrize'=>"".$eleventhPrize.""
                ,'twelvthPrize'=>"".$twelvthPrize.""
                ,'therteenthPrize'=>"".$therteenthPrize.""
                ,'fourteenthPrize'=>"".$fourteenthPrize.""
                ,'fifteenthPrize'=>"".$fifteenthPrize.""
                ,'sixteenthPrize'=>"".$sixteenthPrize.""]);

        }
        return redirect('/controlMainPage');
    }
    
    public function changeToOneOrZero($getdata)
    {
        if($getdata){
        return 1;
        }else {
        return 0;
        }
    }

    public function getLotteryPrizes(Request $request)
    {
        $lotteryPrizes=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
        return Response::json($lotteryPrizes);
    }


	public function setCustomerLotteryHistory(Request $request)
    {
        $product=$request->input("product");
        $customerId=$request->input("customerId");
		$remainBonus=$request->input("remainedBonus");
        DB::table("NewStarfood.dbo.star_TryLottery")->insert(['customerId'=>$customerId,'lotteryId'=>1,'wonPrize'=>"$product"]);
        DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$customerId)->update(['introBonusAmount'=>0,'remainedBonus'=>$remainBonus]);
		DB::table("NewStarfood.dbo.star_weeklyPresentHistory")->where('CustomerSn',$customerId)->update(['isUsed'=>1]);
        return Response::json("success");
    }


    // public function setCustomerLotteryHistory(Request $request)
    // {
    //     $product=$request->get("product");
    //     $customerId=$request->get("customerId");
    //     DB::table("NewStarfood.dbo.star_TryLottery")->insert(['customerId'=>$customerId,'lotteryId'=>1,'wonPrize'=>"$product"]);
    //     DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$customerId)->update(['introBonusAmount'=>0]);
	// 	DB::table("NewStarfood.dbo.star_weeklyPresentHistory")->where('CustomerSn',$customerId)->update(['isUsed'=>1]);
    //     return Response::json("success");
    // }

    public function lotteryResult(Request $request)
    {
        $lotteryTryResult=DB::select("SELECT CONVERT(DATE,timestam) AS lastTryDate,Name,CRM.dbo.getCustomerPhoneNumbers(PSN) PhoneStr
										,id,PSN,wonPrize,Istaken,customerId,CONVERT(DATE,tasviyahDate) AS tasviyahDate
										FROM NewStarfood.dbo.star_TryLottery JOIN Shop.dbo.Peopels ON customerId=PSN order by timestam desc");

        //کیف تخفیفی
        $takhfifCaseResult=DB::select("SELECT PCode,PSN,customerId,Name,money,format(usedDate,'yyyy/MM/dd','fa-ir') as usedDate,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr
										FROM NewStarfood.dbo.star_takhfifHistory JOIN Shop.dbo.Peopels ON PSN=customerId WHERE isUsed=1");
       
        // گیمر لیست کیوری
        $players=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(posId) as PhoneStr,CRM.dbo.getGameName(gameId) as GameName,deleted FROM (
            SELECT Row,Name,posId,PosName,gameId,deleted FROM (
            SELECT ROW_NUMBER() 
                            OVER (ORDER BY id)  AS Row,id,PosName,
            posId,gameId,deleted
            FROM NewStarfood.dbo.star_game_history
            
            unpivot
            (
            posId
            for PosName IN (firstPosId,secondPosId,thirdPosId,fourthPosId,fifthPosId,sixthPosId,seventhPosId,eightPosId,ninthPosId,teenthPosId)
            ) unpiv
            
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
            
            unpivot
            (
            prize
            for PrizeName in (firstPrize,secondPrize,thirdPrize,fourthPrize,fifthPrize,sixthPrize,seventhPrize,eightthPrize,ninthPrize,teenthPrize)
            ) unpiv
            )a WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history)
            )c )d ON b.Row=d.Row where deleted=0");
		
        $lotteryPrizes=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
		
		$nazarSanjies=DB::table("NewStarfood.dbo.star_nazarsanji")->join("NewStarfood.dbo.star_question","nazarId","=","star_nazarsanji.id")->get();
		
		$takhfifCode=new TakhfifCode;
		$usedTakhfifCodes=$takhfifCode->getUsedTakhfifCodes();
		
        return view('lottery.lotteryResult',['lotteryTryResult'=>$lotteryTryResult,
										   'players'=>$players,'takhfifCaseResult'=>$takhfifCaseResult,
										   'prizes'=>$lotteryPrizes,'nazars'=>$nazarSanjies,
										   'usedTakhfifCodes'=>$usedTakhfifCodes]);
    }
    public function tasviyeahLottery(Request $request) {
        $customerId=$request->post("customerId");
        $lotteryId=$request->post("lotteryTryId");

        DB::table("NewStarfood.dbo.star_TryLottery")->where('id',$lotteryId)->where('customerId',$customerId)->update(['Istaken'=>1,'tasviyahDate'=>Carbon::now()]);
        return redirect('/lotteryResult');
    }
    public function checkTryLottery($customerId){ // برای تشخیص اینکه آیا این مشتری از چرخونه استفاده کرده یانه استفاده می شود.
		$tryLotteryState=DB::select("SELECT * FROM NewStarfood.dbo.star_TryLottery WHERE customerId=$customerId");
		if(count($tryLotteryState)>0){
			return 1;
		}else{
			return 0;
		}
	}
    public function indexApi(Request $request)
    {
        $customerSn=$request->get("psn");
        //برای محاسبه کیف تخفیفی
        $counDiscountWallet=new StarfoodFunLib;
        $bonusResult=$counDiscountWallet->customerBonusCalc($customerSn);
        //کالا برای  امتحان لاتاری
        $porducts=DB::select("select firstPrize, secondPrize,thirdPrize,fourthPrize,fifthPrize,	sixthPrize,	seventhPrize,eightthPrize,ninethPrize,teenthPrize,eleventhPrize,twelvthPrize,therteenthPrize,fourteenthPrize,fifteenthPrize,sixteenthPrize from NewStarfood.dbo.star_lotteryPrizes");
        //ختم محسبه امتیازات مشتری
        return Response::json(['monyComTg'=>$bonusResult[0],
        'aghlamComTg'=>$bonusResult[1],'monyComTgBonus'=>$bonusResult[2],
        'aghlamComTgBonus'=>$bonusResult[3],'lotteryMinBonus'=>$bonusResult[4],'allBonus'=>$bonusResult[5],
        'products'=>$porducts]);
    }
}
