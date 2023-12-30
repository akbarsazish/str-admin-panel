<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Star_CustomerPass;
use \Morilog\Jalali\Jalalian;
use Carbon\Carbon;
use DB;
use Response;
use Session;
use BrowserDetect;
use URL;
use DateTime;
class Customer extends Controller{

// The following method return the form to insert haqiq customer into database
        public function haqiqiCustomerAdd(){
            $customerId=Session::get('psn');
            $checkHaqiqiExist=DB::table("NewStarfood.dbo.star_Customer")->where("customerShopSn",Session::get('psn'))->count();
            $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();

            $exacHaqiqi=array();
            foreach ($haqiqiCustomers as $haqiqiCustomer) {
                $exacHaqiqi=$haqiqiCustomer;
            }
            $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();
            $exactHoqoqi=array();
            foreach ($hoqoqiCustomers as $hoqoqiCustomer) {
                $exactHoqoqi=$hoqoqiCustomer;
            }
            return View('customer.addCustomerProfile', ['checkHaqiqiExist'=>$checkHaqiqiExist, 'haqiqiCustomers'=>$haqiqiCustomers,'exactHoqoqi'=>$exactHoqoqi, 'exacHaqiqi'=>$exacHaqiqi]);
        }
    public function listCustomers(Request $request) {
        $withoutRestrictions=DB::select("SELECT * FROM Shop.dbo.Peopels WHERE Peopels.PSN NOT IN(SELECT customerId FROM NewStarfood.dbo.star_customerRestriction) AND CompanyNo=5 AND isActive=1 AND GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).")");
        if(count($withoutRestrictions)>0){
            foreach ($withoutRestrictions as $customer) {
            DB::insert("INSERT INTO NewStarfood.dbo.star_customerRestriction(pardakhtLive,minimumFactorPrice,exitButtonAllowance,manyMobile,customerId,forceExit,activeOfficialInfo)VALUES(1,0,0,1,".$customer->PSN.",0,0)");
            }
        }
        $withoutPassword=DB::select("SELECT distinct Peopels.PSN,Peopels.Name,Peopels.PeopelEghtesadiCode from Shop.dbo.Peopels
        where Peopels.PSN not in(SELECT customerId FROM NewStarfood.dbo.star_CustomerPass  where customerId is not null) and Peopels.CompanyNo=5 AND Peopels.isActive=1 and peopels.GroupCode IN ( 291,297,299,312,313,314) and Name!=''");
        
        if(count($withoutPassword)>0){
            foreach ($withoutPassword as $customer) {
                $phones=DB::select("SELECT PhoneStr FROM Shop.dbo.PhoneDetail where SnPeopel=".$customer->PSN);
                $hamrah=0;
                $sabit=0;
                foreach ($phones as $phone) {
                    if($phone->PhoneType=1){
                        $sabit=$phone->PhoneStr;
                        $customer->PhoneStr=$sabit;
                        break;
                    }else{
                        $hamrah=$phone->PhoneStr;
                        $customer->PhoneStr=$hamrah;
                        break;
                    }
                }
            }
			
            foreach ($withoutPassword as $customer) {
				if(isset($customer->PhoneStr)){
					$pass =substr($customer->PhoneStr, -4);
					DB::insert("INSERT INTO NewStarfood.dbo.star_CustomerPass(customerId,customerPss,userName) 
									VALUES(".$customer->PSN.",'".$pass."','".$customer->PhoneStr."')");
				}
            }
        }
		
        $regions=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and FatherMNM=80");
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and Rectype=1 and FatherMNM=79");
        // کیوری اشخاص رسمی 
        $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->select("*")->get();
        $hohoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->select("*")->get();
		$chekRequests=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(PSN) PhoneStr
								,CRM.dbo.getCustomerMantagheh(SnMantagheh) NameRec FROM NewStarfood.dbo.star_checkRequest 
								  INNER JOIN Shop.dbo.Peopels ON PSN=customerId");
         return view('customer.listCustomers',['regions'=>$regions,'cities'=>$cities,
								'haqiqiCustomers'=>$haqiqiCustomers,
								'hohoqiCustomers'=>$hohoqiCustomers,
                                'chekRequests'=>$chekRequests,'chekRequests'=>$chekRequests]);
    }
	
	public function getProfile (Request $request){
        $profiles=DB::select("SELECT Peopels.Name,PSN,selfIntroCode FROM  Shop.dbo.Peopels Join NewStarfood.dbo.star_customerRestriction on PSN=customerId
        where Peopels.CompanyNo=5 and  Peopels.PSN=".Session::get('psn'));
        $profile;
        foreach ($profiles as $profile1) {
            $profile=$profile1;
        }

        $checkOfficialExistance=DB::table("NewStarfood.dbo.star_Customer")->where("customerShopSn",Session::get('psn'))->count();
        $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get('psn'))->get();

        $officialstate=0;
        foreach ($officialAllowed as  $off) {
            if($off->activeOfficialInfo==1){
                $officialstate = 1;
            }else {
            $officialstate = 0 ;
            }
        }

        $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();
        $exacHaqiqi=array();
        foreach ($haqiqiCustomers as $haqiqiCustomer) {
            $exacHaqiqi=$haqiqiCustomer;
        }

        $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();
        $exactHoqoqi=array();
        foreach ($hoqoqiCustomers as $hoqoqicustomer) {
            $exactHoqoqi=$hoqoqicustomer;
        }

        $factors=DB::select("SELECT TOP 20 FactorHDS.* FROM  Shop.dbo.FactorHDS  where FactorHDS.CustomerSn=".Session::get('psn')." AND  FactType=3 ORDER BY FactDate DESC");
        $orders=DB::select("SELECT  NewStarfood.dbo.OrderHDSS.* FROM  NewStarfood.dbo.OrderHDSS WHERE isSent=0 AND isDistroy=0 AND CustomerSn=".Session::get('psn'));
        foreach ($orders as $order) {
            $orederPrice=0;
            $prices=DB::select("SELECT Price FROM  NewStarfood.dbo.OrderBYSS where SnHDS=".$order->SnOrder);
            foreach ($prices as $price) {
                $orederPrice+=$price->Price;
            }
            $order->Price=$orederPrice;
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

        return view('customer.profile',['profile'=>$profile, 'exactHoqoqi'=>$exactHoqoqi, 'exacHaqiqi'=>$exacHaqiqi,'checkOfficialExistance'=>$checkOfficialExistance,'factors'=>$factors,'orders'=>$orders,'officialstate'=>$officialstate,'currency'=>$currency,'currencyName'=>$currencyName]);
    }

        public function haqiqiCustomerAdmin($id){
            $customerId=$id;
            $checkHaqiqiExist=DB::table("NewStarfood.dbo.star_Customer")->where("customerShopSn",$id)->count();
            $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', $id)->select("*")->get();

            $exacHaqiqi=array();
            foreach ($haqiqiCustomers as $haqiqiCustomer) {
                $exacHaqiqi=$haqiqiCustomer;
            }

            $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', $id)->select("*")->get();
            $exactHoqoqi=array();
            foreach ($hoqoqiCustomers as $hoqoqiCustomer) {
                $exactHoqoqi=$hoqoqiCustomer;
            }
            $chekCustomerType="haqiqi";
            if(count($haqiqiCustomers)>0){
                $chekCustomerType="haqiqi";
            }else{
                $chekCustomerType="hoqoqi";
            }
            return View('customer.editOfficialCustomerByAdmin', ['checkHaqiqiExist'=>$checkHaqiqiExist,'id'=>$id,'checkType'=>$chekCustomerType, 'haqiqiCustomers'=>$haqiqiCustomers,'exactHoqoqi'=>$exactHoqoqi, 'exacHaqiqi'=>$exacHaqiqi]);
        }
	
    public function editCustomer(Request $request){
       $customerSn=$request->post('customerSn');
       $groupCode=$request->post('customerGRP');
       $customer=DB::select("SELECT star_CustomerPass.customerPss,userName,peopels.PCode,Peopels.PSN,Peopels.Name,
                            Peopels.PeopelEghtesadiCode,peopels.peopeladdress,peopels.TimeStamp,PhoneDetail.PhoneStr,A.countLogin,percentTakhfif,discription from Shop.dbo.Peopels
                            join Shop.dbo.PhoneDetail on Peopels.PSN=PhoneDetail.SnPeopel
                            join NewStarfood.dbo.star_CustomerPass on star_CustomerPass.customerId=Peopels.PSN
                            left join (SELECT count(id) as countLogin,customerId FROM NewStarfood.dbo.star_customerSession1 group by customerId)A on A.customerId=Peopels.PSN 
                            join NewStarfood.dbo.star_customerRestriction on Peopels.PSN=star_customerRestriction.customerId
                            left JOIN (select discription,customerId from NewStarfood.dbo.star_takhfifHistory where changeDate=(select MAX(changeDate) from NewStarfood.dbo.star_takhfifHistory where customerId=".$customerSn."))c on c.customerId=Peopels.PSN
                            where Peopels.CompanyNo=5 and Peopels.PSN=".$customerSn." and peopels.GroupCode=".$groupCode);
       $exactCustomer;
        foreach ($customer as $cust) {
            $exactCustomer=$cust;
            $customerRestriction=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction where customerId=".$cust->PSN);
            if(count($customerRestriction)>0){
                foreach ($customerRestriction as $restrict){
                    $exactCustomer->minimumFactorPrice=$restrict->minimumFactorPrice;
                    $exactCustomer->manyMobile=$restrict->manyMobile;
                    $exactCustomer->exitButtonAllowance=$restrict->exitButtonAllowance;
                    $exactCustomer->pardakhtLive=$restrict->pardakhtLive;
                    $exactCustomer->forceExit=$restrict->forceExit;
                    $exactCustomer->officialInfo=$restrict->activeOfficialInfo;
                }
            }else{
                $exactCustomer->minimumFactorPrice=0;
                $exactCustomer->manyMobile=0;
                $exactCustomer->exitButtonAllowance=0;
                $exactCustomer->pardakhtLive=0;
                $exactCustomer->forceExit=0;
                $exactCustomer->officialInfo=0;
            }
        }
       $defaultPercent=DB::select("SELECT percentTakhfif from NewStarfood.dbo.star_webSpecialSetting")[0]->percentTakhfif;
       $takhfifHistory=DB::select("SELECT * from NewStarfood.dbo.star_takhfifHistory where customerId=".$customerSn);
       return view('customer.editCustomer',['customer'=>$exactCustomer,'takhfifHistory'=>$takhfifHistory,'defaultPercent'=>$defaultPercent]);
    }

    public function assignSpecialTakhfifPercentage(Request $request)
    {
        $psn=$request->post("CustomerSn");
        $discription=$request->post("discription");
        $percentTakhfif=(float)str_replace("/", ".",$request->post("percentTakhfif"));
        $lastPercentTakhfif=0;
        $defaultPercent=DB::select("select percentTakhfif from NewStarfood.dbo.star_webSpecialSetting")[0]->percentTakhfif;
        $personalPercent=DB::select("select percentTakhfif from NewStarfood.dbo.star_customerRestriction where customerId=$psn")[0]->percentTakhfif;
        if($personalPercent){
            $lastPercentTakhfif=$personalPercent;
        }else{
            $lastPercentTakhfif=$defaultPercent;
        }
        $allMoneyTakhfif=0;
        $hasTakhfifHistory=DB::select("select c.customerId,money,changeDate from (
                                        select  money,customerId from NewStarfood.dbo.star_takhfifHistory where changeDate=(select MAX(changeDate)
                                        as changeDate from NewStarfood.dbo.star_takhfifHistory where customerId=$psn and isUsed=0 group by customerId) and customerId=$psn
                                        )a join (select MAX(changeDate) as changeDate,customerId from NewStarfood.dbo.star_takhfifHistory where isUsed=0 group by customerId)c on a.customerId=c.customerId
                                        ");
        //اگر تاریخچه استفاده شده و یا اصلا  نداشت و هنوز ویرایش تخفیف نداشت                                
        if(count($hasTakhfifHistory)<1 and !$personalPercent) { 
            $allMoneyTakhfif=DB::select("select sum(NetPriceHDS/10)*$lastPercentTakhfif/100 as SummedAllMoney from Shop.dbo.GetAndPayHDS where CompanyNo=5
                                        and GetOrPayHDS=1 and FiscalYear=".Session::get("FiscallYear")." and DocDate>'1401/08/30' and PeopelHDS=$psn");
            DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$psn)->update(['percentTakhfif'=>$percentTakhfif]);
            DB::table("NewStarfood.dbo.star_takhfifHistory")->insert(
            [
            'customerId'=>$psn
            ,'money'=>(float)$allMoneyTakhfif[0]->SummedAllMoney
            ,'discription'=>"".$discription.""
            ,'lastPercent'=>$lastPercentTakhfif
            ,'isUsed'=>0]);
        }
// اگر تاریخچه تخفیف داشت و لی استفاده شده بود.
        if(count($hasTakhfifHistory)<1 and $personalPercent) {   
            $allMoneyTakhfif=DB::select("select sum(NetPriceHDS/10)*$lastPercentTakhfif/100 as SummedAllMoney
                                        From Shop.dbo.GetAndPayHDS where CompanyNo=5 and GetOrPayHDS=1 and FiscalYear=".Session::get("FiscallYear")." and
                                        PeopelHDS=".Session::get("psn")." and DocDate>"."(select FORMAT(CAST(Max(changeDate) AS DATE), 'yyyy/MM/dd', 'fa') from NewStarfood.dbo.star_takhfifHistory where isUsed=1 and customerId=".Session::get("psn")." group by customerId)
                                        ");

            DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$psn)->update(['percentTakhfif'=>$percentTakhfif]);
            DB::table("NewStarfood.dbo.star_takhfifHistory")->insert(
            [
            'customerId'=>$psn
            ,'money'=>(float)$allMoneyTakhfif[0]->SummedAllMoney
            ,'discription'=>"".$discription.""
            ,'lastPercent'=>$lastPercentTakhfif
            ,'isUsed'=>0]);
        }

        // اگر تاریخچه تخفیف داشت و  استفاده نشده بود.
        if(count($hasTakhfifHistory)>0 and $personalPercent) {   
            $allMoneyTakhfif=DB::select("select sum(NetPriceHDS/10)*$lastPercentTakhfif/100 as SummedAllMoney
                                        From Shop.dbo.GetAndPayHDS where CompanyNo=5 and GetOrPayHDS=1 and FiscalYear=".Session::get("FiscallYear")." and
                                        PeopelHDS=".Session::get("psn")." and DocDate>"."(select FORMAT(CAST(Max(changeDate) AS DATE), 'yyyy/MM/dd', 'fa') from NewStarfood.dbo.star_takhfifHistory where isUsed=0 and customerId=".Session::get("psn")." group by customerId)
                                        ");
            DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$psn)->update(['percentTakhfif'=>$percentTakhfif]);
            DB::table("NewStarfood.dbo.star_takhfifHistory")->insert(
            [
            'customerId'=>$psn
            ,'money'=>(float)$allMoneyTakhfif[0]->SummedAllMoney
            ,'discription'=>"".$discription.""
            ,'lastPercent'=>$lastPercentTakhfif
            ,'isUsed'=>0]);
        }

        Session::put("tempPSN",$psn);
        return redirect('/afterEditCustomer');
    }

    public function getCustomerByID(Request $request)
    {
        $psn=$request->get("PSN");
        $customerAddresses=DB::select("SELECT AddressPeopel,SnPeopelAddress,peopeladdress,Name,PSN,PCode FROM Shop.dbo.Peopels LEFT JOIN Shop.dbo.PeopelAddress ON PSN=PeopelAddress.SnPeopel WHERE PSN=$psn");
        return Response::json($customerAddresses);
    }

// The following methods check if the haqiqi customer exist update the current customer else add new customer
        public function storeHaqiqiCustomer(Request $request){
            $customerShopSn=$request->post("customerShopSn");
            $checkExistance=DB::table("NewStarfood.dbo.star_Customer")->where('customerType', $request->post("customerType"))->where('customerShopSn', Session::get('psn'))->count('customerShopSn');

            // if the customer exist already then update the some fields
            if($checkExistance>0){
                    $customerName=$request->post("customerName");
                    $familyName=$request->post("familyName");
                    $codeMilli=$request->post("codeMilli");
                    $codeEqtisadi=$request->post("codeEqtisadi");
                    $codeNaqsh=$request->post("codeNaqsh");
                    $address=$request->post("address");
                    $codePosti=$request->post("codePosti");
                    $email=$request->post("email");
                    $phoneNo=$request->post("phoneNo");
                    $shenasNamahNo=$request->post("shenasNamahNo");
                    $sabetPhoneNo=$request->post("sabetPhoneNo");
                    $customerType=$request->post("customerType");
                    $customerShopSn=$request->post("customerShopSn");


                DB::update("UPDATE star_Customer SET
                    customerName='".$customerName."',
                    familyName='".$familyName."',
                    codeMilli='".$codeMilli."',
                    codeEqtisadi ='".$codeEqtisadi."',
                    codeNaqsh ='".$codeNaqsh."',
                    address='".$address."',
                    codePosti='".$codePosti."',
                    email='".$email."',
                    shenasNamahNo='".$shenasNamahNo."',
                    sabetPhoneNo='".$sabetPhoneNo."',
                    phoneNo='".$phoneNo."',
                    customerType='".$customerType."',
                    customerShopSn='".Session::get("psn")."'
                    where customerType='".$customerType."' and customerShopSn='".Session::get("psn")."'");
                    $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();
                    $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get('psn'))->get();
                    DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".Session::get("psn"));
                    // return View('userProfile.profile', ['haqiqicustomers'=>$haqiqiCustomers]);

                    return redirect('profile');


            }else{
                    $customerName=$request->post("customerName");
                    $familyName=$request->post("familyName");
                    $codeMilli=$request->post("codeMilli");
                    $codeEqtisadi=$request->post("codeEqtisadi");
                    $codeNaqsh=$request->post("codeNaqsh");
                    $address=$request->post("address");
                    $codePosti=$request->post("codePosti");
                    $email=$request->post("email");
                    $phoneNo=$request->post("phoneNo");
                    $shenasNamahNo=$request->post("shenasNamahNo");
                    $sabetPhoneNo=$request->post("sabetPhoneNo");
                    $customerType=$request->post("customerType");
                    $customerShopSn=$request->post(Session::get("psn"));

                DB::table("NewStarfood.dbo.star_Customer")->insert([
                    'customerName'=>"".$customerName."",
                    'familyName'=>"".$familyName."",
                    'codeMilli'=>"".$codeMilli."",
                    'codeEqtisadi'=>"".$codeEqtisadi."",
                    'codeNaqsh'=>"".$codeNaqsh."",
                    'address'=>"".$address."",
                    'codePosti'=>"".$codePosti."",
                    'email'=>"".$email."",
                    'phoneNo'=>"".$phoneNo."",
                    'shenasNamahNo'=>"".$shenasNamahNo."",
                    'sabetPhoneNo'=>"".$sabetPhoneNo."",
                    'customerType'=>"".$customerType."",
                    'customerShopSn'=>''.Session::get("psn").''
                    ]);
                    $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get('psn'))->get();
                    DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".Session::get("psn"));

                    return redirect('profile');
            }
}

public function afterEditCustomer(Request $request)
{

   $customerSn=Session::get('tempPSN');

   $customer=DB::select("SELECT star_CustomerPass.customerPss,peopels.PCode,Peopels.PSN,Peopels.Name,
                        Peopels.PeopelEghtesadiCode,peopels.peopeladdress,peopels.TimeStamp,PhoneDetail.PhoneStr,A.countLogin,percentTakhfif,discription from Shop.dbo.Peopels
                        join Shop.dbo.PhoneDetail on Peopels.PSN=PhoneDetail.SnPeopel
                        join NewStarfood.dbo.star_CustomerPass on star_CustomerPass.customerId=Peopels.PSN
                        left join (SELECT count(id) as countLogin,customerId FROM NewStarfood.dbo.star_customerSession1 group by customerId)A on A.customerId=Peopels.PSN 
                        join NewStarfood.dbo.star_customerRestriction on Peopels.PSN=star_customerRestriction.customerId
                        left JOIN (select discription,customerId from NewStarfood.dbo.star_takhfifHistory where changeDate=(select MAX(changeDate) from NewStarfood.dbo.star_takhfifHistory where customerId=".$customerSn."))c on c.customerId=Peopels.PSN
                        where Peopels.CompanyNo=5 and Peopels.PSN=".$customerSn);

   $exactCustomer;
   foreach ($customer as $cust) {
        $exactCustomer=$cust;
        $customerRestriction=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction where customerId=".$cust->PSN);
        if(count($customerRestriction)>0){
            foreach ($customerRestriction as $restrict) {
                $exactCustomer->minimumFactorPrice=$restrict->minimumFactorPrice;
                $exactCustomer->manyMobile=$restrict->manyMobile;
                $exactCustomer->exitButtonAllowance=$restrict->exitButtonAllowance;
                $exactCustomer->pardakhtLive=$restrict->pardakhtLive;
                $exactCustomer->forceExit=$restrict->forceExit;
                $exactCustomer->officialInfo=$restrict->activeOfficialInfo;
            }
        }else{
            $exactCustomer->minimumFactorPrice=0;
            $exactCustomer->manyMobile=0;
            $exactCustomer->exitButtonAllowance=0;
            $exactCustomer->pardakhtLive=0;
            $exactCustomer->forceExit=0;
            $exactCustomer->officialInfo=0;
        }
   }

   $takhfifHistory=DB::select("SELECT customerId,money,discription,cast(changeDate AS date) as changeDate,isUsed,lastPercent from NewStarfood.dbo.star_takhfifHistory where customerId=".$customerSn);
   $defaultPercent=DB::select("SELECT percentTakhfif from NewStarfood.dbo.star_webSpecialSetting")[0]->percentTakhfif;
   return redirect("/editCustomer");
}
	
public function restrictCustomer(Request $request){
        $eqtisadiCode=$request->get("EqtisadiCode");
		$userName=$request->get("userName");
        $pardakhtLive=$request->get("PardakhtLive");
        $factorMinPrice=str_replace(",", "",$request->get("FactorMinPrice"));
        $exitAllowance=$request->get("ExitAllowance");
        $manyMobile=$request->get("ManyMobile");
        $customerId=$request->get("CustomerId");
        $forceExit=$request->get("ForceExit");
        $officialInfo=$request->get("officialInfo");
        $userExistance=DB::select("SELECT count(id) as countExist FROM NewStarfood.dbo.star_customerRestriction where customerId=".$customerId);
        $customerExist=0;
        DB::update("UPDATE NewStarfood.dbo.star_CustomerPass SET customerPss='".$eqtisadiCode."',userName='".$userName."' where customerId=".$customerId);
        foreach ($userExistance as $customer) {
            $customerExist=$customer->countExist;
        }
        if($customerExist>0){
            if($forceExit==1){
                $manyMobile=0;
                $sessions=DB::select("SELECT sessionId FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=".$customerId);
                $x=$customerId;
                foreach ($sessions as $sess) {
                    Session::getHandler()->destroy("".trim($sess->sessionId)."");
                }
                
            //    DB::delete(" DELETE FROM NewStarfood.dbo.star_customerSession1 where customerId=".$customerId);
            //    DB::update("UPDATE NewStarfood.dbo.star_customerRestriction SET manyMobile=0 WHERE customerId=".$customerId);
            }
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction SET pardakhtLive=".$pardakhtLive.",manyMobile=".$manyMobile.",	minimumFactorPrice=".$factorMinPrice."
            ,exitButtonAllowance=".$exitAllowance.",forceExit=".$forceExit.",activeOfficialInfo=".$officialInfo." WHERE customerId=".$customerId);
            $countLogedInUsers=DB::select("SELECT COUNT(id) as countLogedIn FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=".$customerId);
            $countLogedIns=0;
            foreach ($countLogedInUsers as $logedIn) {
                $countLogedIns=$logedIn->countLogedIn;
            }
            if($manyMobile >= $countLogedIns){
                //no action need
            }else{
                $tobeDelete=$countLogedIns-$manyMobile;
                $logedInUsers=DB::select("SELECT sessionId FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=".$customerId);
                $tbdel=0;
                foreach ($logedInUsers as $logedIn) {
                    $tbdel+=1;
                    Session::getHandler()->destroy("".trim($logedIn->sessionId)."");
                    DB::delete("DELETE FROM NewStarfood.dbo.star_customerSession1 WHERE sessionId='".($logedIn->sessionId)."' AND customerId=".$customerId);
                    
                    if($tbdel==$tobeDelete){
                        break;
                    }
                }
            }

        }else{
            DB::insert("INSERT INTO NewStarfood.dbo.star_customerRestriction(pardakhtLive,minimumFactorPrice,exitButtonAllowance,manyMobile,customerId,activeOfficialInfo)
            VALUES(".$pardakhtLive.",".$factorMinPrice.",".$exitAllowance.",".$manyMobile.",".$customerId.",".$officialInfo.")");
        }
        return Response::json("good");
    }
	
public function searchCustomer(Request $request){
        $searchText=$request->get("searchText");
        $searchResult=DB::select("SELECT * FROM Shop.dbo.Peopels where (Name like'%".$searchText."%' or PCode like '%".$searchText."%' or peopeladdress like '%".$searchText."%') and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).")");
        return Response::json($searchResult);
    }

// The following methods check if the haqiqi customer exist update the current customer else add new customer
public function storeHaqiqiCustomerAdmin(Request $request){

    $customerShopSn=$request->post("customerShopSn");
    $checkExistance=DB::table("NewStarfood.dbo.star_Customer")->where('customerType', $request->post("customerType"))->where('customerShopSn', Session::get('psn'))->count('customerShopSn');

    // if the customer exist already then update the some fields
    if($checkExistance>0){

            $customerName=$request->post("customerName");
            $id=$request->post("id");
            $familyName=$request->post("familyName");
            $codeMilli=$request->post("codeMilli");
            $codeEqtisadi=$request->post("codeEqtisadi");
            $codeNaqsh=$request->post("codeNaqsh");
            $address=$request->post("address");
            $codePosti=$request->post("codePosti");
            $email=$request->post("email");
            $phoneNo=$request->post("phoneNo");
            $shenasNamahNo=$request->post("shenasNamahNo");
            $sabetPhoneNo=$request->post("sabetPhoneNo");
            $customerType=$request->post("customerType");
            $customerShopSn=$id;


        DB::update("UPDATE star_Customer SET
            customerName='".$customerName."',
            familyName='".$familyName."',
            codeMilli='".$codeMilli."',
            codeEqtisadi ='".$codeEqtisadi."',
            codeNaqsh ='".$codeNaqsh."',
            address='".$address."',
            codePosti='".$codePosti."',
            email='".$email."',
            shenasNamahNo='".$shenasNamahNo."',
            sabetPhoneNo='".$sabetPhoneNo."',
            phoneNo='".$phoneNo."',
            customerType='".$customerType."',
            customerShopSn='".$id."'
            where customerType='".$customerType."' and customerShopSn='".$id."'");
            $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', $id)->select("*")->get();
            $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$id)->get();
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".$id);
            // return View('userProfile.profile', ['haqiqicustomers'=>$haqiqiCustomers]);

            return redirect('/listCustomers');


    }else{
            $customerName=$request->post("customerName");
            $familyName=$request->post("familyName");
            $codeMilli=$request->post("codeMilli");
            $codeEqtisadi=$request->post("codeEqtisadi");
            $codeNaqsh=$request->post("codeNaqsh");
            $address=$request->post("address");
            $codePosti=$request->post("codePosti");
            $email=$request->post("email");
            $phoneNo=$request->post("phoneNo");
            $shenasNamahNo=$request->post("shenasNamahNo");
            $sabetPhoneNo=$request->post("sabetPhoneNo");
            $customerType=$request->post("customerType");
            $customerShopSn=$id;

        DB::table("NewStarfood.dbo.star_Customer")->insert([
            'customerName'=>"".$customerName."",
            'familyName'=>"".$familyName."",
            'codeMilli'=>"".$codeMilli."",
            'codeEqtisadi'=>"".$codeEqtisadi."",
            'codeNaqsh'=>"".$codeNaqsh."",
            'address'=>"".$address."",
            'codePosti'=>"".$codePosti."",
            'email'=>"".$email."",
            'phoneNo'=>"".$phoneNo."",
            'shenasNamahNo'=>"".$shenasNamahNo."",
            'sabetPhoneNo'=>"".$sabetPhoneNo."",
            'customerType'=>"".$customerType."",
            'customerShopSn'=>''.$id.''
            ]);
            $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$id)->get();
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".$id);

            return redirect('/listCustomers');


    }
}

public function crmLogin(Request $request)
{
    $customer=DB::table("Shop.dbo.Peopels")->where("PSN",$request->get("psn"))->first();
    $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
    Session::put('FiscallYear',$fiscallYear);
    Session::put('username', $customer->Name);
    Session::put('psn',$customer->PSN);
    Session::put('otherUserInfo',(string)trim($request->get("otherName")));
    
    return redirect("https://starfoods.ir");
}

public function takhsisMasirs(Request $request)
{
    $cityId=$request->get("cityId");
    $regionId=$request->get("regionId");
    $csn=$request->get("csn");
    DB::table("Shop.dbo.Peopels")->where("PSN",$csn)->update(["SnNahiyeh"=>$cityId,"SnMantagheh"=>$regionId,"SnMasir"=>79]);
    $customers=DB::select("select * from(
        SELECT Peopels.PCode,peopels.Name,peopels.PSN,peopels.peopeladdress,Peopels.GroupCode,Peopels.SnMantagheh,Peopels.CompanyNo FROM Shop.dbo.Peopels
                ) a
                left join Shop.dbo.MNM on a.SnMantagheh=MNM.SnMNM
                WHERE a.CompanyNo=5 AND GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") order by PSN asc");
    foreach ($customers as $customer) {
        $phones=DB::table("Shop.dbo.PhoneDetail")->where("SnPeopel",$customer->PSN)->get();
        $hamrah="";
        $sabit="";
        foreach ($phones as $phone) {
            if($phone->PhoneType==1){
                $sabit.="\n".$phone->PhoneStr;
            }else{
                $hamrah.="\n".$phone->PhoneStr;
            }
        }
        $customer->sabit=$sabit;
        $customer->hamrah=$hamrah;
    }
    return Response::json($customers);
}



// The following methods check if the hoqoqi customer exist update the current customer else add new customer
    public function storeHoqoqiCustomer(Request $request){

    $customerShopSn=$request->post("customerShopSn");
    $checkExistance=DB::table("NewStarfood.dbo.star_Customer")->where('customerType', $request->post("customerType"))->where('customerShopSn', Session::get('psn'))->count('customerShopSn');

    // if the customer exist already then update the some fields
    if($checkExistance>0){

            $companyName=$request->post("companyName");
            $registerNo=$request->post("registerNo");
            $shenasahMilli=$request->post("shenasahMilli");
            $codeEqtisadi=$request->post("codeEqtisadi");
            $codeNaqsh=$request->post("codeNaqsh");
            $address=$request->post("address");
            $codePosti=$request->post("codePosti");
            $email=$request->post("email");
            $phoneNo=$request->post("phoneNo");
            $sabetPhoneNo=$request->post("sabetPhoneNo");
            $customerType=$request->post("customerType");
            $customerShopSn=$request->post("customerShopSn");


        DB::update("UPDATE star_Customer SET
            companyName='".$companyName."',
            registerNo='".$registerNo."',
            shenasahMilli='".$shenasahMilli."',
            codeEqtisadi ='".$codeEqtisadi."',
            codeNaqsh ='".$codeNaqsh."',
            address='".$address."',
            codePosti='".$codePosti."',
            email='".$email."',
            sabetPhoneNo='".$sabetPhoneNo."',
            phoneNo='".$phoneNo."',
            customerType='".$customerType."',
            customerShopSn='".Session::get("psn")."'
            where customerType='".$customerType."' and customerShopSn='".Session::get("psn")."'");
            $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', Session::get('psn'))->select("*")->get();
            $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get('psn'))->get();
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".Session::get("psn"));
            // return View('userProfile.profile', ['hoqoqiCustomers'=>$hoqoqiCustomers]);
            return redirect('profile');



// If the customer is not exist then add new customer
    }else{
            $companyName=$request->post("companyName");
            $registerNo=$request->post("registerNo");
            $shenasahMilli=$request->post("shenasahMilli");
            $codeEqtisadi=$request->post("codeEqtisadi");
            $codeNaqsh=$request->post("codeNaqsh");
            $address=$request->post("address");
            $codePosti=$request->post("codePosti");
            $email=$request->post("email");
            $phoneNo=$request->post("phoneNo");
            $sabetPhoneNo=$request->post("sabetPhoneNo");
            $customerType=$request->post("customerType");
            $customerShopSn=$request->post(Session::get("psn"));

        DB::table("NewStarfood.dbo.star_Customer")->insert([
            'companyName'=>"".$companyName."",
            'registerNo'=>"".$registerNo."",
            'shenasahMilli'=>"".$shenasahMilli."",
            'codeEqtisadi'=>"".$codeEqtisadi."",
            'codeNaqsh'=>"".$codeNaqsh."",
            'address'=>"".$address."",
            'codePosti'=>"".$codePosti."",
            'email'=>"".$email."",
            'phoneNo'=>"".$phoneNo."",
            'sabetPhoneNo'=>"".$sabetPhoneNo."",
            'customerType'=>"".$customerType."",
            'customerShopSn'=>''.Session::get("psn").''
            ]);
            $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get('psn'))->get();
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".Session::get("psn"));
        return redirect('profile');
    }

    }

    public function storeHoqoqiCustomerAdmin(Request $request){
        $customerShopSn=$request->post("customerShopSn");
        $id=$request->post("id");
        $checkExistance=DB::table("NewStarfood.dbo.star_Customer")->where('customerType', $request->post("customerType"))->where('customerShopSn', $id)->count('customerShopSn');

        // if the customer exist already then update the some fields
        if($checkExistance>0){

                $companyName=$request->post("companyName");
                $registerNo=$request->post("registerNo");
                $id=$request->post("id");
                $shenasahMilli=$request->post("shenasahMilli");
                $codeEqtisadi=$request->post("codeEqtisadi");
                $codeNaqsh=$request->post("codeNaqsh");
                $address=$request->post("address");
                $codePosti=$request->post("codePosti");
                $email=$request->post("email");
                $phoneNo=$request->post("phoneNo");
                $sabetPhoneNo=$request->post("sabetPhoneNo");
                $customerType=$request->post("customerType");
                $customerShopSn=$id;


            DB::update("UPDATE star_Customer SET
                companyName='".$companyName."',
                registerNo='".$registerNo."',
                shenasahMilli='".$shenasahMilli."',
                codeEqtisadi ='".$codeEqtisadi."',
                codeNaqsh ='".$codeNaqsh."',
                address='".$address."',
                codePosti='".$codePosti."',
                email='".$email."',
                sabetPhoneNo='".$sabetPhoneNo."',
                phoneNo='".$phoneNo."',
                customerType='".$customerType."',
                customerShopSn='".$id."'
                where customerType='".$customerType."' and customerShopSn='".$id."'");
                $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', $id)->select("*")->get();
                $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$id)->get();
                DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".$id);
                // return View('userProfile.profile', ['hoqoqiCustomers'=>$hoqoqiCustomers]);
                return redirect('/listCustomers');



    // If the customer is not exist then add new customer
        }else{
                $companyName=$request->post("companyName");
                $registerNo=$request->post("registerNo");
                $shenasahMilli=$request->post("shenasahMilli");
                $codeEqtisadi=$request->post("codeEqtisadi");
                $codeNaqsh=$request->post("codeNaqsh");
                $address=$request->post("address");
                $codePosti=$request->post("codePosti");
                $email=$request->post("email");
                $phoneNo=$request->post("phoneNo");
                $sabetPhoneNo=$request->post("sabetPhoneNo");
                $customerType=$request->post("customerType");
                $customerShopSn=$id;

            DB::table("NewStarfood.dbo.star_Customer")->insert([
                'companyName'=>"".$companyName."",
                'registerNo'=>"".$registerNo."",
                'shenasahMilli'=>"".$shenasahMilli."",
                'codeEqtisadi'=>"".$codeEqtisadi."",
                'codeNaqsh'=>"".$codeNaqsh."",
                'address'=>"".$address."",
                'codePosti'=>"".$codePosti."",
                'email'=>"".$email."",
                'phoneNo'=>"".$phoneNo."",
                'sabetPhoneNo'=>"".$sabetPhoneNo."",
                'customerType'=>"".$customerType."",
                'customerShopSn'=>''.$id.''
                ]);
                $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$id)->get();
                DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set activeOfficialInfo=0 where customerId=".$id);
            return redirect('/customerList');

        }

        }



    public function regularLogin(Request $request){
        $customerId=$request->post("customerSn");
        $customers=DB::select("SELECT Peopels.PSN,Peopels.Name from Shop.dbo.Peopels
        where Peopels.CompanyNo=5 and peopels.GroupCode=290 and Peopels.PSN=".$customerId);
        $userName="";
        $psn="";
        foreach ($customers as $customer) {
            $userName=$customer->Name;
            $psn=$customer->PSN;
        }
        Session::put('username', $userName);
        Session::put('psn',$psn);
        return redirect("/home");
    }
    public function regularLogOut(Request $request)
    {
        $customerId=$request->post("customerSn");
        $customers=DB::select("SELECT Peopels.PSN,Peopels.Name from Shop.dbo.Peopels
        where Peopels.CompanyNo=5 and peopels.GroupCode=290 and Peopels.PSN=".$customerId);
        $userName="";
        $psn="";
        foreach ($customers as $customer) {
            $userName=$customer->Name;
            $psn=$customer->PSN;
        }
        Session::forget('username');
        Session::forget('psn');
        return redirect("/listCustomers");
    }

    public function customerDashboard(Request $request){
        $psn=$request->get("csn");
        $adminId=Session::get('asn');
        $customers=DB::select("SELECT * from(
            SELECT * from(         
            SELECT COUNT(Shop.dbo.FactorHDS.SerialNoHDS)as countFactor,CustomerSn FROM Shop.dbo.FactorHDS where FactorHDS.FactType=3  group by CustomerSn)a
            right join (SELECT comment,customerId FROM CRM.dbo.crm_customerProperties)b on a.CustomerSn=b.customerId)c
            right join (SELECT PSN,Name,GroupCode,CompanyNo,peopeladdress,PCode FROM Shop.dbo.Peopels)f on c.customerId=f.PSN
			right join(select * from NewStarfood.dbo.star_CustomerPass)g on g.customerId=PSN
            join (SELECT SnPeopel, STRING_AGG(PhoneStr, '-') AS PhoneStr FROM Shop.dbo.PhoneDetail GROUP BY SnPeopel)a on g.customerId=a.SnPeopel
            where f.CompanyNo=5 AND f.GroupCode IN (291,1297,312 ,313 ,314,299) AND f.PSN=".$psn);
        $exactCustomer=$customers[0];
        $factors=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE FactType=3 AND CustomerSn=".$psn." order by FactDate desc");
        $returnedFactors=DB::select("SELECT * FROM Shop.dbo.FactorHDS WHERE FactType=4 AND CustomerSn=".$psn." order by FactDate desc");
        $GoodsDetail=DB::select("SELECT *,CRM.dbo.countFactorOfProductByCustomer(SnGood,$psn) as countFactor 
		FROM (SELECT MAX(TimeStamp)as maxTime,SnGood FROM(
            SELECT FactorBYS.TimeStamp,FactorBYS.Fi,FactorBYS.Amount,FactorBYS.SnGood FROM Shop.dbo.FactorHDS
            JOIN Shop.dbo.FactorBYS on FactorHDS.SerialNoHDS=FactorBYS.SnFact
            where FactorHDS.CustomerSn=".$psn.")g group by SnGood)c
            JOIN (SELECT * FROM Shop.dbo.PubGoods)d on d.GoodSn=c.SnGood order by maxTime desc");
        $basketOrders=DB::select("SELECT orderStar.TimeStamp,PubGoods.GoodName,orderStar.Amount,orderStar.Fi 
									FROM newStarfood.dbo.FactorStar join newStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS
                                    join Shop.dbo.PubGoods on orderStar.SnGood=PubGoods.GoodSn  where orderStatus=0 and CustomerSn=".$psn);
        $comments=DB::select("SELECT  crm_comment.newComment,crm_comment.nexComment,crm_comment.TimeStamp
								,customerId,adminId,specifiedDate,doneState,crm_comment.id,CONCAT(name,lastName)adminName
								FROM CRM.dbo.crm_comment 
								JOIN CRM.dbo.crm_workList ON crm_comment.id=crm_workList.commentId  
								left join CRM.dbo.crm_admin on adminId=crm_admin.id  WHERE customerId=".$psn." 
								order by TimeStamp desc");
        $specialComment=DB::table("CRM.dbo.crm_customerProperties")->where("customerId",$psn)->select("comment")->get();
        $assesments=DB::select("SELECT crm_assesment.comment,crm_assesment.factorId,crm_assesment.TimeStamp,crm_assesment.shipmentProblem,crm_assesment.driverBehavior FROM CRM.dbo.crm_assesment
        join Shop.dbo.FactorHDS on crm_assesment.factorId=FactorHDS.SerialNoHDS join Shop.dbo.Peopels on Peopels.PSN=FactorHDS.CustomerSn where PSN=".$psn." order by TimeStamp desc");
        $loginInfo=DB::select("select * from NewStarfood.dbo.star_customerTrack where customerId=$psn order by visitDate desc");
        $lotteryTakhfif=DB::select("SELECT * FROM(
            SELECT * FROM (SELECT customerId,Cast(money As varchar(200)) gift,FORMAT(usedDate,'yyyy/MM/dd','fa-ir')usedDate  FROM NewStarfood.dbo.star_takhfifHistory WHERE isUsed=0)a UNION (SELECT  customerId,wonPrize,FORMAT(timestam,'yyyy/MM/dd','fa-ir') FROM NewStarfood.dbo.star_TryLottery ))b WHERE customerId=$psn");
		$requestedProduct=DB::select("SELECT GoodName,GoodCde,FORMAT(TimeStamp,'yyyy/MM/dd','fa-ir') requestDate FROM NewStarfood.dbo.star_requestedProduct INNER JOIN Shop.dbo.PubGoods on productId=GoodSn where customerId=$psn");
        return Response::json([$exactCustomer,$factors,$GoodsDetail,$basketOrders,$comments,$specialComment,$assesments,$returnedFactors,$loginInfo,$lotteryTakhfif,$requestedProduct]);
    }


    public function setCommentProperty(Request $request)  {
        $csn=$request->get('csn');
        $comment=$request->get("comment");
        $checkExistance=DB::table("CRM.dbo.crm_customerProperties")->where('customerId',$csn)->count();
        if($checkExistance>0){
            DB::table("CRM.dbo.crm_customerProperties")->where('customerId',$csn)->update(['comment'=>"".$comment.""]);
        }else{
            DB::table("CRM.dbo.crm_customerProperties")->insert(['customerId'=>$csn,'comment'=>"".$comment.""]); 
        }
        $comments=DB::table("CRM.dbo.crm_customerProperties")->where('customerId',$csn)->get();
        return Response::json($comments);
    }


    public function getFirstComment(Request $request) {
        $id=$request->get('commentId');
        $comment=DB::table("CRM.dbo.crm_comment")->where("id",$id)->select("newComment","nexComment")->first();
        return Response::json($comment);
    }


    public function getProductFactorsByCustomer(Request $request){
		$customerId=$request->get("customerId");
		$productId=$request->get("productId");
		$factors=DB::select("SELECT * FROM Shop.dbo.FactorHDS
							INNER JOIN Shop.dbo.FactorBYS
							ON SnFact=SerialNoHDS WHERE SnGood=$productId 
							AND FactType=3 and CustomerSn=$customerId ORDER BY FactDate DESC");
		return Response::json($factors);
	}
    
    public function getFactorDetail(Request $request){
        $fsn=$request->get("FactorSn");
        $orders=DB::select("SELECT FactorBYS.Price AS goodPrice, *  FROM Shop.dbo.FactorHDS
                    JOIN Shop.dbo.FactorBYS ON FactorHDS.SerialNoHDS=FactorBYS.SnFact 
                    JOIN Shop.dbo.Peopels ON FactorHDS.CustomerSn=Peopels.PSN
                    JOIN Shop.dbo.PubGoods ON FactorBYS.SnGood=PubGoods.GoodSn 
                    JOIN Shop.dbo.PUBGoodUnits ON PUBGoodUnits.USN=PubGoods.DefaultUnit
                    where FactorHDS.SerialNoHDS=".$fsn);
        
        foreach ($orders as $order) {
            $sabit="";
            $hamrah="";
            $phones=DB::table("Shop.dbo.PhoneDetail")->where("SnPeopel",$order->PSN)->get();
            foreach ($phones as $phone) {
                if($phone->PhoneType==1){
                    $sabit.=$phone->PhoneStr."\n";
                }else{
                    $hamrah.=$phone->PhoneStr."\n"; 
                }
            }
            $order->sabit=$sabit;
            $order->hamrah=$hamrah;
        }
        return Response::json($orders);
    }

    public function filterCustomers(Request $request){
        $kala=new Kala;
        $nameOrCodeOrPhone=$kala->changeToArabicLetterAndEngNumber($request->get("nameOrCodeOrPhone"));

        $recName=$request->get("recName");

        $lcationState=$request->get("locationState");

        $activationState=$request->get("activationState");

        $baseName=$request->get("baseName");

        $words=explode(" ",$nameOrCodeOrPhone);

        $queryPart=" ";

        $counter=count($words);
       
        foreach($words as $word){

            $counter-=1;

            if($counter>0){

                $queryPart.="Name LIKE '%$word%' AND ";

            }else{

                $queryPart.="Name LIKE '%$word%'";

            }
             
        }
        $customers;
        if(count($words)==1){
            $customers=DB::select("SELECT * FROM (SELECT PSN,CompanyNo,IsActive,PCode,Name,GroupCode
                    ,FORMAT(TimeStamp,'yyyy/MM/dd','fa-ir') as TimeStamp,
                    peopeladdress,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,
                    CRm.dbo.getCustomerMantagheh(SnMantagheh) as NameRec
                    ,CRM.dbo.checkUserLocation(PSN,$lcationState) as hasLocation
                    ,CRM.dbo.checkCustomerActivationState(PSN,$activationState) as activationState
                    FROM Shop.dbo.Peopels)a
                    WHERE CompanyNo=5 AND Name !='' AND (Name Like '%$nameOrCodeOrPhone%' OR 
                    PCode Like N'%$nameOrCodeOrPhone%' or PhoneStr Like N'%$nameOrCodeOrPhone%') AND 
                    NameRec like N'%$recName%' AND IsActive=1 AND hasLocation=$lcationState AND activationState=$activationState 
                    AND GroupCode in(291,1297,312,313,314,299) ORDER BY $baseName ASC");
        }else{
            $customers=DB::select("SELECT * FROM (SELECT PSN,CompanyNo,IsActive,PCode,Name,GroupCode
                    ,FORMAT(TimeStamp,'yyyy/MM/dd','fa-ir') as TimeStamp,
                    peopeladdress,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,
                    CRm.dbo.getCustomerMantagheh(SnMantagheh) as NameRec
                    ,CRM.dbo.checkUserLocation(PSN,$lcationState) as hasLocation
                    ,CRM.dbo.checkCustomerActivationState(PSN,$activationState) as activationState
                    FROM Shop.dbo.Peopels)a
                    WHERE CompanyNo=5 AND Name !='' AND ($queryPart) AND 
                    NameRec like N'%$recName%' AND IsActive=1 AND hasLocation=$lcationState AND activationState=$activationState 
                    AND GroupCode in(291,1297,312,313,314,299) ORDER BY $baseName ASC");            
        }
        return Response::json($customers);
    }

    public function searchCustomerForNotify(Request $request)
    {
       $searchTerm=$request->get("searchTerm");
       $firstDate=$request->get("firstDate");
       $secondDate=$request->get("secondDate");
       $snMantagheh=$request->get("snMantagheh");
       $SnNahiyeh=$request->get("SnNahiyeh");
	   $poshtibanName=$request->get("poshtibanName");
       $queryPart="AND SnMantagheh=$snMantagheh AND SnNahiyeh=$SnNahiyeh";

       if($snMantagheh==0 and $SnNahiyeh!=0){
            $queryPart="AND SnNahiyeh=$SnNahiyeh";
       }
       if($snMantagheh==0 and $SnNahiyeh==0){
            $queryPart="";
       }

       if($snMantagheh!=0 and $SnNahiyeh==0){
            $queryPart="AND SnMantagheh=$snMantagheh";
       }

        if(strlen($firstDate)<3 and strlen($secondDate)<3){
            $customers=DB::select("SELECT * FROM(SELECT *,CONCAT(name,lastName) as adminName FROM(
   SELECT c.admin_id,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,Name CustomerName,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,PCode,PSN from Shop.dbo.Peopels
   LEFT JOIN CRM.dbo.crm_customer_added c on Peopels.PSN=c.customer_id where c.returnState=0
   )a JOIN CRM.dbo.crm_admin  on a.admin_id=crm_admin.id)b
   WHERE IsActive=1 and CompanyNo=5 and adminName like '%$poshtibanName%' and exists(SELECT * FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=PSN AND LEN(mobileToken)>20) and ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or Pcode like '%$searchTerm%') $queryPart");
            return Response::json(['customers'=>$customers]);
        }else{
            if(strlen($firstDate)<3){

                $firstDate="1366/01/01";
    
            }
            if(strlen($secondDate)<3){
    
                $secondDate="1566/01/01";
                
            }
            $customers=DB::select("SELECT * FROM(SELECT *,CONCAT(name,lastName) as adminName FROM(
   SELECT c.admin_id,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,Name CustomerName,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,PCode,PSN from Shop.dbo.Peopels
   LEFT JOIN CRM.dbo.crm_customer_added c on Peopels.PSN=c.customer_id where c.returnState=0
   )a JOIN CRM.dbo.crm_admin  on a.admin_id=crm_admin.id)b
   WHERE IsActive=1 and CompanyNo=5 and adminName like '%$poshtibanName%' and exists(SELECT * FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=PSN AND LEN(mobileToken)>20) and ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or Pcode like '%$searchTerm%') $queryPart and exists(SELECT * FROM Shop.dbo.FactorHDS WHERE FactDate>='$firstDate' and FactDate<='$secondDate' and FactType=3 and CustomerSn=PSN)");
            return Response::json(['customers'=>$customers]);

        }
    }
	
	    public function searchCustomerSMS(Request $request){
		   $searchTerm=$request->get("searchTerm");
		   $firstDate=$request->get("firstDate");
		   $secondDate=$request->get("secondDate");

		   $firstDateNoBuy=$request->get("firstDateNoBuy");
		   $secondDateNoBuy=$request->get("secondDateNoBuy");

		   $snMantagheh=$request->get("snMantagheh");
		   $SnNahiyeh=$request->get("SnNahiyeh");
		   $customerState=$request->get("customerState");
		   $basketState=$request->get("basketState");
		   //$buyState=$request->get("buyState");

		   $queryPart="AND SnMantagheh=$snMantagheh AND SnNahiyeh=$SnNahiyeh";

		   if($snMantagheh==0 and $SnNahiyeh!=0){
				$queryPart="AND SnNahiyeh=$SnNahiyeh";
		   }
		   if($snMantagheh==0 and $SnNahiyeh==0){
				$queryPart="";
		   }

		   if($snMantagheh!=0 and $SnNahiyeh==0){
				$queryPart="AND SnMantagheh=$snMantagheh";
		   }
		   $customers;

			if((strlen($firstDate)<3 and strlen($secondDate)<3) and (strlen($firstDateNoBuy)<3 and strlen($secondDateNoBuy)<3)){
				if($customerState!=0){
					$customers=DB::select("SELECT * FROM(
											SELECT CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,
											CRM.dbo.getLastDateFactor(PSN) lastFactorDate
											,Name,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,GroupCode,PCode,PSN
											,CRM.dbo.getBascketState(PSN) as basketState FROM Shop.dbo.Peopels)a
											WHERE PSN in (SELECT c.customerId
														FROM CRM.dbo.crm_comment c
														INNER JOIN (
															SELECT customerId, MAX(TimeStamp) AS maxInsertDate
															FROM CRM.dbo.crm_comment
															GROUP BY customerId
														) AS sub
											ON c.customerId = sub.customerId AND c.TimeStamp = sub.maxInsertDate 
											where callResultState=$customerState)
											AND IsActive=1 AND GroupCode IN (291,297,299,312,313,314) and CompanyNo=5 and 
											basketState LIKE '%$basketState%'
											AND ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or 
											Pcode like '%$searchTerm%') $queryPart");
				}else{
					$customers=DB::select("SELECT * FROM(
						SELECT CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,CRM.dbo.getLastDateFactor(PSN) lastFactorDate
						,Name,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,GroupCode,PCode,PSN
						,CRM.dbo.getBascketState(PSN) as basketState FROM Shop.dbo.Peopels)a
						WHERE IsActive=1 and CompanyNo=5  AND GroupCode IN (291,297,299,312,313,314) and 
						basketState LIKE '%$basketState%'
						AND ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or Pcode like '%$searchTerm%') $queryPart");
				}
				return Response::json(['customers'=>$customers]);
			}else{
				$noBuyDateQuery="";
				$buyDateQuery="";
				if(strlen($firstDate)>3){

					$buyDateQuery="AND EXISTS(SELECT CustomerSn FROM Shop.dbo.FactorHDS 
								WHERE FactDate>='$firstDate' AND FactType=3 and CustomerSn=PSN)";

				}
				if(strlen($secondDate)>3){
					if(strlen($firstDate)<3){
						$firstDate="1399/01/01";
					}
						$buyDateQuery="AND EXISTS(SELECT CustomerSn FROM Shop.dbo.FactorHDS 
								WHERE FactDate>='$firstDate' AND FactDate<='$secondDate' AND FactType=3 and CustomerSn=PSN)";

				}
				
				
				if(strlen($firstDateNoBuy)>3){
					$noBuyDateQuery=" AND NOT EXISTS(SELECT CustomerSn FROM Shop.dbo.FactorHDS
								WHERE FactDate>='$firstDateNoBuy' AND FactType=3 and CustomerSn=PSN)";
				}
				if(strlen($secondDateNoBuy)>3){
					if(strlen($firstDateNoBuy)<3){
						$firstDateNoBuy="1399/01/01";
					}
					$noBuyDateQuery=" AND NOT EXISTS(SELECT CustomerSn FROM Shop.dbo.FactorHDS
									WHERE FactDate>='$firstDateNoBuy' AND FactDate<='$secondDateNoBuy' AND 
									FactType=3 and CustomerSn=PSN)";
				}
				$noBuyDateQuery=$buyDateQuery.$noBuyDateQuery;
				if($customerState!=0){
					$customers=DB::select("SELECT * FROM(
						SELECT CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,CRM.dbo.getLastDateFactor(PSN) lastFactorDate
						,Name,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,
						GroupCode,PCode,PSN,CRM.dbo.getBascketState(PSN) as basketState
						FROM Shop.dbo.Peopels)a
						WHERE PSN in (SELECT c.customerId
							FROM CRM.dbo.crm_comment c
							INNER JOIN (
								SELECT customerId, MAX(TimeStamp) AS maxInsertDate
								FROM CRM.dbo.crm_comment
								GROUP BY customerId
							) AS sub
						ON c.customerId = sub.customerId AND c.TimeStamp = sub.maxInsertDate where callResultState=$customerState)
						AND IsActive=1 and CompanyNo=5 and basketState LIKE '%$basketState%'
						AND ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or Pcode like '%$searchTerm%') $queryPart 
						AND GroupCode  IN(291,1297,312,313,299,314) $noBuyDateQuery");
				}else{
					
					$customers=DB::select("SELECT * FROM(
						SELECT CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,CRM.dbo.getLastDateFactor(PSN) lastFactorDate,Name
						,SnMantagheh,SnNahiyeh,IsActive,SaleLevel,CompanyNo,GroupCode,PCode,PSN,CRM.dbo.getBascketState(PSN) as basketState
						FROM Shop.dbo.Peopels)a
						WHERE  IsActive=1 and CompanyNo=5  AND basketState LIKE '%$basketState%'
						AND ((PhoneStr like '%$searchTerm%' or Name like '%$searchTerm%') or Pcode like '%$searchTerm%') $queryPart 
						AND GroupCode  IN(291,1297,299,312,313,314) $noBuyDateQuery");
				}
				return Response::json(['customers'=>$customers]);
        }
    }
	
public function getAllCustomersToMNM(Request $request)
	{
		$mantiqahId=$request->get("MantiqahId");
		$customers=DB::select("select Name,PCode,PSN,SnMantagheh,peopeladdress from Shop.dbo.Peopels where CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and Name!='' and SnMantagheh=0");
		$addedCustomers=DB::select("select Name,PCode,PSN,SnMantagheh,peopeladdress from Shop.dbo.Peopels where CompanyNo=5 and SnMantagheh=".$mantiqahId);
		return Response::json([$customers,$addedCustomers]);
	}
	
	
	public function searchCustomerByAddressMNM(Request $request)
{
    $searchTerm=$request->get("searchTerm");
    $customers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE peopeladdress LIKE '%".$searchTerm."%' AND CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=0");
    return Response::json($customers);
}
public function searchCustomerByNameMNM(Request $request)
{
    $searchTerm=$request->get("searchTerm");
    $customers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE Name LIKE '%".$searchTerm."%' AND CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=0");
    return Response::json($customers);
}
public function searchCustomerAddedAddressMNM(Request $request)
{
    $searchTerm=$request->get("searchTerm");
    $mantiqahId=$request->get("mantiqahId");
    $customers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE peopeladdress LIKE '%".$searchTerm."%' AND CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=".$mantiqahId);
    return Response::json($customers);
}
public function searchCustomerAddedNameMNM(Request $request)
{
    $searchTerm=$request->get("searchTerm");
    $mantiqahId=$request->get("mantiqahId");
    $customers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE Name LIKE '%".$searchTerm."%' AND CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=".$mantiqahId);
    return Response::json($customers);
}
public function addCustomerToMantiqah(Request $request)
{
    $customerIDs=$request->get("customerIDs");
    $mantiqahId=$request->get("mantiqahId");
    $cityId=$request->get("cityId");
    foreach ($customerIDs as $id) {
        DB::table("Shop.dbo.Peopels")->where('PSN',$id)->update(["SnMantagheh"=>$mantiqahId,'SnNahiyeh'=>$cityId,'SnMasir'=>79]);
    }
    $addedCustomers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=".$mantiqahId);
    $customers=DB::select("select Name,PCode,PSN,SnMantagheh,peopeladdress from Shop.dbo.Peopels where CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and Name!='' and SnMantagheh=0");
    return Response::json([$customers,$addedCustomers]);
}
public function removeCustomerFromMantiqah(Request $request)
{
    $customerIds=$request->get("customerIDs");
    $mantiqahId=$request->get("mantiqahId");
    foreach ($customerIds as $id) {
        DB::table("Shop.dbo.Peopels")->where("PSN",$id)->update(["SnMantagheh"=>0]);
    }
    $addedCustomers=DB::select("SELECT Name,peopeladdress,PCode,PSN FROM Shop.dbo.Peopels WHERE CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and SnMantagheh=".$mantiqahId);
    $customers=DB::select("select Name,PCode,PSN,SnMantagheh,peopeladdress from Shop.dbo.Peopels where CompanyNo=5 and GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).") and Name!='' and SnMantagheh=0");
    return Response::json([$customers,$addedCustomers]);
}



public function getInviteCodeApi(Request $request){
    $cusotmerId=$request->input("psn");
    $selfInviteCode="4444444444";
    $selfInviteCodes=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$cusotmerId)->get();
    if(count($selfInviteCodes)>0){
        $selfInviteCode=$selfInviteCodes[0]->selfIntroCode;
    }

    $profiles=DB::select("SELECT Peopels.Name,PSN,selfIntroCode FROM  Shop.dbo.Peopels Join NewStarfood.dbo.star_customerRestriction on PSN=customerId
    where Peopels.CompanyNo=5 and  Peopels.PSN=".$cusotmerId);
    $profile;
    foreach ($profiles as $profile1) {
        $profile=$profile1;
    }

    $invitedCustomers=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction INNER JOIN Shop.dbo.Peopels on customerId=PSN where introducerCode='$selfInviteCode'");
    return Response::json(['invitedCustomers'=>$invitedCustomers,'profile'=>$profile]);
}


	

	
	public function inviteCode(){
		$selfInviteCode="4444444444";
		$selfInviteCodes=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",Session::get("psn"))->get();
		if(count($selfInviteCodes)>0){
			$selfInviteCode=$selfInviteCodes[0]->selfIntroCode;
		}

        $profiles=DB::select("SELECT Peopels.Name,PSN,selfIntroCode FROM  Shop.dbo.Peopels Join NewStarfood.dbo.star_customerRestriction on PSN=customerId
        where Peopels.CompanyNo=5 and  Peopels.PSN=".Session::get('psn'));
        $profile;
        foreach ($profiles as $profile1) {
            $profile=$profile1;
        }

		$invitedCustomers=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction INNER JOIN Shop.dbo.Peopels on customerId=PSN where introducerCode='$selfInviteCode'");
		return view('customer.inviteCode',['invitedCustomers'=>$invitedCustomers,'profile'=>$profile]);
	}
	
	    public function logout(Request $request)
    {
        DB::delete("DELETE FROM NewStarfood.dbo.star_customerSession1 where   sessionId ='".Session::getId()."' and customerId=".Session::get('psn'));
        Session::forget('psn');
        Session::forget('username');
        return redirect('/login');
    }
    public function login(Request $request)
    {
        return  view('login.login');
    }
    public function checkUser(Request $request)
    {
        $this->validate($request,[
                'username'=>'string|required|max:2000|min:3',
                'password'=>'required|min:3|max:54'],
                [
                'required' => 'فیلد نباید خالی بماند',
                'username.max'=>'متن طویل است طویل است',
                'username.min'=>'متن زیاد کوناه است'
                ]
        );

        $customers=DB::select("SELECT Peopels.PSN,Peopels.Name,Peopels.PeopelEghtesadiCode,PhoneDetail.PhoneStr,customerPss,userName from Shop.dbo.Peopels 
                    join Shop.dbo.PhoneDetail on Peopels.PSN=PhoneDetail.SnPeopel
                    join NewStarfood.dbo.star_CustomerPass on Peopels.PSN=star_CustomerPass.customerId
                    where Peopels.CompanyNo=5 and peopels.GroupCode IN ( ".implode(",",[291,297,299,312,313,314]).")");
        $exist=0;
        $userName;
        $sessions;
        $psn=0;
        $mobileToken=$request->post("token");
        foreach ($customers as $customer) {
            if ($customer->userName==$request->post('username') and $customer->customerPss==$request->post('password')){
                $exist=1;
                $userName=$customer->Name;
                $psn=$customer->PSN;
            }
        }
        $allowMobile=0;
        //writ a query to get many mobile after comming at night
        $allowedMobiles=DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$psn)->select("manyMobile")->get();
        foreach ($allowedMobiles as $mobile) {
            $allowMobile=$mobile->manyMobile;
        }


        if($exist==1){
            if($allowMobile>0){
                
                $countLogin=DB::table('star_customerSession1')->where("customerId",$psn)->get()->count();

                $allowanceCountUser=DB::table('star_customerRestriction')->where("customerId",$psn)->select('manyMobile')->get();
                $allowedDevice=1;
                foreach ($allowanceCountUser as $allowanceTedad) {
                    $allowedDevice=$allowanceTedad->manyMobile;
                }
                $sessionKeyId="";
                if($countLogin<$allowedDevice){
                                //set session
                    if($countLogin>0){
                    $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
                    Session::put('FiscallYear',$fiscallYear);
                    Session::put('username', $userName);
                    Session::put('psn',$psn);
                    Session::put('groups',[291,297,299,312,313,314]);
                    $palatform=BrowserDetect::platformFamily();
                    $browser=BrowserDetect::browserFamily();
                    DB::insert("INSERT INTO star_customerSession1(customerId,sessionId,platform,browser,mobileToken) VALUES($psn,'".Session::getId()."','$palatform','$browser','$mobileToken')");
                    }else{
                        Session::put('tmpPSN',$psn);
                        Session::put('tmpNAME',$userName);
                        Session::put('mobileToken',$mobileToken);
                        return view('customer.introducerModal');
                    }
                }else{
                    Session::put('tmpPSN',$psn);
                    Session::put('tmpNAME',$userName);
                    Session::put('mobileToken',$mobileToken);
                    return redirect('/customerConfirmation');
                }
                $SnLastBuy;
                $SnLastBuy=DB::table('factorStar')->where('orderStatus',0)->where('CustomerSn',Session::get('psn'))->get()->max('SnOrder');

                if($SnLastBuy){
                    $allBuys=0;
                    $allBuys=DB::table('orderStar')->where('SnHDS',$SnLastBuy)->get()->count();
                    Session::put('buy',$allBuys);
                }else{
                    Session::put('buy',0);
                }
                    return redirect("/home");
            }else{
                //به مشتری اطلاع داده شود که مشکل چیست
                $error="با دفتر شرکت در تماس شوید";
                return view('login.login')->with(['loginError'=>$error]);
            }
        }else{
            //به مشتری اطلاع داده شود که مشکل چیست
            $credentialError="نام کاربری و یا رمز ورود اشتباه است";
            return view('login.login')->with(['loginError'=>$credentialError]);
        }
    }
    public function customerConfirmation(Request $request)
    {
        $sessionKeys=DB::table('star_customerSession1')->where('customerId',Session::get('tmpPSN'))->get();
        return view('customer.modalLog',['sessionIds'=>$sessionKeys]);
    }
    public function logOutConfirm(Request $request)
    {
        list($sessionId,$customerId)=explode('__',$request->post('selectedDevice'));
        $mobileToken=Session::get('mobileToken');
        Session::getHandler()->destroy($sessionId);
        DB::delete("DELETE FROM NewStarfood.dbo.star_customerSession1 WHERE sessionId ='".$sessionId."' AND customerId=".$customerId);
        Session::put('username', Session::get('tmpNAME'));
        Session::put('psn', Session::get('tmpPSN'));
        $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
        Session::put('FiscallYear',$fiscallYear);
        Session::forget('tmpNAME');
        Session::forget('tmpPSN');
        $palatform=BrowserDetect::platformFamily();
        $browser=BrowserDetect::browserFamily();
        DB::insert("INSERT INTO NewStarfood.dbo.star_customerSession1(customerId,sessionId,platform,browser,mobileToken) VALUES($customerId,'".Session::getId()."','$palatform','$browser','$mobileToken')");
        
        $orderHDSs=DB::select("SELECT MAX(SnOrder) AS maxorder FROM NewStarfood.dbo.factorStar WHERE orderStatus=0 AND CustomerSn=".Session::get('psn'));
        $SnLastBuy=0;
        $SnLastBuy=$orderHDSs[0]->maxorder;
		
        if($SnLastBuy){
			$allBuys=0;
			$orederBYS=DB::select("SELECT COUNT(SnOrderBYS) as allBuys FROM NewStarfood.dbo.orderStar where SnHDS=".$SnLastBuy);
			$allBuys=$orederBYS[0]->allBuys;
			Session::put('buy',$allBuys);
    	}else{
        	Session::put('buy',0);
    	}
        return redirect("/home");
    }

    public function addIntroducerCode(Request $request)
    {
        $introCode=$request->post("introCode");
        if(strlen(trim($introCode))<1){
            $introCode='AAA';
        }
        Session::put('username', Session::get('tmpNAME'));
        Session::put('psn', Session::get('tmpPSN'));
		$customerSn= Session::get('tmpPSN');
        $mobileToken=Session::get('mobileToken');
        $specialSettings=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting");
        $fiscallYear=$specialSettings[0]->FiscallYear;
        Session::put('FiscallYear',$fiscallYear);
        $palatform=BrowserDetect::platformFamily();
        $browser=BrowserDetect::browserFamily();
        $introBonusAmount=$specialSettings[0]->useIntroBonus;
        $introMoneyAmount=$specialSettings[0]->useIntroMoney;
        DB::insert("INSERT INTO NewStarfood.dbo.star_customerSession1(customerId,sessionId,platform,browser,mobileToken) VALUES($customerSn,'".Session::getId()."','$palatform','$browser','$mobileToken')");
        if(strlen(trim($introCode))>3 and trim($introCode) !='AAA'){

            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction SET introducerCode='$introCode' WHERE customerId=$customerSn");
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction SET introBonusAmount+=$introBonusAmount,introMoneyAmount+=$introMoneyAmount WHERE selfIntroCode='$introCode'");
        }
        $orderHDSs=DB::select("SELECT MAX(SnOrder) AS maxorder FROM NewStarfood.dbo.factorStar WHERE orderStatus=0 and CustomerSn=$customerSn");
        $SnLastBuy=0;
        $SnLastBuy=$orderHDSs[0]->maxorder;
		
        if($SnLastBuy){
			$allBuys=0;
			$orederBYS=DB::select("SELECT COUNT(SnOrderBYS) as allBuys FROM NewStarfood.dbo.orderStar where SnHDS=".$SnLastBuy);
			$allBuys=$orederBYS[0]->allBuys;
			Session::put('buy',$allBuys);
    	}else{
        	Session::put('buy',0);
    	}

        return redirect("/home");
    }

	public function wallet(Request $request){
		$allMoneyTakhfifResult=self::getTakhfifCaseMoneyBeforeNazarSanji(Session::get("psn"));
		$customerSn=Session::get("psn");
		$attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");
		if(count($attractionVisit)<1){
			DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerSn
																	   ,"Game" => 0
																	   ,"MoneyCase" => 1
																	   ,"Discount" => 0
																	   ,"StarfoodStar" => 0
																	   ,"ViewDate" => new DateTime()]);
		}else{
			DB::table("NewStarfood.dbo.star_attractionVisit")
						->where("CustomerId",$customerSn)
						->update(["MoneyCase" => 1,"ViewDate" => new DateTime()]);
		
		}
		$attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");
		$nazars=DB::select("SELECT * FROM NewStarfood.dbo.star_nazarsanji join NewStarfood.dbo.star_question on star_nazarsanji.id=star_question.nazarId where nazarId=(select max(id) from NewStarfood.dbo.star_nazarsanji)");
	
		return view('customer.wallet',['moneyTakhfif'=>$allMoneyTakhfifResult,'nazars'=>$nazars,'$attractionVisit'=>$attractionVisit]);
		
	}

	public function getTakhfifCaseMoneyBeforeNazarSanji($customerId){ //برای محاسبه کیف تخفیفی
		//درصد تخفیف عمومی سایت
        $defaultPercent=DB::select("SELECT percentTakhfif FROM NewStarfood.dbo.star_webSpecialSetting")[0]->percentTakhfif;
		//محدودیت های شخصی
        $restrictions=DB::select("SELECT * FROM NewStarfood.dbo.star_customerRestriction where customerId=$customerId")[0];
        $personalPercent=$restrictions->percentTakhfif;	//درصد تخفیف شخصی
        $introMoneyAmount=$restrictions->introMoneyAmount; // مقدار پول شخصی که در نتیجه معرفی دیگران به دست می آورد
        if($personalPercent){
            $lastPercentTakhfif=$personalPercent;
        }else{
            $lastPercentTakhfif=$defaultPercent;
        }
        $allMoneyTakhfifResult=0;
		
		// آخرین تاریخی که از کیف تخفیف استفاده نموده است.
        $lastUsedDate='2022-12-31 20:49:51.000';
		
        $lastUsedHistoryDate=DB::table("NewStarfood.dbo.star_takhfifHistory")->where("customerId",$customerId)->max("usedDate");
		
        if($lastUsedHistoryDate){	// اگر قبلا از کیف پول استفاده شده بود.
            $lastUsedDate=$lastUsedHistoryDate;
        }
		
        $allMoneyTakhfif=DB::select("SELECT SUM(NetPriceHDS)*$lastPercentTakhfif/100 AS SummedAllMoney FROM Shop.dbo.GetAndPayHDS 
                                    WHERE CompanyNo=5 AND GetOrPayHDS=1 AND FiscalYear=1402
									and DocDate>FORMAT(CAST('$lastUsedDate' As datetime),'yyyy/MM/dd','fa-ir') 
									AND PeopelHDS=".$customerId);
		
        $allMoneyTakhfifResult=($allMoneyTakhfif[0]->SummedAllMoney)+$introMoneyAmount;
		
        return $allMoneyTakhfifResult;
    }

	public function getTakhfifCaseMoneyAfterNazarSanji($customerId){// مقدار پولی که به کیف تخفیف آمده وتا کنون استفاده نشده است
        $discountCase=0;
        $discountCase=DB::table("NewStarfood.dbo.star_takhfifHistory")
			->where("customerId",$customerId)->where("isUsed",0)->sum("money");
        return $discountCase;
    }

	public function addMoneyToCase(Request $request){
        $customerSn=Session::get("psn");
        $takhfif=$request->get("takhfif");
        $restrictions=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$customerSn)->get();
        $personalPercentTakhfif=$restrictions[0]->percentTakhfif;
        $introductionMoney=$restrictions[0]->introMoneyAmount;
        if($personalPercentTakhfif){
            $takhfifPercent=$personalPercentTakhfif;
        }else{
            $takhfifPercent= DB::table("NewStarfood.dbo.star_webSpecialSetting")->get()[0]->percentTakhfif;
        }
        $answer1=$request->get("answer1");
        $answer2=$request->get("answer2");
        $answer3=$request->get("answer3");
        $nazarId=$request->get("nazarId");
        DB::table("NewStarfood.dbo.star_answers")->insert([
            "answer1"=>"".$answer1.""
            ,"answer2"=>"".$answer2.""
            ,"answer3"=>"".$answer3.""
            ,"customerId"=>$customerSn
            ,"nazarId"=>$nazarId
            ]);
        
        DB::table("NewStarfood.dbo.star_takhfifHistory")->insert(['customerId'=>$customerSn
                            ,'money'=>($takhfif+$introductionMoney)
                            ,'discription'=>""
                            ,'changeDate'=>"".Jalalian::fromCarbon(Carbon::now())->format("Y/m/d").""
                            ,'lastPercent'=>$takhfifPercent
                            ,'isUsed'=>0]);
        DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$customerSn)->update(['introMoneyAmount'=>0]);
        return redirect("/home");
    }

	public function getTargetsAndBonuses($customerId) {	//امتیازات و لاتاری محاسبه می شود.
		$lottery=new Lottery;
        $count_All_aghlam=0;//تعداد اقلام خرید شده
        $sumAllFactor=0;//مجموع پول خرید شده
        $aghlamComTg="هیچکدام";
        //آخرین تارگت تکمیل شده مشتری
        $aghlamComTgBonus=0;//امتیازات آخرین تارگت
        $monyComTg="هیچکدام";
        //آخرین تارگت تکمیل شده مبلغ
        $monyComTgBonus=0;//امتیازات آخرین تارگت مبلغ
        $lotteryMinBonus=0;//حد اقل امتیاز برای فعاسازی شانس لاتری
        $allBonus=0;//مجموع امتیازات
        $lastPercentTakhfif=0;
        //محاسبه امتیازات مشتری
        $maxDateOfTryLottery=DB::select("SELECT MAX(timestam) AS lastTryDate FROM NewStarfood.dbo.star_TryLottery 
										WHERE customerId=$customerId group by customerId");
		// آخرین تاریخ گردش چرخونه
        $lastTryDate='2023-01-07 18:36:08.000';
		
        if(count($maxDateOfTryLottery)>0){
                $lastTryDate=$maxDateOfTryLottery[0]->lastTryDate;
        }
		// حد اقل امتیاز مورد نیاز چرخونه
        $lotteryMinBonus=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get("lotteryMinBonus")[0]->lotteryMinBonus;
		// مبلغ پولها بعد از چرخونه
        $allMoneyTillNow=DB::select("SELECT SUM(NetPriceHDS)/10 AS allMoney FROM SHop.dbo.FactorHDS WHERE FactType=3 
									AND FactorHDS.CompanyNo=5 AND CustomerSn=$customerId 
									AND FactDate>FORMAT(CAST('$lastTryDate' AS datetime),'yyyy/MM/dd','fa-ir') 
									GROUP BY CustomerSn");
		
        if(count($allMoneyTillNow)>0){
            $sumAllFactor=$allMoneyTillNow[0]->allMoney;
        }
		// تعداد اقلام بعد از چرخونه
        $countAghlam=DB::select("SELECT count(SnGood) AS countGood,CustomerSn FROM(
								SELECT * FROM (SELECT MAX(TimeStamp)AS maxTime,SnGood,CustomerSn FROM(
								SELECT * FROM(
									SELECT FactorBYS.TimeStamp,FactorBYS.Fi,FactorBYS.Amount,FactorBYS.SnGood,CustomerSn 
									FROM Shop.dbo.FactorHDS
									JOIN Shop.dbo.FactorBYS ON FactorHDS.SerialNoHDS=FactorBYS.SnFact)a
									)g WHERE CONVERT(DATE,TimeStamp)>CONVERT(date,'".$lastTryDate."') GROUP BY SnGood,CustomerSn)c
									)e WHERE CustomerSn=$customerId GROUP BY CustomerSn");
		
        if(count($countAghlam)>0){
            $count_All_aghlam=$countAghlam[0]->countGood;
        }
        //معیارهای از قبل تعریف شده ای امتیازات
        $targets=DB::table("NewStarfood.dbo.star_customer_baseBonus")->get();
        //تارگت‌های مبلغ خرید
		$installSelfBonus=0;
        foreach($targets as $target){
            if($target->id==1){
				// اگر هنوز چرخونه را بازی نکرده بود از امتیاز نصب برخوردار است.
				if($lottery->checkTryLottery($customerId)<1){
                    $installSelfBonus=$target->firstTargetBonus;
				}
            }
            if($target->id==2){
                if($sumAllFactor >= $target->thirdTarget){
                    $monyComTg="تارگیت سوم";
                    $monyComTgBonus=$target->thirdTargetBonus;
                }else{
                    if($sumAllFactor >= $target->secondTarget){
                        $monyComTg="تارگیت دوم";
                        $monyComTgBonus=$target->secondTargetBonus;
                    }else{
                        if($sumAllFactor >= $target->firstTarget){
                            $monyComTg="تارگیت اول";
                            $monyComTgBonus=$target->firstTargetBonus;
                        }
                    }
                }
            }
                //تارگت‌های اقلام خرید
            if($target->id==3){
                if($count_All_aghlam >= $target->thirdTarget){
                    $aghlamComTg="تارگیت سوم";
                    $aghlamComTgBonus=$target->thirdTargetBonus;
                }else{
                    if($count_All_aghlam >= $target->secondTarget){
                        $aghlamComTg="تارگیت دوم";
                        $aghlamComTgBonus=$target->secondTargetBonus;
                    }else{
                        if($count_All_aghlam >= $target->firstTarget){
                            $aghlamComTg="تارگیت اول";
                            $aghlamComTgBonus=$target->firstTargetBonus;
                        }
                    }
                }
            }
        }

		$starBonus=0;

		$starPresentBonus=DB::table("star_weeklyPresentHistory")->where("CustomerSn",$customerId)->where("isUsed",0)->get();

		if(count($starPresentBonus)>0){

			$starBonus=$starPresentBonus[0]->bonus;

		}

        $customerRestrictionBonuses=DB::select("SELECT introBonusAmount,remainedBonus FROM NewStarfood.dbo.star_customerRestriction WHERE customerId=$customerId");
        $introBonus=$customerRestrictionBonuses[0]->introBonusAmount;
        $remainedBonus=$customerRestrictionBonuses[0]->remainedBonus;
        //محاسبه همه امتیازات
        $allBonus=$aghlamComTgBonus+$monyComTgBonus+$installSelfBonus+$introBonus+$starBonus+$remainedBonus;

        return [$monyComTg,$aghlamComTg,$monyComTgBonus,$aghlamComTgBonus,$lotteryMinBonus,$allBonus];
    }


    public function setWeeklyPresentApi(Request $request){
		$currentDay=$request->input("dayPr");
		$customerId=$request->input("psn");
        $bonus=$request->input("bonus");

		$isExist=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE $currentDay=0 and CustomerId=$customerId");
		if(count($isExist)>0){
		 	DB::table("NewStarfood.dbo.star_presentCycle")->where("CustomerId",$customerId)->update(["$currentDay"=>1]);
		 	$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
            $allCycleHistory=DB::table("NewStarfood.dbo.star_weeklyPresentHistory")->where("CustomerSn",$customerId)->where("isUsed",0)->get();

            if(count($allCycleHistory)<1){
                DB::table("NewStarfood.dbo.star_weeklyPresentHistory")->insert(["bonus"=>5,"isUsed"=>0,"CustomerSn"=>$customerId]);
            }else{
                DB::update("update NewStarfood.dbo.star_weeklyPresentHistory SET bonus +=$bonus WHERE CustomerSn=$customerId AND isUsed=0");
            }
		 }

       return Response::json(1);
    }





	public function setWeeklyPresent(Request $request){
		$currentDay=explode("_",$request->get("currentDay"))[0];
		$customerId=Session::get("psn");
		$isExist=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE $currentDay=0 and CustomerId=$customerId");
		$currentDayBonusField=explode("_",$request->get("currentDay"))[1].'B';
		if(count($isExist)>0){
			DB::table("NewStarfood.dbo.star_presentCycle")->where("CustomerId",$customerId)->update(["$currentDay"=>1]);
			$presentInfo=DB::select("SELECT * FROM NewStarfood.dbo.star_presentCycle WHERE CustomerId=$customerId");
			$bonus=$presentInfo[0]->$currentDayBonusField;
				$allCycleHistory=DB::table("NewStarfood.dbo.star_weeklyPresentHistory")
					->where("CustomerSn",$customerId)
					->where("isUsed",0)->get();
				
				if(count($allCycleHistory)<1){
					DB::table("NewStarfood.dbo.star_weeklyPresentHistory")->insert
						(["bonus"=>5
						  ,"isUsed"=>0
						  ,"CustomerSn"=>$customerId]);
				}else{
					DB::update("update NewStarfood.dbo.star_weeklyPresentHistory SET bonus +=$bonus WHERE CustomerSn=$customerId AND isUsed=0");
				}
		}

       return Response::json(1);
    }

    public function indexApi (Request $request)
    {
        $customerSn=$request->get("psn");
        $profiles=DB::select("SELECT Peopels.Name,PSN,selfIntroCode,CRM.dbo.getCustomerPhoneNumbers(PSN) AS PhoneStr FROM  Shop.dbo.Peopels Join NewStarfood.dbo.star_customerRestriction on PSN=customerId
        where Peopels.CompanyNo=5 and  Peopels.PSN=$customerSn");
        $profile;
        foreach ($profiles as $profile1) {
            $profile=$profile1;
        }

        $checkOfficialExistance=DB::table("NewStarfood.dbo.star_Customer")->where("customerShopSn",$customerSn)->count();
        $officialAllowed=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$customerSn)->get();

        $officialstate=0;
        foreach ($officialAllowed as  $off) {
            if($off->activeOfficialInfo==1){
                $officialstate = 1;
            }else {
            $officialstate = 0 ;
            }
        }

        $haqiqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','haqiqi')->where('customerShopSn', $customerSn)->select("*")->get();
        $exacHaqiqi=array();
        foreach ($haqiqiCustomers as $haqiqiCustomer) {
            $exacHaqiqi=$haqiqiCustomer;
        }

        $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->where('customerShopSn', $customerSn)->select("*")->get();
        $exactHoqoqi=array();
        foreach ($hoqoqiCustomers as $hoqoqicustomer) {
            $exactHoqoqi=$hoqoqicustomer;
        }

        $factors=DB::select("SELECT TOP 5 FactorHDS.* FROM  Shop.dbo.FactorHDS  where FactorHDS.CustomerSn=$customerSn AND  FactType=3 ORDER BY FactDate DESC");
        $orders=DB::select("SELECT  NewStarfood.dbo.OrderHDSS.* FROM  NewStarfood.dbo.OrderHDSS WHERE isSent=0 AND isDistroy=0 AND CustomerSn=$customerSn");
        foreach ($orders as $order) {
            $orederPrice=0;
            $prices=DB::select("SELECT Price FROM  NewStarfood.dbo.OrderBYSS where SnHDS=".$order->SnOrder);
            foreach ($prices as $price) {
                $orederPrice+=$price->Price;
            }
            $order->Price=$orederPrice;
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

        return Response::json(['profile'=>$profile, 'exactHoqoqi'=>$exactHoqoqi, 'exacHaqiqi'=>$exacHaqiqi,'checkOfficialExistance'=>$checkOfficialExistance,'factors'=>$factors,'orders'=>$orders,'officialstate'=>$officialstate,'currency'=>$currency,'currencyName'=>$currencyName]);
    }

    public function walletApi(Request $request)
    {
    $customerSn=$request->get("psn");
    $allMoneyTakhfifResult=self::getTakhfifCaseMoneyBeforeNazarSanji($customerSn);
    $nazars=DB::select("SELECT * FROM NewStarfood.dbo.star_nazarsanji Join NewStarfood.dbo.star_question ON star_nazarsanji.id=star_question.nazarId WHERE nazarId=(SELECT MAX(id) FROM NewStarfood.dbo.star_nazarsanji)");
    return Response::json(['moneyTakhfif'=>$allMoneyTakhfifResult,'nazars'=>$nazars]);
    }

    public function addMoneyToCaseApi(Request $request)
    {
        $customerSn=$request->input("psn");
        $takhfif=$request->input("takhfif");
        $takhfifPercent=0;

        $restrictions=DB::table("NewStarfood.dbo.star_customerRestriction")->where("customerId",$customerSn)->get();
        $personalPercentTakhfif=$restrictions[0]->percentTakhfif;
        $introductionMoney=$restrictions[0]->introMoneyAmount;
        if($personalPercentTakhfif){
            $takhfifPercent=$personalPercentTakhfif;
        }else{
            $takhfifPercent= DB::table("NewStarfood.dbo.star_webSpecialSetting")->get()[0]->percentTakhfif;
        }
        $answer1=$request->input("answer1");
        $answer2=$request->input("answer2");
        $answer3=$request->input("answer3");
        $nazarId=$request->input("nazarId");
        DB::table("NewStarfood.dbo.star_answers")->insert([
            "answer1"=>"".$answer1.""
            ,"answer2"=>"".$answer2.""
            ,"answer3"=>"".$answer3.""
            ,"customerId"=>$customerSn
            ,"nazarId"=>$nazarId
            ]);
        
        DB::table("NewStarfood.dbo.star_takhfifHistory")->insert(['customerId'=>$customerSn
                            ,'money'=>($takhfif+$introductionMoney)
                            ,'discription'=>""
                            ,'changeDate'=>"".Jalalian::fromCarbon(Carbon::now())->format("Y/m/d").""
                            ,'lastPercent'=>$takhfifPercent
                            ,'isUsed'=>0]);
        DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$customerSn)->update(['introMoneyAmount'=>0]);
        return Response::json(['respond'=>'done']);
    }
    public function logOutConfirmApi(Request $request)
    {
        $sessionId=$request->get("token");
        $customerId=$request->get("customerId");
        $browser;
        $palatform;

        $user = Star_CustomerPass::where('customerId', $customerId)->first();

        DB::delete("DELETE FROM NewStarfood.dbo.star_customerSession1 WHERE sessionId ='".$sessionId."' and customerId=".$customerId);
        DB::delete("DELETE FROM NewStarfood.dbo.personal_access_tokens WHERE token ='".$sessionId."'");

        $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;

        $newToken= $user->createToken(trim($user->userName), [''])->plainTextToken;

        $palatform=BrowserDetect::platformFamily();

        $browser=BrowserDetect::browserFamily();

        DB::insert("INSERT INTO NewStarfood.dbo.star_customerSession1(customerId,sessionId,platform,browser) VALUES (".$customerId.",'$newToken','".$palatform."','".$browser."')");

        $orderHDSs=DB::select("SELECT MAX(SnOrder) AS maxorder FROM NewStarfood.dbo.factorStar WHERE orderStatus=0 and CustomerSn=$customerId");
        
        $SnLastBuy=0;

        $SnLastBuy=$orderHDSs[0]->maxorder;

        $allBuys=0;

        if($SnLastBuy){

			$orederBYS=DB::select("SELECT COUNT(SnOrderBYS) as allBuys FROM NewStarfood.dbo.orderStar where SnHDS=".$SnLastBuy);
			
            $allBuys=$orederBYS[0]->allBuys;

    	}

        return Response::json(['token'=>$newToken,'buyAmount'=>$allBuys,'userName'=>$user->userName,'psn'=>$customerId]);
    }

    public function addIntroducerCodeApi(Request $request)
    {
        $introCode=$request->get("introCode");
        $psn=$request->get("customerId");
        $token=$request->get("token");
        $specialSettings=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting");
        $fiscallYear=$specialSettings[0]->FiscallYear;
        Session::put('FiscallYear',$fiscallYear);
        $palatform=BrowserDetect::platformFamily();
        $browser=BrowserDetect::browserFamily();
        $introBonusAmount=$specialSettings[0]->useIntroBonus;
        $introMoneyAmount=$specialSettings[0]->useIntroMoney;
        DB::insert("INSERT INTO NewStarfood.dbo.star_customerSession1(customerId,sessionId,platform,browser) VALUES($psn,'$token','".$palatform."','".$browser."')");
        if(strlen(trim($introCode))>3 and trim($introCode) !='AAA'){
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set introducerCode='$introCode' where customerId=$psn");
            DB::update("UPDATE NewStarfood.dbo.star_customerRestriction set introBonusAmount+=$introBonusAmount,introMoneyAmount+=$introMoneyAmount WHERE selfIntroCode='$introCode'");
        }
        $orderHDSs=DB::select("SELECT MAX(SnOrder) AS maxorder FROM NewStarfood.dbo.factorStar WHERE orderStatus=0 and CustomerSn=".$psn);
        $SnLastBuy=0;
        $SnLastBuy=$orderHDSs[0]->maxorder;
        $allBuys=0;

        if($SnLastBuy){
			$orederBYS=DB::select("SELECT COUNT(SnOrderBYS) as allBuys FROM NewStarfood.dbo.orderStar where SnHDS=".$SnLastBuy);
			$allBuys=$orederBYS[0]->allBuys;
    	}

        return Response::json(['buyAmount'=>$allBuys]);

    }
    public function  getCustomerForOrder(Request $request){
        $nameOrPhone=$request->input("namePhone");
        $searchByPhone=$request->input("searchByPhone");
        $customers;
        if(strlen($searchByPhone)>0){
            $customers=DB::select("SELECT * FROM(
                SELECT PSN,PCode, Name,0 as countBuy,0 as countSale,GroupCode,0 as chequeCountReturn,0 as chequeMoneyReturn,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,CompanyNo,IsActive
                FROM Shop.dbo.Peopels)a WHERE PhoneStr LIKE '%$nameOrPhone%' AND CompanyNo=5 and IsActive=1");
        }else{
            $customers=DB::select("SELECT PSN,PCode, Name,0 as countBuy,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,0 as countSale,0 as chequeCountReturn,0 as chequeMoneyReturn
                                    FROM Shop.dbo.Peopels WHERE Name LIKE '%$nameOrPhone%' AND CompanyNo=5 and IsActive=1");
        }
    
        return Response::json($customers);
    }
    public function getInfoOfOrderCustomer(Request $request){

        $psn=$request->input("psn");
        $exactCustomer=DB::select("SELECT * FROM(SELECT *,CRM.dbo.getCustomerPhoneNumbers(PSN)PhoneStr FROM Shop.dbo.Peopels WHERE PSN=$psn)a 
                                    LEFT JOIN(SELECT * FROM Shop.dbo.ViewStatusPeopel  WHERE FiscalYear=1402)b ON a.PSN=b.CustomerSn");
        return Response::json($exactCustomer);
    }
    public function getCustomerByCode(Request $request)
    {
        $pcode=$request->get("PCode");
        $customers=DB::select("SELECT * FROM (SELECT PSN,Name,AddressPeopel,SnPeopelAddress,peopeladdress FROM Shop.dbo.Peopels LEFT JOIN Shop.dbo.PeopelAddress ON PSN=PeopelAddress.SnPeopel  WHERE PCode = '$pcode' AND GroupCode IN(291,297,299,312,313,314) AND Peopels.CompanyNo=5)a  LEFT JOIN (SELECT * FROM Shop.dbo.ViewStatusPeopel  WHERE FiscalYear=1402)b ON a.PSN=b.CustomerSn");
        return Response::json($customers);
    }

    public function getCustomerGardish(Request $request) {
        $psn=$request->input("psn");
        $firstDate="1396/01/01";
        $secondDate="1500/01/01";
        $fiscallYear=$request->input("fiscalYear");
        if($request->input("firstDate")){
            if(strlen($request->input("firstDate"))>3){
                $firstDate=$request->input("firstDate");

            }

        }
        if($request->input("secondDate")){
            if(strlen($request->input("secondDate"))>3){
                $secondDate=$request->input("secondDate");

            }

        }
        $customerGardish=DB::select("exec NewStarfood.dbo.getCustomerGardishProc $psn,$fiscallYear,'$firstDate','$secondDate'");
        return response()->json(['customerGardish'=>$customerGardish]);
    }
    function getCustomerInfoByCode(Request $request) {
        $pcode=$request->input("pcode");
        $customers=DB::select("SELECT * FROM Shop.dbo.Peopels WHERE PCode=$pcode AND IsActive=1 and CompanyNo=5");
        return Response::json($customers);
    }



    function renewCustomerGardish(Request $request) {
        
    }
    
    }
