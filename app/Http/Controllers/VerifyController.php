<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VerifyController extends Controller
{
    public  function getVerify()
    {
        return Inertia::render('Verify');
    }

     public function postVerify(Request $request)
     {
         if ($user = User::where('code', $request->code)->first()) {
             $user->active = 1;
             $user->code = null;
             $user->save();
             return redirect()->route('login');
         } else {
             return back()->withErrors('Verify code is not correct',);
         }
     }
}
