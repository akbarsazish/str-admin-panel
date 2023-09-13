<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use BrowserDetect;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use Response;

class NazarSanji extends Controller
{
    public function addNazarSanji(Request $request){
        $nazarSanjiName=$request->get("nazarSanjiName");
        $qContent1=$request->get("content1");
        $qContent2=$request->get("content2");
        $qContent3=$request->get("content3");
        DB::table("NewStarfood.dbo.star_nazarSanji")->insert(["Name"=>"".$nazarSanjiName.""]);
        $maxId=DB::table("NewStarfood.dbo.star_nazarSanji")->max("id");
        DB::table("NewStarfood.dbo.star_question")->insert(["question1"=>"".$qContent1."","question2"=>"".$qContent2."","question3"=>"".$qContent3."","nazarId"=>$maxId]);
        $nazarSanjies=DB::table("NewStarfood.dbo.star_nazarsanji")->join("NewStarfood.dbo.star_question","nazarId","=","star_nazarsanji.id")->get();
        return Response::json($nazarSanjies);
    }

    public function getQAnswers(Request $request){
        $nazarId=$request->get("nazarId");
        $qNumber=$request->get("question");
	
        $newAnswers=DB::select("SELECT id FROM NewStarfood.dbo.star_answers WHERE id NOT IN(SELECT AnswerId FROM NewStarfood.dbo.star_NotifyAdmin WHERE adminId=".Session::get('adminId').")");
        foreach($newAnswers as $answer){
            DB::table("NewStarfood.dbo.star_NotifyAdmin")->insert(['MessageId'=>0,'AnswerId'=>$answer->id,'AdminId'=>Session::get('adminId')]);
        }
        $answerNumber=1;
		
        switch ($qNumber) {
            case 1:
                $answerNumber="answer1";
                break;
            case 2:
                $answerNumber="answer2";
                break;
            case 3:
                $answerNumber="answer3";
                break;
            default:
            $answerNumber="answer1";
                break;
        }
        $answers=DB::select("SELECT $answerNumber AS answer,Name,star_answers.id,star_answers.nazarId, star_answers.TimeStamp,question$qNumber AS question FROM NewStarfood.dbo.star_answers INNER JOIN Shop.dbo.Peopels ON customerId=PSN INNER JOIN NewStarfood.dbo.star_question ON star_answers.nazarId=star_question.id WHERE star_answers.nazarId=".$nazarId);
        return Response::json($answers);
    }
	
	
  public function editNazar(Request $request){// داده ها را برای نظر سنجی بر می گرداند.
		 $nazarId=$request->get("nazarId");
		 $questions=DB::table("NewStarfood.dbo.star_question")->join("NewStarfood.dbo.star_nazarsanji","nazarId","=","star_nazarsanji.id")
			-> where("nazarId",$nazarId)->get();
		 return Response::json($questions);
	
	}

	public function updateQuestion(Request $request){
		$nazarId=$request->get("nazarId");
		$nazarSanjiName=$request->get("nazarSanjiName");
        $qContent1=$request->get("content1");
        $qContent2=$request->get("content2");
        $qContent3=$request->get("content3");
        DB::table("NewStarfood.dbo.star_nazarSanji")->where("id",$nazarId)->update(["Name"=>"".$nazarSanjiName.""]);
        DB::table("NewStarfood.dbo.star_question")->where("nazarId",$nazarId)->update(["question1"=>"".$qContent1."","question2"=>"".$qContent2."","question3"=>"".$qContent3.""]);
        $updateQuestion=DB::table("NewStarfood.dbo.star_nazarsanji")->join("NewStarfood.dbo.star_question","nazarId","=","star_nazarsanji.id")->get();
        return Response::json($updateQuestion);
	
	}
	
}
