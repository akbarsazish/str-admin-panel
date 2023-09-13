<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Response;
use Session;
use Notification;
use Illuminate\Support\Facades\Http;
use App\Notifications\AlertNotification;
use Carbon\Carbon;
use \Morilog\Jalali\Jalalian;
use DateTime;
class Masir extends Controller{
    public function getCityInfo(Request $request)
    {
        $cityId=$request->get("id");
        $cities=DB::table("Shop.dbo.MNM")->where("SnMNM",$cityId)->get()->first();
        return Response::json($cities);
    }
    public function editCity(Request $request)
    {
        $cityName=$request->get("cityName");
        $cityId=$request->get("cityIdEdit");
        DB::table("Shop.dbo.MNM")->where("SnMNM",$cityId)->update(["NameRec"=>"".$cityName.""]);
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and Rectype=1 and FatherMNM=79");
        return Response::json($cities);
    }
    public function addCity(Request $request)
    {
        $cityName=$request->get("cityName");
        DB::table("Shop.dbo.MNM")->insert(['CompanyNo'=>5,'RecType'=>1,'NameRec'=>"".$cityName."",'FatherMNM'=>79,'SnSellerN'=>0,'Add_Update'=>0,'IsExport'=>0,'SnSellerN2'=>0]);
        $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and Rectype=1 and FatherMNM=79");
        return Response::json($cities);
    }
    public function deleteCity(Request $request)
    {
    $cityId=$request->get("id");
    DB::table("Shop.dbo.MNM")->where("SnMNM",$cityId)->delete();
    $cities=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and Rectype=1 and FatherMNM=79");
    return Response::json($cities); 
    }
    public function getMantaghehInfo(Request $request)
    {
        $id=$request->get("id");
        $mantiqah=DB::table("Shop.dbo.MNM")->where("SnMNM",$id)->get()->first();
        return Response::json($mantiqah);
    }
    public function editMantagheh(Request $request)
    {
        $name=$request->get("Name");
        $id=$request->get("mantaghehIdEdit");
        $cityId=$request->get("cityId");
        DB::table("Shop.dbo.MNM")->where("SnMNM",$id)->update(['NameRec'=>"".$name.""]);
        $mantiqah=DB::table("Shop.dbo.MNM")->where("FatherMNM",$cityId)->get();
        return Response::json($mantiqah);
    }
    public function addMantiqah(Request $request)
    {
        $cityId=$request->get("cityId");
        $name=$request->get("name");
        DB::table("Shop.dbo.MNM")->insert(['CompanyNo'=>5,'RecType'=>2,'NameRec'=>"".$name."",'FatherMNM'=>$cityId,'SnSellerN'=>0,'Add_Update'=>0 ,'IsExport'=>0,'SnSellerN2'=>0]);
        $mantiqah=DB::table("Shop.dbo.MNM")->where("FatherMNM",$cityId)->get();
        return Response::json($mantiqah);
    }
    public function deleteMantagheh(Request $request)
    {
        $cityId=$request->get("cityId");
        $mantiqahId=$request->get("mantiqahId");
        DB::table("Shop.dbo.MNM")->where("SnMNM",$mantiqahId)->delete();
        $mantiqah=DB::table("Shop.dbo.MNM")->where("FatherMNM",$cityId)->get();
        return Response::json($mantiqah);
    }

    public function searchMantagha(Request $request)
    {
    $cityId=$request->get('cityId');
    $regions=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and FatherMNM=".$cityId);
    return Response::json($regions);
    }

    public function addMasir(Request $request)
    {
        $mantiqahId=$request->get("mantiqahId");
        $name=$request->get("name");
        DB::table("Shop.dbo.MNM")->insert(['CompanyNo'=>5,'RecType'=>2,'NameRec'=>"".$name."",'FatherMNM'=>$mantiqahId,'SnSellerN'=>0,'Add_Update'=>0 ,'IsExport'=>0,'SnSellerN2'=>0]);
        return Response::json(1);
    }

    public function getMasirs(Request $request)
    {
        $mantiqahId=$request->get("mantiqahId");
        $masirs=DB::select("SELECT * FROM Shop.dbo.MNM WHERE CompanyNo=5 and FatherMNM=".$mantiqahId);
        return Response::json($masirs);
    }
}