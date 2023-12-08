<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Models\Image as ImageModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ImageController extends Controller
{
    public function serviceImage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        if ($request->id != 'undefined') {
            $data = ImageModel::findOrFail($request->id);
            $bannerImage = $data->delete();
            $existingImagePath =  $data->base_path . $data->name;
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
        }
        $image = $request->file('image');
        if ($image) {
            $folder = 'assets/images/service/';
            $name = time() . '_' . $request->image->getClientOriginalName();
            $result = Image::make($image)->save($folder . $name);
            $Imagefile = ImageModel::updateOrCreate([
                'name' => $name,
                'base_url' => $request->root(),
                'base_path' => $folder,
            ]);
            if ($Imagefile->save()) {
                return response()->json([
                    'success' => true,
                    'data' => $Imagefile
                ]);
            }
        }
    }
}
