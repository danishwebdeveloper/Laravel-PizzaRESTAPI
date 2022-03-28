<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Resturantorder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResturantorderController extends Controller
{
    public function store(Request $request, $id)
    {

        $query = DB::table('customer_orders')
        ->select('menus.name', 'customer_orders.quantity', 'customer_orders.RelatedItems')
        ->selectRaw('(menus.price * customer_orders.quantity) As TotalPrice')
        ->join('menus', 'customer_orders.menu_id', '=' , 'menus.id' )
        ->where('customer_orders.user_id' , '=' , $id)
        ->get();
        $sum = $query->sum('TotalPrice');


        if($query->sum('TotalPrice') > 15 && $query->sum('TotalPrice') <= 30){
            // die('lol 1');
            $freereward = "Nothing";
            $ordertable = Resturantorder::create([
                'user_id' => $id,
                'totalprice' => $sum,
                'deliverycharges' => 0,
                'freeoffer' => $freereward,
            ]);
            $ordertable->save();
        }
        elseif($query->sum('TotalPrice') > 30)
        {

            $freereward = "Wine";
            $ordertable = Resturantorder::create([
                'user_id' => $id,
                'totalprice' => $sum,
                'deliverycharges' => 0,
                'freeoffer' => $freereward,
            ]);
            $ordertable->save();
        }
        else{
            $ordertable = Resturantorder::create([
                'user_id' => $id,
                'totalprice' => $sum,
                'deliverycharges' => 3.5,
                'freeoffer' => "No",
            ]);
            $ordertable->save();
        }
        return $query;
    }

    public function show($id)
    {
        $query = DB::table('resturantorders')
        ->select('users.customername', 'users.address' , 'resturantorders.user_id', 'resturantorders.totalprice', 'resturantorders.deliverycharges', 'resturantorders.freeoffer')
        ->join('users', 'resturantorders.user_id', '=', 'users.id')
        ->where('resturantorders.user_id', '=', $id)->get();
        return $query;
    }
}

