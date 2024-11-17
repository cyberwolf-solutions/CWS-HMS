<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendWelcomeEmail;

class SuperAdminController extends Controller
{

    public function user1()
    {
        $title = 'Users';

        $user = Auth::user();
        $branch = $user->branch;
        // $data = User::where('branch', $branch)->get();


        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = User::all();
        return view('super-admin.user', compact('title', 'breadcrumbs', 'data'));
        // return view('users.index', compact('title', 'breadcrumbs', 'data'));
    }
    public function role()
    {
        $title = 'Roles';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = Role::all();

        return view('super-admin.role', compact('title', 'breadcrumbs', 'data'));
    }


    // public function rcreate()
    // {
    //     $title = 'Roles';

    //     $breadcrumbs = [
    //         ['label' => $title, 'url' => route('roles.index'), 'active' => false],
    //         ['label' => 'Create', 'url' => '', 'active' => true],
    //     ];

    //     $data = Role::all();

    //     $permissions = Permission::all();

    //     $is_edit = false;

    //     return view('super-admin.create-role', compact('title', 'breadcrumbs', 'data', 'is_edit', 'permissions'));
    // }
    public function rcreate()
    {
        $title = 'Roles';

        $breadcrumbs = [
            ['label' => $title, 'url' => route('roles.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $data = Role::all();

        $is_edit = false;

        // Check if the logged-in user has the role of 'super admin' or 'admin'
        $user = auth()->user();
        $userHasAccess = $user->roles->contains(function ($role) {
            return in_array($role->name, ['Super Admin', 'Admin']);
        });

        // Retrieve all permissions
        $permissions = Permission::all();

        // If the user does not have 'super admin' or 'admin' roles, exclude 'user create' and 'role create' permissions
        if (!$userHasAccess) {
            $permissions = $permissions->filter(function ($permission) {
                return !in_array($permission->name, [
                    'manage users',
                    'role create',
                    'create users',
                    'view users',
                    'edit users',
                    'delete users',
                    'change_status users',
                    'change_password users',
                    'delete roles',
                    'manage roles',
                    'create roles',
                    'edit roles'
                ]);
            });
        }

        return view('super-admin.create-role', compact('title', 'breadcrumbs', 'data', 'is_edit', 'permissions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    // public function rstore(Request $request) {
    //     // Validate the incoming data
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:roles,name',
    //         'permissions' => 'required|array',
    //     ]);
    //     if ($validator->fails()) {
    //         $all_errors = null;

    //         foreach ($validator->errors()->messages() as $errors) {
    //             foreach ($errors as $error) {
    //                 $all_errors .= $error . "<br>";
    //             }
    //         }

    //         return response()->json(['success' => false, 'message' => $all_errors]);
    //     }
    //     try {

    //         $role = Role::create(['name' => $request->input('name')]);

    //         if ($request->has('permissions')) {
    //             $role->syncPermissions($request->input('permissions'));
    //         }

    //         return json_encode(['success' => true, 'message' => 'Role created', 'url' => route('roles.index')]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return json_encode(['success' => false, 'message' => 'Something went wrong!']);
    //     }
    // }

    // public function ucreate()
    // {
    //     $title = 'Users';

    //     $breadcrumbs = [
    //         // ['label' => 'First Level', 'url' => '', 'active' => false],
    //         ['label' => $title, 'url' => route('users.index'), 'active' => false],
    //         ['label' => 'Create', 'url' => '', 'active' => true],
    //     ];
    //     $roles = Role::all();
    //     $branch = Branch::all();
    //     $is_edit = false;

    //     return view('super-admin.create-user', compact('title', 'breadcrumbs', 'roles', 'is_edit', 'branch'));
    // }

    public function ucreate()
    {
        $title = 'Users';

        $breadcrumbs = [
            ['label' => $title, 'url' => route('users.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $branch = Branch::all();
        $is_edit = false;

        // Check if the logged-in user has the role of 'super admin' or 'admin'
        $user = auth()->user();
        $userHasAccess = $user->roles->contains(function ($role) {
            return in_array($role->name, ['Super Admin', 'Admin']);
        });

        // Retrieve all roles
        if ($userHasAccess) {
            $roles = Role::all(); // Show all roles including 'super admin'
        } else {
            $roles = Role::where('name', '!=', 'Super Admin')->get(); // Exclude 'super admin' role
            // $roles1 = Role::where('name', '!=', 'Admin')->get(); // Exclude 'super admin' role
        }

        return view('super-admin.create-user', compact('title', 'breadcrumbs', 'roles', 'is_edit', 'branch'));
    }

    public function index()
    {

        $branches = Branch::paginate(10);
        $totalBranches = Branch::count();
        $totalUsers = User::count();

        return view('super-admin.superAdminIndex', compact('branches', 'totalBranches', 'totalUsers'));
    }
    // public function login1()
    // {
    //     return view('super-admin.sa-auth.login');
    // }
    // public function login(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $credentials = $request->only('email', 'password');

    //     if (Auth::guard('superadmin')->attempt($credentials)) {
    //         return redirect()->intended(route('super-index'));
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }
    public function branch()
    {
        // Fetch all branches with pagination (e.g., 10 per page)
        $branches = Branch::paginate(10);

        // Pass the data to the view
        return view('super-admin.branch', compact('branches'));
    }
    public function user()
    {
        $title = 'Users';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = User::all();
        return view('users.index', compact('title', 'breadcrumbs', 'data'));
    }

    // public function impersonateBranch($branchId)
    // {
    //     // Check if the logged-in user is an admin
    //     // if (Auth::user()->isAdmin()) {
    //     // Retrieve the user associated with the specified branch
    //     $branchUser = User::where('branch', $branchId)->first(); // Assuming users are linked to branches with 'branch_id'

    //     if ($branchUser) {
    //         // Store the current admin user ID for later "stop impersonating"
    //         session()->put('admin_impersonating', Auth::id());

    //         // Log in as the user associated with the branch
    //         Auth::login($branchUser);

    //         // Redirect to the original project or dashboard
    //         return redirect()->route('home')->with('success', 'You are now impersonating the user from branch ' . $branchId);
    //     } else {
    //         return redirect()->back()->with('error', 'No user found for the specified branch.');
    //     }
    //     // } else {
    //     //     return redirect()->back()->with('error', 'Unauthorized action.');
    //     // }
    // }
    //     public function impersonateBranch($branchId)
    // {
    //     // Check if the logged-in user is an admin (you can uncomment the check if needed)
    //     // if (Auth::user()->isAdmin()) {

    //     // Verify if the branch exists
    //     $branchExists = Branch::find($branchId);

    //     if ($branchExists) {
    //         // Store the selected branch ID in the session
    //         session()->put('impersonated_branch_id', $branchId);

    //         // Redirect to the project or dashboard with a success message
    //         return redirect()->route('home')->with('success', 'You are now accessing the branch ' . $branchId);
    //     } else {
    //         return redirect()->back()->with('error', 'The specified branch does not exist.');
    //     }
    //     // } else {
    //     //     return redirect()->back()->with('error', 'Unauthorized action.');
    //     // }
    // }

    public function impersonateBranch($branchId)
    {
        // Check if the logged-in user is an admin (optional check)
        // if (Auth::user()->isAdmin()) {

        // Verify if the branch exists
        $branchExists = Branch::find($branchId);

        if ($branchExists) {
            // Store the selected branch ID in the session for "branch_id"
            session()->put('branch_id', $branchId);

            // Redirect to the project or dashboard with a success message
            return redirect()->route('home')->with('success', 'You are now accessing the branch ' . $branchId);
        } else {
            return redirect()->back()->with('error', 'The specified branch does not exist.');
        }
        // } else {
        //     return redirect()->back()->with('error', 'Unauthorized action.');
        // }
    }

    public function returnToAdminPanel()
    {
        // Assuming the admin has a default branch ID, for example, stored in the User model
        $adminUser = Auth::user();

        $branches = Branch::paginate(10);
        $totalBranches = Branch::count();
        $totalUsers = User::count();


        // Check if the admin has a default branch
        if ($adminUser->branch) {
            // Store the admin's default branch ID in the session
            session()->put('branch_id', $adminUser->branch);
        }

        return view('super-admin.superAdminIndex', compact('branches', 'totalBranches', 'totalUsers'));

        // Redirect back to the admin panel
        // return redirect()->route('admin.panel')->with('success', 'You are back in the admin panel.');
    }

    public function stopImpersonating()
    {
        // Check if the admin is currently impersonating a branch user
        if (session()->has('admin_impersonating')) {
            // Get the original admin ID from the session
            $adminId = session()->pull('admin_impersonating');

            // Log in as the original admin
            Auth::loginUsingId($adminId);

            // Redirect back to the admin panel
            return redirect()->route('admin.dashboard')->with('success', 'You have returned to the admin panel.');
        }

        return redirect()->route('admin.dashboard')->with('error', 'You are not impersonating any user.');
    }

    public function userstore(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required',
            'branch' => 'required',
        ]);
        if ($validator->fails()) {
            $all_errors = null;

            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $all_errors .= $error . "<br>";
                }
            }

            return response()->json(['success' => false, 'message' => $all_errors]);
        }
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'branch' => $request->branch,
                'password' => Hash::make($request->password),
                'created_by' => Auth::user()->id
            ];

            $user = User::create($data);

            $role = Role::find($request->role);

            $user->assignRole($role);

            $email = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];

            SendWelcomeEmail::dispatch($email)->delay(now()->addSeconds(60));
            // return redirect()->route('super-user1')->with('success', 'You have returned to the admin panel.');

            return json_encode(['success' => true, 'message' => 'User created', 'url' => route('super-user1')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    // public function rolestore(Request $request)
    // {
    //     // Validate the incoming data
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:roles,name',
    //         'permissions' => 'required|array',
    //     ]);
    //     if ($validator->fails()) {
    //         $all_errors = null;

    //         foreach ($validator->errors()->messages() as $errors) {
    //             foreach ($errors as $error) {
    //                 $all_errors .= $error . "<br>";
    //             }
    //         }

    //         return response()->json(['success' => false, 'message' => $all_errors]);
    //     }
    //     try {

    //         $role = Role::create(['name' => $request->input('name')]);

    //         if ($request->has('permissions')) {
    //             $role->syncPermissions($request->input('permissions'));
    //         }

    //         // return redirect()->route('super-role')->with('success', 'You have returned to the admin panel.');

    //         return json_encode(['success' => true, 'message' => 'Role created', 'url' => route('super-role')]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return json_encode(['success' => false, 'message' => 'Something went wrong!']);
    //     }
    // }
    public function rolestore(Request $request)
{
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles,name',
        'permissions' => 'required|array',
    ]);

    if ($validator->fails()) {
        $all_errors = null;

        foreach ($validator->errors()->messages() as $errors) {
            foreach ($errors as $error) {
                $all_errors .= $error . "<br>";
            }
        }

        return response()->json(['success' => false, 'message' => $all_errors]);
    }

    // Check if the logged-in user is a Super Admin
    $user = auth()->user();
    $isSuperAdmin = $user->roles->contains('name', 'Super Admin');

    // Allow only Super Admin to create the 'Owner' role
    if (in_array($request->input('name'), ['Owner', 'Admin']) && !$isSuperAdmin) {
        return response()->json(['success' => false, 'message' => 'Only Super Admin can create the Owner or Admin role.']);
    }
    
    try {
        $role = Role::create(['name' => $request->input('name')]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return response()->json(['success' => true, 'message' => 'Role created', 'url' => route('super-role')]);
    } catch (\Throwable $th) {
        return response()->json(['success' => false, 'message' => 'Something went wrong!']);
    }
}

}
