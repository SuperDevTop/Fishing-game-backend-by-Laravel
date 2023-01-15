<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Info;
use Illuminate\Http\Request;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    //
    public function signup(Request $request)
    {
        $name = $request->name;

        $name_count = User::where('name', $name)->get()->count();

        if($name_count != 0)
        {
            return response([
                'result' => '1' // already exists
            ]);
        }

        $user = new User(); // If the current user is new one, create a new user.
        $user->name = $request->name;
        $user->password = Hash::make($request->password); // Hash password
        $user->save();   //If the pwd isn't hashed, the other can see it by db.

        // Create new info
        $id = User::all()->last()->id;

        $info = new Info();
        $info->ID = $id;
        $info->CoinAmt = 0;
        $info->position = DB::raw("(GeomFromText('POINT(0 0)'))");
        $info->save();

        //Create fish lists for the new user
        $fish = new Fish();
        $fish->ID = $id;
        $fish->BassCaught = 0;
        $fish->MuskieCaught = 0;
        $fish->BlueGillCaught = 0;
        $fish->BassTotal = 0;
        $fish->MuskieTotal = 0;
        $fish->BlueGillTotal = 0;
        $fish->save();

        return response([
            'result' => '2' // success
        ]);
    }

    public function login(Request $request)
    {
        $name = $request->name;
        $password = $request->password;

        if(Auth::attempt(['name' => $name, 'password' => $password]))
        {
            $id = User::where('name', $name)->get()->first()->id;
            return response([
                'result' => '1', //success
                'id' => $id
            ]);
        }
        else{
            $count = User::where('name', $name)->get()->count();

            if($count == 0)
            {
                return response([
                    'result' => '2' // no registered (because the name doesn't exist)
                ]);
            }
            else{
                return response([
                    'result' => '3' // wrong pwd-(name exists, but the wrong pwd)
                ]);
            }
        }
    }
}
