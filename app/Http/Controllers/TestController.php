<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class TestController extends Controller
{
    public function testFunc(Request $request){
        $userID = User::where('email', '=', 'login@rhraju.com')
            ->where('password', '=', '12345')
            ->select('id')
            ->first();
        
        return $userID->id;
    }
}
