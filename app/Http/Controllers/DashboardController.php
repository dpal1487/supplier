<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Respondent;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = new Project();
        return Inertia::render('Dashboard', [
            'projects' => [
                'live_projects' => $projects->where(['status' => 'live'])->count(),
                'inactive_projects' => $projects->where('status', 'hold')->count(),
                'closed_projects' => $projects->where('status', 'close')->count(),
                'archived_projects' => $projects->where('status', 'archived')->count(),
                'latest_projects' => $projects->latest()->limit(10)->get(),
                'supplier_surveys' => Respondent::latest()->limit(10)->get()
            ]
        ]);
    }
}
