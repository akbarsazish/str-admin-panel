<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Response;
use Session;
use Notification;
use Illuminate\Support\Facades\Http;
use App\Notifications\AlertNotification;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use DateTime;
class Admin extends Controller{
    public function index(Request $request){
        $contNewMessage=DB::select("SELECT COUNT(id) as countMessage FROM NewStarfood.dbo.star_message where readState=0");
        $countMessage;
        foreach ($contNewMessage as $countMessage) {
            $countMessage=$countMessage->countMessage;
        }
        Session::put('countMessage');
        return view('admin.dashboard');
    }
    public function listKarbaran(Request $request){
        $admins=DB::select("SELECT * FROM NewStarfood.dbo.admin");
        $shopAdmins=DB::select("SELECT * FROM Shop.dbo.Users WHERE CompanyNo=5 AND SnUser!=0");
        return view('admin.listKarbaran',['admins'=>$admins,'shopAdmins'=>$shopAdmins]);
    }

    public function doAddAdmin(Request $request){
        $username=$request->post('userName');

        $password=$request->post('password');

        $name=$request->post("name");

        $lastname=$request->post("lastName");

        $adminType=$request->post("AdminTypeN");

        $sex=$request->post("gender");

        $shopAdmin=$request->input("shopAdmin");

        // اگر اطلاعات پایه روشن بود
        $baseInfoN = $request->post("baseInfoN");
        $settingsN;
        $mainPageSetting;
        $specialSettingN;
        $emptyazSettingN;

         if($baseInfoN=="on"){
            $baseInfoN = 1;

            $settingsN = $request->post("settingsN");
            if($settingsN = "on"){
                $settingsN = 1;
                    
                //تنظیمات صفحه اصلی با سه عنصر اش چک گردد
                    $mainPageSetting = $request->post("mainPageSetting");
                    $deletMainPageSettingN = $request->post("deletMainPageSettingN");
                    $editManiPageSettingN = $request->post("editManiPageSettingN");
                    $seeMainPageSettingN = $request->post("seeMainPageSettingN");

                    if($mainPageSetting=="on"){
                        $mainPageSetting=1;
                        if($deletMainPageSettingN=="on"){
                            $mainPageSetting=2;
                        }elseif($editManiPageSettingN=="on" and $deletMainPageSettingN!="on"){
                            $mainPageSetting=1;
                        }elseif($editManiPageSettingN !="on" and $seeMainPageSettingN =="on"){
                            $mainPageSetting=0;
                        }else{
                            $mainPageSetting=-1;
                        }
                    }else{
                        $mainPageSetting=-1;
                    }

                //تنظیمات اختصاصی با سه عنصر اش چک گردد
                    $specialSettingN = $request->post("specialSettingN");
                    $deleteSpecialSettingN = $request->post("deleteSpecialSettingN");
                    $editSpecialSettingN = $request->post("editSpecialSettingN");
                    $seeSpecialSettingN = $request->post("seeSpecialSettingN");

                    if($specialSettingN=="on"){
                        if($deleteSpecialSettingN=="on"){
                            $specialSettingN=2;
                        }elseif($editSpecialSettingN=="on" and $deleteSpecialSettingN!="on"){
                            $specialSettingN=1;
                        }elseif($editSpecialSettingN !="on" and $seeSpecialSettingN =="on"){
                            $specialSettingN=0;
                        }else{
                            $specialSettingN=-1;
                        }
                    }else{
                        $specialSettingN=-1;
                    }

                //تنظیمات امتیاز با سه عنصر اش چک گردد
                    $emptyazSettingN = $request->post("emptyazSettingN");
                    $deleteEmtyazSettingN = $request->post("deleteEmtyazSettingN");
                    $editEmptyazSettingN = $request->post("editEmptyazSettingN");
                    $seeEmtyazSettingN = $request->post("seeEmtyazSettingN");

                    if($emptyazSettingN=="on"){
                        if($deleteEmtyazSettingN=="on"){
                            $emptyazSettingN=2;
                        }elseif($editEmptyazSettingN=="on" and $deleteEmtyazSettingN!="on"){
                            $emptyazSettingN=1;
                        }elseif($editEmptyazSettingN !="on" and $seeEmtyazSettingN =="on"){
                            $emptyazSettingN=0;
                        }else{
                            $emptyazSettingN=-1;
                        }
                    }else{
                        $emptyazSettingN=-1;
                    }

                }else{
                    $settingsN = -1;
                    $mainPageSetting = -1;
                    $specialSettingN = -1;
                    $emptyazSettingN = -1;
                }

            }else{
                $baseInfoN = -1;
                $settingsN = -1;
                $mainPageSetting = -1;
                $specialSettingN = -1;
                $emptyazSettingN = -1;
            } 
            // ختم اطلاعات پایه 


        // اگر تعریف عناصر روشن بود 
        $defineElementN = $request->post("defineElementN");
        $defineElementN;
        $karbaranN;
        $customersN;
        if($defineElementN = "on"){
            $defineElementN=1;
             $karbaranN = $request->post("karbaranN");
                if($karbaranN=="on"){
                    $karbaranN=1;
                    $customersN = $request->post("customersN");
                    $deleteCustomersN = $request->post("deleteCustomersN");
                    $editCustomerN = $request->post("editCustomerN");
                    $seeCustomersN = $request->post("seeCustomersN");

                        if($customersN=="on"){
                                if($deleteCustomersN=="on"){
                                    $customersN=2;
                                }elseif($editCustomerN=="on" &&  $deleteCustomersN!="on"){
                                    $customersN=1;    
                                }elseif($seeCustomersN=="on" && $editCustomerN!="on"){
                                    $customersN=0;
                                }else{
                                    $customersN=-1;
                                }
                        }else {
                            $customersN=-1;
                        }
                   
                }else{
                  $karbaranN = -1;
                  $customersN=-1;
                }
        }else{
            $defineElementN = -1;
            $karbaranN = -1;
            $customersN=-1;
        }



        // اگر عملیات روشن بود 
        $operationN = $request->post("operationN");
        $operationN;
        $kalasN;
        $kalaListsN;
        $requestedKalaN;
        $fastKalaN;
        $pishKharidN;
        $brandsN;
        $alertedN;
        $kalaGroupN;
        $orderSalesN;
        $messageN;
        $factorN;
        $bargiriN;

        if($operationN=="on"){
            $operationN=1;
                $kalasN = $request->post("kalasN");
                if($kalasN=="on"){
                    $kalasN=1;
                    // چک کردن لیست کالا ها با سه تا عناصر اش
                        $kalaListsN=$request->post("kalaListsN");
                        $deleteKalaListN=$request->post("deleteKalaListN");
                        $editKalaListN=$request->post("editKalaListN");
                        $seeKalaListN=$request->post("seeKalaListN");

                        if($kalaListsN=="on"){
                                if($deleteKalaListN=="on"){
                                    $kalaListsN=2;
                                }elseif($editKalaListN=="on" && $deleteKalaListN!="on"){
                                    $kalaListsN=1;
                                }elseif($seeKalaListN=="on" && $editKalaListN!="on"){
                                    $kalaListsN=0;
                                }else{
                                    $kalaListsN=-1;
                                }

                        }else{
                            $kalaListsN=-1;
                        }

                        // چک کردن کالا های درخواستی با سه تا عناصر اش
                        $requestedKalaN=$request->post("requestedKalaN");
                        $deleteRequestedKalaN=$request->post("deleteRequestedKalaN");
                        $editRequestedKalaN=$request->post("editRequestedKalaN");
                        $seeRequestedKalaN=$request->post("seeRequestedKalaN");

                        if($requestedKalaN=="on"){
                                if($deleteRequestedKalaN=="on"){
                                    $requestedKalaN=2;
                                }elseif($editRequestedKalaN=="on" && $deleteRequestedKalaN!="on"){
                                    $requestedKalaN=1;
                                }elseif($seeRequestedKalaN=="on" && $editRequestedKalaN!="on"){
                                    $requestedKalaN=0;
                                }else{
                                    $requestedKalaN=-1;
                                }

                        }else{
                            $requestedKalaN=-1;
                        }
                     // چک کردن فست کالا با سه تا عناصر اش
                        $fastKalaN=$request->post("fastKalaN");
                        $deleteFastKalaN=$request->post("deleteFastKalaN");
                        $editFastKalaN=$request->post("editFastKalaN");
                        $seeFastKalaN=$request->post("seeFastKalaN");

                        if($fastKalaN=="on"){
                                if($deleteFastKalaN=="on"){
                                    $fastKalaN=2;
                                }elseif($editFastKalaN=="on" && $deleteFastKalaN!="on"){
                                    $fastKalaN=1;
                                }elseif($seeFastKalaN=="on" && $editFastKalaN!="on"){
                                    $fastKalaN=0;
                                }else{
                                    $fastKalaN=-1;
                                }

                        }else{
                            $fastKalaN=-1;
                        }

                        
                    // چک کردن پیش خرید با سه تا عناصر اش
                        $pishKharidN=$request->post("fastKalaN");
                        $deletePishKharidN=$request->post("deletePishKharidN");
                        $editPishkharidN=$request->post("editPishkharidN");
                        $seePishKharidN=$request->post("seePishKharidN");

                        if($pishKharidN=="on"){
                                if($deletePishKharidN=="on"){
                                    $pishKharidN=2;
                                }elseif($editPishkharidN=="on" && $deletePishKharidN!="on"){
                                    $pishKharidN=1;
                                }elseif($seePishKharidN=="on" && $editPishkharidN!="on"){
                                    $pishKharidN=0;
                                }else{
                                    $pishKharidN=-1;
                                }

                        }else{
                            $pishKharidN=-1;
                        }

                         // چک کردن  برند ها با سه تا عناصر اش
                        $brandsN=$request->post("fastKalaN");
                        $deleteBrandsN=$request->post("deleteBrandsN");
                        $editBrandN=$request->post("editBrandN");
                        $seeBrandsN=$request->post("seeBrandsN");

                        if($brandsN=="on"){
                                if($deleteBrandsN=="on"){
                                    $brandsN=2;
                                }elseif($editBrandN=="on" && $deleteBrandsN!="on"){
                                    $brandsN=1;
                                }elseif($seeBrandsN=="on" && $editBrandN!="on"){
                                    $brandsN=0;
                                }else{
                                    $brandsN=-1;
                                }

                        }else{
                            $brandsN=-1;
                        }


                     // چک کردن کالاهای شامل هشدار با سه تا عناصر اش
                        $alertedN=$request->post("fastKalaN");
                        $deleteAlertedN=$request->post("deleteAlertedN");
                        $editAlertedN=$request->post("editAlertedN");
                        $seeAlertedN=$request->post("seeAlertedN");

                        if($alertedN=="on"){
                                if($deleteAlertedN=="on"){
                                    $alertedN=2;
                                }elseif($editAlertedN=="on" && $deleteAlertedN!="on"){
                                    $alertedN=1;
                                }elseif($seeAlertedN=="on" && $editAlertedN!="on"){
                                    $alertedN=0;
                                }else{
                                    $alertedN=-1;
                                }

                        }else{
                            $alertedN=-1;
                        }


                     // چک کردن  دسته بندی کالاها با سه تا عناصر اش
                        $kalaGroupN=$request->post("kalaGroupN");
                        $deletKalaGroupN=$request->post("deletKalaGroupN");
                        $editKalaGroupN=$request->post("editKalaGroupN");
                        $seeKalaGroupN=$request->post("seeKalaGroupN");
                        if($kalaGroupN=="on"){
                                if($deletKalaGroupN=="on"){
                                    $kalaGroupN=2;
                                }elseif($editKalaGroupN=="on" && $deletKalaGroupN!="on"){
                                    $kalaGroupN=1;
                                }elseif($seeKalaGroupN=="on" && $editKalaGroupN!="on"){
                                    $kalaGroupN=0;
                                }else{
                                    $kalaGroupN=-1;
                                }

                        }else{
                            $kalaGroupN=-1;
                        }

                     // چک کردن  سفارشات فروش با سه تا عناصر اش
                        $orderSalesN=$request->post("kalaGroupN");
                        $deleteOrderSalesN=$request->post("deleteOrderSalesN");
                        $editOrderSalesN=$request->post("editOrderSalesN");
                        $seeSalesOrderN=$request->post("seeSalesOrderN");
                        if($orderSalesN=="on"){
                                if($deleteOrderSalesN=="on"){
                                    $orderSalesN=2;
                                }elseif($editOrderSalesN=="on" && $deleteOrderSalesN!="on"){
                                    $orderSalesN=1;
                                }elseif($seeSalesOrderN=="on" && $editOrderSalesN!="on"){
                                    $orderSalesN=0;
                                }else{
                                    $orderSalesN=-1;
                                }

                        }else{
                            $orderSalesN=-1;
                        }

                     // چک کردن پیام ها با سه تا عناصر اش
                        $messageN=$request->post("kalaGroupN");
                        $deleteMessageN=$request->post("deleteMessageN");
                        $editMessageN=$request->post("editMessageN");
                        $seeMessageN=$request->post("seeMessageN");
                        if($messageN=="on"){
                            if($deleteMessageN=="on"){
                                $messageN=2;
                            }elseif($editMessageN=="on" && $deleteMessageN!="on"){
                                $messageN=1;
                            }elseif($seeMessageN=="on" && $editMessageN!="on"){
                                $messageN=0;
                            }else{
                                $messageN=-1;
                            }

                        }else{
                            $messageN=-1;
                        }

                    // چک کردن فاکتور فروش با سه تا عناصرش
                    $factorN=$request->post("factorN");
                    $deleteFactorN=$request->post("deleteFactorN");
                    $editFactorN=$request->post("editFactorN");
                    $seeFactorN=$request->post("seeFactorN");
                    if($factorN=="on"){
                        if($deleteFactorN=="on"){
                            $factorN=2;
                        }elseif($editFactorN=="on" && $deleteFactorN!="on"){
                            $factorN=1;
                        }elseif($seeFactorN=="on" && $editFactorN!="on"){
                            $factorN=0;
                        }else{
                            $factorN=-1;
                        }

                    }else{
                        $factorN=-1;
                    }
                    // چک کردن بارگیری با سه تا عناصرش
                    $bargiriN=$request->post("bargiriN");
                    $deleteBargiriN=$request->post("deleteBargiriN");
                    $editBargiriN=$request->post("editBargiriN");
                    $seeBargiriN=$request->post("seeBargiriN");
                    if($bargiriN=="on"){
                        if($deleteBargiriN=="on"){
                            $bargiriN=2;
                        }elseif($editBargiriN=="on" && $deleteBargiriN!="on"){
                            $bargiriN=1;
                        }elseif($seeBargiriN=="on" && $editBargiriN!="on"){
                            $bargiriN=0;
                        }else{
                            $bargiriN=-1;
                        }

                    }else{
                        $bargiriN=-1;
                    }
                    }else{
                        $kalasN=-1;
                        $kalaListsN=-1;
                        $requestedKalaN=-1;
                        $fastKalaN=-1;
                        $pishKharidN=-1;
                        $brandsN=-1;
                        $alertedN=-1;
                        $orderSalesN=-1;
                        $messageN=-1;
                        $bargiriN=-1;
                        $factorN=-1;
                    }
                }else{
                    $operationN =-1;
                    $operationN=-1;
                    $kalasN=-1;
                    $kalaListsN=-1;
                    $requestedKalaN=-1;
                    $fastKalaN=-1;
                    $pishKharidN=-1;
                    $brandsN=-1;
                    $alertedN=-1;
                    $kalaGroupN=-1;
                    $orderSalesN=-1;
                    $messageN=-1;
                    $bargiriN=-1;
                    $factorN=-1;
                }

        
        // اگر گزارشات روشن بود 
        $reportN = $request->post("reportN");
        $reportCustomerN;
        $customerListN;
        $officialCustomerN;
        $gameAndLotteryN;
        $lotteryResultN;
        $gamerListN;
        $onlinePaymentN;

        if($reportN=="on") {
            $reportN=1;
            // اگر مشتریان روشن بود 
            $reportCustomerN = $request->post();
            if($reportCustomerN=="on"){

                // لیست مشتریان با سه تا عناصرش چک گردد 
                    $customerListN=$request->post("customerListN");
                    $deletCustomerListN=$request->post("deletCustomerListN");
                    $editCustomerListN=$request->post("editCustomerListN");
                    $seeCustomerListN=$request->post("seeCustomerListN");
                    if($customerListN=="on"){
                            if($deletCustomerListN=="on"){
                                $customerListN=2;
                            }elseif($editCustomerListN=="on" && $deletCustomerListN!="on"){
                                $customerListN=1;
                            }elseif($seeCustomerListN=="on" && $editCustomerListN!="on"){
                                $customerListN=0;
                            }else{
                                $customerListN=-1;
                            }

                    }else{
                        $customerListN=-1;
                    }

                // لیست مشتریان با سه تا عناصرش چک گردد 
                    $officialCustomerN=$request->post("officialCustomerN");
                    $deleteOfficialCustomerN=$request->post("deleteOfficialCustomerN");
                    $editOfficialCustomerN=$request->post("editOfficialCustomerN");
                    $seeOfficialCustomerN=$request->post("seeOfficialCustomerN");
                    if($officialCustomerN=="on"){
                        if($deleteOfficialCustomerN=="on"){
                            $officialCustomerN=2;
                        }elseif($editOfficialCustomerN=="on" && $deleteOfficialCustomerN!="on"){
                            $officialCustomerN=1;
                        }elseif($seeOfficialCustomerN=="on" && $editOfficialCustomerN!="on"){
                            $officialCustomerN=0;
                        }else{
                            $officialCustomerN=-1;
                        }
                    }else{
                        $officialCustomerN=-1;
                    }

            }else{
                $reportCustomerN=-1;
                $customerListN=-1;
                $officialCustomerN=-1;
            }


            // اگر گیم و لاتری روشن بود 

             $gameAndLotteryN = $request->post("gameAndLotteryN");
             if($gameAndLotteryN=="on"){
                $gameAndLotteryN=1;
                  // نتجه لاتری با سه تا عناصرش چک گردد 
                    $lotteryResultN=$request->post("kalaGroupN");
                    $deletLotteryResultN=$request->post("deletLotteryResultN");
                    $editLotteryResultN=$request->post("editLotteryResultN");
                    $seeLotteryResultN=$request->post("seeLotteryResultN");
                    if($lotteryResultN=="on"){
                            if($deletLotteryResultN=="on"){
                                $lotteryResultN=2;
                            }elseif($editLotteryResultN=="on" && $deletLotteryResultN!="on"){
                                $lotteryResultN=1;
                            }elseif($seeLotteryResultN=="on" && $editLotteryResultN!="on"){
                                $lotteryResultN=0;
                            }else{
                                $lotteryResultN=-1;
                            }

                    }else{
                        $lotteryResultN=-1;
                    }

                  // لیست گیمر ها با سه تا عناصرش چک گردد
                    $gamerListN=$request->post("kalaGroupN");
                    $deletGamerListN=$request->post("deletGamerListN");
                    $editGamerListN=$request->post("editGamerListN");
                    $seeGamerListN=$request->post("seeGamerListN");
                    if($gamerListN=="on"){
                            if($deletGamerListN=="on"){
                                $gamerListN=2;
                            }elseif($editGamerListN=="on" && $deletGamerListN!="on"){
                                $gamerListN=1;
                            }elseif($seeGamerListN=="on" && $editGamerListN!="on"){
                                $gamerListN=0;
                            }else{
                                $gamerListN=-1;
                            }
                    }else{
                        $gamerListN=-1;
                    }

             }else{
                $gameAndLotteryN=-1;
             }

            // اگر پرداخت انلاین روشن بود 
                $onlinePaymentN = $request->post("onlinePaymentN");
                $deleteOnlinePaymentN=$request->post("deleteOnlinePaymentN");
                $editOnlinePaymentN=$request->post("editOnlinePaymentN");
                $seeOnlinePaymentN=$request->post("seeOnlinePaymentN");
                if($onlinePaymentN=="on"){
                        if($deleteOnlinePaymentN=="on"){
                            $onlinePaymentN=2;
                        }elseif($editOnlinePaymentN=="on" && $deleteOnlinePaymentN!="on"){
                            $onlinePaymentN=1;
                        }elseif($seeOnlinePaymentN=="on" && $editOnlinePaymentN!="on"){
                            $onlinePaymentN=0;
                        }else{
                            $onlinePaymentN=-1;
                        }

                }else{
                    $onlinePaymentN=-1;
                }

        }else{
            $reportN = -1;
            $reportCustomerN= -1;
            $customerListN= -1;
            $officialCustomerN= -1;
            $gameAndLotteryN= -1;
            $lotteryResultN= -1;
            $gamerListN= -1;
            $onlinePaymentN= -1;
        }

   
        
        DB::insert("INSERT INTO NewStarfood.dbo.admin (name,lastName,userName,password,activeState,sex,address,adminType,ShopAdminSn)

        VALUES('".$name."','".$lastname."','".$username."','".$password."',1,'$sex','','$adminType',$shopAdmin)");
        
        $lastId=DB::table("NewStarfood.dbo.admin")->max('id');

        DB::table("NewStarfood.dbo.star_hasAccess1")->insert(
        ['adminId'=>$lastId
        ,'baseInfoN'=>$baseInfoN
        ,'settingsN'=>$settingsN,
        'mainPageSetting'=>$mainPageSetting
        ,'specialSettingN'=>$specialSettingN
        ,'emptyazSettingN'=>$emptyazSettingN
        ,'defineElementN'=>$defineElementN
        ,'karbaranN'=>$karbaranN
        ,'customersN'=>$customersN
        ,'operationN'=>$operationN
        ,'kalasN'=>$kalasN
        ,'kalaListsN'=>$kalaListsN
        ,'requestedKalaN'=>$requestedKalaN
        ,'fastKalaN'=>$fastKalaN
        ,'pishKharidN'=>$pishKharidN
        ,'brandsN'=>$brandsN
        ,'alertedN'=>$alertedN
        ,'kalaGroupN'=>$kalaGroupN
        ,'orderSalesN'=>$orderSalesN
        ,'messageN'=>$messageN
        ,'reportN'=>$reportN
        ,'reportCustomerN'=>$reportCustomerN
        ,'customerListN'=>$customerListN
        ,'officialCustomerN'=>$officialCustomerN
        ,'gameAndLotteryN'=>$gameAndLotteryN
        ,'lotteryResultN'=>$lotteryResultN
        ,'gamerListN'=>$gamerListN
        ,'onlinePaymentN'=>$onlinePaymentN
        ,'factorN'=>$factorN
        ,'bargiriN'=>$bargiriN
    ]);
        return redirect("/listKarbaran");
    

 }



    /////////////////////////// ویرایش سطح دسترسی /////////////////////////////

    public function doEditAdmin(Request $request){
        $adminId=$request->post("adminId");
	
        $activeState=$request->post("activeState");
        if($activeState){
            $activeState=1;
        }else{
            $activeState=0;
        }
        //refactor codes
        $userName=$request->post('userName');

        $password=$request->post('password');

        $name=$request->post("name");

        $lastName=$request->post("lastName");

        $adminType=$request->post("adminType");

        $sex=$request->post("gender");

        DB::update("UPDATE NewStarfood.dbo.admin set name='".$name."',lastName='".$lastName."',userName='".$userName."',password='".$password."',activeState=".$activeState.",adminType='".$adminType."',sex='".$sex."' where id=".$adminId);
        $homePageDelete=$request->post("homeDelete");
        $homePageEdit=$request->post("changeHomePage");
        $homePageSee=$request->post("seeHomePage");

        $username=$request->post('userName');
        $password=$request->post('password');
        $name=$request->post("name");
        $lastname=$request->post("lastName");
        $adminType=$request->post("AdminTypeN");
        $sex=$request->post("gender");



        // اگر اطلاعات پایه روشن بود
        $baseInfoED = $request->post("baseInfoED");
        $settingsED;
        $mainPageSetting;
        $specialSettingED;
        $emptyazSettingED;

         if($baseInfoED=="on"){
            $baseInfoED = 1;

            $settingsED = $request->post("settingsED");
            if($settingsED = "on"){
                $settingsED = 1;
                    
                //تنظیمات صفحه اصلی با سه عنصر اش چک گردد
                    $mainPageSetting = $request->post("mainPageSetting");
                    $deletMainPageSettingED = $request->post("deletMainPageSettingED");
                    $editManiPageSettingED = $request->post("editManiPageSettingED");
                    $seeMainPageSettingED = $request->post("seeMainPageSettingED");

                    if($mainPageSetting=="on"){
                        $mainPageSetting=1;
                        if($deletMainPageSettingED=="on"){
                            $mainPageSetting=2;
                        }elseif($editManiPageSettingED=="on" and $deletMainPageSettingED!="on"){
                            $mainPageSetting=1;
                        }elseif($editManiPageSettingED !="on" and $seeMainPageSettingED =="on"){
                            $mainPageSetting=0;
                        }else{
                            $mainPageSetting=-1;
                        }
                    }else{
                        $mainPageSetting=-1;
                    }

                //تنظیمات اختصاصی با سه عنصر اش چک گردد
                    $specialSettingED = $request->post("specialSettingED");
                    $deleteSpecialSettingED = $request->post("deleteSpecialSettingED");
                    $editSpecialSettingED = $request->post("editSpecialSettingED");
                    $seeSpecialSettingED = $request->post("seeSpecialSettingED");

                    if($specialSettingED=="on"){
                        if($deleteSpecialSettingED=="on"){
                            $specialSettingED=2;
                        }elseif($editSpecialSettingED=="on" and $deleteSpecialSettingED!="on"){
                            $specialSettingED=1;
                        }elseif($editSpecialSettingED !="on" and $seeSpecialSettingED =="on"){
                            $specialSettingED=0;
                        }else{
                            $specialSettingED=-1;
                        }
                    }else{
                        $specialSettingED=-1;
                    }

                //تنظیمات امتیاز با سه عنصر اش چک گردد
                    $emptyazSettingED = $request->post("emptyazSettingED");
                    $deleteEmtyazSettingED = $request->post("deleteEmtyazSettingED");
                    $editEmptyazSettingED = $request->post("editEmptyazSettingED");
                    $seeEmtyazSettingED = $request->post("seeEmtyazSettingED");

                    if($emptyazSettingED=="on"){
                        if($deleteEmtyazSettingED=="on"){
                            $emptyazSettingED=2;
                        }elseif($editEmptyazSettingED=="on" and $deleteEmtyazSettingED!="on"){
                            $emptyazSettingED=1;
                        }elseif($editEmptyazSettingED !="on" and $seeEmtyazSettingED =="on"){
                            $emptyazSettingED=0;
                        }else{
                            $emptyazSettingED=-1;
                        }
                    }else{
                        $emptyazSettingED=-1;
                    }

                }else{
                    $settingsED = -1;
                    $mainPageSetting = -1;
                    $specialSettingED = -1;
                    $emptyazSettingED = -1;
                }

            }else{
                $baseInfoED = -1;
                $settingsED = -1;
                $mainPageSetting = -1;
                $specialSettingED = -1;
                $emptyazSettingED = -1;
            } 
            // ختم اطلاعات پایه 


        // اگر تعریف عناصر روشن بود 
        $defineElementED = $request->post("defineElementED");
        $defineElementED;
        $karbaranED;
        $customersED;
        if($defineElementED = "on"){
            $defineElementED=1;
             $karbaranED = $request->post("karbaranED");
                if($karbaranED=="on"){
                    $karbaranED=1;
                    $customersED = $request->post("customersED");
                    $deleteCustomersED = $request->post("deleteCustomersED");
                    $editCustomerED = $request->post("editCustomerED");
                    $seeCustomersED = $request->post("seeCustomersED");

                        if($customersED=="on"){
                                if($deleteCustomersED=="on"){
                                    $customersED=2;
                                }elseif($editCustomerED=="on" &&  $deleteCustomersED!="on"){
                                    $customersED=1;    
                                }elseif($seeCustomersED=="on" && $editCustomerED!="on"){
                                    $customersED=0;
                                }else{
                                    $customersED=-1;
                                }
                        }else {
                            $customersED=-1;
                        }
                   
                }else{
                  $karbaranED = -1;
                  $customersED=-1;
                }
        }else{
            $defineElementED = -1;
            $karbaranED = -1;
            $customersED=-1;
        }



        // اگر عملیات روشن بود 
        $operationED = $request->post("operationED");
        $operationED;
        $kalasED;
        $kalaListsED;
        $requestedKalaED;
        $fastKalaED;
        $pishKharidED;
        $brandsED;
        $alertedED;
        $kalaGroupED;
        $orderSalesED;
        $messageED;
        $factorED;
        $bargiriED;

        if($operationED=="on"){
            $operationED=1;
                $kalasED = $request->post("kalasED");
                if($kalasED=="on"){
                    $kalasED=1;
                    // چک کردن لیست کالا ها با سه تا عناصر اش
                        $kalaListsED=$request->post("kalaListsED");
                        $deleteKalaListED=$request->post("deleteKalaListED");
                        $editKalaListED=$request->post("editKalaListED");
                        $seeKalaListED=$request->post("seeKalaListED");

                        if($kalaListsED=="on"){
                                if($deleteKalaListED=="on"){
                                    $kalaListsED=2;
                                }elseif($editKalaListED=="on" && $deleteKalaListED!="on"){
                                    $kalaListsED=1;
                                }elseif($seeKalaListED=="on" && $editKalaListED!="on"){
                                    $kalaListsED=0;
                                }else{
                                    $kalaListsED=-1;
                                }

                        }else{
                            $kalaListsED=-1;
                        }

                        // چک کردن کالا های درخواستی با سه تا عناصر اش
                        $requestedKalaED=$request->post("requestedKalaED");
                        $deleteRequestedKalaED=$request->post("deleteRequestedKalaED");
                        $editRequestedKalaED=$request->post("editRequestedKalaED");
                        $seeRequestedKalaED=$request->post("seeRequestedKalaED");

                        if($requestedKalaED=="on"){
                                if($deleteRequestedKalaED=="on"){
                                    $requestedKalaED=2;
                                }elseif($editRequestedKalaED=="on" && $deleteRequestedKalaED!="on"){
                                    $requestedKalaED=1;
                                }elseif($seeRequestedKalaED=="on" && $editRequestedKalaED!="on"){
                                    $requestedKalaED=0;
                                }else{
                                    $requestedKalaED=-1;
                                }

                        }else{
                            $requestedKalaED=-1;
                        }

                     // چک کردن فست کالا با سه تا عناصر اش
                        $fastKalaED=$request->post("fastKalaED");
                        $deleteFastKalaED=$request->post("deleteFastKalaED");
                        $editFastKalaED=$request->post("editFastKalaED");
                        $seeFastKalaED=$request->post("seeFastKalaED");

                        if($fastKalaED=="on"){
                                if($deleteFastKalaED=="on"){
                                    $fastKalaED=2;
                                }elseif($editFastKalaED=="on" && $deleteFastKalaED!="on"){
                                    $fastKalaED=1;
                                }elseif($seeFastKalaED=="on" && $editFastKalaED!="on"){
                                    $fastKalaED=0;
                                }else{
                                    $fastKalaED=-1;
                                }

                        }else{
                            $fastKalaED=-1;
                        }


                    // چک کردن پیش خرید با سه تا عناصر اش
                        $pishKharidED=$request->post("pishKharidED");
                        $deletePishKharidED=$request->post("deletePishKharidED");
                        $editPishkharidED=$request->post("editPishkharidED");
                        $seePishKharidED=$request->post("seePishKharidED");

                        if($pishKharidED=="on"){
                                if($deletePishKharidED=="on"){
                                    $pishKharidED=2;
                                }elseif($editPishkharidED=="on" && $deletePishKharidED!="on"){
                                    $pishKharidED=1;
                                }elseif($seePishKharidED=="on" && $editPishkharidED!="on"){
                                    $pishKharidED=0;
                                }else{
                                    $pishKharidED=-1;
                                }

                        }else{
                            $pishKharidED=-1;
                        }

                         // چک کردن  برند ها با سه تا عناصر اش
                        $brandsED=$request->post("brandsED");
                        $deleteBrandsED=$request->post("deleteBrandsED");
                        $editBrandED=$request->post("editBrandED");
                        $seeBrandsED=$request->post("seeBrandsED");

                        if($brandsED=="on"){
                                if($deleteBrandsED=="on"){
                                    $brandsED=2;
                                }elseif($editBrandED=="on" && $deleteBrandsED!="on"){
                                    $brandsED=1;
                                }elseif($seeBrandsED=="on" && $editBrandED!="on"){
                                    $brandsED=0;
                                }else{
                                    $brandsED=-1;
                                }

                        }else{
                            $brandsED=-1;
                        }


                     // چک کردن کالاهای شامل هشدار با سه تا عناصر اش
                        $alertedED=$request->post("alertedED");
                        $deleteAlertedED=$request->post("deleteAlertedED");
                        $editAlertedED=$request->post("editAlertedED");
                        $seeAlertedED=$request->post("seeAlertedED");

                        if($alertedED=="on"){
                                if($deleteAlertedED=="on"){
                                    $alertedED=2;
                                }elseif($editAlertedED=="on" && $deleteAlertedED!="on"){
                                    $alertedED=1;
                                }elseif($seeAlertedED=="on" && $editAlertedED!="on"){
                                    $alertedED=0;
                                }else{
                                    $alertedED=-1;
                                }

                        }else{
                            $alertedED=-1;
                        }


                     // چک کردن  دسته بندی کالاها با سه تا عناصر اش
                        $kalaGroupED=$request->post("kalaGroupED");
                        $deletKalaGroupED=$request->post("deletKalaGroupED");
                        $editKalaGroupED=$request->post("editKalaGroupED");
                        $seeKalaGroupED=$request->post("seeKalaGroupED");
                        if($kalaGroupED=="on"){
                                if($deletKalaGroupED=="on"){
                                    $kalaGroupED=2;
                                }elseif($editKalaGroupED=="on" && $deletKalaGroupED!=="on"){
                                    $kalaGroupED=1;
                                }elseif($seeKalaGroupED=="on" && $editKalaGroupED!=="on"){
                                    $kalaGroupED=0;
                                }else{
                                    $kalaGroupED=-1;
                                }

                        }else{
                            $kalaGroupED=-1;
                        }

                     // چک کردن  سفارشات فروش با سه تا عناصر اش
                        $orderSalesED=$request->post("orderSalesED");
                        $deleteOrderSalesED=$request->post("deleteOrderSalesED");
                        $editOrderSalesED=$request->post("editOrderSalesED");
                        $seeSalesOrderED=$request->post("seeSalesOrderED");
                       
                        if($orderSalesED=="on"){
                                if($deleteOrderSalesED=="on"){
                                    $orderSalesED=2;
                                }elseif($editOrderSalesED=="on" && $deleteOrderSalesED!="on"){
                                    $orderSalesED=1;
                                }elseif($seeSalesOrderED=="on" && $editOrderSalesED!="on"){
                                    $orderSalesED=0;
                                }else{
                                    $orderSalesED=-1;
                                }

                        }else{
                            $orderSalesED=-1;
                        }
                     // چک کردن پیام ها با سه تا عناصر اش
                        $messageED=$request->post("messageED");
                        $deleteMessageED=$request->post("deleteMessageED");
                        $editMessageED=$request->post("editMessageED");
                        $seeMessageED=$request->post("seeMessageED");
                        if($messageED=="on"){
                                if($deleteMessageED=="on"){
                                    $messageED=2;
                                }elseif($editOrderSalesED=="on" && $deleteMessageED!="on"){
                                    $messageED=1;
                                }elseif($seeMessageED=="on" && $editOrderSalesED!="on"){
                                    $messageED=0;
                                }else{
                                    $messageED=-1;
                                }

                        }else{
                            $messageED=-1;
                        }

                    // چک کردن فاکتور فروش با سه تا عناصرش
                    $factorED=$request->post("factorED");
                    $deleteFactorED=$request->post("deleteFactorED");
                    $editFactorED=$request->post("editFactorED");
                    $seeFactorED=$request->post("seeFactorED");
                    
                    if($factorED=="on"){
                        if($deleteFactorED=="on"){
                            $factorED=2;
                        }elseif($editFactorED=="on" && $deleteFactorED!="on"){
                            $factorED=1;
                        }elseif($seeFactorED=="on" && $editFactorED!="on"){
                            $factorED=0;
                        }else{
                            $factorED=-1;
                        }

                    }else{
                        $factorED=-1;
                    }

                    // چک کردن بارگیری با سه تا عناصرش
                    $bargiriED=$request->post("bargiriED");
                    $deleteBargiriED=$request->post("deleteBargiriED");
                    $editBargiriED=$request->post("editBargiriED");
                    $seeBargiriED=$request->post("seeBargiriED");
                    if($bargiriED=="on"){
                        if($deleteBargiriED=="on"){
                            $bargiriED=2;
                        }elseif($editBargiriED=="on" && $deleteBargiriED!="on"){
                            $bargiriED=1;
                        }elseif($seeBargiriED=="on" && $editBargiriED!="on"){
                            $bargiriED=0;
                        }else{
                            $bargiriED=-1;
                        }

                    }else{
                        $bargiriED=-1;
                    }


                }else{
                    $kalasED=-1;
                    $kalaListsED=-1;
                    $requestedKalaED=-1;
                    $fastKalaED=-1;
                    $pishKharidED=-1;
                    $brandsED=-1;
                    $alertedED=-1;
                    $orderSalesED=-1;
                    $messageED=-1;
                    $factorED=-1;
                    $bargiriED=-1;
                }

        }else{
            $operationED =-1;
            $operationED=-1;
            $kalasED=-1;
            $kalaListsED=-1;
            $requestedKalaED=-1;
            $fastKalaED=-1;
            $pishKharidED=-1;
            $brandsED=-1;
            $alertedED=-1;
            $kalaGroupED=-1;
            $orderSalesED=-1;
            $messageED=-1;
            $factorED=-1;
            $bargiriED=-1;
        }


        // اگر گزارشات روشن بود 
        $reportED = $request->post("reportED");
        $reportCustomerED;
        $customerListED;
        $officialCustomerED;
        $gameAndLotteryED;
        $lotteryResultED;
        $gamerListED;
        $onlinePaymentED;

        if($reportED=="on") {
            $reportED=1;
            // اگر مشتریان روشن بود 
            $reportCustomerED = $request->post("reportCustomerED");
            if($reportCustomerED=="on"){
                    $reportCustomerED=1;
                // لیست مشتریان با سه تا عناصرش چک گردد 
                    $customerListED=$request->post("cutomerListED");
                    $deletCustomerListED=$request->post("deletCustomerListED");
                    $editCustomerListED=$request->post("editCustomerListED");
                    $seeCustomerListED=$request->post("seeCustomerListED");
                    if($customerListED=="on"){
                            if($deletCustomerListED=="on"){
                                $customerListED=2;
                            }elseif($editCustomerListED=="on" && $deletCustomerListED!="on"){
                                $customerListED=1;
                            }elseif($seeCustomerListED=="on" && $editCustomerListED!="on"){
                                $customerListED=0;
                            }else{
                                $customerListED=-1;
                            }
                    }else{
                        $customerListED=-1;
                    }

                // لیست مشتریان با سه تا عناصرش چک گردد 
                    $officialCustomerED=$request->post("officialCustomerED");
                    $deleteOfficialCustomerED=$request->post("deleteOfficialCustomerED");
                    $editOfficialCustomerED=$request->post("editOfficialCustomerED");
                    $seeOfficialCustomerED=$request->post("seeOfficialCustomerED");
                    if($officialCustomerED=="on"){
                        if($deleteOfficialCustomerED=="on"){
                            $officialCustomerED=2;
                        }elseif($editOfficialCustomerED=="on" && $deleteOfficialCustomerED!="on"){
                            $officialCustomerED=1;
                        }elseif($seeOfficialCustomerED=="on" && $editOfficialCustomerED!="on"){
                            $officialCustomerED=0;
                        }else{
                            $officialCustomerED=-1;
                        }
                    }else{
                        $officialCustomerED=-1;
                    }

            }else{
                $reportCustomerED=-1;
                $customerListED=-1;
                $officialCustomerED=-1;
            }


            // اگر گیم و لاتری روشن بود 

             $gameAndLotteryED = $request->post("gameAndLotteryED");
             if($gameAndLotteryED=="on"){
                $gameAndLotteryED=1;
                  // نتجه لاتری با سه تا عناصرش چک گردد 
                    $lotteryResultED=$request->post("lotteryResultED");
                    $deletLotteryResultED=$request->post("deletLotteryResultED");
                    $editLotteryResultED=$request->post("editLotteryResultED");
                    $seeLotteryResultED=$request->post("seeLotteryResultED");
                    if($lotteryResultED=="on"){
                            if($deletLotteryResultED=="on"){
                                $lotteryResultED=2;
                            }elseif($editLotteryResultED=="on" && $deletLotteryResultED!="on"){
                                $lotteryResultED=1;
                            }elseif($seeLotteryResultED=="on" && $editLotteryResultED!="on"){
                                $lotteryResultED=0;
                            }else{
                                $lotteryResultED=-1;
                            }

                    }else{
                        $lotteryResultED=-1;
                    }

                  // لیست گیمر ها با سه تا عناصرش چک گردد
                    $gamerListED=$request->post("gamerListED");
                    $deletGamerListED=$request->post("deletGamerListED");
                    $editGamerListED=$request->post("editGamerListED");
                    $seeGamerListED=$request->post("seeGamerListED");
                    if($gamerListED=="on"){
                            if($deletGamerListED=="on"){
                                $gamerListED=2;
                            }elseif($editGamerListED=="on" && $deletGamerListED!="on"){
                                $gamerListED=1;
                            }elseif($seeGamerListED=="on" && $editGamerListED!="on"){
                                $gamerListED=0;
                            }else{
                                $gamerListED=-1;
                            }
                    }else{
                        $gamerListED=-1;
                    }

             }else{
                $gameAndLotteryED=-1;
             }

            // اگر پرداخت انلاین روشن بود 
                $onlinePaymentED = $request->post("onlinePaymentED");
                $deleteOnlinePaymentED=$request->post("deleteOnlinePaymentED");
                $editOnlinePaymentED=$request->post("editOnlinePaymentED");
                $seeOnlinePaymentED=$request->post("seeOnlinePaymentED");
                if($onlinePaymentED=="on"){
                        if($deleteOnlinePaymentED=="on"){
                            $onlinePaymentED=2;
                        }elseif($editOnlinePaymentED=="on" && $deleteOnlinePaymentED!="on"){
                            $onlinePaymentED=1;
                        }elseif($seeOnlinePaymentED=="on" && $editOnlinePaymentED!="on"){
                            $onlinePaymentED=0;
                        }else{
                            $onlinePaymentED=-1;
                        }

                }else{
                    $onlinePaymentED=-1;
                }

        }else{
            $reportED = -1;
            $reportCustomerED= -1;
            $customerListED= -1;
            $officialCustomerED= -1;
            $gameAndLotteryED= -1;
            $lotteryResultED= -1;
            $gamerListED= -1;
            $onlinePaymentED= -1;
        }

    DB::table("NewStarfood.dbo.star_hasAccess1")->where("adminId",$adminId)->update(
        ['adminId'=>$adminId
        ,'baseInfoN'=>$baseInfoED
        ,'settingsN'=>$settingsED,
        'mainPageSetting'=>$mainPageSetting
        ,'specialSettingN'=>$specialSettingED
        ,'emptyazSettingN'=>$emptyazSettingED
        ,'defineElementN'=>$defineElementED
        ,'karbaranN'=>$karbaranED
        ,'customersN'=>$customersED
        ,'operationN'=>$operationED
        ,'kalasN'=>$kalasED
        ,'kalaListsN'=>$kalaListsED
        ,'requestedKalaN'=>$requestedKalaED
        ,'fastKalaN'=>$fastKalaED
        ,'pishKharidN'=>$pishKharidED
        ,'brandsN'=>$brandsED
        ,'alertedN'=>$alertedED
        ,'kalaGroupN'=>$kalaGroupED
        ,'orderSalesN'=>$orderSalesED
        ,'messageN'=>$messageED
        ,'reportN'=>$reportED
        ,'reportCustomerN'=>$reportCustomerED
        ,'customerListN'=>$customerListED
        ,'officialCustomerN'=>$officialCustomerED
        ,'gameAndLotteryN'=>$gameAndLotteryED
        ,'lotteryResultN'=>$lotteryResultED
        ,'gamerListN'=>$gamerListED
        ,'onlinePaymentN'=>$onlinePaymentED
        ,'factorN'=>$factorED
        ,'bargiriN'=>$bargiriED
    ]);
       return redirect("/listKarbaran"); 
    }

    public function getAdminInfo(Request $request){

        $adminId=$request->get("searchTerm");

        $adminInfo=DB::select("SELECT * FROM NewStarfood.dbo.admin LEFT JOIN NewStarfood.dbo.star_hasAccess1 ON admin.id=star_hasAccess1.adminId WHERE admin.id=".$adminId)[0];

        return Response::json($adminInfo);

    }

    public function editAdmin(Request $request){
        $adminId=$request->post("adminId");
        $admin=DB::select("SELECT * FROM NewStarfood.dbo.admin where id=".$adminId);
        foreach ($admin as $ad) {
            $admin=$ad;
        }
        return view('admin.editAdmin',['admin'=>$admin]);
    }

    public function loginAdmin(Request $request)
    {
        
            Session::forget("adminName");
            Session::forget("adminId");
        return view('admin.login');
    }

    public function checkAdmin(Request $request)
    {
           $this->validate($request,[
                'username'=>'string|required|max:2000|min:3',
                'password'=>'required|string|min:3|max:54',
            ],
            [
                'required' => 'فیلد نباید خالی بماند',
                'username.max'=>'متن طویل است طویل است',
                'username.min'=>'متن زیاد کوناه است'

            ]
        );
        $username=$request->post("username");
        $password=$request->post("password");
        $admins=DB::select("SELECT * FROM NewStarfood.dbo.admin where userName='".$username."' and password='$password'");
        $exist=0;
        $adminName="";
        $adminId="";
        $shopUserSn=0;
        foreach ($admins as $admin) {
            $adminName=$admin->userName;
            $adminId=$admin->id;
            $shopUserSn=$admin->ShopAdminSn;
            
        }
        if(count($admins)>0){
            $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
                Session::put('adminName',$adminName);
                Session::put('adminId',$adminId);
                Session::put('FiscallYear',$fiscallYear);
                Session::put('ShopUserSn',$shopUserSn);
            $alarmStuff=DB::select("SELECT * FROM(
                                SELECT * FROM(
                                SELECT GoodSn FROM Shop.dbo.PubGoods WHERE GoodSn
                                in( SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE AlarmAmount>0))a
                                JOIN Shop.dbo.ViewGoodExists on a.GoodSn=ViewGoodExists.SnGood WHERE ViewGoodExists.CompanyNo=5 and ViewGoodExists.FiscalYear=".Session::get("FiscallYear").")b 
                                JOIN (SELECT AlarmAmount,productId FROM NewStarfood.dbo.star_GoodsSaleRestriction)c on b.GoodSn=c.productId");

            foreach ($alarmStuff as $kala) {

                $kala->Amount+=DB::select("select SUM(Amount) as SumAmount from Shop.dbo.ViewGoodExistsInStock where ViewGoodExistsInStock.SnStock in(select stockId from NewStarfood.dbo.star_addedStock where productId=".$kala->GoodSn.") and SnGood=".$kala->GoodSn)[0]->SumAmount;

            }

            $alarmedKala=array();
        
            foreach ($alarmStuff as $stuff) {
        
                if($stuff->AlarmAmount >= $stuff->Amount ){
            
                    array_push($alarmedKala,$stuff->productId);
            
                }
        
            }
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
			
			$imediatOrders=DB::select("SELECT PCode,Name FROM NewStarfood.dbo.OrderHDSS JOIN Shop.dbo.Peopels on CustomerSn=PSN  where OrderErsalTime=3 and isSent=0 and isDistroy=0");
            
            return view("admin.alarmModal",["alarmedKalas"=>$alarmedKalas,"imediatOrders"=>$imediatOrders]);
        }else{
            return redirect('loginAdmin');
        }
    }

    public function logout(Request $request)
    {
        Session::forget('adminId');
        Session::forget('adminName');
        redirect('/loginAdmin');
    }	
}
