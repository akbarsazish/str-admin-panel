<?php

namespace App\Providers;
use Session;
use Illuminate\Support\ServiceProvider;
use View;
use DB;
use Request;
use App\Http\Controllers\Customer;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $hoqoqiCustomers=DB::table("NewStarfood.dbo.star_Customer")->where('customerType','hoqoqi')->select("*")->get();
                $exactHoqoqi=array();
                foreach ($hoqoqiCustomers as $hoqoqiCustomer) {
                    $exactHoqoqi=$hoqoqiCustomer;
                }
            View::share('exactHoqoqi', $exactHoqoqi);


// check if the existance of customer type

        $customerShopSn=Session::get('psn');
        $checkExistance=DB::table("NewStarfood.dbo.star_Customer")->where('customerShopSn', Session::get('psn'))->count('customerShopSn');
        View::share('checkExistance', $checkExistance);

        view()->composer("admin.sidebar",function($view){
            $db_ext=\DB::connection('sqlsrv1');
            $db_int=\DB::connection('sqlsrv');
            $groups=$db_ext->table('PeopelGroup')->where('FatherGrpSn',0)->where('GrpSn','>',289)->get();
            // ("select * from PeopelGroup where FatherGrpSn=0 and CompanyNo=5 and PeopelGroup.GrpSn>289");
            $view->with(['groups'=>$groups]);
        });
        view()->composer("admin.listMainGroup",function($view){
            $db_ext=\DB::connection('sqlsrv1');
            $db_int=\DB::connection('sqlsrv');
            $groups=$db_int->table('Star_Group_Def')->select("*")->where('selfGroupId',0)->get();
            $view->with(['groups'=>$groups]);
        });
        view()->composer('layout.layout', function ($view)
        {
            $db_ext=\DB::connection('sqlsrv1');
            $db_int=\DB::connection('sqlsrv');
            $orderHDSs=\DB::select("SELECT SnOrder FROM NewStarfood.dbo.FactorStar WHERE customerSn=".Session::get('psn')." and OrderStatus=0");
            $SnHDS=0;
            foreach ($orderHDSs as $hds) {
                $SnHDS=$hds->SnOrder;
            }

            $orderBYSs=\DB::select("SELECT PubGoods.GoodName,PubGoods.GoodSn,orderStar.*,PUBGoodUnits.UName from Shop.dbo.PubGoods join NewStarfood.dbo.orderStar on PubGoods.GoodSn=orderStar.SnGood inner join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN WHERE SnHDS=".$SnHDS);
            $countBoughtAghlam=count($orderBYSs);
            Session::put('buy',$countBoughtAghlam);
            $countNewReplayMessage=\DB::select("select COUNT(replayId) as countReplayMessage from(select star_replayMessage.id as replayId from star_replayMessage join star_message on star_replayMessage.messageId=star_message.id where star_message.customerId=".Session::get('psn')." and star_replayMessage.readState=0)a ");
            $countNewReplay=0;
            foreach ($countNewReplayMessage as $repCount) {
                $countNewReplay=$repCount->countReplayMessage;
            }
            $restrictions=\DB::table('star_customerRestriction')->where('customerId',Session::get('psn'))->get();
            $exitAllowanceCustomer=0;
            foreach ($restrictions as $rest) {
                $exitAllowanceCustomer=$rest->exitButtonAllowance;
            }
            $socials=\DB::select("select whatsappNumber,instagramId,telegramId,enamad from NewStarfood.dbo.star_webSpecialSetting");
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
            $bonusInfo=new Customer;
            $customerId=Session::get("psn");
            $allMoneyTakhfifResult=$bonusInfo->getTakhfifCaseMoneyBeforeNazarSanji( $customerId);
            $bonusResult=$bonusInfo->getTargetsAndBonuses($customerId);
            $view->with(['exitAllowance'=>$exitAllowanceCustomer,'countBoughtAghlam'=>$countBoughtAghlam,'countNewReplayMessage'=>$countNewReplay,'instagram'=>$instagramId,'telegram'=>$telegramId,'whatsapp'=>$whatsApp,'showEnamad'=>$showEnamad
        ,'takhfifMoney'=>$allMoneyTakhfifResult,'bonusResult'=>($bonusResult[5])]);
            });
            view()->composer('admin.layout', function ($view)
            {
            $countNewMessages=\DB::table("NewStarfood.dbo.star_message")->where("readState",0)->count('id');
			$imediatOrders=\DB::select("SELECT * FROM NewStarfood.dbo.OrderHDSS where OrderErsalTime=3 and isDistroy=0 and isSent=0");
			$imediatOrderCount=count($imediatOrders);
            $view->with(['countNewMessages'=>$countNewMessages,'imediatOrderCount'=>$imediatOrderCount]);
            });
    }
}
