<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{
    public function index(){
        return view("payment.payment");
    }
}
