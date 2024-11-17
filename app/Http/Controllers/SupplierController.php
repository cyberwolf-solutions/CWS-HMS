<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Supplier;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $title = 'Suppliers';

        $user = Auth::user();
        // $branch = $user->branch;  
          // Check if there's a branch ID already stored in the session
          $branch = session('branch_id');

          if ($branch) {
              // If a branch ID exists in the session, update the session branch ID to ensure it’s set after login
              session()->put('branch_id', $branch);
          } else {
              // If no branch ID in the session, use the user's default branch ID, if available
              if ($user->branch) {
                  session()->put('branch_id', $user->branch);
              }
          }
        $data = Supplier::where('branch', $branch)->get();

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        // $data = Supplier::all();
        return view('suppliers.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $title = 'Suppliers';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('users.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;

        return view('suppliers.create-edit', compact('title', 'breadcrumbs', 'is_edit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
          // Get the logged-in user's branch
    $user = Auth::user();
    // $branch = $user->branch;  
    $branch = session('branch_id');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact_primary' => 'required|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'contact_secondary' => 'nullable|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
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
                'contact_primary' => $request->contact_primary,
                'contact_secondary' => $request->contact_secondary,
                'email' => $request->email,
                'address' => $request->address,
                'created_by' => Auth::user()->id,
                'branch' => $branch,
            ];

            $supplier = Supplier::create($data);

            return json_encode(['success' => true, 'message' => 'Supplier created', 'url' => route('suppliers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $data = Supplier::find($id);

        $settings = Settings::latest()->first();

        // Check if the data is not found
        if (!$data) {
            return response()->json(['message' => 'Transfer not found.']);
        }
        // dd($data->name);
        $html = '<table class="table">';
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact Primary :</td>';
        $html .= '<td>' . $data->contact_primary . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact Secondary :</td>';
        $html .= '<td>' . $data->contact_secondary ?? '-' . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Email :</td>';
        $html .= '<td>' . $data->email ?? '-' . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Address :</td>';
        $html .= '<td>' . $data->address . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Balance :</td>';
        $html .= '<td>' . $settings->currency . ' ' . number_format($data->balance, 2) . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created By :</td>';
        $html .= '<td>' . $data->createdBy->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created Date :</td>';
        $html .= '<td>' . date_format(new DateTime('@' . strtotime($data->created_at)), $settings->date_format) . '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return response()->json([$html]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $title = 'Suppliers';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('users.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;

        $data = Supplier::find($id);

        return view('suppliers.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:suppliers,name,' . $id,
            'contact_primary' => 'required|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'contact_secondary' => 'nullable|string|max:15', // Assuming a maximum length of 15 characters for a phone number
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
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
                'contact_primary' => $request->contact_primary,
                'contact_secondary' => $request->contact_secondary,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
            ];


            $Supplier = Supplier::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Supplier updated', 'url' => route('suppliers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        try {

            $Supplier = Supplier::find($id);
            $Supplier->update(['deleted_by' => Auth::user()->id]);
            $Supplier->delete();

            return json_encode(['success' => true, 'message' => 'Supplier deleted', 'url' => route('suppliers.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function suppliersReport(){
        $title = 'Suppliers Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Supplier::all();

        return view ('reports.spplierReports' , compact('data'));
    }
}
