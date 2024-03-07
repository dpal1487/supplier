<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Files ,User};
use Validator,Redirect,Response ,Image;

class FileController extends Controller
{

        public function updateProfileImage($request,$user)
        {
            $image = $request->file('file');
            if($image) {
                    $extension = $request->file->extension();
                    $file_path = 'assets/images/';
                    $name = time().'_'.$request->file->getClientOriginalName();
                    $result= Image::make($image)->save($file_path.$name);
                    $smallthumbnail = date('mdYHis'). '-' . uniqid() . '.' . '_small_'. '.' .$extension;
                    $mediumthumbnail = date('mdYHis'). '-' . uniqid() . '.' . '_medium_' . '.' .$extension;

                    $smallThumbnailFolder = 'assets/images/thumbnail/small/';
                    $mediumThumbnailFolder = 'assets/images/thumbnail/medium/';

                    $result = $result->save($file_path.$name);

                    $result->resize(200,200);
                    $result = $result->save($file_path.'thumbnail/small/'.$smallthumbnail);

                    $result->resize(100,100);
                    $result = $result->save($file_path.'thumbnail/medium/'.$mediumthumbnail);

                    $Imagefile = new Files();
                    $Imagefile->file_name = $name;
                    $Imagefile->file_path = url($file_path.$name);
                    $Imagefile->file_path_small = url($smallThumbnailFolder.$smallthumbnail);
                    $Imagefile->file_path_medium = url($mediumThumbnailFolder.$mediumthumbnail);
                    //$Imagefile->file_size = $size;
                    //$Imagefile->file_mime = $mime;
                    $Imagefile->file_extension = $extension;
                    if($Imagefile->save()){
                            User::where('id',$user->id)->update(['image_id'=>$Imagefile->id]);
                        }
                        $user = User::where('id',$user->id)->with('image')->first();
                        return response()->json(['success'=>true,'image'=>$user->image->file_path_small]);
                }
        }
}
