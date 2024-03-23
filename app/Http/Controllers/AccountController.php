<?php

namespace App\Http\Controllers;

use App\Exports\UserReport;
use App\Http\Resources\ImageResource;
use App\Http\Resources\RespondentResource;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\Respondent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ImageManager;
use App\Http\Resources\CountryResource;
use App\Http\Resources\SupplierResource;
use App\Models\Country;
use App\Models\Supplier;

class AccountController extends Controller
{
    use ImageManager;
    public function index()
    {
        $user = Auth::user();
        $image = Image::where(['entity_id' => $user->id, 'entity_type' => 'supplier'])->first();
        $countries = Country::get();

        return Inertia::render('Account/Index', [
            'user' => new SupplierResource($user),
            'image' => new ImageResource($image),
            'countries' => CountryResource::collection($countries)
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'supplier_name' => 'required|string',
                'password' => 'required',
            ]);
            if (!Hash::check($request->password, auth()->user()->password)) {
                return back()->withErrors(["message" => "Password Doesn't match!"]);
            }
            if ($request->id) {
                Supplier::where('id', $request->id)->updateOrCreate(
                    ['id' => $request->id],
                    [
                        'supplier_name' => $request->supplier_name,
                        'password' => ($request->password ?  Hash::make($request->password) : auth()->user()->password),
                    ]
                );
                return redirect('/account')->with('flash',  updateMessage('User'));
            }
        } catch (\Exception $e) {
            return back()->withErrors(["message" => $e->getMessage()]);
        }
    }
    public function projects(Request $request)
    {
        $user = Auth::user();
        $surveys = Respondent::where('user_id', $user->id)->orderBy('created_at', 'desc');
        if ($request->q) {
            $surveys = $surveys->whereHas('project', function ($query) use ($request) {
                $query->where('project_name', 'like', "%$request->q%");
            });
        }
        if ($request->status !== 'all' && $request->status !== null) {
            $surveys = $surveys->where('status', $request->status);
        }
        return Inertia::render('Account/Project', [
            'surveys' => RespondentResource::collection($surveys->paginate(100)->appends(request()->query())),
            'user' => new UserResource($user),
        ]);
    }

    public function image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false]);
        }
        try {
            DB::beginTransaction();
            $path = public_path("/images/supplier");
            !is_dir($path) &&  mkdir($path, 0777, true);
            if ($file = $request->file('image')) {
                $fileData = $this->uploadImage($path, $file);
                // $image = User::where('id', $request->id)->first();
                $image = Image::where(['entity_id' => $request->id, 'entity_type' => 'supplier'])->first();
                if ($image) {
                    if (file_exists($image->profile_image)) {
                        unlink($image->profile_image);
                    }
                }
                Image::updateOrCreate(
                    ['entity_id' => $request->id],
                    [
                        'name' => $fileData['fileName'],
                        'type' => $fileData['fileType'],
                        'path' => $fileData['filePath'],
                        'size' => $fileData['fileSize'],
                        'entity_type' => 'supplier',
                        'entity_id' => $request->id,
                    ]
                );
            }
            DB::commit();
            return redirect()->back()->with('flash', createMessage('Profile Image'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
