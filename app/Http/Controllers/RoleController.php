<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Http\Resources\PermissionMenuResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionMenu;

class RoleController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function index()
    {
        $roles = Role::all();
        return Inertia::render('UserACL/RoleList', [
            'roles' => RoleResource::collection($roles),
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:roles,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $role = Role::create([
            'name' => $request->role,
            'slug' => Str::slug($request->role),
            'guard_name' => 'sanctum',
        ]);
        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->givePermissionTo($permissions);
        }
        if ($role) {
            return response()->json(createMessage('Role'));
        }
        return response()->json(errorMessage());
    }

    public function edit(int $id)
    {
        $role = Role::find($id);
        $role->load('permissions');
        return response()->json([
            'role' => new RoleResource($role),
            'permissions' => PermissionResource::collection(Permission::all())
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false], 400);
        }
        $permission = Role::where('id', $id)->update([
            'name' => $request->role,
            'slug' => Str::slug($request->role),

        ]);
        if ($permission) {
            return response()->json(updateMessage('Role'));
        }
        return response()->json([
            'success' => false,
            'message' => 'Role not updated'
        ]);
    }

    public function destroy($id)
    {
        if (Role::where('id', $id)->delete()) {
            return response()->json(deleteMessage('Role'));
        }
        return redirect()->back()->withErrors(errorMessage());

        // return response()->json('message', errorMessage());
    }
}
