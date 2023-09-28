<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GoodGroups;
use Illuminate\Support\Facades\Validator;
use Response;
use BrowserDetect;
use Carbon\Carbon;
use Session;
class Home extends Controller {
    public function index (Request $request)
    {
        if(!Session('psn')){
            return redirect('/login');
        }

        $customerId=Session::get("psn");
        if(!Session::get("otherUserInfo")){
            $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
            $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
            if($lastReferesh>=0 or count($logedIns)<1){
                $palatform=BrowserDetect::platformFamily();
                $browser=BrowserDetect::browserFamily();
                if(count($logedIns)<1){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
                }elseif($lastReferesh>0){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
                }
            }
        }
		
        $slider=DB::select("SELECT star_add_homePart_stuff.id,star_add_homePart_stuff.homepartId,star_add_homePart_stuff.firstPic,star_add_homePart_stuff.secondPic,star_add_homePart_stuff.thirdPic,star_add_homePart_stuff.fourthPic,star_add_homePart_stuff.fifthPic FROM NewStarfood.dbo.HomePart INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON HomePart.id=star_add_homePart_stuff.homepartId WHERE HomePart.partType=3");
		 
        $smallSlider=DB::select("SELECT star_add_homePart_stuff.id,star_add_homePart_stuff.homepartId,star_add_homePart_stuff.firstPic,star_add_homePart_stuff.secondPic,star_add_homePart_stuff.thirdPic,star_add_homePart_stuff.fourthPic,star_add_homePart_stuff.fifthPic,HomePart.activeOrNot FROM NewStarfood.dbo.HomePart INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON HomePart.id=star_add_homePart_stuff.homepartId WHERE HomePart.partType=4");
		 
        $productGroups = DB::select("select * from NewStarfood.dbo.star_group WHERE selfGroupId=0 order by mainGroupPriority asc");
		 
        //برای جابجایی و نمایش بخش های صفحه اصلی نوشته می شود
        $partStringForView="";//به ویو فرستاده میشود
        $partStringLocal="";//بخش را در بر می گیرد
        $counterAsId=0;
        $shegeftAngizColorFlag=0;
        $countPartGroup=0;
        $buyFromHome=0;
        $homePageType=1;
		$webSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();
        $logoPos=$webSettings[0]->logoPosition;
		$showLogo=true;
		if($logoPos == 0){
			$logoClass="topLeft";
		}else{
			$logoClass="topRight";
			}
        $parts=DB::select("SELECT DISTINCT textLogo,textColor,textFontSize,NewStarfood.dbo.HomePart.title,NewStarfood.dbo.HomePart.showPercentTakhfif,NewStarfood.dbo.HomePart.partColor,NewStarfood.dbo.HomePart.showAll,NewStarfood.dbo.HomePart.showTedad,NewStarfood.dbo.HomePart.showOverLine,NewStarfood.dbo.HomePart.id AS partId,NewStarfood.dbo.HomePart.priority AS PartPriority,NewStarfood.dbo.HomePart.partType,NewStarfood.dbo.star_homepart_pictures.homepartId FROM NewStarfood.dbo.HomePart LEFT JOIN NewStarfood.dbo.star_homepart_pictures ON NewStarfood.dbo.HomePart.id=NewStarfood.dbo.star_homepart_pictures.homepartId where activeOrNot=1 and  partType!=3 and  partType!=4 ORDER BY NewStarfood.dbo.HomePart.priority ASC");
        $currency=1;
        $currencyName="ریال";
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        $currency=$currencyExistance[0]->currency;
        if($currency==10){
            $currencyName="تومان";
        }
        $buyFromHome=$webSettings[0]->buyFromHome;
        $homePageType=$webSettings[0]->homePage;
        Session::put("FiscallYear",$webSettings[0]->FiscallYear);
        $showBuys="none";
        if($buyFromHome==1){
            $showBuys="flex";
        }
            foreach ($parts as $part) {
                $counterAsId+=1;

            if($part->partType == 1){
                    $countPartGroup=$countPartGroup+1;
                    //گروهی از گروه ها
                    //$groups=DB::select("SELECT star_group.id as groupId,star_group.title FROM NewStarfood.dbo.star_group INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON star_group.id=star_add_homePart_stuff.firstGroupId WHERE star_add_homePart_stuff.homepartId=".$part->partId);
                    $firstPartStringLocal=
                "<section class='product-wrapper container lastBanner'>
                        <div class='headline'><h3>".$part->title."</h3></div>
                        <div id='brandslider".$countPartGroup."' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                        <div class='product-box swiper-wrapper' style='transform: translate3d(547.5px, 0px, 0px); transition-duration: 0ms;'>";
                    $partId=$part->partId;
                    $cart="";
                    $allGroups=DB::select("SELECT  TOP ".$part->showTedad."  star_add_homePart_stuff.priority, star_group.id as groupId,star_group.title FROM NewStarfood.dbo.star_group INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON star_group.id=star_add_homePart_stuff.firstGroupId WHERE star_add_homePart_stuff.homepartId=".$part->partId." order by priority asc");
                    foreach ($allGroups as $group) {
                        $cart.="<div class='swiper-slide'>
                        <div class='emptySlider'>
                            <a href='/listKala/groupId/".$group->groupId."' >
                                <img class='mt-0'style='max-height: 110px; width:110px; margin-bottom:-10px;' src='resources/assets/images/mainGroups/" . $group->groupId . ".jpg' alt='' ></a >
                            <a class='title text-dark fw-bold' style='height: 15%;' href='/listKala/groupId/".$group->groupId."'>".$group->title."</a>
                        </div>
                    </div>
                    ";
                    }
                    $secondPartStringLocal="
                    </section>
                    ";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 12){
                    //در صورتیکه برند باشد
                    $countPartGroup=$countPartGroup+1;
                    $allBrands=DB::select("SELECT star_add_homePart_stuff.brandId,star_add_homePart_stuff.homePartId from NewStarfood.dbo.star_add_homePart_stuff where homePartId=".$part->partId." order by priority asc");
                    $firstPartStringLocal="
                    <section class='product-wrapper container lastBanner'>
                    <div class='headline'><h3>".$part->title."</h3></div>
                    <div id='brandslider".$countPartGroup."' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                        <div class='product-box swiper-wrapper align-items-start' style='transform: translate3d(272px, 0px, 0px); transition-duration: 0ms;'>";
                    $partId=$part->partId;
                    $cart="";
                    foreach ($allBrands as $brand) {
                        $cart.="<div class='swiper-slide'>
                        <div class='emptySlider'>
                        <a href='/listKala/brandCode/".$brand->brandId."'>
                            <img src='resources/assets/images/brands/".$brand->brandId. ".jpg' alt='تصویر' style='width:110px; height:110px;'></a >
                        </div>
                       </div>
                    ";
                    }
                    $secondPartStringLocal="
                    </section>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }


                    if($part->partType == 13){
                        //لیستی از پیش خرید ها
                        $showAll="";
                        if($part->showAll==1){
                            $showAll="<a href='/getAllKala/".$part->partId."' style='display:inline;'>مشاهده همه</a>";
                        }else{
                            $showAll="";
                        }
                    $firstPartStringLocal="<section class='product-wrapper container'>
                                            <div class='headline two-headline'><h4>".$part->title."</h4>".$showAll."</div>
                                            <div id='newpslider".$counterAsId."' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                                        <div class='product-box swiper-wrapper' style='transform: translate3d(1088px, 0px, 0px); transition-duration: 0ms;'>";
                                        $partId=$part->partId;
                                        $cart="";
                                        $allKalas=DB::select("SELECT TOP ".$part->showTedad." * FROM (
                                            SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                                                    star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                                                    JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                                                    JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                                                    JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                                    JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                                    WHERE star_add_homePart_stuff.homepartId=$partId
                                                    and star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a 
                                                    
                                                    JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id order by priority asc");

                                        foreach ($allKalas as $kala) {
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
                                                $secondUnits=DB::select('select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                                                join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                                                join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn);
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
                                        }
                                        foreach ($allKalas as $kala) {
                                            $orderBYSsn=0;
                                            $boughtKala="blue";
                                            $showOverLine="none";
                                            $showTakhfifPercent="none";
                                            if($kala->bought=="Yes"){
                                                $orderBYSsn=$kala->SnOrderBYS;
                                                $amount=$kala->Amount/$kala->PackAmount;
                                                $boughtKala="green";
                                                $fontSize = "27px";
                                            }else{
                                                $orderBYSsn=0;
                                                $amount=0;
                                            }
                                            if($part->showPercentTakhfif==1){
                                                $showOverLine="flex";
                                                $showTakhfifPercent="flex";

                                            }else{
                                                $showTakhfifPercent="none";
                                            }
                                            if($part->showOverLine==1 and $showOverLine=="flex"){
                                                $showOverLine="flex";
                                            }else{
                                                $showOverLine="none";
                                            }
                                            $percentResult=0;
                                            if($kala->Price4>0 and $kala->Price3>0){
                                            $percentResult=round((($kala->Price4-$kala->Price3)*100)/$kala->Price4);
                                            }else{
                                                $percentResult=0;
                                            }
                                            if($percentResult<0){
                                                $percentResult=0;
                                            }
                                            if($percentResult==0){
                                                $showTakhfifPercent="none";
                                            }
                                            $descUrl="/descKala/".$kala->firstGroupId."/itemCode/".$kala->GoodSn;
                                            $imageSrc="";
                                            if(file_exists("resources/assets/images/kala/". $kala->GoodSn ."_1.jpg")){
                                                $imageSrc="/resources/assets/images/kala/".$kala->GoodSn."_1.jpg";
                                            }else{
                                                $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                                            }
                                            $cart.="
                                            <div class='product-item swiper-slide'>
                                                <div class='col-sm-6 float-right ps-1 m-0 buyPlus' style='z-index:100;display:".$showBuys.";'>
                                                        <i onclick='preBuyFromHome(".$kala->GoodSn.",".$partId.")' id='preBuySign".$partId."_".$kala->GoodSn."' class='fa fa-plus-circle fa-lg d-flex flex-start pt-3' style='font-size:30px; color:".$boughtKala.";'>
                                                            <span style='opacity:0.1; padding-right:-5px; font-size:18px;'> خرید </span>
                                                        </i>
                                                        <div style='display:none;' class='preBuyFromHome overlay' id='preBuyFromHome".$partId."_".$kala->GoodSn."' >
                                                        <input id='preOrderNumber".$partId."_".$kala->GoodSn."' style='display:none;' value='".$orderBYSsn."' type='text'/>
                                                        <button class='tobuy fw-bold' id='addToPreBuy".$partId."_".$kala->GoodSn."' onclick='addToPreBuy(".$kala->GoodSn.",".$partId.")'>  + </button>
                                                        <span class='tobuy fw-bold' id='preBuyNumber".$partId."_".$kala->GoodSn."' style='padding:1px 12px 5px 12px;'> ".$amount."  </span>
                                                        <button class='tobuy fw-bold' id='subFromPreBuy".$partId."_".$kala->GoodSn."' onclick='subFromPreBuy(".$kala->GoodSn.",".$partId.")'> -  </button>
                                                    </div>
                                                </div>
                                                
                                                <a href='".$descUrl."'>
													
                                                    <img src='$imageSrc' alt='تصویر'>
                                                    <p class='title' ".$descUrl."'>".$kala->GoodName."</p>
                                                </a>
                                                <div class='row border-top priceDiv'>
                                                    <div class='d-block'style='width:50%'>
                                                        <div class='row d-flex flex-nowrap pe-3 pt-2' style='display:".$showTakhfifPercent.";'>
                                                                <span class='takhfif-round' style='background-color:red'> ".$percentResult."% </span></div>
                                                        <div class='row'> &nbsp </div>
                                                    </div>
                                                    <div class='inc-product-price d-block'style='width:50%'>
                                                        <div class='row'> <del class='ps-3 m-0 fw-bold' style='color: #ef394e;'>".number_format($kala->Price4/$currency)." ".$currencyName." </del></div>
                                                        <div class='row'><span class='ps-3 m-0  price' style='color:#39ae00';>".number_format($kala->Price3/$currency)." ".$currencyName." </span></div>
                                                    </div>
                                                </div>
                                                <div id='newpslider-nbtn' class='slider-nbtn swiper-button-next' style='display: none;'></div>
                                                <div id='newpslider-pbtn' class='slider-pbtn swiper-button-prev' style='display: none;'></div>
                                                <span class='swiper-notification' aria-live='assertive' aria-atomic='true'></span>
                                            </div>
                                        ";
                                            }
                                        $secondPartStringLocal="
                                    </section>";
                                     $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 2){
                    //لیستی از کالاها
                    $showAll="";

                    if($part->showAll==1){
                        $showAll="<a href='/getAllKala/".$part->partId."' style='display:inline;'>مشاهده همه</a>";
                    }else{
                        $showAll="";
                    }
                    $firstPartStringLocal="
                    <section class='product-wrapper container'>
                        <div class='headline two-headline'>
                            <h4>".$part->title."</h4>".$showAll."
                        </div>
                        <div id='newpslider".$counterAsId."' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                        <div class='product-box swiper-wrapper' style='transform: translate3d(1088px, 0px, 0px); transition-duration: 0ms;'>
                    ";
                    $partId=$part->partId;
                    $cart="";
                    $allKalas=DB::select("SELECT TOP ".$part->showTedad." * FROM (
                                            SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                                                    star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                                                    JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                                                    JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                                                    JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                                    JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                                    WHERE star_add_homePart_stuff.homepartId=$partId
                                                    and star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a 
                                                    
                                                    JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id order by priority asc");
                        foreach ($allKalas as $kala) {
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
                            $secondUnits=DB::select('select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                            join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                            join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn);
                        
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
                    }
                    foreach ($allKalas as $kala) {
                        $orderBYSsn=0;
                        $boughtKala="red";
                        $showOverLine="none";
                        $showTakhfifPercent="none";
                        $showCall="flex";
                        if($kala->callOnSale==1){
                            $showCall="none";
                        }else{
                            $showCall="flex";
                        }
                        if($kala->bought=="Yes"){
                            $orderBYSsn=$kala->SnOrderBYS;
                            $amount=$kala->Amount/$kala->PackAmount;
                            $boughtKala="green";
                            $fontSize = "27px";
                        }else{
                            $orderBYSsn=0;
                            $amount=0;
                        }
                        if($part->showPercentTakhfif==1){
                            $showOverLine="flex";
                            $showTakhfifPercent="flex";
                        }else{
                            $showTakhfifPercent="none";
                        }
                        if($part->showOverLine==1 and $showOverLine=="flex"){
                            $showOverLine="flex";
                        }else{
                            $showOverLine="none";
                        }
                        $percentResult=0;
                        if($kala->Price4>0 and $kala->Price3>0){
                        $percentResult=round((($kala->Price4-$kala->Price3)*100)/$kala->Price4);
                        }else{
                            $percentResult=0;
                        }
                        if($percentResult<0){
                            $percentResult=0;
                        }
                        if($percentResult==0){
                            $showTakhfifPercent="none";
                        }
                        $descUrl="/descKala/".$kala->firstGroupId."/itemCode/".$kala->GoodSn;

                        $imageSrc="";
                        if(file_exists("resources/assets/images/kala/". $kala->GoodSn ."_1.jpg")){
							
							
                            $imageSrc="/resources/assets/images/kala/".$kala->GoodSn."_1.jpg";
                        }else{
                            $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                        }
                        $cart.="
                        <div class='product-item swiper-slide'>
                        <div class='col-sm-6 ps-1 m-0 buyPlus' style='z-index:1000;display:".$showBuys.";'>
                        <i onclick='buyFromHome(".$kala->GoodSn.",".$partId.")' id='buySign".$partId."_".$kala->GoodSn."' class='fa fa-plus-circle fa-lg d-flex flex-start pt-3' style='font-size:30px;color:".$boughtKala.";' >
                            <span style='opacity:0.1; padding-left:5px; font-size:18px;'> خرید </span> </i>
                        <div style='display:none;' class='buyFromHome alert overlay' id='buyFromHome".$partId."_".$kala->GoodSn."' >
                        <input class='tobuy'  id='orderNumber".$partId."_".$kala->GoodSn."' style='display:none' value='".$orderBYSsn."' type='text'/>
                        <button class='tobuy' id='addToBuy".$partId."_".$kala->GoodSn."' onclick='addToBuy(".$kala->GoodSn.",".$partId.")' style='display:bock;'> + </button>
                        <span  class='tobuy fw-bold' id='BuyNumber".$partId."_".$kala->GoodSn."' style='padding:1px 12px 5px 12px;'>".$amount."</span>
                        <button class='tobuy' id='subFromBuy".$partId."_".$kala->GoodSn."' onclick='subFromBuy(".$kala->GoodSn.",".$partId.")'> - </button>
                        </div>
                        </div>
                            <a href='".$descUrl."'>
							
                            
                            
                                <img src='$imageSrc' alt='تصویر'>
                                <p class='title' ".$descUrl."'>".$kala->GoodName."</p>
                            </a>
                                <div class='row border-top priceDiv'>
                                    <div class='d-block'style='width:50%'>
                                        <div class='row d-flex flex-nowrap pe-3 pt-2' style='display:".$showTakhfifPercent.";'>
                                                <span class='takhfif-round' style='background-color:red'> ".$percentResult."% </span></div>
                                        <div class='row'> &nbsp </div>
                                    </div>
                                    <div class='inc-product-price d-block'style='width:50%'>
                                        <div class='row'> <del class='ps-3 m-0 fw-bold' style='color: #ef394e;'>".number_format($kala->Price4/$currency)." ".$currencyName." </del></div>
                                        <div class='row'><span class='ps-3 m-0  price' style='color:#39ae00';>".number_format($kala->Price3/$currency)." ".$currencyName." </span></div>
                                    </div>
                                </div>
                                <div id='newpslider-nbtn' class='slider-nbtn swiper-button-next' style='display: none;'></div>
                                <div id='newpslider-pbtn' class='slider-pbtn swiper-button-prev' style='display: none;'></div>
                                <span class='swiper-notification' aria-live='assertive' aria-atomic='true'></span>
                            </div>
                        ";
                    }
                    $secondPartStringLocal="</section>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }


                if($part->partType == 11){
                    //شگفت انگیزها'
                    $showOverLine="none";
                    $showTakhfifPercent="none";
                    if($part->showAll==1){
                        $showAll="<div  class='specials__btn'>مشاهده همه</div>";
                    }else{
                        $showAll="<div style='width:100px'></div>";
                    }
                    $shegeftAngizColorFlag+=1;
                    $changeShegeftColor="";
					$shegeftImage="";
					if(file_exists('resources/assets/images/shegeftAngesPicture/'.$part->partId.'.jpg')){
						$shegeftImage='<img style="width:20px !important;" src="/resources/assets/images/shegeftAngesPicture/'.$part->partId.'.jpg">';
					}else{
					     $shegeftImage='<p style="color:'.$part->textColor.';font-size:'.$part->textFontSize.'">'.$part->textLogo.'</p>';
					}
                        $firstPartStringLocal='
                        <section class="product-wrapper container">
                          <div  id="" style="background-color:'.$part->partColor.' !important" class="c-swiper-specials--incredible mt-2 mb-0">
                            <div style="overflow: hidden" class="container">
                            <section class="icontainer">
                                <a href="/getAllKala/'.$part->partId.'" class="specials__title">'.$shegeftImage.''.$showAll.'</a>
                                <div class="swiper--specials">
                                    <div id="inc-slider'.$shegeftAngizColorFlag.'" class="swiper-container swiper-container-horizontal swiper-container-rtl">
                                    <div class="product-box swiper-wrapper  d-flex align-items-center justify-content-center" style="transform: translate3d(1088px, 0px, 0px); transition-duration: 0ms;">';

                                        $partId=$part->partId;
                                        $cart="";
                                        $allKalas=DB::select("SELECT TOP ".$part->showTedad." * FROM (
                                            SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                                                    star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                                                    JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                                                    JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                                                    JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                                    JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                                                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                                    WHERE star_add_homePart_stuff.homepartId=$partId
                                                    and star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a 
                                                    
                                                    JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id order by priority asc");

                                        foreach ($allKalas as $kala) {
                                        $boughtKalas=DB::select("select  FactorStar.*,orderStar.* from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get('psn')." and SnGood=".$kala->GoodSn." and  orderStatus=0");
                                        $orderBYSsn;
                                        $secondUnit=$kala->UName;
                                        $amount;
                                        $packAmount;
                                        foreach ($boughtKalas as $boughtKala) {
                                            $orderBYSsn=$boughtKala->SnOrderBYS;
                                            $orderGoodSn=$boughtKala->SnGood;
                                            $amount=$boughtKala->Amount;
                                            $packAmount=$boughtKala->PackAmount;
                                            $secondUnits=DB::select('select GoodUnitSecond.AmountUnit,PubGoods.GoodSn,PUBGoodUnits.UName from Shop.dbo.PubGoods
                                            join Shop.dbo.GoodUnitSecond on PubGoods.GoodSn=GoodUnitSecond.SnGood
                                            join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5 and GoodUnitSecond.SnGood='.$orderGoodSn);
                                        
                                        $secondUnit=$secondUnits[0]->UName;
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
                                    }
                                        foreach ($allKalas as $kala) {
                                            $orderBYSsn=0;
                                            $boughtKala="red";
                                            if($kala->bought=="Yes"){
                                                $orderBYSsn=$kala->SnOrderBYS;
                                                $amount=$kala->Amount/$kala->PackAmount;
                                                $boughtKala="green";
                                                $fontSize = "27px";
                                            }else{
                                                $orderBYSsn=0;
                                                $amount=0;
                                            }
                                            if($part->showPercentTakhfif==1){
                                                $showOverLine="flex";
                                                $showTakhfifPercent="flex";

                                            }else{
                                                $showTakhfifPercent="none";
                                            }
                                            if($part->showOverLine==1 or $showOverLine=="flex"){
                                                $showOverLine="flex";
                                            }else{
                                                $showOverLine="none";
                                            }
                                            if($kala->Price4>0 and $kala->Price3>0){
                                                $percentResult=round((($kala->Price4-$kala->Price3)*100)/$kala->Price4);
                                                }else{
                                                    $percentResult=0;
                                                }
                                            if($percentResult==0){
                                                $showTakhfifPercent="none";
                                            }
                                            $descUrl="/descKala/".$kala->firstGroupId."/itemCode/".$kala->GoodSn;
                                            $imageSrc="";
                                            if(file_exists("resources/assets/images/kala/". $kala->GoodSn ."_1.jpg")){
												
                                                $imageSrc="/resources/assets/images/kala/".$kala->GoodSn."_1.jpg";
                                            }else{
                                                $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                                            }
                                            $cart.='

                                                <div class="shegeftAngez-item swiper-slide shegeftAngezHover text-center">
                                                    <div class="col-sm-6 ps-1 m-0 buyPlus" style="z-index:99999999; display:'.$showBuys.'; position:fixed;">
                                                        <i onclick="buyFromHome('.$kala->GoodSn.','.$partId.')" id="buySign'.$partId.'_'.$kala->GoodSn.'" class="fa fa-plus-circle fa-lg d-flex flex-start pt-3" style="font-size:30px;color:'.$boughtKala.';" >
                                                        <span style="opacity:0.1; padding-left:5px; font-size:18px;"> خرید </span> </i>
                                                        <div style="display:none;" class="buyFromHome alert overlay" id="buyFromHome'.$partId.'_'.$kala->GoodSn.'" >
                                                        <input class="tobuy"  id="orderNumber'.$partId.'_'.$kala->GoodSn.'" style="display:none" value="'.$orderBYSsn.'" type="text"/>
                                                        <button class="tobuy" id="addToBuy'.$partId.'_'.$kala->GoodSn.'" onclick="addToBuy('.$kala->GoodSn.','.$partId.')" style="display:bock;"> + </button>
                                                        <span  class="tobuy fw-bold" id="BuyNumber'.$partId.'_'.$kala->GoodSn.'" style="padding:1px 12px 5px 12px;">'.$amount.'</span>
                                                        <button class="tobuy" id="subFromBuy'.$partId.'_'.$kala->GoodSn.'" onclick="subFromBuy('.$kala->GoodSn.','.$partId.')"> - </button>
                                                    </div>
                                                    </div>
                                                        <a href="'.$descUrl.'" class="text-center">
                                                            <img style="z-index:2; width: 166px; height:auto; margin:0 auto" src="'.$imageSrc.'" alt="تصویر">
                                                            <p class="title pe-1 pt-1" href="'.$descUrl.'">'.$kala->GoodName.'</p>
                                                        </a>
                                                    </dvi>
                                                    <div class="row border-top priceDiv">
                                                      <div class="d-block" style="width:50%">
                                                            <div class="row d-flex flex-nowrap pe-3 pt-2" style="display:'.$showTakhfifPercent.';">
                                                                <span class="takhfif-round" style="background-color:red">'.$percentResult.'% </span></div>
                                                            <div class="row"> &nbsp </div>
                                                        </div>
                                                        <div class="inc-product-price d-block" style="width:50%; text-align:left;">
                                                                <div class="row"> <del class="ps-3 ps-0 m-0 fw-bold d-flex justify-content-end" style="color:#ef394e;">'.number_format($kala->Price4/$currency).' '.$currencyName.' </del></div>
                                                                <div class="row"> <span class="ps-3 m-0  price d-flex justify-content-end" style="color:#39ae00;">'.number_format($kala->Price3/$currency).' '.$currencyName.' </span></div>
                                                        </div>
                                                    </div>
                                                    </div>';
                                        }
                                        $secondPartStringLocal=' </div></div><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                                            </div> </section></div> </div></section>';
                                $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 6){
                    //تک عکسی و لیستی از کالاها
                    $firstPartStringLocal="
                    <div class='container'>
                        <div class='row'>
                            <div class='col-12 medium-100'>";
                            $partId=$part->partId;
                            $cart="";
                    $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                    foreach ($pictures as $pic) {
                        $countPicKala=0;
                        $disabled="";
                        $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    if($countPicKala<1){
                            $disabled="style='pointer-events: none; cursor: default;'";
                    }else{
                        $disabled="";
                    }
                        $cart.="
                            <a class='item-box mb-1' ".$disabled." href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."'></a>
                            <a href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled."'>
                                <img style='width: 100%;' src='/resources/assets/images/onePic/".$part->homepartId.".jpg' alt=''>
                            </a>
                        ";
                    }
                    $secondPartStringLocal="
                            </div>
                            </div>
                        </div>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 7){
                    //دوعکسی و لیستی از کالاها
                    $firstPartStringLocal="
                    <div class='container'>
                        <div class='row'>";
                            $partId=$part->partId;
                            $cart="";
                    $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                    $i=0;
                    foreach ($pictures as $pic) {
                        $i=$i+1;
                        $countPicKala=0;
                        $disabled="";
                        $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    if($countPicKala<1){
                        $disabled="style='pointer-events: none; cursor: default;'";
                    }else{
                        $disabled="";
                    }
                    $imageSrc="";

                    if(file_exists("resources/assets/images/twoPics/".$part->homepartId."_".$i.".jpg")){
                        $imageSrc="resources/assets/images/twoPics/".$part->homepartId."_".$i.".jpg";
                        }else{
                        $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                        }

                        $cart.="
                            <div class='col-6 col-md-6 medium-25 pe-1'>
                                <div class='item-box mb-1' href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled.">
                                    <div class='item-media'>
                                    <a href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled.">
									
                                    
                                        <img style='min-height:170px;' src='$imageSrc' ".$part->homepartId."_".$i.".jpg' alt='تصویر'>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        ";
                            }
                    $secondPartStringLocal="
                        </div>
                    </div> ";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 8){
                    //سه عکسی و لیستی از کالاها
                    $firstPartStringLocal="
                    <div class='container'>
                        <div class='row'>";
                            $partId=$part->partId;
                            $cart="";
                    $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                    $i=0;
                    $countCol=0;
                    foreach ($pictures as $pic) {
                        $i=$i+1;
                        $countCol++;
                        $countPicKala=0;
                        $disabled="";
                        $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    if($countPicKala<1){
                        $disabled="style='pointer-events: none; cursor: default;'";
                    }else{
                        $disabled="";
                    }
                    $colSize=12;
                    if($countCol==2 or $countCol==1){
                            $colSize=6;
                        }
                        $imageSrc="";
                        if(file_exists("resources/assets/images/threePics/".$part->homepartId."_".$i.".jpg")){
                            $imageSrc="/resources/assets/images/threePics/".$part->homepartId."_".$i.".jpg";
                            }else{
                            $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                            }
                        $cart.="<div class='col-".$colSize." col-md-4 medium-25 pe-1'>
                                    <div class='item-box mb-1' href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled.">
                                        <div class='item-media'>
                                            <a href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."'  ".$disabled.">
											
                                            
                                                <img style='height:170px;' src='".$imageSrc."' alt=''>
                                            </a>
                                        </div>
                                    </div>
                                </div> ";
                            }
                    $secondPartStringLocal="</div>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 9){
                    //چهار عکسی و لیستی از کالاها
                    $firstPartStringLocal="
                    <section class='product-wrapper container'>
                        <div id='newpslider' class='swiper-container swiper-container-horizontal swiper-container-rtl'>
                            <div class='product-box swiper-wrapper align-items-center d-flex justify-content-center text-center' style='transform: translate3d(272px, 0px, 0px); transition-duration: 0ms;'>";
                            $partId=$part->partId;
                            $cart="";
                    $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                    $i=0;
                    foreach ($pictures as $pic) {
                        $i=$i+1;
                        $countPicKala=0;
                        $disabled="";
                        $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    if($countPicKala<1){
                        $disabled="style='pointer-events: none; cursor: default;'";
                    }else{
                        $disabled="";
                    }
                    $imageSrc="";
                    if(file_exists("resources/assets/images/fourPics/".$part->homepartId."_".$i.".jpg")){
                        $imageSrc="/resources/assets/images/fourPics/".$part->homepartId."_".$i.".jpg";
                        }else{
                        $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                        }
                        $cart.="<div class='swiper-slide swiper-slide-prev d-flex justify-content-center'>
                                <a style='display:block; width:100%;' href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled.">
								
                                
                                <img class=img-responsiv' src='$imageSrc' alt=''></a> </div>";
                            }
                    $secondPartStringLocal="
                    </div><div id='pslider-nbtn' class='slider-nbtn swiper-button-next' style='display: none;'></div>
                    <div id='pslider-pbtn' class='slider-pbtn swiper-button-prev' style='display: none;'></div>
                    <span class='swiper-notification' aria-live='assertive' aria-atomic='true'></span>
                    </div></section>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                if($part->partType == 10){
                    //پنج عکسی و لیستی از کالاها
                    $firstPartStringLocal="
                    <div class='container'><div class='row'>";
                            $partId=$part->partId;
                            $cart="";
                    $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                    $i=0;
                    foreach ($pictures as $pic) {
                        $i=$i+1;
                        $countPicKala=0;
                        $disabled="";
                        $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    if($countPicKala<1){
                        $disabled="style='pointer-events: none; cursor: default;'";
                    }else{
                        $disabled="";
                    }
                    if($i<4){
                        $imageSrc="";
                        if(file_exists("resources/assets/images/fivePics/".$part->homepartId."_".$i.".jpg")){
                            $imageSrc="/resources/assets/images/fivePics/".$part->homepartId."_".$i.".jpg";
                            }else{
                            $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                            }
                        $cart.=" <div class='col-12 col-md-4 medium-20  fifthBanner'>
                                    <div class='item-box mb-2' href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."' ".$disabled.">
                                        <div class='item-media'>
                                            <a href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."'>
										
                                            

                                                <img src='$imageSrc'  ".$disabled." alt=''>
                                            </a>
                                        </div>
                                    </div>
                                </div>";
                        }else{
                            $imageSrc="";
                            if(file_exists("resources/assets/images/fivePics/".$part->homepartId."_".$i.".jpg")){
                                $imageSrc="/resources/assets/images/fivePics/".$part->homepartId."_".$i.".jpg";
                                }else{
                                $imageSrc="/resources/assets/images/defaultKalaPics/altKala.jpg";
                                }
                            $cart.="
                            <div class='col-12 col-md-6 medium-20 fifthBanner'>
                                <div class='item-box mb-2' href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."'   ".$disabled.">
                                    <div class='item-media'>
                                        <a href='/listKalaFromPart/".$part->homepartId."/partPic/".$pic->id."'   ".$disabled.">
                                            <img style='height:170px;' src='$imageSrc' alt='' >
                                        </a>
                                    </div>
                                </div>
                            </div>";
                        }
                            }
                    $secondPartStringLocal="</div></div>";
                    $partStringLocal=$firstPartStringLocal.$cart.$secondPartStringLocal;
                }
                $partStringForView.=$partStringLocal;
            }
            $socials=DB::select("select enamad from NewStarfood.dbo.star_webSpecialSetting");
            $showEnamad=0;
            foreach ($socials as $social) {
                $showEnamad=$social->enamad;
            }
		 $attractions=DB::select("SELECT  *,CONVERT(DATE,ViewDate) AS ViewJustDate FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=".Session::get('psn'));
        return View('home.home',['productGroups' => $productGroups,'attractions'=>$attractions,'homePageType'=>$homePageType,'slider'=>$slider,'smallSlider'=>$smallSlider,'partViews'=>$partStringForView,'showEnamad'=>$showEnamad]);
    }
    public function getHomeParts (Request $request)
    {
        $customerId=$request->input("psn");
        $fiscallYear;
        $partStringForView="";
        $partStringLocal="";
        $counterAsId=0;
        $shegeftAngizColorFlag=0;
        $countPartGroup=0;
        $buyFromHome=0;
        $homePageType=1;
        $showLogo=true;
        $logoPos;
        $logoClass="topRight";
        $currency=1;
        $currencyName="ریال";
        /*
        if(!Session::get("otherUserInfo")){
            $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
            $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
            if($lastReferesh>=0 or count($logedIns)<1){
                 $palatform=BrowserDetect::platformFamily();
                 $browser=BrowserDetect::browserFamily();
                if(count($logedIns)<1){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
                }elseif($lastReferesh>0){
                     DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
                }
            }
        }*/
        //برای جابجایی و نمایش بخش های صفحه اصلی نوشته می شود

		$webSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();
        $logoPos=$webSettings[0]->logoPosition;
		if($logoPos == 0){
			$logoClass="topLeft";
		}
        $currency=$webSettings[0]->currency;
        if($currency==10){
            $currencyName="تومان";
        }
        $buyFromHome=$webSettings[0]->buyFromHome;
        $homePageType=$webSettings[0]->homePage;
        $fiscallYear=$webSettings[0]->FiscallYear;
        $showBuys="none";
        if($buyFromHome==1){
            $showBuys="flex";
        }
        $parts=DB::select("SELECT DISTINCT textLogo,textColor,textFontSize,NewStarfood.dbo.HomePart.title,NewStarfood.dbo.HomePart.showPercentTakhfif,NewStarfood.dbo.HomePart.partColor,NewStarfood.dbo.HomePart.showAll,NewStarfood.dbo.HomePart.showTedad,NewStarfood.dbo.HomePart.showOverLine,NewStarfood.dbo.HomePart.id AS partId,NewStarfood.dbo.HomePart.priority AS PartPriority,NewStarfood.dbo.HomePart.partType,NewStarfood.dbo.star_homepart_pictures.homepartId FROM NewStarfood.dbo.HomePart LEFT JOIN NewStarfood.dbo.star_homepart_pictures ON NewStarfood.dbo.HomePart.id=NewStarfood.dbo.star_homepart_pictures.homepartId where activeOrNot=1 and  partType!=3 and  partType!=4 ORDER BY NewStarfood.dbo.HomePart.priority ASC");
        foreach ($parts as $part) {
           // $counterAsId+=1;
            if($part->partType == 1){
                 // در صورتیکه گروهی از گروه ها باشند
                $allGroups=DB::select("SELECT  TOP ".$part->showTedad."  star_add_homePart_stuff.priority, star_group.id as groupId,star_group.title FROM NewStarfood.dbo.star_group INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON star_group.id=star_add_homePart_stuff.firstGroupId WHERE star_add_homePart_stuff.homepartId=".$part->partId." order by priority asc");
                $part->allGroups=$allGroups;
            }
            if($part->partType == 12){
                //در صورتیکه برند باشد
                $allBrands=DB::select("SELECT star_add_homePart_stuff.brandId,star_add_homePart_stuff.homePartId FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homePartId=".$part->partId." order by priority asc");
                $part->allBrands=$allBrands;
            }
            if($part->partType == 13){
                //لیستی از پیش خرید ها
                $partId=$part->partId;
                $allKalas=DB::select("SELECT TOP 10 *,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,CRM.dbo.getGoodExistance(GoodSn,1402,23)Amount,(CRM.dbo.getGoodExistance(GoodSn,1402,23)/NewStarfood.dbo.getAmountUnit(GoodSn))PackAmount,NewStarfood.dbo.getFirstUnit(GoodSn) firstUnit,NewStarfood.dbo.getSecondUnit(GoodSn) secondUnit FROM (select * from(
                                        SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                                        star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                                        JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                                        JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                                        JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                                        JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                                        JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                                        WHERE star_add_homePart_stuff.homepartId=$partId
                                        AND star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a              
                                        JOIN (SELECT min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id )c
                                        LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerId and orderStatus=0)f on f.SnGood=c.GoodSn
                                        LEFT JOIN (SELECT  SnOrderPishKharid,star_pishKharidOrder.SnOrderBYSPishKharid,SnGood,Amount as PishKharidAmount,PackAmount as pishKharidPackAmount FROM NewStarfood.dbo.star_pishKharidFactor inner join NewStarfood.dbo.star_pishKharidOrder on star_pishKharidFactor.SnOrderPishKharid=SnHDS where CustomerSn=$customerId and orderStatus=0)g on g.SnGood=c.GoodSn order by priority asc");

                $part->allKalas=$allKalas;
            }
            if($part->partType == 2){
                //لیستی از کالاها
                $partId=$part->partId;
                $allKalas=DB::select("SELECT TOP 10 *,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,CRM.dbo.getGoodExistance(GoodSn,1402,23)Amount,(CRM.dbo.getGoodExistance(GoodSn,1402,23)/NewStarfood.dbo.getAmountUnit(GoodSn))PackAmount,NewStarfood.dbo.getFirstUnit(GoodSn) firstUnit,NewStarfood.dbo.getSecondUnit(GoodSn) secondUnit FROM (select * from(
                    SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                    star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                    JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                    JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                    JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                    JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                    WHERE star_add_homePart_stuff.homepartId=$partId
                    and star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a              
                    JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id )c
                    LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerId and orderStatus=0)f on f.SnGood=c.GoodSn order by priority asc");
                $part->allKalas=$allKalas;
            }

            if($part->partType == 11){
                //شگفت انگیزها'
                $partId=$part->partId;
                $allKalas=DB::select("SELECT TOP 10 *,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,CRM.dbo.getGoodExistance(GoodSn,1402,23)Amount,(CRM.dbo.getGoodExistance(GoodSn,1402,23)/NewStarfood.dbo.getAmountUnit(GoodSn))PackAmount,NewStarfood.dbo.getFirstUnit(GoodSn) firstUnit,NewStarfood.dbo.getSecondUnit(GoodSn) secondUnit FROM (select * from(
                    SELECT  star_add_homePart_stuff.priority,GoodGroups.GoodGroupSn,UName,
                    star_add_homePart_stuff.productId,PubGoods.GoodName,PubGoods.GoodSn,GoodPriceSale.Price4,GoodPriceSale.Price3,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.callOnSale FROM Shop.dbo.PubGoods
                    JOIN NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
                    JOIN Shop.dbo.GoodPriceSale on star_add_homePart_stuff.productId=GoodPriceSale.SnGood
                    JOIN Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn
                    JOIN Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=PubGoods.defaultUnit
                    JOIN NewStarfood.dbo.star_GoodsSaleRestriction on PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
                    WHERE star_add_homePart_stuff.homepartId=$partId
                    and star_add_homePart_stuff.productId not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) )a              
                    JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)b on a.productId=b.product_id )c
                    LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerId and orderStatus=0)f on f.SnGood=c.GoodSn order by priority asc");
                $part->allKalas=$allKalas;                
            }
            if($part->partType == 6){
                //تک عکسی و لیستی از کالاها
                $partId=$part->partId;
                $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                foreach ($pictures as $pic) {
                    $countPicKala=0;
                    $disabled="";
                    $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    $pic->countPicKala=$countPicKala;
                }
                $part->pictures=$pictures;
            }
            if($part->partType == 7){
                //دوعکسی و لیستی از کالاها
                $partId=$part->partId;
                $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                $i=0;
                foreach ($pictures as $pic) {
                    $countPicKala=0;
                    $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    $pic->countPicKala=$countPicKala;
                    }
                $part->pictures=$pictures;
            }
            if($part->partType == 8){
                //سه عکسی و لیستی از کالاها
                $partId=$part->partId; 
                $pictures=DB::select("SELECT * FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                foreach ($pictures as $pic) {
                    $countPicKala=0;
                    $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    $pic->countPicKala=$countPicKala;
                }
                $part->pictures=$pictures;
            }
            if($part->partType == 9){
                //چهار عکسی و لیستی از کالاها
                $partId=$part->partId;
                $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                foreach ($pictures as $pic) {
                    $countPicKala=0;
                    $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    $pic->countPicKala=$countPicKala;
                }
                $part->pictures=$pictures;
            }
            if($part->partType == 10){
                //پنج عکسی و لیستی از کالاها
                $partId=$part->partId;
                $pictures=DB::select("select * from NewStarfood.dbo.star_homepart_pictures where homepartId=".$partId);
                foreach ($pictures as $pic) {
                    $countPicKala=0;
                    $countPicKala = DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where("partPic",$pic->id)->count();
                    $pic->countPicKala=$countPicKala;
                }
                $part->pictures=$pictures;
            }
        }
        $showEnamad=0;
        $showEnamad=$webSettings[0]->enamad;
		$attractions=DB::select("SELECT  *,CONVERT(DATE,ViewDate) AS ViewJustDate FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerId");
        
        return Response::json(['parts'=>$parts,'showEnamad'=>$showEnamad]);
    }

    public function controlMainPage(Request $request){
        $parts=DB::select('SELECT * FROM NewStarfood.dbo.HomePart ORDER BY priority ASC');
        $specialSettings=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting");
        $settings=[];
        foreach ($specialSettings as $setting) {
            $settings=$setting;
        }
        $stocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock 
							FROM Shop.dbo.Stocks where SnStock!=0 and NameStock!='' and CompanyNo=5");
        $addedStocks=DB::table("NewStarfood.dbo.addedStocks")->join("Shop.dbo.Stocks","addedStocks.stockId","=","SnStock")->select("*")->get();
        $regions=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and SnMNM>82 and FatherMNM=80");
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and Rectype=1 and FatherMNM=79");

        // کیوری مربوط به تنظیمات امتیازها 
        $targets=DB::table("NewStarfood.dbo.star_customer_baseBonus")->get();
        $lotteryPrizes=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
        $nazarSanjies=DB::table("NewStarfood.dbo.star_nazarsanji")->join("NewStarfood.dbo.star_question","nazarId","=","star_nazarsanji.id")->get();
        $lotteryMinBonus=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting")[0]->lotteryMinBonus;
        $smsModels=DB::table("NewStarfood.dbo.star_SMSModel")->get();
        return view('home.controlMainPage',['parts'=>$parts,'smsModels'=>$smsModels,
					'settings'=>$settings,'stocks'=>$stocks,'addedStocks'=>$addedStocks,
					'regions'=>$regions,'cities'=>$cities,'targets'=>$targets,
					'prizes'=>$lotteryPrizes,'nazars'=>$nazarSanjies,
					'lotteryMinBonus'=>$lotteryMinBonus]);
    }

    public function addNewPart(Request $request) {
        return view('home.addPart');
    }

    public function getPartType(Request $request){
        $partTypes=DB::select("SELECT * FROM NewStarfood.dbo.star_HomePart_Type");
        return Response::json($partTypes);
    }

    public function showEditPartsForm(Request $request) {
        $partType=$request->post('partType');
        $partId=$request->post('partId');
        $title=$request->post('title');
        $parts=DB::select('select textLogo,textFontSize,textColor, HomePart.activeOrNot,HomePart.showPercentTakhfif,HomePart.showAll,HomePart.partColor,HomePart.showOverLine,HomePart.showTedad,HomePart.id as partId,priority,HomePart.title as partTitle,star_HomePart_Type.id as partType,star_HomePart_Type.name from NewStarfood.dbo.star_HomePart_Type inner join NewStarfood.dbo.HomePart on HomePart.partType=star_HomePart_Type.id where HomePart.id='.$partId);
        $countParts=DB::select("select count(id) as countPart from NewStarfood.dbo.HomePart");
        $countHomeParts=0;
        foreach ($countParts as $countPart) {
            $countHomeParts=$countPart->countPart;
        }
        if($partType==1){
            //گروهی
            $addedGroups=DB::select('SELECT star_group.id as groupId,star_group.title as groupTitle ,star_add_homePart_stuff.homepartId,star_add_homePart_stuff.priority from NewStarfood.dbo.star_group inner join NewStarfood.dbo.star_add_homePart_stuff on star_group.id=star_add_homePart_stuff.firstGroupId where homepartId='.$partId.' ORDER BY priority asc');
            $mainGroups=DB::select('SELECT id,title from NewStarfood.dbo.star_group where selfGroupId=0');
            return view('home.editGroupParts',['title'=>$title,'parts'=>$parts,'addedGroups'=>$addedGroups,'groups'=>$mainGroups,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==2){
            //کالایی
            $addedKalas=DB::select('SELECT GoodName,GoodSn,star_add_homePart_stuff.* FROM Shop.dbo.PubGoods inner join NewStarfood.dbo.star_add_homePart_stuff on star_add_homePart_stuff.productId=PubGoods.GoodSn where homepartId='.$partId.' ORDER BY priority asc');
            $allKalas=DB::select('SELECT * FROM Shop.dbo.PubGoods where CompanyNo=5 and GoodSn!=0');
            return view('home.editKalaPart',['title'=>$title,'parts'=>$parts,'addKalas'=>$addedKalas,'kalas'=>$allKalas,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==13){
            //پیش خرید
            $addedKalas=DB::select('SELECT GoodName,GoodSn,star_add_homePart_stuff.* FROM Shop.dbo.PubGoods inner join NewStarfood.dbo.star_add_homePart_stuff on star_add_homePart_stuff.productId=PubGoods.GoodSn where homepartId='.$partId.' ORDER BY priority asc');
            $allKalas=DB::table("Shop.dbo.PubGoods")->JOIN("NewStarfood.dbo.star_GoodsSaleRestriction","productId","=","GoodSn")->where("activePishKharid",1)->select("GoodSn","GoodName")->get();
            return view('home.editKalaPart',['title'=>$title,'parts'=>$parts,'addKalas'=>$addedKalas,'kalas'=>$allKalas,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==11){
            //شگفت انگیز
            $addedKalas=DB::select('SELECT GoodName,GoodSn,star_add_homePart_stuff.* FROM Shop.dbo.PubGoods inner join NewStarfood.dbo.star_add_homePart_stuff on star_add_homePart_stuff.productId=PubGoods.GoodSn where homepartId='.$partId.' ORDER BY priority asc');
            $allKalas=DB::select('SELECT * FROM Shop.dbo.PubGoods where CompanyNo=5 and GoodSn!=0');
            return view('home.editKalaPart',['title'=>$title,'parts'=>$parts,'addKalas'=>$addedKalas,'kalas'=>$allKalas,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==12){
            //برند
            $addedBrands=DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff JOIN NewStarfood.dbo.star_brands ON  star_add_homePart_stuff.brandId=star_brands.id WHERE homePartId=".$partId." order by priority asc");
            $brands=DB::select("SELECT * FROM NewStarfood.dbo.star_brands where star_brands.id not in(select brandId from NewStarfood.dbo.star_add_homePart_stuff where homePartId=".$partId.")");
            return view('home.editPicturesPart',['brands'=>$brands,'addedBrands'=>$addedBrands,'title'=>$title,'parts'=>$parts,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==3 or $partType==4){
            //سلایدر ها
            $allPics=DB::select("SELECT NewStarfood.dbo.star_add_homePart_stuff.id as id,firstPic,secondPic,thirdPic,fourthPic,fifthPic,HomePart.partType FROM NewStarfood.dbo.star_add_homePart_stuff JOIN HomePart ON NewStarfood.dbo.star_add_homePart_stuff.homepartId=HomePart.id WHERE homepartId=".$partId);
            return view('home.editSliders',['title'=>$title,'parts'=>$parts,'picture'=>$allPics,'countHomeParts'=>$countHomeParts]);
        }
        if($partType==6 or $partType==7 or $partType==8 or $partType==9 or $partType==10){
            //تصاویر تکی و چند گانه
            $pictures=DB::select("SELECT HomePart.partType,HomePart.id AS partId,HomePart.title AS partTitle,star_homepart_pictures.id AS picId FROM HomePart INNER JOIN NewStarfood.dbo.star_homepart_pictures ON HomePart.id=star_homepart_pictures.homepartId WHERE HomePart.id=".$partId);
            return view('home.editPicturesPart',['title'=>$title,'parts'=>$parts,'pictures'=>$pictures,'countHomeParts'=>$countHomeParts]);
        }
    }
    

    public function updatePart(Request $request){
        $title=$request->post('partTitle');
        $priority=$request->post('partPriority');
        $partId=$request->post('partId');
        $partType=$request->post('partType');
        $activeOrNot=$request->post('activeOrNot');
        if($activeOrNot){
            $activeOrNot=1;
        }else{
            $activeOrNot=0;
        }

        if($partType==11 or $partType==2 or $partType==1 or $partType==13){
            //کالایی و شگفت انگیز باشد
        $showAll=$request->post('showAll');
        $showOverLine=$request->post('showOverLine');
        $showPercentTakhfif=$request->post('showPercentTakhfif');
        $showTedad=$request->post('showTedad');
        if($partType==1){
            $showTedad=30;
        }
        if($showAll){
            $showAll=1;
        }else{
            $showAll=0;
        }
        if($showPercentTakhfif){
            $showPercentTakhfif=1;
            $showOverLine=1;
        }else{
            $showPercentTakhfif=0;
        }
        if($showOverLine){
            $showOverLine=1;
        }else{
            $showOverLine=0;
        }
        if($partType==11){
            $shegeftColor=$request->post("shegeftColor");
            $shegeftPicture=$request->file("shegeftPicture");
			$shegeftTextColor=$request->post("shegeftTextColor");
			$shegeftTextFontSize=$request->post("shegeftTextFontSize");
			$shegeftText=$request->post("shegeftText");
            DB::update("UPDATE NewStarfood.dbo.HomePart SET title='".$title."',showAll=".$showAll.",showOverLine=".$showOverLine.",
			showTedad=".$showTedad.",activeOrNot=".$activeOrNot.",partColor='".$shegeftColor."',showPercentTakhfif=".$showPercentTakhfif.",
			textColor='$shegeftTextColor',textLogo='$shegeftText',textFontSize=$shegeftTextFontSize
			WHERE id=".$partId);
            $filename;
            if($shegeftPicture){
                $filename=$shegeftPicture->getClientOriginalName();
                $filename=$partId.'.jpg';
                $shegeftPicture->move("resources/assets/images/shegeftAngesPicture/",$filename);
            }
        }else{
            DB::update("UPDATE NewStarfood.dbo.HomePart SET title='".$title."',showAll=".$showAll.",showOverLine=".$showOverLine.",showTedad=".$showTedad.",activeOrNot=".$activeOrNot.",showPercentTakhfif=".$showPercentTakhfif." WHERE id=".$partId);
        }
    }else{
        DB::update("UPDATE NewStarfood.dbo.HomePart SET title='".$title."',activeOrNot=".$activeOrNot." WHERE id=".$partId);

    }
        $priorities=DB::select('SELECT priority FROM NewStarfood.dbo.HomePart where id='.$partId);
        $lastPriority=0;
        foreach ($priorities as $pr) {
            $lastPriority=$pr->priority;
        }
        DB::update("UPDATE NewStarfood.dbo.HomePart SET priority=".$lastPriority." WHERE priority=".$priority." AND id !=".$partId);
        DB::update("UPDATE NewStarfood.dbo.HomePart SET priority=".$priority." WHERE id =".$partId);

        if($partType==1){
            //در صورتیکه لیستی از گروه ها باشد
            $addableGroups=$request->post("groupIds");
            $removableGroups=$request->post('removable');
            if($addableGroups){
                //add groups to homepart
                foreach ($addableGroups as $group) {
                    $groupId=$group;
                    $countGroups=DB::select("SELECT COUNT(id) AS cntGr FROM NewStarfood.dbo.star_add_homePart_stuff where homepartId=".$partId);
                    $countGroup=0;
                    foreach ($countGroups as $cntg) {
                        $countGroup=$cntg->cntGr;
                    }
                    if($countGroup>0){
                        $priorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                        $maxPriority=0;
                        foreach ($priorities as $pr) {
                            $maxPriority=$pr->mxp;
                        }
                        $maxPriority=$maxPriority+1;
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,firstGroupId,priority) VALUES(".$partId.",".$groupId.",".$maxPriority.")") ;
                    }else{
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,firstGroupId,priority) VALUES(".$partId.",".$groupId.",1)") ;
                    }
                }
            }
            if($removableGroups){
                foreach ($removableGroups as $rmGr) {
                    list($mGrId,$title)=explode('_',$rmGr);
                    $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId." and firstGroupId=".$mGrId);
                    $lastPriority=0;
                    foreach ($priorities as $pr) {
                        $lastPriority=$pr->priority;
                    }
                    DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority -=1 WHERE priority>".$lastPriority);
                    DB::delete("DELETE FROM NewStarfood.dbo.star_add_homePart_stuff WHERE firstGroupId=".$mGrId." AND homepartId=".$partId);
                }
            }
        }

        if($partType==11){
            //در صورتیکه شگفت انگیزها' باشد
            $addableKalas=$request->post("addedKala");
            $removableKalas=$request->post('removable');
        }

        if($partType==12){
            $addableBrands=$request->post("addedKalaTobrandList");
            $removeableBrands=$request->post("removeKalaFromBrandList");
            if($addableBrands){
                foreach ($addableBrands as $ka) {
                    list($brandId,$title)=explode('_',$ka);
                    $countKalas=DB::select("SELECT COUNT(id) as cnt FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                    $cntKa=0;
                    foreach ($countKalas as $cntkl) {
                        $cntKa=$cntkl->cnt;
                    }
                    if($cntKa>0){
                                $maxPriority=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                                $maxPr=0;
                                foreach ($maxPriority as $mxp) {
                                    $maxPr=$mxp->mxp;
                                }
                                $maxPr=$maxPr+1;
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,brandId,priority)  VALUES(".$partId.",".$brandId.",".$maxPr.")");
                    }else{
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,brandId,priority)  VALUES(".$partId.",".$brandId.",1)");
                    }
                }
            }
            if($removeableBrands){
                foreach ($removeableBrands as $ka) {
                    $brandId=$ka;
                    $countKalas=DB::select("SELECT COUNT(id) as cnt FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                    $cntKa=0;
                    foreach ($countKalas as $cntkl) {
                        $cntKa=$cntkl->cnt;
                    }
                    if($cntKa>0){
                                $priority=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE brandId=$brandId and  homepartId=".$partId);
                                $pr=0;
                                foreach ($priority as $prio) {
                                    $pr=$prio->priority;
                                }
                                
                                DB::update("update  NewStarfood.dbo.star_add_homePart_stuff set priority-=1  WHERE brandId!=$brandId and priority>=$pr and  homepartId=".$partId);
                                DB::delete("DELETE FROM  NewStarfood.dbo.star_add_homePart_stuff WHERE brandId=$brandId");
                    }else{
                        DB::delete("DELETE FROM  NewStarfood.dbo.star_add_homePart_stuff WHERE brandId=$brandId");
                    }
                }
            }
        }

        if($partType==2){
            //در صورتیکه لیستی از کالاها باشد
            $addableKalas=$request->post("addedKala");
            $removableKalas=$request->post('removable');
        }

        if($partType==13){
            //در صورتیکه لیستی از پیش خرید ها باشد
            $addableKalas=$request->post("addedKala");
            $removableKalas=$request->post('removable');
        }

        if($partType==3){
            $picture1=$request->file('slider1');
            $picture2=$request->file('slider2');
            $picture3=$request->file('slider3');
            $picture4=$request->file('slider4');
            $picture5=$request->file('slider5');
            $filename1;
            $filename2;
            $filename3;
            $filename4;
            $filename5;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/mainSlider/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/mainSlider/",$filename2);
                            }
            if($picture3){
                $filename3=$picture3->getClientOriginalName();
                $filename3=$partId.'_3.'.'jpg';
                $picture3->move("resources/assets/images/mainSlider/",$filename3);
                            }
            if($picture4){
                $filename4=$picture4->getClientOriginalName();
                $filename4=$partId.'_4.'.'jpg';
                $picture4->move("resources/assets/images/mainSlider/",$filename4);
                            }
            if($picture5){
                $filename5=$picture5->getClientOriginalName();
                $filename5=$partId.'_5.'.'jpg';
                $picture5->move("resources/assets/images/mainSlider/",$filename5);
                            }
        }

        if($partType==4){
            $picture1=$request->file('slider1');
            $picture2=$request->file('slider2');
            $filename1;
            $filename2;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/smallSlider/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/smallSlider/",$filename2);
                            }
        }

        if($partType==6){
            //در صورتیکه بخش تک عکسی باشند
            $data = array( );
            $pictures=array();
            $kalas=array();
            $firstPic=$request->post('pic1');
            $picture1=$request->file('editPic1');
            $filename1;
            if($picture1){
            $filename1=$picture1->getClientOriginalName();
            $filename1=$partId.'.jpg';
            $picture1->move("resources/assets/images/onePic/",$filename1);
                        }
            $kalaList1=$request->post('onePicAddedKalaListIds1');
            $removableKalaList1=$request->post('removableOnePic1');
            if($firstPic){
                $pictures[]=$firstPic;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                }
                if($kalaList){
                    foreach ($kalaList as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $countKala=DB::select("SELECT COUNT(id) AS countKala FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                        $countedKala=0;
                        foreach ($countKala as $cntkl) {
                            $countedKala=$cntkl->countKala;
                        }
                        if($countedKala>0){
                            $priorities=DB::select("SELECT MAX(priority) AS mxpr FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                            $maxPriority=0;
                            foreach ($priorities as $pr) {
                                $maxPriority=$pr->mxpr;
                            }
                            $maxPriority=$maxPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",".$maxPriority.",".$pic.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",1,".$pic.")");
                        }
                    }
                }
                if($removableKalaList1){
                    foreach ($removableKalaList1 as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $lastPriority=0;
                        $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                        foreach ($priorities as $pr) {
                            $lastPriority=$pr->priority;
                        }
                        DB::update("UPDATE NewStarfood.dbo.star_add_homepart_stuff SET priority-=1 WHERE partPic=".$pic." AND priority>".$lastPriority);
                        DB::delete("DELETE FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                    }
                }
            }
        }
        if($partType==7){
            //در صورتیکه دو عکسه باشند
            $data = array( );
            $pictures=array();
            $kalas=array();
            $firstPic=$request->post('pic1');
            $secondPic=$request->post('pic2');
            $kalaList1=$request->post('twoPicAddableKalaList1');
            $kalaList2=$request->post('twoPicAddableKalaList2');
            $removableKalaList1=$request->post('removable2Pic1');
            $removableKalaList2=$request->post('removable2Pic2');
            $picture1=$request->file('editPic1');
            $picture2=$request->file('editPic2');
            $filename1;
            $filename2;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/twoPics/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/twoPics/",$filename2);
                            }
            if($firstPic){
                $pictures[]=$firstPic;
            }
            if($secondPic){
                $pictures[]=$secondPic;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $remvableList=$removableKalaList1;
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $remvableList=$removableKalaList2;
                }
                if($kalaList){
                    foreach ($kalaList as $kala) {
                        $countKala=DB::select("SELECT COUNT(id) AS countKala FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                        $countedKala=0;
                        foreach ($countKala as $cntkl) {
                            $countedKala=$cntkl->countKala;
                        }
                        if($countedKala>0){
                            $priorities=DB::select("SELECT MAX(priority) AS mxpr FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                            $maxPriority=0;
                            foreach ($priorities as $pr) {
                                $maxPriority=$pr->mxpr;
                            }
                            $maxPriority=$maxPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",".$maxPriority.",".$pic.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",1,".$pic.")");
                        }
                    }
                }
                if($remvableList){
                    foreach ($remvableList as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $lastPriority=0;
                        $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                        foreach ($priorities as $pr) {
                            $lastPriority=$pr->priority;
                        }
                        DB::update("UPDATE NewStarfood.dbo.star_add_homepart_stuff SET priority-=1 WHERE partPic=".$pic." AND priority>".$lastPriority);
                        DB::delete("DELETE FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                    }
                }
            }
        }
        if($partType==8){

            //در صورتیکه سه عکسه باشند
            $data = array( );
            $pictures=array();
            $kalas=array();
            $firstPic=$request->post('pic1');
            $secondPic=$request->post('pic2');
            $thirdPic=$request->post('pic3');
            $kalaList1=$request->post('threePicAddableKalaList1');
            $kalaList2=$request->post('threePicAddableKalaList2');
            $kalaList3=$request->post('threePicAddableKalaList3');
            $removableKalaList1=$request->post('removable3Pic1');
            $removableKalaList2=$request->post('removable3Pic2');
            $removableKalaList3=$request->post('removable3Pic3');
            $picture1=$request->file('editPic1');
            $picture2=$request->file('editPic2');
            $picture3=$request->file('editPic3');
            $filename1;
            $filename2;
            $filename3;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/threePics/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/threePics/",$filename2);
                            }
            if($picture3){
                $filename3=$picture3->getClientOriginalName();
                $filename3=$partId.'_3.'.'jpg';
                $picture3->move("resources/assets/images/threePics/",$filename3);
                            }
            if($firstPic){
                $pictures[]=$firstPic;
            }
            if($secondPic){
                $pictures[]=$secondPic;
            }
            if($thirdPic){
                $pictures[]=$thirdPic;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $remvableList=$removableKalaList1;
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $remvableList=$removableKalaList2;
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $remvableList=$removableKalaList3;
                }
                if($kalaList){
                    foreach ($kalaList as $kala) {
                        $countKala=DB::select("SELECT COUNT(id) AS countKala FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                        $countedKala=0;
                        foreach ($countKala as $cntkl) {
                            $countedKala=$cntkl->countKala;
                        }
                        if($countedKala>0){
                            $priorities=DB::select("SELECT MAX(priority) AS mxpr FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                            $maxPriority=0;
                            foreach ($priorities as $pr) {
                                $maxPriority=$pr->mxpr;
                            }
                            $maxPriority=$maxPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",".$maxPriority.",".$pic.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",1,".$pic.")");
                        }
                    }
                }
                if($remvableList){
                    foreach ($remvableList as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $lastPriority=0;
                        $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                        foreach ($priorities as $pr) {
                            $lastPriority=$pr->priority;
                        }
                        DB::update("UPDATE NewStarfood.dbo.star_add_homepart_stuff SET priority-=1 WHERE partPic=".$pic." AND priority>".$lastPriority);
                        DB::delete("DELETE FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                    }
                }
            }
        }
        if($partType==9){
            //در صورتیکه چهار عکسه باشند
            $data = array();
            $pictures=array();
            $kalas=array();
            $firstPic=$request->post('pic1');
            $secondPic=$request->post('pic2');
            $thirdPic=$request->post('pic3');
            $fourthPic=$request->post('pic4');
            $kalaList1=$request->post('fourPicAddableKalaList1');
            $kalaList2=$request->post('fourPicAddableKalaList2');
            $kalaList3=$request->post('fourPicAddableKalaList3');
            $kalaList4=$request->post('fourPicAddableKalaList4');
            $removableKalaList1=$request->post('removable4Pic1');
            $removableKalaList2=$request->post('removable4Pic2');
            $removableKalaList3=$request->post('removable4Pic3');
            $removableKalaList4=$request->post('removable4Pic4');
            $picture1=$request->file('editPic1');
            $picture2=$request->file('editPic2');
            $picture3=$request->file('editPic3');
            $picture4=$request->file('editPic4');
            $filename1;
            $filename2;
            $filename3;
            $filename4;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/fourPics/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/fourPics/",$filename2);
                            }
            if($picture3){
                $filename3=$picture3->getClientOriginalName();
                $filename3=$partId.'_3.'.'jpg';
                $picture3->move("resources/assets/images/fourPics/",$filename3);
                            }
            if($picture4){
                $filename4=$picture4->getClientOriginalName();
                $filename4=$partId.'_4.'.'jpg';
                $picture4->move("resources/assets/images/fourPics/",$filename4);
                            }
            if($firstPic){
                $pictures[]=$firstPic;
            }
            if($secondPic){
                $pictures[]=$secondPic;
            }
            if($thirdPic){
                $pictures[]=$thirdPic;
            }
            if($fourthPic){
                $pictures[]=$fourthPic;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $remvableList=$removableKalaList1;
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $remvableList=$removableKalaList2;
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $remvableList=$removableKalaList3;
                }
                if($pictureCounter==4){
                    $kalaList=$kalaList4;
                    $remvableList=$removableKalaList4;
                }
                if($kalaList){
                    foreach ($kalaList as $kala) {
                        $countKala=DB::select("SELECT COUNT(id) AS countKala FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                        $countedKala=0;
                        foreach ($countKala as $cntkl) {
                            $countedKala=$cntkl->countKala;
                        }
                        if($countedKala>0){
                            $priorities=DB::select("SELECT MAX(priority) AS mxpr FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                            $maxPriority=0;
                            foreach ($priorities as $pr) {
                                $maxPriority=$pr->mxpr;
                            }
                            $maxPriority=$maxPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",".$maxPriority.",".$pic.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",1,".$pic.")");
                        }
                    }
                }
                if($remvableList){
                    foreach ($remvableList as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $lastPriority=0;
                        $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                        foreach ($priorities as $pr) {
                            $lastPriority=$pr->priority;
                        }
                        DB::update("UPDATE NewStarfood.dbo.star_add_homepart_stuff SET priority-=1 WHERE partPic=".$pic." AND priority>".$lastPriority);
                        DB::delete("DELETE FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                    }
                }
            }
        }
        if($partType==10){
            //در صورتیکه پنج عکسه باشند
            $data = array( );
            $pictures=array();
            $kalas=array();
            $firstPic=$request->post('pic1');
            $secondPic=$request->post('pic2');
            $thirdPic=$request->post('pic3');
            $fourthPic=$request->post('pic4');
            $fifthPic=$request->post('pic5');
            $kalaList1=$request->post('fivePicAddableKalaList1');
            $kalaList2=$request->post('fivePicAddableKalaList2');
            $kalaList3=$request->post('fivePicAddableKalaList3');
            $kalaList4=$request->post('fivePicAddableKalaList4');
            $kalaList5=$request->post('fivePicAddableKalaList5');
            $removableKalaList1=$request->post('removable5Pic1');
            $removableKalaList2=$request->post('removable5Pic2');
            $removableKalaList3=$request->post('removable5Pic3');
            $removableKalaList4=$request->post('removable5Pic4');
            $removableKalaList5=$request->post('removable5Pic5');
            $picture1=$request->file('editPic1');
            $picture2=$request->file('editPic2');
            $picture3=$request->file('editPic3');
            $picture4=$request->file('editPic4');
            $picture5=$request->file('editPic5');
            $filename1;
            $filename2;
            $filename3;
            $filename4;
            $filename5;
            if($picture1){
                $filename1=$picture1->getClientOriginalName();
                $filename1=$partId.'_1.'.'jpg';
                $picture1->move("resources/assets/images/fivePics/",$filename1);
                            }
            if($picture2){
                $filename2=$picture2->getClientOriginalName();
                $filename2=$partId.'_2.'.'jpg';
                $picture2->move("resources/assets/images/fivePics/",$filename2);
                            }
            if($picture3){
                $filename3=$picture3->getClientOriginalName();
                $filename3=$partId.'_3.'.'jpg';
                $picture3->move("resources/assets/images/fivePics/",$filename3);
                            }
            if($picture4){
                $filename4=$picture4->getClientOriginalName();
                $filename4=$partId.'_4.'.'jpg';
                $picture4->move("resources/assets/images/fivePics/",$filename4);
                            }
            if($picture5){
                $filename5=$picture5->getClientOriginalName();
                $filename5=$partId.'_5.'.'jpg';
                $picture5->move("resources/assets/images/fivePics/",$filename5);
                            }
            if($firstPic){
                $pictures[]=$firstPic;
            }
            if($secondPic){
                $pictures[]=$secondPic;
            }
            if($thirdPic){
                $pictures[]=$thirdPic;
            }
            if($fourthPic){
                $pictures[]=$fourthPic;
            }
            if($fifthPic){
                $pictures[]=$fifthPic;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $remvableList=$removableKalaList1;
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $remvableList=$removableKalaList2;
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $remvableList=$removableKalaList3;
                }
                if($pictureCounter==4){
                    $kalaList=$kalaList4;
                    $remvableList=$removableKalaList4;
                }
                if($pictureCounter==5){
                    $kalaList=$kalaList5;
                    $remvableList=$removableKalaList5;
                }
                if($kalaList){
                    foreach ($kalaList as $kala) {
                        $countKala=DB::select("SELECT COUNT(id) AS countKala FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                        $countedKala=0;
                        foreach ($countKala as $cntkl) {
                            $countedKala=$cntkl->countKala;
                        }
                        if($countedKala>0){
                            $priorities=DB::select("SELECT MAX(priority) AS mxpr FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic);
                            $maxPriority=0;
                            foreach ($priorities as $pr) {
                                $maxPriority=$pr->mxpr;
                            }
                            $maxPriority=$maxPriority+1;
                            DB::insert("INSERT INTO star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",".$maxPriority.",".$pic.")");
                        }else{
                            DB::insert("INSERT INTO star_add_homepart_stuff(productId,priority,partPic) VALUES(".$kala.",1,".$pic.")");
                        }
                    }
                }
                if($remvableList){
                    foreach ($remvableList as $kala) {
                        list($kala,$title)=explode('_',$kala);
                        $lastPriority=0;
                        $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                        foreach ($priorities as $pr) {
                            $lastPriority=$pr->priority;
                        }
                        DB::update("UPDATE NewStarfood.dbo.star_add_homepart_stuff SET priority-=1 WHERE partPic=".$pic." AND priority>".$lastPriority);
                        DB::delete("DELETE FROM NewStarfood.dbo.star_add_homepart_stuff WHERE partPic=".$pic." AND productId=".$kala);
                    }
                }
            }
        }
        return redirect("/controlMainPage");
    }
    public function addPart(Request $request)
    {
       $title=$request->post('partTitle');
       $priority=$request->post('priority');
       $partType=$request->post('partType');
       $firstPic=$request->file("firstPic");
       $secondPic=$request->file("secondPic");
       $thirdPic=$request->file("thirdPic");
       $fourthPic=$request->file("fourthPic");
       $fifthPic=$request->file("fifthPic");
       $addableKalas=$request->post("addedKala");
       $addableGroups=$request->post("addedGroup");
       $addableBrands=$request->post("addedKalaToBrandItem");
    //    if($partType==12){
    //        return $request->file('brandPic2')->getClientOriginalName();
    //    }
       if($partType==11 or $partType==2 or $partType==13){
           //اگر کالایی یا شگفت انگیز بود
        $showAll=$request->post('showAll');
        $showOverLine=$request->post('showOverLine');
        $showTedad=$request->post('showTedad');
        DB::update("UPDATE NewStarfood.dbo.homepart SET priority+=1 WHERE priority>=".$priority);
        if($showAll){
            $showAll=1;
        }else{
            $showAll=0;
        }
        if($showOverLine){
            $showOverLine=1;
        }else{
            $showOverLine=0;
        }
        if($partType==11){
            $shegeftColor=$request->post("shegeftColor");
            $shegeftPicture=$request->file("shegeftPicture");
            DB::insert("INSERT INTO NewStarfood.dbo.homepart (title,priority,partType,showAll,showOverLine,showTedad,activeOrNot,partColor) VALUES('".$title."','".$priority."','".$partType."',".$showAll.",".$showOverLine.",".$showTedad.",1,'".$shegeftColor."')") ;
            $partId=DB::table('NewStarfood.dbo.homepart')->where('partType',11)->max('id');
            $filename;
            if($shegeftPicture){
                    $filename=$shegeftPicture->getClientOriginalName();
                    $filename=$partId.'.jpg';
                    $shegeftPicture->move("resources/assets/images/shegeftAngesPicture/",$filename);
            }
        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.homepart (title,priority,partType,showAll,showOverLine,showTedad,activeOrNot) VALUES('".$title."','".$priority."','".$partType."',".$showAll.",".$showOverLine.",".$showTedad.",1)") ;
        }
    }else{
        DB::update("UPDATE NewStarfood.dbo.homepart SET priority+=1 WHERE priority>=".$priority);
        DB::insert("INSERT INTO NewStarfood.dbo.homepart (title,priority,partType,showTedad,activeOrNot) VALUES('".$title."','".$priority."','".$partType."',10,1)") ;

       }
       $maxHomePart=DB::select("SELECT MAX(id) as maxId FROM NewStarfood.dbo.homepart");
       $maxId=0;
       foreach ($maxHomePart as $mxprt) {
           $maxId=$mxprt->maxId;
       }
        $partId=$maxId;
// if it is group type
        if($partType==1){

            if($addableGroups){
//add groups to homepart
                foreach ($addableGroups as $group) {
                    $groupId=$group;
                    $countGroups=DB::select("SELECT COUNT(id) AS cntGr FROM NewStarfood.dbo.star_add_homePart_stuff where homepartId=".$partId);
                    $countGroup=0;
                    foreach ($countGroups as $cntg) {
                        $countGroup=$cntg->cntGr;
                    }
                    if($countGroup>0){
                        $priorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                        $maxPriority=0;
                        foreach ($priorities as $pr) {
                            $maxPriority=$pr->mxp;
                        }
                        $maxPriority=$maxPriority+1;
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,firstGroupId,priority) VALUES(".$partId.",".$groupId.",".$maxPriority.")") ;
                    }else{
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,firstGroupId,priority) VALUES(".$partId.",".$groupId.",1)") ;
                    }
                }
            }
        }


        //if it is kala type
        if($partType==2){

            if($addableKalas){
//add kala to homepart
                foreach ($addableKalas as $kala) {
                    $kalaId=$kala;
                    $countKalas=DB::select("SELECT COUNT(id) AS cntKl FROM NewStarfood.dbo.star_add_homePart_stuff where homepartId=".$partId);
                    $countKala=0;
                    foreach ($countKalas as $cntk) {
                        $countKala=$cntk->cntKl;
                    }
                    if($countKala>0){
                        $priorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                        $maxPriority=0;
                        foreach ($priorities as $pr) {
                            $maxPriority=$pr->mxp;
                        }
                        $maxPriority=$maxPriority+1;
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",".$maxPriority.")") ;
                    }else{
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",1)") ;
                    }
                }
            }
        }
                //if it is پیش خرید
                if($partType==13){

                    if($addableKalas){
        //add kala to homepart
                        foreach ($addableKalas as $kala) {
                            $kalaId=$kala;
                            $countKalas=DB::select("SELECT COUNT(id) AS cntKl FROM NewStarfood.dbo.star_add_homePart_stuff where homepartId=".$partId);
                            $countKala=0;
                            foreach ($countKalas as $cntk) {
                                $countKala=$cntk->cntKl;
                            }
                            if($countKala>0){
                                $priorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                                $maxPriority=0;
                                foreach ($priorities as $pr) {
                                    $maxPriority=$pr->mxp;
                                }
                                $maxPriority=$maxPriority+1;
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",".$maxPriority.")") ;
                            }else{
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",1)") ;
                            }
                        }
                    }
                }
                //if it is shegeftAngiz type
                if($partType==11){

                    if($addableKalas){
        //add kala to homepart
                        foreach ($addableKalas as $kala) {
                            $kalaId=$kala;
                            $countKalas=DB::select("SELECT COUNT(id) AS cntKl FROM NewStarfood.dbo.star_add_homePart_stuff where homepartId=".$partId);
                            $countKala=0;
                            foreach ($countKalas as $cntk) {
                                $countKala=$cntk->cntKl;
                            }
                            if($countKala>0){
                                $priorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                                $maxPriority=0;
                                foreach ($priorities as $pr) {
                                    $maxPriority=$pr->mxp;
                                }
                                $maxPriority=$maxPriority+1;
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",".$maxPriority.")") ;
                            }else{
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff(homepartId,productId,priority) VALUES(".$partId.",".$kalaId.",1)") ;
                            }
                        }
                    }
                }
        //if it is main slider
        if($partType==3){
            // سلایدر اصلی
        $picture1=$request->file('firstPic');
        $picture2=$request->file('secondPic');
        $picture3=$request->file('thirdPic');
        $picture4=$request->file('fourthPic');
        $picture5=$request->file('fifthPic');
        $filename1=$request->file('firstPic')->getClientOriginalName();
        $filename2=$request->file('secondPic')->getClientOriginalName();
        $filename3=$request->file('thirdPic')->getClientOriginalName();
        $filename4=$request->file('fourthPic')->getClientOriginalName();
        $filename5=$request->file('fifthPic')->getClientOriginalName();
        $filename1=$partId.'_1.'.'jpg';
        $filename2=$partId.'_2.'.'jpg';
        $filename3=$partId.'_3.'.'jpg';
        $filename4=$partId.'_4.'.'jpg';
        $filename5=$partId.'_5.'.'jpg';
        $picture1->move("resources/assets/images/mainSlider/",$filename1);
        $picture2->move("resources/assets/images/mainSlider/",$filename2);
        $picture3->move("resources/assets/images/mainSlider/",$filename3);
        $picture4->move("resources/assets/images/mainSlider/",$filename4);
        $picture5->move("resources/assets/images/mainSlider/",$filename5);
        DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff(homepartId,priority,secondPic,thirdPic,fourthPic,fifthPic,firstPic) VALUES(".$partId.",".$priority.",'".$filename2."','".$filename3."','".$filename4."','".$filename5."','".$filename1."')");
        }
        if($partType==4){
            // سلایدر کوچک
        $picture1=$request->file('firstPic');
        $picture2=$request->file('secondPic');
        $filename1=$request->file('firstPic')->getClientOriginalName();
        $filename2=$request->file('secondPic')->getClientOriginalName();
        $filename1=$partId.'_1.'.'jpg';
        $filename2=$partId.'_2.'.'jpg';
        $picture1->move("resources/assets/images/smallSlider/",$filename1);
        $picture2->move("resources/assets/images/smallSlider/",$filename2);
        DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff(homepartId,priority,secondPic,firstPic) VALUES(".$partId.",".$priority.",'".$filename2."','".$filename1."')");
        }
        if($partType==6){
            // تک عکسی
        $kalaList=$request->post("onePicKalaListIds2");
        $picture1=$request->file('onePic');
        $filename1=$request->file('onePic')->getClientOriginalName();
        $filename1=$partId.'.'.'jpg';
        $picture1->move("resources/assets/images/onePic/",$filename1);
        DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$filename1."',1)");
        $partPic=DB::select("SELECT MAX(id) AS maxpic FROM NewStarfood.dbo.star_homepart_pictures");
        $picId=0;
        foreach ($partPic as $pic) {
            $picId=$pic->maxpic;
        }
        foreach ($kalaList as $kl) {
            $countKalas=DB::select("SELECT COUNT(id) AS cntKl FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$picId);
            $countKl=0;
            foreach ($countKalas as $cntKl) {
                $countKl=$cntKl->cntKl;
            }
            if($countKl>0){
                $maxPriority=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$picId);
                $maxPr=0;
                foreach ($maxPriority as $mxp) {
                    $maxPr=$mxp->mxp;
                }
                $maxPr=$maxPr+1;
                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic)  VALUES(".$kl.",".$maxPr.",".$picId.")");
    }else{
        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic)  VALUES(".$kl.",1,".$picId.")");
    }
        }
        }
        if($partType==7){
            // دو عکسی
            $kalaList1=$request->post('twoPicKalaListIds1');
            $kalaList2=$request->post('twoPicKalaListIds2');
            $picture1=$request->file('firstPic');
            $picture2=$request->file('secondPic');
            $filename1=$request->file('firstPic')->getClientOriginalName();
            $filename2=$request->file('secondPic')->getClientOriginalName();
            $filename1=$partId.'_1.'.'jpg';
            $filename2=$partId.'_2.'.'jpg';
            $data = array( );
            $pictures=array();
            $kalas=array();
            if($filename1){
                $pictures[]=$filename1;
            }
            if($filename2){
                $pictures[]=$filename2;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $picture1->move("resources/assets/images/twoPics/",$pic);
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $picture2->move("resources/assets/images/twoPics/",$pic);
                }
                $countPics=DB::select("SELECT COUNT(id) AS countpic FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                $contPictures=0;
                foreach ($countPics as $contPic) {
                    $contPictures=$contPic->countpic;
                }
                if($contPictures>0){
                    $picPriorities=DB::select("SELECT MAX(priority) AS maxpr FROM NewStarfood.dbo.star_homepart_pictures");
                    $maxPicpr=1;
                    foreach ($picPriorities as $picPr) {
                        $maxPicpr=$picPr->maxpr;
                    }
                    $maxPicpr=$maxPicpr+1;
                    DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',".$maxPicpr.")");
                }else{
                DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',1)");
                }
                if($kalaList){
                    foreach($kalaList as $kalaId){
                        $maxPic=DB::select("SELECT MAX(id) as maxPicId FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                        $maxPicId=0;
                        foreach ($maxPic as $picId) {
                            $maxPicId=$picId->maxPicId;
                        }
                        $countKala=0;
                        $countKalas=DB::select("SELECT COUNT(id) as contkl FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                        foreach ($countKalas as $contKl) {
                            $countKala=$contKl->contkl;
                        }
                        if($countKala>0){
                            $picKalaPriorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                            $maxpKalaPicPriority=1;
                            foreach ($picKalaPriorities as $pr) {
                                $maxpKalaPicPriority=$pr->mxp;
                            }
                            $maxpKalaPicPriority=$maxpKalaPicPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",".$maxpKalaPicPriority.",".$maxPicId.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",1,".$maxPicId.")");
                        }
                    }
                }
            }

        }
        if($partType==8){
            // سه عکسی
            $kalaList1=$request->post('threePicKalaListIds1');
            $kalaList2=$request->post('threePicKalaListIds2');
            $kalaList3=$request->post('threePicKalaListIds3');
            $picture1=$request->file('firstPic');
            $picture2=$request->file('secondPic');
            $picture3=$request->file('thirdPic');
            $filename1=$request->file('firstPic')->getClientOriginalName();
            $filename2=$request->file('secondPic')->getClientOriginalName();
            $filename3=$request->file('thirdPic')->getClientOriginalName();
            $filename1=$partId.'_1.'.'jpg';
            $filename2=$partId.'_2.'.'jpg';
            $filename3=$partId.'_3.'.'jpg';
            $data = array( );
            $pictures=array();
            $kalas=array();
            if($filename1){
                $pictures[]=$filename1;
            }
            if($filename2){
                $pictures[]=$filename2;
            }
            if($filename3){
                $pictures[]=$filename3;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $picture1->move("resources/assets/images/threePics/",$pic);
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $picture2->move("resources/assets/images/threePics/",$pic);
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $picture3->move("resources/assets/images/threePics/",$pic);
                }
                $countPics=DB::select("SELECT COUNT(id) AS countpic FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                $contPictures=0;
                foreach ($countPics as $contPic) {
                    $contPictures=$contPic->countpic;
                }
                if($contPictures>0){
                    $picPriorities=DB::select("SELECT MAX(priority) AS maxpr FROM NewStarfood.dbo.star_homepart_pictures");
                    $maxPicpr=0;
                    foreach ($picPriorities as $picPr) {
                        $maxPicpr=$picPr->maxpr;
                    }
                    $maxPicpr=$maxPicpr+1;
                    DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',".$maxPicpr.")");
                }else{
                DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',1)");
                }
                if($kalaList){
                    foreach($kalaList as $kalaId){
                        $maxPic=DB::select("SELECT MAX(id) as maxPicId FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                        $maxPicId=0;
                        foreach ($maxPic as $picId) {
                            $maxPicId=$picId->maxPicId;
                        }
                        $countKala=0;
                        $countKalas=DB::select("SELECT COUNT(id) as contkl FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                        foreach ($countKalas as $contKl) {
                            $countKala=$contKl->contkl;
                        }
                        if($countKala>0){
                            $picKalaPriorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                            $maxpKalaPicPriority=0;
                            foreach ($picKalaPriorities as $pr) {
                                $maxpKalaPicPriority=$pr->mxp;
                            }
                            $maxpKalaPicPriority=$maxpKalaPicPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",".$maxpKalaPicPriority.",".$maxPicId.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",1,".$maxPicId.")");
                        }
                    }
                }
            }

        }
        if($partType==9){
            // 4 عکسی
            $kalaList1=$request->post('fourPicKalaListIds1');
            $kalaList2=$request->post('fourPicKalaListIds2');
            $kalaList3=$request->post('fourPicKalaListIds3');
            $kalaList4=$request->post('fourPicKalaListIds4');
            $picture1=$request->file('firstPic');
            $picture2=$request->file('secondPic');
            $picture3=$request->file('thirdPic');
            $picture4=$request->file('fourthPic');
            $filename1=$request->file('firstPic')->getClientOriginalName();
            $filename2=$request->file('secondPic')->getClientOriginalName();
            $filename3=$request->file('thirdPic')->getClientOriginalName();
            $filename4=$request->file('fourthPic')->getClientOriginalName();
            $filename1=$partId.'_1.'.'jpg';
            $filename2=$partId.'_2.'.'jpg';
            $filename3=$partId.'_3.'.'jpg';
            $filename4=$partId.'_4.'.'jpg';
            $data = array( );
            $pictures=array();
            $kalas=array();
            if($filename1){
                $pictures[]=$filename1;
            }
            if($filename2){
                $pictures[]=$filename2;
            }
            if($filename3){
                $pictures[]=$filename3;
            }
            if($filename4){
                $pictures[]=$filename4;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $picture1->move("resources/assets/images/fourPics/",$pic);
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $picture2->move("resources/assets/images/fourPics/",$pic);
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $picture3->move("resources/assets/images/fourPics/",$pic);
                }
                if($pictureCounter==4){
                    $kalaList=$kalaList4;
                    $picture4->move("resources/assets/images/fourPics/",$pic);
                }
                $countPics=DB::select("SELECT COUNT(id) AS countpic FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                $contPictures=0;
                foreach ($countPics as $contPic) {
                    $contPictures=$contPic->countpic;
                }
                if($contPictures>0){
                    $picPriorities=DB::select("SELECT MAX(priority) AS maxpr FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                    $maxPicpr=0;
                    foreach ($picPriorities as $picPr) {
                        $maxPicpr=$picPr->maxpr;
                    }
                    $maxPicpr=$maxPicpr+1;
                    DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',".$maxPicpr.")");
                }else{
                DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',1)");
                }
                if($kalaList){
                    foreach($kalaList as $kalaId){
                        $maxPic=DB::select("SELECT MAX(id) as maxPicId FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                        $maxPicId=0;
                        foreach ($maxPic as $picId) {
                            $maxPicId=$picId->maxPicId;
                        }
                        $countKala=0;
                        $countKalas=DB::select("SELECT COUNT(id) as contkl FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                        foreach ($countKalas as $contKl) {
                            $countKala=$contKl->contkl;
                        }
                        if($countKala>0){
                            $picKalaPriorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                            $maxpKalaPicPriority=0;
                            foreach ($picKalaPriorities as $pr) {
                                $maxpKalaPicPriority=$pr->mxp;
                            }
                            $maxpKalaPicPriority=$maxpKalaPicPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",".$maxpKalaPicPriority.",".$maxPicId.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",1,".$maxPicId.")");
                        }
                    }
                }
            }

        }
        if($partType==10){
            // 5 عکسی
            $kalaList1=$request->post('fivePicKalaListIds1');
            $kalaList2=$request->post('fivePicKalaListIds2');
            $kalaList3=$request->post('fivePicKalaListIds3');
            $kalaList4=$request->post('fivePicKalaListIds4');
            $kalaList5=$request->post('fivePicKalaListIds5');
            $picture1=$request->file('firstPic');
            $picture2=$request->file('secondPic');
            $picture3=$request->file('thirdPic');
            $picture4=$request->file('fourthPic');
            $picture5=$request->file('fifthPic');
            $filename1=$request->file('firstPic')->getClientOriginalName();
            $filename2=$request->file('secondPic')->getClientOriginalName();
            $filename3=$request->file('thirdPic')->getClientOriginalName();
            $filename4=$request->file('fourthPic')->getClientOriginalName();
            $filename5=$request->file('fifthPic')->getClientOriginalName();
            $filename1=$partId.'_1.'.'jpg';
            $filename2=$partId.'_2.'.'jpg';
            $filename3=$partId.'_3.'.'jpg';
            $filename4=$partId.'_4.'.'jpg';
            $filename5=$partId.'_5.'.'jpg';
            $data = array( );
            $pictures=array();
            $kalas=array();
            if($filename1){
                $pictures[]=$filename1;
            }
            if($filename2){
                $pictures[]=$filename2;
            }
            if($filename3){
                $pictures[]=$filename3;
            }
            if($filename4){
                $pictures[]=$filename4;
            }
            if($filename5){
                $pictures[]=$filename5;
            }
            $pictureCounter=0;
            foreach ($pictures as $pic) {
                $pictureCounter=$pictureCounter+1;
                $kalaList;
                if($pictureCounter==1){
                    $kalaList=$kalaList1;
                    $picture1->move("resources/assets/images/fivePics/",$pic);
                }
                if($pictureCounter==2){
                    $kalaList=$kalaList2;
                    $picture2->move("resources/assets/images/fivePics/",$pic);
                }
                if($pictureCounter==3){
                    $kalaList=$kalaList3;
                    $picture3->move("resources/assets/images/fivePics/",$pic);
                }
                if($pictureCounter==4){
                    $kalaList=$kalaList4;
                    $picture4->move("resources/assets/images/fivePics/",$pic);
                }
                if($pictureCounter==5){
                    $kalaList=$kalaList5;
                    $picture5->move("resources/assets/images/fivePics/",$pic);
                }
                $countPics=DB::select("SELECT COUNT(id) AS countpic FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                $contPictures=0;
                foreach ($countPics as $contPic) {
                    $contPictures=$contPic->countpic;
                }
                if($contPictures>0){
                    $picPriorities=DB::select("SELECT MAX(priority) AS maxpr FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                    $maxPicpr=0;
                    foreach ($picPriorities as $picPr) {
                        $maxPicpr=$picPr->maxpr;
                    }
                    $maxPicpr=$maxPicpr+1;
                    DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',".$maxPicpr.")");
                }else{
                DB::insert("INSERT INTO NewStarfood.dbo.star_homepart_pictures(homepartId,picName,priority) VALUES(".$partId.",'".$pic."',1)");
                }
                if($kalaList){
                    foreach($kalaList as $kalaId){
                        $maxPic=DB::select("SELECT MAX(id) as maxPicId FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
                        $maxPicId=0;
                        foreach ($maxPic as $picId) {
                            $maxPicId=$picId->maxPicId;
                        }
                        $countKala=0;
                        $countKalas=DB::select("SELECT COUNT(id) as contkl FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                        foreach ($countKalas as $contKl) {
                            $countKala=$contKl->contkl;
                        }
                        if($countKala>0){
                            $picKalaPriorities=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$maxPicId);
                            $maxpKalaPicPriority=0;
                            foreach ($picKalaPriorities as $pr) {
                                $maxpKalaPicPriority=$pr->mxp;
                            }
                            $maxpKalaPicPriority=$maxpKalaPicPriority+1;
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",".$maxpKalaPicPriority.",".$maxPicId.")");
                        }else{
                            DB::insert("INSERT INTO NewStarfood.dbo.star_add_homePart_stuff (productId,priority,partPic) VALUES(".$kalaId.",1,".$maxPicId.")");
                        }
                    }
                }
            }

        }

        if($partType==12){

            if($addableBrands){
                foreach ($addableBrands as $ka) {
                    list($ka,$title)=explode('_',$ka);
                    $countKalas=DB::select("SELECT COUNT(id) as cnt FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                    $cntKa=0;
                    foreach ($countKalas as $cntkl) {
                        $cntKa=$cntkl->cnt;
                    }
                    if($cntKa>0){
                                $maxPriority=DB::select("SELECT MAX(priority) as mxp FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                                $maxPr=0;
                                foreach ($maxPriority as $mxp) {
                                    $maxPr=$mxp->mxp;
                                }
                                $maxPr=$maxPr+1;
                                DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,brandId,priority)  VALUES(".$partId.",".$ka.",".$maxPr.")");
                    }else{
                        DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,brandId,priority)  VALUES(".$partId.",".$ka.",1)");
                    }
                }
            }

        }

        return redirect('/controlMainPage');
    }

    public function deletePart(Request $request)
    {
        $partId=$request->get('id');
        $partType=$request->get('partType');
        $lastPriority=$request->get('priority');
        DB::update("UPDATE NewStarfood.dbo.homepart set priority-=1 WHERE priority>".$lastPriority);
        $partPics = DB::select("SELECT id FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId=".$partId);
        if($partPics){
                        foreach ($partPics as $pic) {
                            $partPicId=$pic->id;
                            DB::delete('DELETE FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic='.$partPicId);
                                }
                    }
        DB::delete('DELETE FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId='.$partId);
        DB::delete('DELETE FROM NewStarfood.dbo.star_homepart_pictures WHERE homepartId='.$partId);
        DB::delete('DELETE FROM NewStarfood.dbo.homepart WHERE id='.$partId);
        if($partType==3){
            for ($i=0; $i <6 ; $i++) {
                if(file_exists("resources/assets/images/mainSlider/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/mainSlider/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==4){
            for ($i=0; $i <3 ; $i++) {
                if(file_exists("resources/assets/images/smallSlider/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/smallSlider/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==6){
            for ($i=0; $i <2 ; $i++) {
                if(file_exists("resources/assets/images/onePic/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/onePic/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==7){
            for ($i=0; $i <3 ; $i++) {
                if(file_exists("resources/assets/images/twoPics/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/twoPics/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==8){
            for ($i=0; $i <4 ; $i++) {
                if(file_exists("resources/assets/images/threePics/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/threePics/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==9){
            for ($i=0; $i <5 ; $i++) {
                if(file_exists("resources/assets/images/fourPics/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/fourPics/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==10){
            for ($i=0; $i <6 ; $i++) {
                if(file_exists("resources/assets/images/fivePics/".$partId."_".$i.".jpg")){
                    unlink("resources/assets/images/fivePics/".$partId."_".$i.".jpg");
                }
            }
        }
        if($partType==12){
            $brandItems=DB::table("NewStarfood.dbo.star_BrandItem")->where('homePartId',$partId)->get('id');
            foreach ($brandItems as $item) {
                DB::table("NewStarfood.dbo.star_add_homePart_stuff")->where('brandId',$item->id)->delete();
                if(file_exists("resources/assets/images/brands/".$partId."_".$item->id.".jpg")){
                    unlink("resources/assets/images/brands/".$partId."_".$item->id.".jpg");
                }
            }

            DB::table("NewStarfood.dbo.star_BrandItem")->where('homePartId',$partId)->delete();

        }

    }
	// برای اولویت بندی بخش های صفحه اصلی فرانت
    public function changePriority(Request $request)
    {
        $partId=$request->get('partId');
        $priorityState=$request->get('changePriority');
        $priorities = DB::select("SELECT priority FROM NewStarfood.dbo.Homepart WHERE Id=".$partId);
        $countParts= DB::select("SELECT COUNT(id) as countPart FROM NewStarfood.dbo.Homepart");
        $allPartsCount=0;
        foreach ($countParts as $contPart) {
            $allPartsCount=$contPart->countPart;
        }
        $priority=0;
        foreach ($priorities as $pr) {
            $priority=$pr->priority;
        }
        if ($priorityState=='up') {
            if($priority>3){
            DB::update('UPDATE NewStarfood.dbo.Homepart set priority-=1 WHERE id='.$partId);
            DB::update('UPDATE NewStarfood.dbo.Homepart set priority='.($priority).' WHERE id!='.$partId.' and priority='.($priority-1));
            $parts=DB::select('SELECT * FROM NewStarfood.dbo.HomePart ORDER BY priority ASC');
            return Response::json($parts);
        }else{
            $parts=DB::select('SELECT * FROM NewStarfood.dbo.HomePart ORDER BY priority ASC');
            return Response::json($parts);
        }

        }else{
            if($priority<$allPartsCount and $priority>=0){
            DB::update('UPDATE NewStarfood.dbo.Homepart set priority+=1 WHERE id='.$partId);
            DB::update('UPDATE NewStarfood.dbo.Homepart set priority='.($priority).' WHERE id!='.$partId.' and priority='.($priority+1));
            $parts=DB::select('SELECT * FROM NewStarfood.dbo.HomePart ORDER BY priority ASC');
            return Response::json($parts);
            }else{
                $parts=DB::select('SELECT * FROM NewStarfood.dbo.HomePart ORDER BY priority ASC');
                return Response::json($parts);
            }
        }
    }
    public function getAllKalaForHomePageFront($pid)
    {
        $partId=$pid;
        $overLine=0;
        $callOnSale=0;
        $zeroExistance=0;
        $activeTakhfifPercent=0;
        $activePishKharid=0;
        $freeExistance=0;
        //with stocks-------------------------------------
        $listKala=DB::select("SELECT  GoodSn,GoodName,UName,Price3,Price4,SnGoodPriceSale,IIF(csn>0,'YES','NO') favorite,productId,IIF(ISNULL(productId,0)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,SumAmount,BoughtAmount)) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,secondUnit,freeExistance,activeTakhfifPercent,activePishKharid,GoodGroupSn,firstGroupId FROM(

            SELECT  PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,csn,D.productId,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale,GoodGroupSn
            ,SumAmount,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,secondUnit,star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activeTakhfifPercent,star_GoodsSaleRestriction.activePishKharid,p.firstGroupId FROM Shop.dbo.PubGoods
            JOIN NewStarfood.dbo.star_GoodsSaleRestriction ON PubGoods.GoodSn=NewStarfood.dbo.star_GoodsSaleRestriction.productId
            JOIN (select min(firstGroupId) as firstGroupId,product_id from NewStarfood.dbo.star_add_prod_group group by product_id)p on PubGoods.GoodSn=p.product_id
            JOIN  NewStarfood.dbo.star_add_homePart_stuff ON PubGoods.GoodSn=star_add_homePart_stuff.productId
            JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
            join(select SUM(Amount) as SumAmount,SnGood from Shop.dbo.ViewGoodExistsInStock
            where  ViewGoodExistsInStock.FiscalYear=".Session::get("FiscallYear")." and ViewGoodExistsInStock.CompanyNo=5 group by SnGood )B on PubGoods.GoodSn=B.SnGood 
            left JOIN (select  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount from NewStarfood.dbo.FactorStar join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".Session::get("psn")." and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
            left join (select goodSn as csn from NewStarfood.dbo.star_Favorite WHERE star_Favorite.customerSn=".Session::get("psn").")C on PubGoods.GoodSn=C.csn
            LEFT JOIN (select productId from NewStarfood.dbo.star_requestedProduct where customerId=".Session::get("psn").")D on PubGoods.GoodSn=D.productId
            left join (select zeroExistance,callOnSale,overLine,productId from NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
            JOIN (SELECT * from Shop.dbo.ViewGoodExists) A ON PubGoods.GoodSn=A.SnGood
            LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
            left join (select GoodUnitSecond.AmountUnit,SnGood,UName as secondUnit from Shop.dbo.GoodUnitSecond
            join Shop.dbo.PUBGoodUnits on PUBGoodUnits.USN=GoodUnitSecond.SnGoodUnit WHERE GoodUnitSecond.CompanyNo=5)G on G.SnGood=PUbGoods.GoodSn
            WHERE  PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 ) and A.FiscalYear=".Session::get("FiscallYear")." and A.CompanyNo=5
            and homepartId=$partId
            GROUP BY p.firstGroupId, GoodGroupSn,PubGoods.GoodSn,E.zeroExistance,E.callOnSale,E.overLine,BoughtAmount,PackAmount,SnOrderBYS,secondUnit,D.productId,PubGoods.GoodName,SumAmount,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale,PUBGoodUnits.UName,star_GoodsSaleRestriction.activeTakhfifPercent,
            star_GoodsSaleRestriction.freeExistance,star_GoodsSaleRestriction.activePishKharid,csn 
            ) A order by SumAmount desc");

        foreach ($listKala as $kala) {

            $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;
    
        }

        $favorits=DB::select("SELECT * from NewStarfood.dbo.star_Favorite where customerSn=".Session::get('psn'));

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
        return view('kala.kalaFromPart',['kala'=>$listKala,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
		$logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
        return view('kala.kalaFromPart',['kala'=>$listKala,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    }

    public function addKalatoPart(Request $request)
    {
        $partId=$request->input('partId');
        $addableKala=$request->input("kalaList");
        $partType=$request->input("partType");
        if($partType=="kala"){
            $iterator=0;
            foreach ($addableKala as $kala) {
                $iterator+=1;
                list($ka,$title)=explode("_",$kala);
                $countKalas=DB::select("SELECT COUNT(id) as cnt FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId);
                $cntKa=0;
                foreach ($countKalas as $cntkl) {
                    $cntKa=$cntkl->cnt;
                }
                if($cntKa>0){
                            DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority+=1 where homepartId=".$partId);
                            DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,productId,priority)  VALUES(".$partId.",".$ka.",1)");
                }else{
                    DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (homepartId,productId,priority)  VALUES(".$partId.",".$ka.",1)");
                }
            }
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
            return Response::json($kala);
        }else{
            $iterator=0;
            foreach ($addableKala as $kala) {
                $iterator+=1;
                list($ka,$title)=explode("_",$kala);
                $countKalas=DB::select("SELECT COUNT(id) as cnt FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$partId);
                $cntKa=0;
                foreach ($countKalas as $cntkl) {
                    $cntKa=$cntkl->cnt;
                }
                if($cntKa>0){
                            DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority+=1 where partPic=".$partId);
                            DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (partPic,productId,priority)  VALUES(".$partId.",".$ka.",1)");
                }else{
                    DB::insert("INSERT INTO  NewStarfood.dbo.star_add_homePart_stuff (partPic,productId,priority)  VALUES(".$partId.",".$ka.",1)");
                }
            }
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE partPic=".$partId." order by priority asc");
            return Response::json($kala);
        }
    }

    public function deleteKalaFromPart(Request $request){
        $partId=$request->get("partId");
        $removableKalas=$request->get("kalaList");
        $partType=$request->get("partType");
        if($partType=="kala"){
            if($removableKalas){
                foreach ($removableKalas as $rmKlId) {
                    // list($rmKlId,$title)=explode('_',$rmKlId);
                    if ($rmKlId!='on'){
                    $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE homepartId=".$partId." and productId=".$rmKlId);
                    $lastPriority=0;
                    foreach ($priorities as $pr) {
                        $lastPriority=$pr->priority;
                    }
                    DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority -=1 WHERE homepartId=".$partId." and priority>".$lastPriority);
                    DB::delete("DELETE FROM NewStarfood.dbo.star_add_homePart_stuff WHERE productId=".$rmKlId." AND homepartId=".$partId);
                    }else{

                    }
                }
            }
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE homepartId=".$partId." order by priority asc");
            return Response::json($kala);
        }else{
            if($removableKalas){
                foreach ($removableKalas as $rmKlId) {
                    // list($rmKlId,$title)=explode('_',$rmKlId);
                    if ($rmKlId!='on'){
                    $priorities=DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE partPic=".$partId." and productId=".$rmKlId);
                    $lastPriority=0;
                    foreach ($priorities as $pr) {
                        $lastPriority=$pr->priority;
                    }
                    DB::update("UPDATE NewStarfood.dbo.star_add_homePart_stuff SET priority -=1 WHERE partPic=".$partId." and priority>".$lastPriority);
                    DB::delete("DELETE FROM NewStarfood.dbo.star_add_homePart_stuff WHERE productId=".$rmKlId." AND partPic=".$partId);
                    }
                }
            }
            $kala = DB::select("SELECT * FROM NewStarfood.dbo.star_add_homePart_stuff join Shop.dbo.PubGoods on star_add_homePart_stuff.productId=PubGoods.GoodSn WHERE partPic=".$partId." order by priority asc");
            return Response::json($kala);
        }
    }


    public function deleteShegeftImage(Request $request){
        $partId=$request->get("partId");
        unlink("".base_path("resources\\assets\\images\\shegeftAngesPicture\\".$partId.".jpg")."");
        return Response::json(1);
    }

    public function getHeaderInfoApi(Request $request)
    {
        $customerSn=$request->get("psn");
        return Response::json($customerSn);
        $orderHDSs=\DB::select("SELECT SnOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=$customerSn and OrderStatus=0");
        $SnHDS=0;
        foreach ($orderHDSs as $hds) {
            $SnHDS=$hds->SnOrder;
        }

        $orderBYSs=\DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,orderStar.*,PUBGoodUnits.UName from Shop.dbo.PubGoods join NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood inner join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE SnHDS=".$SnHDS);
        $countBoughtAghlam=count($orderBYSs);
        // Session::put('buy',$countBoughtAghlam);
        
        $countNewReplayMessage=\DB::select("SELECT COUNT(replayId) as countReplayMessage FROM(SELECT star_replayMessage.id AS replayId FROM star_replayMessage JOIN star_message ON star_replayMessage.messageId=star_message.id WHERE star_message.customerId=$customerSn AND star_replayMessage.readState=0)a ");
        $countNewReplay=0;
        foreach ($countNewReplayMessage as $repCount) {
            $countNewReplay=$repCount->countReplayMessage;
        }
        
        $restrictions=\DB::select("SELECT * FROM star_customerRestriction WHERE customerId = $customerSn");
        
        $exitAllowanceCustomer=0;
        foreach ($restrictions as $rest) {
            $exitAllowanceCustomer=$rest->exitButtonAllowance;
        }
        $socials=\DB::select("SELECT whatsappNumber,instagramId,telegramId,enamad FROM NewStarfood.dbo.star_webSpecialSetting");
        $telegramId;
        $instagramId;
        $whatsApp;
        foreach ($socials as $social) {
            $instagramId=$social->instagramId;
            $telegramId=$social->telegramId;
            $whatsApp=$social->whatsappNumber;
            $showEnamad=$social->enamad;
        }
        
        //محاسبه پول کیف تخفیفی
        $counDiscountWallet=new StarfoodFunLib;
        $allMoneyTakhfifResult=$counDiscountWallet->discountWalletCalc($customerSn);
        $bonusResult=$counDiscountWallet->customerBonusCalc($customerSn);
        
        return Response::json(['exitAllowance'=>$exitAllowanceCustomer,'countBoughtAghlam'=>$countBoughtAghlam,
                               'countNewReplayMessage'=>$countNewReplay,'instagram'=>$instagramId,'telegram'=>$telegramId,
                               'whatsapp'=>$whatsApp,'showEnamad'=>$showEnamad,'takhfifMoney'=>$allMoneyTakhfifResult,
                               'bonusResult'=>($bonusResult[5])]);
    }

    public function getSlidersApi(Request $request){

        $customerId=$request->input("psn");

        $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
        $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
        if($lastReferesh>=0 or count($logedIns)<1){
                $palatform=BrowserDetect::platformFamily();
                $browser=BrowserDetect::browserFamily();
            if(count($logedIns)<1){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
            }elseif($lastReferesh>0){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser]);
            }
        }

        $slider=DB::select("SELECT star_add_homePart_stuff.firstPic,star_add_homePart_stuff.secondPic,star_add_homePart_stuff.thirdPic,star_add_homePart_stuff.fourthPic,star_add_homePart_stuff.fifthPic FROM NewStarfood.dbo.HomePart INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON HomePart.id=star_add_homePart_stuff.homepartId WHERE HomePart.partType=3");
        $smallSlider=DB::select("SELECT star_add_homePart_stuff.id,star_add_homePart_stuff.homepartId,star_add_homePart_stuff.firstPic,star_add_homePart_stuff.secondPic,star_add_homePart_stuff.thirdPic,star_add_homePart_stuff.fourthPic,star_add_homePart_stuff.fifthPic,HomePart.activeOrNot FROM NewStarfood.dbo.HomePart INNER JOIN NewStarfood.dbo.star_add_homePart_stuff ON HomePart.id=star_add_homePart_stuff.homepartId WHERE HomePart.partType=4");
        $bigSliderList=[$slider[0]->firstPic,$slider[0]->secondPic,$slider[0]->thirdPic,$slider[0]->fourthPic,$slider[0]->fifthPic];
        $smalSliderList=[$smallSlider[0]->firstPic,$smallSlider[0]->secondPic,$smallSlider[0]->thirdPic,$smallSlider[0]->fourthPic,$smallSlider[0]->fifthPic];
        return Response::json(['sliders'=>$slider,'smallSlider'=>$smallSlider,'bigSliderList'=>$bigSliderList,'smalSliderList'=>$smalSliderList]);
    }


}
