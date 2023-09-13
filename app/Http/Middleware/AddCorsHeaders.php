<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Illuminate\Http\Request;

class AddCorsHeaders{

    public function handle($request, Closure $next){
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', 'https://starfoods.ir');
        return $response;
    }

}


