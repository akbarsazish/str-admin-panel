<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Goods;
use Response;
use Session;
use Cockie;
use DateTime;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;

class Game extends Controller
{
    public function index($gameId){
        $gameId=$gameId;
        $players=DB::select("SELECT Name,PSN,customerId,score FROM NewStarfood.dbo.star_game_score JOIN Shop.dbo.Peopels ON customerId=PSN WHERE gameId=$gameId ORDER BY score DESC");
        $prizes=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();

        $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter  WHERE isFinishedChampion=0 AND gameId=$gameId");

        if(count($endOfOpportunity)<1){
            DB::table("NewStarfood.dbo.star_Gamestarter")->insert(['gameId'=>$gameId]);
            $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter  WHERE isFinishedChampion=0 AND gameId=$gameId");
        }
        
        if($endOfOpportunity[0]->endOfOpportunity <= Carbon::now() ){
            $gameHistory=DB::table("NewStarfood.dbo.star_game_score")->where('gameId',$gameId)->orderbydesc("score")->get();
            $prizes=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();
            $firstPosId=0;
            $secPosId=0;
            $thirdPosId=0;
            $fourthPosId=0;
            $fifthPosId=0;
            $sixthPosId=0;
            $seventhPosId=0;
            
            $eightthPosId=0;
            $ninthPosId=0;
            $teenthPosId=0;
            $firstScore=0;
            $secondScore=0;
            $thirdScore=0;
            $fourthScore=0;
            $fifthScore=0;
            $sixthScore=0;
            $seventhScore=0;
            $eightthScore=0;
            $ninethScore=0;
            $teenthScore=0;

            if(isset($gameHistory[0]->customerId)){
                
                $firstPosId=$gameHistory[0]->customerId;
                $firstScore=$gameHistory[0]->score;

            }
            if(isset($gameHistory[1])){
                
                $secPosId=$gameHistory[1]->customerId;
                $secondScore=$gameHistory[1]->score;

            }

            if(isset($gameHistory[2]->customerId)){
                $thirdPosId=$gameHistory[2]->customerId;
                $thirdScore=$gameHistory[2]->score;

            }

            if(isset($gameHistory[3]->customerId)){
                $fourthPosId=$gameHistory[3]->customerId;
                $fourthScore=$gameHistory[3]->score;

            }

            if(isset($gameHistory[4]->customerId)){
                $fifthPosId=$gameHistory[4]->customerId;
                $fifthScore=$gameHistory[4]->score;

            }

            if(isset($gameHistory[5]->customerId)){
                $sixthPosId=$gameHistory[5]->customerId;
                $sixthScore=$gameHistory[5]->score;

            }

            if(isset($gameHistory[6]->customerId)){
                $seventhPosId=$gameHistory[6]->customerId;
                $seventhScore=$gameHistory[6]->score;

            }

            if(isset($gameHistory[7]->customerId)){
                $eightthPosId=$gameHistory[7]->customerId;
                $eightthScore=$gameHistory[7]->score;

            }

            if(isset($gameHistory[8]->customerId)){
                $ninthPosId=$gameHistory[8]->customerId;
                $ninethScore=$gameHistory[8]->score;

            }

            if(isset($gameHistory[9]->customerId)){
                $teenthPosId=$gameHistory[9]->customerId;
                $teenthScore=$gameHistory[9]->score;
            }

            DB::table("NewStarfood.dbo.star_game_history")->insert(["gameId"=>$gameId
                                                                    ,"firstPosId"=>$firstPosId
                                                                    ,"secondPosId"=>$secPosId
                                                                    ,"thirdPosId"=>$thirdPosId
                                                                    ,"fourthPosId"=>$fourthPosId
                                                                    ,"fifthPosId"=>$fifthPosId
                                                                    ,"sixthPosId"=>$sixthPosId
                                                                    ,"seventhPosId"=>$seventhPosId
                                                                    ,"eightPosId"=>$eightthPosId
                                                                    ,"ninthPosId"=>$ninthPosId
                                                                    ,"teenthPosId"=>$teenthPosId
                                                                    ,"firstPrize"=>$prizes[0]->firstPrize
                                                                    ,"secondPrize"=>$prizes[0]->secondPrize
                                                                    ,"thirdPrize"=>$prizes[0]->thirdPrize
                                                                    ,"fourthPrize"=>$prizes[0]->fourthPrize
                                                                    ,"fifthPrize"=>$prizes[0]->fifthPrize
                                                                    ,"sixthPrize"=>$prizes[0]->sixthPrize
                                                                    ,"seventhPrize"=>$prizes[0]->seventhPrize
                                                                    ,"eightthPrize"=>$prizes[0]->eightPrize
                                                                    ,"ninthPrize"=>$prizes[0]->ninthPrize
                                                                    ,"teenthPrize"=>$prizes[0]->teenthPrize
                                                                    ,"firstScore"=>$firstScore
                                                                    ,"secondScore"=>$secondScore
                                                                    ,"thirdScore"=>$thirdScore
                                                                    ,"fourthScore"=>$fourthScore
                                                                    ,"fifthScore"=>$fifthScore
                                                                    ,"sixthScore"=>$sixthScore
                                                                    ,"seventhScore"=>$seventhScore
                                                                    ,"eightthScore"=>$eightthScore
                                                                    ,"ninethScore"=>$ninethScore
                                                                    ,"teenthScore"=>$teenthScore]);
            DB::table("NewStarfood.dbo.star_game_score")->where('gameId',$gameId)->delete();
            DB::table("NewStarfood.dbo.star_Gamestarter")->where('gameId',$gameId)->update(["isFinishedChampion"=>1]);
            $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter WHERE gameId=$gameId");
        }

        $remainDays=DB::select("SELECT DATEDIFF (day,'".Carbon::now()."','".$endOfOpportunity[0]->endOfOpportunity."') as dayRemain");

        $played=DB::select("SELECT * FROM (
            SELECT Row,Name,posId,PosName FROM (
            SELECT ROW_NUMBER() 
                            OVER (ORDER BY id)  AS Row,id,PosName,
            posId
            FROM NewStarfood.dbo.star_game_history 
            
            unpivot
            (
            posId
            for PosName IN (firstPosId,secondPosId,thirdPosId,fourthPosId,fifthPosId,sixthPosId,seventhPosId,eightPosId,ninthPosId,teenthPosId)
            ) unpiv
            
            
            )a 
            
            JOIN Shop.dbo.Peopels ON a.posId=PSN
            
            WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history)
            )b JOIN 
            (
            SELECT * FROM(
            SELECT Row,PrizeName,prize FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY id)  AS Row,id,PrizeName,prize
            FROM NewStarfood.dbo.star_game_history
            
            unpivot
            (
            prize
            for PrizeName in (firstPrize,secondPrize,thirdPrize,fourthPrize,fifthPrize,sixthPrize,seventhPrize,eightthPrize,ninthPrize,teenthPrize)
            ) unpiv
            
            )a WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history WHERE gameId=$gameId)
            )c )d ON b.Row=d.Row ");
		
		
            // برای سر زدن به صفحات جذب مشتری نوشته شده است.
            $customerSn=Session::get("psn");
            $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");
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

		    $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");

        return view('game.saveEarth',['played'=>$played,'players'=>$players,'prizes'=>$prizes[0],'endOfOpportunity'=>$endOfOpportunity[0]->endOfOpportunity,'remainDays'=>$remainDays,'gameId'=>$gameId,'attractions' => $attractionVisit]);

    }

   public function getGamerList(Request $request) {
    $gameId=$request->input("gameId");
    $customerSn=$request->input("psn");
    $players=DB::select("SELECT Name,PSN,customerId,score FROM NewStarfood.dbo.star_game_score JOIN Shop.dbo.Peopels ON customerId=PSN WHERE gameId=$gameId ORDER BY score DESC");
    $prizes=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();

    $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter  WHERE isFinishedChampion=0 AND gameId=$gameId");

    if(count($endOfOpportunity)<1){
        DB::table("NewStarfood.dbo.star_Gamestarter")->insert(['gameId'=>$gameId]);
        $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter  WHERE isFinishedChampion=0 AND gameId=$gameId");
    }
    
    if($endOfOpportunity[0]->endOfOpportunity <= Carbon::now() ){
        $gameHistory=DB::table("NewStarfood.dbo.star_game_score")->where('gameId',$gameId)->orderbydesc("score")->get();
        $prizes=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();
        $firstPosId=0;
        $secPosId=0;
        $thirdPosId=0;
        $fourthPosId=0;
        $fifthPosId=0;
        $sixthPosId=0;
        $seventhPosId=0;
        
        $eightthPosId=0;
        $ninthPosId=0;
        $teenthPosId=0;
        $firstScore=0;
        $secondScore=0;
        $thirdScore=0;
        $fourthScore=0;
        $fifthScore=0;
        $sixthScore=0;
        $seventhScore=0;
        $eightthScore=0;
        $ninethScore=0;
        $teenthScore=0;

        if(isset($gameHistory[0]->customerId)){
            
            $firstPosId=$gameHistory[0]->customerId;
            $firstScore=$gameHistory[0]->score;

        }
        if(isset($gameHistory[1])){
            
            $secPosId=$gameHistory[1]->customerId;
            $secondScore=$gameHistory[1]->score;

        }

        if(isset($gameHistory[2]->customerId)){
            $thirdPosId=$gameHistory[2]->customerId;
            $thirdScore=$gameHistory[2]->score;

        }

        if(isset($gameHistory[3]->customerId)){
            $fourthPosId=$gameHistory[3]->customerId;
            $fourthScore=$gameHistory[3]->score;

        }

        if(isset($gameHistory[4]->customerId)){
            $fifthPosId=$gameHistory[4]->customerId;
            $fifthScore=$gameHistory[4]->score;

        }

        if(isset($gameHistory[5]->customerId)){
            $sixthPosId=$gameHistory[5]->customerId;
            $sixthScore=$gameHistory[5]->score;

        }

        if(isset($gameHistory[6]->customerId)){
            $seventhPosId=$gameHistory[6]->customerId;
            $seventhScore=$gameHistory[6]->score;

        }

        if(isset($gameHistory[7]->customerId)){
            $eightthPosId=$gameHistory[7]->customerId;
            $eightthScore=$gameHistory[7]->score;

        }

        if(isset($gameHistory[8]->customerId)){
            $ninthPosId=$gameHistory[8]->customerId;
            $ninethScore=$gameHistory[8]->score;

        }

        if(isset($gameHistory[9]->customerId)){
            $teenthPosId=$gameHistory[9]->customerId;
            $teenthScore=$gameHistory[9]->score;
        }

        DB::table("NewStarfood.dbo.star_game_history")->insert(["gameId"=>$gameId
                                                                ,"firstPosId"=>$firstPosId
                                                                ,"secondPosId"=>$secPosId
                                                                ,"thirdPosId"=>$thirdPosId
                                                                ,"fourthPosId"=>$fourthPosId
                                                                ,"fifthPosId"=>$fifthPosId
                                                                ,"sixthPosId"=>$sixthPosId
                                                                ,"seventhPosId"=>$seventhPosId
                                                                ,"eightPosId"=>$eightthPosId
                                                                ,"ninthPosId"=>$ninthPosId
                                                                ,"teenthPosId"=>$teenthPosId
                                                                ,"firstPrize"=>$prizes[0]->firstPrize
                                                                ,"secondPrize"=>$prizes[0]->secondPrize
                                                                ,"thirdPrize"=>$prizes[0]->thirdPrize
                                                                ,"fourthPrize"=>$prizes[0]->fourthPrize
                                                                ,"fifthPrize"=>$prizes[0]->fifthPrize
                                                                ,"sixthPrize"=>$prizes[0]->sixthPrize
                                                                ,"seventhPrize"=>$prizes[0]->seventhPrize
                                                                ,"eightthPrize"=>$prizes[0]->eightPrize
                                                                ,"ninthPrize"=>$prizes[0]->ninthPrize
                                                                ,"teenthPrize"=>$prizes[0]->teenthPrize
                                                                ,"firstScore"=>$firstScore
                                                                ,"secondScore"=>$secondScore
                                                                ,"thirdScore"=>$thirdScore
                                                                ,"fourthScore"=>$fourthScore
                                                                ,"fifthScore"=>$fifthScore
                                                                ,"sixthScore"=>$sixthScore
                                                                ,"seventhScore"=>$seventhScore
                                                                ,"eightthScore"=>$eightthScore
                                                                ,"ninethScore"=>$ninethScore
                                                                ,"teenthScore"=>$teenthScore]);
        DB::table("NewStarfood.dbo.star_game_score")->where('gameId',$gameId)->delete();
        DB::table("NewStarfood.dbo.star_Gamestarter")->where('gameId',$gameId)->update(["isFinishedChampion"=>1]);
        $endOfOpportunity=DB::select("SELECT endDate AS endOfOpportunity FROM NewStarfood.dbo.star_Gamestarter WHERE gameId=$gameId");
    }

    $remainDays=DB::select("SELECT DATEDIFF (day,'".Carbon::now()."','".$endOfOpportunity[0]->endOfOpportunity."') as dayRemain");

    $played=DB::select("SELECT * FROM (
        SELECT Row,Name,posId,PosName FROM (
        SELECT ROW_NUMBER() 
                        OVER (ORDER BY id)  AS Row,id,PosName,
        posId
        FROM NewStarfood.dbo.star_game_history 
        
        unpivot
        (
        posId
        for PosName IN (firstPosId,secondPosId,thirdPosId,fourthPosId,fifthPosId,sixthPosId,seventhPosId,eightPosId,ninthPosId,teenthPosId)
        ) unpiv
        
        
        )a 
        
        JOIN Shop.dbo.Peopels ON a.posId=PSN
        
        WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history)
        )b JOIN 
        (
        SELECT * FROM(
        SELECT Row,PrizeName,prize FROM (
        SELECT ROW_NUMBER() OVER (ORDER BY id)  AS Row,id,PrizeName,prize
        FROM NewStarfood.dbo.star_game_history
        
        unpivot
        (
        prize
        for PrizeName in (firstPrize,secondPrize,thirdPrize,fourthPrize,fifthPrize,sixthPrize,seventhPrize,eightthPrize,ninthPrize,teenthPrize)
        ) unpiv
        
        )a WHERE a.id=(SELECT MAX(id) AS lastId FROM NewStarfood.dbo.star_game_history WHERE gameId=$gameId)
        )c )d ON b.Row=d.Row ");
    
    
        // برای سر زدن به صفحات جذب مشتری نوشته شده است.
        
        $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");
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

        $attractionVisit=DB::select("SELECT * FROM NewStarfood.dbo.star_attractionVisit WHERE CustomerId=$customerSn");

    return Response::json(['played'=>$played,'players'=>$players,'prizes'=>$prizes[0],'endOfOpportunity'=>$endOfOpportunity[0]->endOfOpportunity,'remainDays'=>$remainDays,'gameId'=>$gameId,'attractions' => $attractionVisit]);

    }

    public function addGamePrize(Request $request){

        $firstPrize=$request->post("firstPrize");
        $secondPrize=$request->post("secondPrize");
        $thirdPrize=$request->post("thirdPrize");
        $fourthPrize=$request->post("fourthPrize");
        $fifthPrize=$request->post("fifthPrize");
        $sixthPrize=$request->post("sixthPrize");
        $seventhPrize=$request->post("seventhPrize");
        $eightthPrize=$request->post("eightthPrize");
        $ninthPrize=$request->post("ninthPrize");
        $teenthPrize=$request->post("teenthPrize");
        $countPrizes=DB::table("NewStarfood.dbo.star_game_prize")->count();
    
        if($countPrizes>0){
            DB::table("NewStarfood.dbo.star_game_prize")->update(['firstPrize'=>$firstPrize
                                ,'secondPrize'=>$secondPrize
                                ,'thirdPrize'=>$thirdPrize
                                ,'fourthPrize'=>$fourthPrize
                                ,'fifthPrize'=>$fifthPrize
                                ,'sixthPrize'=>$sixthPrize
                                ,'seventhPrize'=>$seventhPrize
                                ,'eightPrize'=>$eightthPrize
                                ,'ninthPrize'=>$ninthPrize
                                ,'teenthPrize'=>$teenthPrize]);
        }else{
            DB::table("NewStarfood.dbo.star_game_prize")->insert(['firstPrize'=>$firstPrize
                                ,'secondPrize'=>$secondPrize
                                ,'thirdPrize'=>$thirdPrize
                                ,'fourthPrize'=>$fourthPrize
                                ,'fifthPrize'=>$fifthPrize
                                ,'sixthPrize'=>$sixthPrize
                                ,'seventhPrize'=>$seventhPrize
                                ,'eightPrize'=>$eightthPrize
                                ,'ninthPrize'=>$ninthPrize
                                ,'teenthPrize'=>$teenthPrize]);
        }
        return redirect("/webSpecialSettings");
    }

    public function addGameScore(Request $request){
        $score=$request->get("record");
        $gameId=$request->get("gameId");
        $customerId=Session::get("psn");
        $play_before=DB::table("NewStarfood.dbo.star_game_score")->where('customerId',$customerId)->where('gameId',$gameId)->count();

        if($play_before<1){
            //اگر قبلا نیست
            DB::table("NewStarfood.dbo.star_game_score")->insert(['customerId'=>$customerId,'gameId'=>$gameId,'score'=>$score]);
        }else{
            //اگر قبلا هست
            $countRecord=DB::table("NewStarfood.dbo.star_game_score")->where('customerId',$customerId)->where('score',"<",$score)->where('gameId',$gameId)->count();
            //اگر رکورد است
            if($countRecord>0){
                DB::table("NewStarfood.dbo.star_game_score")->where('customerId',$customerId)->where('gameId',$gameId)->update(['score'=>$score]);
            }
        }
        return Response::json($score);
    }
	
	public function strayMaster(){
        return view("game.astrayMaster");
    }

	public function hextrisGame(){
        return view("game.hextris.index");
    }

	public function buildingTower(){
        return view("game.tower.index");
    }

    public function deletePlayedGamePeriod(Request $request)
    {

        DB::delete("UPDATE NewStarfood.dbo.star_game_history set deleted=1 where deleted=0");

        return Response::json(1);

    }
}
