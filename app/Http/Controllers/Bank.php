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
class Bank extends Controller {
    public function allBanks(Request $request){
        $bankKarts=DB::select("SELECT * FROM Shop.dbo.PubBanks p join Shop.dbo.AccBanks a on p.SerialNoBSN=a.SnBank where p.CompanyNo=5 and SerialNoBSN!=0");
        return Response::json(['bankKarts'=>$bankKarts,'status'=>"200 OK"]);
    }
}