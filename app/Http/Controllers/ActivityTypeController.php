<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityTypeResource;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ActivityTypeController extends Controller
{

    public function index(Request $request)
    {
        $activityTypes = new ActivityType;
        if (!empty($request->q)) {
            $activityTypes = $activityTypes->where('text', 'like', "%{$request->q}%");
        }
        return Inertia::render('ActivityType/Index', [
            'activity_types' => ActivityTypeResource::collection($activityTypes->paginate(5)->appends(request()->query())),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tesxt' => 'required',
        ]);
        $activityType = ActivityType::create([
            'text' => $request->text,
        ]);
        if ($activityType) {
            return response()->json(createMessage('ActivityType'));
        }
    }
    public function edit(Request $request)
    {
        $activityType = ActivityType::find($request->id);
        return response()->json([
            'success' => true,
            'activity_type' => new ActivityTypeResource($activityType),
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);
        $activityType = ActivityType::find($request->id);
        if ($activityType) {
            $update = ActivityType::where('id', $request->id)->update([
                'text' => $request->text,
            ]);
            if ($update) {
                return response()->json(updateMessage('ActivityType'));
            } else {
                return response()->json(errorMessage());
            }
        }
    }

    public function destroy($id)
    {
        $activityType = ActivityType::find($id);
        if ($activityType->delete()) {
            return response()->json(deleteMessage('ActivityType'));
        }
        return response()->json(errorMessage());
    }
}
