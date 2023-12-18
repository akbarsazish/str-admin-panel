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
use App\Http\Controllers\Kala;
class Order extends Controller{

    public function index(Request $request) {
        $orders=DB::select("SELECT *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
        left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 

        left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE isSent=0 and isDistroy=0  order by orderHDSS.TimeStamp desc");
        $allMoney=DB::select("SELECT sum(allPrice) as sumAllMoney FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
        left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
        left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE isSent=0 and isDistroy=0");
        $allPayed=DB::select("SELECT SUM(payedMoney) AS payedMoney FROM NewStarfood.dbo.OrderHDSS WHERE isDistroy=0 AND isSent=0");
		$imediatOrders=DB::select("SELECT PCode,Name FROM NewStarfood.dbo.OrderHDSS JOIN Shop.dbo.Peopels on CustomerSn=PSN  where OrderErsalTime=3 and isSent=0 and isDistroy=0");
        return view('orders.salesOrderList',['orders'=>$orders,'allMoney'=>$allMoney[0]->sumAllMoney,'allPayed'=>$allPayed[0]->payedMoney,'imediatOrders'=>$imediatOrders]);
    }
    public function getOrderDetail(Request $request)
    {
        $customerId=0;

        $orderSn=$request->get("orderSn");

        $orderItems=DB::select("SELECT *,orderBYSS.Price as totalPrice,NewStarfood.dbo.getLastDateBuyFi(GoodSn)lastBuyFi,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,NewStarfood.dbo.getSecondUnitAmount(GoodSn)AmountUnit,NewStarfood.dbo.getFirstUnit(GoodSn) as firstUnit  from NewStarfood.dbo.orderBYSS join Shop.dbo.PubGoods on orderBYSS.SnGood=PubGoods.GoodSn
        where orderBYSS.SnHDS=".$orderSn);

        $order=DB::select("SELECT *,Shop.dbo.FuncStatusCustomer(5,1402,PSN)CustomerStatus,Takhfif FROM NewStarfood.dbo.orderHDSS JOIN Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
                            JOIN (SELECT SnPeopel, STRING_AGG(PhoneStr, '-') AS PhoneStr
                            FROM Shop.dbo.PhoneDetail
                            GROUP BY SnPeopel)a on PSN=a.SnPeopel WHERE SnOrder=$orderSn");
        $amelInfo=DB::select("SELECT * FROM NewStarfood.dbo.OrderAmelBYSS where SnOrder=$orderSn");
        $customerId=$order[0]->PSN;

        $notEffecientList=DB::select("SELECT * FROM(
            SELECT ViewGoodExistsInStock.Amount AS stockAmount,a.Amount AS orderAmount,
            a.SnGood,IIF(ViewGoodExistsInStock.Amount <= a.Amount, 0, 1) AS goodExist 
            FROM Shop.dbo.ViewGoodExistsInStock JOIN (SELECT * From NewStarfood.dbo.OrderBYSS 
            WHERE SnHDS=$orderSn)a ON a.SnGood=ViewGoodExistsInStock.SnGood WHERE ViewGoodExistsInStock.CompanyNo=5 AND ViewGoodExistsInStock.FiscalYear=".Session::get("FiscallYear")." AND SnStock=23)
            a JOIN Shop.dbo.PubGoods ON a.SnGood=PubGoods.GoodSn WHERE goodExist>1");

        $costs=DB::select("SELECT SUM(Price) AS totalPrice FROM Shop.dbo.OrderAmelBYS  WHERE SnOrder=$orderSn GROUP BY SnOrder");

        $totalAmount=DB::select("SELECT SUM(Price) AS totalMoney FROM NewStarfood.dbo.OrderBYSS WHERE SnHDS=$orderSn GROUP BY SnHDS");

        $addresses=DB::select("SELECT * FROM Shop.dbo.PeopelAddress where SnPeopel=$customerId");

        //مبلغ کیف تخفیفی
        $takhfifCaseMoney=0;
        if(count($order) > 0){
            $takhfifCaseMoney=$order[0]->Takhfif;
        }
        //جایزه لاتاری
        $lotteryResult=DB::select("SELECT wonPrize FROM NewStarfood.dbo.star_TryLottery WHERE customerId=$customerId AND isTaken=0");
        $passInfo=DB::select("SELECT customerId psn,customerPss password,userName username FROM NewStarfood.dbo.star_CustomerPass WHERE customerId=$customerId");
        return Response::json([$orderItems,$order,$notEffecientList,$costs,$totalAmount,$addresses,$takhfifCaseMoney,$lotteryResult,$passInfo,$amelInfo]);
    }

    public function orderView(Request $request){
        $hds=$request->post("factorSn");
        $orders=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,OrderBYSS.Amount,OrderBYSS.Fi,OrderBYSS.Price,OrderBYSS.DateOrder,OrderBYSS.TimeStamp,OrderBYSS.PackAmount,Peopels.Name,Peopels.PSN,A.UName as secondUnit,B.UName AS firstUnit,payedMoney FROM  NewStarfood.dbo.OrderBYSS join  Shop.dbo.PubGoods on OrderBYSS.SnGood=PubGoods.GoodSn
        join  NewStarfood.dbo.OrderHDSS on OrderHDSS.SnOrder=OrderBYSS.SnHDS join  Shop.dbo.Peopels on OrderHDSS.CustomerSn=Peopels.PSN 
        left join (SELECT PUBGoodUnits.UName,PUBGoodUnits.USN,Shop.dbo.GoodUnitSecond.SnGood  from  Shop.dbo.PUBGoodUnits join  Shop.dbo.GoodUnitSecond on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)A ON A.SnGood=PubGoods.GoodSn
        join (SELECT PUBGoodUnits.UName,PUBGoodUnits.USN from  Shop.dbo.PUBGoodUnits)B on B.USN=PubGoods.DefaultUnit
         where SnHDS=".$hds);
        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        $payedMoney=$orders[0]->payedMoney;

        return View('orders.listOrder',['orders'=>$orders,'currency'=>$currency,'currencyName'=>$currencyName,'orderSn'=>$hds,'payedMoney'=>$payedMoney]);
    }

    public function getSendItemInfo(Request $request)
    {
        $stockId=$request->get("stockId");
        $goodSn=$request->get("goodSn");
        $customerSn=$request->get("customerSn");
       
        $goodExist=DB::select("SELECT Amount FROM Shop.dbo.ViewGoodExistsInStock WHERE CompanyNo=5 AND FiscalYear=1402 AND SnGood=$goodSn AND SnStock=".$stockId);
        
        $goodPrice=DB::select("SELECT * FROM Shop.dbo.GoodPriceSale WHERE CompanyNo=5 and SnGood=".$goodSn);
        
        $goodPriceOfCustomer=DB::select("SELECT * FROM(
            SELECT Max(SerialNoBys) lastBYSSn FROM (
            SELECT Fi,SnGood,CustomerSn,SnFact,SerialNoBys FROM  Shop.dbo.FactorBYS  JOIN Shop.dbo.FactorHDS ON Shop.dbo.FactorBYS.SnFact=FactorHDS.SerialNoHDS
            )a WHERE CustomerSn=$customerSn AND SnGood=$goodSn)b JOIN Shop.dbo.FactorBYS ON b.lastBYSSn=FactorBYS.SerialNoBys");
        
        $lastSalePrice=DB::select("SELECT Fi,lastBysSn,SnGood FROM(
            SELECT MAX(SerialNoBys) AS lastBysSn FROM Shop.dbo.FactorBYS WHERE SnGood=$goodSn AND CompanyNo=5
            )a JOIN Shop.dbo.FactorBYS ON a.lastBysSn=FactorBYS.SerialNoBys");

        return Response::json([$goodExist,$goodPrice,$goodPriceOfCustomer,$lastSalePrice]);
    }

    public function distroyOrder(Request $request)
    {
        $orderSn=$request->get("orderId");
        DB::table("NewStarfood.dbo.orderHDSS")->where("SnOrder",$orderSn)->update(['isDistroy'=>1]);
        $orders=DB::select("SELECT * FROM NewStarfood.dbo.orderHDSS JOIN Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
                            LEFT JOIN (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) AS adminName FROM CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
                            left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE isSent=0 and isDistroy=0");
        $allMoney=DB::select("SELECT sum(allPrice) as sumAllMoney FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
                            left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
                            left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE isSent=0 and isDistroy=0");
        $allPayed=DB::select("SELECT SUM(payedMoney) AS payedMoney FROM NewStarfood.dbo.OrderHDSS WHERE isDistroy=0 AND isSent=0");
        return Response::json([$orders,$allMoney[0],$allPayed[0]]);
    }
    public function deleteOrderItem(Request $request)
    {
        $orderSn=$request->get("orderSn");
        $orderHds=$request->get("hdsSn");
        DB::table("NewStarfood.dbo.orderBYSS")->where("SnOrderBYSS",$orderSn)->delete();
        $orderItems=DB::select("SELECT *,orderBYSS.Price as totalPrice from NewStarfood.dbo.orderBYSS join Shop.dbo.PubGoods on orderBYSS.SnGood=PubGoods.GoodSn
        join (SELECT USN,UName as firstUnit from Shop.dbo.PUBGoodUnits)a on PubGoods.DefaultUnit=a.USN
        left join (SELECT USN,UName as secondUnit,SnGood from Shop.dbo.PUBGoodUnits join Shop.dbo.GoodUnitSecond on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)b on b.SnGood=PubGoods.GoodSn
        where orderBYSS.SnHDS=".$orderHds);
        return Response::json($orderItems);
    }
    public function searchItemForAddToOrder(Request $request)
    {
        $kala=new Kala;
        $searchTerm=$kala->changeToArabicLetterAndEngNumber($request->get("searchTerm"));
        $items=DB::select("SELECT * FROM Shop.dbo.PubGoods JOIN (SELECT UName AS firstUnit,USN FROM Shop.dbo.PUBGoodUnits WHERE CompanyNo=5)a  ON DefaultUnit=a.USN
                            LEFT JOIN (SELECT SnGood,UName AS secondUnit,USN as secondUnitSn,AmountUnit FROM Shop.dbo.GoodUnitSecond LEFT JOIN Shop.dbo.PUBGoodUnits on GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN)b on PubGoods.GoodSn=b.SnGood
                            WHERE CompanyNo=5 AND (GoodName LIKE N'%$searchTerm%')");
        return Response::json($items);
    }
    public function getGoodInfoForAddOrderItem(Request $request)
    {
        $goodSn=$request->get("goodSn");
        $stockId=$request->get("stockId");
        $customerSn=$request->get("customerSn");

        $items=DB::select(" SELECT * FROM Shop.dbo.PubGoods JOIN (SELECT UName AS firstUnit,USN FROM Shop.dbo.PUBGoodUnits WHERE CompanyNo=5)a  ON DefaultUnit=a.USN
                            LEFT JOIN (SELECT SnGood,UName AS secondUnit,USN as secondUnitSn,AmountUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits on GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN)b on PubGoods.GoodSn=b.SnGood
                            WHERE CompanyNo=5 AND (GoodSn = $goodSn)");
        //گرفتن اطلاعات موجودی قیمت فروش 
        
        $goodExist=DB::select("SELECT Amount FROM Shop.dbo.ViewGoodExistsInStock WHERE CompanyNo=5 AND FiscalYear=1402 AND SnGood=$goodSn AND SnStock=".$stockId);
        
        $goodPrice=DB::select("SELECT * FROM Shop.dbo.GoodPriceSale WHERE CompanyNo=5 and SnGood=".$goodSn);
        
        $goodPriceOfCustomer=DB::select("SELECT * FROM(
            SELECT Max(SerialNoBys) lastBYSSn FROM (
            SELECT Fi,SnGood,CustomerSn,SnFact,SerialNoBys FROM  Shop.dbo.FactorBYS  JOIN Shop.dbo.FactorHDS ON Shop.dbo.FactorBYS.SnFact=FactorHDS.SerialNoHDS
            )a WHERE CustomerSn=$customerSn AND SnGood=$goodSn)b JOIN Shop.dbo.FactorBYS ON b.lastBYSSn=FactorBYS.SerialNoBys");
        
        $lastSalePrice=DB::select("SELECT Fi,lastBysSn,SnGood FROM(
            SELECT MAX(SerialNoBys) AS lastBysSn FROM Shop.dbo.FactorBYS WHERE SnGood=$goodSn AND CompanyNo=5
            )a JOIN Shop.dbo.FactorBYS ON a.lastBysSn=FactorBYS.SerialNoBys");
        return Response::json([$items,$goodExist,$goodPrice,$goodPriceOfCustomer,$lastSalePrice]);
    }
    public function addToOrderItems(Request $request)
    {
        $defaultUnit;
        $packType;
        $packAmount;
        $orderHDSsn=$request->get('HdsSn');
        $amountUnit=$request->get('amountUnit');
        $productId=$request->get('goodSn');

        $secondUnits=DB::select("SELECT SnGoodUnit,AmountUnit FROM Shop.dbo.GoodUnitSecond WHERE GoodUnitSecond.SnGood=".$productId);
        $defaultUnits=DB::select("SELECT defaultUnit FROM Shop.dbo.PubGoods WHERE PubGoods.GoodSn=".$productId);
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

        
        $prices=DB::select("SELECT GoodPriceSale.Price3,GoodPriceSale.Price4 FROM Shop.dbo.GoodPriceSale WHERE GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        $exactPrice1=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $fiPack=$exactPrice*$packAmount;
        $fiPrice=$allMoney/$amountUnit;
        $packAmount1=$amountUnit/$packAmount;

        DB::table("NewStarfood.dbo.orderBYSS")->insert(["CompanyNo"=>5
                                                        ,"SnHDS"=>$orderHDSsn
                                                        ,"SnGood"=>$productId
                                                        ,"PackType"=>$packType
                                                        ,"PackAmount"=>$packAmount1
                                                        ,"Amount"=>$amountUnit
                                                        ,"Fi"=>$fiPrice
                                                        ,"Price"=>$allMoney
                                                        ,"DescRecord"=>"دستی توسط ادمین"
                                                        ,"DateOrder"=>"".Jalalian::fromCarbon(Carbon::today())->format('Y/m/d').""
                                                        ,"SnUser"=>12
                                                        ,"FactorFew"=>0
                                                        ,"FiPack"=>$fiPack
                                                        ,"PriceAfterTakhfif"=>$allMoney
                                                        ,"RealFi"=>$fiPrice
                                                        ,"RealPrice"=>$allMoney]);

        $orderItems=DB::select("SELECT *,orderBYSS.Price AS totalPrice FROM NewStarfood.dbo.orderBYSS JOIN Shop.dbo.PubGoods ON orderBYSS.SnGood=PubGoods.GoodSn
                                JOIN (SELECT USN,UName AS firstUnit FROM Shop.dbo.PUBGoodUnits)a ON PubGoods.DefaultUnit=a.USN
                                LEFT JOIN (SELECT USN,UName AS secondUnit,SnGood FROM Shop.dbo.PUBGoodUnits JOIN Shop.dbo.GoodUnitSecond on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)b on b.SnGood=PubGoods.GoodSn
                                WHERE orderBYSS.SnHDS=".$orderHDSsn);
        return Response::json($orderItems);
    }
    public function getOrderItemInfo(Request $request)
    {
        $itemSn=$request->get("itemSn");
        $customerSn=$request->get("customerSn");
        $tem=DB::select("SELECT *,orderBYSS.Price AS totalPrice FROM NewStarfood.dbo.orderBYSS JOIN Shop.dbo.PubGoods ON orderBYSS.SnGood=PubGoods.GoodSn
                        JOIN (SELECT USN,UName AS firstUnit FROM Shop.dbo.PUBGoodUnits)a ON PubGoods.DefaultUnit=a.USN
                        LEFT JOIN (SELECT USN,UName as secondUnit,SnGood,AmountUnit
                        FROM Shop.dbo.PUBGoodUnits JOIN Shop.dbo.GoodUnitSecond ON PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)b ON b.SnGood=PubGoods.GoodSn
                        WHERE orderBYSS.SnOrderBYSS=$itemSn");
        $goodSn=$tem[0]->GoodSn;
        $stockId=23;             
        //گرفتن اطلاعات موجودی قیمت فروش
        $goodExist=DB::select("SELECT Amount FROM Shop.dbo.ViewGoodExistsInStock WHERE CompanyNo=5 AND FiscalYear=".Session::get("FiscallYear")." AND SnGood=$goodSn AND SnStock=".$stockId);

        $goodPrice=DB::select("SELECT * FROM Shop.dbo.GoodPriceSale WHERE CompanyNo=5 and SnGood=".$goodSn);
        
        $goodPriceOfCustomer=DB::select("SELECT * FROM(
            SELECT Max(SerialNoBys) lastBYSSn FROM (
            SELECT Fi,SnGood,CustomerSn,SnFact,SerialNoBys FROM  Shop.dbo.FactorBYS  JOIN Shop.dbo.FactorHDS ON Shop.dbo.FactorBYS.SnFact=FactorHDS.SerialNoHDS
            )a WHERE CustomerSn=$customerSn AND SnGood=$goodSn)b JOIN Shop.dbo.FactorBYS ON b.lastBYSSn=FactorBYS.SerialNoBys");
        
        $lastSalePrice=DB::select("SELECT Fi,lastBysSn,SnGood FROM(
            SELECT MAX(SerialNoBys) AS lastBysSn FROM Shop.dbo.FactorBYS WHERE SnGood=$goodSn AND CompanyNo=5
            )a JOIN Shop.dbo.FactorBYS ON a.lastBysSn=FactorBYS.SerialNoBys");                
        return Response::json([$tem[0],$goodExist,$goodPrice,$goodPriceOfCustomer,$lastSalePrice]);
    }
    public function editOrderItem(Request $request)
    {
        $itemSn=$request->get("orderSn");
        $orderHDSsn=$request->get('snHDS');
        $amountUnit=$request->get('amount');
        $productId=$request->get('productId');
        $defaultUnit=0;
        $packAmount=1;
        $secondUnits=DB::select("SELECT SnGoodUnit,AmountUnit FROM Shop.dbo.GoodUnitSecond WHERE GoodUnitSecond.SnGood=".$productId);
        $defaultUnits=DB::select("SELECT defaultUnit FROM Shop.dbo.PubGoods WHERE PubGoods.GoodSn=".$productId);
        foreach ($defaultUnits as $unit) {
            $defaultUnit=$unit->defaultUnit;
        }
        if(count($secondUnits)>0){
            foreach ($secondUnits as $unit) {
                $packAmount=$unit->AmountUnit;
            }
        }

        $bysInfo=DB::select("SELECT * FROM NewStarfood.dbo.orderBYSS WHERE SnOrderBYSS=$itemSn");
        
        $fi=0;

        foreach ($bysInfo as $info) {
            $fi=$info->Fi;
        }

        $allMoney= $fi * $amountUnit;

        $fiPack=$fi*$packAmount;
        $boughtPackAmount=$amountUnit/$packAmount;
        DB::update("UPDATE NewStarfood.dbo.orderBYSS SET Amount=$amountUnit,DescRecord='دستی ویرایش شد',PackAmount=$boughtPackAmount ,Price=$allMoney,FiPack=$fiPack,
        PriceAfterTakhfif=$allMoney,Fi=$fi WHERE SnOrderBYSS=$itemSn");
        $orderItems=DB::select("SELECT *,orderBYSS.Price AS totalPrice FROM NewStarfood.dbo.orderBYSS JOIN Shop.dbo.PubGoods ON orderBYSS.SnGood=PubGoods.GoodSn
                                JOIN (SELECT USN,UName AS firstUnit FROM Shop.dbo.PUBGoodUnits)a ON PubGoods.DefaultUnit=a.USN
                                LEFT JOIN (SELECT USN,UName AS secondUnit,SnGood FROM Shop.dbo.PUBGoodUnits
                                JOIN Shop.dbo.GoodUnitSecond ON PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)b ON b.SnGood=PubGoods.GoodSn
                                WHERE orderBYSS.SnHDS=".$orderHDSsn);
        return Response::json($orderItems);
    }

    public function getOrdersHistory(Request $request) {
        $history=$request->get("history");
        if($history=="TODAY"){
            $orders=DB::select("SELECT  *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
                                LEFT JOIN (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
                                LEFT JOIN (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE CONVERT(DATE,orderHDSS.TimeStamp)=CONVERT(DATE,CURRENT_TIMESTAMP)");
            return Response::json([$orders]);
        }
        if($history=="YESTERDAY"){
            $orders=DB::select("SELECT  *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
                                LEFT JOIN (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
                                LEFT JOIN (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE CONVERT(DATE,orderHDSS.TimeStamp)=CONVERT(DATE,DATEADD(day,-1,CURRENT_TIMESTAMP))");
            return Response::json([$orders]);
        }
        if($history=="HUNDRED"){
            $orders=DB::select("SELECT TOP 100 *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
            LEFT JOIN (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
            LEFT JOIN (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder ORDER BY OrderHDSS.TimeStamp DESC");
            return Response::json([$orders]);
        }
        if($history=="ALL"){
            $orders=DB::select("SELECT *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
            LEFT JOIN (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
            LEFT JOIN (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder ORDER BY OrderHDSS.TimeStamp DESC");
            return Response::json([$orders]);
        }

    }

    public function filterAllSefarishat(Request $request)
    {
        $firstOrderDate=$request->get("fromDate");
        $secondOrderDate=$request->get("toDate");
        $orderType=$request->get("orderType");
        $code=$request->get("code");
        $name=$request->get("name");
        if(strlen($secondOrderDate)<3){
            $secondOrderDate='1500/01/01';
        }
        if(strlen($firstOrderDate)<3){
            $firstOrderDate='1401/01/01';
        }
        
        if($orderType==0){
            $orders=DB::select("SELECT *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
            left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
            left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE (isSent=0 and isDistroy=0) AND (Name LIKE '%$name%' AND PCode LIKE '%$code%') and OrderHDSS.OrderDate>='$firstOrderDate' and OrderHDSS.OrderDate<='$secondOrderDate'");
            return Response::json([$orders]);
        }elseif($orderType==1){
            $orders=DB::select("SELECT *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
            left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
            left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE (Name LIKE '%$name%' AND PCode LIKE '%$code%') and (isSent=0 and isDistroy=1) and OrderHDSS.OrderDate>='$firstOrderDate' and OrderHDSS.OrderDate<='$secondOrderDate'");
            return Response::json([$orders]);
        }else{
            $orders=DB::select("SELECT *,FORMAT(OrderHDSS.TimeStamp,'yyyy/MM/dd hh:mm','fa-ir') as orderDateHijri FROM NewStarfood.dbo.orderHDSS join Shop.dbo.Peopels ON orderHDSS.CustomerSn=PSN
            left join (SELECT customer_id,admin_id,returnState,CONCAT(name,lastName) as adminName from CRM.dbo.crm_customer_added join CRM.dbo.crm_admin on admin_id=crm_admin.id where returnState=0)b on b.customer_id=Peopels.PSN 
            left join (SELECT SnHDS,SUM(Price) as allPrice from NewStarfood.dbo.OrderBYSS group by SnHDS)a ON a.SnHDS=OrderHDSS.SnOrder WHERE (Name LIKE '%$name%' AND PCode LIKE '%$code%') and (isSent=1 and isDistroy=0) and OrderHDSS.OrderDate>='$firstOrderDate' and OrderHDSS.OrderDate<='$secondOrderDate'");
            return Response::json([$orders]);
        
        }
    }

    public function checkOrderExistance(Request $request)
    {
        $hds=$request->get("hds");
        $allExists=0;// در صورتیک تمام کالاها وجود نداشته باشد
        $items=DB::select("SELECT * FROM NewStarfood.dbo.orderBYSS where SnHDS=".$hds);//آیتم های سفارش
        $notExistGoods=array();//آی دی کالاهای که وجود ندارند.
        $notExist=array();
        foreach($items as $item){
            $amount=DB::select("SELECT Amount FROM Shop.dbo.ViewGoodExistsInStock WHERE SnGood=$item->SnGood AND CompanyNo=5 AND FiscalYear=".Session::get("FiscallYear")." AND SnStock=23");
            if($amount[0]->Amount < $item->Amount){
                array_push($notExistGoods,$item->SnGood);
            }
        }
        //اسم کالاهای که موجودی ندارند.
        $notExitGoodIds = implode(',', $notExistGoods);
        if($notExitGoodIds){
        $notExist=DB::select("SELECT GoodCde,GoodSn,GoodName,Amount FROM  Shop.dbo.PubGoods JOIN Shop.dbo.ViewGoodExistsInStock ON PubGoods.GoodSn=ViewGoodExistsInStock.SnGood WHERE  ViewGoodExistsInStock.CompanyNo=5 AND ViewGoodExistsInStock.FiscalYear=".Session::get("FiscallYear")." AND SnStock=23 AND GoodSn in($notExitGoodIds)");
        }
        //چک کردن عدم موجودی تمامی آیتم های سفارش
        if(count($notExist)==count($items)){
            $allExists=1;
        }
        return Response::json([$notExist,$allExists]);
    }

    public function editorderSendState(Request $request)
    {
        $orderSn=$request->input("orderSn");
        $customerSn=$request->input("CustomerSn");
        $orderState=$request->input("orderState");
        if($orderState==1 or $orderState==0){
            DB::table("NewStarfood.dbo.orderHDSS")->where("SnOrder",$orderSn)->where("CustomerSn",$customerSn)->update(['isSent'=>$orderState]);
        }else{
            DB::table("NewStarfood.dbo.orderHDSS")->where("SnOrder",$orderSn)->where("CustomerSn",$customerSn)->update(['isDistroy'=>$orderState]);   
        }
        return Response::json(1);
    }

public function addOrder(Request $request){
        $lastOrderSnStar=0;
        // DB::beginTransaction();
        // try {
        $takhfifCodeMoney=0;
        $code=$request->post("takhfifCode");
        $customerSn=Session::get('psn');
        $codeExistance=DB::select("SELECT * FROM NewStarfood.dbo.star_SMSModel 
									INNER JOIN NewStarfood.dbo.star_takhfifCodeAssign
									ON Id=CodeId AND CustomerId=$customerSn 
									AND isUsed=0 AND Code='$code'");

        $codeState=array();
        if(count($codeExistance)>0){
            $date = $codeExistance[0]->AssignDate;
            $newDate= Carbon::parse(date('Y-m-d', strtotime($date. ' + '.($codeExistance[0]->UseDays).' days')));
            $codeState=DB::select("SELECT * FROM NewStarfood.dbo.star_takhfifCodeAssign WHERE CodeId=".$codeExistance[0]->Id." AND CustomerId=".$customerSn." AND isUsed=0 AND CURRENT_TIMESTAMP<='".$newDate."'");
        }else{

        }
        if(count($codeState)>0){
			$takhfifCodeMoney=(int)($codeExistance[0]->Money);
			DB::table("NewStarfood.dbo.star_takhfifCodeAssign")
				->where("CustomerId",$customerSn)
				->update(["isUsed"=>1,"UsedMoney"=>$takhfifCodeMoney]);
        }
        $lastOrdersStar=DB::table("NewStarfood.dbo.FactorStar")->where("CustomerSn",$customerSn)->where("OrderStatus",0)->max('SnOrder');
        
        if($lastOrdersStar>0){
        //سفارش در سمت مشتری وجود داشته باشد.
			
        list($pmOrAmSn,$orderDate)=explode(",",$request->post("recivedTime"));
        $orderDate=Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d H:i:s',$orderDate))->format("Y/m/d");
        $totalCostNaql=0;
        $totalCostNasb=0;
        $totalCostMotafariqa=0;
        $totalCostBrgiri=0;
        $totalCostTarabari=0;
        $orderDescription=" ";
        $maxsOrderId=0;
        $lastOrderSnWeb=0;
        $maxsOrderIdWeb=0;
        
        //اعلان ثبت مشخصات ورود جعلی و نمایش پشتیبان

        if(Session::get("otherUserInfo")){
            $orderDescription='توسط:ادمین ثبت شد';
        }
        
		$poshtibanInfo=DB::select('SELECT CONCAT(convert(varchar,name),convert(varchar,lastName)) AS nameLastName FROM 
									CRM.dbo.crm_admin JOIN CRM.dbo.crm_customer_added ON 
									crm_admin.id=crm_customer_added.admin_id WHERE customer_id='.Session::get("psn").'
									and returnState=0');
        if(count($poshtibanInfo)>0){
            $poshtibanInformation=(string) $poshtibanInfo[0]->nameLastName;
			$orderDescription.=' '.$poshtibanInformation;
		}else{
			$orderDescription.="پشتیبان ندارد";
		}
       
        $orderDescription=(string)$orderDescription;
		//ختم ثبت مشخصات پشتیبان و جعلی

        $recivedAddress=$request->post('customerAddress');
        list($recivedAddress,$addressSn)=explode("_",$recivedAddress);
        $allMoney=$request->post('allMoney');
        // شماره فاکتور های سفارشی سمت دفتر حساب
        $factorNumber=DB::select("SELECT MAX(OrderNo) AS maxFact FROM NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
        $factorNo=0;
        $current = Carbon::today();
        $sabtTime = Carbon::now()->format("H:i:s");
        $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
        foreach ($factorNumber as $number) {
            $factorNo=$number->maxFact;
        }

        $factorNo=$factorNo+1;

        //آخرین سفارش فاکتور که در سمت وب داده شده
            
        $lastOrderSnStar=$lastOrdersStar;

            //وارد فاکتور سفارشات دفتر حساب می شود                               
                    
       DB::insert("INSERT INTO Shop.dbo.OrderHDS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc
	   ,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,
	   SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,
	   MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,
	   OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,
	   SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,
	   LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,
	   PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder
	   ,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress) VALUES(5,".$factorNo.",'".$orderDate."',".$customerSn.",'$orderDescription',0,'','','".Session::get("FiscallYear")."',0,0,3,'".$recivedAddress."','',0,'','',0,0,0,0,0,'','','','',$takhfifCodeMoney,0,0,'',0,'".$sabtTime."',0,0,0,0,0,0,'','',0,0,0,0,0,'','',".$pmOrAmSn.",$addressSn)");
            // در صورتیکه یک سفارش ارسال نشده در سمت سفارشات فروش قبلا موجود باشد.
       $orderExist=DB::table("NewStarfood.dbo.OrderHDSS")->where("CustomerSn",$customerSn)->where("isSent",0)->where("isDistroy",0)->get(); 
        if(count($orderExist)){
            $lastOrderSnWeb=$orderExist[0]->SnOrder;
            $maxsOrderIdWeb=$orderExist[0]->SnOrder;
        } 
        //آخرین فاکتور سفارش که در سمت دفتر حساب داده شده
      $lastOrders=DB::select("SELECT MAX(SnOrder) as orderSn from Shop.dbo.OrderHDS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSn=0;
            foreach ($lastOrders as $lastOrder) {
                if($lastOrder->orderSn){
                    $lastOrderSn=$lastOrder->orderSn;
                    $maxsOrderId=$lastOrder->orderSn;
                }
            }
           
            if($lastOrderSnWeb<1 or $orderExist[0]->OrderSnAddress != $addressSn){//اگر سفارشی در لیست سفارشات از قبل وجود ندارد.

                DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress)
                VALUES(5,".$factorNo.",'".$orderDate."',".$customerSn.",'$orderDescription',0,'','','".Session::get("FiscallYear")."',0,0,3,'".$recivedAddress."','',0,'','',0,0,0,0,0,'','','','',$takhfifCodeMoney,0,0,'',0,'".$sabtTime."',0,0,0,0,0,0,'','',0,0,0,0,0,'','',".$pmOrAmSn.",$addressSn)");
                      
                //آخرین فاکتور سفارش که در سمت وب داده شده
                $lastOrdersWeb=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
                foreach ($lastOrdersWeb as $lastOrder) {
                    if($lastOrder->orderSn){
                        $lastOrderSnWeb=$lastOrder->orderSn;
                        $maxsOrderIdWeb=$lastOrder->orderSn;
                    }
                }
               $item=0;
				//  آیتم های سفارش را از سمت وب می خواند
                $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
                //
                foreach ($orederBYS as $order) {
					$item+=1;
                    $costExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$order->SnOrderBYS)->select("*")->get();
                    if(count($costExistance)>0){
                        foreach ($costExistance as $cost) {
                            switch ($cost->SnAmel) {
                                case 142:
                                    $totalCostNaql+=$cost->Price;
                                    break;
                                case 143:
                                    $totalCostNasb+=$cost->Price;
                                    break;
                                case 144:
                                    $totalCostMotafariqa+=$cost->Price;
                                    break;
                                case 168:
                                    $totalCostBrgiri+=$cost->Price;
                                    break;
                                case 188:
                                    $totalCostTarabari+=$cost->Price;
                                    break;
                            }
                        }
                    }    
                    //وارد جدول زیر شاخه فاکتور های سمت دفتر حساب می شود.
                    DB::insert("INSERT INTO Shop.dbo.OrderBYS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSn.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,$item,0,0,0,0,0,0,0,0,0,0,0,0)");
                
                    //اگر کالاهای سفارش داده شده بود
                    //وارد جدول زیر شاخه فاکتور های سمت استارفود می شود.
                    DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSnWeb.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->Price.",0,0,".$order->Price.",".$order->Price.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                }
                
                if($totalCostNaql>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>142,'Price'=>$totalCostNaql,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostNasb>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>143,'Price'=>$totalCostNasb,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostMotafariqa>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>144,'Price'=>$totalCostMotafariqa,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostBrgiri>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>168,'Price'=>$totalCostBrgiri,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostTarabari>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>188,'Price'=>$totalCostTarabari,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
            }else{

                self::updateOrInsertOrders($lastOrderSnWeb,$lastOrderSnStar);
                //وارد کردن داده ها به جدول دفتر حساب
                //  آیتم های سفارش را از سمت وب می خواند
                $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
                foreach ($orederBYS as $order) {
                //وارد جدول زیر شاخه فاکتور های سمت دفتر حساب می شود.
                    DB::insert("INSERT INTO Shop.dbo.OrderBYS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSn.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                }
            }
            DB::update("UPDATE   NewStarfood.dbo.FactorStar SET OrderStatus=1 WHERE  SnOrder=".$lastOrderSnStar);
            Session::put('buy',0);

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
            //used because of پیش خرید
            $lastOrdersStarPishKharids=DB::select("SELECT MAX(SnOrderPishKharid) as orderSn from   NewStarfood.dbo.star_pishKharidFactor WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSnStarPishKharid=0;
            foreach ($lastOrdersStarPishKharids as $lastOrder) {
                if($lastOrder->orderSn){
                $lastOrderSnStarPishKharid=$lastOrder->orderSn;
                }
            }
            $pishKharidOrderAfters=DB::select("SELECT * FROM   NewStarfood.dbo.star_pishKharidOrder where SnHDS=".$lastOrderSnStarPishKharid);
            if(count($pishKharidOrderAfters)>0){
                $factorNumberPishKharid=DB::select("SELECT MAX(OrderNo) as maxFact from
				NewStarfood.dbo.star_pishKharidFactorAfter WHERE CompanyNo=5");
                $factorNoPishKharid=0;
                $current = Carbon::today();
                $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
                foreach ($factorNumberPishKharid as $number) {
                    $factorNoPishKharid=$number->maxFact;
                }

                $factorNoPishKharid=$factorNoPishKharid+1;

                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactorAfter (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)
                VALUES(5,".$factorNoPishKharid.",'".$todayDate."',".$customerSn.",'',0,'','','".Session::get("FiscallYear")."',0,0,3,'','',0,'','',0,0,0,0,0,'','','".$orderDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");


                $lastOrderSnPishKharid=DB::table("NewStarfood.dbo.star_pishKharidFactorAfter")->max("SnOrderPishKharidAfter");
                $item=0;
                foreach ($pishKharidOrderAfters as $order) {
                    $item=$item+1;
                    DB::insert("INSERT INTO  NewStarfood.dbo.star_pishKharidOrderAfter(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4,preBuyState)
                    VALUES(5,".$lastOrderSnPishKharid.",".$order->SnGood.",".$order->PackType.",".$order->PackAmount.",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0)");
                }
                DB::update("update  NewStarfood.dbo.star_pishKharidFactor set OrderStatus=1 WHERE  SnOrderPishKharid=".$lastOrderSnStarPishKharid);
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
            $profit=$request->post("profit");
            return view('orders.success',['factorNo'=>$factorNo,'factorBYS'=>$factorBYS,'profit'=>$profit,'currency'=>$currency,'currencyName'=>$currencyName]);
        
        }else{
            return redirect("/allGroups");
        }

    //     DB::commit();
    //     // all good
    // } catch (\Exception $e) {
    //     DB::rollback();
    //     // something went wrong
    // }
    }

	public function setPayOnlineSessions(Request $request)
    {
        Session::put("recivedTime",$request->get("recivedTime"));
		if($request->get("takhfif")){
        	Session::put("takhfif",$request->get("takhfif"));
		}else{
			Session::put("takhfif",0);
		}
		if($request->get("takhfifCodeMoney")){
			Session::put("takhfifCodeMoney",$request->get("takhfifCodeMoney"));
		}else{
			Session::put("takhfifCodeMoney",0);			
		}
        Session::put("receviedAddress",$request->get("receviedAddress"));
        Session::put("allMoneyToSend",$request->get("allMoneyToSend"));
        Session::put("hasOrderSent",$request->get("isSent"));
        Session::put("orderSn",$request->get("orderSn"));
		Session::put("takhfifCode",$request->get("takhfifCode"));
        return Response::json(Session::get("allMoneyToSend"));
	}

    public function getPaymentForm(Request $request){
        $allMoney=self::getAllMoneyForOnlinePay();
		try {
			$pasargad = new Pasargad(
			  "5015060",
			  "2263969",
			  "https://starfoods.ir/sucessPay",
			  "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
			$pasargad->setAmount($allMoney); 
			$lastInvoiceNumber=DB::table("NewStarfood.dbo.star_paymentResponds")->max("InvoiceNumber");
			if($lastInvoiceNumber){
				$lastInvoiceNumber+=1;
				$this->invoiceNumber=$lastInvoiceNumber;
			}else{
				$this->invoiceNumber=111111;
			}
			$pasargad->setInvoiceNumber($this->invoiceNumber);
			$pasargad->setInvoiceDate("".Carbon::now()->format('Y/m/d H:i:s')."");
			$redirectUrl = $pasargad->redirect();
			return redirect($redirectUrl);
		} catch (\Exception $ex) {
			return "اتصال با درگاه بانک بر قرار نشد";
		}
    }
	
    public function finalizePayAndOrder(Request $request){
        $allMoney=self::getAllMoneyForOnlinePay();
		try {
            $pasargad = new Pasargad(
                          "5015060",
                          "2263969",
                          "https://starfoods.ir/sucessPay",
                          "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
            
            $pasargad->setTransactionReferenceId($request->get("tref")); 
            $pasargad->setInvoiceNumber($request->get("iN"));
            $pasargad->setInvoiceDate($request->get("iD"));
            $payResults=$pasargad->checkTransaction();
            if($payResults['IsSuccess']=="true"){
                
                $pasargad->setAmount($allMoney); 
                
                $pasargad->setInvoiceNumber($request->get("iN"));
                
                $pasargad->setInvoiceDate($request->get("iD"));
                
          		if($pasargad->verifyPayment()["IsSuccess"]=='true'){
                    // درج فاکتور از اینجا شروع می شود که در صورت موفقیت درج به صفحه موفقیت هدایت می شود   
                    $allTakhfifMoney=0;
                    $takhfif=self::getTakhfifForOnlinePay();
                    $takhfifCodeMoney=0;
					$code=Session::get("takhfifCode");
					$customerSn=Session::get('psn');
					$codeExistance=DB::select("SELECT * FROM NewStarfood.dbo.star_SMSModel 
									INNER JOIN NewStarfood.dbo.star_takhfifCodeAssign
									ON Id=CodeId AND CustomerId=$customerSn 
									AND isUsed=0 AND Code='$code'");
					$codeState=array();
					if(count($codeExistance)>0){
						$date = $codeExistance[0]->AssignDate;
						$newDate= Carbon::parse(date('Y-m-d', strtotime($date. ' + '.($codeExistance[0]->UseDays).' days')));
						$codeState=DB::select("SELECT * FROM NewStarfood.dbo.star_takhfifCodeAssign WHERE
						CodeId=".$codeExistance[0]->Id." AND CustomerId=".$customerSn." AND isUsed=0 AND
						CURRENT_TIMESTAMP<='".$newDate."'");
					}
					if(count($codeState)>0){
						$takhfifCodeMoney=$codeExistance[0]->Money;
						DB::table("NewStarfood.dbo.star_takhfifCodeAssign")
							->where("CustomerId",$customerSn)->update(["isUsed"=>1,"UsedMoney"=>$takhfifCodeMoney]);
					}
					
            		list($pmOrAmSn,$orderDate)=explode(",",Session::get("recivedTime"));
                    
					$allTakhfifMoney=(int)($takhfif+$takhfifCodeMoney);
                    Session::put("takhfif",0);
            		$orderDate=Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d H:i:s',$orderDate))->format("Y/m/d");
    				//اطلاعات مربوط هزینه های اضافی فروش لیست می شود
            		$totalCostNaql=0;
    
            		$totalCostNasb=0;
    
            		$totalCostMotafariqa=0;
    
            		$totalCostBrgiri=0;
    
            		$totalCostTarabari=0;
    
            		$orderDescription=" ";
            		$maxsOrderId=0;
            		$lastOrderSnWeb=0;
            		$maxsOrderIdWeb=0;
    
    			//اطلاعاتی مربوط به پشتیبان وارد کننده و داشتن پشتیبان
				if(Session::get("otherUserInfo")){
                	$orderDescription=' توسط:ادمین ثبت شد';
            	}
            
            	$poshtibanInfo=DB::select('SELECT CONCAT(convert(varchar,name),convert(varchar,lastName)) as nameLastName from 
                                        CRM.dbo.crm_admin join CRM.dbo.crm_customer_added on 
                                        crm_admin.id=crm_customer_added.admin_id where customer_id='.Session::get("psn").'
                                        and returnState=0');
				if(count($poshtibanInfo)>0){
					$poshtibanInformation=(string) $poshtibanInfo[0]->nameLastName;
					$orderDescription.=' '.$poshtibanInformation;
				}else{
					$orderDescription.="پشتیبان ندارد";
				}
           
            	$orderDescription=(string)$orderDescription;
            	$customerSn=Session::get('psn');
            	$recivedAddress=Session::get("receviedAddress");
            	list($recivedAddress,$addressSn)=explode("_",Session::get("receviedAddress"));
            
            	//گرفتن شماره سفارش سمت دفتر حساب برای ثبت شماره سفارش بعدی
            	$factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
            	$factorNo=0;
            	$current = Carbon::today();
            	$sabtTime = Carbon::now()->format("H:i:s");
            	$todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
            	foreach ($factorNumber as $number) {
                	$factorNo=$number->maxFact;
            	}
    
            	$factorNo=$factorNo+1;
           
           		//وارد فاکتور سفارشات وب می شود
           		DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus
					,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName
					,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor
					,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust
					,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder
					,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime
					,OrderSnAddress,isSent,isPayed,payedMoney,InVoiceNumber)
           	VALUES(5,".$factorNo.",'".$orderDate."',".$customerSn.",'$orderDescription',0,'','','".Session::get("FiscallYear")."',0,0,3,'".$recivedAddress."','',0,'','',0,0,0,0,0,'','','','',$allTakhfifMoney,0,0,'',0,'".$sabtTime."',0,0,0,0,0,0,'','',0,0,0,0,0,'','',".$pmOrAmSn.",$addressSn,0,1,$allMoney,".$request->get('iN').")");
           
    
            //سر شاخه سبد خرید خوانده می شود.
            $lastOrdersStar=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.FactorStar WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSnStar=0;
            foreach ($lastOrdersStar as $lastOrder) {
                $lastOrderSnStar=$lastOrder->orderSn;
            }
    
            //آخرین فاکتور سفارش که در سمت وب داده شده
            $lastOrdersWeb=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
    
            foreach ($lastOrdersWeb as $lastOrder) {
                if($lastOrder->orderSn){
                    $lastOrderSnWeb=$lastOrder->orderSn;
                    $maxsOrderIdWeb=$lastOrder->orderSn;
                }
            }
    
            //آیتم های سبد خرید خوانده می شود
            $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
            $item=0;
            foreach ($orederBYS as $order) {
                // برای ثبت اطلاعات مربوط به هزینه انتقال و نصب و غیره
                $item=$item+1;
                $costExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$order->SnOrderBYS)->select("*")->get();
                if(count($costExistance)>0){
                    foreach ($costExistance as $cost) {
                        switch ($cost->SnAmel) {
                            case 142:
                                $totalCostNaql+=$cost->Price;
                                break;
                            case 143:
                                $totalCostNasb+=$cost->Price;
                                break;
                            case 144:
                                $totalCostMotafariqa+=$cost->Price;
                                break;
                            case 168:
                                $totalCostBrgiri+=$cost->Price;
                                break;
                            case 188:
                                $totalCostTarabari+=$cost->Price;
                                break;
                        }
                    }
                }     
				
           //وارد جدول زیر شاخه فاکتور های سمت استارفود می شود.
                DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
    
                VALUES(5,".$lastOrderSnWeb.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
    
            }
            //  کیف تخفیفی
            if($takhfif>0){
                DB::update("UPDATE NewStarfood.dbo.star_takhfifHistory set isUsed=1,snOrder=$lastOrderSnWeb,usedDate='".Carbon::now()."' WHERE isUsed=0 and customerId=".$customerSn);
            }
            //هزینه های فروش
            if($totalCostNaql>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>142,'Price'=>$totalCostNaql,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostNasb>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>143,'Price'=>$totalCostNasb,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostMotafariqa>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>144,'Price'=>$totalCostMotafariqa,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostBrgiri>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>168,'Price'=>$totalCostBrgiri,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostTarabari>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>188,'Price'=>$totalCostTarabari,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
            }
            //سرشاخه سبد خرید سمت مشتری به عنوان تخلیه شده ثبت میشود.
            DB::update("update   NewStarfood.dbo.FactorStar set OrderStatus=1 WHERE  SnOrder=".$lastOrderSnStar);
            //تعداد کالاهای سبد خرید صفر می شود.
            Session::put('buy',0);
            //آیتم های سفارشی از دفتر حساب خوانده می شود که مربوط به این خرید بوده است.
            $factorBYS=DB::select("SELECT OrderBYSS.*,PubGoods.GoodName FROM NewStarfood.dbo.OrderBYSS join Shop.dbo.PubGoods on OrderBYSS.SnGood=PubGoods.GoodSn WHERE SnHDS=".$lastOrderSnWeb);
            $amountUnit=1;
            $defaultUnit;
            //اطلاعات مثل واحدات کالا و غیره برای صفحه موفقیت در اینجا بدست می آید.
            foreach ($factorBYS as $buy) {
                $kala=DB::select('SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods INNER JOIN Shop.dbo.PUBGoodUnits
                ON PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn='.$buy->SnGood);
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
    
            //  ختم موفق بودن خرید.
            //برای نمایش  واحد پول
            $currency=1;
            $currencyName="ریال";
            $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
            foreach ($currencyExistance as $cr) {
                $currency=$cr->currency;
            }
            if($currency==10){
                $currencyName="تومان";
            }
            $takhfif=(int)(Session::get("takhfif"));
        //برای ثبت مشخصات واریزی در جدول جواب بانک
        $payResults=$pasargad->checkTransaction();		
        DB::table("NewStarfood.dbo.star_paymentResponds")->insert(["customerId"=>Session::get("psn")
           ,"TraceNumber"=>"".$payResults["TraceNumber"].""
           ,"ReferenceNumber"=>"".$payResults["ReferenceNumber"].""
           ,"TransactionDate"=>"".$payResults["TransactionDate"].""
           ,"TransactionReferenceID"=>"".$payResults["TransactionReferenceID"].""
           ,"InvoiceNumber"=>"".$payResults["InvoiceNumber"].""
           ,"InvoiceDate"=>"".$payResults["InvoiceDate"].""
           ,"Amount"=>"".$payResults["Amount"].""
           ,"TrxMaskedCardNumber"=>"".$payResults["TrxMaskedCardNumber"].""
           ,"IsSuccess"=>$payResults["IsSuccess"]
           ,"Message"=>"".$payResults["Message"].""]);
    
            return view("orders.successPay",['factorNo'=>$factorNo,'factorBYS'=>$factorBYS,
                                           'profit'=>$profit,'currency'=>$currency,'currencyName'=>$currencyName,
                                           'payResults'=>$pasargad->checkTransaction()]);
                    
                }else{
                    
                    return redirect("/carts");
                    
                }
            }else{
                return redirect("/carts");
            }
            } catch (\Exception $ex) {
                  return redirect("/carts");
            }
    }

    public function getFactorPaymentFormApi(Request $request)
    {
        $allMoney=$request->input("allMoney");
		try {
			$pasargad = new Pasargad(
			  "5015060",
			  "2263969",
			  "https://star.starfoods.ir/successFactorPayApi",
			  "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
			$pasargad->setAmount($allMoney); 
			$lastInvoiceNumber=DB::table("NewStarfood.dbo.star_paymentResponds")->max("InvoiceNumber");
			if($lastInvoiceNumber){
				$lastInvoiceNumber+=1;
				$this->invoiceNumber=$lastInvoiceNumber;
			}else{
				$this->invoiceNumber=111111;
			}
			$pasargad->setInvoiceNumber($this->invoiceNumber);
			$pasargad->setInvoiceDate("".Carbon::now()->format('Y/m/d H:i:s')."");
			$redirectUrl = $pasargad->redirect();
			return Response::json($redirectUrl);
		} catch (\Exception $ex) {
			return Response::json("اتصال با درگاه بانک بر قرار نشد");
		}
    }

    public function finalizeFactorPayApi(Request $request)
    {
        $psn=$request->input("psn");
        $allMoney=$request->input("allMoney");
        $tref=$request->input("tref");
        $iN=$request->input("iN");
        $iD=$request->input("iD");
        $lastFactSN=$request->input("factorSn");
        $fiscallYear="1402";
		try {
            $pasargad = new Pasargad(
                          "5015060",
                          "2263969",
                          "https://starfoods.ir/successFactorPayApi",
                          "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
            $pasargad->setTransactionReferenceId($tref); 
            $pasargad->setInvoiceNumber($iN);
            $pasargad->setInvoiceDate($iD);
            $payResults=$pasargad->checkTransaction();
            
            if($payResults['IsSuccess']=="true"){
                
                $pasargad->setAmount($allMoney); 
                
                $pasargad->setInvoiceNumber($iN);
                
                $pasargad->setInvoiceDate($iD);
          		if($pasargad->verifyPayment()["IsSuccess"]=='true'){
                    // ثبت اطلاعات واریزی در سمت خودما
                    DB::table("NewStarfood.dbo.star_paymentResponds")->insert([
                                                                            "customerId"=>$psn
                                                                            ,"TraceNumber"=>"".$payResults["TraceNumber"].""
                                                                            ,"ReferenceNumber"=>"".$payResults["ReferenceNumber"].""
                                                                            ,"TransactionDate"=>"".$payResults["TransactionDate"].""
                                                                            ,"TransactionReferenceID"=>"".$payResults["TransactionReferenceID"].""
                                                                            ,"InvoiceNumber"=>"".$payResults["InvoiceNumber"].""
                                                                            ,"InvoiceDate"=>"".$payResults["InvoiceDate"].""
                                                                            ,"Amount"=>"".$payResults["Amount"].""
                                                                            ,"TrxMaskedCardNumber"=>"".$payResults["TrxMaskedCardNumber"].""
                                                                            ,"IsSuccess"=>$payResults["IsSuccess"]
                                                                            ,"Message"=>"".$payResults["Message"].""
                                                                            ]);

                
                    $lastDocNoHds=DB::table("Shop.dbo.GetAndPayHDS")->where("GetOrPayHDS",1)->max("DocNoHDS");
                    //وارد جدول سطح بالای داد و گرفت
                    DB::table("Shop.dbo.GetAndPayHDS")->insert(
                                                                ["CompanyNo"=>5
                                                                ,"GetOrPayHDS"=>1
                                                                ,"DocNoHDS"=>$lastDocNoHds+1//auto increment according to HDS 
                                                                ,"DocDate"=>"".Jalalian::fromCarbon(Carbon::today())->format('Y/m/d').""//فارسی تاریخ
                                                                ,"DocDescHDS"=>".آنلاین پرداخت شد"
                                                                ,"StatusHDS"=>0
                                                                ,"PeopelHDS"=>$psn
                                                                ,"FiscalYear"=>"".$fiscallYear.""
                                                                ,"SnFactor"=>0
                                                                ,"InForHDS"=>0
                                                                ,"NetPriceHDS"=>$allMoney//مبلغ به ریال
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
                    DB::table("Shop.dbo.GetAndPayBYS")->insert(["CompanyNo"=>5
                                                                ,"DocTypeBYS"=>3
                                                                ,"Price"=>$allMoney
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
                                                                    'payedMoney'=>$allMoney,
                                                                    'invoiceNumber'=>"$iN"
                                                                    ]);
                return Response::json(['payResult'=>$payResults,'result'=>"OK"]);    
                }else{
                    return Response::json(["result"=>"Not Varified"]);
                }
            }else{
                return Response::json(["result"=>"Not Payed"]);
            }
        } catch (\Exception $ex) {
            return Response::json(["result"=>"Not Connected"]);
        }
    }


    public function getPaymentFormApi(Request $request)
    {
        $psn=$request->input("psn");
        $allMoney=$request->input("allMoney");
		try {
			$pasargad = new Pasargad(
			  "5015060",
			  "2263969",
			  "https://star.starfoods.ir/successPayApi",
			  "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
			$pasargad->setAmount($allMoney); 
			$lastInvoiceNumber=DB::table("NewStarfood.dbo.star_paymentResponds")->max("InvoiceNumber");
			if($lastInvoiceNumber){
				$lastInvoiceNumber+=1;
				$this->invoiceNumber=$lastInvoiceNumber;
			}else{
				$this->invoiceNumber=111111;
			}
			$pasargad->setInvoiceNumber($this->invoiceNumber);
			//$pasargad->setCustomerId($psn);
            $pasargad->setMobile("0912100_".$psn);
			$pasargad->setInvoiceDate("".Carbon::now()->format('Y/m/d H:i:s')."");
			$redirectUrl = $pasargad->redirect();
			return Response::json($redirectUrl);
		} catch (\Exception $ex) {
			return Response::json("اتصال با درگاه بانک بر قرار نشد");
		}
    }

   
    public function finalizePayAndOrderApi(Request $request)
    {
        $psn=$request->input("psn");
        $allMoney=$request->input("allMoney");
        $tref=$request->input("tref");
        $iN=$request->input("iN");
        $iD=$request->input("iD");

        $allTakhfifMoney=0;
        $takhfif=$request->input("takhfif");
        $takhfifCodeMoney=0;
        $code=$request->input("takhfifCode");
        $customerSn=$psn;
        $recivedTime=$request->input("recivedTime");
        $receviedAddress=$request->input("receviedAddress");
        
		try {
            
            $pasargad = new Pasargad(
                          "5015060",
                          "2263969",
                        "https://starfoods.ir/successPayApi",
                        "C:/inetpub/vhosts/starfoods.ir/httpdocs/key.xml");
                          
            $pasargad->setTransactionReferenceId($tref); 
            $pasargad->setInvoiceNumber($iN);
            $pasargad->setInvoiceDate($iD);
            $payResults=$pasargad->checkTransaction();
            
            if($payResults['IsSuccess']=="true"){
                
                $pasargad->setAmount($allMoney); 
                
                $pasargad->setInvoiceNumber($iN);
                
                $pasargad->setInvoiceDate($iD);
          		if($pasargad->verifyPayment()["IsSuccess"]=='true'){
                    
                    // ثبت اطلاعات واریزی در سمت خودما
                    DB::table("NewStarfood.dbo.star_paymentResponds")->insert([
                                                                            "customerId"=>$psn
                                                                            ,"TraceNumber"=>"".$payResults["TraceNumber"].""
                                                                            ,"ReferenceNumber"=>"".$payResults["ReferenceNumber"].""
                                                                            ,"TransactionDate"=>"".$payResults["TransactionDate"].""
                                                                            ,"TransactionReferenceID"=>"".$payResults["TransactionReferenceID"].""
                                                                            ,"InvoiceNumber"=>"".$payResults["InvoiceNumber"].""
                                                                            ,"InvoiceDate"=>"".$payResults["InvoiceDate"].""
                                                                            ,"Amount"=>"".$payResults["Amount"].""
                                                                            ,"TrxMaskedCardNumber"=>"".$payResults["TrxMaskedCardNumber"].""
                                                                            ,"IsSuccess"=>$payResults["IsSuccess"]
                                                                            ,"Message"=>"".$payResults["Message"].""
                                                                            ]);
                    //درج فاکتور از اینجا شروع می شود که در صورت موفقیت درج به صفحه موفقیت هدایت می شود  
                    

					$codeExistance=DB::select("SELECT * FROM NewStarfood.dbo.star_SMSModel 
									INNER JOIN NewStarfood.dbo.star_takhfifCodeAssign
									ON Id=CodeId AND CustomerId=$customerSn
									AND isUsed=0 AND Code='$code'");
                                    
					$codeState=array();
					if(count($codeExistance)>0){
						$date = $codeExistance[0]->AssignDate;
						$newDate= Carbon::parse(date('Y-m-d', strtotime($date. ' + '.($codeExistance[0]->UseDays).' days')));
						$codeState=DB::select("SELECT * FROM NewStarfood.dbo.star_takhfifCodeAssign WHERE
						CodeId=".$codeExistance[0]->Id." AND CustomerId=".$customerSn." AND isUsed=0 AND
						CURRENT_TIMESTAMP<='".$newDate."'");
					}
					if(count($codeState)>0){
						$takhfifCodeMoney=$codeExistance[0]->Money;
						DB::table("NewStarfood.dbo.star_takhfifCodeAssign")->where("CustomerId",$customerSn)->update(["isUsed"=>1,"UsedMoney"=>$takhfifCodeMoney]);
					}
                    
            		list($pmOrAmSn,$orderDate)=explode(",",$recivedTime);
                    
					$allTakhfifMoney=(int)($takhfif+$takhfifCodeMoney);
                    
                    list($orderDate,$noUse)=explode("T",$orderDate);
                    
            		$orderDate=Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d',$orderDate))->format("Y/m/d");
                    
    				//اطلاعات مربوط هزینه های اضافی فروش لیست می شود
            		$totalCostNaql=0;
            		$totalCostNasb=0;
    
            		$totalCostMotafariqa=0;
    
            		$totalCostBrgiri=0;
    
            		$totalCostTarabari=0;
    
            		$orderDescription=" پرداخت آنلاین ";
            		$maxsOrderId=0;
            		$lastOrderSnWeb=0;
            		$maxsOrderIdWeb=0;
            
            	$poshtibanInfo=DB::select("SELECT CONCAT(convert(varchar,name),convert(varchar,lastName)) AS nameLastName FROM 
                                        CRM.dbo.crm_admin JOIN CRM.dbo.crm_customer_added ON 
                                        crm_admin.id=crm_customer_added.admin_id WHERE customer_id=$psn AND returnState=0");
				
                if(count($poshtibanInfo)>0){
					$poshtibanInformation=(string) $poshtibanInfo[0]->nameLastName;
					$orderDescription.=' '.$poshtibanInformation;
				}else{
					$orderDescription.="پشتیبان ندارد";
				}
                
            	$orderDescription=(string)$orderDescription;
                
            	$customerSn=$psn;
                
            	list($addressSn,$recivedAddress)=explode("_",$receviedAddress);
                
            	//گرفتن شماره سفارش سمت دفتر حساب برای ثبت شماره سفارش بعدی
            	$factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
            	$factorNo=0;
            	$current = Carbon::today();
            	$sabtTime = Carbon::now()->format("H:i:s");
            	$todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
            	foreach ($factorNumber as $number) {
                	$factorNo=$number->maxFact;
            	}
                
            	$factorNo=$factorNo+1;
           		//وارد فاکتور سفارشات وب می شود
           		DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus
					,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName
					,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor
					,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust
					,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder
					,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime
					,OrderSnAddress,isSent,isPayed,payedMoney,InVoiceNumber)
           	VALUES(5,".$factorNo.",'".$orderDate."',".$customerSn.",'$orderDescription',0,'','','1402',0,0,3,'".$recivedAddress."','',0,'','',0,0,0,0,0,'','','','',$allTakhfifMoney,0,0,'',0,'".$sabtTime."',0,0,0,0,0,0,'','',0,0,0,0,0,'','',".$pmOrAmSn.",$addressSn,0,1,$allMoney,$iN)");
           
            //سر شاخه سبد خرید خوانده می شود.
            $lastOrdersStar=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.FactorStar WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSnStar=0;
            foreach ($lastOrdersStar as $lastOrder) {
                $lastOrderSnStar=$lastOrder->orderSn;
            }
    
            //آخرین فاکتور سفارش که در سمت وب داده شده
            $lastOrdersWeb=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
    
            foreach ($lastOrdersWeb as $lastOrder) {
                if($lastOrder->orderSn){
                    $lastOrderSnWeb=$lastOrder->orderSn;
                    $maxsOrderIdWeb=$lastOrder->orderSn;
                }
            }

            //آیتم های سبد خرید خوانده می شود
            $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
            $item=0;
            foreach ($orederBYS as $order) {
                // برای ثبت اطلاعات مربوط به هزینه انتقال و نصب و غیره
                $item=$item+1;
                $costExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$order->SnOrderBYS)->select("*")->get();
                if(count($costExistance)>0){
                    foreach ($costExistance as $cost) {
                        switch ($cost->SnAmel) {
                            case 142:
                                $totalCostNaql+=$cost->Price;
                                break;
                            case 143:
                                $totalCostNasb+=$cost->Price;
                                break;
                            case 144:
                                $totalCostMotafariqa+=$cost->Price;
                                break;
                            case 168:
                                $totalCostBrgiri+=$cost->Price;
                                break;
                            case 188:
                                $totalCostTarabari+=$cost->Price;
                                break;
                        }
                    }
                }     
				
           //وارد جدول زیر شاخه فاکتور های سمت استارفود می شود.
                DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
    
                VALUES(5,".$lastOrderSnWeb.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
            }
            //  کیف تخفیفی
            if($takhfif>0){
                DB::update("UPDATE NewStarfood.dbo.star_takhfifHistory set isUsed=1,snOrder=$lastOrderSnWeb,usedDate='".Carbon::now()."' WHERE isUsed=0 and customerId=".$customerSn);
            }
            //هزینه های فروش
            if($totalCostNaql>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>142,'Price'=>$totalCostNaql,'FiscalYear'=>'1402','DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostNasb>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>143,'Price'=>$totalCostNasb,'FiscalYear'=>'1402','DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostMotafariqa>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>144,'Price'=>$totalCostMotafariqa,'FiscalYear'=>'1402','DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostBrgiri>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>168,'Price'=>$totalCostBrgiri,'FiscalYear'=>'1402','DescItem'=>'','IsExport'=>'False']);
            }
            if($totalCostTarabari>0){
                DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>188,'Price'=>$totalCostTarabari,'FiscalYear'=>'1402','DescItem'=>'','IsExport'=>'False']);
            }
            //سرشاخه سبد خرید سمت مشتری به عنوان تخلیه شده ثبت میشود.
            DB::update("UPDATE NewStarfood.dbo.FactorStar SET OrderStatus=1 WHERE  SnOrder=".$lastOrderSnStar);

            //آیتم های سفارشی از دفتر حساب خوانده می شود که مربوط به این خرید بوده است.
            $factorBYS=DB::select("SELECT OrderBYSS.*,PubGoods.GoodName FROM NewStarfood.dbo.OrderBYSS join Shop.dbo.PubGoods on OrderBYSS.SnGood=PubGoods.GoodSn WHERE SnHDS=$lastOrderSnWeb");
            $amountUnit=1;
            $defaultUnit;
            //اطلاعات مثل واحدات کالا و غیره برای صفحه موفقیت در اینجا بدست می آید.
            foreach ($factorBYS as $buy) {
                $kala=DB::select('SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods INNER JOIN Shop.dbo.PUBGoodUnits
                ON PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn='.$buy->SnGood);
                foreach ($kala as $k) {
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
    
            //  ختم موفق بودن خرید.
            //برای نمایش  واحد پول
            $currency=1;
            $currencyName="ریال";
            $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
            foreach ($currencyExistance as $cr) {
                $currency=$cr->currency;
            }
            if($currency==10){
                $currencyName="تومان";
            }

        //برای ثبت مشخصات واریزی در جدول جواب بانک

            return Response::json(["result"=>"OK",'factorNo'=>$factorNo,'factorBYS'=>$factorBYS,
                                   'profit'=>0,'currency'=>$currency,'currencyName'=>$currencyName,
                                   'payResults'=>$pasargad->checkTransaction()]);
            }else{
                return Response::json(["result"=>"Not Varified"]);
            }
        }else{
            return Response::json(["result"=>"Not Payed"]);
        }
        } catch (\Exception $ex) {
            return Response::json(["result"=>"Not Connected"]);
        }
    }



	public function getAllMoneyForOnlinePay(){
		// مقدار پولی است که در پرداخت آنلاین باید واریز شود.
		return (int)(Session::get('allMoneyToSend')*10);
	}
	public function getTakhfifForOnlinePay(){
		// مقدار پولی است که در پرداخت آنلاین تخفیف داده می شود.
		return (int)(Session::get('takhfif')*10);
	}
	public function getTakhfifCodeMoneyForOnlinePay(){
		// مقدار پولی است که در پرداخت آنلاین از طریق کدتخفیف  تخفیف داده می شود.
		return (int)(Session::get('takhfifCodeMoney')*10);
	}

    public function addPishkharidBasketsToOrder(Request $request)
    { 
        
        $factorId=$request->post("factorNumber");
        $orderSns=$request->post("SnOrderBYSPishKharidAfter");
        $totalCostNaql=0;
        $totalCostNasb=0;
        $totalCostMotafariqa=0;
        $totalCostBrgiri=0;
        $totalCostTarabari=0;
        $customerSn=$request->post("csn");
        $factorNumber=DB::select("SELECT MAX(OrderNo) as maxFact from Shop.dbo.OrderHDS WHERE CompanyNo=5");
        $factorNo=0;
        $current = Carbon::today();
        $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
        foreach ($factorNumber as $number) {
            $factorNo=$number->maxFact;
        }
        
        $factorNo=$factorNo+1;
        $customerAddress=DB::select("SELECT peopeladdress FROM Shop.dbo.Peopels WHERE PSN=".$customerSn);
        $orderAddress="";
        foreach ($customerAddress as $peopelAdd) {
            $orderAddress=$peopelAdd->peopeladdress;
        }
        $lastOrdersStarAfter=DB::select("SELECT MAX(SnOrderPishKharidAfter) as orderSn from NewStarfood.dbo.star_pishKharidFactorAfter WHERE CustomerSn=".$customerSn." and OrderStatus=0");
        $lastOrderSnStar=0;
        foreach ($lastOrdersStarAfter as $lastOrder) {
            $lastOrderSnStar=$lastOrder->orderSn;
        }
        $countSendedOrders=0;
        $item=0;
        if($request->post("action")=="sendToApp"){
            DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress)
            VALUES(5,".$factorNo.",'".$todayDate."',".$customerSn.",'پیش خرید',0,'','','".Session::get("FiscallYear")."',0,0,3,'".$orderAddress."','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','',0,0)");
            $maxsOrders=DB::select("SELECT MAX(SnOrder) as maxOrderId from NewStarfood.dbo.OrderHDSS where CustomerSn=".$customerSn);
            $maxsOrderId=0;
            foreach ($maxsOrders as $maxOrder) {
                $maxsOrderId=$maxOrder->maxOrderId;
            }
            $lastOrders=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSn=0;
            foreach ($lastOrders as $lastOrder) {
                $lastOrderSn=$lastOrder->orderSn;
            }
            $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.star_pishKharidOrderAfter where SnHDS=".$factorId);

            $countOrderBYS=DB::table("NewStarfood.dbo.star_pishKharidOrderAfter")->where("preBuyState",0)->where("SnHDS",$factorId)->count();
            
            foreach ($orederBYS as $order) {
                $item=$item+1;
                foreach ($orderSns as $sn) {
                    if($sn==$order->SnOrderBYSPishKharidAfter and $order->preBuyState==0){
                        $countSendedOrders+=1;
                        DB::update("UPDATE NewStarfood.dbo.star_pishKharidOrderAfter set preBuyState=1 where SnOrderBYSPishKharidAfter=".$sn);
                        DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
                        VALUES(5,".$lastOrderSn.",".$order->SnGood.",".$order->PackType.",".$order->PackAmount.",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                    }
                }
            }
            
            if($countSendedOrders==$countOrderBYS){
                DB::update("UPDATE NewStarfood.dbo.star_pishKharidFactorAfter SET OrderStatus=1 WHERE  SnOrderPishKharidAfter=".$lastOrderSnStar);
            }
            return redirect("/listKala");
        }else{
            $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.star_pishKharidOrderAfter where SnHDS=".$factorId);
            $countOrderBYS=DB::table("NewStarfood.dbo.star_pishKharidOrderAfter")->where("preBuyState",0)->where("SnHDS",$factorId)->count();
            
            foreach ($orederBYS as $order) {
                $item=$item+1;
                foreach ($orderSns as $sn) {
                    if($sn==$order->SnOrderBYSPishKharidAfter and $order->preBuyState==0){
                        
                        $countSendedOrders+=1;
                        DB::delete("DELETE FROM NewStarfood.dbo.star_pishKharidOrderAfter where SnOrderBYSPishKharidAfter=".$sn);
                    }
                }
            }
            if($countSendedOrders==$countOrderBYS){
                DB::delete("DELETE FROM NewStarfood.dbo.star_pishKharidFactorAfter WHERE  SnOrderPishKharidAfter=".$lastOrderSnStar);
            }
            return redirect("/listKala");
        }
    }

    public function updateOrInsertOrders($SnHDS,$SnOrderStar)
    {
        $todayDate = Jalalian::fromCarbon(Carbon::today())->format('Y/m/d');
        //اگر قبلا این کالا فرستاده شده بود ویرایش شود
        $updateables=DB::select("SELECT * FROM NewStarfood.dbo.orderStar WHERE SnHDS=$SnOrderStar AND SnGood IN( SELECT SnGood FROM NewStarfood.dbo.OrderBYSS WHERE SnHDS=$SnHDS)");
        foreach ($updateables as $updateable) {
            # code...
            DB::update("UPDATE NewStarfood.dbo.OrderBYSS SET PackAmount+=($updateable->PackAmount),Amount+=$updateable->Amount,Price+=$updateable->Price,PriceAfterTakhfif+=$updateable->PriceAfterTakhfif WHERE SnHDS=$SnHDS and SnGood=$updateable->SnGood");
        }
        //اگر قبلا این کالا فرستاده نشده بود وارد تبدیل شود
        $insertables=DB::select("SELECT * FROM NewStarfood.dbo.orderStar WHERE SnHDS=$SnOrderStar AND SnGood NOT IN(SELECT SnGood FROM NewStarfood.dbo.OrderBYSS WHERE SnHDS=$SnHDS)");
        foreach ($insertables as $order) {
            # code...
            DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

            VALUES(5,".$SnHDS.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
        }
    }

    public function addFactorApi(Request $request){
        $lastOrderSnStar=0;
        // DB::beginTransaction();

        // try {
        $customerSn=$request->get('psn');;
        $lastOrdersStar=DB::table("NewStarfood.dbo.FactorStar")->where("CustomerSn",$customerSn)->where("OrderStatus",0)->max('SnOrder');
        
        if($lastOrdersStar>0){
            //سفارش در سمت مشتری وجود داشته باشد.
            
        list($pmOrAmSn,$orderDate)=explode(",",$request->get("recivedTime"));
        
        list($orderDate,$timeNotNeed)=explode("T",$orderDate);
        $orderDate=Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d',$orderDate))->format("Y/m/d");

        $totalCostNaql=0;
        $totalCostNasb=0;
        $totalCostMotafariqa=0;
        $totalCostBrgiri=0;
        $totalCostTarabari=0;
        $orderDescription=" ";
        $maxsOrderId=0;
        $lastOrderSnWeb=0;
        $maxsOrderIdWeb=0;
        $orederBYS=[];
        //اعلان ثبت مشخصات ورود جعلی و نمایش پشتیبان

       // if(Session::get("otherUserInfo")){
       //     $orderDescription=' توسط:ادمین ثبت شد';
      //  }
        
		$poshtibanInfo=DB::select("SELECT CONCAT(convert(varchar,name),convert(varchar,lastName)) AS nameLastName FROM 
									CRM.dbo.crm_admin JOIN CRM.dbo.crm_customer_added ON 
									crm_admin.id=crm_customer_added.admin_id WHERE customer_id=$customerSn and returnState=0");
        if(count($poshtibanInfo)>0){
            $poshtibanInformation=(string) $poshtibanInfo[0]->nameLastName;
			$orderDescription.=' '.$poshtibanInformation;
		}else{
			$orderDescription.="پشتیبان ندارد";
		}
       
        $orderDescription=(string)$orderDescription;
		//ختم ثبت مشخصات پشتیبان و جعلی

        $recivedAddress=$request->get('customerAddress');
        list($addressSn,$recivedAddress)=explode("_",$recivedAddress);
        $allMoney=$request->get('allMoney');
        // شماره فاکتور های سفارشی سمت دفتر حساب
        $factorNumber=DB::select("SELECT MAX(OrderNo) AS maxFact FROM NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
        $factorNo=0;
        $current = Carbon::today();
        $sabtTime = Carbon::now()->format("H:i:s");
        $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
        foreach ($factorNumber as $number) {
            $factorNo=$number->maxFact;
        }

        $factorNo=$factorNo+1;

        //آخرین سفارش فاکتور که در سمت وب داده شده
            
        $lastOrderSnStar=$lastOrdersStar;

            //وارد فاکتور سفارشات دفتر حساب می شود  
            DB::insert("INSERT INTO Shop.dbo.OrderHDS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress)
            VALUES(5,$factorNo,'$orderDate',$customerSn,'$orderDescription',0,'','','1402',0,0,3,'$recivedAddress','',0,'','',0,0,0,0,0,'','','','',0,0,0,'',0,'$sabtTime',0,0,0,0,0,0,'','',0,0,0,0,0,'','',$pmOrAmSn,$addressSn)");
            // در صورتیکه یک سفارش ارسال نشده در سمت سفارشات فروش قبلا موجود باشد.
            $orderExist=DB::table("NewStarfood.dbo.OrderHDSS")->where("CustomerSn",$customerSn)->where("isSent",0)->where("isDistroy",0)->get(); 
            if(count($orderExist)){
                 $lastOrderSnWeb=$orderExist[0]->SnOrder;
                 $maxsOrderIdWeb=$orderExist[0]->SnOrder;
            } 
            //آخرین فاکتور سفارش که در سمت دفتر حساب داده شده
            $lastOrders=DB::select("SELECT MAX(SnOrder) as orderSn from Shop.dbo.OrderHDS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
            $lastOrderSn=0;
            foreach ($lastOrders as $lastOrder) {
                if($lastOrder->orderSn){
                    $lastOrderSn=$lastOrder->orderSn;
                    $maxsOrderId=$lastOrder->orderSn;
                }
            }
           
            if($lastOrderSnWeb<1 or $orderExist[0]->OrderSnAddress != $addressSn){//اگر سفارشی در لیست سفارشات از قبل وجود ندارد.

                DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress)
                VALUES(5,".$factorNo.",'".$orderDate."',".$customerSn.",'$orderDescription',0,'','','1402',0,0,3,'".$recivedAddress."','',0,'','',0,0,0,0,0,'','','','',0,0,0,'',0,'".$sabtTime."',0,0,0,0,0,0,'','',0,0,0,0,0,'','',".$pmOrAmSn.",$addressSn)");
                      
                //آخرین فاکتور سفارش که در سمت وب داده شده
                $lastOrdersWeb=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");
                foreach ($lastOrdersWeb as $lastOrder) {
                    if($lastOrder->orderSn){
                        $lastOrderSnWeb=$lastOrder->orderSn;
                        $maxsOrderIdWeb=$lastOrder->orderSn;
                    }
                }
                //  آیتم های سفارش را از سمت وب می خواند
                $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
                //
                foreach ($orederBYS as $order) {
                    $costExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$order->SnOrderBYS)->select("*")->get();
                    if(count($costExistance)>0){
                        foreach ($costExistance as $cost) {
                            switch ($cost->SnAmel) {
                                case 142:
                                    $totalCostNaql+=$cost->Price;
                                    break;
                                case 143:
                                    $totalCostNasb+=$cost->Price;
                                    break;
                                case 144:
                                    $totalCostMotafariqa+=$cost->Price;
                                    break;
                                case 168:
                                    $totalCostBrgiri+=$cost->Price;
                                    break;
                                case 188:
                                    $totalCostTarabari+=$cost->Price;
                                    break;
                            }
                        }
                    }    
                    //وارد جدول زیر شاخه فاکتور های سمت دفتر حساب می شود.
                    DB::insert("INSERT INTO Shop.dbo.OrderBYS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSn.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                
                    //اگر کالاهای سفارش داده شده بود
                    //وارد جدول زیر شاخه فاکتور های سمت استارفود می شود.
                    DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSnWeb.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->Price.",0,0,".$order->Price.",".$order->Price.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                }
                
                if($totalCostNaql>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>142,'Price'=>$totalCostNaql,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostNasb>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>143,'Price'=>$totalCostNasb,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostMotafariqa>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>144,'Price'=>$totalCostMotafariqa,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostBrgiri>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>168,'Price'=>$totalCostBrgiri,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                if($totalCostTarabari>0){
                    DB::table('Shop.dbo.OrderAmelBYS')->insert(['CompanyNo'=>5,'SnOrder'=>$maxsOrderIdWeb,'SnAmel'=>188,'Price'=>$totalCostTarabari,'FiscalYear'=>Session::get("FiscallYear"),'DescItem'=>'','IsExport'=>'False']);
                }
                //used because of پیش خرید
                $lastOrdersStarPishKharids=DB::select("SELECT MAX(SnOrderPishKharid) as orderSn from   NewStarfood.dbo.star_pishKharidFactor WHERE CustomerSn=".$customerSn." and OrderStatus=0");
                $lastOrderSnStarPishKharid=0;
                foreach ($lastOrdersStarPishKharids as $lastOrder) {
                    if($lastOrder->orderSn){
                    $lastOrderSnStarPishKharid=$lastOrder->orderSn;
                    }
                }
                $pishKharidOrderAfters=DB::select("SELECT * FROM   NewStarfood.dbo.star_pishKharidOrder where SnHDS=".$lastOrderSnStarPishKharid);
                if(count($pishKharidOrderAfters)>0){

                    $factorNumberPishKharid=DB::select("SELECT MAX(OrderNo) as maxFact from  NewStarfood.dbo.star_pishKharidFactorAfter WHERE CompanyNo=5");
                    $factorNoPishKharid=0;
                    $current = Carbon::today();
                    $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
                    foreach ($factorNumberPishKharid as $number) {
                        $factorNoPishKharid=$number->maxFact;
                    }

                    $factorNoPishKharid=$factorNoPishKharid+1;

                    DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactorAfter (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)
                    VALUES(5,".$factorNoPishKharid.",'".$todayDate."',".$customerSn.",'',0,'','','1402',0,0,3,'','',0,'','',0,0,0,0,0,'','','".$orderDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");


                    $lastOrderSnPishKharid=DB::table("NewStarfood.dbo.star_pishKharidFactorAfter")->max("SnOrderPishKharidAfter");
                    $item=0;
                    foreach ($pishKharidOrderAfters as $order) {
                        $item=$item+1;
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_pishKharidOrderAfter(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4,preBuyState)
                        VALUES(5,".$lastOrderSnPishKharid.",".$order->SnGood.",".$order->PackType.",".$order->PackAmount.",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0)");
                    }
                    DB::update("update  NewStarfood.dbo.star_pishKharidFactor set OrderStatus=1 WHERE  SnOrderPishKharid=".$lastOrderSnStarPishKharid);
                }

            }else{
                self::updateOrInsertOrders($lastOrderSnWeb,$lastOrderSnStar);
                //وارد کردن داده ها به جدول دفتر حساب
                //  آیتم های سفارش را از سمت وب می خواند
                $orederBYS=DB::select("SELECT * FROM NewStarfood.dbo.orderStar where SnHDS=".$lastOrderSnStar);
                foreach ($orederBYS as $order) {
                //وارد جدول زیر شاخه فاکتور های سمت دفتر حساب می شود.
                    DB::insert("INSERT INTO Shop.dbo.OrderBYS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                    VALUES(5,".$lastOrderSn.",".$order->SnGood.",".$order->PackType.",".($order->PackAmount).",".$order->Amount.",".$order->Fi.",".$order->Price.",'',0,'".$todayDate."',12,0,0,0,".$order->FiPack.",0,0,0,'',0,0,0,0,0,".$order->PriceAfterTakhfif.",0,0,".$order->Price.",".$order->PriceAfterTakhfif.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                }
            }

            DB::update("UPDATE   NewStarfood.dbo.FactorStar SET OrderStatus=1 WHERE  SnOrder=".$lastOrderSnStar);
            $orederBYS=DB::select("SELECT orderStar.*,PubGoods.GoodName FROM NewStarfood.dbo.orderStar join Shop.dbo.PubGoods on orderStar.SnGood=PubGoods.GoodSn WHERE SnHDS=".$lastOrderSnStar);
            $amountUnit=1;
            $defaultUnit;
            foreach ($orederBYS as $buy) {
                $kala=DB::select('SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods INNER JOIN Shop.dbo.PUBGoodUnits
                                ON PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn='.$buy->SnGood);
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
            $profit=$request->get("profit");
            return Response::json(['orderNo'=>$factorNo,'orderBYS'=>$orederBYS,'profit'=>$profit,'currency'=>$currency,'currencyName'=>$currencyName]);
        }

    //     DB::commit();
    //     // all good
    // } catch (\Exception $e) {
    //     DB::rollback();
    //     // something went wrong
    // }
    }

    public function listOrdersApi(Request $request)
    {
        $hds=$request->get("factorSn");
        $orders=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,OrderBYSS.Amount,OrderBYSS.Fi,OrderBYSS.Price,OrderBYSS.DateOrder,OrderBYSS.TimeStamp,OrderBYSS.PackAmount,Peopels.Name,Peopels.PSN,A.UName as secondUnit,B.UName AS firstUnit,payedMoney FROM  NewStarfood.dbo.OrderBYSS join  Shop.dbo.PubGoods on OrderBYSS.SnGood=PubGoods.GoodSn
        join  NewStarfood.dbo.OrderHDSS on OrderHDSS.SnOrder=OrderBYSS.SnHDS join  Shop.dbo.Peopels on OrderHDSS.CustomerSn=Peopels.PSN 
        left join (SELECT PUBGoodUnits.UName,PUBGoodUnits.USN,Shop.dbo.GoodUnitSecond.SnGood  from  Shop.dbo.PUBGoodUnits join  Shop.dbo.GoodUnitSecond on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit)A ON A.SnGood=PubGoods.GoodSn
        join (SELECT PUBGoodUnits.UName,PUBGoodUnits.USN from  Shop.dbo.PUBGoodUnits)B on B.USN=PubGoods.DefaultUnit
         where SnHDS=".$hds);
        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        $payedMoney=$orders[0]->payedMoney;

        return Response::json(['orders'=>$orders,'currency'=>$currency,'currencyName'=>$currencyName,'orderSn'=>$hds,'payedMoney'=>$payedMoney]);
    }
    function addSefarishToList(Request $request) {

        $countRequestedGoods= (count($request->all())-15)/7;
        if($countRequestedGoods>0){
            for ($i=1; $i < $countRequestedGoods; $i++) {
                $allPrice=str_replace(",", "",$request->input("allPrice".$i));
            }
        }
        $hamlMoney=$request->input("hamlMoney");
        $hamlDesc=$request->input("hamlDesc");
        $nasbMoney=$request->input("nasbMoney");
        $nasbDesc=$request->input("nasbDesc");
        $motafariqaMoney=$request->input("motafariqaMoney");
        $motafariqaDesc=$request->input("motafariqaDesc");
        $bargiriMoney=$request->input("bargiriMoney");
        $bargiriDesc=$request->input("bargiriDesc");
        $tarabariMoney=$request->input("tarabariMoney");
        $tarabariDesc=$request->input("tarabariDesc");
        $customerSn=$request->input('customerForSefarishId');
        $orderDate=$request->input('orderDate');
        $pmOrAmSn=0;
        $recivedAddress=$request->input('customerAddress');
        $addressSn=1;
        list($recivedAddress,$addressSn)=explode("_",$recivedAddress);
        $orderDescription=$request->input('orderDescription');
        $takhfif=$request->input('takhfif');
        if(!$takhfif){
            $takhfif=0;
        }
        $lastOrderSnWeb=0;
        $maxsOrderIdWeb=0;

        $allMoney=$allPrice;
        $orderDescription." سفارش دستی";
        // ثبت سر درخواست
        // مشخصات پشتیبان ثبت می شود.
        $poshtibanInfo=DB::select("SELECT CONCAT(convert(varchar,name),convert(varchar,lastName)) AS nameLastName FROM 
                                    CRM.dbo.crm_admin JOIN CRM.dbo.crm_customer_added ON 
                                    crm_admin.id=crm_customer_added.admin_id WHERE customer_id=$customerSn and returnState=0");
        if(count($poshtibanInfo)>0){
            $poshtibanInformation=(string) $poshtibanInfo[0]->nameLastName;
            $orderDescription.=' '.$poshtibanInformation;
        }else{
            $orderDescription.="پشتیبان ندارد";
        }

        $orderDescription=(string)$orderDescription;
        //ختم ثبت مشخصات پشتیبان و جعلی

        // شماره فاکتور های سفارشی سمت دفتر حساب
        $factorNumber=DB::select("SELECT MAX(OrderNo) AS maxFact FROM NewStarfood.dbo.OrderHDSS WHERE CompanyNo=5");
        $factorNo=0;
        $sabtTime = Carbon::now()->format("H:i:s");
        $current = Carbon::today();
        $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
        foreach ($factorNumber as $number) {
            $factorNo=$number->maxFact;
        }
        $factorNo=$factorNo+1;
        //آخرین سفارش فاکتور که در سمت وب داده شده

        // در صورتیکه یک سفارش ارسال نشده در سمت سفارشات فروش قبلا موجود باشد.
        $orderExist=DB::table("NewStarfood.dbo.OrderHDSS")->where("CustomerSn",$customerSn)->where("isSent",0)->where("isDistroy",0)->get(); 
        if(count($orderExist)){
            $lastOrderSnWeb=$orderExist[0]->SnOrder;
            $maxsOrderIdWeb=$orderExist[0]->SnOrder;
        }

        if($lastOrderSnWeb<1 or $orderExist[0]->OrderSnAddress != $addressSn){  // و یا اینکه آدرس مشتری دوتا است.
                                                                //  اگر سفارش ارسال نشده در لیست سفارشات از قبل وجود ندارد.
            DB::insert("INSERT INTO NewStarfood.dbo.OrderHDSS (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder,OrderErsalTime,OrderSnAddress)
            VALUES(5,$factorNo,'$orderDate',$customerSn,'$orderDescription',0,'','','1402',0,0,3,'$recivedAddress','',0,'','',0,0,0,0,0,'','','','',$takhfif,0,0,'',0,'$sabtTime',0,0,0,0,0,0,'','',0,0,0,0,0,'','',$pmOrAmSn,$addressSn)");

            //آخرین فاکتور سفارش که در سمت وب داده شده
            $lastOrdersWeb=DB::select("SELECT MAX(SnOrder) as orderSn from NewStarfood.dbo.OrderHDSS WHERE CustomerSn=".$customerSn." and OrderStatus=0");

            foreach ($lastOrdersWeb as $lastOrder) {
                if($lastOrder->orderSn){
                    $lastOrderSnWeb=$lastOrder->orderSn;
                    $maxsOrderIdWeb=$lastOrder->orderSn;
                }
            }
        }elseif($takhfif>0){
            DB::update("UPDATE NewStarfood.dbo.OrderHDSS SET Takhfif=$takhfif where SnOrder=$lastOrderSnWeb");
        }

        if($hamlMoney>0){
            DB::table("NewStarfood.dbo.orderAmelBYSS")->insert([
            "CompanyNo"=>5
            ,"SnOrder"=>$lastOrderSnWeb
            ,"SnAmel"=>142
            ,"Price"=>$hamlMoney
            ,"FiscalYear"=>"1402"
            ,"DescItem"=>"".$hamlDesc.""]);
        }
        if($nasbMoney>0){
            DB::table("NewStarfood.dbo.orderAmelBYSS")->insert([
            "CompanyNo"=>5
            ,"SnOrder"=>$lastOrderSnWeb
            ,"SnAmel"=>143
            ,"Price"=>$nasbMoney
            ,"FiscalYear"=>"1402"
            ,"DescItem"=>"".$nasbDesc.""]);
        }
        if($motafariqaMoney>0){

            DB::table("NewStarfood.dbo.orderAmelBYSS")->insert([
            "CompanyNo"=>5
            ,"SnOrder"=>$lastOrderSnWeb
            ,"SnAmel"=>144
            ,"Price"=>$motafariqaMoney
            ,"FiscalYear"=>"1402"
            ,"DescItem"=>"".$motafariqaDesc.""]);
            
        }
        if($bargiriMoney>0){

            DB::table("NewStarfood.dbo.orderAmelBYSS")->insert([
            "CompanyNo"=>5
            ,"SnOrder"=>$lastOrderSnWeb
            ,"SnAmel"=>168
            ,"Price"=>$bargiriMoney
            ,"FiscalYear"=>"1402"
            ,"DescItem"=>"".$bargiriDesc.""]);
            
        }
        if($tarabariMoney>0){

            DB::table("NewStarfood.dbo.orderAmelBYSS")->insert([
            "CompanyNo"=>5
            ,"SnOrder"=>$lastOrderSnWeb
            ,"SnAmel"=>188
            ,"Price"=>$tarabariMoney
            ,"FiscalYear"=>"1402"
            ,"DescItem"=>"".$tarabariDesc.""]);
            
        }
  
  
        if($countRequestedGoods>0){
            for ($i=1; $i < $countRequestedGoods; $i++) {
                $packAmount=str_replace(",", "",$request->input("packAmount".$i));
                $firstAmountUnit=str_replace(",", "",$request->input("firstUnitAmount".$i));
                $fi=str_replace(",", "",$request->input("Price3".$i));
                $packPrice=str_replace(",", "",$request->input("packPrice".$i));
                $allPrice=str_replace(",", "",$request->input("allPrice".$i));
                $orderDescription=str_replace(",", "",$request->input("description".$i));
                $goodSn=$request->input("goodSn".$i);
                $packType=0;

                $packTypes=DB::select("SELECT * FROM Shop.dbo.GoodUnitSecond WHERE SnGood=$goodSn");
                $defaultUnits=DB::select("SELECT DefaultUnit FROM Shop.dbo.PubGoods WHERE GoodSn=$goodSn");
                if(count($packTypes)>0){
                    $packType=$packTypes[0]->SnGoodUnit;
                }else{
                    $packType=$defaultUnits[0]->DefaultUnit;
                }

                DB::insert("INSERT INTO NewStarfood.dbo.OrderBYSS(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)
        
                VALUES(5,$lastOrderSnWeb,$goodSn,$packType,$packAmount,$firstAmountUnit,$fi,$allPrice,'',0,'".$todayDate."',12,0,0,0,$packPrice,0,0,0,'',0,0,0,0,0,$allPrice,0,0,$allPrice,$allPrice,0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");

            }
        }
        return redirect("/salesOrder");
    }
    

    public function doEditOrder(Request $request){
        $psn=$request->input("psn");
        $snHDS=$request->input("SnHDS");
        list($address,$addressSn)=explode("_",$request->input("address"));
        DB::update("UPDATE NewStarfood.dbo.OrderHDSS SET CustomerSn=$psn,OrderAddress='$address',OrderSnAddress=$addressSn WHERE SnOrder=$snHDS");
        return Response::json(1);
    }
    
    public function doUpdateOrder(Request $request) {
        
        $snHDS=$request->input("SnHDS");
        $hamlMoney=$request->input("hamlMoneyEdit");
        $hamlSn=142;

        $hamlDesc=$request->input("hamlDescEdit");
        if(!$hamlDesc){
            $hamlDesc="";
        }

        $nasbMoney=$request->input("nasbMoneyEdit");
        $nasbSn=143;
        $nasbDesc=$request->input("nasbDescEdit");
        if(!$nasbDesc){
            $nasbDesc="";
        }

        $motafariqaMoney=$request->input("motafariqaMoneyEdit");
        $motafariqaSn=144;
        $motafariqaDesc=$request->input("motafariqaDescEdit");
        if(!$motafariqaDesc){
            $motafariqaDesc="";
        }

        $bargiriMoney=$request->input("bargiriMoneyEdit");
        $bargiriDesc=$request->input("bargiriDescEdit");
        if(!$bargiriDesc){
            $bargiriDesc="";
        }

        $bargiriSn=168;
        $tarabariMoney=$request->input("tarabariMoneyEdit");
        $tarabariDesc=$request->input("tarabariDescEdit");
        if(!$tarabariDesc){
            $tarabariDesc="";
        }

        $tarabariSn=188;
        if($nasbMoney>0){
            $nasbExistance=DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$nasbSn)->where("SnOrder",$snHDS)->count();
            if($nasbExistance<1){
                DB::table("NewStarfood.dbo.orderAmelBYSS")->insert(["CompanyNo"=>5
                ,"SnOrder"=>$snHDS
                ,"SnAmel"=>$nasbSn
                ,"Price"=>$nasbMoney
                ,"FiscalYear"=>1402
                ,"DescItem"=>$nasbDesc]);
            }else{
                DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$nasbSn)->where("SnOrder",$snHDS)->update([
                "Price"=>$nasbMoney
                ,"DescItem"=>$nasbDesc]);
            }
        }
        if($hamlMoney>0){
            $hamlExistance=DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$hamlSn)->where("SnOrder",$snHDS)->count();
                if($hamlExistance<1){
                    DB::table("NewStarfood.dbo.orderAmelBYSS")->insert(["CompanyNo"=>5
                    ,"SnOrder"=>$snHDS
                    ,"SnAmel"=>$hamlSn
                    ,"Price"=>$hamlMoney
                    ,"FiscalYear"=>1402
                    ,"DescItem"=>$hamlDesc]);
                }else{
                DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$hamlSn)->where("SnOrder",$snHDS)->update([
                "Price"=>$hamlMoney
                ,"DescItem"=>$hamlDesc]);
            }
        }
        if($motafariqaMoney>0){
            $motafariqahExistance=DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$motafariqaSn)->where("SnOrder",$snHDS)->count();
            if($motafariqahExistance<1){
                DB::table("NewStarfood.dbo.orderAmelBYSS")->insert(["CompanyNo"=>5
                ,"SnOrder"=>$snHDS
                ,"SnAmel"=>$motafariqaSn
                ,"Price"=>$motafariqaMoney
                ,"FiscalYear"=>1402
                ,"DescItem"=>$motafariqaDesc]);
            }else{
                DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$motafariqaSn)->where("SnOrder",$snHDS)->update([
                "Price"=>$motafariqaMoney
                ,"DescItem"=>$motafariqaDesc]);
            }
        }
        if($tarabariMoney>0){
            $tarabariExistance=DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$tarabariSn)->where("SnOrder",$snHDS)->count();
            if($tarabariExistance<1){
                DB::table("NewStarfood.dbo.orderAmelBYSS")->insert(["CompanyNo"=>5
                ,"SnOrder"=>$snHDS
                ,"SnAmel"=>$tarabariSn
                ,"Price"=>$tarabariMoney
                ,"FiscalYear"=>1402
                ,"DescItem"=>$tarabariDesc]);
            }else{
                DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$tarabariSn)->where("SnOrder",$snHDS)->update([
                "Price"=>$tarabariMoney
                ,"DescItem"=>$tarabariDesc]);
            }
        }
        if($bargiriMoney>0){
            $bargiriExistance=DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$bargiriSn)->where("SnOrder",$snHDS)->count();
            if($bargiriExistance<1){
                DB::table("NewStarfood.dbo.orderAmelBYSS")->insert(["CompanyNo"=>5
                ,"SnOrder"=>$snHDS
                ,"SnAmel"=>$bargiriSn
                ,"Price"=>$bargiriMoney
                ,"FiscalYear"=>1402
                ,"DescItem"=>$bargiriDesc]);
            }else{
                DB::table("NewStarfood.dbo.orderAmelBYSS")->where("SnAmel",$bargiriSn)->where("SnOrder",$snHDS)->update([
                "Price"=>$bargiriMoney
                ,"DescItem"=>$bargiriDesc]);
            }
        }

        $takhfif=$request->input("takhfif");
        $takhfifMoney=0;
        if($takhfif){
            $takhfifMoney=$takhfif;
        }
        $psn=$request->input("customerForSefarishIdEdit");

        $orderDate=$request->input("orderDateEdit");
        list($addressSn,$address)=explode("_",$request->input("customerAddressEdit"));
        $orderDescription=$request->input("orderDescriptionEdit");
        $editablesGoods=$request->input("editables");  
        DB::update("UPDATE NewStarfood.dbo.OrderHDSS SET CustomerSn=$psn,Takhfif=$takhfif,OrderDate='$orderDate',OrderDesc='$orderDescription',OrderAddress='$address',OrderSnAddress=$addressSn WHERE SnOrder=$snHDS");
        DB::delete("DELETE FROM NewStarfood.dbo.OrderBYSS WHERE SnHDS=$snHDS AND SnGood not in( ".implode(",",$editablesGoods).")");

        foreach ($editablesGoods as $goodSn) {
            $packAmount=str_replace(",", "",$request->input("packAmount".$goodSn));
            $amount=str_replace(",", "",$request->input("Amount".$goodSn));
            $fi=str_replace(",", "",$request->input("Fi".$goodSn));
            $price=str_replace(",", "",$request->input("AllPrice".$goodSn));
            $descRec=$request->input("Description".$goodSn);
            $fiPack=str_replace(",", "",$request->input("PackPrice".$goodSn));
            $jozePack=str_replace(",", "",$request->input("JozeAmount".$goodSn));
            $realFi=str_replace(",", "",$request->input("Fi".$goodSn));
            $realPrice=str_replace(",", "",$request->input("AllPrice".$goodSn));
            $countEditables=DB::table('NewStarfood.dbo.OrderBYSS')->WHERE("SnHDS",$snHDS)->WHERE("SnGood",$goodSn)->count();
            if($countEditables>0){
                // is editable?
                DB::table('NewStarfood.dbo.OrderBYSS')->WHERE("SnHDS",$snHDS)->WHERE("SnGood",$goodSn)->UPDATE(["PackAmount"=>$packAmount
                ,"Amount"=>$amount
                ,"Fi"=>$fi
                ,"Price"=>$price
                ,"PriceAfterTakhfif"=>$price
                ,"DescRecord"=>"دستی"
                ,"FiPack"=>$fiPack
                ,"JozePack"=>$jozePack
                ,"RealFi"=>$fi
                ,"RealPrice"=>$price]);
            }else{
                // is addable?
                $packtypes=DB::select("SELECT NewStarfood.dbo.getPackType($goodSn)PackType");
                $packType=$packtypes[0]->PackType;
                $current = Carbon::today();
                $todayDate = Jalalian::fromCarbon($current)->format('Y/m/d');
                DB::table('NewStarfood.dbo.OrderBYSS')->insert(["CompanyNo"=>5
                    ,"SnHDS"=>$snHDS
                    ,"SnGood"=>$goodSn
                    ,"PackType"=>$packType
                    ,"PackAmount"=>$packAmount
                    ,"Amount"=>$amount
                    ,"Fi"=>$fi
                    ,"Price"=>$price
                    ,"PriceAfterTakhfif"=>$price
                    ,"DescRecord"=>"دستی"
                    ,"DateOrder"=>"".$todayDate.""
                    ,"FiPack"=>$fiPack
                    ,"JozePack"=>$jozePack
                    ,"RealFi"=>$fi
                    ,"RealPrice"=>$price]);
            }
        }
    return Response::json("done");
    }
}   