<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Cockie;
use DateTime;
use \Morilog\Jalali\Jalalian;
use Session;
use Carbon\Carbon;

class Infors extends Controller
{
    function index() {
        
    }
    function getInforTypeInfo(Request $request){
        $inforSn=$request->input("SnInfor");
        $infors=DB::select("SELECT * FROM Shop.dbo.Infors WHERE CompanyNo=5 AND SnInfor=$inforSn");
        return Response::json($infors);
    }
}
