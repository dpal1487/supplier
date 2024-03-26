<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectListResource;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $supplier = Supplier::where(['id' => $id])->first();
        return Inertia::render('Dashboard/Index', [
            'projects' => new ProjectListResource($supplier)
        ]);
    }
}