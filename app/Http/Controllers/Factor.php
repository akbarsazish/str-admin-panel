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
use Pasargad\Pasargad;
use Pasargad\Classes\PaymentItem;
class Factor extends Controller{
    public function addFactor(Request $request){
        $orderHDS=$request->post("orderHDS");
        $factorWasRemained=0;
        $lastFactSN=0;
        $factDate=$request->post("sendOrderDate");
        $fiscallYear=Session::get('FiscallYear');
        $stockId=$request->post("stockId");
        $willAppendToFactor=0;
//         DB::beginTransaction();

// try {
        //خواندن داده ها از سفارش ارسالی
        $orders=DB::select("SELECT * FROM NewStarfood.dbo.OrderHDSS where isSent=0 and SnOrder=$orderHDS");
        if(count($orders)>0){
            //در صورتیکه سفارش قبلا توسط کاربر دیگر ارسال نشده باشد!
            $orderbys=DB::table("NewStarfood.dbo.orderBYSS")->where("SnHDS",$orderHDS)->get();
            $netPriceOrder=0;
            foreach($orderbys as $order){
                $amount=DB::select("SELECT Amount,NewStarfood.dbo.getAmountUnit(SnGood) as AmountUnit FROM Shop.dbo.ViewGoodExistsInStock WHERE SnGood=$order->SnGood AND CompanyNo=5 AND FiscalYear=".$fiscallYear." AND SnStock=$stockId");
                if($amount[0]->Amount < $order->Amount){
                    $amountUnit=$amount[0]->AmountUnit;
                    $newPackAmount=(int)(($amount[0]->Amount)/$amountUnit);
                        $factorWasRemained=1;
                    $newAmount=$newPackAmount*$amountUnit;
                    $newPice=$newAmount*$order->Fi;
                    $netPriceOrder+=$newPice;
                    $remainedPackAmount=((int)($order->Amount/$amountUnit))-$newPackAmount;
                    $reamainedAmount=$remainedPackAmount*$amountUnit;
                    $remainedPice=$reamainedAmount*$order->Fi;
                }else{
                    $netPriceOrder+=$order->Price;
                }
            }

            // return $factorWasRemained;
            $order=$orders[0];
            
            $customerSn=$order->CustomerSn;
            
            $takhfif=$order->Takhfif;//
            $inVoiceNumber=$order->InVoiceNumber;//
            
            $factDesc=$order->OrderDesc;
            $SnGetAndPay=0;
        
            $netPriceHDS=$netPriceOrder;
            $payedPriceHDS=$order->payedMoney;
            $isOnline=$order->isPayed;
            $inforPriceHDS=0;
            $factTime=Carbon::now()->format("H:i:s");
            $otherAddress=$order->OrderAddress;
            $ersalTime=$order->OrderErsalTime;
            $snAddress=$order->OrderSnAddress;

            $factNo=1;
            $factNo=DB::table("Shop.dbo.FactorHDS")->where("FactType",3)->where("CompanyNo",5)->max("FactNo");
            $sendedFactorInfo=[];
            $sendedFactorInfo=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE FactDate='$factDate' AND OtherAddress='$otherAddress' AND CustomerSn=$customerSn");
            if(count($sendedFactorInfo)<1){
                DB::table("Shop.dbo.FactorHDS")->insert([
                "CompanyNo"=>5
                ,"FactType"=>3
                ,"FactNo"=>$factNo+1
                ,"FactDate"=>"$factDate"
                ,"CustomerSn"=>$customerSn
                ,"takhfif"=>$takhfif
                ,"FactDesc"=>"$factDesc"
                ,"FiscalYear"=>"$fiscallYear"
                ,"SnGetAndPay"=>$SnGetAndPay
                ,"NetPriceHDS"=>$netPriceHDS
                ,"InforPriceHDS"=>$inforPriceHDS
                ,"SnStockIn"=>$stockId
                ,"SnUser1"=>21
                ,"FactTime"=>"$factTime"
                ,"OtherAddress"=>"$otherAddress"
                ,"ErsalTime"=>$ersalTime
                ,"SnAddress"=>$snAddress
                ]);

                $lastFactSN=DB::table("Shop.dbo.FactorHDS")->max("SerialNoHDS");
            }else{
                $lastFactSN=$sendedFactorInfo[0]->SerialNoHDS;
                $willAppendToFactor=1;
                //DB::table("Shop.dbo.FactorHDS")->where("CustomerSn",$customerSn)->max("SerialNoHDS");
            }
            //ثبت سفارش باقی مانده فاکتور
            $factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
            $factorNo=0;
            foreach ($factorNumber as $number) {
                $factorNo=$number->maxFact;
            }
            $factorNo=$factorNo+1;
            if($factorWasRemained==1){
                DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress,isSent,isPayed,payedMoney,InVoiceNumber)
                VALUES(5,$factorNo,'$factDate',$customerSn,'باقی مانده است',0,'','','".$fiscallYear."',0,0,3,'$otherAddress','',0,'','',0,0,0,0,0,'','','','',0,0,0,'',0,'$factTime',0,0,0,0,0,0,'','',0,0,0,0,0,'','',1,$snAddress,0,0,0,0)");
            }

            if($isOnline==1){
                //آخرین شماره سند
                 $lastDocNoHds=DB::table("Shop.dbo.GetAndPayHDS")->where("GetOrPayHDS",1)->max("DocNoHDS");
                //وارد جدول سطح بالای داد و گرفت
                DB::table("Shop.dbo.GetAndPayHDS")->insert(
                ["CompanyNo"=>5
                ,"GetOrPayHDS"=>1
                ,"DocNoHDS"=>$lastDocNoHds+1//auto increment according to HDS 
                ,"DocDate"=>"".Jalalian::fromCarbon(Carbon::today())->format('Y/m/d').""//فارسی تاریخ
                ,"DocDescHDS"=>".آنلاین پرداخت شد"
                ,"StatusHDS"=>0
                ,"PeopelHDS"=>$customerSn
                ,"FiscalYear"=>"".$fiscallYear.""
                ,"SnFactor"=>0
                ,"InForHDS"=>0
                ,"NetPriceHDS"=>$payedPriceHDS//مبلغ به ریال
                ,"DocTypeHDS"=>0
                ,"SnCashMaster"=>851
                ,"BuyFactNo"=>0
                ,"SaveTime"=>"".Jalalian::fromCarbon(Carbon::now())->format('H:i:s').""//ساعت دقیقه و ثانیه فعلی
                ,"IsExport"=>0
                ,"AmanatiOrZemanati"=>0
                ,"PriceMaliat"=>0
                ,"SnUser"=>0
                ,"SnFactBuy"=>0
                ,"SnTafHazineh"=>0
                ,"SnNamayeshgah2"=>0
                ,"SnBuyEX"=>0
                ,"SnToCash"=>0
                ,"NaghdiPrice"=>0
                ,"SnKoodak"=>0
                ,"SnSeller"=>0
                ,"SnSerialNoFromPablet"=>0
                ,"SnChequeTransBargashti"=>0
                ,"PayIsBabatChequeBargashti"=>0
                ,"GAPSnTaf1"=>0
                ,"GAPTafType1"=>0
                ,"GAPSnTaf2"=>0
                ,"GAPTafType2"=>0
                ,"ExportSanadGAP"=>0
                ,"SnFactForTasviyeh"=>$lastFactSN//آخرین فاکتور
                ,"MazanehPrice"=>0
                ,"Fi_1_GramTala"=>0
                ,"VaznTala"=>0
                ,"SnGapHDSTablet"=>0
                ,"SnGapSellerTablet"=>0
                ,"SnOldFactForTasviyeh"=>0]);

                //آخرین شماره ورود جدول سطح بالای داد و گرفت
                $lastSnPayHDS=DB::table("Shop.dbo.GetAndPayHDS")->max("SerialNoHDS");
                //جدول سطح دوم داد و گرفت
                DB::table("Shop.dbo.GetAndPayBYS")->insert(
                    ["CompanyNo"=>5
                    ,"DocTypeBYS"=>3
                    ,"Price"=>$payedPriceHDS
                    ,"ChequeDate"=>"".Jalalian::fromCarbon(Carbon::today())->format('Y/m/d').""
                    ,"ChequeNo"=>0
                    ,"AccBankno"=>""
                    ,"Owner"=>""
                    ,"SnBank"=>0
                    ,"Branch"=>""
                    ,"SnChequeBook"=>0
                    ,"FiscalYear"=>"".$fiscallYear.""
                    ,"SnHDS"=>$lastSnPayHDS
                    ,"DocDescBYS"=>"پرداخت آنلاین"
                    ,"StatusBYS"=>0
                    ,"ChequeRecNo"=>0
                    ,"CuType"=>0
                    ,"CuPrice"=>0
                    ,"SnAccBank"=>46
                    ,"LastSnTrans"=>0
                    ,"CashNo"=>0
                    ,"SnPriorDetail"=>0
                    ,"SnMainPeopel"=>0
                    ,"SnTransChequeRefrence"=>0
                    ,"IsExport"=>0
                    ,"RadifInDaftarCheque"=>0
                    ,"CuUnitPrice"=>0
                    ,"SnBigIntHDSFact_GapBYS"=>0
                    ,"NoPayaneh_KartKhanBys"=>""
                    ,"KarMozdPriceBys"=>0
                    ,"NoSayyadi"=>""
                    ,"NameSabtShode"=>""
                    ,"SnOldBysGAP"=>0
                    ,"SnOldHDSGAP"=>0
                    ,"SnSellerGap"=>0]);
                DB::table("NewStarfood.dbo.payedOnline")->insert([
                    'factorSn'=>$lastFactSN,
                    'payedMoney'=>$payedPriceHDS,
                    'invoiceNumber'=>"$inVoiceNumber"
                ]);    
            }
            //وارد کردن داده های جدول زیر شاخه فاکتور
            
            
            $orders=DB::table("NewStarfood.dbo.orderBYSS")->where("SnHDS",$orderHDS)->get();
            $lastSnOrder=DB::select("SELECT MAX(SnOrder) as maxFact from NewStarfood.dbo.OrderHDSS")[0]->maxFact;
            $i=0;
            foreach($orders as $order){
                $i+=1;
                $amount=DB::select("SELECT Amount,NewStarfood.dbo.getAmountUnit(SnGood) as AmountUnit FROM Shop.dbo.ViewGoodExistsInStock WHERE SnGood=$order->SnGood AND CompanyNo=5 AND FiscalYear=$fiscallYear AND SnStock=23");
                if($amount[0]->Amount < $order->Amount){
                    $amountUnit=$amount[0]->AmountUnit;
                    $newPackAmount=(int)(($amount[0]->Amount)/$amountUnit);
                    $newAmount=$newPackAmount*$amountUnit;
                    $newPice=$newAmount*$order->Fi;
                    $remainedPackAmount=(int)(($order->Amount/$amountUnit))-$newPackAmount;
                    $reamainedAmount=$remainedPackAmount*$amountUnit;
                    $remainedPice=$reamainedAmount*$order->Fi;
                    if($newPackAmount>0){
                        DB::table("Shop.dbo.FactorBYS")->insert([
                            "CompanyNo"=>5
                            ,"SnFact"=>$lastFactSN
                            ,"SnGood"=>$order->SnGood
                            ,"PackType"=>$order->PackType
                            ,"PackAmnt"=>$newPackAmount
                            ,"Amount"=>$newAmount
                            ,"Fi"=>$order->Fi
                            ,"Price"=>$newPice
                            ,"FiPack"=>$order->FiPack
                            ,"SnStockBYS"=>$stockId
                            ,"PriceAfterAmel"=>0//کار شود
                            ,"FiAfterAmel"=>0//ک ش
                            ,"ItemNo"=>$i// ک ش
                            ,"PriceAfterTakhfif"=>$newPice//ک ش
                            ,"RealFi"=>$order->Fi
                            ,"RealPrice"=>$newPice
                        ]);

                        if($willAppendToFactor>0){
                            DB::update("UPDATE Shop.dbo.FactorHDS set NetPriceHDS+=$newPice WHERE SerialNoHDS=$lastFactSN");
                        }
                        DB::table("NewStarfood.dbo.orderBYSS")->where("SnGood",$order->SnGood)->where("SnHDS",$orderHDS)->update(
                            ["PackAmount"=>$newPackAmount
                            ,"Amount"=>$newAmount
                            ,"Price"=>$newPice
                            ,"PriceAfterTakhfif"=>$newPice
                            ,"RealPrice"=>$newPice]);
                    }
                    //ثبت زیر شاخه های سفارش باقی مانده 
                    if($remainedPackAmount>0){
                        DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
                        VALUES(5,".($lastSnOrder).",".$order->SnGood.",".$order->PackType.",".($remainedPackAmount).",".$reamainedAmount.",".$order->Fi.",".$remainedPice.",'',0,'".$factDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$remainedPice.",0,0,".$remainedPice.",".$remainedPice.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                    }
                }else{
                    DB::table("Shop.dbo.FactorBYS")->insert([
                        "CompanyNo"=>5
                        ,"SnFact"=>$lastFactSN
                        ,"SnGood"=>$order->SnGood
                        ,"PackType"=>$order->PackType
                        ,"PackAmnt"=>$order->PackAmount
                        ,"Amount"=>$order->Amount
                        ,"Fi"=>$order->Fi
                        ,"Price"=>$order->Price
                        ,"FiPack"=>$order->FiPack
                        ,"SnStockBYS"=>$stockId
                        ,"PriceAfterAmel"=>0//کار شود
                        ,"FiAfterAmel"=>0//ک ش
                        ,"ItemNo"=>$i// ک ش
                        ,"PriceAfterTakhfif"=>$order->Price//ک ش
                        ,"RealFi"=>$order->Fi
                        ,"RealPrice"=>$order->Price
                    ]);
                    $price=$order->Price;
                    if($willAppendToFactor>0){
                        DB::update("UPDATE Shop.dbo.FactorHDS set NetPriceHDS+=$price WHERE SerialNoHDS=$lastFactSN");
                    }
                }
            }

            DB::table("NewStarfood.dbo.orderHDSS")->where("SnOrder",$orderHDS)->update(['isSent'=>1]);
            $specialSettings=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting");
            $moarrifInfo=DB::select("SELECT CAST(DATEDIFF(DAY,TimeStamp,CURRENT_TIMESTAMP)/30 AS INT) AS moarrifDate,PSN FROM Shop.dbo.Peopels WHERE PSN=$customerSn")[0];
            if($moarrifInfo->moarrifDate < $specialSettings[0]->useIntroMonth){
                $restrictions=DB::table('NewStarfood.dbo.star_customerRestriction')->where("customerId",$customerSn)->get();
                $introMoneyAmount=0;
                if(strlen(trim($restrictions[0]->introducerCode))>0){
                    $introMoneyPercent=$specialSettings[0]->useIntroPercent;
                    $introMoneyAmount=($introMoneyPercent/100)*$netPriceHDS;
                    $introducerCode=$restrictions[0]->introducerCode;
                    DB::update("UPDATE NewStarfood.dbo.star_customerRestriction 
								SET introMoneyAmount+=$introMoneyAmount WHERE 
								selfIntroCode='$introducerCode' AND customerId=$customerSn");
                }
            }
        }

        $orderAmelBYSS=DB::select("SELECT * FROM NewStarfood.dbo.orderAmelBYSS WHERE SnOrder=$orderHDS");
        if(count($orderAmelBYSS)>0){
            foreach ($orderAmelBYSS as $amel){
                DB::table("Shop.dbo.FactorBYSAmel")->insert(["CompanyNo"=>5
                ,"SnFact"=>$lastFactSN
                ,"SnAmel"=>$amel->SnAmel
                ,"Price"=>$amel->Price
                ,"FiscalYear"=>$fiscallYear
                ,"DescItem"=>$amel->DescItem]);
            }
        }
    //     DB::commit();
    //     // all good
    // } catch (\Exception $e) {
    //     DB::rollback();
    //     // something went wrong
    // }
        return redirect("/salesOrder");
    }

    function getFactorInfoForEdit(Request $request) {
        $factSn=$request->input("SnFactor");
        $factorInfo=DB::select("SELECT GoodSn,GoodCde,amel.SnAmel,G.GoodName NameGood,P.Name as Name,P.PCode as PCode,b.*,bazar.Name as BName,bazar.PCode BPCode,P.PSN,G.GoodName,F.FactDate,F.SerialNoHDS,F.FactNo,F.SnStockIn,F.OtherCustName,F.MobileOtherCust,F.OtherAddress,F.SerialNoHDS,F.FactDesc,NewStarfood.dbo.getFirstUnit(SnGood)FirstUnit,NewStarfood.dbo.getAmountUnit(SnGood)AmountUnit,NewStarfood.dbo.getSecondUnit(SnGood)SecondUnit FROM Shop.dbo.PubGoods G join Shop.dbo.FactorBYS b on G.GoodSn=b.SnGood join Shop.dbo.Stocks s  on b.SnStockBYS=s.SnStock join Shop.dbo.FactorHDS F on F.SerialNoHDS=b.SnFact join Shop.dbo.Peopels P on F.CustomerSn=P.PSN join Shop.dbo.Peopels bazar on BazaryabSn=bazar.PSN  LEFT JOIN SHop.dbo.FactorBYSAmel amel ON F.SerialNoHDS=amel.SnFact WHERE F.SerialNoHDS=$factSn AND s.CompanyNo=5");
        $stocks=DB::table('Shop.dbo.Stocks')->where("CompanyNo",5)->get();
        return Response::json(['factorInfo'=>$factorInfo,'stocks'=>$stocks]);
    }

    public function factorView(Request $request){
        $factorSn=$request->post("factorSn");
        $factorhds=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE SerialNoHDS=".$factorSn);
        $factorDate1;
        foreach ($factorhds as $factor) {
            $factorDate1=$factor->FactDate;
        }
        $factorBYS=DB::select("SELECT * FROM Shop.dbo.FactorBYS WHERE SnFact=".$factorSn);
        foreach ($factorBYS as $buy) {
            $defaultUnit;
            $kalaName;
            $secondUnit;
            $amountUnit;
            $kala=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods JOIN Shop.dbo.PUBGoodUnits
            ON PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn=".$buy->SnGood);
            foreach ($kala as $k) {
            $defaultUnit=$k->UName;
            $kalaName=$k->GoodName;
            }
            $subUnitStuff= DB::select("SELECT PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$buy->SnGood);
            if(count($subUnitStuff)>0){
            foreach ($subUnitStuff as $stuff) {
            $secondUnit=$stuff->secondUnit;
            }
            }else{
                $secondUnit=$defaultUnit;
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
            $buy->firstUnit=$defaultUnit;
            $buy->secondUnit=$secondUnit;
            $buy->GoodName=$kalaName;
            $factorDate=Carbon::parse($buy->TimeStamp);
            $buy->factorDate = $factorDate1;
            $buy->factorTime = Jalalian::fromCarbon($factorDate)->format('H:m:s');
        }
        return view('factors.cartView',['factorBYS'=>$factorBYS,'currency'=>$currency,'currencyName'=>$currencyName]);
    }

    public function indexApi(Request $request) {
        $customerSn=$request->get("psn");
        $rejectedFactors=DB::select("SELECT TOP 10 * FROM Shop.dbo.FactorHDS WHERE FactType=4 and CustomerSn=$customerSn ORDER BY FactDate DESC");
        
        return Response::json(['rejectedFactors'=>$rejectedFactors]);
    }

    public function factorViewApi(Request $request){
        $factorSn=$request->get("factorSn");
        $factorhds=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE SerialNoHDS=".$factorSn);
        $factorDate1;
        foreach ($factorhds as $factor) {
            $factorDate1=$factor->FactDate;
        }
        $factorBYS=DB::select("SELECT * FROM Shop.dbo.FactorBYS WHERE SnFact=".$factorSn);
        foreach ($factorBYS as $buy) {
            $defaultUnit;
            $kalaName;
            $secondUnit;
            $amountUnit;
            $kala=DB::select('SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods JOIN Shop.dbo.PUBGoodUnits
            ON PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn='.$buy->SnGood);
            foreach ($kala as $k) {
            $defaultUnit=$k->UName;
            $kalaName=$k->GoodName;
            }
            $subUnitStuff= DB::select("SELECT PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$buy->SnGood);
            if(count($subUnitStuff)>0){
            foreach ($subUnitStuff as $stuff) {
            $secondUnit=$stuff->secondUnit;
            }
            }else{
                $secondUnit=$defaultUnit;
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
            $buy->firstUnit=$defaultUnit;
            $buy->secondUnit=$secondUnit;
            $buy->GoodName=$kalaName;
            $factorDate=Carbon::parse($buy->TimeStamp);
            $buy->factorDate = $factorDate1;
            $buy->factorTime = Jalalian::fromCarbon($factorDate)->format('H:m:s');
        }
        return response()->json(['factorBYS'=>$factorBYS,'currency'=>$currency,'currencyName'=>$currencyName]);
    }

    public function salesFactors(Request $request){
      $fiscallYear=self::getSelectedFiscalYear();
      $factors=DB::select("SELECT * FROM(
        SELECT * FROM(
            SELECT H.SerialNoHDS,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver   where H.CompanyNo=5 and H.FiscalYear=1402 and FactType=3 and FactDate=Format(getdate(),'yyyy/MM/dd','fa-ir')
        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedAmount,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
    )C");
      $todayDrivers=DB::select("SELECT NameDriver driverName,H.CompanyNo,H.SnDriver,NoPaper,DatePeaper,MashinNo,DescPeaper,SnMasterBar FROM Shop.dbo.BargiryHDS H JOIN Shop.dbo.Sla_Drivers D on D.SnDriver=H.SnDriver WHERE H.CompanyNo=5 order by DatePeaper desc");
      $users=DB::select("SELECT * FROM Shop.dbo.Users WHERE CompanyNo=5");
      $stocks=DB::select("SELECT * FROM Shop.dbo.stocks where CompanyNo=5");
      return View("factors.salesFactors",['factors'=>$factors,'todayDrivers'=>$todayDrivers,'users'=>$users,'stocks'=>$stocks]);
    }

    public function getSelectedFiscalYear(){
      $settings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('*');
      return $settings[0]->FiscallYear;
    }

    public function getFactorBYSInfo(Request $request){
        $snFact=$request->input("snFact");
        $factorBYSs=DB::select("SELECT *,NewStarfood.dbo.getGoodName(SnGood)GoodName,CRM.dbo.getGoodCode(SnGood)GoodCode,NewStarfood.dbo.getFirstUnit(SnGood)FirstUnit,NewStarfood.dbo.getSecondUnit(SnGood)SecondUnit FROM Shop.dbo.FactorBYS where SnFact=$snFact");
        return response()->json($factorBYSs);
    }
    public function getDriverFactors(Request $request){
        $snMaster=$request->get("SnMasterBar");
        $factors=DB::select("
        SELECT FactNo,FactDate,CRM.dbo.getCustomerName(CustomerSn)Name,CRM.dbo.getCustomerPCode(CustomerSn)PCode,NetPriceHDS,FactDesc,NaghdPrice,KartPrice,VarizPrice,TakhfifPriceBar,DifPrice,CRM.dbo.getCustomerPeopelAddress(CustomerSn)peopeladdress,CRM.dbo.getCustomerPhoneNumbers(CustomerSn)PhoneStr FROM Shop.dbo.BargiryBYS b join Shop.dbo.FactorHDS f on b.SnFact=f.SerialNoHDS  WHERE b.CompanyNo=5 AND  b.SnMaster=$snMaster");
        $kalas=DB::select("SELECT CRM.dbo.getGoodName(SnGood)GoodName,NewStarfood.dbo.getAmountUnit(SnGood)AmountUnit,allAmount%NewStarfood.dbo.getAmountUnit(SnGood)joze,CRM.dbo.getGoodCode(SnGood)GoodCde,CRM.dbo.getSecondUnitName(SnGood)SecondUnitName,NewStarfood.dbo.getFirstUnit(SnGood)FirstUnitName,* from (select sum(PackAmnt)packAmnt,sum(Amount)allAmount,sum(SumFewWeight)SumFewWeight,SnGood,COUNT(SnGood)countFactor FROM(
            SELECT SnGood,PackAmnt,Amount,PackType,Amount2Weight,SumFewWeight FROM Shop.dbo.BargiryBYS b join Shop.dbo.FactorBYS o on b.SnFact=o.SnFact where SnMaster=$snMaster)A GROUP BY SnGood)C");
        return Response::json(['factors'=>$factors,'kalas'=>$kalas,'status'=>"200 OK"]);
    }

    public function filterFactors(Request $request) {
        
        $factDate1="1399/01/01";
        $factDate2="1500/01/01";
        $factTime1="00:00:00";
        $factTime2="23:59:59";
        $factNo1=1;
        $factNo2=2000000;
        $customerName="";
        $setterName="";
        $factDesc="";
        $bazaryabName="";
        $stockName="";
        $tasvieyQPart="";
        $bargiryQPart="";
        if(strlen($request->input("factDate1"))>3){
            $factDate1=$request->input("factDate1");
        }
        if(strlen($request->input("factDate2"))>3){
            $factDate2=$request->input("factDate2");
        }
        if(strlen($request->input("factTime1"))>3){
            $factTime1=$request->input("factTime1").':00';
        }
        if(strlen($request->input("factTime2"))>3){
            $factTime2=$request->input("factTime2").':00';
        }
        if($request->input("factNo1")){
            $factNo1=$request->input("factNo1");
        }
        if($request->input("factNo2")){
            $factNo2=$request->input("factNo2");
        }
        if(strlen($request->input("customerName"))>3){
            $customerName=$request->input("customerName");
        }
        if(strlen($request->input("setterName"))>3){
            $setterName=$request->input("setterName");
        }
        if(strlen($request->input("factDesc"))>3){
            $factDesc=$request->input("factDesc");
        }
        if(strlen($request->input("bazaryabName"))>3){
            $bazaryabName=$request->input("bazaryabName");
        }        
        if(strlen($request->input("stockName"))>3){
            $stockName=$request->input("stockName");
        }

        if($request->input("tasviyehYes") and $request->input("tasviyehNo")){
            $tasvieyQPart="AND (tasviyehState='YES' OR tasviyehState='NO')";
        }else {
            if($request->input("tasviyehYes")){
                $tasvieyQPart="AND tasviyehState='YES'";
            }
            if($request->input("tasviyehNo")){
                $tasvieyQPart="AND tasviyehState='NO'";
            }
        }

        if($request->input("bargiryYes") and $request->input("bargiryNo")){
            $bargiryQPart="AND (bargiriyState='YES' OR bargiriyState='NO')";
        }else{
            if($request->input("bargiryYes")){
                $bargiryQPart="AND bargiriyState='YES'";
            }
            if($request->input("bargiryNo")){
                $bargiryQPart="AND bargiriyState='NO'";
            }
        }
        
        $factors=DB::select("SELECT * FROM(
                                SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                                    SELECT * FROM(
                                        SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                                        LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                                    )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                                )C 
                            )D	WHERE CompanyNo=5 AND FactType=3 $bargiryQPart $tasvieyQPart AND FactDate >= '$factDate1' AND FactDate <= '$factDate2'
                            AND FactTime>='$factTime1' AND FactTime <= '$factTime2' AND FactNo >= $factNo1 AND FactNo <= $factNo2
                            AND Name LIKE '%$customerName%' AND setterName LIKE '%$setterName%'
                            AND FactDesc LIKE '%$factDesc%' AND BazaryabName LIKE '%$bazaryabName%' AND stockName LIKE '%$stockName%' ORDER BY FactDate DESC");

        
     return Response::json($factors);
    }

    function getFactorHistory(Request $request) {
        $historyWord=$request->input("historyWord");
        $factors;
        switch ($historyWord) {
            case 'TODAY':
                {
                $factors=DB::select("SELECT * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 AND FactDate=FORMAT(getDate(),'yyyy/MM/dd','fa-ir')");
                }
                break;
            case 'YESTERDAY':
                {
                $factors=DB::select("SELECT * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 AND FactDate =FORMAT(convert(date,dateadd(day,-1,getdate())),'yyyy/MM/dd','fa-ir')");
                }
                break;
            case 'TOMORROW':
                {
                $factors=DB::select("SELECT * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 AND FactDate =FORMAT(convert(date,dateadd(day,1,getdate())),'yyyy/MM/dd','fa-ir')");
                }
                break;
            case 'AFTERTOMORROW':
                {
                $factors=DB::select("SELECT * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 AND FactDate =FORMAT(convert(date,dateadd(day,2,getdate())),'yyyy/MM/dd','fa-ir')");
                }
                break;
            case 'HUNDRED':
                {
                $factors=DB::select("SELECT top 100 * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 order by FactDate desc");
                }
                break;
            
            default:
                $factors=DB::select("SELECT * FROM(
                    SELECT *,iif(payedMoney>=NetPriceHDS,'YES','NO')tasviyehState FROM(
                        SELECT * FROM(
                            SELECT H.SerialNoHDS,NoPaper,H.FactType,iif(NoPaper>0,'YES','NO')bargiriyState,FactNo,FactDesc,NewStarfood.dbo.getAnbarName(SnStockIn)stockName,U.NameUser setterName,0 payType,H.NetPriceHDS,CountPrint,TotalPricePorsant,takhfif,SnUnitSales,FactDate,DateEelamBeAnbar,TimeEelamBeAnbar,DateBargiri,TimeBargiri,SnBazaryab2,BazaryabName,BarNameNo,NoPaper bargiriNo,DatePeaper as driverTahvilDate,NameDriver driverName,FactTime,CustomerSn,H.CompanyNo,PCode,Name FROM Shop.dbo.FactorHDS H join Shop.dbo.Peopels P on H.CustomerSn=P.PSN JOIN Shop.dbo.Users U on H.SnUser1=U.SnUser LEFT JOIN Shop.dbo.BargiryBYS B on H.SerialNoHDS=B.SnFact left join Shop.dbo.BargiryHDS BH on BH.SnMasterBar=B.SnMaster left join Shop.dbo.Sla_Drivers D on D.SnDriver=BH.SnDriver
                            LEFT JOIN (SELECT Name as BazaryabName ,PSN FROM Shop.dbo.Peopels) Bazaryab on Bazaryab.PSN=H.SnBazaryab2
                        )A LEFT JOIN (SELECT SUM(NetPriceHDS)payedMoney,SnFactForTasviyeh FROM Shop.dbo.GetAndPayHDS  GROUP BY SnFactForTasviyeh)b on A.SerialNoHDS=b.SnFactForTasviyeh
                    )C 
                )D	WHERE CompanyNo=5 AND FactType=3 AND FactDate =FORMAT(getDate(),'yyyy/MM/dd','fa-ir')");
                break;
        }

        return Response::json($factors);
    }
    function doEditFactor(Request $request) {
       $factNoEdit=$request->input("FactNoEdit");
       $serialNoHDS=$request->input("SerialNoHDSEdit");
       $psnEdit=$request->input("psnEdit");
       $stockEdit=$request->input("stockEdit");
       $factDateEdit=$request->input("FactDateEdit");
       $pCodeEdit=$request->input("pCodeEdit");
       $nameEdit=$request->input("NameEdit");
       $bazaryabCodeEdit=$request->input("bazaryabCodeEdit");
       $bazaryabNameEdit=$request->input("bazaryabNameEdit");
       $motafariqahNameEdit=$request->input("MotafariqahNameEdit");
       $motafariqahAddressEdit=$request->input("MotafariqahAddressEdit");
       $factDescEdit=$request->input("ّFactDescEdit");
       $tahvilTypeEdit=$request->input("TahvilTypeEdit");
       $sendTimeEdit=$request->input("SendTimeEdit");
       $editableGoods=$request->input("editableGoods");//arrays
       $netPriceHDS=0;
       DB::delete("DELETE FROM Shop.dbo.FactorBYS WHERE SnFact=$serialNoHDS AND SnGood not in( ".implode(",",$editableGoods).")");
       
       foreach ($editableGoods as $goodSn) {
            $nameGood=$request->input("NameGood".$goodSn);
            $firstUnit=$request->input("FirstUnit".$goodSn);
            $secondUnit=$request->input("SecondUnit".$goodSn);
            $packAmnt=str_replace(",", "",$request->input("PackAmnt".$goodSn));
            $jozeAmountEdit=str_replace(",", "",$request->input("JozeAmountEdit".$goodSn));
            $firstAmount=str_replace(",", "",$request->input("FirstAmount".$goodSn));
            $reAmount=str_replace(",", "",$request->input("ReAmount".$goodSn));
            $amount=str_replace(",", "",$request->input("Amount".$goodSn));
            $fi=str_replace(",", "",$request->input("Fi".$goodSn));
            $fiPack=str_replace(",", "",$request->input("FiPack".$goodSn));
            $price=str_replace(",", "",$request->input("Price".$goodSn));
            $priceAfterTakhfif=str_replace(",", "",$request->input("PriceAfterTakhfif".$goodSn));
            $nameStock=$request->input("NameStock".$goodSn);
            $price3PercentMaliat=str_replace(",", "",$request->input("Price3PercentMaliat".$goodSn));
            $fi2Weight=str_replace(",", "",$request->input("Fi2Weight".$goodSn));
            $amount2Weight=str_replace(",", "",$request->input("Amount2Weight".$goodSn));
            $service=str_replace(",", "",$request->input("Service".$goodSn));
            $percentMaliat=str_replace(",", "",$request->input("PercentMaliat".$goodSn));
            $packType=0;
            $packTypes=DB::table("Shop.dbo.GoodUnitSecond")->where("SnGood",$goodSn)->get();
            if(count($packTypes)>0){
                $packType=$packTypes[0]->SnGoodUnit;
            }else{
                $defaultUnits=DB::table("Shop.dbo.PubGoods")->where("GoodSn",$goodSn)->get();
                $packType=$defaultUnits[0]->DefaultUnit;
            }
            $netPriceHDS+=$price;

            //check if it is updateable
            $countEditable=DB::table("Shop.dbo.FactorBYS")->where("SnFact",$serialNoHDS)->where("SnGood",$goodSn)->count();
            if($countEditable>0){
                DB::table('Shop.dbo.FactorBYS')->where("SnGood",$goodSn)->where("SnFact",$serialNoHDS)->update([
                                                                "PackType"=>$packType
                                                                ,"PackAmnt"=>$packAmnt
                                                                ,"Amount"=>$amount
                                                                ,"Fi"=>$fi
                                                                ,"Price"=>$price
                                                                ,"SnOrderDetail"=>0
                                                                ,"FiPack"=>$fiPack
                                                                ,"SnStockBYS"=>23
                                                                ,"Price3PercentMaliat"=>$percentMaliat
                                                                ,"PriceAfterAmel"=>$price
                                                                ,"FiAfterAmel"=>$fi
                                                                ,"Amount2Weight"=>$amount2Weight
                                                                ,"Fi2Weight"=>$fi2Weight
                                                                ,"PriceAfterTakhfif"=>$price
                                                                ,"RealFi"=>$fi
                                                                ,"RealPrice"=>$price
                                                                ,"FirstAmout"=>$firstAmount
                                                                ,"ReAmount"=>$reAmount]);
            }
            //check if it is insertable

            if($countEditable==0){
                DB::table('Shop.dbo.FactorBYS')->insert([
                    "CompanyNo"=>5
                    ,"SnFact"=>$serialNoHDS
                    ,"SnGood"=>$goodSn
                    ,"PackType"=>$packType
                    ,"PackAmnt"=>$packAmnt
                    ,"Amount"=>$amount
                    ,"Fi"=>$fi
                    ,"Price"=>$price
                    ,"SnOrderDetail"=>0
                    ,"FiPack"=>$fiPack
                    ,"SnStockBYS"=>23
                    ,"Price3PercentMaliat"=>$percentMaliat
                    ,"PriceAfterAmel"=>$price
                    ,"FiAfterAmel"=>$fi
                    ,"Amount2Weight"=>$amount2Weight
                    ,"Fi2Weight"=>$fi2Weight
                    ,"PriceAfterTakhfif"=>$price
                    ,"RealFi"=>$fi
                    ,"RealPrice"=>$price
                    ,"FirstAmout"=>$firstAmount
                    ,"ReAmount"=>$reAmount]
                );
            }
        }
        DB::table('Shop.dbo.FactorHDS')->where("SerialNoHDS",$serialNoHDS)->update(["NetPriceHDS"=>$netPriceHDS]);
        return Response::json($request->all());
    }

}