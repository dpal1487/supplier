<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Industry;
use App\Http\Resources\IndustryResource;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;

use Inertia\Inertia;

use Illuminate\Http\Request;

class IndustryController extends Controller
{

    public function index(Request $request)
    {
        $industries = new Industry();
        if (!empty($request->q)) {
            $industries = $industries->where('name', 'like', '%' . $request->q . '%');
        }
        if (!empty($request->status) && $request->status !== null) {
            $industries = $industries->where('status',  (int)$request->status);
        }
        return Inertia::render('Industry/Index', [
            'industries' => IndustryResource::collection($industries->paginate(10)->appends($request->all())),
        ]);
    }
    public function statusUpdate(Request  $request)
    {
        if (Industry::where(['id' => $request->id])->update(['status' => $request->status ? 1 : 0])) {
            $status = $request->status == 0  ? "Inactive" : "Active";
            return response()->json(['message' => "Your Industry has been " . $status, 'success' => true]);
        }
        return response()->json(['message' => 'Opps! something went wrong.', 'success' => false]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $industry = Industry::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        if ($industry) {
            Image::where(['id' => $request->image['id']])->update(['entity_id' => $industry->id, 'entity_type' => 'industry']);
            return response()->json(createMessage('Industry'));
        }
        return response()->json(errorMessage());
    }


    public function edit($id)
    {
        $industry = Industry::find($id);
        $image = Image::where(['entity_id' => $industry->id, 'entity_type' => 'industry'])->first();

        return response()->json([
            'industry' => new IndustryResource($industry),
            'image' => $image ?  new ImageResource($image) : null,

        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);
        $industry = Industry::find($request->id);
        if ($industry) {
            $update = Industry::where(['id' => $request->id])->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            if ($update) {
                Image::where(['id' => $request->image['id']])->update(['entity_id' => $industry->id, 'entity_type' => 'industry']);
                return response()->json(updateMessage('Industry'));
            } else {
                return response()->json([errorMessage()]);
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'Industries not updated',
        ]);
    }
    public function destroy($id)
    {
        $industry = Industry::find($id);
        if ($industry->delete()) {
            return response()->json(deleteMessage('Industry'));
        }
        return response()->json(errorMessage());
    }
}
