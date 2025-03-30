<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    protected $rules = [
        'name' => 'required|unique:roles,name',
    ];

    protected $messages = [
        'name.unique' => "You can't create an admin role.",
    ];

    /**
     * Constructor to apply middleware.
     */
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of roles.
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all(); // Fetch all permissions
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'name' => ['required', 'unique:roles,name', function ($attribute, $value, $fail) {
                if ($value === 'admin') {
                    $fail("You can't create an admin role.");
                }
            }],
            'permissions' => 'required|array', // Ensure permissions are passed as an array
        ]);
    
        // Create the role
        $role = Role::create(['name' => $request->input('name')]);
    
        // Sync the permissions
        Log::debug('Syncing Permissions:', $request->input('permissions'));
        $role->syncPermissions($request->input('permissions')); // Ensure permissions are passed as an array
    
        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully');
    }
    

    /**
     * Display the specified role along with its permissions.
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all(); // Fetch all permissions
        $rolePermissions = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array', // Match the input name
        ]);
    
        // Find the role and update it
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
    
        // Sync permissions to the role
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    
    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        // Delete the role
        DB::table("roles")->where('id', $id)->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
