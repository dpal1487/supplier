<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginActivityResource;
use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class LoginActivityController extends Controller
{
    public function loginActivity(Request $request)
    {
        $date = Carbon::parse($request->start_date)->format('Y-m-d');
        $loginActivities = LoginActivity::orderBy('created_at', 'desc');
        if (!empty($request->q)) {
            $loginActivities = $loginActivities->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->q}%")->orWhere('last_name', 'like', "%{$request->q}%");
            })->where('created_at', 'like', "%{$date}%");
        }
        if (!empty($request->start_date)) {

            $loginActivities = $loginActivities->where('created_at', 'like', "%{$date}%");
        }

        $loginActivities = $loginActivities->paginate(10)->appends(request()->query());
        return Inertia::render('LoginActivity/Index', [
            'login_activities' => LoginActivityResource::collection($loginActivities),
        ]);
    }
}
