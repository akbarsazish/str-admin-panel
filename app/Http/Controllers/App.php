<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use BrowserDetect;
use DateTime;
use Response;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
class App extends Controller{
    public function removeNotify(Request $request){
        DB::table("NewStarfood.dbo.star_takhfifHistory")->where("isUsed",1)->update(['isSeen'=>1]);
        return Response::json(1);
    }
    public function aboutUs(Request $request) {
        return View("siteInfo.aboutUs");
    }

    public function policy(Request $request){
        return View("siteInfo.policy");
    }

    public function contactUs(Request $request){
        return View("siteInfo.contactUs");
    }

    public function privacy(Request $request){
        return View("siteInfo.privacy");
    }

	public function callUs(Request $request){
        return view('siteInfo.contact');
    }

	public function guide() {
        return view('siteInfo.appGuidence');
    }

    public function doUpdatewebSpecialSettings(Request $request){
            $maxSale=$request->post("maxSale");
            $minSalePriceFactor=str_replace(",", "",$request->post("minSalePriceFactor"));
			$showDeleteNotificationMSG=$request->post("showNotificationMSG");
           // $lotteryMinBonus=str_replace(",", "",$request->post("lotteryMinBonus"));
            $moorningTimeContent=$request->post("moorningTimeContent");
            $afternoonTimeContent=$request->post("afternoonTimeContent");
            $whatsappNumber=$request->post("whatsappNumber");
            $instagramId=$request->post("instagramId");
            $telegramId=$request->post("telegramId");
            $firstDayMoorningActive=$request->post("firstDayMoorningActive");
            $firstDayAfternoonActive=$request->post("firstDayAfternoonActive");
            $secondDayMoorningActive=$request->post("secondDayMoorningActive");
            $secondDayAfternoonActive=$request->post("secondDayAfternoonActive");
            $favoriteDateMoorningActive=$request->post("favoriteDateMoorningActive");
            $favoriteDateAfternoonActive=$request->post("favoriteDateAfternoonActive");
            $startImediatOrder=$request->post("startImediatTime");
            $endImediatOrder=$request->post("endImediatTime");
            $buyFromHome=$request->post("buyFromHome");
            $enamad=$request->post("enamad");
			$enamadOther=$request->post("enamadOther");
			$logoPosition=$request->post("logoPosition");
            $selectHome=$request->post("selectHome");
            $fiscallYear=$request->post("fiscallYear");
            $currency=$request->post("currency");
            $percentTakhfif=str_replace("/", ".",$request->post("percentTakhfif"));
            $useIntroMoney=str_replace(",", "",$request->post("useIntroMoney"));
            $useIntroPercent=str_replace("/", ".",$request->post("useIntroPercent"));
            $useIntroMonth=str_replace(",", "",$request->post("useIntroMonth"));
            $apk=$request->file("uploadAPK");

            $firstPrize=str_replace(",", "",$request->post("firstPrize"));
            $secondPrize=str_replace(",", "",$request->post("secondPrize"));
            $thirdPrize=str_replace(",", "",$request->post("thirdPrize"));
            $fourthPrize=str_replace(",", "",$request->post("fourthPrize"));
            $fifthPrize=str_replace(",", "",$request->post("fifthPrize"));
            $sixthPrize=str_replace(",", "",$request->post("sixthPrize"));
            $seventhPrize=str_replace(",", "",$request->post("seventhPrize"));
            $eightthPrize=str_replace(",", "",$request->post("eightthPrize"));
            $ninthPrize=str_replace(",", "",$request->post("ninthPrize"));
            $teenthPrize=str_replace(",", "",$request->post("teenthPrize"));
            $gameId=$request->input("gameId");


            if($apk){
                $fileName=$apk->getClientOriginalName();
            list($a,$b)=explode(".",$fileName);
            $fileName="starfood."."apk";
            $apk->move("resources/assets/apks/",$fileName);
            }
            if($buyFromHome){
                $buyFromHome=1;
            }else{
                $buyFromHome=0;
            }
			if($showDeleteNotificationMSG){
				$showNotificationMSG=1;
			}else{
				$showNotificationMSG=0;
			}
            if($enamad){
                $enamad=1;
            }else{
                $enamad=0;
            }
		    if($enamadOther){
                $enamadOther=1;
            }else{
                $enamadOther=0;
            }
            if($firstDayMoorningActive){
                $firstDayMoorningActive=1;
            }else{
                $firstDayMoorningActive=0;
            }
            if($firstDayAfternoonActive){
                $firstDayAfternoonActive=1;
            }else{
                $firstDayAfternoonActive=0;
            }
            if($secondDayMoorningActive){
                $secondDayMoorningActive=1;
            }else{
                $secondDayMoorningActive=0;
            }
            if($secondDayAfternoonActive){
                $secondDayAfternoonActive=1;
            }else{
                $secondDayAfternoonActive=0;
            }
            if($favoriteDateMoorningActive){
                $favoriteDateMoorningActive=1;
            }else{
                $favoriteDateMoorningActive=0;
            }
            if($favoriteDateAfternoonActive){
                $favoriteDateAfternoonActive=1;
            }else{
                $favoriteDateAfternoonActive=0;
            }
            DB::update("UPDATE NewStarfood.dbo.star_webSpecialSetting SET maxSale=".$maxSale.",
            minSalePriceFactor=".$minSalePriceFactor.",moorningTimeContent='".$moorningTimeContent."',
            afternoonTimeContent='".$afternoonTimeContent."',whatsappNumber='".$whatsappNumber."',
            instagramId='".$instagramId."',telegramId='".$telegramId."',
            firstDayMoorningActive=".$firstDayMoorningActive.",firstDayAfternoonActive=".$firstDayAfternoonActive.",
            secondDayMoorningActive=".$secondDayMoorningActive.",secondDayAfternoonActive=".$secondDayAfternoonActive.",
            FavoriteDateMoorningActive=".$favoriteDateMoorningActive.",FavoriteDateAfternoonActive=".$favoriteDateAfternoonActive.",
            defaultStock=23,currency=".$currency.",buyFromHome=".$buyFromHome.",homePage=".$selectHome.",FiscallYear=".$fiscallYear.",
            percentTakhfif=$percentTakhfif,enamad=$enamad,logoPosition=$logoPosition,
            firstPrize=$firstPrize,
            secondPrize=$secondPrize,
            thirdPrize=$thirdPrize,
            fourthPrize=$fourthPrize,
            fifthPrize=$fifthPrize,
            sixthPrize=$sixthPrize,
            seventhPrize=$seventhPrize,
            eightPrize=$eightthPrize,
            ninthPrize=$ninthPrize,
            teenthPrize=$teenthPrize,
            useIntroMoney=$useIntroMoney,
            useIntroPercent=$useIntroPercent,
            useIntroMonth=$useIntroMonth,
			showDeleteNotification=$showNotificationMSG,
		    startTimeImediatOrder='$startImediatOrder',
			endTimeImediatOrder='$endImediatOrder',
			enamadOther=$enamadOther,
            gameId=$gameId"
        );
            $specialSettings=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting");
            $settings=[];
            foreach ($specialSettings as $setting) {
                $settings=$setting;
            }
            $stocks=DB::select("SELECT SnStock,CompanyNo,CodeStock,NameStock from Shop.dbo.Stocks where SnStock!=0 and NameStock!='' and CompanyNo=5");
            $removableStocks=$request->post("removeStocksFromWeb");
            $addableStocks=$request->post("addedStocksToWeb");
            if($addableStocks){
                foreach ($addableStocks as $stock) {
                    list($id,$name)=explode('_',$stock);
                    DB::table("NewStarfood.dbo.addedStocks")->insert(['stockId'=>$id]);
                }
            }
            if($removableStocks){
                foreach ($removableStocks as $stock) {
                    if($stock!='on'){
                    list($id,$name)=explode('_',$stock);
                    DB::table("NewStarfood.dbo.addedStocks")->where('stockId',$id)->delete();
                    }
                }
            }
            $addedStocks=DB::table("NewStarfood.dbo.addedStocks")->join("Shop.dbo.Stocks","addedStocks.stockId","=","SnStock")->select("*")->get();
            return redirect("/controlMainPage");
    }
    

    public function downloadApk(Request $request) {
        $headers =  [ 
            'Content-Type'=>'application/vnd.android.package-archive',
            'Content-Disposition'=> 'attachment; filename="starfood001.apk"',
            ];

        return response()->file(base_path('resources\\assets\\apks\\starfood001.apk') , $headers);
    }

    public function getAttractiveVisits(Request $request) {
        $psn=$request->input("psn");
        $attractions=DB::select("SELECT  *,CONVERT(DATE,ViewDate) AS ViewJustDate FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$psn");
        return Response::json($attractions);
    }

    public function setAttractiveVisits(Request $request){
        $customerSn=$request->input("psn");
        $pageName=$request->input("attractionName");
        $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");
        switch ($pageName) {
            case 'Game':
                {
                    if(count($attractionVisit)<1){
                        DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerSn
                                                                                ,"Game" => 1
                                                                                ,"MoneyCase" => 0
                                                                                ,"Discount" => 0
                                                                                ,"StarfoodStar" => 0
                                                                                ,"ViewDate" => new DateTime()]);
                    }else{
                        DB::table("NewStarfood.dbo.star_attractionVisit")
                            ->where("CustomerId",$customerSn)
                            ->update(["Game" => 1,"ViewDate" => new DateTime()]);
            
                    }
                }
                break;
            
                case 'MoneyCase':
                    {
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
                    }
                    break;
                case 'Discount':
                    {
                        if(count($attractionVisit)<1){
                            DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerSn
                                                                                    ,"Game" => 0
                                                                                    ,"MoneyCase" => 0
                                                                                    ,"Discount" => 1
                                                                                    ,"StarfoodStar" => 0
                                                                                    ,"ViewDate" => new DateTime()]);
                        }else{
                            DB::table("NewStarfood.dbo.star_attractionVisit")
                                ->where("CustomerId",$customerSn)
                                ->update(["Discount" => 1,"ViewDate" => new DateTime()]);
                
                        }
                    }
                    break;
                case 'StarfoodStar':
                    {
                        if(count($attractionVisit)<1){
                            DB::table("NewStarfood.dbo.star_attractionVisit")->insert(["CustomerId" => $customerSn
                                                                                    ,"Game" => 0
                                                                                    ,"MoneyCase" => 0
                                                                                    ,"Discount" => 0
                                                                                    ,"StarfoodStar" => 1
                                                                                    ,"ViewDate" => new DateTime()]);
                        }else{
                            DB::table("NewStarfood.dbo.star_attractionVisit")
                                ->where("CustomerId",$customerSn)
                                ->update(["StarfoodStar" => 1,"ViewDate" => new DateTime()]);
                
                        }
                    }
                    break;
        }

        return Response::json("done");
    }


    function getFiscalYears() {
        $fiscallYears=DB::select("select * from Shop.dbo.FiscalYearList WHERE CompanyNo=5");
        return response()->json($fiscallYears, 200);
    }
    function getEnamadState(Request $request) {
        $enamadInfo;
        $enamadInfo=DB::select("SELECT enamad FROM NewStarfood.dbo.star_webSpecialSetting")[0];
        return Response::json(['enamadState'=>$enamadInfo]);
    }
}
