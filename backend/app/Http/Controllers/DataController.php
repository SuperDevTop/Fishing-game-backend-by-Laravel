<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Info;
use Illuminate\Http\Request;

class DataController extends Controller
{
    // Get the user's data
    public function getUserData(Request $request)
    {
        $id = $request->id; // When the user logs in, unity saves user id.

        // with that id, unity can get corresponding data to the current user from
        // the database
        // for this, unity sends id together each request.

        $fish = Fish::where('ID', $id)->get()->first();

        $BassCaught = $fish->BassCaught;
        $MuskieCaught = $fish->MuskieCaught;
        $BlueGillCaught = $fish->BlueGillCaught;
        $BassTotal = $fish->BassTotal;
        $MuskieTotal = $fish->MuskieTotal;
        $BlueGillTotal = $fish->BlueGillTotal;

        $coin = Info::where('ID', $id)->get()->first()->CoinAmt;

        return response()->json([
            'bassCaught' => $BassCaught,
            'muskieCaught' => $MuskieCaught,
            'blueGillCaught' => $BlueGillCaught,
            'bassTotal' => $BassTotal,
            'muskieTotal' => $MuskieTotal,
            'blueGillTotal' => $BlueGillTotal,
            'coin' => $coin
        ]);
    }

    // Catch a new fish
    public function catch(Request $request)
    {
        # code...
        $id = $request->id;
        $fish_type = $request->fish_name;

        $fish = Fish::where('ID', $id)->get()->first();

        switch($fish_type)
        {
            case 'Bass':
                $caughtcount = $fish->BassCaught;
                $caughtcount++;

                Fish::where('ID', $id)->update(['BassCaught' => $caughtcount]);

                $totalcount = $fish->BassTotal;
                $totalcount++;
                Fish::where('ID', $id)->update(['BassTotal' => $totalcount]);

                break;

            case 'Muskie':
                $caughtcount = $fish->MuskieCaught;
                $caughtcount++;
                Fish::where('ID', $id)->update(['MuskieCaught' => $caughtcount]);

                $totalcount = $fish->MuskieTotal;
                $totalcount++;
                Fish::where('ID', $id)->update(['MuskieTotal' => $totalcount]);

                break;
            
            case 'BlueGill':
                $caughtcount = $fish->BlueGillCaught;
                $caughtcount++;
                Fish::where('ID', $id)->update(['BlueGillCaught' => $caughtcount]);

                $totalcount = $fish->BlueGillTotal;
                $totalcount++;
                Fish::where('ID', $id)->update(['BlueGillTotal' => $totalcount]);

                break;
        }

        $fish = Fish::where('ID', $id)->get()->first();
        $BassCaught = $fish->BassCaught;
        $MuskieCaught = $fish->MuskieCaught;
        $BlueGillCaught = $fish->BlueGillCaught;
        $BassTotal = $fish->BassTotal;
        $MuskieTotal = $fish->MuskieTotal;
        $BlueGillTotal = $fish->BlueGillTotal;

        return response()->json([
            'bassCaught' => $BassCaught,
            'muskieCaught' => $MuskieCaught,
            'blueGillCaught' => $BlueGillCaught,
            'bassTotal' => $BassTotal,
            'muskieTotal' => $MuskieTotal,
            'blueGillTotal' => $BlueGillTotal
        ]);     
    }

    // Sell fishes
    public function sell(Request $request)
    {
        # code...
        $id = $request->id;
        $bass = $request->bass;
        $muskie = $request->muskie;
        $bluegill = $request->blueGill;
        $coin = $request->coin;

        $fish = Fish::where('ID', $id)->get()->first();

        $BassCaught = $fish->BassCaught - $bass;
        $MuskieCaught = $fish->MuskieCaught - $muskie;
        $BlueGillCaught = $fish->BlueGillCaught - $bluegill;

        Fish::where('ID', $id)->update([
            'BassCaught' => $BassCaught,
            'MuskieCaught' => $MuskieCaught,
            'BlueGillCaught' => $BlueGillCaught
        ]); 

        $info = Info::where('ID', $id)->get()->first();
        $CoinAmt = $info->CoinAmt + $coin;  // the coin is increased.
        
        Info::where('ID', $id)->update(['CoinAmt' => $CoinAmt]);

        return response()->json([
            'bassCaught' => $BassCaught,
            'muskieCaught' => $MuskieCaught,
            'blueGillCaught' => $BlueGillCaught,
            'coin' => $CoinAmt
        ]);

    }
}
