<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;

class UnitController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $title = 'Units';

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
        $data = Unit::where('branch', $branch)->get();



        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        // $data = Unit::all();
        return view('units.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $title = 'Units';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('units.index'), 'active' => false],
            ['label' => 'Create', 'url' => '', 'active' => true],
        ];

        $is_edit = false;

        return view('units.create-edit', compact('title', 'breadcrumbs', 'is_edit'));
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
            'name' => 'required|string|max:255|unique:units,name'
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
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'branch' => $branch,
            ];

            $unit = Unit::create($data);

            return json_encode(['success' => true, 'message' => 'Unit created', 'url' => route('units.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $data = Unit::find($id);

        $settings = Settings::latest()->first();

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $data->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Description :</td>';
        $html .= '<td>' . $data->description . '</td>';
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
        $title = 'Units';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => route('units.index'), 'active' => false],
            ['label' => 'Edit', 'url' => '', 'active' => true],
        ];

        $is_edit = true;

        $data = Unit::find($id);

        return view('units.create-edit', compact('title', 'breadcrumbs', 'is_edit', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:15|unique:units,name,' . $id
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
                'description' => $request->description,
                'updated_by' => Auth::user()->id,
            ];

            $unit = Unit::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Unit updated', 'url' => route('units.index')]);
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

            $unit = Unit::find($id);
            $unit->update(['deleted_by' => Auth::user()->id]);
            $unit->delete();

            return json_encode(['success' => true, 'message' => 'Unit deleted', 'url' => route('units.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
