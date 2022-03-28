<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CustomerOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\Table\Table;

class CustomerOrderController extends Controller
{
    public function store(Request $request){

        $customerOrder = $request->validate([
            'customername' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'menu_id' => 'required',
            'user_id' => 'required',
            'quantity' => 'required',
            'RelatedItems' => 'required|json',
        ]);


        $customerOrder = CustomerOrder::create(
            [
                'menu_id' => $customerOrder['menu_id'],
                'user_id' => $customerOrder['user_id'],
                'quantity' => $customerOrder['quantity'],
                'RelatedItems' => $customerOrder['RelatedItems'],
            ],
            [
                User::create([
                    'customername' => $customerOrder['customername'],
                    'address' => $customerOrder['address'],
                    'telephone' => $customerOrder['telephone'],
                ])
            ]
    );
        return $customerOrder;
    }

    public function show($id){

        $getall = DB::table('menus')
        ->join('customer_orders', 'menus.id', '=', 'customer_orders.menu_id')
        ->join('categories', 'menus.category_id', '=', 'categories.id')
        ->select('categories.categoryname', 'menus.name', 'menus.price', 'customer_orders.RelatedItems', 'customer_orders.quantity')
        ->where('customer_orders.user_id', $id)
        ->get();
        return $getall;
    }
}




// {
//     Products:[{
//                 Category: "Pizzas",
//                 ProductList : [
//                               {"ProductName":"Pizza Margherita", "ProductPrice":6.90},
//                               {"ProductName":"Pizza Salame", "ProductPrice":7.90},
//                               {"ProductName":"Pizza Quattro Stagioni", "ProductPrice":9.90}
//                             ],
//                 Options:[
//                     {ProductName:"extra cheese", ProductPrice:1.00},
//                     {ProductName:"Big Pizza", ProductPrice:2.00}
//                     ]
//               },
//               {
//                 category:"Desserts",
//                 ProductList:[
//                     {ProductName:"Tiramisu", ProductPrice:3.90},
//                     {ProductName:"Crostate", ProductPrice:4.50}
//                     ]
//               }
//             ],
//      Delivery:3.5
// }

