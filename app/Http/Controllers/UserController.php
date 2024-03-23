<?php

namespace App\Http\Controllers;

use App\Http\Resources\RespondentResource;
use App\Models\Respondent;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function projects(Request $request, $id)
    {
        $surveys = Respondent::where('user_id', $id)->orderBy('created_at', 'desc');
        $user = User::find($id);
        if (!empty($request->q)) {
            $surveys = $surveys->where(function ($query) use ($request) {
                $query->whereHas('project', function ($projectQuery) use ($request) {
                    $projectQuery->where('project_name', 'like', "%$request->q%");
                })->orWhereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('first_name', 'like', "%$request->q%")->orWhere('last_name', 'like', "%$request->q%");
                });
            });
        }
        if ($request->status != 'all' && $request->status !== null) {
            $surveys = $surveys->where('status', $request->status);
        }
        return Inertia::render('User/Project', [
            'surveys' => RespondentResource::collection($surveys->paginate(20)->appends(request()->query())),
        ]);
    }
}
