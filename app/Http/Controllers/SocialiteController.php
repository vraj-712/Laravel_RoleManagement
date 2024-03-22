<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\MailerForGmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectForProvider(){
        return Socialite::driver('google')->redirect();
    }
    public function callbackForProvider(){
        try{
            $SocialUser = Socialite::driver('google')->user(); 

            if(User::where('email', $SocialUser->getEmail())->exists()){
                $user = User::where('email', $SocialUser->getEmail())->first();
                $mailData = [
                    'title' => "Welcome ". $user->name,
                    'body' => 'User Login Successfully'
                ] ;
                Mail::to($user->email)->send(new MailerForGmail($mailData));
                Auth::login($user);
                return redirect('/');
            }

            $user = User::where([
                'provider' => 'google',
                'provider_id' => $SocialUser->id
            ])->first(); 

            if(!$user){

               $user = User::create([
                    'name' => $SocialUser->getName(),
                    'email' => $SocialUser->getEmail(),
                    'provider' => 'google',
                    'provider_id' => $SocialUser->getId(),
                    'provider_token' => $SocialUser->token,
                    'email_verified_at' => now(),
                    ]);
                $user->assignRole('user');
    
                $mailData = [
                    'title' => "Welcome ". $user->name,
                    'body' => 'User Created Successfully'
                ] ;
                Mail::to($user->email)->send(new MailerForGmail($mailData));

            }

            $mailData = [
                'title' => "Welcome ". $user->name,
                'body' => 'User Login Successfully'
            ];
            Mail::to($user->email)->send(new MailerForGmail($mailData));
            
            Auth::login($user);
            return redirect('/');
        }catch(Exception $e){
            return redirect('/login');
        }
    }
}
