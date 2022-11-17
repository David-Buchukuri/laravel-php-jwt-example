<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function delete(): JsonResponse
    {
        Item::where('user_id', jwtUser()->id)->delete();

        return response()->json(['message' => 'deleted all your items'], 200);
    }
}
