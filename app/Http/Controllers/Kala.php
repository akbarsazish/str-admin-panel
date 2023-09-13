<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use Response;
use Session;
use Cockie;
use DateTime;
use BrowserDetect;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
class Kala extends Controller {
	// برای نمایش صفحه لیست کالاها در سمت ادمین پنل استفاده می شود.
    public function index(Request $request) {
        $withoutRestrictions=DB::select("SELECT PubGoods.GoodSn from Shop.dbo.PubGoods where GoodSn not in (select productId from NewStarfood.dbo.star_GoodsSaleRestriction) and CompanyNo=5 and PubGoods.GoodGroupSn>49");
        if(count($withoutRestrictions)>0){
            foreach ($withoutRestrictions as $kala) {
                DB::insert("INSERT INTO NewStarfood.dbo.star_GoodsSaleRestriction(maxSale,minSale,productId
				,overLine,callOnSale,zeroExistance,hideKala,activeTakhfifPercent,freeExistance,costLimit,
				costError,sabtDate ,costAmount ,inforsType,activePishKharid)
                VALUES(-1, 1, ".$kala->GoodSn.",0,0,0,0,0,0,0,'',null ,0,0,0)");
            }
        }
        $stocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock FROM Shop.dbo.Stocks WHERE SnStock!=0 AND NameStock!='' AND CompanyNo=5");

        // کیوری کالای در خواست شده 
         $requests=DB::select("SELECT * from(
        SELECT countRequest,a.productId,GoodName,GoodSn,TimeStamp FROM(SELECT COUNT(star_requestedProduct.id) AS countRequest,min(TimeStamp) as TimeStamp,productId  FROM NewStarfood.dbo.star_requestedProduct group by productId)a
        
        JOIN Shop.dbo.PubGoods ON PubGoods.GoodSn=a.productId )b  order by TimeStamp desc");

        // کیور پیش خرید 
        $factors=DB::table("NewStarfood.dbo.star_pishKharidFactorAfter")->join("Shop.dbo.Peopels","CustomerSn","=","PSN")->where("orderStatus",0)->select("*")->get();

        foreach ($factors as $factor) {
            $allMoney=0;
            $orders=DB::table("NewStarfood.dbo.star_pishKharidOrderAfter")->where("SnHDS",$factor->SnOrderPishKharidAfter)->select("*")->get();
            foreach ($orders as $order) {
                $allMoney+=$order->Price;
            }
            $factor->allMoney=$allMoney;
        }
		
		// کیوری پیش خرید های ارسال نشده به دفتر حساب

		$orderPishKharid=DB::table("NewStarfood.dbo.star_pishKharidFactor")
									->join("Shop.dbo.Peopels","CustomerSn","=","PSN")
									->where("orderStatus",0)
									->select("*")
									->get();

        foreach ($orderPishKharid as $orderHds){
            $orderAllMoney=0;
            $orders=DB::table("NewStarfood.dbo.star_pishKharidOrder")->where("SnHDS",$orderHds->SnOrderPishKharid)->select("*")->get();
			
            foreach ($orders as $order) {
                $orderAllMoney+=$order->Price;
            }
            $orderHds->allMoney=$orderAllMoney;
        }
        // کیور مربوط برند 
         $brands=DB::table("NewStarfood.dbo.star_brands")->select("*")->get();

        // کیور کالاهای شامل هشدار 
         $alarmStuff=DB::select("SELECT * FROM(
                    SELECT * FROM( SELECT GoodSn FROM Shop.dbo.PubGoods WHERE GoodSn
                    IN (SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE AlarmAmount>0)
                    )a
                    JOIN Shop.dbo.ViewGoodExists on a.GoodSn=ViewGoodExists.SnGood WHERE ViewGoodExists.CompanyNo=5 and
					ViewGoodExists.FiscalYear=".Session::get("FiscallYear").")b 
                    JOIN (SELECT AlarmAmount,productId FROM NewStarfood.dbo.star_GoodsSaleRestriction)c on b.GoodSn=c.productId");
    
    $alarmedKala=array();
    foreach ($alarmStuff as $stuff) {
    if($stuff->AlarmAmount >= $stuff->Amount ){
    array_push($alarmedKala,$stuff->productId);

    } }
    $alarmedKalas=array();
    if(count($alarmedKala)>0){
    $alarmedKalas=DB::select("SELECT GoodName,Amount,GoodSn FROM Shop.dbo.PubGoods
                        JOIN Shop.dbo.ViewGoodExists on PubGoods.GoodSn=ViewGoodExists.SnGood 
                        WHERE ViewGoodExists.CompanyNo=5 and ViewGoodExists.FiscalYear=".Session::get("FiscallYear")."
                        AND GoodSn in(".implode(',',$alarmedKala).")");

    foreach ($alarmedKalas as $kala) {
        $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;
    }
    }
// کیوری لیست گروپ 
       $mainGroups=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=0 order by mainGroupPriority asc");
       return view ('kala.listKala',['stocks'=>$stocks, 'products'=>$requests, 'mainGroups'=>$mainGroups, 'factors'=>$factors, 'brands'=>$brands, 'alarmedKalas'=>$alarmedKalas,'orderPishKharid'=>$orderPishKharid]);
    }
	//لیستی از کالاها را برای افزودن به یک زیر گروه بر می گرداند.
	    public function getKalaForSubGroup(Request $request)
    {
        $subGroupId=$request->get('id');
        $kalas=DB::select("SELECT Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods 
        where companyNo=5 and not exists (select * from NewStarfood.dbo.star_add_prod_group where star_add_prod_group.product_id=GoodSn and
         star_add_prod_group.secondGroupId=$subGroupId) and CompanyNo=5 and GoodName !=''"
        );
        return Response::json($kalas);
    }
	// صفحه فرانت کالاهای مورد علاقه را بر می گرداند.
public function getFavorite(Request $request)
    {
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
	
        $listKala= DB::select("SELECT DISTINCT PubGoods.GoodSn,PubGoods.GoodName,GoodGroups.GoodGroupSn,GoodPriceSale.Price3,GoodPriceSale.Price4,PUBGoodUnits.UName as UNAME,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.freeExistance,Amount,activePishKharid from Shop.dbo.PubGoods
                                JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                JOIN Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN
                                JOIN NewStarfood.dbo.star_Favorite on PubGoods.GoodSn=star_Favorite.GoodSn
                                JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A on PubGoods.GoodSn=A.SnGood
                                left JOIN Shop.dbo.GoodPriceSale on GoodPriceSale.SnGood=PubGoods.GoodSn  where customerSn=".Session::get('psn').' and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) order by Amount desc');

        foreach ($listKala as $kala) {

            $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;

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

        foreach ($listKala as $kala) {
            if($kala->activePishKharid<1){
                $overLine=0;
                $callOnSale=0;
                $zeroExistance=0;
                $exist="NO";
                $favorits=DB::select("SELECT * FROM star_Favorite");
                foreach ( $favorits as $favorite) {
                    if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==Session::get('psn')){
                        $exist='YES';
                        break;
                    }else{
                        $exist='NO';
                    }
                }
				
                $kala->requested=self::getKalaRequestState(Session::get('psn'),$kala->GoodSn);
				
                $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
                if(count($restrictionState)>0){
                    foreach($restrictionState as $rest){
                        if($rest->overLine==1){
                            $overLine=1;
                        }else{
                            $overLine=0;
                        }
                        if($rest->callOnSale==1){
                            $callOnSale=1;
                        }else{
                            $callOnSale=0;
                        }
                        if($rest->zeroExistance==1){
                            $zeroExistance=1;
                        }else{
                            $zeroExistance=0;
                        }
                    }
                }
                $boughtKalas=DB::select("select  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and  orderStatus=0");
                $orderBYSsn;
                $secondUnit;
                $amount;
                $packAmount;
                foreach ($boughtKalas as $boughtKala) {
                    $orderBYSsn=$boughtKala->SnOrderBYS;
                    $orderGoodSn=$boughtKala->SnGood;
                    $amount=$boughtKala->Amount;
                    $packAmount=$boughtKala->PackAmount;
                    $secondUnits=DB::select('SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                                            JOIN Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                                            JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn
                                            );
                    if(count($secondUnits)>0){
                        foreach ($secondUnits as $unit) {
                            $secondUnit=$unit->UName;
                        }
                    }else{
                        $secondUnit=$kala->UName;
                    }
                }
                if(count($boughtKalas)>0){
                    $kala->bought="Yes";
                    $kala->SnOrderBYS=$orderBYSsn;
                    $kala->secondUnit=$secondUnit;
                    $kala->Amount=$amount;
                    $kala->PackAmount=$packAmount;
                }else{
                    $kala->bought="No";
                }
                $kala->favorite=$exist;
                $kala->overLine=$overLine;
                $kala->callOnSale=$callOnSale;
                if($zeroExistance==1){
                $kala->Amount=0;
                }
            }else{

                $overLine=0;
                $callOnSale=0;
                $zeroExistance=0;
                $exist="NO";
                $favorits=DB::select("SELECT * FROM star_Favorite");
                foreach ( $favorits as $favorite) {
                    if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==Session::get('psn')){
                        $exist='YES';
                        break;
                    }else{
                        $exist='NO';
                    }
                }
                $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
                if(count($restrictionState)>0){
                    foreach($restrictionState as $rest){
                        if($rest->overLine==1){
                            $overLine=1;
                        }else{
                            $overLine=0;
                        }
                        if($rest->callOnSale==1){
                            $callOnSale=1;
                        }else{
                            $callOnSale=0;
                        }
                        if($rest->zeroExistance==1){
                            $zeroExistance=1;
                        }else{
                            $zeroExistance=0;
                        }
                    }
                }
                $boughtKalas=DB::select("SELECT  star_pishKharidFactor.*,star_pishKharidOrder.* from NewStarfood.dbo.star_pishKharidFactor join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=star_pishKharidOrder.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and  orderStatus=0");
                $orderBYSsn;
                $secondUnit;
                $amount;
                $packAmount;
                foreach ($boughtKalas as $boughtKala) {
                    $orderBYSsn=$boughtKala->SnOrderBYSPishKharid;
                    $orderGoodSn=$boughtKala->SnGood;
                    $amount=$boughtKala->Amount;
                    $packAmount=$boughtKala->PackAmount;
                    $secondUnits=DB::select('SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods
                                        JOIN Shop.dbo.GoodUnitSecond ON PubGoods.GoodSn=GoodUnitSecond.SnGood
                                        JOIN Shop.dbo.PUBGoodUnits ON PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn);
                    if(count($secondUnits)>0){
                            $secondUnit=$secondUnits[0]->UName;
                    }else{
                        $secondUnit=$kala->UName;
                    }
                }
                if(count($boughtKalas)>0){
                    $kala->bought="Yes";
                    $kala->SnOrderBYS=$orderBYSsn;
                    $kala->secondUnit=$secondUnit;
                    $kala->Amount=$amount;
                    $kala->PackAmount=$packAmount;
                }else{
                    $kala->bought="No";
                }
                $kala->favorite=$exist;
                $kala->overLine=$overLine;
                $kala->callOnSale=$callOnSale;
                if($zeroExistance==1){
                $kala->Amount=0;
                }
            }
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('kala.favoritProducts',['favorits'=>$listKala,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    public function updateChangedPrice(Request $request)
    {
        $SnHDS=$request->post('SnHDS');
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
        return redirect('/carts');

    }
	
// کالا بر اساس اسم و یا کد آن بر میگرداند. 
	public function searchKalaByName(Request $request)
    {
        $nameOrCode=$request->get('nameOrCode'); // 
        $kala_list=DB::select(" SELECT PubGoods.GoodName,PubGoods.GoodGroupSn,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,V.Amount,GoodCde,GoodGroups.NameGRP from Shop.dbo.PubGoods
                        join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                        JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") V on PubGoods.GoodSn=V.SnGood
                        left join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                        where GoodName!='' and NameGRP!='' and GoodSn!=0
                        and PubGoods.CompanyNo=5  and PubGoods.GoodGroupSn >49 and (GoodName like '%$nameOrCode%' or GoodCde like '%$nameOrCode%')") ;
        return Response::json($kala_list);
    }
	// یک کالا را با جزءیات آن برای سفارش سمت ادمین پنل بر می گرداند.
    public function searchKalaByID(Request $request)
    {
        $goodSn=$request->get("goodSn");
        $kala=DB::select("SELECT *,NewStarfood.dbo.getFirstUnit(GoodSn) as firstUnit,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,NewStarfood.dbo.getAmountUnit(GoodSn) as AmountUnit FROM Shop.dbo.PubGoods join SHop.dbo.GoodPriceSale on GoodSn=GoodPriceSale.SnGood WHERE PubGoods.CompanyNo=5 and GoodSn=$goodSn");
        return Response::json($kala);
    }
// لیست انبارها را از بر می گرداند.
    public function getStocks(Request $request)
    {
        $stocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock from Shop.dbo.Stocks where SnStock!=0 and NameStock!='' and CompanyNo=5");
        return Response::json($stocks);
    }
	 //کالاها را بر اساس انباری که آید آن را می گیرد برمیگرداند
    public function searchKalaByStock(Request $request)
    {
        $stockId=$request->get("stockId");
        $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,V.Amount,
                        PubGoods.GoodCde,GoodGroups.NameGRP,PubGoods.GoodGroupSn from Shop.dbo.PubGoods
                        join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                        join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                        JOIN (select * from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.FiscalYear=".Session::get("FiscallYear").") V on PubGoods.GoodSn=V.SnGood 
                        where GoodName!='' and NameGRP!='' and GoodSn!=0 and PubGoods.GoodGroupSn >49
                        and PubGoods.CompanyNo=5 and V.FiscalYear=".Session::get("FiscallYear")." and V.SnStock=".$stockId);

        
        return Response::json($kalas);
    }
// کالاهایی را که در داخل تصاویر صفحه اول گذاشته اند بر می گرداند.
    public function listKalaOfPicture($id,$picId)
    {
        $picId=$picId;
        $id=$id;
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        $kalaList=DB::select("SELECT NewStarfood.dbo.star_add_homePart_stuff.*,GoodName,A.GoodSn,Price4,Price3,B.SUNAME secondUnit,UNAME as firstUnit,V.Amount,G.GoodGroupSn,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.activePishKharid
                        FROM NewStarfood.dbo.star_add_homePart_stuff
                        join (SELECT PubGoods.GoodSn,PubGoods.GoodGroupSn FROM Shop.dbo.GoodGroups join Shop.dbo.PubGoods on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn) G on G.GoodSn=NewStarfood.dbo.star_add_homePart_stuff.productId
                        join (SELECT PUBGoodUnits.UName,PubGoods.GoodSn from Shop.dbo.PUBGoodUnits join Shop.dbo.PubGoods on PUBGoodUnits.USN=PubGoods.DefaultUnit) A  on A.GoodSn=NewStarfood.dbo.star_add_homePart_stuff.productId
                        JOIN (SELECT PubGoods.GoodName,PubGoods.GoodSn FROM Shop.dbo.PubGoods) C on c.GoodSn=NewStarfood.dbo.star_add_homePart_stuff.productId
                        JOIN (select * from Shop.dbo.ViewGoodExists) V on NewStarfood.dbo.star_add_homePart_stuff.productId=V.SnGood
                        left JOIN (Select GoodPriceSale.Price4,GoodPriceSale.Price3,GoodPriceSale.SnGood from Shop.dbo.GoodPriceSale) S on S.SnGood=NewStarfood.dbo.star_add_homePart_stuff.productId
                        left JOIN (SELECT GoodUnitSecond.SnGoodUnit,PUBGoodUnits.UName as SUNAME,GoodUnitSecond.SnGood from Shop.dbo.GoodUnitSecond join Shop.dbo.PUBGoodUnits on GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN) B on NewStarfood.dbo.star_add_homePart_stuff.productId=B.SnGood
                        left join NewStarfood.dbo.star_GoodsSaleRestriction on NewStarfood.dbo.star_add_homePart_stuff.productId=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                        where NewStarfood.dbo.star_add_homePart_stuff.partPic=".$picId." and V.FiscalYear=".Session::get("FiscallYear")."  and NewStarfood.dbo.star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) order by Amount desc");

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        foreach ($kalaList as $kala) {
            $overLine=0;
            $callOnSale=0;
            $zeroExistance=0;
            $freeExistance=0;
            $activePishKharid=0;
            $exist="NO";
            $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");

            foreach ( $favorits as $favorite) {
                if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==Session::get('psn')){
                    $exist='YES';
                    break;
                }else{
                    $exist='NO';
                }
            }
			
            $kala->requested=self::getKalaRequestState(Session::get('psn'),$kala->GoodSn);

            $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance",'freeExistance','activePishKharid')->get();
            if(count($restrictionState)>0){
                foreach($restrictionState as $rest){
                    if($rest->overLine==1){
                        $overLine=1;
                    }
                    if($rest->callOnSale==1){
                        $callOnSale=1;
                    }
                    if($rest->zeroExistance==1){
                        $zeroExistance=1;
                    }
                    if($rest->activePishKharid==1){
                        $activePishKharid=1;
                    }
                    if($rest->freeExistance==1){
                        $freeExistance=1;
                    }
                }
            }
            $boughtKalas=DB::select("select  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            foreach ($boughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYS;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;
                $secondUnits=DB::select("select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$orderGoodSn);
                foreach ($secondUnits as $unit) {
                    $secondUnit=$unit->UName;
                }
            }
            if(count($boughtKalas)>0){
                $kala->bought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
            }else{
                $kala->bought="No";
            }
            $kala->favorite=$exist;
            $kala->overLine=$overLine;
            $kala->callOnSale=$callOnSale;
            if($zeroExistance==1){
                $kala->Amount=0;
            }
            $boughtKalas=DB::select("select  star_pishKharidFactor.*,star_pishKharidOrder.* from NewStarfood.dbo.star_pishKharidFactor join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=star_pishKharidOrder.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and  orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            foreach ($boughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYSPishKharid;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;
                $secondUnits=DB::select("select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$orderGoodSn);
                if(count($secondUnits)>0){
                    foreach ($secondUnits as $unit) {
                        $secondUnit=$unit->UName;
                    }
                }else{
                    $secondUnit=$kala->firstUnit;
                }
            }
            if(count($boughtKalas)>0){
                $kala->bought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
                $kala->UName=$kala->firstUnit;
            }else{
                $kala->bought="No";
            }
            $kala->favorite=$exist;
            $kala->overLine=$overLine;
            $kala->callOnSale=$callOnSale;
            $kala->activePishKharid=$activePishKharid;
            $kala->freeExistance=$freeExistance;
            if($zeroExistance==1){
            $kala->Amount=0;
            }
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('kala.kalaFromPart',['kala'=>$kalaList,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }
	// برای اطلاعات مودال ویرایش کالا در سمت ادمین پنل
    public function getKalaInfoForEdit(Request $request){
        $kalaId=$request->get('kalaId');
        $maxSaleOfAll=0;
        $showTakhfifPercent=0;
        $kala=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,PubGoods.Price,PubGoods.price2,B.SUNAME,B.AmountUnit, GoodGroups.NameGRP,PUBGoodUnits.UName,star_desc_product.descProduct,senonym from Shop.dbo.PubGoods
        join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
        inner join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN
        LEFT JOIN NewStarfood.dbo.star_desc_product ON PubGoods.GoodSn=star_desc_product.GoodSn
        left JOIN (SELECT GoodUnitSecond.AmountUnit,GoodUnitSecond.SnGoodUnit,PUBGoodUnits.UName as SUNAME,GoodUnitSecond.SnGood from Shop.dbo.GoodUnitSecond join Shop.dbo.PUBGoodUnits on GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN) B on PubGoods.GoodSn=B.SnGood
        where PubGoods.GoodSn=".$kalaId);
        $exactKala;
        foreach ($kala as $k) {
            $exactKala=$k;
           $subUnitStuff= DB::select("SELECT GoodUnitSecond.AmountUnit,PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$k->GoodSn);
            if(count($subUnitStuff)>0){
                foreach ($subUnitStuff as $stuff) {
                    $exactKala->secondUnit=$stuff->secondUnit;
                    $exactKala->amountUnit=$stuff->AmountUnit;
                }
            }else{
                $exactKala->secondUnit="تعریف نشده است";
                $exactKala->amountUnit="تعریف نشده است";
            }
           $priceStuff= DB::select("SELECT GoodPriceSale.Price3,GoodPriceSale.Price4 FROM Shop.dbo.GoodPriceSale 
		   							WHERE GoodPriceSale.SnGood=".$k->GoodSn);
           foreach ($priceStuff as $stuff) {
            $exactKala->mainPrice=$stuff->Price3;
            $exactKala->overLinePrice=$stuff->Price4;
            }
            $webSpecialSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->select('maxSale')->get();
			if(count($webSpecialSettings)>0){
				$maxSaleOfAll=$webSpecialSettings[0]->maxSale;
			}
            $restrictSaleStuff=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$k->GoodSn)->select("minSale","maxSale","overLine","callOnSale","zeroExistance","hideKala",
                                                                                            "activeTakhfifPercent",'inforsType',"freeExistance",'costLimit','costError','costAmount','activePishKharid','alarmAmount')->get();
            if(count($restrictSaleStuff)>0){
                foreach ($restrictSaleStuff as $saleStuff) {
                $exactKala->minSale=$saleStuff->minSale;
                $exactKala->showTakhfifPercent=$saleStuff->activeTakhfifPercent;
                    if($saleStuff->maxSale>-1){
                        $exactKala->maxSale=$saleStuff->maxSale;

                    }else{
                        $exactKala->maxSale=$maxSaleOfAll;
                    }
                $exactKala->callOnSale=$saleStuff->callOnSale;
                $exactKala->overLine=$saleStuff->overLine;
                $exactKala->zeroExistance=$saleStuff->zeroExistance;
                $exactKala->hideKala=$saleStuff->hideKala;
                $exactKala->freeExistance=$saleStuff->freeExistance;
                $exactKala->costLimit=$saleStuff->costLimit;
                $exactKala->costError=$saleStuff->costError;
                $exactKala->costAmount=$saleStuff->costAmount;
                $exactKala->inforsType=$saleStuff->inforsType;
                $exactKala->activePishKharid=$saleStuff->activePishKharid;
                $exactKala->alarmAmount=$saleStuff->alarmAmount;
                }
            }else{
                $exactKala->freeExistance=0;
                $exactKala->minSale=1;
                $exactKala->maxSale=$maxSaleOfAll;
                $exactKala->callOnSale=0;
                $exactKala->overLine=0;
                $exactKala->zeroExistance=0;
                $exactKala->hideKala=0;
                $exactKala->showTakhfifPercent=0;
                $exactKala->costLimit=0;
                $exactKala->costError="ندارد";
                $exactKala->costAmount=0;
                $exactKala->inforsType=0;
                $exactKala->activePishKharid=0;
                $exactKala->alarmAmount=0;
            }
        }
        $mainGroupList=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=0");
        $addedKala=DB::select("select firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group");
        $exist="";
        foreach($kala as $kl){
            foreach($mainGroupList as $group){
                foreach($addedKala as $addkl){
                    if($addkl->firstGroupId==$group->id and $kl->GoodSn==$addkl->product_id){
                        $exist='ok';
                        break;
                    }else{
                        $exist='no';
                    }
                }
                $group->exist=$exist;
            }
        }

        $kalaPriceHistory=DB::select("SELECT application,userId,FORMAT(changedate,'yyyy/MM/dd','fa-ir') as changedate,name,lastName,firstPrice,changedFirstPrice,changedSecondPrice,secondPrice FROM NewStarfood.dbo.star_KalaPriceHistory JOIN NewStarfood.dbo.admin ON admin.id=star_KalaPriceHistory.userId where productId=$kalaId");
        $infors=DB::select("select * from Shop.dbo.infors where CompanyNo=5 and TypeInfor=5");
        $assameKalas=DB::table("NewStarfood.dbo.star_assameKala")->where("mainId",$kalaId)->leftjoin("Shop.dbo.PubGoods","assameId","=","GoodSn")->select("*")->get();
        $stocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock from Shop.dbo.Stocks where SnStock not in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kalaId.") and SnStock!=0 and NameStock!='' and CompanyNo=5");
        $addedStocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock from Shop.dbo.Stocks
                        JOIN star_addedStock on Stocks.SnStock=star_addedStock.stockId where star_addedStock.productId=".$kalaId);
       return Response::json([$exactKala,$mainGroupList, $stocks, $assameKalas,$addedStocks,$infors, $kalaPriceHistory]);
    }
// برای کالا یک تعداد محدودیت و خصوصیت اضافه می کند.
    public function restrictKala(Request $request){
        $overLine1=$request->get('overLine');
        $freeExistance=$request->get('freeExistance');
        $callOnSale=$request->get('callOnSale');
        $zeroExistance=$request->get('zeroExistance');
        $hideKala=$request->get("hideKala");
        $productId=$request->get('kalaId');
        $showTakhfifPercent=$request->get('activeTakhfifPercent');
        $costLimit=$request->get('costLimit');
        $costAmount=$request->get('costAmount');
        $inforsType=$request->get('infors');
        $costErrorContent=$request->get('costErrorContent');
        $activePishKharid=$request->get('activePishKharid');
        $alarmAmount=$request->get('alarmAmount');
        $overLine=0;

        if($showTakhfifPercent){
            $showTakhfifPercent=1;
            $overLine=1;
        }else{
            $showTakhfifPercent=0;
        }

        if($freeExistance){
            $freeExistance=1;
        }else{
            $freeExistance=0;
        }

        if($hideKala){
            $hideKala=1;
        }else{
            $hideKala=0;
        }
        if($activePishKharid){
            $activePishKharid=1;
        }else{
            $activePishKharid=0;
        }

        if($overLine1 or $overLine==1){
            $overLine=1;
        }else{
            $overLine=0;
        }

        if($callOnSale){
            $callOnSale=1;
        }else{
            $callOnSale=0;
        }

        if($zeroExistance){
            $zeroExistance=1;
        }else{
            $zeroExistance=0;
        }

        $maxSaleOfAll=0;
        $webSpecialSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->select('maxSale')->get();
        if(count($webSpecialSettings)>0){
            $maxSaleOfAll=$webSpecialSettings[0]->maxSale;
		}
        $isRestricted = DB::select("SELECT * FROM NewStarfood.dbo.star_GoodsSaleRestriction where productId=".$productId);
        if((count($isRestricted)>0)){
            DB::update("UPDATE NewStarfood.dbo.star_GoodsSaleRestriction  SET overLine=".$overLine.",callOnSale=".$callOnSale.",zeroExistance=".$zeroExistance.",
            hideKala=".$hideKala.",freeExistance=".$freeExistance.",activeTakhfifPercent=".$showTakhfifPercent.",costLimit=".$costLimit."
            ,costError='$costErrorContent',costAmount=$costAmount,inforsType=$inforsType,activePishKharid=$activePishKharid,alarmAmount=$alarmAmount  WHERE productId=".$productId);

        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.star_GoodsSaleRestriction(maxSale, minSale, productId,overLine,callOnSale,zeroExistance,hideKala,activeTakhfifPercent) VALUES(".$maxSaleOfAll.", 1, ".$productId.",".$overLine.",".$callOnSale.",".$zeroExistance.",".$hideKala.",".$showTakhfifPercent.")");
        }
        return Response::json($hideKala);
    }

//تصاویر کالا ها را از مودال ویرایش کالا تغییر می دهد
    public function changeKalaPicture(Request $request)
    {
        $kalaId=$request->get('kalaId');
        $picture1=$request->file('firstPic');
        $picture2=$request->file('secondPic');
        $picture3=$request->file('thirthPic');
        $picture4=$request->file('fourthPic');
        $picture5=$request->file('fifthPic');
        $filename1="";
        $filename2="";
        $filename3="";
        $filename4="";
        $filename5="";
        if($picture1){
        $filename1=$picture1->getClientOriginalName();
        $filename1=$kalaId.'_1.'.'jpg';
        $picture1->move("resources/assets/images/kala/",$filename1);
        }
        if($picture2){
        $filename2=$picture2->getClientOriginalName();
        $filename2=$kalaId.'_2.'.'jpg';
        $picture2->move("resources/assets/images/kala/",$filename2);
        }
        if($picture3){
        $filename3=$picture3->getClientOriginalName();
        $filename3=$kalaId.'_3.'.'jpg';
        $picture3->move("resources/assets/images/kala/",$filename3);
        }
        if($picture4){
        $filename4=$picture4->getClientOriginalName();
        $filename4=$kalaId.'_4.'.'jpg';
        $picture4->move("resources/assets/images/kala/",$filename4);
        }
        if($picture5){
        $filename5=$picture5->getClientOriginalName();
        $filename5=$kalaId.'_5.'.'jpg';
        $picture5->move("resources/assets/images/kala/",$filename5);
        }
        /*DB::insert("INSERT INTO NewStarfood.dbo.starPicAddress(goodId,picAddress,picAddress2,picAddress3,picAddress4,picAddress5) VALUES(".$kalaId.",'".$filename1."','".$filename2."','".$filename3."','".$filename4."','".$filename5."')");
		*/
        return Response::json('good');
    }

// صفحه جزءیات کالا را بر میگرداند.
    public function describeKala($groupId,$id)
    {
        $groupId=$groupId;// آی دی گروه که به آن تعلق می گیرد.
        $productId=$id;// آی دی کالا
        $overLine=0; // قیمت خط خورده کالا نشان داده شود. 1 می گیرد.
        $callOnSale=0; // خرید کالا در صورتیکه نیاز به تماس با شرکت باشد 1 در نظر گرفته می شود..
        $zeroExistance=0; //آیا کالا قصد صفر شده است
        $customerId=Session::get("psn");
        if(!Session::get("otherUserInfo")){
            $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
            $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
            if($lastReferesh>=0 or count($logedIns)<1){
                 $palatform=BrowserDetect::platformFamily();
                 $browser=BrowserDetect::browserFamily();
                if(count($logedIns)<1){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'productId'=>''.$productId.'']);
                }elseif($lastReferesh>0){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'productId'=>''.$productId.'']);
                }else{
                    $lastLoginId=DB::select("SELECT MAX(id)lastLoginId FROM NewStarfood.dbo.star_customerTrack WHERE customerId=$customerId");

                    if(count($lastLoginId)>0){
                        $lastLoginId=$lastLoginId[0]->lastLoginId;
                        $lastVisitedProductIds=DB::select("SELECT productId FROM NewStarfood.dbo.star_customerTrack WHERE id=$lastLoginId");
                        $productIds;
                        if(count($lastVisitedProductIds)>0){
                            $productIds = explode("_",$lastVisitedProductIds[0]->productId);
                        }

                        if(!in_array($productId,$productIds)){
                            DB::update("UPDATE NewStarfood.dbo.star_customerTrack SET productId+='_$productId' WHERE customerId=$customerId and id=$lastLoginId");
                        }
                    }
                }
            }
        }
        // کالا را با جزءیات قیمت و غیره  بدست می آورد
        $listKala=DB::select("SELECT  GoodGroups.NameGRP,PubGoods.GoodCde,PubGoods.GoodSn,PubGoods.GoodName,GoodPriceSale.Price3,GoodPriceSale.Price4,PUBGoodUnits.UName as UNAME,A.Amount as AmountExist,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activePishKharid  from Shop.dbo.PubGoods
        join Shop.dbo.GoodGroups on GoodGroups.GoodGroupSn=PubGoods.GoodGroupSn
        left join Shop.dbo.GoodPriceSale on GoodPriceSale.SnGood=PubGoods.GoodSn
        left join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN
        left join (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=".Session::get("FiscallYear").") A on PubGoods.GoodSn=A.SnGood
        left join NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
         WHERE PubGoods.GoodSn=".$productId." and PubGoods.GoodGroupSn>49");

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        foreach ($listKala as $kala) {
            $exist="NO";
            $overLine=0;
            $callOnSale=0;
            $zeroExistance=0;
            $discriptKala="توضیحاتی ندارد";
            $discription=DB::select("SELECT descProduct FROM NewStarfood.dbo.star_desc_Product where GoodSn=".$kala->GoodSn);
            foreach ($discription as $disc) {
                $discriptKala=$disc->descProduct;
            }
            $kala->requested=self::getKalaRequestState(Session::get('psn'),$kala->GoodSn);
            $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
            if(count($restrictionState)>0){
                foreach($restrictionState as $rest){
                if($rest->overLine==1){
                    $overLine=1;
                }else{
                    $overLine=0;
                }
                if($rest->callOnSale==1){
                    $callOnSale=1;
                }else{
                    $callOnSale=0;
                }
                if($rest->zeroExistance==1){
                    $zeroExistance=1;
                }else{
                    $zeroExistance=0;
                }
            }
            }
            $kala->descKala=$discriptKala;
            $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");
            foreach ( $favorits as $favorite) {
                if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==Session::get('psn')){
                    $exist='YES';
                    break;
                }else{
                    $exist='NO';
                }
            }
            $boughtKalas=DB::select("select  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn."  and orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            $defaultUnit;
            $defaultUnits=DB::select("select defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$kala->GoodSn);
            
            $secondUnits=DB::select("select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$kala->GoodSn);
            if(count($secondUnits)>0){
                foreach ($secondUnits as $unit) {
                $secondUnit=$unit->UName;
                $packAmount=$unit->AmountUnit;
            }
            }else{
                $secondUnit=$defaultUnit;
                $packAmount=1;
            }
            
            foreach ($defaultUnits as $unit) {
                $defaultUnit=$unit->defaultUnit;
            }
            foreach ($boughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYS;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$packAmount;


            }
            if(count($boughtKalas)>0){
                $kala->bought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
            }else{
                $kala->bought="No";
                $kala->SnOrderBYS=0;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=1;
                $kala->PackAmount=$packAmount;
            }
            $kala->favorite=$exist;
            $kala->overLine=$overLine;
            $kala->callOnSale=$callOnSale;
            if($zeroExistance==1){
            $kala->AmountExist=0;
            }
            $preBoughtKalas=DB::select("select  star_pishKharidFactor.*,star_pishKharidOrder.* from NewStarfood.dbo.star_pishKharidFactor join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=star_pishKharidOrder.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and  orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            foreach ($preBoughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYSPishKharid;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;
                $secondUnits=DB::select("select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$orderGoodSn);
                if(count($secondUnits)>0){
                    foreach ($secondUnits as $unit) {
                        $secondUnit=$unit->UName;
                    }
                }else{
                    $secondUnit=$kala->UName;
                }
            }
            if(count($preBoughtKalas)>0){
                $kala->preBought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
                $kala->UName=$kala->UNAME;
            }else{
                $kala->preBought="No";
            }
        }
        $mainGroup=DB::select("select title from NewStarfood.dbo.star_group where star_group.id=".$groupId);
        $groupName="";
        foreach ($mainGroup as $gr) {
            $groupName=$gr->title;
        }
        // کالاهای مشابهش را بدست می آورد.
        $assameKalas=DB::select("select TOP 4 * from Shop.dbo.PubGoods join NewStarfood.dbo.star_assameKala on PubGoods.GoodSn=star_assameKala.assameId WHERE mainId=".$productId." and PubGoods.GoodSn not in (select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1)");
		// موقعیت لوگو را تعیین می کند.
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('kala.descKala',['product'=>$listKala,'groupName'=>$groupName,'assameKalas'=>$assameKalas,'mainGroupId'=>$groupId,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }
	
	/* کالاهای گروهی اصلی را که آی دی اش فرستاده شده بر می گرداند.
	 پارامتر آن آی دی گروه اصلی است.
	 */
    public function getMainGroupKalaForFront($groupId){
        if(!Session::get("otherUserInfo")){
            $customerId=SESSION::get("psn");
            $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
            $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
            if($lastReferesh>=0 or count($logedIns)<1){
                 $palatform=BrowserDetect::platformFamily();
                 $browser=BrowserDetect::browserFamily();
                if(count($logedIns)<1){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'groupId'=>''.$groupId.'']);
                }elseif($lastReferesh>0){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'groupId'=>''.$groupId.'']);
                }else{
                    $lastLoginId=DB::select("SELECT MAX(id)lastLoginId FROM NewStarfood.dbo.star_customerTrack WHERE customerId=$customerId");

                    if(count($lastLoginId)>0){
                        $lastLoginId=$lastLoginId[0]->lastLoginId;
                        $lastVisitedGroupIds=DB::select("SELECT groupId FROM NewStarfood.dbo.star_customerTrack WHERE id=$lastLoginId");
                        $groupIds;
                        if(count($lastVisitedGroupIds)>0){
                            $groupIds = explode("_",$lastVisitedGroupIds[0]->groupId);
                        }

                        if(!in_array($groupId,$groupIds)){
                            DB::update("UPDATE NewStarfood.dbo.star_customerTrack SET groupId+='_$groupId' where customerId=$customerId and id=$lastLoginId");
                        }
                    }
                }
            }
        }
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        $secondGroups=DB::select("Select id from NewStarfood.dbo.star_group where selfGroupId=$groupId");
        $secondGroupId=$secondGroups[0]->id;
       $listKala= DB::select("SELECT SnOrderBYSPishKharid,pishKharidPackAmount,PishKharidAmount,IIF(ISNULL(SnOrderBYSPishKharid,0)=0,'No','Yes') pishKharid,firstGroupId,CompanyNo,GoodSn,GoodName,NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,IIF(NewStarfood.dbo.isFavoritOrNot(".Session::get('psn').",GoodSn)>0,'YES','NO') AS favorite,IIF(NewStarfood.dbo.isRequestedOrNot(".Session::get('psn').",GoodSn)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine, iif(NewStarfood.dbo.getSecondUnit(GoodSn) is null,NewStarfood.dbo.getFirstUnit(GoodSn),NewStarfood.dbo.getSecondUnit(GoodSn)) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid,IsActive FROM(
        SELECT SnOrderBYSPishKharid,pishKharidPackAmount,PishKharidAmount,firstGroupId,secondGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
                            ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,IsActive FROM Shop.dbo.PubGoods
                                    INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
                                    INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
                                    INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                                    LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
                                    LEFT JOIN (SELECT  SnOrderPishKharid,star_pishKharidOrder.SnOrderBYSPishKharid,SnGood,Amount as PishKharidAmount,PackAmount as pishKharidPackAmount FROM NewStarfood.dbo.star_pishKharidFactor inner join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=SnHDS where CustomerSn=".Session::get('psn')." and orderStatus=0)g on g.SnGood=PubGoods.GoodSn
                                    LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
                                    LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
                                    ) A WHERE firstGroupId=$groupId AND IsActive=1 AND CompanyNo=5 AND not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 AND productId=GoodSn ) ORDER BY Amount DESC");
        $listSubGroups=DB::select("SELECT
        id,
        title
        ,selfGroupId
        ,percentTakhf
        ,secondBranchId
        ,thirdBranchId
        ,mainGroupPriority
        ,subGroupPriority FROM NewStarfood.dbo.star_group where selfGroupId=".$groupId." order by subGroupPriority desc");
        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
           $currency=$cr->currency;
        }
        if($currency==10){
           $currencyName="تومان";
       }
       $minSubGroupId=DB::table("NewStarfood.dbo.star_add_prod_group")->where("firstGroupId",$groupId)->min("secondGroupId");
       $logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('groups.maingroupKala',['listKala'=>$listKala,'listGroups'=>$listSubGroups,'mainGrId'=>$groupId,'subGroupId'=>$minSubGroupId,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }
//برای تنظیمات کالاهای برند استفاده می شود.
    public function getListKala(Request $request)
    {
        $listKala=DB::select("SELECT GoodSn,GoodName,price,Price2 FROM Shop.dbo.PubGoods WHERE CompanyNo=5 and GoodSn!=0 and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 )");
        return Response::json($listKala);
    }
	// کالاهای سمت راست که انتخاب شده اند.
    public function getSelectedListKala(Request $request)
    {
        $ids=$request->get('kalaIds');
        $kalas= array( );
        $kala;
        foreach ($ids as $id) {
            $kala=DB::select("SELECT GoodSn,GoodName,price,Price2 FROM Shop.dbo.PubGoods WHERE CompanyNo=5 and GoodSn=".$id);
            $kalas=$kala;
        }
        return Response::json($kalas);
    }
    public function changeKalaPartPriority(Request $request)
    {
        $partId=$request->get('partId');
        $kalaId=$request->get('kalaId');
        $priorityState=$request->get('priority');
        $kala = DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE productId=".$kalaId." and homepartId=".$partId);
        $countKala = DB::select("SELECT COUNT(id) as countKala FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
        $countAllKala=0;
        foreach ($countKala as $countKl) {
            $countAllKala=$countKl->countKala;
        }
        $priority=0;
        foreach ($kala as $k) {
            $priority=$k->priority;
        }
        if ($priorityState=='up') {
            if($priority>1){
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority-1).' WHERE homepartId='.$partId.'and productId='.$kalaId);
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority).' WHERE homepartId='.$partId.'and productId!='.$kalaId.' and priority='.($priority-1));
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
            return Response::json($kala);
        }else{
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
            return Response::json($kala);
        }

        } else {
            if($priority<$countAllKala and $priority>0){
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority+1).' WHERE homepartId='.$partId.'and productId='.$kalaId);
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority).' WHERE homepartId='.$partId.'and productId!='.$kalaId.' and priority='.($priority+1));
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
            return Response::json($kala);
            }else{
                $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
                return Response::json($kala);

            }

        }

    }
	// کالاها را برای تصاویر صفحه اول می آورد.
    public function getListKalaForPictures(Request $request)
    {
        $partPic= $request->get("partPic");
        $addedKala=DB::select("SELECT PubGoods.GoodSn,PubGoods.GoodName FROM Shop.dbo.PubGoods INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId WHERE partPic=".$partPic." and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) ORDER BY priority ASC");
        $allKalas=DB::select("SELECT GoodSn,GoodName FROM Shop.dbo.PubGoods WHERE GoodSn!=0 and CompanyNo=5 and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 )");
        return Response::json(['addedKala'=>$addedKala,'allKala'=>$allKalas]);
    }
	// کالاها را برای زیر گروه جستجو می کند.
    public function searchKalas(Request $request) {
        $term = self::changeToArabicLetterAndEngNumber($request->get('searchTerm'));
        $id= $request->get('id');
        if($id){
                $kalas=DB::select("SELECT Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods
                join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                where PubGoods.companyNo=5 and Shop.dbo.PubGoods.GoodSn not in (
                    SELECT Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods
                    join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_id
                    where companyNo=5 and star_add_prod_group.secondGroupId=".$id.")
                    and Shop.dbo.PubGoods.GoodName like '%".$term."%'
                    or Shop.dbo.PubGoods.GoodCde like '%".$term."%'
                    and PubGoods.GoodGroupSn>49 and PubGoods.GoodName !=''
                    and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction
                    where hideKala=1 )"
                );
                return Response::json($kalas);
            }else{
                $kalas=DB::select("SELECT Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods
                join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                where PubGoods.companyNo=5  and (Shop.dbo.PubGoods.GoodName like '%".$term."%'
                or Shop.dbo.PubGoods.GoodCde like '%".$term."%') and PubGoods.GoodName!=''
                and PubGoods.GoodGroupSn>49 and PubGoods.GoodSn
                not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 )"
                );
                return Response::json($kalas);
            }
    }
    
    public function getKalasSearch(Request $request)
    {
        $groupId=$request->get('groupId');
        $subGroups;
        $kalas;
        $flag;
        if($groupId!=0){
            $flag=array(1,2);
            $subGroups=DB::select("SELECT id,title FROM NewStarfood.dbo.star_group WHERE selfGroupId=".$groupId);
            $kalas=DB::select("SELECT GoodName,GoodSn,GoodGroupSn FROM Shop.dbo.PubGoods
            JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=star_add_prod_group.product_id
             WHERE firstGroupId=".$groupId." and PubGoods.GoodGroupSn>49 and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1)");
        }else{
            $flag=array(1);
            $subGroups=DB::select("SELECT id,title FROM NewStarfood.dbo.star_group WHERE selfGroupId=0");
            $kalas=DB::select("SELECT GoodName,GoodSn,GoodGroupSn FROM Shop.dbo.PubGoods WHERE CompanyNo=5 and GoodGroupSn>49 and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and GoodSn!=0");

        }
        return Response::json(['kalas'=>$kalas,'subGroups'=>$subGroups,'flag'=>$flag]);
    }
    public function getKalasSearchSubGroup(Request $request)
    {
        $groupId=$request->get('groupId');
        $kalas=DB::select("SELECT GoodName,GoodSn FROM Shop.dbo.PubGoods INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=star_add_prod_group.product_id WHERE secondGroupId=".$groupId." and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 )");
        return Response::json($kalas);
    }
    public function changePicturesKalaPriority(Request $request)
    {
        $picId=$request->get('picId');
        $kalaId=$request->get('kalaId');
        $priorityState=$request->get('priorityState');
        $priorities = DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE productId=".$kalaId." AND partPic=".$picId);
        $priority=0;
        foreach ($priorities as $pr) {
            $priority=$pr->priority;
        }
        if ($priorityState=='up') {
            if($priority>1){
            DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority=".($priority-1)." WHERE productId=".$kalaId." AND partPic=".$picId);
            DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority=".($priority)." WHERE productId!=".$kalaId." and priority=".($priority-1));

            return redirect('/controlMainPage');

        }else{
            return 'up not allowed with priority:'.$priority;
        }
        } else {
            if($priority<20 or $priority>=0){
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority+=1 WHERE productId=".$kalaId." AND partPic=".$picId);
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority=".($priority)." WHERE productId!=".$kalaId." and priority=".($priority+1));
            return redirect('/controlMainPage');
            }else{
                return 'down not allowed with priority:'.$priority;
            }
        }
        return Response::json('good');
    }
    public function getUnitsForSettingMinSale(Request $request){
        $kalaId=$request->get('Pcode');
        $secondUnit;
        $defaultUnit;
        $amountUnit;
        $amountExist=0;
        $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName,V.Amount FROM Shop.dbo.PubGoods
                JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=1402) V on PubGoods.GoodSn=V.SnGood WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn=".$kalaId);         
        foreach ($kalas as $k) {
            $defaultUnit=$k->UName;
            $amountExist=$k->Amount;
        }
        $subUnitStuff= DB::select("SELECT GoodUnitSecond.AmountUnit,PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$kalaId);
        foreach ($subUnitStuff as $stuff) {
            $secondUnit=$stuff->secondUnit;
            $amountUnit=$stuff->AmountUnit;
        }
        $code=" ";
          for ($i= 1; $i <= 500; $i++) {
            $code.="<span class='d-none'>31</span>
            <span id='Count1_0_239' class='d-none'>".($i*$amountUnit)."</span>
             <span id='CountLarge_0_239' class='d-none'>".$i."</span>
             <input value='' style='display:none' class='SnOrderBYS'/>
             <button style='font-weight: bold;  font-size: 17px;' value='".$i.'_'.$kalaId.'_'.$defaultUnit."' class='setMinSale btn-add-to-cart w-100 mb-2'> ".$i."".$secondUnit."  معادل ".($i*$amountUnit)."".$defaultUnit."</button>
             ";
          }
        return Response::json($code);
    }
    public function setMinimamSaleKala(Request $request)
    {
        $productId=$request->get('kalaId');
        $minSale=$request->get('amountUnit');
        $maxSaleOfAll=0;
        $webSpecialSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->select('maxSale')->get();
        if(count($webSpecialSettings)>0){
            $maxSaleOfAll=$webSpecialSettings[0]->maxSale;
		}
        $checkExistance = DB::select("SELECT * FROM NewStarfood.dbo.star_GoodsSaleRestriction where productId=".$productId);
        if(!(count($checkExistance)>0)){
            DB::insert("INSERT INTO NewStarfood.dbo.star_GoodsSaleRestriction(maxSale, minSale, productId,overLine,callOnSale,zeroExistance) VALUES(".$maxSaleOfAll.", 1, ".$productId.",0,0,0)");

        }else{
            DB::update("UPDATE NewStarfood.dbo.star_GoodsSaleRestriction  SET minSale=".$minSale." WHERE productId=".$productId);
        }
        return Response::json($minSale);
    }


    public function getUnitsForSettingMaxSale(Request $request){
        $kalaId=$request->get('Pcode');
        $secondUnit;
        $defaultUnit;
        $amountUnit;
        $amountExist=0;
        $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName,V.Amount FROM Shop.dbo.PubGoods
                    JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                    JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=1402) V on PubGoods.GoodSn=V.SnGood WHERE PubGoods.CompanyNo=5 AND PubGoods.GoodSn=".$kalaId);
        foreach ($kalas as $k) {
            $defaultUnit=$k->UName;
            $amountExist=$k->Amount;
        }
        $subUnitStuff= DB::select("SELECT GoodUnitSecond.AmountUnit,PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$kalaId);
        
        foreach ($subUnitStuff as $stuff) {
            $secondUnit=$stuff->secondUnit;
            $amountUnit=$stuff->AmountUnit;
        }
        $code=" ";
        for ($i= 1; $i <= 500; $i++) {
        $code.="<span class='d-none'>31</span>
            <span id='Count1_0_239' class='d-none'>".($i*$amountUnit)."</span>
            <span id='CountLarge_0_239' class='d-none'>".$i."</span>
            <input value='' style='display:none' class='SnOrderBYS'/>
            <button style='font-weight: bold;  font-size: 17px;' value='".$i.'_'.$kalaId.'_'.$defaultUnit."' class='setMaxSale btn-add-to-cart w-100 mb-2'> ".$i."".$secondUnit."  معادل ".($i*$amountUnit)."".$defaultUnit."</button>
            ";
        }
        return Response::json($code);
    }



    public function setMaximamSaleKala(Request $request)
    {
        $productId=$request->get('kalaId');
        $maxSale=$request->get('amountUnit');
        $checkExistance = DB::select("SELECT * FROM NewStarfood.dbo.star_GoodsSaleRestriction where productId=".$productId);
        if(!(count($checkExistance)>0)){
            DB::insert("INSERT INTO NewStarfood.dbo.star_GoodsSaleRestriction(maxSale, minSale, productId,overLine,callOnSale,zeroExistance) VALUES(".$maxSaleOfAll.", 1, ".$productId.",0,0,0)");

        }else{
            DB::update("UPDATE NewStarfood.dbo.star_GoodsSaleRestriction  SET maxSale=".$maxSale." WHERE productId=".$productId);
        }
        return Response::json($maxSale);
    }

    public function getUnitsForUpdate(Request $request)
    {
            $costAmount=0;
            $amelSn=0;
            $kalaId=$request->get('Pcode');
            $secondUnit;
            $defaultUnit;
            $amountUnit;
            $amountExist=0;
            $costLimit=0;
            $costError="";
    
            $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,PUBGoodUnits.UName,V.Amount FROM Shop.dbo.PubGoods
                        JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                        JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=1402) V on PubGoods.GoodSn=V.SnGood
                        where PubGoods.CompanyNo=5 and PubGoods.GoodSn=".$kalaId);
            
            foreach ($kalas as $k) {
                $defaultUnit=$k->UName;
                $amountExist=$k->Amount;
            }

            $subUnitStuff= DB::select("SELECT GoodUnitSecond.AmountUnit,PUBGoodUnits.UName AS secondUnit FROM Shop.dbo.GoodUnitSecond JOIN Shop.dbo.PUBGoodUnits
                                    ON GoodUnitSecond.SnGoodUnit=PUBGoodUnits.USN WHERE GoodUnitSecond.SnGood=".$kalaId);
            if(count($subUnitStuff)>0){
                foreach ($subUnitStuff as $stuff) {
                    $secondUnit=$stuff->secondUnit;
                    $amountUnit=$stuff->AmountUnit;
                }
            }else{
                $secondUnit=$defaultUnit;
                $amountUnit=1;
            }
            $saleAmounts=DB::select("SELECT maxSale from NewStarfood.dbo.star_webSpecialSetting");
                $maxSaleAmount=10;
                $minSaleAmount=1;
                foreach ($saleAmounts as $amount) {
                    $maxSaleAmount=$amount->maxSale;
                }
                $testRestriction=DB::select("SELECT * FROM  NewStarfood.dbo.star_GoodsSaleRestriction WHERE productId=".$kalaId);
                foreach ($testRestriction as $restriction) {
                    if($restriction->maxSale>-1){
                        $maxSaleAmount=$restriction->maxSale;
                    }
                    $minSaleAmount=$restriction->minSale;
                    $costLimit=$restriction->costLimit;
                    $costError=$restriction->costError;
                    $costAmount=$restriction->costAmount;
                    $amelSn=$restriction->inforsType;
                    $freeExistance=$restriction->freeExistance;
                    $zeroExistance=$restriction->zeroExistance;
                }
                $maxSale=$maxSaleAmount;
                $minSaleAmount=$minSaleAmount;
            return Response::json(['minSaleAmount'=>$minSaleAmount,'kalaId'=>$kalaId,'maxSale'=>$maxSale
                                    ,'amountUnit'=>$amountUnit,'amountExist'=>$amountExist,'costLimit'=>$costLimit,
                                    'costError'=>$costError,'secondUnit'=>$secondUnit,'defaultUnit'=>$defaultUnit,
                                    'freeExistance'=>$freeExistance,'zeroExistance'=>$zeroExistance]);
    }


    public function pishKharidSomething(Request $request){
        $packType;
        $packAmount;
        $allPacks;
        $defaultUnit=0;
        $costAmount=0;
        $amelSn=0;
        $kalaId=$request->get('kalaId');
        $amountUnit=$request->get('amountUnit');
        $checkExistance=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kalaId)->select("*")->get();
        foreach ($checkExistance as $pr) {
            $costLimit=$pr->costLimit;
            $costAmount=$pr->costAmount;
            $amelSn=$pr->inforsType;
        }
        $secondUnits=DB::select("SELECT SnGoodUnit,AmountUnit from Shop.dbo.GoodUnitSecond where GoodUnitSecond.SnGood=".$kalaId);
        $defaultUnits=DB::select("SELECT defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$kalaId);
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
        $amountBought=(int)$amountUnit/$packAmount;

        $prices=DB::select("SELECT GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$kalaId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $maxOrderNo=DB::select("SELECT MAX(OrderNo) as maxNo from NewStarfood.dbo.star_pishKharidFactor where CompanyNo=5");
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
        $countOrders=DB::select("SELECT count(SnOrderPishKharid) AS contOrder from NewStarfood.dbo.star_pishKharidFactor WHERE OrderStatus=0 AND  CustomerSn=".$customerId);
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
            DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactor (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)
            VALUES(5,".$factorNo.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscallYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
           $maxsFactor=DB::select("SELECT MAX(SnOrderPishKharid) as maxFactorId from NewStarfood.dbo.star_pishKharidFactor where CustomerSn=".$customerId);
           $maxsFactorId=0;
           foreach ($maxsFactor as $maxFact) {
            $maxsFactorId=$maxFact->maxFactorId;
           }
        }
        $maxOrderSn=DB::select("SELECT MAX(SnOrderPishKharid) AS mxsn from NewStarfood.dbo.star_pishKharidFactor WHERE CustomerSn=".$customerId);
        $maxOrder=1;

        if(count($maxOrderSn)>0){

            foreach ($maxOrderSn as $mxsn) {
                $maxOrder=($mxsn->mxsn)+1;
            }

        }else{

            $maxOrder=1;

            }

        $FactorStarStatus=DB::select("SELECT OrderStatus from NewStarfood.dbo.star_pishKharidFactor where CompanyNo=5 and CustomerSn=".$customerId." and SnOrderPishKharid=".$maxOrder);
        $orderState=0;
        foreach ($FactorStarStatus as $status) {
            $orderState=$status->OrderStatus;
        }
        if($orderState==1){
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactor (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)

                VALUES(5,".$maxOrder.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscallYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
                $FactorStarSn=DB::select("SELECT MAX(SnOrderPishKharid) as snOrder FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=".$customerId." and OrderStatus=0");
                $lastOrder;

                if(count($FactorStarSn)>0){

                    foreach ($FactorStarSn as $orderSn) {
                        $lastOrder=$orderSn->snOrder;
                    }

                }else{

                    $lastOrder=1;
                    }

                $fiPack=$allMoney/$packAmount;
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidOrder(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
        }else{
                $FactorStarSn=DB::select("SELECT MAX(SnOrderPishKharid) as snOrder FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=".$customerId." and OrderStatus=0");
                $lastOrder;
                if(count($FactorStarSn)>0){

                    foreach ($FactorStarSn as $orderSn) {
                        $lastOrder=$orderSn->snOrder;
                    }

                }else{

                    $lastOrder=1;

                    }

                $fiPack=$allMoney/$packAmount;
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidOrder(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                $snlastBYS=DB::table('NewStarfood.dbo.orderStar')->max('SnOrderBYS');
            }

        return Response::json(mb_convert_encoding($snlastBYS, "HTML-ENTITIES", "UTF-8"));
    }

    //پیش خرید
    public function updateOrderPishKharid(Request $request)
    {
        $costAmount=0;
        $amelSn=0;
        $costLimit=0;
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
        $prices=DB::select("select GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $packAmount=(int)($amountUnit/$packAmount);
        DB::update("UPDATE NewStarfood.dbo.star_pishKharidOrder SET Amount=".$amountUnit.",PackAmount=$packAmount,Price=".$allMoney." WHERE SnOrderBYSPishKharid=".$orderBYSsn);
        $checkExistance=DB::table("NewStarfood.dbo.star_orderAmelBYS")->where("SnOrder",$orderBYSsn)->count();
        return Response::json('good');
    }

    public function preBuySomethingFromHome(Request $request)
    {
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

        $amountUnit=$request->get('amountUnit')*$packAmount;
        $amountBought=$request->get('amountUnit');
        $prices=DB::select("select GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$kalaId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        $maxOrderNo=DB::select("select MAX(OrderNo) as maxNo from NewStarfood.dbo.star_pishKharidFactor where CompanyNo=5");
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
        $countOrders=DB::select("SELECT count(SnOrderPishKharid) AS contOrder from NewStarfood.dbo.star_pishKharidFactor WHERE OrderStatus=0 AND  CustomerSn=".$customerId);
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
            DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactor (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)
            VALUES(5,".$factorNo.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscallYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
           $maxsFactor=DB::select("SELECT MAX(SnOrderPishKharid) as maxFactorId from NewStarfood.dbo.star_pishKharidFactor where CustomerSn=".$customerId);
           $maxsFactorId=0;
           foreach ($maxsFactor as $maxFact) {
            $maxsFactorId=$maxFact->maxFactorId;
           }
        }
        $maxOrderSn=DB::select("SELECT MAX(SnOrderPishKharid) AS mxsn from NewStarfood.dbo.star_pishKharidFactor WHERE CustomerSn=".$customerId);
        $maxOrder=1;

        if(count($maxOrderSn)>0){

            foreach ($maxOrderSn as $mxsn) {
                $maxOrder=($mxsn->mxsn)+1;
            }

        }else{

            $maxOrder=1;

            }

        $FactorStarStatus=DB::select("SELECT OrderStatus from NewStarfood.dbo.star_pishKharidFactor where CompanyNo=5 and CustomerSn=".$customerId." and SnOrderPishKharid=".$maxOrder);
        $orderState=0;
        foreach ($FactorStarStatus as $status) {
            $orderState=$status->OrderStatus;
        }
        $snlastBYS=0;
        if($orderState==1){
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidFactor (CompanyNo,OrderNo,OrderDate,CustomerSn,OrderDesc,OrderStatus,LastDatePay,LastDateTrue,FiscalYear,TimeStamp,BazarYab,CountPrintOrder,SnUser,OrderAddress,OtherCustName,TahvilType,TahvilDesc,RanandehName,MashinNo,BarNameNo,IsExport,SnOrderHDSRecived,OrderOrPishFactor,OtherMobile,OtherTel,DateNovbat,TimeNovbat,Takhfif,OrderNo2,SnOrder2,NextOrderDate,LastOrderCust,SaveTimeOrder,LatOrder,LonOrder,Sal_SnCust,Sal_SnBazaryab,IsFax,FaxUser,FaxDate,FaxTime,PayTypeOrder,SnHDSTablet_O,SnSellerTablet_O,EzafatOrder,KosoratOrder,NameEzafatOrder,NameKosoratOrder)

                VALUES(5,".$maxOrder.",'".$todayDate."',".$customerId.",'',0,'','','".Session::get("FiscallYear")."',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
                $FactorStarSn=DB::select("SELECT MAX(SnOrderPishKharid) as snOrder FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=".$customerId." and OrderStatus=0");
                $lastOrder;

                if(count($FactorStarSn)>0){

                    foreach ($FactorStarSn as $orderSn) {
                        $lastOrder=$orderSn->snOrder;
                    }

                }else{

                    $lastOrder=1;
                    }

                $fiPack=$allMoney/$packAmount;
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidOrder(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                $snlastBYS=DB::table('NewStarfood.dbo.star_pishKharidOrder')->max('SnOrderBYSPishKharid');
        }else{
                $FactorStarSn=DB::select("SELECT MAX(SnOrderPishKharid) as snOrder FROM NewStarfood.dbo.star_pishKharidFactor WHERE customerSn=".$customerId." and OrderStatus=0");
                $lastOrder;
                if(count($FactorStarSn)>0){

                    foreach ($FactorStarSn as $orderSn) {
                        $lastOrder=$orderSn->snOrder;
                    }

                }else{

                    $lastOrder=1;

                    }

                $fiPack=$allMoney/$packAmount;
                DB::insert("INSERT INTO NewStarfood.dbo.star_pishKharidOrder(CompanyNo,SnHDS,SnGood,PackType,PackAmount,Amount,Fi,Price,DescRecord,StatusBys,DateOrder,SnUser,TimeStamp,FactorFew,ExportType,SendToKarkhaneh,FiPack,IsExport,SnOrderDetailRecived,OrderTo,GoodName2,JozePack,SaleType,PriceMaliyat,PercentTakhFif,PriceTakhfif,PriceAfterTakhfif,PercentReval,PriceReval,RealFi,RealPrice,Price3PercentMaliat,PercentSood,Tedad,Tol,Arz,Zekhamat,SnOrderBys2,SnOrderHds2,OrderNo2,OrderDate2,SnBazaryab2,FewExit,TimeTasviyeInOrder,ItemNo,TakhfifDetail1,TakhfifDetail2,TakhfifDetail3,TakhfifDetail4,PriceTakhfifDetail1,PriceTakhfifDetail2,PriceTakhfifDetail3,PriceTakhfifDetail4,FiAfterTakhfifDetail1,FiAfterTakhfifDetail2,FiAfterTakhfifDetail3,FiAfterTakhfifDetail4)

                VALUES(5,".$lastOrder.",".$kalaId.",".$packType.",".$amountBought.",".$amountUnit.",".$exactPrice.",".$allMoney.",'',0,'".$todayDate."',12,".(DB::raw('CURRENT_TIMESTAMP')).",0,0,0,".$fiPack.",0,0,0,'',0,0,0,0,0,".$allMoney.",0,0,".$exactPrice.",".$allMoney.",0,0,0,0,0,0,0,0,0,'',0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0)");
                $snlastBYS=DB::table('NewStarfood.dbo.star_pishKharidOrder')->max('SnOrderBYSPishKharid');
                }
        return Response::json(mb_convert_encoding($snlastBYS, "HTML-ENTITIES", "UTF-8"));
    }




 public function updatePreOrderBYSFromHome(Request $request)
    {
        $costAmount=0;
        $amelSn=0;
        $costLimit=0;
        $orderBYSsn=$request->get('orderBYSSn');
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
        $amountUnit=$request->get('amountUnit')*$packAmount;
        $amountBought=$request->get('amountUnit');
        $prices=DB::select("select GoodPriceSale.Price3 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$productId);
        $exactPrice=0;
        foreach ($prices as $price) {
            $exactPrice=$price->Price3;
        }
        $allMoney= $exactPrice * $amountUnit;
        if($amountUnit>0){
        DB::update("UPDATE NewStarfood.dbo.star_pishKharidOrder SET Amount=".$amountUnit.",PackAmount=$amountBought  ,Price=".$allMoney." WHERE SnOrderBYSPishKharid=".$orderBYSsn);
        return Response::json('good');
        }else{
            DB::table("NewStarfood.dbo.star_pishKharidOrder")->where("SnOrderBYSPishKharid",$orderBYSsn)->delete();
            return Response::json('good');
        }

    }


    public function setFavorite(Request $request)
    {
        $goodSn=$request->get('goodSn');
        $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite WHERE customerSn=".Session::get('psn')." AND goodSn=".$goodSn);
        $msg;
        if(count($favorits)>0){
            DB::delete("DELETE FROM NewStarfood.dbo.star_Favorite WHERE customerSn=".Session::get('psn')." AND goodSn=".$goodSn);
        $msg='deleted_'.$goodSn;
        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.star_Favorite(customerSn,goodSn)
            VALUES(".Session::get('psn').",".$goodSn.")") ;
            $msg='added_'.$goodSn;
        }
        return Response::json(mb_convert_encoding($msg, "HTML-ENTITIES", "UTF-8"));
    }

    public function searchKala($name)
    {
        $kalaName=trim(self::changeToArabicLetterAndEngNumber($name));
        $queryPart=" ";
        $queryPart=self::getJustKalaNameQueryPart($name);

        $senQueryPart=" ";

        $senQueryPart=self::getSenonymKalaNameQueryPart($name);

        //without stocks-----------------------------------------------------
        $kalaList=DB::select("SELECT  GoodSn,senonym,GoodName,UName
			,CRM.dbo.getGoodFirstGroupId(GoodSn) AS firstGroupId,CRM.dbo.getGoodSecondGroupId(GoodSn) AS secondGroupId
            ,Price3,Price4,SnGoodPriceSale,IIF(csn>0,'YES','NO') favorite,productId,IIF(ISNULL(productId,0)=0,0,1) as requested
            ,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought
            ,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,secondUnit,freeExistance,activeTakhfifPercent,activePishKharid,IsActive FROM(
            SELECT  PubGoods.GoodSn,NewStarfood.dbo.getProductSenonym(GoodSn) as senonym,PubGoods.GoodName,PUBGoodUnits.UName,csn,D.productId,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
            ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,secondUnit,star_GoodsSaleRestriction.freeExistance
            ,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.activePishKharid,IsActive FROM Shop.dbo.PubGoods
            JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
            JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
            LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount AS BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar 
            JOIN NewStarfood.dbo.orderStar ON FactorStar.SnOrder=orderStar.SnHDS WHERE CustomerSn=".Session::get('psn')." and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
            LEFT JOIN (SELECT goodSn AS csn FROM NewStarfood.dbo.star_Favorite WHERE star_Favorite.customerSn=".Session::get('psn').")C on PubGoods.GoodSn=C.csn
            LEFT JOIN (SELECT productId FROM NewStarfood.dbo.star_requestedProduct WHERE customerId=".Session::get('psn').")D on PubGoods.GoodSn=D.productId
            LEFT JOIN (SELECT zeroExistance,callOnSale,overLine,productId FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
            LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
            LEFT JOIN (SELECT GoodUnitSecond.AmountUnit,SnGood,UName AS secondUnit FROM Shop.dbo.GoodUnitSecond
            JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5)G on G.SnGood=PUbGoods.GoodSn
            WHERE  PubGoods.GoodSn NOT IN(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 )) A WHERE ($queryPart OR $senQueryPart) AND IsActive=1 AND GoodSn IN(SELECT product_id FROM NewStarfood.dbo.star_add_prod_group) order by Amount DESC");   
        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('kala.kalaFromPart',['kala'=>$kalaList,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos, 'kalaName'=>$kalaName]);
    }
    
	// جستجوی عمومی سر صفحه سمت فرانت توسط این متد اجرا می شود.
	public function publicSearch(Request $request){
		
		$name=$request->get("name");
        $customerId=$request->input("psn");
        $kalaName=self::changeToArabicLetterAndEngNumber($name);
        $words=explode(" ",$kalaName);
        $queryPart=" ";
        $counter=count($words);
        if(count($words)>1){
            foreach ($words as $word) {
            $counter-=1;
                if($counter>0){
                    $queryPart.="REPLACE(GoodName,' ', '') LIKE '%$word%' AND ";
                }else{
                    if(strlen($word)>0){
                        $queryPart.="REPLACE(GoodName,' ', '') LIKE '%$word%'";
                    }
                }
                
            }
        }else{
            $queryPart="REPLACE(GoodName,' ', '') LIKE '%$kalaName%'";
        }
		
		$senWords=explode(" ",$kalaName);
        $senQueryPart=" ";
        $senCounter=count($senWords);
        foreach ($senWords as $word) {
        	$senCounter-=1;
            if($senCounter>0){
                $senQueryPart.=" Replace(senonym,' ','') LIKE '%$word%' AND ";
            }else{
                if(strlen($word)>0){
                    $senQueryPart.=" Replace(senonym,' ','') LIKE '%$word%'";
                }
            }
        }
        //without stocks-----------------------------------------------------
        $kalaList=DB::select("SELECT  GoodSn,senonym,GoodName,UName
			,CRM.dbo.getGoodFirstGroupId(GoodSn) AS firstGroupId,CRM.dbo.getGoodSecondGroupId(GoodSn) AS secondGroupId
            ,Price3,Price4,SnGoodPriceSale,IIF(csn>0,'YES','NO') favorite,productId,IIF(ISNULL(productId,0)=0,0,1) as requested
            ,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought
            ,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,secondUnit,freeExistance,activeTakhfifPercent,activePishKharid,IsActive FROM(
            SELECT  PubGoods.GoodSn,NewStarfood.dbo.getProductSenonym(GoodSn) as senonym,PubGoods.GoodName,PUBGoodUnits.UName,csn,D.productId,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
            ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,secondUnit,star_GoodsSaleRestriction.freeExistance
            ,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.activePishKharid,IsActive FROM Shop.dbo.PubGoods
            JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
            JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
            LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount AS BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar 
            JOIN NewStarfood.dbo.orderStar ON FactorStar.SnOrder=orderStar.SnHDS WHERE CustomerSn=$customerId and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
            LEFT JOIN (SELECT goodSn AS csn FROM NewStarfood.dbo.star_Favorite WHERE star_Favorite.customerSn=$customerId)C on PubGoods.GoodSn=C.csn
            LEFT JOIN (SELECT productId FROM NewStarfood.dbo.star_requestedProduct WHERE customerId=$customerId)D on PubGoods.GoodSn=D.productId
            LEFT JOIN (SELECT zeroExistance,callOnSale,overLine,productId FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
            LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
            LEFT JOIN (SELECT GoodUnitSecond.AmountUnit,SnGood,UName AS secondUnit FROM Shop.dbo.GoodUnitSecond
            JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5)G on G.SnGood=PUbGoods.GoodSn
            WHERE  PubGoods.GoodSn NOT IN(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 )) A WHERE ($queryPart) AND IsActive=1 AND GoodSn IN(SELECT product_id FROM NewStarfood.dbo.star_add_prod_group) order by Amount DESC");
		return Response::json($kalaList);
		}

    public function searchKalaBySubGroup(Request $request)
    {
        $subGroupId=$request->get('id');
        $kalas=DB::select("SELECT * from Shop.dbo.PubGoods
                            join NewStarfood.dbo.star_add_prod_group on star_add_prod_group.product_id=PubGoods.GoodSn
                            join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                            join Shop.dbo.Goods_App on PubGoods.GoodSn=Goods_App.SnGood
                            join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                            where star_add_prod_group.secondGroupId=".$subGroupId);
        return Response::json($kalas);
    }
//  توضیحات کالا از قسمت ویرایش کالا انجام می شود.
    public function setDescribeKala(Request $request)
    {
        $kalaId=$request->post('kalaId');
        $discription=$request->post('discription');
		$kalaTags=$request->post('kalaTags');
        $customerId=Session::get("psn");
        $checkDiscription=DB::select("SELECT COUNT(id) as countDiscription from NewStarfood.dbo.star_desc_product where GoodSn=".$kalaId);


        if(count($checkDiscription)>0){
        	DB::update("UPDATE NewStarfood.dbo.star_desc_product 
						SET descProduct='".$discription."',senonym='".$kalaTags."' 
						WHERE GoodSn=".$kalaId);
        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.star_desc_product  VALUES('".$discription."',".$kalaId.")");
        }
        return Response::json("good");
    }

    public function addKalaToGroup(Request $request)
    {
        $addableKalas=$request->post('addedKalaToGroup');
        $removeableKalas=$request->post('removeKalaFromGroup');
        $firstGroupId=$request->post("firstGroupId");
        $secondGroupId=$request->post("secondGroupId");
        if($addableKalas){

            foreach ($addableKalas as $kalaId) {
                if(strlen($kalaId)>3){
                    list($kalaId,$title)=explode('_',$kalaId);
                    DB::insert("INSERT INTO NewStarfood.dbo.star_add_prod_group (firstGroupId, product_id, secondGroupId, thirdGroupId, fourthGroupId)
                    VALUES(".$firstGroupId.",".$kalaId.", ".$secondGroupId.", 0, 0)");
                }
            }
        }
        if($removeableKalas){
            //delete data from Group
            foreach ($removeableKalas as $kalaId) {
                if(strlen($kalaId)>3){
                list($kalaId,$title)=explode('_',$kalaId);
                DB::delete("DELETE FROM NewStarfood.dbo.star_add_prod_group WHERE product_id=".$kalaId);
                }
            }
        }
        
        $kalas=DB::select("select Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_id
        where star_add_prod_group.secondGroupId=".$secondGroupId." and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and CompanyNo=5");

        $allkalas=DB::select("SELECT Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods 
        where companyNo=5 and not exists (select * from NewStarfood.dbo.star_add_prod_group where star_add_prod_group.product_id=GoodSn and
         star_add_prod_group.secondGroupId=$secondGroupId) and CompanyNo=5 and GoodName !=''"
        );

        return Response::json(['kalas'=>$kalas,'allkalas'=>$allkalas]);
    }
    public function getSubGroupKala(Request $request)
    {
        $subGroupId=$request->get('id');
        $kalas=DB::select("select Shop.dbo.PubGoods.GoodName,Shop.dbo.PubGoods.GoodSn from Shop.dbo.PubGoods join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_id
        where star_add_prod_group.secondGroupId=".$subGroupId." and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and CompanyNo=5");
        return Response::json($kalas);
    }
    public function getAllKalas(Request $request)
    {
        $mainKalaId=$request->post("mainKalaId");
        $allKalas=DB::select("SELECT * FROM Shop.dbo.PubGoods WHERE GoodName!='' and GoodSn!=0 and GoodSn not in( Select mainId from NewStarfood.dbo.star_assameKala join Shop.dbo.PubGoods on PubGoods.GoodSn=star_assameKala.assameId)");
        return Response::json($allKalas);
    }
    public function getPreBuyAbles(Request $request)
    {
        $allKalas=DB::table("Shop.dbo.PubGoods")->JOIN("NewStarfood.dbo.star_GoodsSaleRestriction","productId","=","GoodSn")->where("activePishKharid",1)->select("GoodSn","GoodName")->get();
        return Response::json($allKalas);
    }
    public function searchPreBuyAbleKalas(Request $request)
    {
        $searchTerm=$request->get("searchTerm");
        $allKalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn From Shop.dbo.PubGoods join NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=star_GoodsSaleRestriction.productId where PubGoods.GoodName like '%".$searchTerm."%' and star_GoodsSaleRestriction.activePishKharid=1");
        return Response::json($allKalas);
    }



    public function addOrDeleteAssame(Request $request){
        $mainKalaId=$request->get("mainKalaId");
        $addableKalas=$request->get('addedKalaToList');
        $removeableKalas=$request->get('removeKalaFromList');

        if($addableKalas){
            foreach ($addableKalas as $kalaId) {
                list($kalaId,$title)=explode('_',$kalaId);
                DB::insert("INSERT INTO NewStarfood.dbo.star_assameKala (mainId, assameId)
                VALUES(".$mainKalaId.",".$kalaId.")");
            }
        }

       if($removeableKalas){

           foreach ($removeableKalas as $kalaId) {
             if($kalaId !="on"){
              list($id,$title)=explode('_',$kalaId);
             DB::delete("DELETE FROM NewStarfood.dbo.star_assameKala WHERE assameId=".$id." and mainId=".$mainKalaId);
                }
            }
        }
        return Response::json($removeableKalas);

    }

    public function addStockToList(Request $request){
        $kalaId=$request->post("kalaId");
        $stockIds=$request->post("addedStockToList");
        $removableStocks=$request->post("removeStockFromList");
        if($stockIds){
            foreach ($stockIds as $stockId) {
                DB::insert("INSERT INTO NewStarfood.dbo.star_addedStock (productId, stockId)
                VALUES(".$kalaId.",".$stockId.")");
            }
        }
        if($removableStocks){
            foreach ($removableStocks as $stockId) {
                DB::delete("DELETE from NewStarfood.dbo.star_addedStock where stockId=".$stockId);
            }
        }
        return Response::json('good');
    }


    public function addOrDeleteKalaFromSubGroup(Request $request)
    {
        $addbles=$request->get("addables");
        $kalaId=$request->get("ProductId");
        $x=0;
        $removables=$request->get('removables');
        if($addbles){
            foreach ($addbles as $addble) {
                list($subGroupId,$firstGroupId)=explode('_',$addble);
                $exitsanceResult=DB::table("NewStarfood.dbo.star_add_prod_group")
                ->where('firstGroupId',$firstGroupId)
                ->where('secondGroupId',$subGroupId)->where('product_id',$kalaId)->get();
                if(count($exitsanceResult)<1){
                    $x=1;
                    DB::table("NewStarfood.dbo.star_add_prod_group")
                    ->insert(['firstGroupId'=>$firstGroupId,'product_id'=>$kalaId,
                    'secondGroupId'=>$subGroupId,'thirdGroupId'=>0,'fourthGroupId'=>0]);
                }

            }
        }

        if($removables){
            foreach ($removables as $removable) {
            list($subGroupId,$firstGroupId)=explode('_',$removable);
            $exitsanceResult=DB::table("NewStarfood.dbo.star_add_prod_group")
                ->where('firstGroupId',$firstGroupId)
                ->where('secondGroupId',$subGroupId)->where('product_id',$kalaId)->get();
                if(count($exitsanceResult)>0){
                    $x=2;
                    DB::table("NewStarfood.dbo.star_add_prod_group")->where("secondGroupId",$subGroupId)->where('product_id',$kalaId)->delete();
                }

        }
    }
     return Response::json($kalaId);
    }

	// صفحه فست کالا را بر میگرداند
    public function getKalaWithPic($id)
    {
        $subGroupId=$id;
        $listKala=DB::select("SELECT * FROM Shop.dbo.PubGoods join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_Id where star_add_prod_group.secondGroupId=".$subGroupId);
        return view("kala.changeKalaPic",['listKala'=>$listKala]);
    }

    public function getGoodPictureState(Request $request)
    {
        $respond="deleted";
        $goodSn=$request->get('goodSn');
        if(file_exists('resources/assets/images/kala/' . $goodSn . '_1.jpg')){
            unlink('resources/assets/images/kala/' . $goodSn . '_1.jpg');
            $respond="deleted";
        }else{
            $respond="notExist";
        }
        return response()->json($respond);
    }
    public function changePriceKala(Request $request)
    {
        $kalaId=$request->get("kalaId");
        $kalaPrice=DB::table("Shop.dbo.GoodPriceSale")->where('SnGood',$kalaId)->where("CompanyNo",5)->where('FiscalYear',1402)->select("*")->get();
        $changedFirstPrice=str_replace(",", "",$request->get("firstPrice"));
        $changedSecondPrice=str_replace(",", "",$request->get("secondPrice"));


        foreach ($kalaPrice as $price) {
            $firstPrice=$price->Price4;
            $secondPrice=$price->Price3;
        }
        DB::table("NewStarfood.dbo.star_KalaPriceHistory")->insert(
        ['userId'=>Session::get('adminId'),'application'=>'starfood','firstPrice'=>($firstPrice/1),'changedFirstPrice'=>($changedFirstPrice/1),
        'secondPrice'=>($secondPrice/1),'changedSecondPrice'=>($changedSecondPrice/1),'productId'=>$kalaId]);


        DB::update("UPDATE Shop.dbo.GoodPriceSale set Price4=".$changedFirstPrice.", Price3=".$changedSecondPrice." where SnGood=".$kalaId." and CompanyNo=5 and FiscalYear=".Session::get("FiscallYear")."");
        return Response::json(1);
    }
	
    public function getKalaBySubGroups(Request $request)
    {
        $subGrId=$request->get("subGrId");
        $firstGrId=$request->get("firstGrId");
        $kalas;
        if($subGrId==0 and $firstGrId>0){

            $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,ViewGoodExists.Amount,
                            GoodCde,GoodGroups.NameGRP,PubGoods.GoodGroupSn from Shop.dbo.PubGoods
                            join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                            join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                            join Shop.dbo.ViewGoodExists on ViewGoodExists.SnGood=PubGoods.GoodSn
                            join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_Id
                            where GoodName!='' and NameGRP!='' and GoodSn!=0 and PubGoods.GoodGroupSn >49 and
                            star_add_prod_group.firstGroupId=".$firstGrId);
            foreach ($kalas as $kala) {

                $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;
    
            }
        }
        elseif($subGrId==0 and $firstGrId==0){

            $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,ViewGoodExists.Amount,
                            GoodCde,GoodGroups.NameGRP,PubGoods.GoodGroupSn from Shop.dbo.PubGoods
                            JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                            JOIN Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                            JOIN Shop.dbo.ViewGoodExists on ViewGoodExists.SnGood=PubGoods.GoodSn
                            JOIN NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_Id
                            where GoodName!='' and NameGRP!='' and GoodSn!=0 and PubGoods.GoodGroupSn >49 ");

            foreach ($kalas as $kala) {

                $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;

            }

        }elseif($subGrId>0 and $firstGrId==0){

            $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,ViewGoodExists.Amount,
                            GoodCde,GoodGroups.NameGRP,PubGoods.GoodGroupSn from Shop.dbo.PubGoods
                            JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                            JOIN Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                            JOIN Shop.dbo.ViewGoodExists on ViewGoodExists.SnGood=PubGoods.GoodSn
                            JOIN NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_Id
                            where GoodName!='' and NameGRP!='' and GoodSn!=0 and PubGoods.GoodGroupSn >49 and
                            star_add_prod_group.secondGroupId=".$subGrId);

            foreach ($kalas as $kala) {

                $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;

            }

        }else{

            $kalas=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,ViewGoodExists.Amount,
                            GoodCde,GoodGroups.NameGRP,PubGoods.GoodGroupSn from Shop.dbo.PubGoods
                            join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                            join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                            join Shop.dbo.ViewGoodExists on ViewGoodExists.SnGood=PubGoods.GoodSn
                            join NewStarfood.dbo.star_add_prod_group on PubGoods.GoodSn=star_add_prod_group.product_Id
                            where GoodName!='' and NameGRP!='' and GoodSn!=0 and PubGoods.GoodGroupSn >49 and
                            star_add_prod_group.secondGroupId=".$subGrId);
            
            foreach ($kalas as $kala) {

                $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;
    
            }
        }
        return Response::json($kalas);
    }


    public function getKalaBybrandItem($code)
    {
        $brandId=$code;
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        $activePishKharid=0;
        //without stock -------------------------------------------------------------------
        $kalaList=DB::select("SELECT NewStarfood.dbo.star_brandItems.*,GoodSn,PubGoods.GoodName,S.Price4,S.Price3,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,NewStarfood.dbo.getFirstUnit(GoodSn) as firstUnit,NewStarfood.dbo.getProductExistance(GoodSn) as Amount,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.freeExistance,firstGroupId
        FROM NewStarfood.dbo.star_brandItems
        JOIN Shop.dbo.PubGoods on star_brandItems.productId=PubGoods.GoodSn
        JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
        JOIN (select min(firstGroupId) as firstGroupId,product_id from  NewStarfood.dbo.star_add_prod_group group by product_id) a on a.product_id=GoodSn
        LEFT JOIN (Select GoodPriceSale.Price4,GoodPriceSale.Price3,GoodPriceSale.SnGood from Shop.dbo.GoodPriceSale) S on S.SnGood=NewStarfood.dbo.star_brandItems.productId
        where NewStarfood.dbo.star_brandItems.brandId=$brandId and star_brandItems.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) order by Amount desc");

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        foreach ($kalaList as $kala) {
            $overLine=0;
            $callOnSale=0;
            $zeroExistance=0;
            $exist="NO";
            $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");
            foreach ( $favorits as $favorite) {
                if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==Session::get('psn')){
                    $exist='YES';
                    break;
                }else{
                    $exist='NO';
                }
            }
            
            $kala->requested=self::getKalaRequestState(Session::get('psn'),$kala->GoodSn);

            $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance",'activePishKharid')->get();
            if(count($restrictionState)>0){
                foreach($restrictionState as $rest){
                    if($rest->overLine==1){
                        $overLine=1;
                    }
                    if($rest->callOnSale==1){
                        $callOnSale=1;
                    }
                    if($rest->zeroExistance==1){
                        $zeroExistance=1;
                    }
                    if($rest->activePishKharid==1){
                        $activePishKharid=1;
                    }
                }
            }
            $boughtKalas=DB::select("select  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            foreach ($boughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYS;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;
                $secondUnits=DB::select("select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$orderGoodSn);
                foreach ($secondUnits as $unit) {
                    $secondUnit=$unit->UName;
                }
            }
            if(count($boughtKalas)>0){
                $kala->bought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
            }else{
                $kala->bought="No";
            }
            $kala->favorite=$exist;
            $kala->overLine=$overLine;
            $kala->callOnSale=$callOnSale;
            $kala->activePishKharid=$activePishKharid;
            if($zeroExistance==1){
            $kala->Amount=0;
            }
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
            return view('kala.kalaFromPart',['kala'=>$kalaList,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    public function filterAllKala(Request $request)
    {
        $kalaNameCode= $request->get("kalaNameCode");
        $mainGroup  = $request->get("mainGroup");
        $subGroup  = $request->get("subGroup");
        $searchKalaStock  = $request->get("searchKalaStock");
        $searchKalaActiveOrNot  = $request->get("searchKalaActiveOrNot");
        $searchKalaExistInStock  = $request->get("searchKalaExistInStock");
        $assesFirstDate  = $request->get("assesFirstDate");
        $assesSecondDate='1490/01/01';
        if(strlen($request->get("assesSecondDate"))>3){
        $assesSecondDate  = $request->get("assesSecondDate");
        }
        $existanceQuery="";
        if($searchKalaExistInStock==1){
            $existanceQuery=">=1";
        }
        if($searchKalaExistInStock==0){
            $existanceQuery="=0";
        }

        if($searchKalaExistInStock==-1){
            $existanceQuery=">=-2000";
        }



        $listKala=DB::select("SELECT * FROM(
            SELECT PubGoods.GoodName,PubGoods.GoodSn,CRM.dbo.getGoodPrice(GoodSn,'Price3') AS Price3,
            CRM.dbo.getGoodPrice(GoodSn,'Price4') AS Price4,CRM.dbo.getGoodExistance(GoodSn,1402,$searchKalaStock) AS Amount
            ,GoodCde,PubGoods.GoodGroupSn,PubGoods.CompanyNo,
            FORMAT(CONVERT(DATE,CRM.dbo.getLastDateGoodSale(GoodSn)),'yyyy/MM/dd','fa-IR') AS lastDate,
            CRM.dbo.getGoodHiddenState(GoodSn) AS hideKala,CRM.dbo.getGoodMainGroupStarfood(GoodSn) AS firstGroupName,CRM.dbo.getGoodSubGroupStarfood(GoodSn) AS secondGroupName,IsActive FROM Shop.dbo.PubGoods 
            )a
            WHERE GoodName!='' AND a.GoodSn!=0 AND GoodGroupSn >49 AND CompanyNo=5 AND (GoodName LIKE '%$kalaNameCode%' OR GoodCde LIKE '%$kalaNameCode%')
            AND lastDate >='$assesFirstDate' AND lastDate <='$assesSecondDate' AND hideKala LIKE '%$searchKalaActiveOrNot%' AND Amount $existanceQuery AND firstGroupName LIKE N'%$mainGroup%' AND secondGroupName LIKE N'%$subGroup%' AND IsActive=1
            ORDER BY Amount desc");
        return Response::json($listKala);
    }


    public function tempRoute(Request $request)
    {
        // $restrictions=DB::select('SELECT * FROM star_customerRestriction');
        // foreach ($restrictions as $rest) {
        //     $introCode='AB'.$rest->customerId.''.$rest->customerId;
        //     DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set selfIntroCode = '$introCode' where customerId = $rest->customerId");
        // }
        // return 'good';
        //----------------PICS--------------------------
        $pics=DB::select("SELECT COUNT(productId) as countProduct,partPic from NewStarfood.dbo.star_add_homePart_stuff where partPic is not null  group by partPic");
        foreach ($pics as $pic) {
            $onePics=DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$pic->partPic);
            $i=0;
            foreach ($onePics as $pic) {
                $i+=1;
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority=".$i." where productId=".$pic->productId." and partPic=".$pic->partPic);
            }
        }
        //----------------PARTS------------------------
        $parts=DB::select("SELECT COUNT(productId) as countProduct,homepartId from NewStarfood.dbo.star_add_homePart_stuff where homepartId is not null and productId is not null  group by homepartId");
            foreach ($parts as $pic) {
            $onePart=DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$pic->homepartId);
            $i=0;
            foreach ($onePart as $part) {
                $i+=1;
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority=".$i." where productId=".$part->productId." and homepartId=".$pic->homepartId);
            }
        }
        //----------------BRANDS----------------------
        $parts=DB::select("SELECT COUNT(productId) as countProduct,homepartId from NewStarfood.dbo.star_add_homePart_stuff where homepartId is not null and brandId is not null  group by homepartId");
            foreach ($parts as $pic) {
            $oneBrand=DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$pic->homepartId);
            $i=0;
            foreach ($oneBrand as $part) {
                $i+=1;
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority=".$i." where brandId=".$part->brandId." and homepartId=".$part->homepartId);
            }
        }
        //----------------GROUPS----------------------
        $parts=DB::select("SELECT COUNT(firstGroupId) as countGroup,homepartId from NewStarfood.dbo.star_add_homePart_stuff where homepartId is not null and firstGroupId is not null  group by homepartId");
        foreach ($parts as $pic) {
            $onePart=DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$pic->homepartId);
            $i=0;
            foreach ($onePart as $part) {
                $i+=1;
                DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority=".$i." where firstGroupId=".$part->firstGroupId." and homepartId=".$part->homepartId);
            }
        }
        return 1;
    }

    function addRequestedProduct(Request $request){
        $customerId=$request->get("customerId");
        $productId=$request->get("productId");
        $isRequested=DB::table("NewStarfood.dbo.star_requestedProduct")->where("customerId",$customerId)->where("productId",$productId)->get();
        if(count($isRequested) < 1){
            DB::table("NewStarfood.dbo.star_requestedProduct")->insert(["customerId"=>$customerId,"productId"=>$productId,'acceptance'=>0]);
        }
        return Response::json(1);
    }



    public function displayRequestedKala(Request $request)
    {
        $gsn=$request->get('productId');
        $products=DB::select("SELECT DISTINCT star_requestedProduct.customerId,star_requestedProduct.acceptance,Peopels.PSN,Peopels.Name,
                            a.PhoneStr,Peopels.PCode,Peopels.peopeladdress,GoodName,FORMAT(convert( date,star_requestedProduct.TimeStamp),'yyyy/MM/dd','fa-ir') as TimeStamp
                            FROM NewStarfood.dbo.star_requestedProduct join Shop.dbo.Peopels on Peopels.PSN=star_requestedProduct.customerId 
                            join (SELECT SnPeopel, STRING_AGG(PhoneStr, '-') AS PhoneStr
							FROM Shop.dbo.PhoneDetail
							GROUP BY SnPeopel)a on star_requestedProduct.customerId=a.SnPeopel
							join (select GoodName,GoodSn from Shop.dbo.PubGoods where CompanyNo=5)c on c.GoodSn=productId
                            where star_requestedProduct.acceptance=0 and ProductId=".$gsn);
        return Response::json($products);
    }

    public function cancelRequestedProduct(Request $request)
    {
        $psn=$request->get("psn");
        $gsn=$request->get("gsn");
        $deleted=DB::delete("DELETE FROM NewStarfood.dbo.star_requestedProduct WHERE productId=".$gsn." and customerId=".$psn);
        if($deleted){
            return Response::json(mb_convert_encoding($deleted, "HTML-ENTITIES", "UTF-8"));
        }else{
            return Response::json(mb_convert_encoding($deleted, "HTML-ENTITIES", "UTF-8"));
        }
    }

    public function removeRequestedKala(Request $request)
    {
        
        $gsn=$request->get('productId');
        
        $deleted=DB::delete("DELETE FROM NewStarfood.dbo.star_requestedProduct WHERE productId=".$gsn);
        
        $requests=DB::select("SELECT * FROM(
            SELECT countRequest,a.productId,GoodName,GoodSn,TimeStamp FROM(SELECT COUNT(star_requestedProduct.id) AS countRequest,min(TimeStamp) as TimeStamp,productId  
            FROM NewStarfood.dbo.star_requestedProduct group by productId)a
            JOIN Shop.dbo.PubGoods ON PubGoods.GoodSn=a.productId )b  order by TimeStamp desc");
        
        return Response::json($requests);    
}
public function searchRequestedKala(Request $request)
{
    $searchTerm=$request->get("searchTerm");
    $requests=DB::select("SELECT * FROM(
        SELECT countRequest,a.productId,GoodName,GoodSn,TimeStamp FROM(SELECT COUNT(star_requestedProduct.id) AS countRequest,min(TimeStamp) as TimeStamp,productId  
        FROM NewStarfood.dbo.star_requestedProduct group by productId)a
        JOIN Shop.dbo.PubGoods ON PubGoods.GoodSn=a.productId )b 
        WHERE b.GoodName LIKE '%".$searchTerm."%'  order by TimeStamp desc");
    return Response::json($requests);
}


public function getTenLastSales(Request $request){
    $kalaId=$request->get("kalaId");
    $lastTenSales=DB::select("SELECT * FROM (
                            SELECT * FROM (
                            SELECT TOP 10 SnGood,Amount,PackType,Fi,Price,SnFact FROM Shop.dbo.FactorBYS WHERE SnGood=".$kalaId." order by FactorBYS.TimeStamp desc)a
                            JOIN (SELECT SerialNoHDS,CustomerSn,FactDate FROM Shop.dbo.FactorHDS)b on a.SnFact=b.SerialNoHDS)c
                            JOIN (SELECT Name,PCode,PSN FROM Shop.dbo.Peopels )d on c.CustomerSn=d.PSN");
    $productInfo=DB::select("SELECT GoodName,GoodSn FROM Shop.dbo.PubGoods WHERE GoodSn=$kalaId");
    return Response::json([$lastTenSales,$productInfo]);
}

public function getSubGroupKalaForFront(Request $request){
    $subGroupKalaId=$request->get('subKalaGroupId');
    $mainGrId=$request->get('mainGrId');

     $listKala= DB::select("SELECT secondGroupId,firstGroupId,CompanyNo,GoodSn,GoodName,
	 NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,".Session::get('psn')." as CustomerSn,
	 IIF(NewStarfood.dbo.isFavoritOrNot(".Session::get('psn').",GoodSn)>0,'YES','NO') AS favorite
	 ,IIF(NewStarfood.dbo.isRequestedOrNot(".Session::get('psn').",GoodSn)=0,0,1) as requested,
	 IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,
	 SnOrderBYS,BoughtAmount,PackAmount,overLine,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid,IsActive FROM(
        SELECT firstGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
        ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,secondGroupId,IsActive FROM Shop.dbo.PubGoods
        INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
        INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
        INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
        LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
        LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
        LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
        ) A WHERE firstGroupId=$mainGrId AND IsActive=1 AND secondGroupId=$subGroupKalaId and CompanyNo=5 and not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 and productId=GoodSn ) ORDER BY Amount DESC");  
	foreach($listKala as $kala){
	if(file_exists('resources/assets/images/kala/' . $kala->GoodSn . '_1.jpg')){
		$kala->hasPicture=1;
	}else{
		$kala->hasPicture=0;	
	}
	}
    $currency=1;

    $currencyName="ریال";

    $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
    
    $currency=$currencyExistance[0]->currency;

    if($currency==10){
        $currencyName="تومان";
    }
    $listSubGroups=DB::select('SELECT * FROM NewStarfood.dbo.star_group where selfGroupId='.$mainGrId.'order by subGroupPriority desc');
    $logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;

    return Response::json(['listKala'=>$listKala,'listGroups'=>$listSubGroups
						   ,'subGroupId'=>$subGroupKalaId,'mainGrId'=>$mainGrId,'currency'=>$currency
						   ,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
}


public function deleteCustomerRequest(Request $request){
    $psn=$request->get("psn");
    $gsn=$request->get("gsn");
    DB::delete("DELETE FROM NewStarfood.dbo.star_requestedProduct where productId=$gsn and customerId=$psn");
   return Response::json($gsn);
}

public function getRequestedKalaByCustomer(Request $request)
{
    $customerId=$request->get("psn");
    $products=DB::select("SELECT PCode,Name,PSN,GoodSn,GoodName,star_requestedProduct.TimeStamp,GoodCde FROM NewStarfood.dbo.star_requestedProduct JOIN Shop.dbo.PubGoods on productId=GoodSn JOIN Shop.dbo.Peopels on PSN=customerId where customerId=$customerId");
    return Response::json(['products'=>$products]);
}
	
public function getKalaRequestState($customerId,$goodSn){
	$requested=0;
    $isRequested = DB::table('NewStarfood.dbo.star_requestedProduct')->where('acceptance',0)->where('customerId',$customerId)->where('productId',$goodSn)->first();
    if($isRequested){
        $requested=1;
    }
	return $requested;
}
	
public function changeToArabicLetterAndEngNumber($str){
	$dictionary = [
		'ی' => 'ي', 'ک' => 'ک', 'ە' => 'ه', 'ێ' => 'ي', 'ھ' => 'ه',
		'ۆ' => 'و', 'ۇ' => 'و', 'ۈ' => 'و', 'ۋ' => 'و', 'ې' => 'ي',
		'ۊ' => 'و', 'ؤ' => '',  'أ' => '',  'إ' => '',  'ئ' => '',
		'۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
		'۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9'
	];
	$string = strtr($str, $dictionary);

	return $string;
}

public function appendSubGroupKalaApi(Request $request){
    $subGroupKalaId=$request->get('subKalaGroupId');
    $mainGrId=$request->get('mainGrId');
    $customerSn=$request->get('psn');

     $listKala= DB::select("SELECT secondGroupId,firstGroupId,FiscalYear,CompanyNo,GoodSn,GoodName,NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,IIF(NewStarfood.dbo.isFavoritOrNot($customerSn,GoodSn)>0,'YES','NO') AS favorite,IIF(NewStarfood.dbo.isRequestedOrNot($customerSn,GoodSn)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid FROM(
        SELECT firstGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale,GoodPriceSale.FiscalYear
        ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,secondGroupId FROM Shop.dbo.PubGoods
        INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
        INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
        INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
        LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerSn and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
        LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
        LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
        ) A WHERE FiscalYear=1402 AND firstGroupId=$mainGrId AND secondGroupId=$subGroupKalaId and CompanyNo=5 and not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 and productId=GoodSn ) ORDER BY Amount DESC");  
    $currency=1;

    $currencyName="ریال";

    $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
    
        $currency=$currencyExistance[0]->currency;

    if($currency==10){
        $currencyName="تومان";
    }
    $listSubGroups=DB::select('SELECT * FROM NewStarfood.dbo.star_group where selfGroupId='.$mainGrId.'order by subGroupPriority desc');
    $logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;

    return Response::json(['listKala'=>$listKala,'listGroups'=>$listSubGroups,'subGroupId'=>$subGroupKalaId,'mainGrId'=>$mainGrId,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
}

public function buySomethingApi(Request $request) {
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
    $prices=DB::select("select GoodPriceSale.Price3,GoodPriceSale.Price4 from Shop.dbo.GoodPriceSale where GoodPriceSale.SnGood=".$kalaId." AND FiscalYear=1402");
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
    $customerId=$request->get('psn');;
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
        VALUES(5,".$factorNo.",'".$todayDate."',".$customerId.",'',0,'','','1402',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
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

            VALUES(5,".$maxOrder.",'".$todayDate."',".$customerId.",'',0,'','','1402',".(DB::raw('CURRENT_TIMESTAMP')).",0,0,3,'','',0,'','',0,0,0,0,0,'','','".$todayDate."','',0,0,0,'',0,'',0,0,0,0,0,0,'','',0,0,0,0,0,'','')");
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
                'SnAmel'=>$amelSn,'Price'=>$costLimit,'FiscalYear'=>1402,'DescItem'=>"",'IsExport'=>1]);
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
            'SnAmel'=>$amelSn,'Price'=>$costAmount,'FiscalYear'=>1402,'DescItem'=>"",'IsExport'=>0]);
        }
        $buys=Session::get('buy');
        Session::put('buy',$buys+1);

        }
    return Response::json(mb_convert_encoding($snlastBYS, "HTML-ENTITIES", "UTF-8"));
}

    public function setFavoriteApi(Request $request){
        $goodSn=$request->get('goodSn');
        $customerId=$request->get('psn');
        $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite WHERE customerSn=$customerId AND goodSn=".$goodSn);
        $msg;
        if(count($favorits)>0){
            DB::delete("DELETE FROM NewStarfood.dbo.star_Favorite WHERE customerSn=$customerId AND goodSn=".$goodSn);
        $msg=0;
        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.star_Favorite(customerSn,goodSn)
            VALUES($customerId,".$goodSn.")") ;
            $msg=1;
        }
        return Response::json(['msg'=>$msg]);
    }

    public function favoritKalaApi(Request $request){
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        $customerSn=$request->get('psn');
        //without stocks----------------------------------------
        $listKala= DB::select("SELECT DISTINCT PubGoods.GoodSn,PubGoods.GoodName,GoodGroups.GoodGroupSn,GoodPriceSale.Price3,GoodPriceSale.Price4,PUBGoodUnits.UName as UNAME,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.freeExistance,Amount,activePishKharid from Shop.dbo.PubGoods
                                JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                JOIN Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN
                                JOIN NewStarfood.dbo.star_Favorite on PubGoods.GoodSn=star_Favorite.GoodSn
                                JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=1402) A on PubGoods.GoodSn=A.SnGood
                                left JOIN Shop.dbo.GoodPriceSale on GoodPriceSale.SnGood=PubGoods.GoodSn  where customerSn=$customerSn and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) order by Amount desc");


        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        foreach ($listKala as $kala) {
            if($kala->activePishKharid<1){
                $overLine=0;
                $callOnSale=0;
                $zeroExistance=0;
                $exist="NO";
                $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");
                foreach ( $favorits as $favorite) {
                    if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==$customerSn){
                        $exist=1;
                        break;
                    }else{
                        $exist=0;
                    }
                }
                $requested=0;
                $user = DB::table('NewStarfood.dbo.star_requestedProduct')->where('acceptance',0)->where('customerId',$customerSn)->where('productId',$kala->GoodSn)->first();
                if($user){
                    $requested=1;
                }
                $kala->requested=$requested;
                $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
                if(count($restrictionState)>0){
                    foreach($restrictionState as $rest){
                        if($rest->overLine==1){
                            $overLine=1;
                        }else{
                            $overLine=0;
                        }
                        if($rest->callOnSale==1){
                            $callOnSale=1;
                        }else{
                            $callOnSale=0;
                        }
                        if($rest->zeroExistance==1){
                            $zeroExistance=1;
                        }else{
                            $zeroExistance=0;
                        }
                    }
                }
                $boughtKalas=DB::select("SELECT FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerSn and SnGood=".$kala->GoodSn." and  orderStatus=0");
                $orderBYSsn;
                $secondUnit;
                $amount;
                $packAmount;
                foreach ($boughtKalas as $boughtKala) {
                    $orderBYSsn=$boughtKala->SnOrderBYS;
                    $orderGoodSn=$boughtKala->SnGood;
                    $amount=$boughtKala->Amount;
                    $packAmount=$boughtKala->PackAmount;
                    $secondUnits=DB::select('SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                                            JOIN Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                                            JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn
                                            );
                    if(count($secondUnits)>0){
                        foreach ($secondUnits as $unit) {
                            $secondUnit=$unit->UName;
                        }
                    }else{
                        $secondUnit=$kala->UName;
                    }
                }
                if(count($boughtKalas)>0){
                    $kala->bought="Yes";
                    $kala->SnOrderBYS=$orderBYSsn;
                    $kala->secondUnit=$secondUnit;
                    $kala->Amount=$amount;
                    $kala->PackAmount=$packAmount;
                }else{
                    $kala->bought="No";
                }
                $kala->favorite=$exist;
                $kala->overLine=$overLine;
                $kala->callOnSale=$callOnSale;
                if($zeroExistance==1){
                $kala->Amount=0;
                }
            }else{

                $overLine=0;
                $callOnSale=0;
                $zeroExistance=0;
                $exist="NO";
                $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");
                foreach ( $favorits as $favorite) {
                    if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==$customerSn){
                        $exist='YES';
                        break;
                    }else{
                        $exist='NO';
                    }
                }
                $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
                if(count($restrictionState)>0){
                    foreach($restrictionState as $rest){
                        if($rest->overLine==1){
                            $overLine=1;
                        }else{
                            $overLine=0;
                        }
                        if($rest->callOnSale==1){
                            $callOnSale=1;
                        }else{
                            $callOnSale=0;
                        }
                        if($rest->zeroExistance==1){
                            $zeroExistance=1;
                        }else{
                            $zeroExistance=0;
                        }
                    }
                }
                $boughtKalas=DB::select("SELECT  star_pishKharidFactor.*,star_pishKharidOrder.* from NewStarfood.dbo.star_pishKharidFactor join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=star_pishKharidOrder.SnHDS where CustomerSn=$customerSn and SnGood=".$kala->GoodSn." and  orderStatus=0");
                $orderBYSsn;
                $secondUnit;
                $amount;
                $packAmount;
                foreach ($boughtKalas as $boughtKala) {
                    $orderBYSsn=$boughtKala->SnOrderBYSPishKharid;
                    $orderGoodSn=$boughtKala->SnGood;
                    $amount=$boughtKala->Amount;
                    $packAmount=$boughtKala->PackAmount;
                    $secondUnits=DB::select('SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName FROM Shop.dbo.PubGoods
                                        JOIN Shop.dbo.GoodUnitSecond ON PubGoods.GoodSn=GoodUnitSecond.SnGood
                                        JOIN Shop.dbo.PUBGoodUnits ON PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn);
                    if(count($secondUnits)>0){
                            $secondUnit=$secondUnits[0]->UName;
                    }else{
                        $secondUnit=$kala->UName;
                    }
                }
                if(count($boughtKalas)>0){
                    $kala->bought="Yes";
                    $kala->SnOrderBYS=$orderBYSsn;
                    $kala->secondUnit=$secondUnit;
                    $kala->Amount=$amount;
                    $kala->PackAmount=$packAmount;
                }else{
                    $kala->bought="No";
                }
                $kala->favorite=$exist;
                $kala->overLine=$overLine;
                $kala->callOnSale=$callOnSale;
                if($zeroExistance==1){
                $kala->Amount=0;
                }
            }
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return Response::json(['favorits'=>$listKala,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    public function descKalaApi(Request $request)
    {
        $customerSn=$request->get("psn");
        $groupId=$request->get("groupId");
        $productId=$request->get("id");
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        // برای ثبت دیدن مشتری از کالا 
        $customerId=$customerSn;
        $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
        $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
        if($lastReferesh>=0 or count($logedIns)<1){
             $palatform=BrowserDetect::platformFamily();
             $browser=BrowserDetect::browserFamily();
            if(count($logedIns)<1){
                 DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'productId'=>''.$productId.'']);
            }elseif($lastReferesh>0){
                 DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'productId'=>''.$productId.'']);
            }else{
                $lastLoginId=DB::select("SELECT MAX(id)lastLoginId FROM NewStarfood.dbo.star_customerTrack WHERE customerId=$customerId");

                if(count($lastLoginId)>0){
                    $lastLoginId=$lastLoginId[0]->lastLoginId;
                    $lastVisitedProductIds=DB::select("SELECT productId FROM NewStarfood.dbo.star_customerTrack WHERE id=$lastLoginId");
                    $productIds;
                    if(count($lastVisitedProductIds)>0){
                        $productIds = explode("_",$lastVisitedProductIds[0]->productId);
                    }

                    if(!in_array($productId,$productIds)){
                        DB::update("UPDATE NewStarfood.dbo.star_customerTrack SET productId+='_$productId' WHERE customerId=$customerId and id=$lastLoginId");
                    }
                }
            }
        }

        //
        //without stocks----------------------------------------
        $listKala=DB::select("SELECT  GoodGroups.NameGRP,PubGoods.GoodCde,GoodPriceSale.FiscalYear,PubGoods.GoodSn,PubGoods.GoodName,GoodPriceSale.Price3,GoodPriceSale.Price4,PUBGoodUnits.UName as UNAME,A.Amount as AmountExist,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activePishKharid  from Shop.dbo.PubGoods
                                JOIN Shop.dbo.GoodGroups on GoodGroups.GoodGroupSn=PubGoods.GoodGroupSn
                                LEFT JOIN Shop.dbo.GoodPriceSale on GoodPriceSale.SnGood=PubGoods.GoodSn
                                LEFT JOIN Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN
                                LEFT JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=1402) A on PubGoods.GoodSn=A.SnGood
                                LEFT JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                WHERE PubGoods.GoodSn=".$productId." and PubGoods.GoodGroupSn>49 AND GoodPriceSale.FiscalYear=1402");

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }

        foreach ($listKala as $kala) {
            $exist="NO";
            $overLine=0;
            $callOnSale=0;
            $zeroExistance=0;
            $discriptKala="توضیحاتی ندارد";
            $discription=DB::select("SELECT descProduct FROM NewStarfood.dbo.star_desc_Product where GoodSn=".$kala->GoodSn);
            foreach ($discription as $disc) {
                $discriptKala=$disc->descProduct;
            }
            $requested=0;
            $user = DB::table('NewStarfood.dbo.star_requestedProduct')->where('acceptance',0)->where('customerId',$customerSn)->where('productId',$kala->GoodSn)->first();
            if($user){
                $requested=1;
            }
            $kala->requested=$requested;
            $restrictionState=DB::table("NewStarfood.dbo.star_GoodsSaleRestriction")->where("productId",$kala->GoodSn)->select("overLine","callOnSale","zeroExistance")->get();
            if(count($restrictionState)>0){
                foreach($restrictionState as $rest){
                    if($rest->overLine==1){
                        $overLine=1;
                    }else{
                        $overLine=0;
                    }
                    if($rest->callOnSale==1){
                        $callOnSale=1;
                    }else{
                        $callOnSale=0;
                    }
                    if($rest->zeroExistance==1){
                        $zeroExistance=1;
                    }else{
                        $zeroExistance=0;
                    }
                }
            }
            $kala->descKala=$discriptKala;
            $favorits=DB::select("SELECT * FROM NewStarfood.dbo.star_Favorite");
            foreach ( $favorits as $favorite) {
                if($kala->GoodSn==$favorite->goodSn and $favorite->customerSn==$customerSn){
                    $exist='YES';
                    break;
                }else{
                    $exist='NO';
                }
            }
            $boughtKalas=DB::select("SELECT  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".$customerSn." and SnGood=".$kala->GoodSn."  and orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount=0;
            $packAmount;
            $defaultUnit;
            $defaultUnits=DB::select("SELECT defaultUnit from Shop.dbo.PubGoods where PubGoods.GoodSn=".$kala->GoodSn);
            foreach ($defaultUnits as $unit) {
                $defaultUnit=$unit->defaultUnit;
            }
            $secondUnits=DB::select("SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$kala->GoodSn);
            if(count($secondUnits)>0){

                foreach ($secondUnits as $unit) {
                    $secondUnit=$unit->UName;
                }
                
            }else{
                $secondUnit=$defaultUnit;
            }
            foreach ($boughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYS;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;

            }
            if(count($boughtKalas)>0){
                $kala->bought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
            }else{
                $kala->bought="No";
                $kala->SnOrderBYS=0;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=0;
            }
            $kala->favorite=$exist;
            $kala->overLine=$overLine;
            $kala->callOnSale=$callOnSale;
            if($zeroExistance==1){
            $kala->AmountExist=0;
            }
            $preBoughtKalas=DB::select("SELECT  star_pishKharidFactor.*,star_pishKharidOrder.* from NewStarfood.dbo.star_pishKharidFactor join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=star_pishKharidOrder.SnHDS where CustomerSn=".$customerSn." and SnGood=".$kala->GoodSn." and  orderStatus=0");
            $orderBYSsn;
            $secondUnit;
            $amount;
            $packAmount;
            foreach ($preBoughtKalas as $boughtKala) {
                $orderBYSsn=$boughtKala->SnOrderBYSPishKharid;
                $orderGoodSn=$boughtKala->SnGood;
                $amount=$boughtKala->Amount;
                $packAmount=$boughtKala->PackAmount;
                $secondUnits=DB::select("SELECT GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood=".$orderGoodSn);
                if(count($secondUnits)>0){
                    foreach ($secondUnits as $unit) {
                        $secondUnit=$unit->UName;
                    }
                }else{
                    $secondUnit=$kala->UName;
                }
            }
            if(count($preBoughtKalas)>0){
                $kala->preBought="Yes";
                $kala->SnOrderBYS=$orderBYSsn;
                $kala->secondUnit=$secondUnit;
                $kala->Amount=$amount;
                $kala->PackAmount=$packAmount;
                $kala->UName=$kala->UNAME;
            }else{
                $kala->preBought="No";
            }
        }
        $mainGroup=DB::select("SELECT title FROM NewStarfood.dbo.star_group WHERE star_group.id=".$groupId);
        $groupName="";
        foreach ($mainGroup as $gr) {
            $groupName=$gr->title;
        }
        // $assameKalas=DB::table("NewStarfood.dbo.star_assameKala")->join("Shop.dbo.PubGoods","PubGoods.GoodSn",'=','star_assameKala.assameId')->where("mainId",$productId)->select("*")->take(4)->get();
        $assameKalas=DB::select("SELECT TOP 4 * from Shop.dbo.PubGoods join NewStarfood.dbo.star_assameKala on PubGoods.GoodSn=star_assameKala.assameId WHERE mainId=".$productId." and PubGoods.GoodSn not in (select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1)");
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return Response::json(['product'=>$listKala,'groupName'=>$groupName,'assameKalas'=>$assameKalas,'mainGroupId'=>$groupId,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    public function searchKalaApi(Request $request)
    {
        
        $kalaName=$request->get("name");
        $customerSn=$request->get("psn");
        $words=explode(" ",$kalaName);
        $queryPart=" ";
        $counter=count($words);
       
        foreach ($words as $word) {
        $counter-=1;
            if($counter>0){
                $queryPart.="GoodName LIKE '%$word%' AND ";
            }else{
                $queryPart.="GoodName LIKE '%$word%'";
            }
                
            
        }

        //without stocks-----------------------------------------------------
        $kalaList=DB::select("SELECT  GoodSn,GoodName,UName,CRM.dbo.getGoodFirstGroupId(GoodSn) as firstGroupId,CRM.dbo.getGoodSecondGroupId(GoodSn) as secondGroupId,Price3,Price4,SnGoodPriceSale,IIF(csn>0,'YES','NO') favorite,productId,IIF(ISNULL(productId,0)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,secondUnit,freeExistance,activeTakhfifPercent,activePishKharid FROM(
            SELECT  PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,csn,D.productId,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
            ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,secondUnit,star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.activePishKharid FROM Shop.dbo.PubGoods
            JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
            JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
            left JOIN (select  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerSn and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
            left join (select goodSn as csn from NewStarfood.dbo.star_Favorite WHERE star_Favorite.customerSn=$customerSn)C on PubGoods.GoodSn=C.csn
            LEFT JOIN (select productId from NewStarfood.dbo.star_requestedProduct where customerId=$customerSn)D on PubGoods.GoodSn=D.productId
            left join (select zeroExistance,callOnSale,overLine,productId from NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
            LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
            left join (select GoodUnitSecond.AmountUnit,SnGood,UName as secondUnit from Shop.dbo.GoodUnitSecond
            join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5)G on G.SnGood=PUbGoods.GoodSn
            WHERE  PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) 
            GROUP BY PubGoods.GoodSn,E.zeroExistance,E.callOnSale,E.overLine,BoughtAmount,PackAmount,SnOrderBYS,secondUnit,D.productId,PubGoods.GoodName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale,PUBGoodUnits.UName,star_GoodsSaleRestriction.activeTakhfifPercent,
            star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activePishKharid,csn 
            ) A where $queryPart order by Amount desc");   

        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        foreach ($currencyExistance as $cr) {
            $currency=$cr->currency;
        }
        if($currency==10){
            $currencyName="تومان";
        }
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        
        return Response::json(['kala'=>$kalaList,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos, 'kalaName'=>$kalaName]);

    }

    public function getJustKalaNameQueryPart($name)
    {
        $kalaName=trim(self::changeToArabicLetterAndEngNumber($name));
        $words=explode(" ",$kalaName);
        $queryPart=" ";
        $counter=count($words);
       
        foreach ($words as $word) {
        $counter-=1;
            if($counter>0){
                $queryPart.="REPLACE(GoodName,' ', '') LIKE '%$word%' AND ";
            }else{
                $queryPart.="REPLACE(GoodName,' ', '') LIKE '%$word%'";
            }
            
        }
        return $queryPart;
    }

    public function getSenonymKalaNameQueryPart($name)
    {
        $kalaName=trim(self::changeToArabicLetterAndEngNumber($name));
		$senWords=explode(" ",$kalaName);
        $senQueryPart=" ";
        $senCounter=count($senWords);
        foreach ($senWords as $word) {
        	$senCounter-=1;
            if($senCounter>0){
                $senQueryPart.=" Replace(senonym,' ','') LIKE '%$word%' AND ";
            }else{
                $senQueryPart.=" Replace(senonym,' ','') LIKE '%$word%'";
            }
        }
        return $senQueryPart;
    }

    public function getKalaByName(Request $request){
        $name=$request->get('name');
        $queryPart=self::getJustKalaNameQueryPart($name);
        $kala_list=DB::select(" SELECT PubGoods.GoodName,PubGoods.GoodGroupSn,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,V.Amount,GoodCde,GoodGroups.NameGRP from Shop.dbo.PubGoods
                        join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                        JOIN (select * from Shop.dbo.ViewGoodExists where ViewGoodExists.FiscalYear=1402) V on PubGoods.GoodSn=V.SnGood
                        left join Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
                        where GoodName!='' and NameGRP!='' and GoodSn!=0
                        and PubGoods.CompanyNo=5  and PubGoods.GoodGroupSn >49 and ($queryPart)") ;
        return Response::json($kala_list);
    }

    function getKalaByCode(Request $request) {
        $code=$request->input("code");
        $kala=DB::select("SELECT PubGoods.GoodName,PubGoods.GoodGroupSn,PubGoods.GoodSn,GoodPriceSale.Price3,GoodPriceSale.Price4,V.Amount,GoodCde,GoodGroups.NameGRP FROM Shop.dbo.PubGoods
        JOIN Shop.dbo.GoodGroups ON PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
        JOIN (SELECT * FROM Shop.dbo.ViewGoodExists WHERE ViewGoodExists.FiscalYear=1402) V on PubGoods.GoodSn=V.SnGood
        LEFT JOIN Shop.dbo.GoodPriceSale on PubGoods.GoodSn=GoodPriceSale.SnGood
        WHERE GoodName!='' AND NameGRP!='' AND GoodSn!=0
        AND PubGoods.CompanyNo=5  AND PubGoods.GoodGroupSn >49 AND (GoodCde LIKE '%$code%')");
        return Response::json($kala);
    }


}



