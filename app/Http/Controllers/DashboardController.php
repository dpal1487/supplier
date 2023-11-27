<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
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
                'live_projects' => $projects->where('status' ,'live')->count(),
                'inactive_projects' => $projects->where('status', 'hold')->count(),
                'closed_projects' => $projects->where('status', 'close')->count(),
                'archived_projects' => $projects->where('status', 'archived')->count(),
                'cancelled_projects' => $projects->where('status', 'cancelled')->count(),
                'invoiced_projects' => $projects->where('status', 'invoiced')->count(),
                'latest_projects' => ProjectResource::collection($projects->latest()->limit(10)->get()),
            ]
        ]);
    }
}
