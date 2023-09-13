<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Session;
use Response;
use DateTime;
use App\Http\Controllers\Lottery;
class Cheque extends Controller{

public function showRequestForm(){
	$checkRequest=DB::table("NewStarfood.dbo.star_checkRequest")->where("customerId",Session::get('psn'))->get();
	$checkRequestOrNot=0;
	$checkReqState=-1;
	if(count($checkRequest)>0){
		$checkRequestOrNot=1;
		$checkReqState=$checkRequest[0]->AcceptState;
	}
	return view ('cheque.checkRequest',['checkRequestOrNot'=>$checkRequestOrNot,'checkReqState'=>$checkReqState]);
}

public function getChequeReqState(Request $request){
	$customerId=$request->input("customerId");
	$checkRequest=DB::table("NewStarfood.dbo.star_checkRequest")->where("customerId",$customerId)->get();
	$checkRequestOrNot=0;
	$checkReqState=-1;
	if(count($checkRequest)>0){
		$checkRequestOrNot=1;
		$checkReqState=$checkRequest[0]->AcceptState;
	}
	return Response::json(['acceptState'=>$checkReqState,'requestState'=>$checkRequestOrNot]);
}

public function addRequestCheck(Request $request){
	$name=$request->input("name");
	$customerId=$request->input("customerId");
	$milliCode=$request->input("milliCode");
	$phone=$request->input("phone");
	$milkState=$request->input("milkState");
	$bankAccNum=$request->input("accountNo");
	$bankName=$request->input("bankName");
	$bankBranchName=$request->input("branchName");
	$contractDate=$request->input("contractDate");
	$malikName=$request->input("malikName");
	$depositAmount=str_replace(",","",$request->input("depositAmount"));
	$malikPhone=$request->input("malikPhone");
	$homeAddress=$request->input("homeAddress");
	$jawazState=$request->input("jawazState");
	$workExperience=$request->input("workExperience");
	$lastAddress=$request->input("lastAddress");
	$reliablityMony=str_replace(",","",$request->input("reliablityMony"));
	$returnedCheckState=$request->input("returnedCheckState");
	$returnedCheckMoney=str_replace(",","",$request->input("returnedCheckMoney"));
	$returnedCheckCause=$request->input("returnedCheckCause");
	$zaminName=$request->input("zaminName");
	$zaminAddress=$request->input("zaminAddress");
	$zaminPhone=$request->input("zaminPhone");
	$zaminJob=$request->input("zaminJob");
	$lastSuppName=$request->input("lastSuppName");
	$lastSuppPhone=$request->input("lastSuppPhone");
	$lastSuppAddress=$request->input("lastSuppAddress");	  
	DB::table("NewStarfood.dbo.star_checkRequest")->insert([
		  'Name'=>''.$name.'',
          'MilliCode'=>''.$milliCode.'',
          'PhoneNumber'=>''.$phone.'',
          'MilkState'=>''.$milkState.'',
          'BankAccNum'=>''.$bankAccNum.'',
          'BankName'=>''.$bankName.'',
          'BankBranchName'=>''.$bankBranchName.'',
          'AcceptState'=>'New',
		  'customerId'=>$customerId,							
		  'ContractDate'=>''.$contractDate.'',
		  'MalikName'=>''.$malikName.'',
		  'DepositAmount'=>$depositAmount,
		  'MalikPhone'=>''.$malikPhone.'',
		  'HomeAddress'=>''.$homeAddress.'',
		  'JawazState'=>''.$jawazState.'',
		  'WorkExperience'=>''.$workExperience.'',
		  'LastAddress'=>''.$lastAddress.'',
		  'ReliablityMony'=>''.$reliablityMony.'',
		  'ReturnedCheckState'=>''.$returnedCheckState.'',
		  'ReturnedCheckMoney'=>$returnedCheckMoney,
		  'ReturnedCheckCause'=>''.$returnedCheckCause.'',
		  'ZaminName'=>''.$zaminName.'',
		  'ZaminAddress'=>''.$zaminAddress.'',
		  'ZaminPhone'=>''.$zaminPhone.'',
		  'ZaminJob'=>''.$zaminJob.'',
		  'LastSuppName'=>''.$lastSuppName.'',
		  'LastSuppPhone'=>''.$lastSuppPhone.'',
		  'LastSuppAddress'=>''.$lastSuppAddress.'']);
	return Response::json(1);
}

public function changeCheckReqState(Request $request){
	$changeState=$request->input("changeState");
	$chequeReqId=$request->input("chequeReqId");
	if($changeState=="delete"){
		DB::table("NewStarfood.dbo.star_checkRequest")->where("CheckReqSn",$chequeReqId)->delete();
	}
	if($changeState=="reject"){
		DB::table("NewStarfood.dbo.star_checkRequest")->where("CheckReqSn",$chequeReqId)->update(['AcceptState'=>'Rejected']);
	}
	if($changeState=="accept"){
		DB::table("NewStarfood.dbo.star_checkRequest")->where("CheckReqSn",$chequeReqId)->update(['AcceptState'=>'Accepted']);			
	}
	
	return Response::json("done");
}
	
function filterReqCheques(Request $request){
	$chequReqState=$request->input("chequeReqState");
	$chequReqs=DB::select("SELECT *,CRM.dbo.getCustomerPhoneNumbers(PSN) PhoneStr
							,CRM.dbo.getCustomerMantagheh(SnMantagheh) NameRec FROM NewStarfood.dbo.star_checkRequest 
								INNER JOIN Shop.dbo.Peopels ON PSN=customerId WHERE acceptState LIKE '%$chequReqState%'");
	return Response::json($chequReqs);
}
public function showCheckReqInfo(Request $request){
	$customerId=$request->get("customerId");
	$checkReqInfo=DB::select("SELECT *,star_checkRequest.Name as reqName,Peopels.Name as CustomerName FROM NewStarfood.dbo.star_checkRequest 
							  INNER JOIN Shop.dbo.Peopels ON customerId=PSN 
							  WHERE customerId=$customerId");
	return Response::json($checkReqInfo);
}

}