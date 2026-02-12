<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;

class CounselorController extends Controller
{
    // GET: /api/counselors
    public function index(Request $request)
    {
        $counselors = Counselor::when($request->search, function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('counseling_country', 'like', '%' . $request->search . '%');
        })->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $counselors
        ]);
    }

    // POST: /api/counselors
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:counselors,email',
            'counseling_country' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|boolean'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/counselor'), $imageName);
        }

        $counselor = new Counselor();
        $counselor->name = $data['name'];
        $counselor->email = $data['email'];
        $counselor->counseling_country = $data['counseling_country'];
        $counselor->image = $imageName;
        $counselor->status = $data['status'];
        $counselor->save();

        return response()->json([
            'success' => true,
            'message' => 'Counselor created successfully',
            'data' => $counselor
        ], 201);
    }

    // GET: /api/counselors/{id}
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'data' => Counselor::findOrFail($id)
        ]);
    }

    // UPDATE: /api/counselors/{id}
    public function update(Request $request, $id)
    {
        $counselor = Counselor::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:counselors,email,' . $id,
            'counseling_country' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|boolean'
        ]);

        if ($request->hasFile('image')) {

            // Delete old image
            if ($counselor->image && file_exists(public_path('images/counselor/' . $counselor->image))) {
                unlink(public_path('images/counselor/' . $counselor->image));
            }

            // Upload new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/counselor'), $imageName);

            $counselor->image = $imageName;
        }

        $counselor->name = $data['name'];
        $counselor->email = $data['email'];
        $counselor->counseling_country = $data['counseling_country'];
        $counselor->status = $data['status'];
        $counselor->save();

        return response()->json([
            'success' => true,
            'message' => 'Counselor updated successfully',
            'data' => $counselor
        ]);
    }

    // DELETE: /api/counselors/{id}
    public function destroy($id)
    {
        $counselor = Counselor::findOrFail($id);

        if ($counselor->image && file_exists(public_path('images/counselor/' . $counselor->image))) {
            unlink(public_path('images/counselor/' . $counselor->image));
        }

        $counselor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Counselor deleted successfully'
        ]);
    }

    // PATCH: /api/counselors/{id}/status
    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $counselor = Counselor::findOrFail($id);
        $counselor->status = $request->status;
        $counselor->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'data' => $counselor
        ]);
    }
}
