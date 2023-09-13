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
use App\Http\Controllers\BagCash;
class Basket extends Controller {
    public function getCurrency()
    {
        $currency=1;
        $currencyName="ریال";
        $specialSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('*')[0];
        if($specialSettings->currency==10){
            $currencyName="تومان";
            $currency=10;
        }

        return (["currency"=>10,"currencyName"=>$currencyName,
				 "logoPosition"=>$specialSettings->logoPosition,
				 "minSalePriceFactor"=>$specialSettings->minSalePriceFactor,
        		 "moorningTimeContent"=>$specialSettings->moorningTimeContent,
                 "afternoonTimeContent"=>$specialSettings->afternoonTimeContent]);
    }


    public function index(Request $request)
    {
        $afternoonTitle="";
        $moorningTitle="";
        $defaultUnit;
        $changedPriceState=0;
        $orderHDSs=DB::select("SELECT SnOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".Session::get('psn')." and OrderStatus=0");
        $SnHDS=0;
        if(count($orderHDSs)>0){
            $SnHDS=$orderHDSs[0]->SnOrder;
        }

        $orderBYSs=DB::select("SELECT IIF(Fi=Pr.Price3,0,1) as changedPrice,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYS,orderStar.CompanyNo,orderStar.Price,orderStar.SnGood,Price1,SnHDS,PackAmount,orderStar.Amount,Fi,Pr.Price3,Pr.Price4,DateOrder,A.Amount as AmountExist,star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,iif(NewStarfood.dbo.getSecondUnit(GoodSn) is null,NewStarfood.dbo.getFirstUnit(GoodSn),NewStarfood.dbo.getSecondUnit(GoodSn)) as secondUnitName from Shop.dbo.PubGoods
        JOIN NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood
        JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
        JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=1402) A on PubGoods.GoodSn=A.SnGood
		JOIN (select * from Shop.dbo.GoodPriceSale where FiscalYear=1402)Pr on Pr.SnGood=orderStar.SnGood
        WHERE PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and SnHDS=".$SnHDS);
        //assign Currency and other info settings
        $currencyInfo=self::getCurrency();
        $currency=$currencyInfo["currency"];
        $currencyName=$currencyInfo["currencyName"];
        //logo position
        $logoPos=$currencyInfo["logoPosition"];
        //changed price or not
		
		$renewQuery=0; //برای تکرار گرفتن دوباره آیتم های سبد خرید استفاده می شود.
        if(count($orderBYSs)>0){
            foreach($orderBYSs as $orderBYS){
                if($orderBYS->changedPrice ==1){
                    $changedPriceState=$orderBYS->changedPrice;
                }
				//محاسبه موجودی
				$amount=DB::select("SELECT Amount,NewStarfood.dbo.getAmountUnit(SnGood) as AmountUnit 
									FROM Shop.dbo.ViewGoodExistsInStock WHERE SnGood=$orderBYS->SnGood
									AND CompanyNo=5 AND FiscalYear=".Session::get("FiscallYear")." AND SnStock=23");
				
                if($amount[0]->Amount < $orderBYS->Amount){
					DB::table("NewStarfood.dbo.orderStar")->where("SnGood",$orderBYS->SnGood)->where("SnHDS",$SnHDS)->delete();
					$renewQuery=1;
                }else{
                }
				//ختم محاسبه موجودی 
            }
        }
		
		if($renewQuery==1){
			$changedPriceState=0;
		    $orderBYSs=DB::select("SELECT IIF(Fi=Pr.Price3,0,1) as changedPrice,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYS,
			orderStar.CompanyNo,orderStar.Price,orderStar.SnGood,Price1,SnHDS,PackAmount,orderStar.Amount,Fi,Pr.Price3,
			Pr.Price4,DateOrder,A.Amount as AmountExist,star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName
			,iif(NewStarfood.dbo.getSecondUnit(GoodSn) is null,NewStarfood.dbo.getFirstUnit(GoodSn),
			NewStarfood.dbo.getSecondUnit(GoodSn)) as secondUnitName from Shop.dbo.PubGoods
        JOIN NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood
        JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
        JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A on PubGoods.GoodSn=A.SnGood
		JOIN (select * from Shop.dbo.GoodPriceSale where FiscalYear=".Session::get("FiscallYear").")Pr on Pr.SnGood=orderStar.SnGood
        WHERE PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and SnHDS=".$SnHDS);
			
		 if(count($orderBYSs)>0){
            foreach($orderBYSs as $orderBYS){
                if($orderBYS->changedPrice ==1){
                    $changedPriceState=$orderBYS->changedPrice;
                }
			}
		 }
		}
        //check time of updating factor or not
        $intervalBetweenBuys=1000;
        $MainIntervalBetweenBuys= DB::select("SELECT DATEDIFF(hour,CONVERT(DATETIME, (SELECT TimeStamp from NewStarfood.dbo.OrderHDSS where
        OrderHDSS.SnOrder=(select Max(SnOrder) from NewStarfood.dbo.OrderHDSS WHERE  CustomerSn=".Session::get('psn')." and isDistroy=0))), CURRENT_TIMESTAMP)
        AS DateDiff");

        if($MainIntervalBetweenBuys[0]->DateDiff){
            $intervalBetweenBuys=$MainIntervalBetweenBuys[0]->DateDiff;
        }else{
            $intervalBetweenBuys=$intervalBetweenBuys;
        }

        $minSalePriceFactor=1000;
        $pardakhtLive=0;
        $minSalePriceFactor=$currencyInfo["minSalePriceFactor"];
        $afternoonTitle=$currencyInfo["moorningTimeContent"];
        $moorningTitle=$currencyInfo["afternoonTimeContent"];
        
        $minimumFactorPrice=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction WHERE customerId=".Session::get('psn'))[0]->minimumFactorPrice;
        if($minimumFactorPrice>0){
            $minSalePriceFactor=$minimumFactorPrice;
        }
        //used for پیش خرید
        $SnOrderPishKharid=DB::select("SELECT SnOrderPishKharid FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=".Session::get('psn')." and OrderStatus=0");
        $SnHDS=0;
        if(count($SnOrderPishKharid)>0){
            $SnHDS=$SnOrderPishKharid[0]->SnOrderPishKharid;
        }
        $orderPishKarids=DB::select("SELECT IIF(Fi!=Price3,0,1) as changedPric,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYSPishKharid,star_pishKharidOrder.CompanyNo,star_pishKharidOrder.Price,star_pishKharidOrder.SnGood,SnHDS,PackAmount,star_pishKharidOrder.Amount,Fi,Price3,Price4,DateOrder,A.Amount as AmountExist,dbo.star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnitName from Shop.dbo.PubGoods
                                    JOIN NewStarfood.dbo.star_pishKharidOrder ON PubGoods.GoodSn=star_pishKharidOrder.SnGood
                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                    JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A ON PubGoods.GoodSn=A.SnGood
                                    WHERE NOT EXISTS(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 AND productId=PubGoods.GoodSn) AND SnHDS=".$SnHDS);
        return view ('basket.carts',['orders'=>$orderBYSs,'orderPishKarids'=>$orderPishKarids,'intervalBetweenBuys'=>$intervalBetweenBuys,'minSalePriceFactor'=>$minSalePriceFactor,'changedPriceState'=>$changedPriceState,'afternoonTitle'=>$afternoonTitle,'moorningTitle'=>$moorningTitle,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
   }

   public function sendBasket(Request $request)
   {
       $customerId=Session::get('psn');
       $allMoney=$request->post('allMoney');
       $profit=$request->post('profit');
       $customers=DB::select('SELECT Peopels.* FROM Shop.dbo.Peopels WHERE PSN='.$customerId);
       $customer;
       foreach ($customers as $customer) {
           $customer=$customer;
       }
       $tomorrowDate= Carbon::now()->addDays(1);//فردا جمع یک
       
       $tomorrow=$tomorrowDate->dayOfWeek;

       $afterTomorrowDate = Carbon::now();
       $twoDaysLater = $afterTomorrowDate->addDays(2);// پس فردا جمع دو
       $afterTomorrow= $twoDaysLater->dayOfWeek;

       if($tomorrow==5){
           $tomorrowDate = $tomorrowDate->addDays(1);
           $twoDaysLater = $twoDaysLater->addDays(1);
       }
       $tomorrow=$tomorrowDate->dayOfWeek;
       $afterTomorrow= $twoDaysLater->dayOfWeek;

       if($afterTomorrow==5){
           $twoDaysLater = $twoDaysLater->addDays(1);
       }
       $afterTomorrow= $twoDaysLater->dayOfWeek;
       $day1;
       switch ($tomorrow) {
           case 6:
               $day1='شنبه';
               break;
           case 0:
               $day1='یکشنبه';
               break;
           case 1:
               $day1='دوشنبه';
               break;
           case 2:
               $day1='سه شنبه';
               break;
           case 3:
               $day1='چهار شنبه';
               break;
           case 4:
               $day1='پنج شنبه';
               break;
           case 5:
               $day1='جمعه';
               break;

           default:
               # code...
               break;
       }
       $day2;
       switch ($afterTomorrow) {
           case 6:
               $day2='شنبه';
               break;
           case 0:
               $day2='یکشنبه';
               break;
           case 1:
               $day2='دوشنبه';
               break;
           case 2:
               $day2='سه شنبه';
               break;
           case 3:
               $day2='چهار شنبه';
               break;
           case 4:
               $day2='پنج شنبه';
               break;
           case 5:
               $day2='جمعه';
               break;
           default:
               # code...
               break;
       }
       $customerRestrictions=DB::select("SELECT * FROM  NewStarfood.dbo.star_customerRestriction WHERE customerId=".Session::get('psn'));
       $pardakhtLive=0;
       foreach ($customerRestrictions as $restrict) {
           $pardakhtLive=$restrict->pardakhtLive;
       }
       $webSpecialSettings=DB::table('NewStarfood.dbo.star_webSpecialSetting')->select("*")->get();
       $moorningActive=0;
       $afternoonActive=0;
       $settings=array();
       foreach ($webSpecialSettings as  $setting) {
           $settings=$setting;
       }

       $currency=1;
       $currencyName="ریال";
       $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
       foreach ($currencyExistance as $cr) {
           $currency=$cr->currency;
       }
       if($currency==10){
           $currencyName="تومان";
       }
       //برای محاسبه کیف تخفیفی
       $walletInfo=new Customer;
       $allMoneyTakhfifResult=(int)($walletInfo->getTakhfifCaseMoneyAfterNazarSanji(Session::get('psn')));
       $addresses=DB::select("SELECT * FROM Shop.dbo.PeopelAddress where  SnPeopel=".Session::get('psn'));
       return view ('basket.shipping',['date1'=>$day1,'date2'=>$day2,'customer'=>$customer,'takhfifCase'=>$allMoneyTakhfifResult
       ,'allMoney'=>$allMoney,'profit'=>$profit, 'tomorrowDate'=>$tomorrowDate,'afterTomorrowDate'=>$twoDaysLater
       ,'pardakhtLive'=>$pardakhtLive,'setting'=>$settings,'currency'=>$currency,'currencyName'=>$currencyName,
       'addresses'=>$addresses]);
    }

    public function addToBasket(Request $request){
       $packType;
       $packAmount;
       $allPacks;
       $defaultUnit=0;
       $costAmount=0;
       $amelSn=0;
       $kalaId=$request->get('kalaId');
       $checkExistance=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kalaId)->select("*")->get();
       foreach ($checkExistance as $pr) {
           $costLimit=$pr->costLimit;
           $costAmount=$pr->costAmount;
           $amelSn=$pr->inforsType;
       }
       $secondUnits=DB::select("select SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$kalaId);
       $defaultUnits=DB::select("select defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$kalaId);
       foreach ($defaultUnits as $unit) {
           $defaultUnit=$unit->defaultUnit;
       }
       if(count($secondUnits)>0){
           foreach ($secondUnits as $unit) {
               $packType=$unit->SnGoodUnit;
               $packAmount=$unit->AmountUnit;
           }
           }else{
               $packType=$defaultUnit;
               $packAmount=1;
           }
       $amountUnit=$request->get('amountUnit');
       $prices=DB::select("select GoodPriceSale.Price3,GoodPriceSale.Price4 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$kalaId);
       $exactPrice=0;
       $exactPriceFirst=0;
       foreach ($prices as $price) {
           $exactPrice=$price->Price3;
           $exactPriceFirst=$price->Price4;
       }
       $allMoney= $exactPrice * $amountUnit;
       $allMoneyFirst=$exactPriceFirst * $amountUnit;
       $maxOrderNo=DB::select("select MAX(OrderNo) as maxNo from NewStarfood.dbo.FactorStar where CompanyNo=5");
       $maxOrder=0;
       if(count($maxOrderNo)>0){

           foreach ($maxOrderNo as $maxNo) {

               $maxOrder=$maxNo->maxNo;

               $maxOrder=$maxOrder+1;
           }

       }else{

           $maxOrder=1;

           }

       $todayDate = Jalalian::forge('today')->format('Y/m/d');
       $todayNow = Jalalian::forge('today')->format("%H:%M:%S");
       $customerId=Session::get('psn');
       $curTime=  Carbon::now();
       $dt=$curTime->format("Y-m-d H:i:s");
       $countOrders=DB::select("SELECT count(SnOrder) AS contOrder from NewStarfood.dbo.FactorStar WHERE OrderStatus=0 AND  CustomerSn=".$customerId);
       $countOrder=0;
       foreach ($countOrders as $countOrder1) {
           $countOrder=$countOrder1->contOrder;
       }
       $factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from Shop.dbo.OrderHDS WHERE CompanyNo=5");
       $factorNo;
       foreach ($factorNumber as $number) {
           $factorNo=$number->maxFact;
       }
       $factorNo=$factorNo+1;
       if($countOrder<1){
           DB::insert("INSERT INTO NewStarfood.dbo.FactorStar (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)
           VALUES(5,".$factorNo.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscalllYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
          $maxsFactor=DB::select("SELECT MAX(SnOrder) as maxFactorId from NewStarfood.dbo.FactorStar where CustomerSn=".$customerId);
          $maxsFactorId=0;
          foreach ($maxsFactor as $maxFact) {
           $maxsFactorId=$maxFact->maxFactorId;
          }
          DB::insert("INSERT INTO star_BuyTracking (factorStarId ,orderHDSId ,factorHDSId,customerId,pardakhtType) VALUES (".$maxsFactorId.", 0, 0,".$customerId.",'notYet')");
       }
       $maxOrderSn=DB::select("SELECT MAX(SnOrder) AS mxsn from NewStarfood.dbo.FactorStar WHERE CustomerSn=".$customerId);
       $maxOrder=1;

       if(count($maxOrderSn)>0){

           foreach ($maxOrderSn as $mxsn) {
               $maxOrder=($mxsn->mxsn)+1;
           }

       }else{

           $maxOrder=1;

           }

       $FactorStarStatus=DB::select("SELECT OrderStatus from NewStarfood.dbo.FactorStar where CompanyNo=5 and CustomerSn=".$customerId." and SnOrder=".$maxOrder);
       $orderState=0;
       foreach ($FactorStarStatus as $status) {
           $orderState=$status->OrderStatus;
       }
       if($orderState==1){
               DB::insert("INSERT INTO NewStarfood.dbo.FactorStar (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)

               VALUES(5,".$maxOrder.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscalllYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
               $FactorStarSn=DB::select("SELECT MAX(SnOrder) as snOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".$customerId." and OrderStatus=0");
               $lastOrder;

               if(count($FactorStarSn)>0){

                   foreach ($FactorStarSn as $orderSn) {
                       $lastOrder=$orderSn->snOrder;
                   }

               }else{

                   $lastOrder=1;
                   }

               $fiPack=$exactPrice*$packAmount;
               DB::insert("INSERT INTO NewStarfood.dbo.orderStar(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4,Price1)

               VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".($amountUnit/$packAmount).",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,".$allMoneyFirst.")");
               Session::put('buy',1);
               $snlastBYS=DB::table('NewStarfood.dbo.orderStar')->max('SnOrderBYS');
               if($costLimit>0){
                   //add cost to AmelBYS
                   DB::table('NewStarfood.dbo.star_orderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$snlastBYS,
                   'SnAmel'=>$amelSn,'Price'=>$costLimit,'FiscalYear'=>Session::get("FiscalllYear"),'DescItem'=>"",'IsExport'=>1]);
               }
       }else{
               $FactorStarSn=DB::select("SELECT MAX(SnOrder) as snOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".$customerId." and OrderStatus=0");
               $lastOrder;
               if(count($FactorStarSn)>0){

                   foreach ($FactorStarSn as $orderSn) {
                       $lastOrder=$orderSn->snOrder;
                   }

               }else{

                   $lastOrder=1;

                   }

               $fiPack=$exactPrice*$packAmount;
               DB::insert("INSERT INTO NewStarfood.dbo.orderStar(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4,Price1)

               VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".($amountUnit/$packAmount).",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,".$allMoneyFirst.")");
               $snlastBYS=DB::table('NewStarfood.dbo.orderStar')->max('SnOrderBYS');
               if($costLimit<=$amountUnit){
                   //add cost to AmelBYS
                   DB::table('NewStarfood.dbo.star_orderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$snlastBYS,
                   'SnAmel'=>$amelSn,'Price'=>$costAmount,'FiscalYear'=>Session::get("FiscalllYear"),'DescItem'=>"",'IsExport'=>0]);
               }
               $buys=Session::get('buy');
               Session::put('buy',$buys+1);
        }

       return Response::json(mb_convert_encoding($snlastBYS, "HTML-ENTITIES", "UTF-8"));
    }

    public function addToBasketFromHomePage(Request $request)
    {
        $packType;
        $packAmount;
        $allPacks;
        $defaultUnit=0;
        $kalaId=$request->get('kalaId');
        $secondUnits=DB::select("select SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$kalaId);
        $defaultUnits=DB::select("select defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$kalaId);
        foreach ($defaultUnits as $unit) {
            $defaultUnit=$unit->defaultUnit;
        }
        if(count($secondUnits)>0){
            foreach ($secondUnits as $unit) {
                $packType=$unit->SnGoodUnit;
                $packAmount=$unit->AmountUnit;
            }
            }else{
                $packType=$defaultUnit;
                $packAmount=1;
            }
        $amountUnit=$request->get('amountUnit')*$packAmount;
        $amountBought=$request->get('amountUnit');
        $prices=DB::select("select GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$kalaId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $maxOrderNo=DB::select("select MAX(OrderNo) as maxNo from NewStarfood.dbo.FactorStar where CompanyNo=5");
        $maxOrder=0;
        if(count($maxOrderNo)>0){

            foreach ($maxOrderNo as $maxNo) {

                $maxOrder=$maxNo->maxNo;

                $maxOrder=$maxOrder+1;
            }

        }else{

            $maxOrder=1;

            }

        $todayDate = Jalalian::forge('today')->format('Y/m/d');
        $todayNow = Jalalian::forge('today')->format("%H:%M:%S");
        $customerId=Session::get('psn');
        $curTime=  Carbon::now();
        $dt=$curTime->format("Y-m-d H:i:s");
        $countOrders=DB::select("SELECT count(SnOrder) AS contOrder from NewStarfood.dbo.FactorStar WHERE OrderStatus=0 AND  CustomerSn=".$customerId);
        $countOrder=0;
        foreach ($countOrders as $countOrder1) {
            $countOrder=$countOrder1->contOrder;
        }
        $factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from Shop.dbo.OrderHDS WHERE CompanyNo=5");
        $factorNo;
        foreach ($factorNumber as $number) {
            $factorNo=$number->maxFact;
        }
        $factorNo=$factorNo+1;
        if($countOrder<1){
            DB::insert("INSERT INTO NewStarfood.dbo.FactorStar (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)

            VALUES(5,".$factorNo.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscalllYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
           $maxsFactor=DB::select("SELECT MAX(SnOrder) as maxFactorId from NewStarfood.dbo.FactorStar where CustomerSn=".$customerId);
           $maxsFactorId=0;
           foreach ($maxsFactor as $maxFact) {
            $maxsFactorId=$maxFact->maxFactorId;
           }
           DB::insert("INSERT INTO star_BuyTracking (factorStarId ,orderHDSId ,factorHDSId,customerId,pardakhtType) VALUES (".$maxsFactorId.", 0, 0,".$customerId.",'notYet')");
        }
        $maxOrderSn=DB::select("SELECT MAX(SnOrder) AS mxsn from NewStarfood.dbo.FactorStar WHERE CustomerSn=".$customerId);
        $maxOrder=1;

        if(count($maxOrderSn)>0){

            foreach ($maxOrderSn as $mxsn) {
                $maxOrder=($mxsn->mxsn)+1;
            }

        }else{

            $maxOrder=1;

            }

        $FactorStarStatus=DB::select("SELECT OrderStatus from NewStarfood.dbo.FactorStar where CompanyNo=5 and CustomerSn=".$customerId." and SnOrder=".$maxOrder);
        $orderState=0;
        foreach ($FactorStarStatus as $status) {
            $orderState=$status->OrderStatus;
        }
        if($orderState==1){
            DB::insert("INSERT INTO NewStarfood.dbo.FactorStar (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)

            VALUES(5,".$maxOrder.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscalllYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
            $FactorStarSn=DB::select("SELECT MAX(SnOrder) as snOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".$customerId." and OrderStatus=0");
    $lastOrder;

    if(count($FactorStarSn)>0){

        foreach ($FactorStarSn as $orderSn) {
            $lastOrder=$orderSn->snOrder;
        }

    }else{

        $lastOrder=1;

        }
    $fiPack=$allMoney/$packAmount;

    DB::insert("INSERT INTO NewStarfood.dbo.orderStar(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

    VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
    Session::put('buy',1);
}else{
    $FactorStarSn=DB::select("SELECT MAX(SnOrder) as snOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".$customerId." and OrderStatus=0");
    $lastOrder;

    if(count($FactorStarSn)>0){

        foreach ($FactorStarSn as $orderSn) {
            $lastOrder=$orderSn->snOrder;
        }

    }else{

        $lastOrder=1;

        }

    $fiPack=$allMoney/$packAmount;
    DB::insert("INSERT INTO NewStarfood.dbo.orderStar(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
    VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
    $snlastBYS=DB::table('NewStarfood.dbo.orderStar')->max('SnOrderBYS');
    $buys=Session::get('buy');
    Session::put('buy',$buys+1);
        }

        return Response::json(mb_convert_encoding($snlastBYS, "HTML-ENTITIES", "UTF-8"));
    }

    public function updateBasketItem(Request $request)
    {
        $costAmount=0;
        $amelSn=0;
        $costLimit=0;
        $defaultUnit;
        $packType;
        $packAmount;
        $orderBYSsn=$request->get('orderBYSSn');
        $amountUnit=$request->get('amountUnit');
        $productId=$request->get('kalaId');

        $secondUnits=DB::select("select SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$productId);
        $defaultUnits=DB::select("select defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$productId);
        foreach ($defaultUnits as $unit) {
            $defaultUnit=$unit->defaultUnit;
        }
        if(count($secondUnits)>0){
            foreach ($secondUnits as $unit) {
                $packType=$unit->SnGoodUnit;
                $packAmount=$unit->AmountUnit;
            }
            }else{
                $packType=$defaultUnit;
                $packAmount=1;
            }

        $checkExistance=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$productId)->select("*")->get();
        foreach ($checkExistance as $pr) {
            $costLimit=$pr->costLimit;
            $costAmount=$pr->costAmount;
            $amelSn=$pr->inforsType;
        }
        $prices=DB::select("select GoodPriceSale.Price3,GoodPriceSale.Price4 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        $exactPrice1=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
            $exactPrice1=$price->Price4;
        }
        $allMoney= $exactPrice * $amountUnit;
        $allMoneyFirst= $exactPrice1 * $amountUnit;
        $fiPack=$exactPrice*$packAmount;
        DB::update("UPDATE NewStarfood.dbo.orderStar SET Amount=".$amountUnit.",PackAmount=($amountUnit/$packAmount),Price=".$allMoney.",Price1=".$allMoneyFirst.",FiPack=".$fiPack.",PriceAfterTakhfif=$allMoney WHERE SnOrderBYS=".$orderBYSsn);
        $checkExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$orderBYSsn)->count();
        if($checkExistance<1 and $costLimit>0){
            //add cost to AmelBYS
            DB::table('NewStarfood.dbo.star_orderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$orderBYSsn,
            'SnAmel'=>$amelSn,'Price'=>$costAmount,'FiscalYear'=>Session::get("FiscalllYear"),'DescItem'=>"",'IsExport'=>0]);
        }
        return Response::json(mb_convert_encoding($allMoney, "HTML-ENTITIES", "UTF-8"));
    }

    public function updateBasketItemFromHomePage(Request $request)
    {
        $orderBYSsn=$request->get('orderBYSSn');
        $amountUnit=$request->get('amountUnit');
        $productId=$request->get('kalaId');
        $defaultUnit;
        $defaultUnits=DB::select("SELECT UName FROM Shop.dbo.PubGoods JOIN Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.GoodSn=".$productId);
        foreach ($defaultUnits as $unit) {
            $defaultUnit=$unit->UName;
        }
        $secondUnits=DB::select("select SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$productId);
        if(count($secondUnits)>0){
            foreach ($secondUnits as $unit) {
                $packType=$unit->SnGoodUnit;
                $packAmount=$unit->AmountUnit;
            }
        }else{
            $packType=$defaultUnit;
            $packAmount=1;
        }
        $amountUnit=$request->get('amountUnit')*$packAmount;
        $amountBought=$request->get('amountUnit');
        $prices=DB::select("select GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $fiPack=$exactPrice*$packAmount;
        if($amountUnit>0){
        DB::update("UPDATE NewStarfood.dbo.orderStar SET Amount=".$amountUnit.",PackAmount=$amountBought ,Price=".$allMoney.",FiPack=".$fiPack.",PriceAfterTakhfif=$allMoney WHERE SnOrderBYS=".$orderBYSsn);
        return Response::json('good');
        }else{
        DB::delete('DELETE FROM NewStarfood.dbo.orderStar WHERE SnOrderBYS='.$orderBYSsn);
        return Response::json('good');
        }

    }

    public function deleteBasketItem(Request $request)
    {
        $snBYS=$request->POST('SnOrderBYS');
        DB::delete('DELETE FROM NewStarfood.dbo.orderStar WHERE SnOrderBYS='.$snBYS);
        $buys=Session::get('buy');
        Session::put('buy',$buys-1);
        return Response::json(1);
    }

    public function deletePishKharidBasketItem(Request $request){
        
        $orderId=$request->get("SnOrderBYS");
        DB::table("NewStarfood.dbo.star_pishKharidOrder")->where("SnOrderBYSPishKharid",$orderId)->delete();
        return Response::json(1);
    }

    public function getUnSentBasketItems(Request $request)
    {
        $factorId=$request->get("id");
        //without stocks----------------------------------------------
        $orders=DB::select("SELECT PubGoods.GoodCde,star_pishKharidOrderAfter.SnOrderBYSPishKharidAfter,PubGoods.GoodName,NewStarfood.dbo.star_pishKharidOrderAfter .Fi,NewStarfood.dbo.star_pishKharidOrderAfter .Amount,NewStarfood.dbo.star_pishKharidOrderAfter .Price,NewStarfood.dbo.getFirstUnit(GoodSn) as firstUnitName,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnitName FROM NewStarfood.dbo.star_pishKharidOrderAfter 
        JOIN Shop.dbo.PubGoods ON PubGoods.GoodSn=NewStarfood.dbo.star_pishKharidOrderAfter.SnGood
        WHERE SnHDS=$factorId and star_pishKharidOrderAfter.SnGood not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and  preBuyState=0
        ");
        foreach ($orders as $order) {
            if(!$order->secondUnitName){

                $order->secondUnitName=$order->firstUnitName;

            }
        }
        return Response::json($orders);
    }
    public function updateOrderBYS(Request $request)
    {
        $costAmount=0;
        $amelSn=0;
        $costLimit=0;
        $defaultUnit;
        $packType;
        $packAmount;
        $orderBYSsn=$request->get('orderBYSSn');
        $amountUnit=$request->get('amountUnit');
        $productId=$request->get('kalaId');

        $secondUnits=DB::select("select SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$productId);
        $defaultUnits=DB::select("select defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$productId);
        foreach ($defaultUnits as $unit) {
            $defaultUnit=$unit->defaultUnit;
        }
        if(count($secondUnits)>0){
            foreach ($secondUnits as $unit) {
                $packType=$unit->SnGoodUnit;
                $packAmount=$unit->AmountUnit;
            }
            }else{
                $packType=$defaultUnit;
                $packAmount=1;
            }

        $checkExistance=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$productId)->select("*")->get();
        foreach ($checkExistance as $pr) {
            $costLimit=$pr->costLimit;
            $costAmount=$pr->costAmount;
            $amelSn=$pr->inforsType;
        }
        $prices=DB::select("select GoodPriceSale.Price3,GoodPriceSale.Price4 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        $exactPrice1=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
            $exactPrice1=$price->Price4;
        }
        $allMoney= $exactPrice * $amountUnit;
        $allMoneyFirst= $exactPrice1 * $amountUnit;
        $fiPack=$exactPrice*$packAmount;
        DB::update("UPDATE NewStarfood.dbo.orderStar SET Amount=".$amountUnit.",PackAmount=($amountUnit/$packAmount),Price=".$allMoney.",Price1=".$allMoneyFirst.",FiPack=".$fiPack.",PriceAfterTakhfif=$allMoney WHERE SnOrderBYS=".$orderBYSsn);
        $checkExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$orderBYSsn)->count();
        if($checkExistance<1 and $costLimit>0){
            //add cost to AmelBYS
            DB::table('NewStarfood.dbo.star_orderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$orderBYSsn,
            'SnAmel'=>$amelSn,'Price'=>$costAmount,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>"",'IsExport'=>0]);
        }
        return Response::json(mb_convert_encoding($allMoney, "HTML-ENTITIES", "UTF-8"));
    }

    public function deleteOrderBYS(Request $request)
    {
        $snBYS=$request->get('SnOrderBYS');
        DB::delete('DELETE FROM NewStarfood.dbo.orderStar WHERE SnOrderBYS='.$snBYS);
        return Response::json('good');
    }

    public function shippingData(Request $request)
    {
        $customerId=$request->get('psn');
        $allMoney=$request->get('allMoney');
        $profit=$request->get('profit');
        $customers=DB::select('SELECT Peopels.* FROM Shop.dbo.Peopels WHERE PSN='.$customerId);
        $customer;
        foreach ($customers as $customer) {
            $customer=$customer;
        }
        $tomorrowDate= Carbon::now()->addDays(1);//فردا جمع یک
        
        $tomorrow=$tomorrowDate->dayOfWeek;

        $afterTomorrowDate = Carbon::now();
        $twoDaysLater = $afterTomorrowDate->addDays(2);// پس فردا جمع دو
        $afterTomorrow= $twoDaysLater->dayOfWeek;

        if($tomorrow==5){
            $tomorrowDate = $tomorrowDate->addDays(1);
            $twoDaysLater = $twoDaysLater->addDays(1);
        }
        $tomorrow=$tomorrowDate->dayOfWeek;
        $afterTomorrow= $twoDaysLater->dayOfWeek;

        if($afterTomorrow==5){
            $twoDaysLater = $twoDaysLater->addDays(1);
        }
        $afterTomorrow= $twoDaysLater->dayOfWeek;
        $day1;
        switch ($tomorrow) {
            case 6:
                $day1='شنبه';
                break;
            case 0:
                $day1='یکشنبه';
                break;
            case 1:
                $day1='دوشنبه';
                break;
            case 2:
                $day1='سه شنبه';
                break;
            case 3:
                $day1='چهار شنبه';
                break;
            case 4:
                $day1='پنج شنبه';
                break;
            case 5:
                $day1='جمعه';
                break;

            default:
                # code...
                break;
        }
        $day2;
        switch ($afterTomorrow) {
            case 6:
                $day2='شنبه';
                break;
            case 0:
                $day2='یکشنبه';
                break;
            case 1:
                $day2='دوشنبه';
                break;
            case 2:
                $day2='سه شنبه';
                break;
            case 3:
                $day2='چهار شنبه';
                break;
            case 4:
                $day2='پنج شنبه';
                break;
            case 5:
                $day2='جمعه';
                break;
            default:
                # code...
                break;
        }
        $customerRestrictions=DB::select("SELECT * FROM  NewStarfood.dbo.star_customerRestriction where customerId=$customerId");
        $pardakhtLive=0;
        foreach ($customerRestrictions as $restrict) {
            $pardakhtLive=$restrict->pardakhtLive;
        }
        $webSpecialSettings=DB::table('NewStarfood.dbo.star_webSpecialSetting')->select("*")->get();
        $moorningActive=0;
        $afternoonActive=0;
        $settings=array();
        foreach ($webSpecialSettings as  $setting) {
            // $moorningActive=$settings->moorningActive;
            // $afternoonActive=$settings->afternoonActive;
            // $moorningContent=$settings->moorningTimeContent;
            // $afternoonContent=$settings->afternoonTimeContent;
            $settings=$setting;
        }

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }
        //برای محاسبه کیف تخفیفی
        $walletInfo=new Customer;
        $allMoneyTakhfifResult=(int)($walletInfo->getTakhfifCaseMoneyAfterNazarSanji($customerId));

        $addresses=DB::select("SELECT * FROM Shop.dbo.PeopelAddress where  SnPeopel=$customerId");
        return Response::json(['date1'=>$day1,'date2'=>$day2,'customer'=>$customer,'takhfifCase'=>$allMoneyTakhfifResult
        ,'allMoney'=>$allMoney,'profit'=>$profit, 'tomorrowDate'=>$tomorrowDate,'afterTomorrowDate'=>$twoDaysLater
        ,'pardakhtLive'=>$pardakhtLive,'setting'=>$settings,'currency'=>$currency,'currencyName'=>$currencyName,
        'addresses'=>$addresses]);
    }

    public function successFactorInfo(Request $request){
        $customerSn=$request->get('psn');
        $lastOrderSnStar=DB::table("NewStarfood.dbo.FactorStar")->where("OrderStatus",1)->where("CustomerSn",$customerSn)->max("SnOrder");
        if($lastOrderSnStar>0){
            DB::update("UPDATE   NewStarfood.dbo.FactorStar SET OrderStatus=1 WHERE  SnOrder=".$lastOrderSnStar);
        }
        $factorNo=DB::table("NewStarfood.dbo.OrderHDSS")->where("CustomerSn",$customerSn)->max("OrderNo");
        $factorBYS=DB::select("SELECT orderStar.*,PubGoods.GoodName FROM NewStarfood.dbo.orderStar join Shop.dbo.PubGoods on orderStar.SnGood=PubGoods.GoodSn WHERE SnHDS=".$lastOrderSnStar);
        $amountUnit=1;
        $defaultUnit;
        foreach ($factorBYS as $buy) {
            $kala=DB::select('select PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods inner join Shop.dbo.PUBGoodUnits
            on PubGoods.DefaultUnit=PUBGoodUnits.USN where PubGoods.CompanyNo=5 and PubGoods.GoodSn='.$buy->SnGood);
            foreach ($kala as $k) {
            $defaultUnit=$k->UName;
            $defaultUnit=$k->UName;
            }
            $subUnitStuff= DB::select("SELECT GoodUnitSecond.AmountUnit,PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$buy->SnGood);
            if(count($subUnitStuff)>0){
                foreach ($subUnitStuff as $stuff) {
                $secondUnit=$stuff->secondUnit;
                $amountUnit=$stuff->AmountUnit;
                }
            }else{
                $secondUnit=$defaultUnit;
            }
            $buy->firstUnit=$defaultUnit;
            $buy->secondUnit=$secondUnit;
            $buy->amountUnit=$amountUnit;
        }

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }
        
        return Response::json(['factorNo'=>$factorNo,'factorBYS'=>$factorBYS,'currency'=>$currency,'currencyName'=>$currencyName]);
    }

    public function cartsListApi(Request $request) {
        $defaultUnit;
        $changedPriceState=0;
        $customerId=$request->input("psn");
        $orderHDSs=DB::select("SELECT SnOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=$customerId and OrderStatus=0");
        $SnHDS=0;
        if(count($orderHDSs)>0){
            $SnHDS=$orderHDSs[0]->SnOrder;
        }
 
        $orderBYSs=DB::select("SELECT IIF(Fi=Pr.Price3,0,1) as changedPrice,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYS,orderStar.CompanyNo,orderStar.Price,orderStar.SnGood,Price1,SnHDS,PackAmount,orderStar.Amount,Fi,Pr.Price3,Pr.Price4,DateOrder,A.Amount as AmountExist,star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,iif(NewStarfood.dbo.getSecondUnit(GoodSn) is null,NewStarfood.dbo.getFirstUnit(GoodSn),NewStarfood.dbo.getSecondUnit(GoodSn)) as secondUnitName from Shop.dbo.PubGoods
                                JOIN NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood
                                JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=1402) A on PubGoods.GoodSn=A.SnGood
                                JOIN (select * from Shop.dbo.GoodPriceSale where FiscalYear=1402)Pr on Pr.SnGood=orderStar.SnGood
                                WHERE PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and SnHDS=".$SnHDS);
        //assign Currency and other info settings
        $currencyInfo=self::getCurrency();
        $currency=$currencyInfo["currency"];
        $currencyName=$currencyInfo["currencyName"];
        //logo position
        $logoPos=$currencyInfo["logoPosition"];
        //changed price or not
        if(count($orderBYSs)>0){
            $changedPriceState=$orderBYSs[0]->changedPrice;
        }
        //check time of updating factor or not
        $intervalBetweenBuys=1000;
        $MainIntervalBetweenBuys= DB::select("SELECT DATEDIFF(hour,CONVERT(DATETIME, (SELECT TimeStamp from NewStarfood.dbo.OrderHDSS where
        OrderHDSS.SnOrder=(select Max(SnOrder) from NewStarfood.dbo.OrderHDSS WHERE  CustomerSn=$customerId and isDistroy=0))), CURRENT_TIMESTAMP)
        AS DateDiff");
 
        if($MainIntervalBetweenBuys[0]->DateDiff){
            $intervalBetweenBuys=$MainIntervalBetweenBuys[0]->DateDiff;
        }else{
            $intervalBetweenBuys=$intervalBetweenBuys;
        }
 
        $minSalePriceFactor=1000;
        $pardakhtLive=0;
        $minSalePriceFactor=$currencyInfo["minSalePriceFactor"];
        
        $minimumFactorPrice=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction WHERE customerId=$customerId")[0]->minimumFactorPrice;
        if($minimumFactorPrice>0){
            $minSalePriceFactor=$minimumFactorPrice;
        }
        //used for پیش خرید
        $SnOrderPishKharid=DB::select("SELECT SnOrderPishKharid FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=$customerId and OrderStatus=0");
        $SnHDS=0;
        if(count($SnOrderPishKharid)>0){
            $SnHDS=$SnOrderPishKharid[0]->SnOrderPishKharid;
        }
        $orderPishKarids=DB::select("SELECT IIF(Fi!=Price3,0,1) as changedPric,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYSPishKharid,star_pishKharidOrder.CompanyNo,star_pishKharidOrder.Price,star_pishKharidOrder.SnGood,SnHDS,PackAmount,star_pishKharidOrder.Amount,Fi,Price3,Price4,DateOrder,A.Amount as AmountExist,NewStarfood.dbo.star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnitName from Shop.dbo.PubGoods
                                    JOIN NewStarfood.dbo.star_pishKharidOrder ON PubGoods.GoodSn=star_pishKharidOrder.SnGood
                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                    JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=1402) A ON PubGoods.GoodSn=A.SnGood
                                    WHERE NOT EXISTS(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 AND productId=PubGoods.GoodSn) AND SnHDS=".$SnHDS);
        return Response::json(['orders'=>$orderBYSs,'orderPishKarids'=>$orderPishKarids,'intervalBetweenBuys'=>$intervalBetweenBuys,'minSalePriceFactor'=>$minSalePriceFactor,'changedPriceState'=>$changedPriceState,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }


    public function updateChangedPriceApi(Request $request){
        $SnHDS=$request->get('SnHDS');
        $defaultUnit;
        $changedPriceState=0;
        $customerId=$request->get('psn');

        $orderBYSs=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,orderStar.*,PUBGoodUnits.UName from Shop.dbo.PubGoods join NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood inner join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE SnHDS=".$SnHDS);
        //در صورتیکه قیمت ها تغییر کرده باشند
        foreach ($orderBYSs as $order) {
            $prices=DB::select("SELECT * FROM Shop.dbo.GoodPriceSale where SnGood=".$order->GoodSn);
            foreach ($prices as $price) {
                if($order->Fi != $price->Price3){
                    DB::update("UPDATE NewStarfood.dbo.orderStar SET orderStar.Fi=".$price->Price3.",orderStar.Price=".($price->Price3*$order->Amount).",orderStar.FiPack=".(($price->Price3*$order->Amount)/$order->PackAmount).",orderStar.PriceAfterTakhfif=".($price->Price3*$order->Amount).",orderStar.RealFi=".$price->Price3.",orderStar.RealPrice=".$price->Price3*$order->Amount." WHERE SnHDS=".$SnHDS." and SnGood=".$order->GoodSn);
                }
            }
        }
        
        // get data to send back


        $orderHDSs=DB::select("SELECT SnOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=$customerId and OrderStatus=0");
        $SnHDS=0;
        if(count($orderHDSs)>0){
            $SnHDS=$orderHDSs[0]->SnOrder;
        }
 
        $orderBYSs=DB::select("SELECT IIF(Fi!=Price3,0,1) as changedPrice,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYS,orderStar.CompanyNo,orderStar.Price,orderStar.SnGood,Price1,SnHDS,PackAmount,orderStar.Amount,Fi,Price3,Price4,DateOrder,A.Amount as AmountExist,star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,iif(NewStarfood.dbo.getSecondUnit(GoodSn) is null,NewStarfood.dbo.getFirstUnit(GoodSn),NewStarfood.dbo.getSecondUnit(GoodSn)) as secondUnitName from Shop.dbo.PubGoods
        JOIN NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood
        JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
        JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A on PubGoods.GoodSn=A.SnGood
        WHERE PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and SnHDS=".$SnHDS);
        //assign Currency and other info settings
        $currencyInfoObj=new Carts;
        $currencyInfo=$currencyInfoObj->getCurrency();
        $currency=$currencyInfo["currency"];
        $currencyName=$currencyInfo["currencyName"];
        //logo position
        $logoPos=$currencyInfo["logoPosition"];
        //changed price or not
        if(count($orderBYSs)>0){
            $changedPriceState=$orderBYSs[0]->changedPrice;
        }
        //check time of updating factor or not
        $intervalBetweenBuys=1000000;
        $MainIntervalBetweenBuys= DB::select("SELECT DATEDIFF(hour,CONVERT(DATETIME, (SELECT TimeStamp from NewStarfood.dbo.OrderHDSS where
        OrderHDSS.SnOrder=(select Max(SnOrder) from NewStarfood.dbo.OrderHDSS WHERE  CustomerSn=$customerId and isDistroy=0))), CURRENT_TIMESTAMP)
        AS DateDiff");
 
        if($MainIntervalBetweenBuys[0]->DateDiff){
            $intervalBetweenBuys=$MainIntervalBetweenBuys[0]->DateDiff;
        }else{
            $intervalBetweenBuys=$intervalBetweenBuys;
        }
 
        $minSalePriceFactor=1000;
        $pardakhtLive=0;
        $minSalePriceFactor=$currencyInfo["minSalePriceFactor"];
        $afternoonTitle=$currencyInfo["moorningTimeContent"];
        $moorningTitle=$currencyInfo["afternoonTimeContent"];
        
        $minimumFactorPrice=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction WHERE customerId=$customerId")[0]->minimumFactorPrice;
        if($minimumFactorPrice>0){
            $minSalePriceFactor=$minimumFactorPrice;
        }
        //used for پیش خرید
        $SnOrderPishKharid=DB::select("SELECT SnOrderPishKharid FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=$customerId and OrderStatus=0");
        $SnHDS=0;
        if(count($SnOrderPishKharid)>0){
            $SnHDS=$SnOrderPishKharid[0]->SnOrderPishKharid;
        }
        $orderPishKarids=DB::select("SELECT IIF(Fi!=Price3,0,1) as changedPric,PubGoods.GoodName,PubGoods.GoodSn,SnOrderBYSPishKharid,star_pishKharidOrder.CompanyNo,star_pishKharidOrder.Price,star_pishKharidOrder.SnGood,SnHDS,PackAmount,star_pishKharidOrder.Amount,Fi,Price3,Price4,DateOrder,A.Amount as AmountExist,NewStarfood.dbo.star_GoodsSaleRestriction.freeExistance,NewStarfood.dbo.getFirstUnit(GoodSn) as UName,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnitName from Shop.dbo.PubGoods
                                    JOIN NewStarfood.dbo.star_pishKharidOrder ON PubGoods.GoodSn=star_pishKharidOrder.SnGood
                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                    JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A ON PubGoods.GoodSn=A.SnGood
                                    WHERE NOT EXISTS(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 AND productId=PubGoods.GoodSn) AND SnHDS=".$SnHDS);
        return Response::json(['orders'=>$orderBYSs,'orderPishKarids'=>$orderPishKarids,'intervalBetweenBuys'=>$intervalBetweenBuys,'minSalePriceFactor'=>$minSalePriceFactor,'changedPriceState'=>$changedPriceState,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    
}
