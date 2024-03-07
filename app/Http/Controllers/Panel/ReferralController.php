<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        return "account refrel view page view";
        return view('backend.account.referrals');
    }
}
