<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use BrowserDetect;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use Response;

class Target extends Controller
{
    public function index(Request $request) {
        $targets=DB::table("NewStarfood.dbo.star_customer_baseBonus")->get();
        $lotteryPrizes=DB::table("NewStarfood.dbo.star_lotteryPrizes")->get();
        $nazarSanjies=DB::table("NewStarfood.dbo.star_nazarsanji")->join("NewStarfood.dbo.star_question","nazarId","=","star_nazarsanji.id")->get();
        $lotteryMinBonus=DB::select("SELECT * FROM NewStarfood.dbo.star_webSpecialSetting")[0]->lotteryMinBonus;
        return view("target.basebonusSettings",['targets'=>$targets,'prizes'=>$lotteryPrizes,'nazars'=>$nazarSanjies,'lotteryMinBonus'=>$lotteryMinBonus]);
    }
    public function getTargetInfo(Request $request) {
		$targetId=$request->get('targetId');
		$target=DB::table("NewStarfood.dbo.star_customer_baseBonus")->where('id',$targetId)->get();
		return Response::json($target);
    }
    public function editTarget(Request $request) {
        $targetId=$request->get("targetId");
        $firstTarget=str_replace(",","",$request->get("firstTarget"));
        $secondTarget=str_replace(",","",$request->get("secondTarget"));
        $thirdTarget=str_replace(",","",$request->get("thirdTarget"));
        $firstTargetBonus=$request->get("firstTargetBonus");
        $secondTargetBonus=$request->get("secondTargetBonus");
        $thirdTargetBonus=$request->get("thirdTargetBonus");
        DB::table("NewStarfood.dbo.star_customer_baseBonus")->where('id','=',$targetId)->update([
            'firstTarget'=>$firstTarget
            ,'secondTarget'=>$secondTarget
            ,'thirdTarget'=>$thirdTarget
            ,'firstTargetBonus'=>$firstTargetBonus
            ,'secondTargetBonus'=>$secondTargetBonus
            ,'thirdTargetBonus'=>$thirdTargetBonus]);
        $targets=DB::table("NewStarfood.dbo.star_customer_baseBonus")->get();
        return Response::json($targets); 
    }
}