<?php
namespace App\Http\Controllers;
use App\Models\Star_CustomerPass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use BrowserDetect;
use Session;
use Response;

class AuthController extends Controller
{
public function register (Request $request){

    $validator = Validator::make($request->all(), [
    'name' => 'required|max:191',
    'email' => 'required|email:191|unique:users,email',
    'password' => 'required|min:8',
    ]);

    if($validator->fails()){

        return response()->json([
            'validation_errors' =>$validator->messages(),
        ]);

    }else{

        $user = Star_CustomerPass::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>Star_CustomerPass::make($request->password),
        ]);

        $token = $user->createToken($user->email.'_Token')->plainTextToken;

        return response()->json([
            'status' =>200,
            'username' =>$user->name,
            'token' =>$token,
            'message' =>'Registered Successfully',
        ]);

    }
}

public function irregularLoginApi(Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);
    if($validator->fails()){
        return response()->json([
            'validation_errors' =>$validator->messages(),
        ]);
    }else{
        $role="jaliLogin";
        $user = Star_CustomerPass::where('userName', $request->email)->where('customerPss',$request->password)->first();
        $sessionKeyId= $user->createToken(trim($user->userName), [''])->plainTextToken;
        $countBuy=DB::select("SELECT COUNT(SnOrderBYS) as countBuy FROM NewStarfood.dbo.orderStar  where exists(SELECT * FROM NewStarfood.dbo.FactorStar where SnOrder=SnHDS and OrderStatus=0 and CustomerSn=$user->customerId)");
        return response()->json([
            'status' =>200,
            'username' =>$user->userName,
            'token' =>$sessionKeyId,
            'message' =>'شما موفقانه وارد سیستم شدید!!',
            'psn' =>$user->customerId,
            'countBuy'=>$countBuy,
            'role'=>"jaliLogin"
        ]);
    }

}

public function login (Request $request){

    $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
    ]);

    if($validator->fails()){
            return response()->json([
                'validation_errors' =>$validator->messages(),
            ]);
    }else{
         $user = Star_CustomerPass::where('userName', $request->email)->where('customerPss',$request->password)->first();
         $role = 'customer';
        if(!$user){
                return response()->json([
                    'status'=>401,
                    'message'=>'نام کاربری و یا رمز ورود اشتباه است!',
                ]);
        }else{

            $allowMobile=0;
            //writ a query to get many mobile after comming at night
            $allowedMobiles=DB::table("NewStarfood.dbo.star_customerRestriction")->where('customerId',$user->customerId)->select("manyMobile")->get();
            foreach ($allowedMobiles as $mobile) {
                $allowMobile=$mobile->manyMobile;
            }

            $browserToken=$request->plainTextToken;

            if(strlen($browserToken)>5){
                
                if($allowMobile>0){
                
                    $isLogedInBefore=DB::table('NewStarfood.dbo.star_customerSession1')->where("customerId",$user->customerId)->where("sessionId",$browserToken)->get()->count();

                    if($isLogedInBefore>0){// اگر قبلا لاگین است
                        $SnLastBuy;
                        $SnLastBuy=DB::table('factorStar')->where('orderStatus',0)->where('CustomerSn',$user->customerId)->get()->max('SnOrder');
                        //جوابیکه به فرانت فرستاده می شود
                        
                        $name=trim($user->userName);
                        $alredyExistUser=DB::select("SELECT name,token from NewStarfood.dbo.personal_access_tokens where name='$name'");
                        $countBuy=DB::select("SELECT COUNT(SnOrderBYS) as countBuy FROM NewStarfood.dbo.orderStar  where exists(SELECT * FROM NewStarfood.dbo.FactorStar where SnOrder=SnHDS and OrderStatus=0 and CustomerSn=$user->customerId)");
                        $countBuy=$countBuy[0]->countBuy;
                        return response()->json([
                            'status' =>200,
                            'username' =>$user->userName,
                            'logedInBefore'=>1,
                            'token' =>$browserToken,
                            'message' =>'قبلا لاگین بودید',
                            'psn' =>$user->customerId,
                            'countBuy'=>$countBuy,
                            'role'=>$role
                        ]);
                    }

                    $countLogin=DB::table('star_customerSession1')->where("customerId",$user->customerId)->get()->count();

                    $allowanceCountUser=DB::table('star_customerRestriction')->where("customerId",$user->customerId)->select('manyMobile')->get();
                    $allowedDevice=1;
                    foreach ($allowanceCountUser as $allowanceTedad) {
                        $allowedDevice=$allowanceTedad->manyMobile;
                    }
                    $sessionKeyId= $user->createToken(trim($user->userName), [''])->plainTextToken;

                    $SnLastBuy;
                    $SnLastBuy=DB::table('factorStar')->where('orderStatus',0)->where('CustomerSn',$user->customerId)->get()->max('SnOrder');
                    //جوابیکه به فرانت فرستاده می شود
                    $countBuy=DB::select("SELECT COUNT(SnOrderBYS) as countBuy FROM NewStarfood.dbo.orderStar  where exists(SELECT * FROM NewStarfood.dbo.FactorStar where SnOrder=SnHDS and OrderStatus=0 and CustomerSn=$user->customerId)");
                    $countBuy=$countBuy[0]->countBuy;

                    if($countLogin<$allowedDevice){
                        //set session
                        if($countLogin>0){
                            $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
                            $palatform=BrowserDetect::platformFamily();
                            $browser=BrowserDetect::browserFamily();
                            DB::insert("INSERT INTO star_customerSession1(customerId,sessionId,platform,browser) VALUES(".$user->customerId.",'$sessionKeyId','".$palatform."','".$browser."')");
                        }else{
                            //show introducer Modal
                            return response()->json([
                                'status' =>200,
                                'browser'=>BrowserDetect::browserFamily(),
                                'username' =>$user->userName,
                                'token' =>$sessionKeyId,
                                'introducerCode'=>1,
                                'message' =>'لطفا کد معرف تان را وارد نمایید!',
                                'psn' =>$user->customerId,
                                'countBuy'=>$countBuy,
                                'role'=>$role
                            ]);
                            
                        }


                        if(count($alredyExistUser)>0){
                            $token=$alredyExistUser[0]->plainTextToken;
                        }else{
                            $token = $user->createToken(trim($user->userName), [''])->plainTextToken;
                        }
                        return response()->json([
                            'status' =>200,
                            'username' =>$user->userName,
                            'token' =>$token,
                            'message' =>'Logged In Successfully',
                            'isSuccessfull'=>1,
                            'psn' =>$user->customerId,
                            'countBuy'=>$countBuy,
                            'role'=>$role
                        ]);

                    }else{
                        //Exit one of devices from website

                        $logedInInfo=DB::table('NewStarfood.dbo.star_customerSession1')->where("customerId",$user->customerId)->get();
                        return response()->json([
                            'status' =>200,
                            'username' =>$user->userName,
                            'token' =>$sessionKeyId,
                            'loginInfo'=>$logedInInfo,
                            'browser'=>BrowserDetect::browserFamily(),
                            'message' =>'لطفا یکی از مرورگر ها را برای خروج انتخاب کنید!',
                            'psn' =>$user->customerId,
                            'countBuy'=>"",
                            'role'=>$role
                        ]);
                    }
                }else{
                    //User exited by force
                    $error="با دفتر شرکت در تماس شوید";
                    return response()->json([
                        'status' =>200,
                        'username' =>"",
                        'token' =>"",
                        'message' =>$error,
                        'psn' =>"",
                        'countBuy'=>0,
                        'role'=>$role
                    ]);
                }

            }else{

                if($allowMobile>0){
                
                    $countLogin=DB::table('star_customerSession1')->where("customerId",$user->customerId)->get()->count();

                    $allowanceCountUser=DB::table('star_customerRestriction')->where("customerId",$user->customerId)->select('manyMobile')->get();
                    $allowedDevice=1;
                    foreach ($allowanceCountUser as $allowanceTedad) {
                        $allowedDevice=$allowanceTedad->manyMobile;
                    }
                    $sessionKeyId= $user->createToken(trim($user->userName), [''])->plainTextToken;
                    if($countLogin<$allowedDevice){

                        $SnLastBuy;
                        $SnLastBuy=DB::table('factorStar')->where('orderStatus',0)->where('CustomerSn',$user->customerId)->get()->max('SnOrder');
                        //جوابیکه به فرانت فرستاده می شود
                        $role = '';
                        $countBuy=DB::select("SELECT COUNT(SnOrderBYS) as countBuy FROM NewStarfood.dbo.orderStar  where exists(SELECT * FROM NewStarfood.dbo.FactorStar where SnOrder=SnHDS and OrderStatus=0 and CustomerSn=$user->customerId)");
                        $countBuy=$countBuy[0]->countBuy;

                        //set session
                        if($countLogin>0){
                            $fiscallYear=DB::select("SELECT FiscallYear FROM NewStarfood.dbo.star_webSpecialSetting")[0]->FiscallYear;
                            $palatform=BrowserDetect::platformFamily();
                            $browser=BrowserDetect::browserFamily();
                            DB::insert("INSERT INTO star_customerSession1(customerId,sessionId,platform,browser) VALUES(".$user->customerId.",'$sessionKeyId','".$palatform."','".$browser."')");
                        }else{
                            //show introducer Modal
                            return response()->json([
                                'status' =>200,
                                'browser'=>BrowserDetect::browserFamily(),
                                'username' =>$user->userName,
                                'introducerCode'=>1,
                                'token' =>$sessionKeyId,
                                'message' =>'لطفا کد معرف تان را وارد نمایید!',
                                'psn' =>$user->customerId,
                                'countBuy'=>"",
                                'role'=>$role
                            ]);
                            
                        }


                        return response()->json([
                            'status' =>200,
                            'username' =>$user->userName,
                            'token' =>$sessionKeyId,
                            'message' =>'شما موفقانه وارد سیستم شدید!!',
                            'psn' =>$user->customerId,
                            'countBuy'=>$countBuy,
                            'role'=>$role
                        ]);

                    }else{
                        //Exit one of devices from website
                        $logedInInfo=DB::table('star_customerSession1')->where("customerId",$user->customerId)->get();
                        return response()->json([
                            'status' =>200,
                            'username' =>$user->userName,
                            'loginInfo'=>$logedInInfo,
                            'token' =>$sessionKeyId,
                            'browser'=>BrowserDetect::browserFamily(),
                            'message' =>'لطفا یکی از مرورگر ها را برای خروج انتخاب کنید!',
                            'psn' =>$user->customerId,
                            'countBuy'=>"",
                            'role'=>$role
                        ]);
                    }
                }else{
                    //User exited by force
                    $error="با دفتر شرکت در تماس شوید";
                    return response()->json([
                        'status' =>200,
                        'username' =>"",
                        'Allowed'=>0,
                        'token' =>"",
                        'message' =>$error,
                        'psn' =>"",
                        'countBuy'=>0,
                        'role'=>$role
                    ]);
                }

            }

        }
    }
}

public function checkLoginApi(Request $request)
{
    $token=$request->get("token");
    $userExist=DB::select("SELECT  * FROM NewStarfood.dbo.star_customerSession1 WHERE sessionId='$token'");
    if(count($userExist)>0){
        return Response::json(['isLogin'=>"YES"]);
    }else{
        return Response::json(['isLogin'=>"NO"]);
    }
}

public function logout(){
    auth()->user()->tokens()->delete();
    return response()->json([
        'status'=>200,
        'message'=>'Logged out Successfully',
    ]);
}
}