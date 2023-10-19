<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GoodGroups;
use BrowserDetect;
use Illuminate\Support\Facades\Validator;
use Response;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use App\Http\Controllers\Kala;
class Group extends Controller {
	// گروه های اصلی را در سمت فرانت لیست می کند.
    public function index(Request $request){
        $allGroups=DB::select("SELECT id,title,mainGroupPriority FROM NewStarfood.dbo.star_group 
								WHERE selfGroupId=0  order by mainGroupPriority asc");
        return view('groups.maingroups',['groups'=>$allGroups]);
    }

    public function addGroup(Request $request){
        $groupName=$request->post('mainGroupName');
        $priority=$request->post("priority");
        DB::update("UPDATE NewStarfood.dbo.star_group SET mainGroupPriority+=1 where mainGroupPriority>=".$priority." and selfGroupId=0");
		
        DB::insert("INSERT INTO NewStarfood.dbo.star_group(title,created_date,selfGroupId,percentTakhf,secondBranchId,thirdBranchId,mainGroupPriority) VALUES('".$groupName."',DEFAULT,0,0,0,0,".$priority.")");
		
        if($request->file('mainGroupPicture')){
			$picture=$request->file('mainGroupPicture');
			$filename=$picture->getClientOriginalName();
			$maxGroupId=DB::table("NewStarfood.dbo.star_group")->where("selfGroupId",0)->select("id")->max('id');
			$filename=($maxGroupId).'.'.'jpg';
			$picture->move("resources/assets/images/mainGroups/",$filename);
        }
        $mainGroups=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=0 order by mainGroupPriority asc");
        return Response::json(["mainGroups"=>$mainGroups]);
   }
   public function deleteMainGroup(Request $request)
   {
       $mainGroupsId=$request->post('mainGroupId');
       $mainGroupId=0;
       foreach ($mainGroupsId as $groupId) {
        list($mainGroupId, $b) = explode('_',$groupId);
       }
       $priorities=DB::table("NewStarfood.dbo.star_group")->select("mainGroupPriority")->where("selfGroupId",0)->get();
       $priority=0;
       foreach ($priorities as $pr) {
           $priority=$pr->mainGroupPriority;
       }
        $subGroupList=DB::table("NewStarfood.dbo.star_group")->where('selfGroupId',$mainGroupId)->select("id")->get();
        foreach($subGroupList as $subGroup){
            DB::table("NewStarfood.dbo.star_add_prod_group")->where("secondGroupId",$subGroup->id)->delete();
            if(file_exists("resources/assets/images/subgroup/".$subGroup->id.".jpg")){
                unlink("resources/assets/images/subgroup/".$subGroup->id.".jpg");
            }
        }
        DB::table("NewStarfood.dbo.star_group")->where('selfGroupId',$mainGroupId)->delete();
        DB::table("NewStarfood.dbo.star_group")->where('id',$mainGroupId)->delete();
        DB::update("UPDATE NewStarfood.dbo.star_group set mainGroupPriority-=1 where selfGroupId=0 and mainGroupPriority>".$priority);
        if(file_exists("resources/assets/images/mainGroups/".$mainGroupId.".jpg")){
            unlink("resources/assets/images/mainGroups/".$mainGroupId.".jpg");
        }
        $mainGroups=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=0 order by mainGroupPriority asc");
        return Response::json(["mainGroups"=>$mainGroups]);
   }

   public function editMainGroup(Request $request){
		   $groupId=$request->post('groupId');
		   $groupName=$request->post('groupName');
		   if($request->file('groupPicture')){
		   $picture=$request->file('groupPicture');
		   $filename=$request->file('groupPicture')->getClientOriginalName();
		   $filename=$groupId.'.'.'jpg';
		   $picture->move("resources/assets/images/mainGroups/",$filename);
		   }
		   DB::update("UPDATE NewStarfood.dbo.star_group set title='".$groupName."' where id=".$groupId);
		   $mainGroups=DB::select("SELECT id,title from NewStarfood.dbo.star_group 
		   							WHERE selfGroupId=0 order by mainGroupPriority ASC");
		   return Response::json(["mainGroups"=>$mainGroups]);
	 }

	public function editSubGroup(Request $request)
    {
        $fatherGroupId=$request->post('fatherMainGroupId');
        $title=$request->post("subGroupNameEdit");
        $subGruopId=$request->post("subGroupId");

        if($request->file('subGroupPictureEdit')){
			$picture=$request->file('subGroupPictureEdit');
			$filename=$request->file('subGroupPictureEdit')->getClientOriginalName();
			$filename=$subGruopId.'.'.'jpg';
			$picture->move("resources/assets/images/subgroup/",$filename);
        }
        DB::update("UPDATE NewStarfood.dbo.star_group
        SET title = '".$title."' 
        WHERE id=".$subGruopId);
        $subGroups=DB::select('select id, title,selfGroupId, percentTakhf from NewStarfood.dbo.star_group where selfGroupId='.$fatherGroupId.' order by subGroupPriority asc');
        return Response::json(['subGroups'=>$subGroups]);
    }
	
	    public function addSubGroup(Request $request)
    {
        $title=$request->post('groupTitle');
        $priority=$request->post('priority');
        $fatherGroupId=$request->post('fatherMainGroupId');
        $selfGroupId=$request->post('selfGroupId');
        DB::update("UPDATE NewStarfood.dbo.star_group set subGroupPriority+=1 where subGroupPriority>=".$priority." and selfGroupId=".$fatherGroupId);
        DB::insert("INSERT INTO NewStarfood.dbo.star_group (title,created_date,selfGroupId,percentTakhf,subGroupPriority)
        VALUES('".$title."',DEFAULT,".$fatherGroupId.",0,".$priority.")") ;
        if($request->file('subGroupPicture')){
        $picture=$request->file('subGroupPicture');
        $filename=$request->file('subGroupPicture')->getClientOriginalName();
        $maxSubGroup=DB::table("NewStarfood.dbo.star_group")->where("selfGroupId",$fatherGroupId)->select("id")->max('id');
        $filename=$maxSubGroup.'.'.'jpg';
        $picture->move("resources/assets/images/subgroup/",$filename);
        }
        $subGroups=DB::select('SELECT id, title,selfGroupId, percentTakhf from NewStarfood.dbo.star_group where selfGroupId='.$fatherGroupId.' order by subGroupPriority asc');
        return Response::json(['subGroups'=>$subGroups]);
    }
    
    public function deleteSubGroup(Request $request)
    {
        $subGroupId=$request->post('id');
        $priorities=DB::table("NewStarfood.dbo.star_group")->where('id',$subGroupId)->select("subGroupPriority")->get();
        $priority=0;
        foreach ($priorities as $pr) {
            $priority=$pr->subGroupPriority;
        }
        $mainGroupIds=DB::table("NewStarfood.dbo.star_group")->where('id',$subGroupId)->select('selfGroupId')->get();
        $mainGroupId=0;
        foreach ($mainGroupIds as $mainGrId) {
            $mainGroupId=$mainGrId->selfGroupId;
        }
        DB::table("NewStarfood.dbo.star_add_prod_group")->where('secondGroupId',$subGroupId)->delete();
        DB::table("NewStarfood.dbo.star_group")->where('id',$subGroupId)->delete();
        DB::update("UPDATE NewStarfood.dbo.star_group SET subGroupPriority-=1 where subGroupPriority>".$priority." and selfGroupId=".$mainGroupId);
        if(file_exists("resources/assets/images/subgroup/".$subGroupId.".jpg")){
            unlink("resources/assets/images/subgroup/".$subGroupId.".jpg");
        }
        $subGroups=DB::select('select id, title,selfGroupId, percentTakhf from NewStarfood.dbo.star_group where selfGroupId='.$mainGroupId.' order by subGroupPriority asc');
        return Response::json(['subGroups'=>$subGroups]);
    }
	
	    public function changeSubGroupPriority(Request $request)
    {
        $priorityState=$request->get("priorityState");
        $groupId=$request->get("subGrId");
        $mainGroupId=$request->get("mainGroupId");
        $countAllGroupsList=DB::table("NewStarfood.dbo.star_group")->where('selfGroupId',$mainGroupId)->count();
        
        $priorities=DB::table("NewStarfood.dbo.star_group")->where('id',$groupId)->select('subGroupPriority')->get();
        $priority=0;
        foreach ($priorities as $pr) {
            $priority=$pr->subGroupPriority;
        }
        if($priorityState=="top"){
            if($priority>1){
                DB::update('UPDATE NewStarfood.dbo.star_group set subGroupPriority-=1 WHERE id='.$groupId);
                DB::update('UPDATE NewStarfood.dbo.star_group set subGroupPriority='.($priority).' WHERE selfGroupId='.$mainGroupId.' and id!='.$groupId.' and subGroupPriority='.($priority-1));
            }
        }
        if($priorityState=="down"){
            if($priority<$countAllGroupsList){
                DB::update('UPDATE NewStarfood.dbo.star_group set subGroupPriority+=1 WHERE id='.$groupId);
                DB::update('UPDATE NewStarfood.dbo.star_group set subGroupPriority='.($priority).' WHERE selfGroupId='.$mainGroupId.' and id!='.$groupId.' and subGroupPriority='.($priority+1));
            }
        }
        $subGroups=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=".$mainGroupId." order by subGroupPriority asc");
        return Response::json($subGroups);
    }
	
	public function getSubGroups(Request $request){
        $mainGroupId=$request->get('id');
        $subGroups=DB::select('SELECT id, title,selfGroupId, percentTakhf FROM NewStarfood.dbo.star_group 
								WHERE selfGroupId='.$mainGroupId.' order by subGroupPriority asc');
        return Response::json($subGroups); 
    }
	
 	public function getAllMainGroups(Request $request)
	 {
		 $groups=DB::select('SELECT id,title FROM NewStarfood.dbo.star_group WHERE selfGroupId=0');
		 return Response::json($groups);
	 }

 public function getMainGroupById(Request $request)
 {
     $groupId=$request->get('groupId');
     $group=DB::select('SELECT id,title FROM NewStarfood.dbo.star_group WHERE selfGroupId=0 AND id='.$groupId);
     return Response::json($group);
 }

 public function getMainGroupByTitle(Request $request) {
     $searchTerm=$request->get('searchTerm');
     $groups=DB::select("SELECT id,title FROM NewStarfood.dbo.star_group WHERE title like '%".$searchTerm."%' and selfGroupId=0");
     return Response::json($groups);
 }

	/*
 public function changeGroupsPartPriority(Request $request)
    {
        $partId=$request->get('partId');
        list($groupId,$title)=explode('_',$request->get('groupId'));
        $priorityFlag=$request->get('priority');
        $group = DB::select("SELECT priority FROM NewStarfood.dbo.star_add_homePart_stuff WHERE firstGroupId=".$groupId." AND homepartId=".$partId);
        $groupCount = DB::select("SELECT COUNT(id) countGroup FROM NewStarfood.dbo.star_add_homePart_stuff WHERE  homepartId=".$partId);
        $countAllGroups=0;
        foreach ($groupCount as $countGroup) {
            $countAllGroups=$countGroup->countGroup;
        }
        $priority=0;
        foreach ($group  as $g) {
            $priority=$g->priority;
        }
        if ($priorityFlag=='up') {
            if($priority>1){
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority-1).' WHERE homepartId='.$partId.'and firstGroupId='.$groupId);
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority).' WHERE homepartId='.$partId.'and firstGroupId!='.$groupId.' and priority='.($priority-1));
            
            return redirect('/controlMainPage');
            }
        } else {
            if($priority<$countAllGroups and $priority>0){
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority+1).' WHERE homepartId='.$partId.'and firstGroupId='.$groupId);
            DB::update('UPDATE NewStarfood.dbo.star_add_homePart_stuff set priority='.($priority).' WHERE homepartId='.$partId.'and firstGroupId!='.$groupId.' and priority='.($priority+1));
            return redirect('/controlMainPage');
            }

        }
    }
	
*/
	// اولویت گروه های اصلی را تغییر می دهد.
public function changeMainGroupPriority(Request $request)
    {
        $priorityState=$request->get("priorityState");
        $groupId=$request->get("mainGrId");
        $countAllGroupsList=DB::table("NewStarfood.dbo.star_group")->where('selfGroupId',0)->count();
        $priorities=DB::table("NewStarfood.dbo.star_group")->where('id',$groupId)->select('mainGroupPriority')->get();
        $priority=0;
        foreach ($priorities as $pr) {
            $priority=$pr->mainGroupPriority;
        }
        if($priorityState=="top"){
            if($priority>1){
                DB::update('UPDATE NewStarfood.dbo.star_group set mainGroupPriority-=1 WHERE id='.$groupId);
                DB::update('UPDATE NewStarfood.dbo.star_group set mainGroupPriority='.($priority).' WHERE id!='.$groupId.' and mainGroupPriority='.($priority-1));
            }
        }
        if($priorityState=="down"){
            if($priority<$countAllGroupsList){
                DB::update('UPDATE NewStarfood.dbo.star_group set mainGroupPriority+=1 WHERE id='.$groupId);
                DB::update('UPDATE NewStarfood.dbo.star_group set mainGroupPriority='.($priority).' WHERE id!='.$groupId.' and mainGroupPriority='.($priority+1));
            }
        }
		
        $mainGroups=DB::select("select id,title from NewStarfood.dbo.star_group where selfGroupId=0 order by mainGroupPriority asc");
        return Response::json($mainGroups);

    }
	// این میتد لیست زیر گروه های یک گروه اصلی را بر میگرداند در ضمن کالا را مشخص می کند که آیا در این  زیر گروه ها وجود دارد یا خیر.
public function getSubGroupAndCheckKala(Request $request)
    {
        $id=$request->get('id');
        $kalaId=$request->get('kalaId');
        $kala=DB::select('SELECT PubGoods.GoodName,PubGoods.GoodSn,PubGoods.Price,PubGoods.price2, GoodGroups.NameGRP,PUBGoodUnits.UName from Shop.dbo.PubGoods inner join Shop.dbo.GoodGroups on PubGoods.GoodGroupSn=GoodGroups.GoodGroupSn inner join Shop.dbo.PUBGoodUnits on PubGoods.DefaultUnit=PUBGoodUnits.USN where PubGoods.GoodSn='.$kalaId);
        $exactKala;
        foreach ($kala as $k) {
            $exactKala=$k;
        }
        $subGroupList=DB::select("select id,title,selfGroupId from NewStarfood.dbo.star_group  where selfGroupId=".$id);
        $addedKala=DB::select('select firstGroupId,product_id,secondGroupId from NewStarfood.dbo.star_add_prod_group WHERE product_id='.$kalaId);
        $exist="";
        
            foreach($subGroupList as $group){
                foreach($addedKala as $addkl){
                    if($addkl->secondGroupId==$group->id and $kalaId==$addkl->product_id){
                        $exist='ok';
                        break;
                    }else{
                        $exist='no';
                    }
                }
                $group->exist=$exist;
            }
        return Response::json($subGroupList);
    }
	
public function addKalaToSubGroups(Request $request){
        $mainGrId=$request->get('mainGrId');
        $subGrId=$request->get('subGrId');
        $kalaId=$request->get('kalaId');
        foreach ($subGrId as $id) {
            DB::insert("INSERT INTO NewStarfood.dbo.star_add_prod_group(firstGroupId,product_id,secondGroupId,thirdGroupId,fourthGroupId)
			values(".$mainGrId.",".$kalaId.",".$id.",0,0)");
         }
        return Response::json(1);
    }

public function deleteKalaFromSubGroups(Request $request){
        $mainGrId=$request->get('mainGrId');
        $subGrId=$request->get('subGrId');
        $kalaId=$request->get('kalaId');
        foreach ($subGrId as $id) {
            DB::delete("DELETE FROM NewStarfood.dbo.star_add_prod_group WHERE firstGroupId=".$mainGrId." 
						AND product_id=".$kalaId." AND secondGroupId=".$id);
         }
        return Response::json(1);
    }
	
public function getSubGroupKalaByName(Request $request)
    {
        $searchTerm=$request->get("searchTerm");
        $subGroupId=$request->get('subGrId');
        $kalas=DB::select("SELECT * FROM Shop.dbo.PubGoods 
        JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=star_add_prod_group.product_id 
        where PubGoods.GoodName like'%".$searchTerm."%' and secondGroupId=".$subGroupId." and PubGoods.GoodSn not in(select productId from NewStarfood.dbo.star_GoodsSaleRestriction where hideKala=1 )");
        return Response::json($kalas);
    }

    public function getMainGroups(Request $request)
    {
        $groups=DB::table("NewStarfood.dbo.star_group")->where("selfGroupId",0)->select("id",'title')->get();
        return json_encode($groups);
    }

    public function getSubGroupList(Request $request)
    {
        $id=$request->get('mainGrId');
        $subGroups=DB::select("SELECT id,title,selfGroupId FROM NewStarfood.dbo.star_group WHERE selfGroupId=".$id);
        return json_encode($subGroups);
    }

    public function getMainGroupKala(Request $request){
        $mainGrId=$request->get('mainGrId');
        $customerSn=$request->get("psn");
        $groupId=$mainGrId;
        $customerId=$customerSn;
        $lastReferesh=Carbon::parse(DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->max("visitDate"))->diffInHours(Carbon::now());
        $logedIns=DB::table("NewStarfood.dbo.star_customerTrack")->where("customerId",$customerId)->select("visitDate")->get();
        if($lastReferesh>=0 or count($logedIns)<1){
                $palatform=BrowserDetect::platformFamily();
                $browser=BrowserDetect::browserFamily();
            if(count($logedIns)<1){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'groupId'=>''.$groupId.'']);
            }elseif($lastReferesh>0){
                    DB::table("NewStarfood.dbo.star_customerTrack")->insert(['platform'=>$palatform,'customerId'=>$customerId,'browser'=>$browser,'groupId'=>''.$groupId.'']);
            }else{
                $lastLoginId=DB::select("SELECT MAX(id)lastLoginId FROM NewStarfood.dbo.star_customerTrack WHERE customerId=$customerId");
                if(count($lastLoginId)>0){
                    $lastLoginId=$lastLoginId[0]->lastLoginId;
                    $lastVisitedGroupIds=DB::select("SELECT groupId FROM NewStarfood.dbo.star_customerTrack WHERE id=$lastLoginId");
                    $groupIds;
                    if(count($lastVisitedGroupIds)>0){
                        $groupIds = explode("_",$lastVisitedGroupIds[0]->groupId);
                    }

                    if(!in_array($groupId,$groupIds)){
                        DB::update("UPDATE NewStarfood.dbo.star_customerTrack SET groupId+='_$groupId' WHERE customerId=$customerId AND id=$lastLoginId");
                    }
                }
            }
        }
        
        $listKala= DB::select("SELECT secondGroupId,firstGroupId,CompanyNo,GoodSn,GoodName,NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,IIF(NewStarfood.dbo.isFavoritOrNot(".$customerSn.",GoodSn)>0,'YES','NO') AS favorite,IIF(NewStarfood.dbo.isRequestedOrNot(".$customerSn.",GoodSn)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),NewStarfood.dbo.getProductExistance(GoodSn))) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid FROM(
            SELECT firstGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
            ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,secondGroupId FROM Shop.dbo.PubGoods
            INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
            INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
            INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
            LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=".$customerSn." and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
            LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
            LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn WHERE GoodPriceSale.FiscalYear=1402
            ) A WHERE firstGroupId=$mainGrId and CompanyNo=5 and not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 and productId=GoodSn ) ORDER BY Amount DESC");  
        
        $currency=1;
    
        $currencyName="ریال";
    
        $currencyExistance=DB::table("NewStarfood.dbo.star_webSpecialSetting")->get('currency');
        
            $currency=$currencyExistance[0]->currency;
    
        if($currency==10){
            $currencyName="تومان";
        }
    
        $listSubGroups=DB::select('SELECT * FROM NewStarfood.dbo.star_group where selfGroupId='.$mainGrId.'order by subGroupPriority desc');
    
        $logoPos=DB::select("SELECT logoPosition FROM NewStarfood.dbo.star_webSpecialSetting")[0]->logoPosition;
    
        return Response::json(['listKala'=>$listKala,'listGroups'=>$listSubGroups,'mainGrId'=>$mainGrId,'currency'=>$currency,'currencyName'=>$currencyName,'logoPos'=>$logoPos]);
    
    }

    public function getAllMainGroupBranches(Request $request) {
        $customerSn=$request->input("psn");
        $kalaObj=new Kala;

        $mainGroups=DB::select("SELECT * FROM NewStarfood.dbo.star_group WHERE selfGroupId=0");
        
        foreach ($mainGroups as $group) {
            $subGroups=DB::select("SELECT * FROM NewStarfood.dbo.star_group where selfGroupId=$group->id order by subGroupPriority desc");
            
            $listKala= DB::select("SELECT secondGroupId,firstGroupId,CompanyNo,GoodSn,GoodName,NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,IIF(NewStarfood.dbo.isFavoritOrNot($customerSn,GoodSn)>0,'YES','NO') AS favorite,IIF(NewStarfood.dbo.isRequestedOrNot($customerSn,GoodSn)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),NewStarfood.dbo.getProductExistance(GoodSn))) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid FROM(
                                    SELECT firstGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale
                                    ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,secondGroupId FROM Shop.dbo.PubGoods
                                    INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
                                    INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
                                    INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                                    LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerSn and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
                                    LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
                                    LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn WHERE GoodPriceSale.FiscalYear=1402
                                    ) A WHERE firstGroupId=$group->id and CompanyNo=5 and not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 and productId=GoodSn ) ORDER BY Amount DESC");  
                                    
            foreach ($subGroups as $subGroup) {
                $listKala= DB::select("SELECT secondGroupId,firstGroupId,FiscalYear,CompanyNo,GoodSn,GoodName,NewStarfood.dbo.getFirstUnit(GoodSn) AS UName,Price3,Price4,SnGoodPriceSale,IIF(NewStarfood.dbo.isFavoritOrNot($customerSn,GoodSn)>0,'YES','NO') AS favorite,IIF(NewStarfood.dbo.isRequestedOrNot($customerSn,GoodSn)=0,0,1) as requested,IIF(zeroExistance=1,0,IIF(ISNULL(SnOrderBYS,0)=0,NewStarfood.dbo.getProductExistance(GoodSn),NewStarfood.dbo.getProductExistance(GoodSn))) Amount,IIF(ISNULL(SnOrderBYS,0)=0,'No','Yes') bought,callOnSale,SnOrderBYS,BoughtAmount,PackAmount,overLine,NewStarfood.dbo.getSecondUnit(GoodSn) as secondUnit,freeExistance,activeTakhfifPercent,activePishKharid FROM(
                    SELECT firstGroupId,PubGoods.GoodSn,PubGoods.GoodName,PUBGoodUnits.UName,GoodPriceSale.Price3,GoodPriceSale.Price4,GoodPriceSale.SnGoodPriceSale,GoodPriceSale.FiscalYear
                    ,E.zeroExistance,E.callOnSale,SnOrderBYS,BoughtAmount,PackAmount,E.overLine,freeExistance,activeTakhfifPercent,activePishKharid,PubGoods.CompanyNo,secondGroupId FROM Shop.dbo.PubGoods
                    INNER JOIN NewStarfood.dbo.star_add_prod_group ON PubGoods.GoodSn=product_id
                    INNER JOIN NewStarfood.dbo.star_group ON star_group.id=star_add_prod_group.firstGroupId
                    INNER JOIN Shop.dbo.PUBGoodUnits ON PubGoods.DefaultUnit=PUBGoodUnits.USN
                    LEFT JOIN (SELECT  SnOrderBYS,SnGood,Amount as BoughtAmount,PackAmount FROM NewStarfood.dbo.FactorStar inner join NewStarfood.dbo.orderStar on FactorStar.SnOrder=orderStar.SnHDS where CustomerSn=$customerSn and orderStatus=0)f on f.SnGood=PubGoods.GoodSn
                    LEFT JOIN (SELECT freeExistance,zeroExistance,callOnSale,overLine,productId,activePishKharid,activeTakhfifPercent FROM NewStarfood.dbo.star_GoodsSaleRestriction)E on E.productId=PubGoods.GoodSn
                    LEFT JOIN Shop.dbo.GoodPriceSale ON GoodPriceSale.SnGood=PubGoods.GoodSn
                    ) A WHERE FiscalYear=1402 AND firstGroupId=$group->id AND secondGroupId=$subGroup->id and CompanyNo=5 and not exists(SELECT productId FROM NewStarfood.dbo.star_GoodsSaleRestriction WHERE hideKala=1 and productId=GoodSn ) ORDER BY Amount DESC"); 
                
                $subGroup->listKala=$listKala;
            }
            $group->listGroups=$subGroups;
        }
        return Response::json(["mainGroupBranches"=>$mainGroups]);
    }

}
