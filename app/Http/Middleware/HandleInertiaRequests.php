<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{

    protected $rootView = 'app';
    protected $user = [];
    protected $status = [
        [
            'name' => 'All',
            'value' => 'all',
        ],
        [
            'name' => 'Active',
            'value' => '1',
        ],
        [
            'name' => 'Inactive',
            'value' => '0',
        ],
    ];


    public function version(Request $request)
    {
        return parent::version($request);
    }


    public function share(Request $request)
    {
        $this->user = Auth::user();
        return array_merge(parent::share($request), [
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'user' => $this->user,
                    'status' => $this->status,
                    'flash' => [
                        'message' => fn () => $request->session()->get('message'),
                    ],
                ]);
            },
        ]);
    }
}
