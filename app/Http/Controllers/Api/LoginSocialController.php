<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Customer;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Session;
use Hash;

class LoginSocialController extends Controller
{
    public function redirect($provider)
    { 
        return Socialite::driver($provider)->redirect();
    }
 
    public function Callback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        // dd($userSocial);die;
        $users      =   Customer::where(['email' => $userSocial->getEmail()])->first(); 

        if($users){
            Session::put('customer_id', $users->id);
            Session::put('customer_name', $users->name); 
            Session::put('customer_email', $users->email); 
            return redirect()->route('site.index');
        }else{
            $user = Customer::insertGetId([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'phone'         => '',
                'password'     => '',
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]); 
            Session::put('customer_id', $userSocial->getId());
            Session::put('customer_name', $userSocial->getName()); 
            Session::put('customer_email', $userSocial->getEmail());

            return redirect()->route('site.index');
        }
    }
}
