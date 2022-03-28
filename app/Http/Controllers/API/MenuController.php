<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function show($id)
    {

        $displaymenuwithCateogries = Menu::findorFail($id);
        return $displaymenuwithCateogries;
    }

    public function store(Request $request)
    {
        // die('here');
        $postMenuCateogry = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'categoryname' => 'required',
        ]);
        $addmenuwithCategory = Category::create([
            'categoryname' => $postMenuCateogry['categoryname'],
        ],
        [
            Menu::create([
            'name' => $postMenuCateogry['name'],
            'description' => $postMenuCateogry['description'],
            'price' => $postMenuCateogry['price'],
            ])
        ]
    );
    return $addmenuwithCategory;
    }
}
