<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;
use Response;

class Notification extends Controller
{
    //
    public function index(Request $request){
		$settings=array();
		$specialSettings=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get();
		if(count($specialSettings)>0){
			$settings=$specialSettings;
		}
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM where FatherMNM=79");
        $notifications=DB::select("SELECT *,Format(sendTime,'yyyy/mm/dd hh:mm:ss','fa-ir') as sendPersianDate
									FROM Shop.dbo.Peopels INNER JOIN NewStarfood.dbo.star_notificationHistory ON PSN=customerId
									ORDER BY NotificationSn DESC");
		$poshtibans=DB::select("SELECT * FROM CRM.dbo.crm_admin where adminType !=4 and deleted=0");
        return view ('notification.notification',['cities'=>$cities,'poshtibans'=>$poshtibans
					,'notifications'=>$notifications,'settings'=>$settings]);
    }
    public function sendNotificationToAndroid(Request $request)
    {
        $customerIDs=$request->get("customerIDs");

        $title=$request->get("title");

        $content=$request->get("content");

        $registration_ids=array();

        foreach($customerIDs as $id){

            $deviceTokens=DB::select("SELECT mobileToken FROM NewStarfood.dbo.star_customerSession1 WHERE customerId=$id");
            if(count($deviceTokens)>0){
                DB::table("NewStarfood.dbo.star_notificationHistory")->insert(["customerId"=>$id,"title"=>"$title","body"=>"$content"]);
            }

            foreach ($deviceTokens as $devToken) {

                if(strlen($devToken->mobileToken)>10){

                array_push($registration_ids,$devToken->mobileToken);

                }

            }

        }
		$response=array();
		$response1=array();
        if(count($registration_ids)>0){
			 for($i=0;$i<2;$i++){
			 	if($i==0){
             $data = [
                "registration_ids" => $registration_ids,
                "notification" => [
                      "title" => "$title",
               	 	  "body" => "$content"
                    ],
                  "priority" => "high"
             ];

             $dataString = json_encode($data);
             $headers = ['Authorization:key=AAAADRalTAg:APA91bFqTjZ3Tw30ZxV3zKHSuzyB_K000uxjepc4eNMl8nbFKleRp4B8OOWmIvxRz00WNoNwoOa2fPJtOBzZ3kTvLeWMX1vWVcHUyuOdujDZgML3IBnO5CyvD-zZtxxAivGlhJYnN5uJ',
                 'Content-Type: application/json'
             ];
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
             curl_setopt($ch, CURLOPT_POST, true);
             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            $response = curl_exec($ch);
					
			 	}else{
            //used for notifications
			
              $data1 = [
						'registration_ids' => $registration_ids,
						'data' => [
							'data_title' => $title,
							'data_body' => $content,
						],
						'priority' => 'high',
					];

              $dataString1 = json_encode($data1);
              $headers1 =['Authorization:key=AAAADRalTAg:APA91bFqTjZ3Tw30ZxV3zKHSuzyB_K000uxjepc4eNMl8nbFKleRp4B8OOWmIvxRz00WNoNwoOa2fPJtOBzZ3kTvLeWMX1vWVcHUyuOdujDZgML3IBnO5CyvD-zZtxxAivGlhJYnN5uJ',
'Content-Type: application/json'];
              $ch1 = curl_init();
              curl_setopt($ch1, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
              curl_setopt($ch1, CURLOPT_POST, true);
              curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
              curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch1, CURLOPT_POSTFIELDS, $dataString1);
             $response1 = curl_exec($ch1);
			
			 	}
			 }
			
            $notifications=DB::select("SELECT *,Format(sendTime,'yyyy/MM/dd hh:mm:ss','fa-ir') AS sendPersianDate
										FROM Shop.dbo.Peopels INNER JOIN NewStarfood.dbo.star_notificationHistory
										ON PSN=customerId ORDER BY NotificationSn DESC");
            return Response::json(['info'=>$response,'done'=>1,'notifications'=>$notifications]);
        }else{
            return Response::json(['info'=>"0",'done'=>0]);
        }
    }
    public function serachNotificationsByDate(Request $request)
    {
        $firstDate=$request->get("firstDate");
        $secondDate=$request->get("secondDate");
        if(strlen($firstDate)<3){
            $firstDate="1366/01/01";
        }
        if(strlen($secondDate)<3){
            $secondDate="1566/01/01";
        }

        $notifications=DB::select("SELECT *,Format(sendTime,'yyyy/MM/dd hh:mm:ss','fa-ir') AS sendPersianDate FROM Shop.dbo.Peopels INNER JOIN NewStarfood.dbo.star_notificationHistory ON PSN=customerId WHERE Format(sendTime,'yyyy/MM/dd','fa-ir')>='$firstDate' and Format(sendTime,'yyyy/MM/dd','fa-ir')<='$secondDate'");
        return Response::json(['notifications'=>$notifications]);
    }
	
	public function deleteNotificationHistory(Request $request){
		DB::table("NewStarfood.dbo.star_notificationHistory")->delete();
		return Response::json(1);
	}
}
