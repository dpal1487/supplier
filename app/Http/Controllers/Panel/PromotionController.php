<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
    	return view('backend.account.promotions');
    }
}
