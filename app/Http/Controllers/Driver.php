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
class Driver extends Controller {
    public function allDrivers(Request $request){
        $allDrivers=DB::select("SELECT * FROM Shop.dbo.Sla_Drivers WHERE CompanyNo=5");
        return Response::json(['drivers'=>$allDrivers,'status'=>"200 OK"]);
    }
}