<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionResource;
use App\Models\PermissionMenu;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = new Permission();

        if (!empty($request->q)) {
            $permissions = $permissions->where('name', 'like', "%$request->q");
            // return $permissions->get();
        }
        // return $permissions->roles()->get();
        return Inertia::render('UserACL/Permissions/Index', [
            'permissions' => PermissionResource::collection($permissions->paginate(10)->appends($request->all())),
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'name' => 'required|unique:permissions,name',
            'name' => 'required|string|max:255|unique:permissions,name',

        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $existingPermission = Permission::where('name', 'like', "%$request->name")->first();

        // return $existingPermission;

        if ($existingPermission) {
            $existingPermission->delete();
        }
        Permission::create(['name' => $request->name . ' read']);
        Permission::create(['name' => $request->name . ' write']);
        Permission::create(['name' => $request->name . ' delete']);
        return response()->json(createMessage('Permission'));
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $permission = Permission::find($id);

        return response()->json([
            'success' => true,
            'permission' => new PermissionResource($permission)
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'success' => false]);
        }
        $permission = Permission::where('id', $id)->update([
            'name' => $request->name,
        ]);
        if ($permission) {
            return response()->json([
                'success' => true,
                'message' => 'Permission updated Successfully',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Permission not updated'
        ]);
    }
    public function destroy(Request $request)
    {

        if (Permission::where('id', $request->id)->delete()) {
            return response()->json(['success' => true, 'message' => 'Permission has been deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Opps something went wrong!']);
    }
    public function assignRole(Request $request, Permission $permission)
    {
        if ($permission->hasRole($request->role)) {
            return back()->with('message', 'Role exists.');
        }

        $permission->assignRole($request->role);
        return back()->with('message', 'Role assigned.');
    }

    public function removeRole(Permission $permission, Role $role)
    {
        if ($permission->hasRole($role)) {
            $permission->removeRole($role);
            return back()->with('message', 'Role removed.');
        }
        return back()->with('message', 'Role not exists.');
    }
}
