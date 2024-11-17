<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
  

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request) {
    //     // Validate the incoming data
    //     $validator = Validator::make($request->all(), [
    //         'bname' => 'required',
    //         'bcode' => 'required',
    //         'description' => 'required',
    //         'location' => 'required',
    //         'contact' => 'required|numeric|digits:10',
    //     ]);

    //     //dd($request->bcode);

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
    //         $data = [
    //             'name' => $request->bname,
    //             'code' => $request->bcode,
    //             'description' => $request->description,
    //             'location' => $request->location,
    //             'contact' => $request->contact,
    //         ];

    //         $user = Branch::create($data);

    //         // return json_encode(['success' => true, 'message' => 'User created', 'url' => route('super-index')]);
    //         return redirect()->route('super-branch')->with('success', 'Branch created');

    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return redirect()->route('super-branch')->with('success', $th);
    //         // return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
    //     }
    // }

  

public function store(Request $request) {
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        'bname' => 'required|unique:branches,name', // Check if branch name already exists
        'bcode' => 'required',
        'description' => 'required',
        'location' => 'required',
        'contact' => 'required|numeric|digits:10',
    ]);

    if ($validator->fails()) {
        // Collect all error messages and return them as a JSON response
        $all_errors = implode('<br>', $validator->errors()->all());
        
        return response()->json(['success' => false, 'message' => $all_errors]);
    }

    try {
        $data = [
            'name' => $request->bname,
            'code' => $request->bcode,
            'description' => $request->description,
            'location' => $request->location,
            'contact' => $request->contact,
        ];

        Branch::create($data);

        // return response()->json(['success' => true, 'message' => 'Branch created successfully']);
        return response()->json(['success' => true, 'redirect_url' => route('super-branch')]);

    } catch (\Throwable $th) {
        // Handle any other exceptions and return an error message as JSON
        return response()->json(['success' => false, 'message' => 'Something went wrong! ' . $th->getMessage()]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}