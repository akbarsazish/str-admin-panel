<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use DB;
use Response;
use App\Http\Controllers\Kala;
/**
 * undocumented class
 */
class Message extends Controller
{
    public function index(Request $request)
    {
        $messages=DB::select("SELECT *,FORMAT(messageDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as messageHijriDate FROM NewStarfood.dbo.star_message join Shop.dbo.Peopels on star_message.customerId=Peopels.PSN  WHERE customerId=".Session::get('psn')." order by id asc");
        foreach ($messages as $message) {
            $replays=DB::select("SELECT *,FORMAT(replayDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as replayHijriDate FROM NewStarfood.dbo.star_replayMessage WHERE messageId=".$message->id);
            $message->replay=$replays;
        }
        $newMessages=DB::table("NewStarfood.dbo.star_message")->where("customerId",Session::get("psn"))->get("id");
        foreach ($newMessages as $message) {
            DB::update("update NewStarfood.dbo.star_replayMessage set readState=1 where messageId=".$message->id);
        }
        return view('messages.messageList',['messages'=>$messages]);
    }
    public function doAddMessage(Request $request)
    {
		$kalaObj= new Kala;
		
        $messageContent=$kalaObj->changeToArabicLetterAndEngNumber($request->get('pmContent'));
        $customerId=Session::get('psn');
        DB::insert("INSERT INTO NewStarfood.dbo.star_message (messageContent,readState	,customerId)
            VALUES('".$messageContent."',0,".$customerId.")");
            return Response::json("good");
    }
    public function replayMessage(Request $request)
    {
		$kalaObj1= new Kala;
        $replayContent=$kalaObj1->changeToArabicLetterAndEngNumber($request->get('replayContent'));
		$customerId=$request->input("customerId");
        $messageId=DB::table("NewStarfood.dbo.star_message")->where("customerId",$customerId)->max("id");
        DB::insert("INSERT INTO NewStarfood.dbo.star_replayMessage(replayContent ,messageId,readState) 
					Values('".$replayContent."' ,".$messageId.",0)");
        $lastReplay=DB::select("SELECT * FROM NewStarfood.dbo.star_replayMessage where id=(SELECT MAX(id) from star_replayMessage) and messageId=".$messageId);
        $msg="";
        $id;

        foreach ($lastReplay as $replay) {
            $msg='
            <div class="d-flex flex-row justify-content-end mb-2" id="replayDiv">
              <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                 <p class="small mb-0" style="font-size:1rem;">'.$replay->replayContent.'</p>
            </div>
             <img src="/resources/assets/images/girl.png" alt="avatar 1" style="width: 45px; height: 100%;">
          </div> ';
        }
        return Response::json($msg);
    }
	
	    public function messages(Request $request)
    {
        $messages=DB::select("SELECT top 10 * from (Select  CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
		from NewStarfood.dbo.star_message join (select MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
        left join ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
        join Shop.dbo.Peopels on a.customerId=Peopels.PSN
		)a 
		order by a.messageDate desc");

        return view('messages.messages',['messages'=>$messages]);
    }

    public function getUnreadMessages(Request $request)
    {
        $messages=DB::select("SELECT * from (Select  CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,FORMAT(messageDate,'yyyy/MM/dd','fa-ir') as hijriDate,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
		from NewStarfood.dbo.star_message join (select MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
        left join ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
        join Shop.dbo.Peopels on a.customerId=Peopels.PSN
		)a where countUnread is not null
		order by a.messageDate asc");

        return Response::json(['messages'=>$messages]);
    }

    public function getReadMessages(Request $request)
    {
        $messages=DB::select("SELECT * from (Select  CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,FORMAT(messageDate,'yyyy/MM/dd','fa-ir') as hijriDate,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
		from NewStarfood.dbo.star_message join (select MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
        left join ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
        join Shop.dbo.Peopels on a.customerId=Peopels.PSN
		)a where countUnread is null
		order by a.messageDate asc");

        return Response::json(['messages'=>$messages]);
    }

    public function getUnReplayedMessages(Request $request)
    {
        $messages=DB::select("SELECT * FROM (Select  messageId,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,FORMAT(messageDate,'yyyy/MM/dd','fa-ir') as hijriDate,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
                                FROM NewStarfood.dbo.star_message JOIN (SELECT MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
                                LEFT JOIN ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
                                LEFT JOIN ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
                                LEFT JOIN ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
                                JOIN Shop.dbo.Peopels on a.customerId=Peopels.PSN
                                )a where  not exists (select * from NewStarfood.dbo.star_replayMessage where star_replayMessage.messageId=a.messageId ) 
                                order by a.messageDate asc");
        return Response::json(['messages'=>$messages]);
    }
    public function getReplayedMessages(Request $request)
    {
        $messages=DB::select("SELECT * FROM (Select  messageId,CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,FORMAT(messageDate,'yyyy/MM/dd','fa-ir') as hijriDate,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
                                FROM NewStarfood.dbo.star_message JOIN (SELECT MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
                                LEFT JOIN ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
                                LEFT JOIN ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
                                LEFT JOIN ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
                                JOIN Shop.dbo.Peopels on a.customerId=Peopels.PSN
                                )a where exists (select * from NewStarfood.dbo.star_replayMessage where star_replayMessage.messageId=a.messageId ) 
                                order by a.messageDate asc");
        return Response::json(['messages'=>$messages]);
    }
	
	    public function getAllMessages(Request $request)
    {
        $messages=DB::select("SELECT * from (Select  CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
		from NewStarfood.dbo.star_message join (select MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
        left join ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
        join Shop.dbo.Peopels on a.customerId=Peopels.PSN
		)a 
		order by a.messageDate desc");
        return Response::json(['messages'=>$messages]);
    }
	
	    public function getLastTenMessages(Request $request)
    {
        $messages=DB::select("SELECT top 10 * from (Select  CRM.dbo.getCustomerPhoneNumbers(PSN) as PhoneStr,Shop.dbo.Peopels.Name,Shop.dbo.Peopels.PSN,star_message.messageContent,convert(Date,star_message.messageDate) as messageDate,unread as countUnread,Didread as countRead,countAll
		from NewStarfood.dbo.star_message join (select MAX(star_message.id) as messageId,customerId from NewStarfood.dbo.star_message group by star_message.customerId)a on star_message.id=a.messageId
        left join ( select COUNT(star_message.id) AS Didread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=1 group by customerId )b on b.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS unread,star_message.customerId FROM NewStarfood.dbo.star_message where star_message.readState=0 group by customerId )c on c.customerId=a.customerId
        left join ( select COUNT(star_message.id) AS countAll,star_message.customerId FROM NewStarfood.dbo.star_message group by customerId )d on d.customerId=a.customerId
        join Shop.dbo.Peopels on a.customerId=Peopels.PSN
		)a 
		order by a.messageDate desc");
        return Response::json(['messages'=>$messages]);
    }
	
	public function getMessages(Request $request){
        $messages=DB::select("SELECT *,FORMAT(messageDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as messageHirji FROM NewStarfood.dbo.star_message
        join Shop.dbo.Peopels on star_message.customerId=Peopels.PSN  WHERE customerId=".$request->get('customerSn')." order by id asc");
        DB::update("UPDATE NewStarfood.dbo.star_message SET readState=1 WHERE customerId=".$request->get('customerSn'));

        $newMessages=DB::select("SELECT * FROM NewStarfood.dbo.star_message WHERE customerId=".$request->get('customerSn')." 
                                AND id NOT IN(SELECT messageId FROM NewStarfood.dbo.star_NotifyAdmin
                                WHERE adminId=".Session::get('adminId').")");
        foreach($newMessages as $message){
            DB::table("NewStarfood.dbo.star_NotifyAdmin")->insert(['MessageId'=>$message->id,'AnswerId'=>0,'AdminId'=>Session::get('adminId')]);
        }
        $msg="";
        $conversation="";
        foreach ($messages as $message) {
            $firstPart="";
            $secondPart="";
            $firstPart='
                   <h3>'.$message->Name.'</h3>
                    <div class="d-flex flex-row justify-content-start mb-2">
                        <img src="/resources/assets/images/boy.png" alt="avatar 1" style="width: 45px;">
                          <div class="p-3 ms-2" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                        <input id="customerSn" type="text" style="display:none" value="'.$request->get('customerSn').'"/>
                            <span class="text-info">'.$message->messageHirji.'</span>
                            <p class="small mb-0" style="font-size:1rem;"> '.$message->messageContent.'</p>
                        </div>
                    </div>';

            $secondPart='';

                $replays=DB::select("SELECT *,FORMAT(replayDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as messageHirji FROM NewStarfood.dbo.star_replayMessage WHERE messageId=".$message->id);
                $msg="";
                foreach ($replays as $replay) {
                        $msg.='<div class="d-flex flex-row justify-content-end mb-2" id="replayDiv'.$replay->id.'">
                                    <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                        <span class="text-info">'.$replay->messageHirji.'</span>
                                        <p class="small mb-0" style="font-size:1rem;">'.$replay->replayContent.'</p>
                                    </div>
                                    <img src="/resources/assets/images/girl.png" alt="avatar 1" style="width: 45px;">
                                </div>';
                }
            $conversation.=$firstPart.$msg.$secondPart;
            }

        return Response::json($conversation);
    }

    public function indexApi(Request $request)
    {
        $customerId=$request->get("psn");
        $messages=DB::select("SELECT *,FORMAT(messageDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as messageHijriDate FROM NewStarfood.dbo.star_message join Shop.dbo.Peopels on star_message.customerId=Peopels.PSN  WHERE customerId=".$customerId." order by id asc");
        foreach ($messages as $message) {
            $replays=DB::select("SELECT *,FORMAT(replayDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as replayHijriDate FROM NewStarfood.dbo.star_replayMessage WHERE messageId=".$message->id);
            $message->replay=$replays;
        }
        $newMessages=DB::table("NewStarfood.dbo.star_message")->where("customerId",$customerId)->get("id");
        foreach ($newMessages as $message) {
            DB::update("update NewStarfood.dbo.star_replayMessage set readState=1 where messageId=".$message->id);
        }
        return Response::json(['messages'=>$messages]);
    }

    public function doAddMessageApi(Request $request)
    {
        $messageContent=$request->get('pmContent');
        $customerId=$request->get("psn");
        DB::insert("INSERT INTO NewStarfood.dbo.star_message (messageContent,readState,customerId)
        VALUES('".$messageContent."',0,".$customerId.")");

        $messages=DB::select("SELECT *,FORMAT(messageDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as messageHijriDate FROM NewStarfood.dbo.star_message join Shop.dbo.Peopels on star_message.customerId=Peopels.PSN  WHERE customerId=".$customerId." order by id asc");
        foreach ($messages as $message) {
            $replays=DB::select("SELECT *,FORMAT(replayDate,'yyyy/MM/dd hh:mm:ss','fa-ir') as replayHijriDate FROM NewStarfood.dbo.star_replayMessage WHERE messageId=".$message->id);
            $message->replay=$replays;
        } 
        return Response::json(['messages'=>$messages]);
    }

}


