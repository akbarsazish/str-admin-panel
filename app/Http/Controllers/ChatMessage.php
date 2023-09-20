<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Session;
use Cockie;
use DateTime;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use App\Http\Controllers\ChatMessage;
class ChatMessage extends Controller {
    public function getChatMessages()
    {
        return self::getChats();
    }
    public function addMessage(Request $request)
    {
        $content=$request->input("messageContent");
        $customerId=$request->input("psn");
        DB::table("NewStarfood.dbo.ChatMessage")->insert(["ReplayToMessageSn"=>0
        ,"MessageContent"=>"".$content.""
        ,"CustomerId"=>$customerId]);

        return self::getChats();
    }
    public function replayMessage(Request $request)
    {
        $content=$request->input("messageContent");
        $customerId=$request->input("psn");
        $messageId=$request->input("messageId");
        DB::table("NewStarfood.dbo.ChatMessage")->insert([
        "ReplayToMessageSn"=>$messageId
        ,"MessageContent"=>$content
        ,"CustomerId"=>$customerId]);

       return self::getChats();
    }
    public function getChats()
    {
        $messageLists=DB::select("SELECT * FROM NewStarfood.dbo.ChatMessage WHERE ReplayToMessageSn=0");
        foreach($messageLists as $message){
            $replays=DB::select("SELECT * FROM NewStarfood.dbo.ChatMessage WHERE ReplayToMessageSn=$message->MessageSn");
            foreach ($replays as $key => $replay1) {
                $secondReplays=DB::select("SELECT * FROM NewStarfood.dbo.ChatMessage WHERE ReplayToMessageSn=$replay1->MessageSn");
                $replay1->replay=$secondReplays;
                foreach ($secondReplays as $replay2) {
                    $thirdReplays=DB::select("SELECT *,CRM.dbo.getCustomerName(PSN)Name FROM NewStarfood.dbo.ChatMessage WHERE ReplayToMessageSn=$replay2->MessageSn");
                    $replay2->replay=$thirdReplays;
                }
            }
            $message->replay=$replays;
        }
        return Response::json($messageLists);
    }
}