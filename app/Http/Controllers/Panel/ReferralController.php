<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
    	return view('backend.account.referrals');
    }
}
