<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomFacilities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomFacilityController extends Controller
{
    public function index()
    {

        $title = 'Room Facility';

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
        $data = RoomFacilities::where('branch', $branch)->get();




        // $data = RoomFacilities::all();
        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];


        return view('facilities.index', compact('data', 'title', 'breadcrumbs'));
    }

    public function store(Request $request)
    {
        // Get the logged-in user's branch
        $user = Auth::user();
        // $branch = $user->branch;
        $branch = session('branch_id');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'list' => 'required',

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

            $existingFacility = RoomFacilities::where('name', $request->name)->first();

            if ($existingFacility) {
                return json_encode(['success' => false, 'message' => 'This facility already exists']);
            }


            $data = [
                'name' => $request->name,
                'List' => $request->list,
                'created_by' => Auth::user()->id,
                'branch' => $branch,
            ];

            $Roomfacility = RoomFacilities::create($data);

            return json_encode(['success' => true, 'message' => 'Room Facility created', 'url' => route('room-facility.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }



    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'list' => 'required',
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
                'List' => $request->list,
                'updated_by' => Auth::user()->id,
            ];

            $RoomType = RoomFacilities::find($id)->update($data);

            return json_encode(['success' => true, 'message' => 'Room Facility updated', 'url' => route('room-facility.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    public function destroy(string $id)
    {
        try {

            $RoomType = RoomFacilities::find($id);
            $RoomType->update(['deleted_by' => Auth::user()->id]);
            $RoomType->delete();

            return json_encode(['success' => true, 'message' => 'Room Facility deleted', 'url' => route('room-facility.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
