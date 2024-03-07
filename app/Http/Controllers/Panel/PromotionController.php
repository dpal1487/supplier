<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        return "Promotion view page";
    	return view('backend.account.promotions');
    }
}
